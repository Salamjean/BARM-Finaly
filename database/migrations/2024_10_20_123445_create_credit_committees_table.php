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
        Schema::create('credit_committees', function (Blueprint $table) {
            $table->id();
            $table->integer('pv_committee_id');
            $table->integer('candidature_id');
            $table->string('agency')->nullable();
            $table->integer('amount_agreed')->nullable();
            $table->integer('deferred_months')->nullable();
            $table->integer('loan_duration')->nullable();

            $table->integer('amount_ten_percent')->nullable();
            $table->timestamp('datetime_ten_percent')->nullable();
            $table->integer('ten_percent_updated_by')->nullable();

            $table->boolean('pension')->default(false);
            $table->boolean('pension_partner_financial')->default(false);
            $table->enum('status', ['pending', 'finished'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_committees');
    }
};
