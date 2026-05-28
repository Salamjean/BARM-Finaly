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
        Schema::create('candidature_controls', function (Blueprint $table) {
            $table->id();
            $table->enum('table', ['candidatures', 'users', 'retireds', 'disbursements', 'self_employment_monitored_payments', 'p_a_s', 'data_collects', 'cohorts', 'choice_final_adherents']);
            $table->enum('type',  ['created', 'updated', 'deleted']);
            $table->enum('user_type', ['personal', 'partner'])->default('personal');
            $table->integer('user_id');
            $table->integer('adherent_id');
            $table->string('reason')->nullable();
            $table->json('data')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidature_controls');
    }
};
