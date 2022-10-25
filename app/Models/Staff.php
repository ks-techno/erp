<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use SoftDeletes;
    protected $table = 'staffs';
    protected $fillable = [
        'uuid',
        'name',
        'contact_no',
        'cnic_no',
        'address',
        'department_id',
        'company_id',
        'project_id',
        'user_id',
    ];

    public function addresses(){
        return $this->morphOne(Address::class, 'addressable');
    }

    public function sale_seller(){
        return $this->morphOne(SaleSeller::class, 'sale_sellerable');
    }

    protected function scopeOrderByName($qry,$dir = 'asc'){
        return $qry->orderby('name',$dir);
    }

    public function project(){
        return $this->belongsTo(Project::class);
    }
    public function department(){
        return $this->belongsTo(Department::class);
    }
}
