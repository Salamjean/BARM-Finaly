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
        Schema::create('disbursements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('self_employment_monitored_payment_id');
            $table->integer('amount_disbursement');
            $table->integer('created_by');

            $table->string('document_file')->nullable();
            $table->timestamp('date_hour_submission_document')->nullable();

            $table->boolean('authorization')->default(false);
            $table->timestamp('authorization_date')->nullable();
            $table->string('authorization_file')->nullable();
            $table->integer('authorization_created_by')->nullable();
            $table->text('reason')->nullable();

            $table->timestamp('report_date')->nullable();
            $table->string('report_file')->nullable();
            $table->integer('report_created_by')->nullable();

            $table->timestamp('report_signed_date')->nullable();
            $table->string('report_signed_file')->nullable();
            $table->integer('report_signed_created_by')->nullable();

            $table->date('loan_set_up_date')->nullable();

            $table->timestamp('date_disbursement')->nullable();
            $table->integer('disbursement_submission_by')->nullable();
            $table->string('file_disbursement')->nullable();

            $table->enum('status', ['init', 'pending', 'in_progress', 'finished', 'cancel'])->default('init');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disbursements');
    }
};
