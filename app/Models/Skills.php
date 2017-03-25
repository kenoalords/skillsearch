<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Skills extends Model
{
    //

    protected $fillable = ['skill', 'description'];

    public function scopeUnselectedSkills($query){
    	$exclude_ids = Auth::user()->skills()->pluck('skill');
    	return $query->whereNotIn('skill', $exclude_ids);
    }

    public function scopeOrderAlphabetically($query)
    {
    	return $this->orderBy('skill', 'asc');
    }
}
