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
        Schema::table('candidatures', function (Blueprint $table) {
            if (!Schema::hasColumn('candidatures', 'pa_resubmitted')) {
                $table->boolean('pa_resubmitted')->default(false)->after('pa_decision');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidatures', function (Blueprint $table) {
            if (Schema::hasColumn('candidatures', 'pa_resubmitted')) {
                $table->dropColumn('pa_resubmitted');
            }
        });
    }
};
