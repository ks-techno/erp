<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariationDtl extends Model
{
    use HasFactory;

    protected $table = 'product_variation_dtl';

    protected $fillable = [
        'uuid',
        'value_type',
        'product_variation_id',
        'buyable_type_id',
        'sr_no',
        'value',
        'company_id',
        'project_id',
        'user_id',
    ];
    public function buyable_type(){
        return $this->belongsTo(BuyableType::class,'buyable_type_id','id');
    }
    public function product_variation(){
        return $this->belongsTo(ProductVariation::class,'product_variation_id','id');
    }
}
