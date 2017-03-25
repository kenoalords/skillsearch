<?php

namespace App\Listeners;

use Storage;
use File;
use Image;
use App\Events\PortfolioImageUploadEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PortfolioImageUploadEventListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PortfolioImageUploadEvent  $event
     * @return void
     */
    public function handle(PortfolioImageUploadEvent $event)
    {
        // Store the new file to s3
        $path = storage_path() . '/app/' . $event->thumbnail;
        $filename = $event->thumbnail;

        if(Storage::disk('s3images')->put($filename, fopen($path, 'r+'))){
            Storage::disk('s3images')->delete($event->default);
            $event->portfolio->thumbnail = $filename;
            $event->portfolio->save();
            // Delete file
            Storage::delete($filename);
            return $filename;
        }
    }
}
