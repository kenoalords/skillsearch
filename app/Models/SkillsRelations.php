<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkillsRelations extends Model
{
	protected $fillable = ['user_id', 'skill', 'skill_id'];

    public function skills(){
    	return $this->morphTo();
    }
}
