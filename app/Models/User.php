<?php

namespace App\Models;

use App\Models\Phone;
use App\Models\Blog;
use App\Models\Profile;
use App\Models\VerifyUser;
use App\Models\Follower;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getRouteKeyName(){
        return 'name';
    }

    // Set up relationship 
    // user to user phone contact
    public function phone()
    {
        return $this->hasMany('App\Models\Phone');
    }

    public function social()
    {
        return $this->hasOne(SocialAccount::class);
    }

    public function blog()
    {
        return $this->hasMany(Blog::class);
    }

    // Set up relationship 
    // user to user phone contact
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    // Setup relationship with verify table
    public function verifyUser()
    {
        return $this->hasOne('App\Models\VerifyUser');
    }

    public function skills(){
        return $this->morphMany('App\Models\SkillsRelations', 'skills');
    }

    public function portfolio(){
        return $this->hasMany('App\Models\Portfolio');
    }

    public function messages(){
        return $this->hasMany('App\Models\Message');
    }

    public function tasks(){
        return $this->hasMany('App\Models\Task');
    }

    public function views(){
        return $this->morphMany('App\Models\View', 'viewable');
    }
    
    public function followers()
    {
        return $this->hasMany('App\Models\Follower');
    }

    public function getFollowers(User $user)
    {
        return Follower::where('following_id', $user->id)->count();
    }

    public function getFollowing()
    {
        return $this->followers()->count();
    }

    public function userCanFollow(User $user)
    {
        return !$this->followers()->where('following_id', $user->id)->count();
    }

    public function userIsSelf(User $user)
    {
        return ($this->id === $user->id) ? true : false;
    }

    // Reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function hasReviewed(User $user)
    {
        
    }

    public function requests()
    {
        return $this->hasMany(ServiceRequest::class);
    }

    public function responses()
    {
        return $this->hasMany(ServiceRequestResponse::class);
    }

    public function identity()
    {
        return $this->hasOne(VerifyIdentity::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'commentable');
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'activable');
    }

}











