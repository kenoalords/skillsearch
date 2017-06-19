<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlaggedJobs extends Model
{
    protected $fillable = ['user_id', 'task_id'];

    public function tasks()
    {
    	return $this->belongsTo(Task::class);
    }
}
