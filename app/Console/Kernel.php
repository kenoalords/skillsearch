<?php

namespace App\Console;

use Mail;
use App\Models\User;
use App\Models\VerifyUser;
use App\Models\ContactInvite;
use App\Models\Task;
use App\Mail\ContactInviteReminder;
use App\Mail\CronTestEmail;
use App\Mail\InstagramNotificationMail;
use App\Transformers\SimpleTaskTransformer;
use App\Mail\VerificationReminderMail;
use App\Mail\JobPromotionNotification;
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
        // $schedule->command('inspire')
        //          ->hourly();

        // Send out reminder emails for invites
        $schedule->call(function(){

            $reminder = ContactInvite::getSentInvites()->get();
            $reminder->each(function($item, $key){
                $user = User::where('email', $item->email)->first();
                if(!$user){
                    Mail::to($item->email)->send(new ContactInviteReminder($item->invitee_name, $item->email));
                }
            });

        })->weekly()->tuesdays()->at('10:00')->timezone('Africa/Lagos');

        $schedule->call(function(){

            $verify = VerifyUser::get();
            if($verify->count()){
                $verify->each( function($item, $key) {
                    $user = User::where('id', $item->user_id)->first();
                    Mail::to($user)->send( new VerificationReminderMail( $user->name, $item->verify_key ) );
                });
            }

        })->weekly()->fridays()->at('10:00')->timezone('Africa/Lagos');


        // Job Promotion Notification Schedule Mail
        $schedule->call(function(){
            $users = ContactInvite::get();
            $tasks = Task::isPublic()->isApproved()->orderDesc()->take(5)->get();
            $tasks = fractal()->collection($tasks)
                              ->transformWith(new SimpleTaskTransformer)
                              ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                              ->toArray();
            if($users->count()){
                $users->each( function( $user, $key ) use ($tasks) {
                    Mail::to($user->email)->send( new JobPromotionNotification($tasks) );
                });
            }
        })->weekly()->mondays()->at('17:00')->timezone('Africa/Lagos');

        $schedule->call(function(){
            $users = User::get();
            if($users->count()){
                $users->each( function( $user, $key ) {
                    $hasInstagram = $user->instagram()->first();
                    $profile = $user->profile()->first();
                    if($profile && $profile->account_type === 1 && !$hasInstagram){
                        Mail::to($user)->send( new InstagramNotificationMail($user) );
                    }
                });
            }
        })->weekly()->thursdays()->at('14:49')->timezone('Africa/Lagos');
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
