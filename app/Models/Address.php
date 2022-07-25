<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'country_id',
        'region_id',
        'city_id',
        'address',
    ];

    public function addressable()
    {
        return $this->morphTo();
    }


}
