<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roms', function (Blueprint $table) {

            $table->id();
            
            $table->string('title',150);

            $table->string('slug',150)->unique();

            $table->text('description')->nullable();

            $table->string('file_path');

            $table->string('cover_image')->nullable();

            $table->unsignedInteger('size_bytes')->nullable();

            $table->string('region',50)->nullable();

            $table->foreignId('emulator_id')
                ->constrained()
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('uploaded_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->boolean('is_public')->default(true);

            $table->timestamps();

            $table->index('title','idx_roms_title');

            $table->index('emulator_id','idx_roms_emulator');

            $table->index('is_public','idx_roms_public');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roms');
    }
};