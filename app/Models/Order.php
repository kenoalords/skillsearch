<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function orderable()
    {
    		return $this->morphTo();
    }

    public function transaction()
    {
    		return $this->hasMany(Transaction::class);
    }
}
