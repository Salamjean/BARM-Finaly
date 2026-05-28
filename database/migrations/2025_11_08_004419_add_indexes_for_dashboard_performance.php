<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('candidatures', function (Blueprint $table) {
            // Index simple (Laravel gère déjà les doublons)
            $table->index('partner_technical_id', 'idx_candidatures_partner_technical');
        });

        Schema::table('disbursements', function (Blueprint $table) {
            // Index composé
            $table->index(
                ['created_by', 'status'],
                'idx_disbursements_created_by_status'
            );

            // Index pour SUM / agrégations
            $table->index(
                'amount_disbursement',
                'idx_disbursements_amount'
            );
        });
    }

    public function down(): void
    {
        Schema::table('candidatures', function (Blueprint $table) {
            $table->dropIndex('idx_candidatures_partner_technical');
        });

        Schema::table('disbursements', function (Blueprint $table) {
            $table->dropIndex('idx_disbursements_created_by_status');
            $table->dropIndex('idx_disbursements_amount');
        });
    }
};