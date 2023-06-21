<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ProductVariation;
use App\Models\PropertyVariation;
use App\Models\ProductVariationDtl;
use App\Models\Department;

class Scp extends Model
{
    use SoftDeletes;
    protected $table = 'scp';
    protected $fillable = [
        'id',
        'uuid',
        'property_typeID',
        'department_id',
        'percentage',
    ];
    public function buyable_type(){
        return $this->belongsTo(BuyableType::class,'property_typeID','id');
    }
    public function department(){
        return $this->belongsTo(Department::class,'department_id','id');
    }
}
