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
        Schema::create('job_offers', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->integer('user_id');
            $table->string('title');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('phone_number');
            $table->string('email');
            $table->text('educations')->nullable();
            $table->text('benefits')->nullable();
            $table->text('skills')->nullable();
            $table->text('languages')->nullable();
            $table->integer('pay')->nullable();
            $table->integer('number')->nullable();
            $table->string('location');
            $table->date('end_date');
            $table->string('genders')->nullable();
            $table->enum('job_type', ['Temps plein', 'Temps partiel', 'Travail de journée'])->nullable();
            $table->enum('status', ['enable', 'disable'])->default('enable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_offers');
    }
};
