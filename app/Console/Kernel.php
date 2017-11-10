<?php

namespace App\Console;

use Mail;
use Carbon\Carbon;
use App\Models\User;
use App\Models\VerifyUser;
use App\Models\ContactInvite;
use App\Models\LinkedinContacts;
use App\Models\Task;
use App\Models\Profile;
use App\Mail\ContactInviteReminder;
use App\Mail\CronTestEmail;
use App\Mail\InstagramNotificationMail;
use App\Transformers\SimpleTaskTransformer;
use App\Transformers\ProfileTransformers;
use App\Mail\VerificationReminderMail;
use App\Mail\JobPromotionNotification;
use App\Mail\LinkedinContactMailingList;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
