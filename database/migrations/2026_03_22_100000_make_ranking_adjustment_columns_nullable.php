<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ranking_adjustments', function (Blueprint $table) {
            $table->enum('placement', ['winner', 'finalist', 'semi_finalist', 'quarter_finalist', 'participant'])
                  ->nullable()
                  ->change();
            $table->string('reason')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('ranking_adjustments', function (Blueprint $table) {
            $table->enum('placement', ['winner', 'finalist', 'semi_finalist', 'quarter_finalist', 'participant'])
                  ->nullable(false)
                  ->change();
            $table->string('reason')->nullable(false)->change();
        });
    }
};
