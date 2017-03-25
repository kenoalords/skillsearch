<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Orderable;

class Activity extends Model
{
	use Orderable;
	
    protected $fillable = [
    	'user_id', 'title', 'type'
    ];

    public function activable()
    {
    	return $this->morphTo();
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function portfolio()
    {
    	return $this->belongsTo(Portfolio::class);
    }
}
