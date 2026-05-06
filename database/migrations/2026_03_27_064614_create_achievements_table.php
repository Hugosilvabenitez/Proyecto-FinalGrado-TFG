<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
* Class CreateAchievementsTable (Migration)
* 
* @author Hugo Silva Benitez <hsilben979@g.educaand.es>
* @date 2026-05-05
* 
* This migration creates the achievements table with unlock requirements and rewards.
*/
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('achievements', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('description');
        $table->string('icon')->default('🏆');
        $table->enum('type', ['time_played', 'games_completed', 'in_game']);
        $table->integer('threshold'); // minutos, partidas, o puntuación
        $table->integer('points')->default(10);
        $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
