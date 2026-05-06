<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
* Class CreatePermissionsTable (Migration)
* 
* @author Hugo Silva Benitez <hsilben979@g.educaand.es>
* @date 2026-05-05
* 
* This migration creates the permissions table used by the role system.
*/
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      Schema::create('permissions', function (Blueprint $table) {
        $table->id();
        $table->string('name');        // "Ver panel admin"
        $table->string('slug');        // "admin.access"
        $table->string('description')->nullable();
        $table->timestamps();
    });

    Schema::create('permission_role', function (Blueprint $table) {
        $table->foreignId('permission_id')->constrained()->cascadeOnDelete();
        $table->foreignId('role_id')->constrained()->cascadeOnDelete();
        $table->primary(['permission_id', 'role_id']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
