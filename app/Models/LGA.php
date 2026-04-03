<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LGA extends Model
{
    protected $table = 'lga';
    protected $primaryKey = 'LGA_ID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['LGA_NAME', 'State'];

    public function wards(): HasMany
    {
        return $this->hasMany(Ward::class, 'lga_id', 'lga_id');
    }

    public function pollingUnits(): HasMany
    {
        return $this->hasMany(PollingUnit::class, 'lga_id', 'lga_id');
    }

    public function announcedResults(): HasMany
    {
        return $this->hasMany(AnnouncedLGAResult::class, 'lga_id', 'lga_id');
    }
}