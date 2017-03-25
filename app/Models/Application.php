<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
    	'application', 'budget'
    ];

    public function task(){
    	return $this->belongsTo('App\Models\Task');
    }
}
