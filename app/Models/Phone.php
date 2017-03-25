<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    //
    protected $fillable = ['type','number', 'is_private'];

    /*
	
	* Setup user relationship to phone

    */

    public function user(User $user)
    {
    	return $this->belongsTo($user);
    }

    public function scopeIsPublic()
    {
        return $this->where('is_private', 1);
    }
}
