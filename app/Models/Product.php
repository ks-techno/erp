<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductVariation;
use App\Models\PropertyVariation;
use App\Models\ProductVariationDtl;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'code',
        'name',
        'is_purchase_able',
        'is_taxable',
        'status',
        'supplier_id',
        'manufacturer_id',
        'brand_id',
        'parent_category',
        'category_id',
        'default_sale_price',
        'default_purchase_price',
        'stock_on_hand_units',
        'stock_on_hand_packages',
        'sold_in_quantity',
        'sell_by_package_only',
        'external_item_id',
        'product_form_type',
        'buyable_type_id',
        'company_id',
        'project_id',
        'user_id',
    ];

    protected $appends = ['block'];

    protected function scopeOrderByName($qry,$dir = 'asc'){
        return $qry->orderby('name',$dir);
    }

    protected function scopeProductProperty($qry){
        return $qry->where('product_form_type','property');
    }

    protected function scopeProductInventory($qry){
        return $qry->where('product_form_type','inventory');
    }

    public function property_variation(){
        return $this->hasMany(PropertyVariation::class,'product_id','id');
    }
    
    public function buyable_type(){
        return $this->belongsTo(BuyableType::class,'buyable_type_id','id');
    }

    public function getBlockAttribute()
    {
        $productVariation = ProductVariation::where('key_name', 'block')->first();

        if ($productVariation) {
            $propertyVariation = PropertyVariation::where('product_id', $this->id)
                                    ->where('product_variation_id', $productVariation->id)
                                    ->first();
            return $propertyVariation ? $propertyVariation->value : null;
        }

        return null;
    }
}
