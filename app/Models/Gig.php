<?php

namespace App\Models;

use Storage;
use App\Traits\Orderable;
use Illuminate\Database\Eloquent\Model;

class Gig extends Model
{
    use Orderable;

    public function getRouteKeyName()
    {
        return 'uid';
    }
	protected $fillable = ['title', 'description', 'category', 'image', 'regular_price', 'sale_price', 'addon_services', 'delivery_time', 'is_local', 'is_public', 'uid', 'slug'];
    
    public function user()
    {
    		return $this->belongsTo(User::class);
    }

    public function order()
    {
    		return $this->morphMany(Order::class, 'orderable');
    }

    public function getFile()
    {
        if(Storage::exists($this->image)){
            return config('app.url') . '/' . $this->image;
        }
        return config('skillsearch.s3.images').'/'.$this->image;
    }
}
