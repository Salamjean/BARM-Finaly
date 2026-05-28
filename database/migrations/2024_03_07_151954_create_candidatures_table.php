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
        Schema::create('candidatures', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('created_by');
            $table->integer('cohort_id')->nullable();
            $table->integer('pan_affaire_id')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('phone_number2')->nullable();
            $table->string('phone_number3')->nullable();
            $table->date('date_inscription')->nullable();
            $table->string('sos_person_fullname')->nullable();
            $table->string('sos_person_phone_number')->nullable();
            $table->string('sos_person_phone_number2')->nullable();
            $table->string('type_piece');
            $table->string('no_card');
            $table->date('birth_date');
            $table->string('cgrae_no')->nullable();
            $table->string('image')->nullable();
            $table->string('gender');
            $table->string('ethnic');
            $table->string('religion');
            $table->string('situation_matrimoniale')->nullable();
            $table->string('partner_fullname')->nullable();
            $table->string('partner_job')->nullable();
            $table->string('partner_phone_number')->nullable();
            $table->string('partner_phone_number2')->nullable();
            $table->string('partner_card')->nullable();
            $table->string('marriage_certificate')->nullable();
            $table->string('residence')->nullable();
            $table->string('address')->nullable();
            $table->string('armee')->nullable();
            $table->string('unite_rattachement')->nullable();
            $table->string('statut_prof')->nullable();
            $table->string('grade')->nullable();
            $table->date('date_entree')->nullable();
            $table->date('date_radiation')->nullable();
            $table->string('duree_service')->nullable();
            $table->enum('orientation',['auto-emploi', 'fonction-publique', 'entreprise-privee'])->nullable();
            $table->string('domaine_1c')->nullable();
            $table->string('specialisation_1c')->nullable();
            $table->string('region_retraite_1c')->nullable();
            $table->string('department_1c')->nullable();
            $table->string('locality_1c')->nullable();
            $table->string('adress_geo_1c')->nullable();
            $table->string('formation_1c')->nullable();
            $table->string('autres_form_1c')->nullable();
            $table->string('domaine_2c')->nullable();
            $table->string('specialisation_2c')->nullable();
            $table->string('region_retraite_2c')->nullable();
            $table->string('department_2c')->nullable();
            $table->string('locality_2c')->nullable();
            $table->string('adress_geo_2c')->nullable();
            $table->string('formation_2c')->nullable();
            $table->string('autres_form_2c')->nullable();
            $table->string('condition_admin')->nullable();
            $table->string('condition_financiere')->nullable();
            $table->string('condition_disciplinaire')->nullable();
            $table->string('accident_maladie')->nullable();
            $table->text('maladie_supp')->nullable();
            $table->string('demarche_nature')->nullable();
            $table->string('demarche_admin')->nullable();
            $table->string('etat_avancement')->nullable();
            $table->string('indication')->nullable();
            $table->string('demande_manuscrite')->nullable();
            $table->string('cv')->nullable();
            $table->string('id_card')->nullable();
            $table->string('carte_pro')->nullable();
            $table->string('fiche_inscription')->nullable();
            $table->string('fiche_engagement')->nullable();
            $table->string('fiche_individuelle')->nullable();
            $table->string('arrete_radiation')->nullable();
            $table->string('certificat')->nullable();

            $table->text('completed_by')->nullable();
            $table->text('completed_at')->nullable();


            $table->enum('session_collective', ['0', '1'])->default('0');

            $table->enum('status', ['accepted', 'refused', 'pending'])->default('pending');
            $table->enum('step', ['1', '2','3', '4', '5','6', '7', 'pending', 'completed'])->default('1');

            $table->integer('session_id')->nullable();
            $table->integer('partner_technical_id')->nullable();
            $table->integer('partner_financial_id')->nullable();
            $table->string('other_partner_financial',100)->nullable();

            $table->boolean('training')->default(false);

            $table->text('focal_point_area')->nullable();
            $table->text('commission_step')->nullable();
            $table->boolean('pa')->default(false);
            $table->boolean('pa_decision')->default(false);

            $table->boolean('data_collect')->default(false);

            $table->enum('death', ['0', '1'])->default(0);
            $table->date('death_date')->nullable();
            $table->string('death_no_act')->nullable();

            $table->text('death_city')->nullable();
            $table->text('death_justification')->nullable();

            //only auto-emploi
            $table->boolean('favorable_opinion')->default(false);
            $table->string('docs_favorable_opinion')->nullable();

            $table->string('imputation')->nullable();
            $table->text('pensionnaire_cgrae')->nullable();

            $table->boolean('credit_committee')->default(false);
            // $table->boolean('project_financing')->default(false);
            $table->boolean('ten_percent')->default(false);

            $table->boolean('disbursement')->default(false);

            $table->integer('focal_point_post_monitored')->nullable();
            $table->boolean('post_monitored')->default(false);

            $table->enum('resignation', ['0', '1'])->default(0);
            $table->date('resignation_date')->nullable();
            $table->text('resignation_justification')->nullable();

            //only entreprise privée
            $table->enum('en_poste', ['0', '1'])->default(0);
            $table->integer('poste_id')->nullable();

            //only fonction publique
            $table->enum('admissionconcours', ['0', '1'])->default(0);
            $table->integer('concour_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatures');
    }
};
