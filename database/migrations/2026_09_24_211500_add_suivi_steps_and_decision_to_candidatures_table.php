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
            // Suivi 1
            $table->date('suivi_1_date')->nullable()->after('post_monitored');
            $table->text('suivi_1_commentaire')->nullable()->after('suivi_1_date');
            $table->unsignedBigInteger('suivi_1_by')->nullable()->after('suivi_1_commentaire');
            $table->timestamp('suivi_1_at')->nullable()->after('suivi_1_by');

            // Suivi 2
            $table->date('suivi_2_date')->nullable()->after('suivi_1_at');
            $table->text('suivi_2_commentaire')->nullable()->after('suivi_2_date');
            $table->unsignedBigInteger('suivi_2_by')->nullable()->after('suivi_2_commentaire');
            $table->timestamp('suivi_2_at')->nullable()->after('suivi_2_by');

            // Suivi 3
            $table->date('suivi_3_date')->nullable()->after('suivi_2_at');
            $table->text('suivi_3_commentaire')->nullable()->after('suivi_3_date');
            $table->unsignedBigInteger('suivi_3_by')->nullable()->after('suivi_3_commentaire');
            $table->timestamp('suivi_3_at')->nullable()->after('suivi_3_by');

            // Décision Finale Post-Insertion (en_service, revoque, demission, indisponible)
            $table->string('post_insertion_status', 50)->nullable()->after('suivi_3_at');
            $table->date('post_insertion_date')->nullable()->after('post_insertion_status');
            $table->date('post_insertion_date_fin')->nullable()->after('post_insertion_date');
            $table->text('post_insertion_motif')->nullable()->after('post_insertion_date_fin');
            $table->unsignedBigInteger('post_insertion_by')->nullable()->after('post_insertion_motif');
            $table->timestamp('post_insertion_at')->nullable()->after('post_insertion_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidatures', function (Blueprint $table) {
            $table->dropColumn([
                'suivi_1_date',
                'suivi_1_commentaire',
                'suivi_1_by',
                'suivi_1_at',
                'suivi_2_date',
                'suivi_2_commentaire',
                'suivi_2_by',
                'suivi_2_at',
                'suivi_3_date',
                'suivi_3_commentaire',
                'suivi_3_by',
                'suivi_3_at',
                'post_insertion_status',
                'post_insertion_date',
                'post_insertion_date_fin',
                'post_insertion_motif',
                'post_insertion_by',
                'post_insertion_at'
            ]);
        });
    }
};
