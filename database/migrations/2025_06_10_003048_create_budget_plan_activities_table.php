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
        Schema::create('budget_plan_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('budget_plan_section_id');
            $table->string('code')->nullable(); 
            $table->string('title');
            $table->string('company')->nullable();
            $table->text('p_objective_q1')->nullable();
            $table->text('p_objective_q2')->nullable();
            $table->text('p_objective_q3')->nullable();
            $table->text('p_objective_q4')->nullable();
            $table->text('p_objective_annual')->nullable();
            $table->text('execution_zone')->nullable();
            $table->text('ca_investment')->nullable();
            $table->text('ca_service')->nullable();
            $table->text('ca_transfer')->nullable();
            $table->text('ca_personal')->nullable();
            $table->text('ca_total')->nullable();
            $table->text('entity')->nullable();
            $table->text('observation')->nullable();
            $table->timestamps();

            $table->foreign('budget_plan_section_id')->references('id')->on('budget_plan_sections')->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_plan_parts');
    }
};
