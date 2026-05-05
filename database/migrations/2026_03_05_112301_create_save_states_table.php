<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
* Class CreateSaveStatesTable (Migration)
* 
* @author Hugo Silva Benitez <hsilben979@g.educaand.es>
* @date 2026-05-05
* 
* This migration creates the save states table used to persist emulator progress.
*/
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('save_states', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();

            $table->foreignId('rom_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            
            $table->integer('slot_number');

            $table->string('save_name',100);

            $table->string('save_path',255);
            
            $table->timestamps();

            $table->unique(['user_id','rom_id','slot_number'],'uq_save_unique_slot');

            $table->index(['user_id','rom_id'],'idx_save_user_rom');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('save_states');
    }
};
