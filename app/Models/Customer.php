<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'cnic_no',
        'contact_no',
        'email',
        'status',
        'company_id',
        'project_id',
        'user_id',
    ];

    public function addresses(){
        return $this->morphOne(Address::class, 'addressable');
    }

    protected function scopeOrderByName($qry,$dir = 'asc'){
        return $qry->orderby('name',$dir);
    }

}
