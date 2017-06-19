<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationResponse extends Model
{
    protected $fillable = ['user_id', 'task_id', 'application_id', 'response'];

    public function application()
    {
    	return $this->hasOne(Application::class);
    }

    public function user()
    {
    	return $this->hasOne(User::class);
    }

    public function task()
    {
    	return $this->hasOne(Task::class);
    }
}
