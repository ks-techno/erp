<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'default_country',
        'status',
        'company_id',
        'project_id',
        'user_id',
    ];
     protected $dates = ['deleted_at']; // indicate that this model uses soft deletes
     
    protected function scopeOrderByName($qry,$dir = 'asc'){
        return $qry->orderby('name',$dir);
    }
    public function regions(){
        return $this->hasMany(Region::class,'country_id','id')->orderby('name');
    }
    public function projects()
    {
        return $this->hasMany(Project::class,'company_id', 'id',)->orderBy('name');
    }

    public function canDelete()
    {
        return $this->regions()->count() == 0  && $this->projects()->count() == 0;
    }
}
