<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'country_id',
        'region_id',
    ];

    protected function scopeOrderByName($qry,$dir = 'asc'){
        return $qry->orderby('name',$dir);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }
    public function region(){
        return $this->belongsTo(Region::class);
    }
}
