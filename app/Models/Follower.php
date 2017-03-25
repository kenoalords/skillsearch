<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    protected $fillable = ['following_id'];

    public function user()
    {
    	return $this->belongsTo('App\Models\User');
    }
}
