<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    protected $fillable = ['user_id', 'email', 'name', 'message', 'is_urgent', 'phone_number', 'ip'];

    public function user(){
    		$this->belongsTo(User::class);
    }

    public function scopeUnread($query){
    		$query->where('is_read', false);
    }

    public function scopeRead($query){
    		$query->where('is_read', true);
    }
}
