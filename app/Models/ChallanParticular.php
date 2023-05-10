<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChallanPrticular extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'challan_particular';

    protected $fillable = [
        'id',
        'challan_id',
        'paarticular_id',
    ];

    public function challan(){
        return $this->belongsTo(ChallanForm::class,'challan_id','id');
    }
}
