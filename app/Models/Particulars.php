<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Particulars extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'particulars';

    protected $fillable = [
        'id',
        'name',
        'is_active',
    ];
}
