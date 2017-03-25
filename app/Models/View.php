<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Request;

class View extends Model
{
    protected $fillable = ['ip', 'viewable_id', 'viewable_type'];

    public function viewable()
    {
    	return $this->morphTo();
    }

    public function scopeViewToday($q)
    {
    	$ip = Request::ip();
        // dd($this->viewable_id);
    	return $q->where('viewable_id', $this->viewable_id)
    			->where('ip', $ip);
    }
}
