<?php

namespace App\Http\Controllers;

use Mail;
use App\Models\User;
use App\Models\Profile;
use App\Models\ContactInvite;
use App\Models\Activity;
use App\Models\Phone;
use App\Models\VerifyIdentity;
use App\Jobs\UserImageJob;
use App\Services\PointService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserProfileRequest;
use App\Http\Requests\SocialUserProfileRequest;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Jobs\DeleteFileFromS3Storage;
use App\Mail\CancelVerifyNotification;
use App\Mail\ApproveVerifyNotification;
use App\Mail\InviteAccepted;

class UserProfileController extends Controller
{
    
    public function edit(){
    	$profile = Auth::user()->profile;
    	return view('profile.edit')->with([
    		'profile' 	=> $profile,
    	]);
    }

    public function setupUserProfile()
    {
        $profile = Auth::user()->profile()->get();
        // dd($profile);
        if($profile->count() > 0){
            return redirect('/home');
        }
        $name = Auth::user()->name;
        return view('profile.start')->with('name', $name);
    }

    public function setupTwitterUserProfile()
    {
        return view('profile.start')->with('name', $name);
    }

    public function saveSocialUserProfile(SocialUserProfileRequest $request, PointService $point)
    {
        // dd($request->user_location);
        if($request->username !== $request->user()->name){
            $request->validate($request, [
                'username'  => 'required|unique:users,name|min:6|max:32',
            ]);
            $request->user()->name = $request->username;
            $request->user()->save();
        }
        $user = $request->user()->profile()->create([
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'gender'        => $request->gender,
            'bio'           => $request->bio,
            'account_type'  => $request->account_type,
            'location'      => $request->location,
        ]);

        $inviteCheck = ContactInvite::where('email', $request->user()->email)->first();
        if($inviteCheck){
            $invitee = User::where('email', $inviteCheck->invitee_email)->first();
            if($invitee){
                $point->addPoint($invitee, 'invite_signup');
            }
            Mail::to($inviteCheck->invitee_email)->send(new InviteAccepted($inviteCheck->invitee_name, $request->first_name, $request->username));
            $inviteCheck->delete();
        }

        if($request->account_type == 1){
            return redirect('/home/start/skills');
        } else {
            return redirect('/home');
        }
    }

    public function setupUserSkills(Request $request)
    {
        return view('profile.start-skills');
    }

    public function store(UserProfileRequest $request){
        // dd($request);
        $profile = $request->user()->profile;
        $profile->bio = $request->bio;
        $profile->gender = $request->gender;
        $profile->location = $request->user_location;
    	
    	$profile->save();

    	$profile = $request->user()->profile;
    	$request->session()->flash('status', 'Your profile was saved successfully');
    	return view('profile.edit')->with([
    		'profile' 	=> $profile,
    	]);
    }

    public function phoneIndex(Request $request){
    	$phones = Auth::user()->phone()->get();
    	return view('profile.phone')->with(['phones' => $phones]);
    }

    public function phoneAdd(Request $request){
    	return view('profile.phone_add');
    }

    public function phoneEdit(Request $request, Phone $phone){
        $this->authorize('edit', $phone);
        return view('profile.phone_edit')->with('phone', $phone);
    }

    public function phoneEditSave(Request $request, Phone $phone){
        $this->authorize('edit', $phone);
        $phone->number = $request->phone;
        $phone->save();
        return redirect()->route('phone');
    }

    public function phoneDelete(Request $request, Phone $phone){
        $this->authorize('edit', $phone);
        return view('profile.phone_delete')->with('phone', $phone);
    }

    public function phoneDeleteSubmit(Request $request, Phone $phone){
        $this->authorize('edit', $phone);
        $phone->delete();
        return redirect()->route('phone');
    }

    public function phoneAddNew(Request $request){
    	$this->validate($request, [
	        'phone' => 'required|numeric',
	    ]);

	    Auth::user()->phone()->create([
	    	'number'	=> $request->phone,
            'is_private'=> 1
	    ]);

	    return redirect()->route('phone');
    }



    // Upload user profile image
    public function uploadImage(Request $request){

        $this->validate($request, [
            'image' => 'image'
        ]);

        $profile = $request->user()->profile()->first();

        if($profile->avatar != null){
            Storage::delete($profile->avatar);
        }

        $store = $request->file('image')->store('public');

        Image::make(storage_path() . '/app/' . $store)->fit(200)->save();


        $profile->avatar = $store;
        $profile->save();

        $filename = asset($store);
        $request->user()->activity()->create([
            'user_id'   => $request->user()->id,
            'title'     => 'Changed their profile image',
            'type'      => 'avatar',
        ]);
        dispatch(new UserImageJob($store));
        return response()->json(['filename'=>$filename]);
    }

    // Get user reviews
    public function reviews(Request $request)
    {
        $name = $request->user()->name;
        $profile = $request->user()->profile()->get()->first();
        return view('profile.reviews')->with([
            'name' => $name,
            'profile' => $profile
        ]);
    }

    // Set Account Privacy
    public function setAccountPrivacy(Request $request)
    {
        $profile = $request->user()->profile()->first();
        if($request->option === 'private'){
            $profile->is_public = false;
            $profile->save();
            return response()->json(null, 200);
        } else if($request->option === 'public'){
            $profile->is_public = true;
            $profile->save();
            return response()->json(null, 200);
        }
    }

    public function getAccountPrivacy(Request $request)
    {
        $status = $request->user()->profile()->first()->is_public;
        $status = ($status == 0) ? false : true;
        return response()->json(['status' => $status], 200);
    }

    // Delete user account
    public function deleteAccount(Request $request)
    {
        $profile = $request->user()->profile()->first();
        return view('profile.delete')->with(['user'=>$request->user, 'profile'=>$profile]);
    }

    // Confirm delete 
    public function deleteAccountConfirm(Request $request)
    {
        $portfolio = $request->user()->portfolio;

        $portfolio->map(function($item){
            $files = $item->files;
            $files->each(function ($file, $key){
                dispatch(new DeleteFileFromS3Storage($file->file));
            });
        });

        $request->user()->delete();
        return redirect('/');
    }

    public function verifyUserAccounts(Request $request)
    {
        $profile = $request->user()->profile()->first();
        return view('verify-accounts')->with('profile', $profile);
    }

    public function getVerifyUserAccounts(Request $request)
    {
        $req = VerifyIdentity::where('status', 0)->get();
        return response()->json($req, 200);
    }

    public function cancelUserVerifyRequest(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();
        $identity = VerifyIdentity::where('id', $request->id)->first();
        dispatch(new DeleteFileFromS3Storage($identity->scan_link));
        $identity->delete();
        Mail::to($user)->queue(new CancelVerifyNotification($user, $request->message));
        return response()->json(null, 200);
    }

    public function approveUserVerifyRequest(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();
        $identity = VerifyIdentity::where('id', $request->id)->first();
        $identity->status = 1;
        $identity->save();
        Mail::to($user)->queue(new ApproveVerifyNotification($user));
        return response()->json(null, 200);
    }
}




