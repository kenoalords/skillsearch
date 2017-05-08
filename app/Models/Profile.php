<?php

namespace App\Models;

use App\Models\User;
use App\Models\Phone;
use App\Models\Portfolio;
use App\Models\Review;
use Storage;
use App\Models\SkillsRelations;
use App\Models\VerifyIdentity;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Profile extends Model
{
    //
    use Searchable;

    protected $fillable = [
    	'first_name',
    	'last_name',
    	'bio',
    	'city',
        'state',
        'gender',
    	'location',
    	'first_name',
    	'avatar',
    	'skills',
    	'is_public',
        'account_type',
        'background',
        'identity_verified',
    ];

    // protected $appends = ['user', 'skills', 'rating', 'portfolio_count', 'phones', 'identity', 'is_skill'];

    public function getUserAttribute($value)
    {
        return User::where('id', $this->user_id)->get()->first();
    }

    public function getIsSkillAttribute()
    {
        return ($this->account_type === 'skill') ? 1 : 0;
    }

    public function getIdentityAttribute()
    {
        return VerifyIdentity::where('user_id', $this->user_id)->get()->first();
    }

    // public function getPortfolioAttribute($value)
    // {
    //     return Portfolio::where( ['user_id' => $this->user_id, 'is_public' => true] )->get();
    // }

    public function getPortfolioCountAttribute()
    {
        return Portfolio::where( ['user_id' => $this->user_id, 'is_public' => true] )->count();
    }

    public function getPhonesAttribute(){
        return Phone::where(['user_id' => $this->user_id, 'is_private' => true])->get();
    }

    public function getSkillsAttribute($value)
    {
        return SkillsRelations::where('skills_id', $this->user_id)->get();
    }

    public function getFirstNameAttribute($value){
        return ucfirst(strtolower($value));
    }

    public function getLastNameAttribute($value){
        return ucfirst(strtolower($value));
    }

    // Setup user relationship
    public function user()
    {
    	return $this->belongsTo('\App\Models\User');
    }

    public function getAvatar(){
        if($this->avatar){
            if(Storage::exists($this->avatar)){
                return asset($this->avatar);
            }
            return config('skillsearch.s3.images') . '/' . $this->avatar;
        } else {
            return asset('public/default-user.jpg');
        }
    }

    public function getFullname()
    {
      return $this->first_name . ' ' . $this->last_name;
    }

    public function getUserBackground(){
        if($this->background){
            if(Storage::exists($this->background)){
                return asset($this->background);
            }
            return config('skillsearch.s3.images') . '/' . $this->background;
        } else {
            return asset('public/default-user-back.jpg');
        }
    }

    public function getRatingAttribute()
    {
        return Review::where('user_id', $this->user_id)->avg('score');
    }

    // Scopes
    public function scopeIsPublic($query)
    {
        return $query->where('is_public', 1);
    }

    public function getVerified()
    {
        $id = VerifyIdentity::where('user_id', $this->id)->first();
        return ($id && $id->status === 1) ? true : false;
    }

    public function scopeGetOtherProfiles($query, User $user)
    {
        return $query->where('user_id', '!=', $user->id);
    }
}
