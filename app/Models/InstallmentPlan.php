<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ProductVariation;
use App\Models\PropertyVariation;
use App\Models\ProductVariationDtl;

class InstallmentPlan extends Model
{
    use SoftDeletes;
    protected $table = 'installment_plan';
    protected $fillable = [
        'uuid',
        'property_typeID',
        'plan_id',
        'total_payment',
        'down_payment',
        'on_balloting',
        'allocation_amount',
        'installment_bi_annual',
        'installment_monthly',
        'on_possession',
        'installemnt_plan_name',
        'product_variation_id',
        'product_variation_value'
    ];
    public function buyable_type(){
        return $this->belongsTo(BuyableType::class,'property_typeID','id');
    }
    public function product_variation(){
        return $this->belongsTo(ProductVariation::class,'product_variation_id','id');
    }
}
