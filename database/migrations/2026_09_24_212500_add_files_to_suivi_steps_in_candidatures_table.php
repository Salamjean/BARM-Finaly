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
            $table->text('suivi_1_file')->nullable()->after('suivi_1_commentaire');
            $table->text('suivi_2_file')->nullable()->after('suivi_2_commentaire');
            $table->text('suivi_3_file')->nullable()->after('suivi_3_commentaire');
            $table->text('post_insertion_file')->nullable()->after('post_insertion_motif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidatures', function (Blueprint $table) {
            $table->dropColumn([
                'suivi_1_file',
                'suivi_2_file',
                'suivi_3_file',
                'post_insertion_file',
            ]);
        });
    }
};
