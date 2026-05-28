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
        Schema::create('disbursement_deadlines', function (Blueprint $table) {
            $table->id();
            $table->integer('self_employment_monitored_payment_id');
            $table->string('title');
            $table->date('date_expiry');
            $table->json('reminder_dates')->nullable();
            $table->date('date_refund')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->integer('amount')->default(0);
            $table->enum('status', ['pending', 'paid', 'unpaid'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disbursement_deadlines');
    }
};
