<?php

namespace App\Listeners;

use Storage;
use App\Events\PortfolioFilesUploadEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PortfolioFilesUploadEventListener implements ShouldQueue
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
     * @param  PortfolioFilesUploadEvent  $event
     * @return void
     */
    public function handle(PortfolioFilesUploadEvent $event)
    {
        $path = storage_path() . '/app/' . $event->file;
        $filename = $event->file;

        if(Storage::disk('s3images')->put($filename, fopen($path, 'r+'))){
            // Storage::disk('s3images')->delete($event->default);
            // $event->portfolio->thumbnail = $filename;
            // $event->portfolio->save();
            // Delete file
            Storage::delete($filename);
            // return $filename;
        }
    }
}
