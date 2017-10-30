<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactRequest extends Model
{
    protected $fillable = ['user_id', 'fullname', 'email', 'phone', 'location', 'ip', 'iso_code', 'country', 'city', 'state_name', 'lat', 'lon', 'timezone', 'currency', 'is_approved'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
