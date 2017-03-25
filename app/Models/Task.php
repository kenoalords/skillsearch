<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
	protected $fillable = [
		'user_id', 'title', 'description', 'location', 'category', 'budget', 'budget_type', 'slug', 'expires', 'is_public', 'only_portfolio', 'open_applications'
	];

    public function user(){
    	return $this->belongsTo('App\Models\User');
    }

    public function applications(){
    	return $this->hasMany('App\Models\Application');
    }

    public function scopeOrderDesc($query)
    {
    	return $query->orderBy('created_at', 'desc');
    }

    public function scopeIsPublic($query)
    {
    	return $query->where('is_public', true);
    }
}
