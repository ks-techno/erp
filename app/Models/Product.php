<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

    protected function scopeOrderByName($qry,$dir = 'asc'){
        return $qry->orderby('name',$dir);
    }


    public function property_variation(){
        return $this->hasMany(PropertyVariation::class,'product_id','id')->orderby('sr_no');
    }
}
