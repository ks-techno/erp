<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyableType extends Model
{
    use HasFactory;
    protected $table = 'buyable_types';

    protected $fillable = [
        'uuid',
        'name',
        'status',
    ];

    protected function scopeOrderByName($qry,$dir = 'asc'){
        return $qry->orderby('name',$dir);
    }
    protected function scopeStatus($qry,$dir = 1){
        return $qry->where('status',$dir);
    }


}
