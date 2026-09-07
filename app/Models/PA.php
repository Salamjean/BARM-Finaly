<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PA extends Model
{
    use HasFactory;

    protected $table = 'p_a_s';

    protected $fillable = [
        'candidature_id',
        'partner_id',
        'partner_financial_id',
        'other_partner_financial',
        'commission_id',
        'title',
        'amount',
        'amount_awarded',
        'url',
        'observation',
        'status',
        'location',
        'credit',
        'sentence_reason',
        'sentence_at',
        'sentence_by',
    ];

    public function candidature() : BelongsTo
    {
        return $this->belongsTo(Candidature::class);
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partenaire::class, 'partner_id', 'id');
    }

    public function partnerFinancial(): BelongsTo
    {
        return $this->belongsTo(Partenaire::class, 'partner_financial_id', 'id');
    }

    public function commission() : BelongsTo
    {
        return $this->belongsTo(Commission::class);
    }

    public function sentenceBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sentence_by', 'id');
    }

    public function getFilePath(): ?string
    {
        if (!$this->url) {
            return null;
        }

        $cleanUrl = ltrim(str_replace(['public/', '\\'], ['', '/'], $this->url), '/');
        $fileName = basename($cleanUrl);

        $possiblePaths = [
            public_path($cleanUrl),
            public_path('data/docs/pa/' . $fileName),
            base_path($cleanUrl),
            base_path('public/' . $cleanUrl),
            base_path('data/docs/pa/' . $fileName),
        ];

        foreach ($possiblePaths as $path) {
            if ($path && file_exists($path) && !is_dir($path)) {
                return $path;
            }
        }

        return null;
    }

    public function fileExists(): bool
    {
        return $this->getFilePath() !== null;
    }
}
