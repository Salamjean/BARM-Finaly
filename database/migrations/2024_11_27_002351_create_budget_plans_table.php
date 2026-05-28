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
        Schema::create('budget_plans', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['memdef', 'c2d'])->default('c2d');
            $table->string('name');
            $table->string('year');
            $table->double('conversion_xof'); 
            $table->text('description')->nullable(); 
            $table->enum('status', ['pending', 'approuved'])->default('pending'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_plans');
    }
};
