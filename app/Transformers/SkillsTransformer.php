<?php

namespace App\Transformers;

use App\Models\Profile;
use App\Models\User;
use App\Models\SkillsRelations;
use League\Fractal\TransformerAbstract;

class SkillsTransformer extends TransformerAbstract
{

	public function transform(SkillsRelations $skills){

		return [
			'skill'	=> $skills->skill,
		];
	}

}