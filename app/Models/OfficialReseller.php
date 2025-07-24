<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficialReseller extends Model
{
    protected $guarded = []; // <- ini tambahan penting

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
