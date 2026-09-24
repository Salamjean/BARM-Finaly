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
            $table->boolean('profilage_decision')->default(false)->after('orientation');
            $table->date('date_decision_profilage')->nullable()->after('profilage_decision');
            $table->text('motif_decision_profilage')->nullable()->after('date_decision_profilage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidatures', function (Blueprint $table) {
            $table->dropColumn(['profilage_decision', 'date_decision_profilage', 'motif_decision_profilage']);
        });
    }
};
