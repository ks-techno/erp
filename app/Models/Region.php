<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'country_id',
        'company_id',
        'project_id',
        'user_id',
    ];
    protected $dates = ['deleted_at'];

    protected function scopeOrderByName($qry,$dir = 'asc'){
        return $qry->orderby('name',$dir);
    }
    public function country(){
        return $this->belongsTo(Country::class)->withDefault([
            'name' => 'No project'
        ]);;
    }
    public function cities(){
        return $this->hasMany(City::class)->OrderByName();
    }
}
