<?php

namespace App\Models;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    protected $fillable = [
    	'user_id', 'receiver_id', 'subject', 'body', 'skills', 'read'
    ];

    protected $appends = [
    	'date', 'sender_profile', 'receiver_profile'
    ];

    public function serviceResponses()
    {
    	return $this->hasMany(ServiceRequestResponses::class);
    }

   	public function scopeAllRequests($query, User $user)
   	{
   		// dd($user->id);
   		return $query->where('user_id', '=', $user->id)->orWhere('receiver_id', '=', $user->id)->orderBy('created_at', 'desc');
   	}

   	public function getDateAttribute($value)
   	{
   		return $this->created_at->diffForHumans();
   	}

   	public function getSenderProfileAttribute($value)
   	{
   		return Profile::where('user_id', $this->user_id)->get()->first();
   	}

   	public function getReceiverProfileAttribute($value)
   	{
   		return Profile::where('user_id', $this->receiver_id)->get()->first();
   	}
}
