<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dealer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'cnic_no',
        'contact_no',
        'email',
        'status',
    ];

    public function addresses(){
        return $this->morphOne(Address::class, 'addressable');
    }

    public function sale_seller(){
        return $this->morphOne(SaleSeller::class, 'sale_sellersable');
    }

    protected function scopeOrderByName($qry,$dir = 'asc'){
        return $qry->orderby('name',$dir);
    }

}
