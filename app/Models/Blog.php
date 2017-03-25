<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Orderable;

class Blog extends Model
{
	use Orderable;
    
    protected $fillable = [
    	'title', 'excerpt', 'body', 'slug', 'image', 'status', 'is_public'
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function files()
    {
    	return $this->morphMany(File::class, 'fileable');
    }

    public function views()
    {
    	return $this->morphMany(View::class, 'viewable');
    }

    public function likes()
    {
    	return $this->morphMany(Like::class, 'likeable');
    }

    public function comments()
    {
    	return $this->morphMany(Comment::class, 'commentable');
    }

}
