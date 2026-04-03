<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnnouncedLGAResult extends Model
{
    protected $table = 'announced_lga_results';

    protected $fillable = ['lga_id', 'party_abbreviation', 'votes_secured'];

    public function lga(): BelongsTo
    {
        return $this->belongsTo(LGA::class, 'lga_id', 'lga_id');
    }
}