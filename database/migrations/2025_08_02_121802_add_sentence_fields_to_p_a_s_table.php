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
        Schema::table('p_a_s', function (Blueprint $table) {
            if (!Schema::hasColumn('p_a_s', 'sentence_reason')) {
                $table->text('sentence_reason')->nullable()->after('status');
            }
            if (!Schema::hasColumn('p_a_s', 'sentence_at')) {
                $table->timestamp('sentence_at')->nullable()->after('sentence_reason');
            }
            if (!Schema::hasColumn('p_a_s', 'sentence_by')) {
                $table->integer('sentence_by')->nullable()->after('sentence_at');
            }
            if (!Schema::hasColumn('p_a_s', 'commission_id')) {
                $table->integer('commission_id')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('p_a_s', function (Blueprint $table) {

        });
    }
};
