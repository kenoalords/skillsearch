<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTracker extends Model
{
    protected $fillable = ['email', 'subject', 'ip'];
}
