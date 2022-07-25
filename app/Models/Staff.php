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
        'address',
        'project_id',
        'department_id',
    ];

    public function addresses(){
        return $this->morphOne(Address::class, 'addressable');
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
