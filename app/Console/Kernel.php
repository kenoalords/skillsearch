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
        // $schedule->call(function(){
        //     $users = ContactInvite::get();
        //     $tasks = Task::isPublic()->isApproved()->orderDesc()->take(5)->get();
        //     $tasks = fractal()->collection($tasks)
        //                       ->transformWith(new SimpleTaskTransformer)
        //                       ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
        //                       ->toArray();
        //     if($users->count()){
        //         $users->each( function( $user, $key ) use ($tasks) {
        //             Mail::to($user->email)->send( new JobPromotionNotification($tasks) );
        //         });
        //     }
        // })->weekly()->mondays()->at('17:00')->timezone('Africa/Lagos');

        // $schedule->call(function(){
        //     $users = User::get();
        //     if($users->count()){
        //         $users->each( function( $user, $key ) {
        //             $hasInstagram = $user->instagram()->first();
        //             $profile = $user->profile()->first();
        //             if($profile && $profile->account_type === 1 && !$hasInstagram){
        //                 Mail::to($user)->send( new InstagramNotificationMail($user) );
        //             }
        //         });
        //     }
        // })->weekly()->thursdays()->at('14:49')->timezone('Africa/Lagos');

        // Graphics Designer Promotion
        $schedule->call(function(){
            $term = ['Graphics Designer', 'Graphics Designer'];
            $users = LinkedinContacts::get();
            $profiles = User::where('id', '!=', 1)->whereHas('skills', function($query) use ($term){
                $query->whereIn('skill', $term);
            })->whereHas('portfolio', function($query){
                $query->where('is_public', true);
            })->inRandomOrder()->take(5)->get(); 
            $other_profiles = [];
            if($profiles){
                foreach($profiles as $user){
                    $other = $user->profile()->isPublic()->get()->first();
                    if($other){
                        $other_profiles[] = fractal()->item($other)
                                ->transformWith(new ProfileTransformers)
                                ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                                ->toArray();
                    }
                }
            }
            if($users->count()){
                $users->each( function( $user, $key ) use ($other_profiles, $term) {
                    $when = Carbon::now()->addSeconds(5*$key);
                    Mail::to($user->email)->later($when, new LinkedinContactMailingList($user, json_encode($other_profiles), $term ));
                });
            }
        })->weekly()->mondays()->at('13:00')->timezone('Africa/Lagos');
        //

        // Photographer Promotion
        $schedule->call(function(){
            $term = ['Photography', 'Photographer'];
            $users = LinkedinContacts::get();
            $profiles = User::where('id', '!=', 1)->whereHas('skills', function($query) use ($term){
                $query->whereIn('skill', $term);
            })->whereHas('portfolio', function($query){
                $query->where('is_public', true);
            })->inRandomOrder()->take(5)->get(); 
            $other_profiles = [];
            if($profiles){
                foreach($profiles as $user){
                    $other = $user->profile()->isPublic()->get()->first();
                    if($other){
                        $other_profiles[] = fractal()->item($other)
                                ->transformWith(new ProfileTransformers)
                                ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                                ->toArray();
                    }
                }
            }
            if($users->count()){
                $users->each( function( $user, $key ) use ($other_profiles, $term) {
                    $when = Carbon::now()->addSeconds(5*$key);
                    Mail::to($user->email)->later($when, new LinkedinContactMailingList($user, json_encode($other_profiles), $term ));
                });
            }
        })->weekly()->tuesdays()->at('13:30')->timezone('Africa/Lagos');

        // Website Developer Promotion
        $schedule->call(function(){
            $term = ['Website Developer', 'Website Designer'];
            $users = LinkedinContacts::get();
            $profiles = User::where('id', '!=', 1)->whereHas('skills', function($query) use ($term){
                $query->whereIn('skill', $term);
            })->whereHas('portfolio', function($query){
                $query->where('is_public', true);
            })->inRandomOrder()->take(5)->get(); 
            $other_profiles = [];
            if($profiles){
                foreach($profiles as $user){
                    $other = $user->profile()->isPublic()->get()->first();
                    if($other){
                        $other_profiles[] = fractal()->item($other)
                                ->transformWith(new ProfileTransformers)
                                ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                                ->toArray();
                    }
                }
            }
            if($users->count()){
                $users->each( function( $user, $key ) use ($other_profiles, $term) {
                    $when = Carbon::now()->addSeconds(5*$key);
                    Mail::to($user->email)->later($when, new LinkedinContactMailingList($user, json_encode($other_profiles), $term ));
                });
            }
        })->weekly()->wednesdays()->at('13:30')->timezone('Africa/Lagos');

        // Makeup Artists Promotion
        $schedule->call(function(){
            $term = ['Makeup Artists', 'Makeup Artists'];
            $users = LinkedinContacts::get();
            $profiles = User::where('id', '!=', 1)->whereHas('skills', function($query) use ($term){
                $query->whereIn('skill', $term);
            })->whereHas('portfolio', function($query){
                $query->where('is_public', true);
            })->inRandomOrder()->take(5)->get(); 
            $other_profiles = [];
            if($profiles){
                foreach($profiles as $user){
                    $other = $user->profile()->isPublic()->get()->first();
                    if($other){
                        $other_profiles[] = fractal()->item($other)
                                ->transformWith(new ProfileTransformers)
                                ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                                ->toArray();
                    }
                }
            }
            if($users->count()){
                $users->each( function( $user, $key ) use ($other_profiles, $term) {
                    $when = Carbon::now()->addSeconds(5*$key);
                    Mail::to($user->email)->later($when, new LinkedinContactMailingList($user, json_encode($other_profiles), $term ));
                });
            }
        })->weekly()->thursdays()->at('13:30')->timezone('Africa/Lagos');
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
