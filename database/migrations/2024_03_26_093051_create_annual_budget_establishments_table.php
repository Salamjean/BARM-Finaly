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

        Schema::create('annual_budget_establishments', function (Blueprint $table) {
            $table->id();
            $table->integer('chief_id');
            $table->integer('annual_budget_id');
            $table->integer('cell_id');
            $table->longText('elements');
            $table->longText('elements_retained')->nullable();
            $table->date('date');
            $table->text('description')->nullable();
            $table->text('summary')->nullable();
            $table->enum('status', ["new", "verification", "finished"])->default('new');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annual_budget_establishments');
    }
};
