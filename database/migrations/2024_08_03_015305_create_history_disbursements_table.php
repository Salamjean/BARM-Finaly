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
        Schema::create('history_disbursements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('self_employment_monitored_payment_id');
            $table->integer('amount_disbursement');
            $table->integer('created_by');
            $table->text('report')->nullable();

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
