<?php

use App\Models\File;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class PortfolioRecordSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $files = File::get();

        $files->each(function($item, $key)
        {
        	$file = explode(".", $item->file);
        	$image = ['jpeg', 'png', 'gif'];
        	$video = ['mp4'];
        	$audio = ['mp3', 'mpga'];

        	if( in_array($file[1], $image) ){
        		$item->file_type = 'image/'.$file[1];
        		$item->save();
        	}

        	if( in_array($file[1], $audio) ){
        		$item->file_type = 'audio/mp3';
        		$item->save();
        	}

        	if( in_array($file[1], $video) ){
        		$item->file_type = 'video/mp4';
        		$item->save();
        	}
        });
    }
}
