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
        Schema::create('budget_plan_sub_components', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('budget_plan_component_id');
            $table->integer('amount')->nullable();
            $table->string('code')->nullable();
            $table->string('title'); 
            $table->timestamps();

            $table->foreign('budget_plan_component_id')->references('id')->on('budget_plan_components')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_plan_sub_components');
    }
};
