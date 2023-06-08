<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChallanForm extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'challan_form';

    protected $fillable = [
        'id',
        'uuid',
        'challan_no',
        'property_payment_mode_id',
        'cheque_no',
        'cheque_date',
        'total_amount',
        'customer_id',
        'project_id',
        'product_id',
        'user_id',
        'status',
        'is_active',
    ];

    public function project(){
        return $this->belongsTo(Project::class,'project_id','id');
    }
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    
    public function property_payment_mode(){
        return $this->belongsTo(PropertyPaymentMode::class,'property_payment_mode_id','id');
    }
    public function file_status(){
        return $this->belongsTo(BookingFileStatus::class,'file_status_id','id');
    }
    public function product(){
        return $this->belongsTo(Product::class,'product_id','id')
            ->with('buyable_type');
    }
    public function challan_particluar(){
        return $this->belongsTo(ChallanParticular::class,'id','challan_id');
    }
    public function vouchers(){
        return $this->belongsTo(Voucher::class,'id','challan_id');
    }
}
