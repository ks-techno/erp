<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Miscellaneouscharges extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'miscellaneous_charges';

    protected $fillable = [
        'id',
        'uuid',
        'surcharge',
        'monthly_maintainance_fee',
        'other_charges',
        'utility_charges',
        'project_id',
    ];
    public function project(){
        return $this->belongsTo(Project::class,'project_id','id');
    }
}
