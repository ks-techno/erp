<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChallanParticular extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'challan_particular';

    protected $fillable = [
        'id',
        'challan_id',
        'particular_id',
        'amount',
    ];

    public function challan(){
        return $this->belongsTo(ChallanForm::class,'challan_id','id');
    }
    public function particular(){
        return $this->belongsTo(Particulars::class,'particular_id','id');
    }
}
