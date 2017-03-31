<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialShare extends Model
{
    protected $fillable = ['network', 'shareable_id', 'shareable_type'];

    public function shareable()
    {
    	return $this->morphTo();
    }
}
