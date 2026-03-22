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
        Schema::table('users', function (Blueprint $table) {
        $table->string('phone')->nullable();
        $table->enum('gender', ['male', 'female'])->nullable();
        $table->enum('role', ['admin', 'player'])->default('player');
        $table->boolean('national_ranking')->default(false);
        $table->integer('points')->default(0);
        $table->string('division')->default('Beginner');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['gender', 'points', 'division', 'national_ranking', 'role', 'phone']);
        });
    }
};
