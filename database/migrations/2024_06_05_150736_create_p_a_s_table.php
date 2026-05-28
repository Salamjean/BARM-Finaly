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
        Schema::create('p_a_s', function (Blueprint $table) {
            $table->id();
            $table->integer('candidature_id');
            $table->integer('partner_id');
            $table->integer('partner_financial_id')->nullable();
            $table->string('other_partner_financial')->nullable();
            $table->integer('commission_id')->nullable();
            $table->string('url');
            $table->string('title')->nullable();
            $table->integer('amount')->default(0);
            $table->integer('amount_awarded')->default(0);
            $table->string('location')->nullable();
            $table->integer('credit')->nullable();
            $table->text('observation')->nullable();
            $table->enum('status', ['in_progress','accepted','refused','missing','resignation','deferred'])->defaut('in_progress');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('p_a_s');
    }
};
