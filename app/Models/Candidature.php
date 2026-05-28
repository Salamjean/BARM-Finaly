<?php

namespace App\Models;

use App\Models\Candidatentretien;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidature extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'absent_date' => 'date',
        'absent' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function completedBy()
    {
        return $this->belongsTo(User::class, 'completed_by', 'id');
    }

    public function submittedBy()
    {
        return $this->belongsTo(User::class, 'submitted_by', 'id');
    }

    public function partnerTechnical()
    {
        return $this->belongsTo(Partenaire::class, 'partner_technical_id', 'id');
    }

    public function candidaturePartners()
    {
        return $this->hasMany(CandidaturePartnerTechnicial::class, 'candidature_id', 'id');
    }

    public function candidaturePartner()
    {
        return $this->hasOne(CandidaturePartnerTechnicial::class, 'candidature_id', 'id')->where('status', 'accepted');
    }


    public function partnerFinancial()
    {
        return $this->belongsTo(Partenaire::class, 'partner_financial_id', 'id');
    }

    public function childs()
    {
        return $this->hasMany(ChildCandidate::class);
    }

    public function jobs()
    {
        return $this->hasMany(JobCandidate::class);
    }

    public function diplomes()
    {
        return $this->hasMany(DiplomaCandidate::class);
    }

    public function candidaturePartenaires(): HasMany
    {
        return $this->hasMany(CandidaturePartenaire::class, 'candidature_id', 'id');
    }

    public function partenaires(): BelongsToMany
    {
        return $this->belongsToMany(Partenaire::class, 'candidaturepartenaires', 'candidature_id', 'partenaire_id')
            ->withPivot('status', 'partner_financial_id', 'other_partner_financial', 'reason_rejet', 'id')
            ->withTimestamps();
    }

    public function candidatureSessioncollective(): HasOne
    {
        return $this->hasOne(CandidatureSessioncollective::class, 'candidature_id', 'id');
    }

    public function sessioncollectives(): BelongsToMany
    {
        return $this->belongsToMany(Sessioncollective::class, 'candidature_sessioncollective','sessioncollective_id','candidature_id')->withPivot('methode_prise_contact',
        'commentaire','presence','presence_status');
    }

    public function sessionCollective(): BelongsTo
    {
        return $this->belongsTo(Sessioncollective::class, 'session_id', 'id');
    }

    public function rdvpartenaires(): HasMany
    {
        return $this->hasMany(Rdvpartner::class);
    }

    public function choiceFinal() : HasOne
    {
        return $this->hasOne(ChoiceFinalAdherent::class);
    }

    public function cohort()
    {
        return $this->belongsTo(Cohort::class);
    }

    public function participations() : HasMany
    {
        return $this->hasMany(TrainingParticipation::class);
    }

    public function dataCollect(): HasOne
    {
        return $this->hasOne(DataCollect::class);
    }

    public function pas(): HasMany
    {
        return $this->hasMany(PA::class)->orderByDESC('created_at');
    }

    public function paPending(): HasOne
    {
        return $this->hasOne(PA::class)->where('status', 'in_progress');
    }


    public function paAccepted(): HasOne
    {
        return $this->hasOne(PA::class)->where('status', 'accepted');
    }

    public function selfEmploymentMonitoredPayment(): HasOne
    {
        return $this->hasOne(SelfEmploymentMonitoredPayment::class);
    }

    public function reportsPostMonitored() : HasMany
    {
        return $this->hasMany(ReportPostMonitored::class);
    }

    public function creditCommittee()
    {
        return $this->hasOne(CreditCommittee::class, 'candidature_id', 'id');
    }


    public function profilages(): BelongsToMany
    {
        return $this->belongsToMany(Profilage::class,'candidatprofilages','profilage_id','candidature_id')->withPivot('profile');
    }

    public function commissions(): BelongsToMany
    {
        return
        $this->belongsToMany(Commission::class,'commissioncandidats','commission_id','candidature_id')->withPivot('partner_financial_id','other_partner_financial','decision','comment');
    }

    public function commissionCandidats(): HasMany
    {
        return $this->hasMany(Commissioncandidat::class, 'candidature_id', 'id');
    }

    public function commissionCandidat(): HasOne
    {
        return $this->hasOne(Commissioncandidat::class, 'candidature_id', 'id')->where('decision', 'accepted');
    }

    public function formations(): BelongsToMany
    {
        return $this->belongsToMany(Formation::class,'candidatformations','formation_id','candidature_id')->withPivot('presence','commentaire','attestation');
    }

    public function candidatformations() : HasMany
    {
        return $this->hasMany(Candidatformation::class);
    }

    public function candidatentreprises() : HasMany
    {
        return $this->hasMany(Candidatentreprise::class);
    }

    public function poste() : BelongsTo
    {
        return $this->belongsTo(Candidatentreprise::class,'poste_id','id');
    }

    public function concours() : HasMany
    {
        return $this->hasMany(Inscriptionconcour::class,);
    }

    public function entretiens(): BelongsTo
    {
        return $this->belongsTo(Entretien::class);
    }

    public function soumissiondossiers(): HasMany
    {
        return $this->hasMany(Soumissiondossier::class);
    }

    public function candidatadmi(): HasOne
    {
        return $this->hasOne(Candidatsadmi::class);
    }

    public function choixconcour(): HasOne
    {
        return $this->hasOne(Choixconcour::class);
    }

    public function candidatentretiens() : HasMany
    {
        return $this->hasMany(Candidatentretien::class);
    }

    public function bilancompetences() : HasMany
    {
        return $this->hasMany(Bilancompetence::class);
    }

    public function cvlms() : HasMany
    {
        return $this->hasMany(Cvlm::class);
    }

    public function prepaentretiens() : HasMany
    {
        return $this->hasMany(Prepaentretien::class);
    }

}
