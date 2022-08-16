<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;

    protected $table = 'product_variations';

    protected $fillable = [
        'uuid',
        'display_title',
        'key_name',
        'description',
        'value_type',
    ];

    protected function scopeOrderByName($qry,$dir = 'asc'){
        return $qry->orderby('display_title',$dir);
    }
    public function dtl(){
        return $this->hasMany(ProductVariationDtl::class,'product_variation_id','id')->orderby('sr_no');
    }

}
