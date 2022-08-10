<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryType extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'category_types';

    protected $fillable = [
        'uuid',
        'name',
        'status',
    ];

    protected function scopeOrderByName($qry,$dir = 'asc'){
        return $qry->orderby('name',$dir);
    }

}
