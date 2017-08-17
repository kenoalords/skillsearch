<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function scopeOrderAsc($query)
    {
    	return $query->orderBy('category', 'ASC');
    }
}
