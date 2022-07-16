<?php

namespace App\Models\Defi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblDefiCountry extends Model
{
    protected $table = 'tbl_defi_country';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'default_country',
        'country_status'
    ];

}
