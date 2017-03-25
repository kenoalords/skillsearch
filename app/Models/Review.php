<?php

namespace App\Models;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
    	'user_id', 'reviewer_id', 'score', 'review', 'worked_with'
    ];

    protected $appends = ['profile', 'user', 'date'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function getProfileAttribute($value)
    {
    	return Profile::where('user_id', $this->reviewer_id)->get()->first();
    }

    public function getUserAttribute($value)
    {
    	return User::where('id', $this->reviewer_id)->get()->first();
    }

    public function getDateAttribute($value)
    {
    	return $this->created_at->diffForHumans();
    }

    public function scopeLatestFirst($query)
    {
    	return $query->orderBy('created_at', 'desc');
    }
}
