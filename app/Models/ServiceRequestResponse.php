<?php

namespace App\Models;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;

class ServiceRequestResponse extends Model
{
    protected $fillable = [
    	'request_id', 'response', 'read'
    ];

    protected $appends = ['profile', 'date'];

    public function serviceRequests()
    {
    	return $this->belongsTo(ServiceRequest::class);
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function getProfileAttribute($value)
    {
    	return Profile::where('user_id', $this->user_id)->get()->first();
    }

    public function getDateAttribute($value)
    {
    	return $this->created_at->diffForHumans();
    }
}
