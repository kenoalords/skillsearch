<?php

namespace App\Transformers;

use App\Models\File;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection;

class FileTransformer extends TransformerAbstract
{
	public function transform(File $file){
		return [
			'id'		=> $file->id,
			'file'		=> $file->getFile(),
			'caption'	=> $file->caption,
			'file_type'	=> $file->file_type,
		];
	}
}