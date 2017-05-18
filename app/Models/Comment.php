<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Orderable;

class Comment extends Model
{
	use Orderable;
	
    protected $fillable = [
    	'user_id', 'reply_id', 'comment'
    ];

    public function commentable()
    {
    	return $this->morphTo();
    }

    public function replies()
    {
    	return $this->hasMany(Comment::class, 'reply_id', 'id');
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }
}
