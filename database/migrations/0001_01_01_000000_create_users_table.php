<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
* Class CreateUsersTable (Migration)
* 
* @author Hugo Silva Benitez <hsilben979@g.educaand.es>
* @date 2026-05-05
* 
* This migration creates the users table and the basic authentication structure.
*/
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name',50)->unique();

            $table->string('email',100)->unique();

            $table->string('avatar_url',250);

            $table->string('password',255);

            $table->timestamp('email_verified_at')->nullable();

            $table->string('remember_token',100)->nullable();
            
            $table->timestamps();

            $table->index('email','idx_users_email');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
