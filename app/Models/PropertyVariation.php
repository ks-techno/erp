<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyVariation extends Model
{
    use HasFactory;

    protected $table = 'property_variations';

    protected $fillable = [
        'sr_no',
        'product_id',
        'buyable_id',
        'product_variation_id',
        'value',
    ];
}
