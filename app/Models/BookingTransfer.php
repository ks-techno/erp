<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingTransfer extends Model
{

    use HasFactory;
    protected $table = 'booking_transfers';
    use SoftDeletes;


    protected $fillable = [
        'uuid',
        'code',
        'date',

        'nm_customer_id',
        'nm_customer_name',
        'nm_membership_no',
        'nm_registration_no',
        'nm_mobile_no',
        'nm_cnic_no',
        'nm_image',

        'nm_nominee_no',
        'nm_nominee_name',
        'nm_nominee_parent_name',
        'nm_nominee_cnic_no',
        'nm_nominee_contact_no',
        'nm_nominee_relation',

        'om_customer_id',
        'om_customer_name',
        'om_membership_no',
        'om_cnic_no',
        'om_registration_no',
        'om_mobile_no',

        'om_nominee_no',
        'om_nominee_name',
        'om_nominee_parent_name',
        'om_nominee_cnic_no',
        'om_nominee_contact_no',
        'om_nominee_relation',
        'om_image',

        'booking_id',
        'booking_code',
        'product_id',
        'product_name',
        'file_status_id',
        'status',
        'company_id',
        'project_id',
        'user_id',
    ];
    public function nm_customer(){
        return $this->belongsTo(Customer::class,'nm_customer_id','id')
        ->with('addresses',);
    }

    public function om_customer(){
        return $this->belongsTo(Customer::class,'om_customer_id','id')
        ->with('addresses','sales');
    }

    public function file_status(){
        return $this->belongsTo(BookingFileStatus::class,'file_status_id','id');
    }
    public function product(){
        return $this->belongsTo(Product::class,'product_id','id')
            ->with('buyable_type');
    }
}
