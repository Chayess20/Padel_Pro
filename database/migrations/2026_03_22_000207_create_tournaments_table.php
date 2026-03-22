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
        Schema::create('tournaments', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->enum('type', ['monthly', 'weekly']);
        $table->string('category')->nullable();
        $table->string('division');
        $table->integer('required_points')->default(0);
        $table->integer('win_points')->default(0);
        $table->integer('final_points')->default(0);
        $table->integer('semi_points')->default(0);
        $table->integer('quarter_points')->default(0);
        $table->decimal('entry_fee', 8, 2)->default(0.00);
        $table->integer('max_players')->default(0);
        $table->enum('status', ['draft', 'open', 'live', 'completed'])->default('draft');
        $table->date('event_date')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};
