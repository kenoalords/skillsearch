<?php

namespace App\Http\Controllers;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Jobs\FileDeleteJob;

class FileController extends Controller
{
    //
    public function deleteFile(File $file)
    {
	    	dispatch(new FileDeleteJob($file));
	    	return response()->json(null, 200);
    }
}
