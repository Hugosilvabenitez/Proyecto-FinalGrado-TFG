<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('save_states', function (Blueprint $table) {
            $table->longText('save_data')->nullable()->after('save_path');
        });
    }

    public function down(): void
    {
        Schema::table('save_states', function (Blueprint $table) {
            $table->dropColumn('save_data');
        });
    }
};
