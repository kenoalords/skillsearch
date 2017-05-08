<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactInvite extends Model
{
	use SoftDeletes;
	
    protected $fillable = [
    	'invitee_name', 'invitee_email', 'fullname', 'email', 'medium'
    ];

    public function scopeGetSentInvites($query)
    {
    	return $query->where('sent', true);
    }
}
