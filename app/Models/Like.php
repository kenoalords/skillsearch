<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Orderable;

class Like extends Model
{
    use Orderable;
    
    protected $fillable = [
    		'user_id', 'likeable_id', 'likeable_type'
    ];

    public function likeable()
    {
    		return $this->morphMany();
    }

    public function user()
    {
    		return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
