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
        Schema::table('candidaturepartenaires', function (Blueprint $table) {
            $table->integer('partner_financial_id')->nullable();
            $table->string('other_partner_financial')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidaturepartenaires', function (Blueprint $table) {
            //
        });
    }
};
