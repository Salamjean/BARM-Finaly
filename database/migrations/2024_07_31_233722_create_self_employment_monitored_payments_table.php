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
        Schema::create('self_employment_monitored_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('candidature_id');
            $table->integer('created_by');

            $table->boolean('account_opening')->default(false);
            $table->timestamp('datetime_plug_removal')->nullable();
            $table->integer('account_opening_updated_by')->nullable();

            $table->string('file')->nullable();
            $table->boolean('authorization_approved')->default(false);
            $table->timestamp('datetime_authorization_approved')->nullable();
            $table->integer('authorization_approved_updated_by')->nullable();

            $table->boolean('open_disbursement')->default(false);
            $table->enum('status_disbursement', ['init', 'pending', 'approved', 'cancelled'])->default('init');
            $table->string('disbursement_form')->nullable();
            $table->text('report_disbursement')->nullable();
            $table->string('signed_disbursement_document')->nullable();
            $table->date('loan_set_up_date')->nullable();
            $table->string('loan_set_up_date_by')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('self_employment_monitored_payments');
    }
};
