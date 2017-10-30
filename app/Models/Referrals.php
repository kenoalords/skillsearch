<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referrals extends Model
{
    protected $fillable = ['user_id','referrer_id'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
