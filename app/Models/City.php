<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities'; // atau 'kotas' sesuai nama tabel kamu

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function resellers()
    {
        return $this->hasMany(OfficialReseller::class, 'city_id');
    }
}
