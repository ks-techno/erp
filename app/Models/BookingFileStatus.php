<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingFileStatus extends Model
{
    protected $table = 'booking_file_status';
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'slug',
        'default',
        'status',
        'company_id',
        'project_id',
        'user_id',
    ];

}
