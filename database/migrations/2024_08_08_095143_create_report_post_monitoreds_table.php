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
        Schema::create('report_post_monitoreds', function (Blueprint $table) {
            $table->id();
            $table->enum('user_type', ['personal', 'partner'])->default('personal');
            $table->integer('created_by');
            $table->integer('candidature_id');
            $table->string('report_title');
            $table->date('date_visit');
            $table->text('report_description')->nullable();
            $table->string('file_report')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_post_monitoreds');
    }
};
