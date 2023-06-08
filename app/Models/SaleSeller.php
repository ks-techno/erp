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
    public function dealer(){
        return $this->belongsTo(Dealer::class,'sale_sellerable_id','id');
    }
    public function staff(){
        return $this->belongsTo(Staff::class,'sale_sellerable_id','id');
    }
}
