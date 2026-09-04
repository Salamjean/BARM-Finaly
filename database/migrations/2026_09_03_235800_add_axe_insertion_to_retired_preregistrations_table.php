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
        Schema::table('retired_preregistrations', function (Blueprint $table) {
            $table->boolean('axe_auto_emploi')->default(false)->after('residence');
            $table->text('auto_emploi_projet1')->nullable()->after('axe_auto_emploi');
            $table->text('auto_emploi_projet2')->nullable()->after('auto_emploi_projet1');

            $table->boolean('axe_entreprise_privee')->default(false)->after('auto_emploi_projet2');
            $table->text('entreprise_privee_emploi')->nullable()->after('axe_entreprise_privee');
            $table->text('entreprise_privee_formation1')->nullable()->after('entreprise_privee_emploi');
            $table->text('entreprise_privee_formation2')->nullable()->after('entreprise_privee_formation1');

            $table->boolean('axe_fonction_publique')->default(false)->after('entreprise_privee_formation2');
            $table->text('fonction_publique_diplome')->nullable()->after('axe_fonction_publique');
            $table->text('fonction_publique_emploi1')->nullable()->after('fonction_publique_diplome');
            $table->text('fonction_publique_emploi2')->nullable()->after('fonction_publique_emploi1');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('retired_preregistrations', function (Blueprint $table) {
            $table->dropColumn([
                'axe_auto_emploi',
                'auto_emploi_projet1',
                'auto_emploi_projet2',
                'axe_entreprise_privee',
                'entreprise_privee_emploi',
                'entreprise_privee_formation1',
                'entreprise_privee_formation2',
                'axe_fonction_publique',
                'fonction_publique_diplome',
                'fonction_publique_emploi1',
                'fonction_publique_emploi2',
            ]);
        });
    }
};
