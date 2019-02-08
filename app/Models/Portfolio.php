<?php

namespace App\Models;

use Storage;
use App\Models\File;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Traits\Orderable;
use Illuminate\Notifications\Notifiable;

class Portfolio extends Model
{
    use Orderable, Notifiable;

    protected $fillable = [
    	'title', 'description', 'is_public', 'uid', 'user_id', 'type', 'url', 'skills', 'thumbnail', 'completion_date'
    ];

    protected $appends = [
        'files', 'date', 'likes', 'user',
    ];

    public function getRouteKeyName(){
        return 'uid';
    }

   	public function files()
   	{
   		return $this->morphMany(File::class, 'fileable');
   	}

   	public function user()
   	{
   		return $this->belongsTo(User::class);
   	}

    public function getFilesAttribute($value)
    {
      return $this->files()->get();
    }

    public function getUserAttribute()
    {
      return User::where('id', $this->user_id)->get()->first();
    }

    public function getDateAttribute($value)
    {
      return $this->created_at->diffForHumans();
    }

    public function scopeIsPublic($query)
    {
      return $query->where('is_public', true);
    }

    public function scopeIsFeatured($query)
    {
      return $query->where('is_featured', true);
    }

    public function likes()
    {
      return $this->morphMany('App\Models\Like', 'likeable');
    }

    public function userHasLiked()
    {
        if(Auth::user()){
          return (bool)$this->likes()->where(['user_id' => Auth::user()->id, 'likeable_id' => $this->id ])->count();
        } else {
          return false;
        }
    }

    public function getLikesAttribute()
    {
      return $this->likes()->count();
    }

    public function comments()
    {
      return $this->morphMany(Comment::class, 'commentable')->where('reply_id', null);
    }

    public function comment()
    {
      return $this->morphMany(Comment::class, 'commentable');
    }

    public function track()
    {
      return $this->morphMany(UserTracker::class, 'trackable');
    }

    public function getAvatar()
    {
      if(!$this->avatar){
        if(Storage::exists($this->avatar)){
                return asset($this->avatar);
        }
        return config('skillsearch.s3.images') . '/' . $this->avatar;
      } else {
        return asset($this->avatar);
      }
    }

    public function getThumbnail()
    {
      if($this->thumbnail){
        if(Storage::exists($this->thumbnail)){
            return asset($this->thumbnail);
        }
        return config('skillsearch.s3.images') . '/' . $this->thumbnail;
      } else {
        return asset('public/no-image.png');
      }
      
    }

    public function scopeHasThumbnail($query)
    {
      return $query->whereNotNull('thumbnail');
    }

    public function views()
    {
      return $this->morphMany(View::class, 'viewable');
    }

    public function activity()
    {
      return $this->morphMany(Activity::class, 'activable');
    }
    
}
