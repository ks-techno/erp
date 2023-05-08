<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'code',
        'customer_id',
        'sale_by_staff',
        'product_id',
        'is_installment',
        'is_booked',
        'is_purchased',
        'property_payment_mode_id',
        'sale_price',
        'booked_price',
        'currency_note_no',
        'company_id',
        'project_id',
        'user_id',
        'down_payment',
        'on_balloting',
        'no_of_bi_annual',
        'installment_bi_annual',
        'no_of_month',
        'installment_amount_monthly',
        'on_possession',
        'file_status_id',
        'sale_discount',
        'seller_commission_perc',
        'file_type',
        'file_date',
        'notes',
        'installment_start_time',
        'installment_end_time',
        'installment_type'
    ];
}
