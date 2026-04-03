<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PollingUnit extends Model
{
    protected $table = 'polling_unit';
    
    protected $primaryKey = 'uniqueid';

      public $timestamps = false;

    protected $fillable = [
        'polling_unit_id',
        'polling_unit_number',
        'ward_id',
        'lga_id',
        
    ];


    public function ward(): BelongsTo
    {
        return $this->belongsTo(Ward::class, 'ward_id', 'ward_id');
    }

    public function lga(): BelongsTo
    {
        return $this->belongsTo(LGA::class, 'lga_id', 'lga_id');
    }

  public function announcedResults(): HasMany
    {
        return $this->hasMany(
            AnnouncedPUResult::class,
            'polling_unit_uniqueid', 
            'uniqueid'               
        );
    }

    public function getTotalVotes(): int
    {
        return $this->announcedResults->sum('votes_secured');
    }
}
