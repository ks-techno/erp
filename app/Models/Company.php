<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;
    public $timestamps=false;

    protected $fillable = [
        'uuid',
        'name',
        'contact_no',
        'address',
        'country_id',
    ];

    public function addresses(){
        return $this->morphOne(Address::class, 'addressable');
    }

    protected function scopeOrderByName($qry,$dir = 'asc'){
        return $qry->orderby('name',$dir);
    }
}
