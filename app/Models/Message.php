<?php

namespace App\Models;
use App\Models\User;
use App\Models\Profile;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $fillable = [
    	'user_id', 'receiver_id', 'reply_id', 'subject', 'message', 'read'
    ];

    protected $appends = ['sender', 'receiver', 'date'];

    public function getSenderAttribute($value){
    	return Profile::where( ['user_id' => $this->user_id] )->get()->first();
    }

    public function getDateAttribute($value)
    {
        return $this->created_at->diffForHumans();
    }

    public function getReceiverAttribute($value){
    	return Profile::where('user_id', $this->receiver_id)->get()->first();
    }

    public function user(){
    	return $this->belongsTo('App\Models\User');
    }
}
