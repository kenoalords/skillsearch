<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class VerifyUser extends Model
{
	protected $fillable = ['verify_key'];
    
    public function user(){
    	return $this->belongsTo('App\Models\User');
    }
}
