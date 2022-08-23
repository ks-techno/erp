<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionUser extends Model
{
    protected $table = 'permission_user';
    public $timestamps = true;


    public function user(){
        return $this->belongsTo(User::class,'user_id')->select(['id','name']);
    }
}
