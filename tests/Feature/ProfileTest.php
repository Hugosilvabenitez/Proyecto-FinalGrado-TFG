<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/profile');

        $response->assertOk();
    }

    public function test_profile_page_includes_saved_emulator_preferences(): void
    {
        $user = User::factory()->create();

        UserSettings::create([
            'user_id' => $user->id,
            'audio_volume' => 48,
            'emulator_background' => 'forest',
        ]);

        $this
            ->actingAs($user)
            ->get('/profile')
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Profile/Edit')
                ->where('emulatorPreferences.audio_volume', 48)
                ->where('emulatorPreferences.emulator_background', 'forest')
                ->where('backgroundPresets.forest.label', 'Forest')
            );
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => $user->email,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    public function test_user_can_update_emulator_preferences_from_profile(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        UserSettings::create([
            'user_id' => $otherUser->id,
            'audio_volume' => 12,
            'emulator_background' => 'arcade',
        ]);

        $response = $this
            ->actingAs($user)
            ->patch('/profile/emulator-preferences', [
                'audio_volume' => 73,
                'emulator_background' => 'sunset',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertDatabaseHas('user_settings', [
            'user_id' => $user->id,
            'audio_volume' => 73,
            'emulator_background' => 'sunset',
        ]);

        $this->assertDatabaseHas('user_settings', [
            'user_id' => $otherUser->id,
            'audio_volume' => 12,
            'emulator_background' => 'arcade',
        ]);
    }

    public function test_user_can_delete_their_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete('/profile', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->delete('/profile', [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrors('password')
            ->assertRedirect('/profile');

        $this->assertNotNull($user->fresh());
    }
}
