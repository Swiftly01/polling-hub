<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnnouncedPUResult extends Model
{
    protected $table = 'announced_pu_results';

    public $timestamps = false;

    protected $fillable = [
        'polling_unit_uniqueid',
        'party_abbreviation',
        'party_score',
        'entered_by_user',
        'date_entered',
        'user_ip_address'
    ];

    public function pollingUnit(): BelongsTo
    {
        return $this->belongsTo(
            PollingUnit::class,
            'polling_unit_uniqueid', 
            'uniqueid'              
        );
    }
}


