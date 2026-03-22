<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ranking_adjustments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('tournament_id')->nullable()->constrained()->onDelete('set null');
        $table->integer('points_before')->default(0); 
        $table->integer('amount');
        $table->integer('points_after')->default(0);
        $table->enum('placement', ['winner', 'finalist', 'semi_finalist', 'quarter_finalist', 'participant']);
        $table->string('reason');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ranking_adjustments');
    }
};
