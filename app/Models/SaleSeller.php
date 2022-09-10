<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleSeller extends Model
{
    use SoftDeletes;

    public function sale_sellersable()
    {
        return $this->morphTo();
    }
}
