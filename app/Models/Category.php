<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'parent_id',
        'category_type_id',
        'company_id',
        'project_id',
        'user_id',
    ];

    protected function scopeOrderByName($qry,$dir = 'asc'){
        return $qry->orderby('name',$dir);
    }
    protected function scopeParentCategory($qry){
        return $qry->whereNull('parent_id');
    }

    public function category_type(){
        return $this->belongsTo(CategoryType::class);
    }
    public function parent(){
        return $this->belongsTo(self::class)->orderBy('name');
    }
}
