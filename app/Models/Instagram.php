<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Instagram extends Model
{
    protected $fillable = ['user_id', 'access_token', 'full_name', 'username', 'instagram_id'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
