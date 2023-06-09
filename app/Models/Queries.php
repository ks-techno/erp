<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Queries extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'purchaseDemand_id',
        'date',
        'uom',
        'packing',
        'sr_no',
        'supplier_id',
        'demandBy_id',
        'product_id',
        'physical_stock',
        'store_stock',
        'reorder',
        'reorder',
        'consumption',
        'quantity',
        'lpo_stock',
        'notes',
    ];

public function satff()
{
    return $this->belongsTo(Staff::class,'demandBy_id');
}

}

