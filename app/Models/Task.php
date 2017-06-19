<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Laravel\Scout\Searchable;

class Task extends Model
{
    use Searchable;
    
	protected $fillable = [
		'user_id', 'title', 'description', 'location', 'category', 'budget', 'budget_type', 'slug', 'expires', 'is_public', 'only_portfolio', 'open_applications'
	];

    public function user(){
    	return $this->belongsTo(User::class);
    }

    public function savedJob()
    {
        return $this->hasMany(SaveJob::class);
    }

    public function applications(){
    	return $this->hasMany(Application::class);
    }

    public function flags()
    {
        return $this->hasMany(FlaggedJobs::class);
    }

    public function scopeOrderDesc($query)
    {
    	return $query->orderBy('created_at', 'desc');
    }

    public function scopeIsPublic($query)
    {
    	return $query->where('is_public', true);
    }

    public function scopeIsApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeIsNotApproved($query)
    {
        return $query->where('is_approved', false);
    }

    public function scopeIsNotRejected($query)
    {
        return $query->where('is_rejected', false);
    }
}
