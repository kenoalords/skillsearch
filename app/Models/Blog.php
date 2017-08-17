<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Orderable;

class Blog extends Model
{
	use Orderable;
    
    protected $fillable = [
    	'title', 'excerpt', 'body', 'slug', 'image', 'status', 'is_public', 'uid', 'category', 'allow_comments'
    ];

    public function getRouteKeyName(){
        return 'uid';
    }

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

    public function subscribers()
    {
        return $this->hasMany(Subscriber::class);
    }

    // public function getImage()
    // {
    //     if(!$this->image){
    //         if(Storage::exists($this->image)){
    //             return asset($this->image);
    //         }
    //         return config('skillsearch.s3.images') . '/' . $this->image;
    //     } else {
    //         return asset($this->image);
    //     }
    // }

}
