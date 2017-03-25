<?php

namespace App\Models;

use Storage;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    //

    protected $fillable = ['type', 'file'];
    protected $appends = ['link'];

    public function fileable()
    {
    	$this->morphTo();
    }

    public function getLinkAttribute()
    {
        if(Storage::exists($this->file)){
            return config('app.url') . '/' . $this->file;
        }
    	return config('skillsearch.s3.images').'/'.$this->file;
    }

    public function getFile()
    {
        if(Storage::exists($this->file)){
            return config('app.url') . '/' . $this->file;
        }
        return config('skillsearch.s3.images').'/'.$this->file;
    }
}
