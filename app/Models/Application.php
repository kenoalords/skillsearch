<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
    	'application', 'budget', 'user_id'
    ];

    public function task()
    {
    	return $this->belongsTo(Task::class);
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function response()
    {
        return $this->hasMany(ApplicationResponse::class);
    }
}
