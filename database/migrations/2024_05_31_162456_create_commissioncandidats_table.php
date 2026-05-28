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
        Schema::create('commissioncandidats', function (Blueprint $table) {
            $table->id();
            $table->integer('commission_id')->nullable();
            $table->integer('candidature_id')->nullable();
            $table->integer('partner_financial_id')->nullable();
            $table->string('other_partner_financial')->nullable();
            $table->enum('decision', ['accepted','refused','deferred','missing','resignation'])->nullable();
            $table->longText('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commissioncandidats');
    }
};
