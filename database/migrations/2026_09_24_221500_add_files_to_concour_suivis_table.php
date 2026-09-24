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
        Schema::table('concour_suivis', function (Blueprint $table) {
            if (!Schema::hasColumn('concour_suivis', 'dossier_r1_file')) {
                $table->string('dossier_r1_file')->nullable()->after('dossier_r1_obs');
            }
            if (!Schema::hasColumn('concour_suivis', 'dossier_r2_file')) {
                $table->string('dossier_r2_file')->nullable()->after('dossier_r2_obs');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('concour_suivis', function (Blueprint $table) {
            if (Schema::hasColumn('concour_suivis', 'dossier_r1_file')) {
                $table->dropColumn('dossier_r1_file');
            }
            if (Schema::hasColumn('concour_suivis', 'dossier_r2_file')) {
                $table->dropColumn('dossier_r2_file');
            }
        });
    }
};
