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
        Schema::disableForeignKeyConstraints();

        Schema::create('annual_budgets', function (Blueprint $table) {
            $table->id();
            $table->integer('personal_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('date');
            $table->string('year');
            $table->text('summary')->nullable();
            $table->enum('status', ["launch", "negotiation","finished"])->default('launch');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annual_budgets');
    }
};
