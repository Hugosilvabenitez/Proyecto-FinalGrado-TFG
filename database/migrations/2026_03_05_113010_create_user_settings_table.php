<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_settings', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->unsigned()
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->json('control_config')->nullable();

            $table->integer('audio_volume')->default(100);

            $table->integer('video_scale')->default(1);

            $table->string('theme',50)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_settings');
    }
};