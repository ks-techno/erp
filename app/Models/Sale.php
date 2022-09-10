<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'code',
        'customer_id',
        'sale_by_staff',
        'project_id',
        'product_id',
        'is_installment',
        'is_booked',
        'is_purchased',
        'sale_price',
        'booked_price',
    ];

    protected $morphClass = null;

    public function project(){
        return $this->belongsTo(Project::class,'project_id','id');
    }
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }

    public function getMorphClass()
    {
        return $this->morphClass ?: static::class;
    }
    public function dealer()
    {
        $this->morphClass = 'App\Models\Dealer';
        return $this->morphOne(SaleSeller::class,'sale_sellersable','sale_sellerable_type','sale_id','id');
    }
    public function staff()
    {
        $this->morphClass = 'App\Models\Staff';
        return $this->morphOne(SaleSeller::class,'sale_sellersable','sale_sellerable_type','sale_id','id');
    }
}
