<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialShare extends Model
{
	protected $table = 'socialshares';
	protected $fillable = ['network', 'url', 'agent', 'ip'];
}
