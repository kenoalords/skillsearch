<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $fillable = ['user_id', 'subscriber_id', 'fullname', 'email', 'blog_id', 'blog_title', 'blog_url', 'ip'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
