<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ward extends Model
{
    protected $table = 'ward';
   
   

    public function lga(): BelongsTo
    {
        return $this->belongsTo(LGA::class, 'lga_id', 'lga_id');
    }

    public function pollingUnits(): HasMany
    {
        return $this->hasMany(PollingUnit::class, 'ward_id', 'ward_id');
    }
}