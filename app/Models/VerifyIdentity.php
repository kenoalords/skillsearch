<?php

namespace App\Models;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;

class VerifyIdentity extends Model
{
    protected $fillable = ['scan_link', 'status'];

    protected $appends = ['user_profile'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function getUserProfileAttribute()
    {
    	return Profile::where('user_id', $this->user_id)->first();
    }
}
