<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerifyIdentity extends Model
{
    protected $fillable = ['scan_link', 'status'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
