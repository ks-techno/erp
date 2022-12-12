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
        'mobile_no',
        'email',
        'status',
        'company_id',
        'project_id',
        'user_id',
        'father_name',
        'husband_name',
        'registration_no',
        'membership_no',
        'nominee_no',
        'nominee_name',
        'nominee_father_name',
        'nominee_relation',
        'nominee_contact_no',
        'nominee_cnic_no',
    ];

    public function addresses(){
        return $this->morphOne(Address::class, 'addressable');
    }

    protected function scopeOrderByName($qry,$dir = 'asc'){
        return $qry->orderby('name',$dir);
    }

}
