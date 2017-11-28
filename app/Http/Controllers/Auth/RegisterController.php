<?php

namespace App\Http\Controllers\Auth;

use Mail;
use App\Models\User;
use App\Models\ContactInvite;
use App\Models\ReferralCode;
use App\Events\UserEvents;
use App\Services\PointService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Crypt;
use App\Mail\InviteAccepted;
use App\Mail\ReferralNotification;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'          => 'required|max:255|alpha_num',
            'email'         => 'required|email|max:255|unique:users',
            'password'      => 'required|min:6|confirmed',
            'first_name'    => 'required|min:3|max:32',
            'last_name'     => 'required|min:3|max:32',
            'referral_code' => 'nullable|exists:referral_codes,code',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => bcrypt($data['password']),
        ]);

        $user->profile()->create([
            'first_name'    => $data['first_name'],
            'last_name'     => $data['last_name'],
            'account_type'  => 1,
            'is_public'     => true,
        ]);

        if($data['referral_code']){
            $ref = ReferralCode::where('code', $data['referral_code'])->first();
            $ref_user = $ref->user_id;
            $user->referral()->create([
                'referrer_id'   => $ref_user,
            ]);
            $ref_data = User::where('id', $ref_user)->first();
            $fullname = ucwords($data['first_name'] . ' ' . $data['last_name']);
            Mail::to($ref_data)->send(new ReferralNotification($ref_data, $fullname, $data['name']));
        }

        // Generate user verify token and store in database
        $verify_key = Crypt::encryptString($data['email']);
        $user->verifyUser()->create([
            'verify_key' => $verify_key
        ]);

        $inviteCheck = ContactInvite::where('email', $data['email'])->first();
        if($inviteCheck){
            $invitee = User::where('email', $inviteCheck->invitee_email)->first();
            if($invitee){
                $point = new PointService(config('services.points'));
                $point->addPoint($invitee, 'invite_signup');
            }
            Mail::to($inviteCheck->invitee_email)->send(new InviteAccepted($inviteCheck->invitee_name, $data['first_name'], $data['name']));
            $inviteCheck->delete();
        }

        // Dispatch the event to send the email
        event(new UserEvents($user));

        // Return the newly created user
        return $user;

    }

    private function addUserPoint(User $user, PointService $point)
    {
        $point->addPoint($user, 'invite_signup');
    }
}
