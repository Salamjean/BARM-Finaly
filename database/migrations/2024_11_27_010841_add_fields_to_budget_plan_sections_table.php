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
        Schema::table('budget_plan_parts', function (Blueprint $table) {
            $table->integer('cost_total_project')->nullable()->after('title'); 
            $table->integer('commitments')->nullable()->after('cost_total_project');
            $table->integer('percent_commitments')->nullable()->after('commitments'); 
            $table->integer('cost_q1')->nullable()->after('percent_commitments'); 
            $table->integer('cost_q2')->nullable();
            $table->integer('cost_q3')->nullable(); 
            $table->integer('cost_q4')->nullable(); 
            $table->integer('cost_total_year')->nullable(); 
            $table->string('chronogram_q1')->nullable()->after('cost_total_year'); 
            $table->string('chronogram_q2')->nullable(); 
            $table->string('chronogram_q3')->nullable(); 
            $table->string('chronogram_q4')->nullable(); 
            $table->text('comments')->nullable()->after('chronogram_q4'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('budget_plan_parts', function (Blueprint $table) {
            //
        });
    }
};
