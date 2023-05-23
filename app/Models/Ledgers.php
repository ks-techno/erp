<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ledgers extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'ledgers';

    protected $fillable = [
        'id',
        'voucher_id',
        'COAID',
        'payment_id',
        'company_id',
        'user_id',
    ];
}
