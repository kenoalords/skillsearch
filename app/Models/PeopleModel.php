<?php

namespace App\Models;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PeopleModel extends Model
{
    public function getAllUsers(){
    	return Profile::get()->where('account_type', 'skill');
    }
}
