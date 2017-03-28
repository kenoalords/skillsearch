<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use App\Models\Activity;
use App\Models\Phone;
use App\Jobs\UserImageJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserProfileRequest;
use App\Http\Requests\SocialUserProfileRequest;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Jobs\DeleteFileFromS3Storage;

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

    public function saveSocialUserProfile(SocialUserProfileRequest $request)
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
        $profile = $request->user()->profile;
    	// dd($phones);
    	return view('profile.phone')->with(['phones' => $phones, 'profile' => $profile]);
    }

    public function phoneAdd(Request $request){
    	// dd($phones);
        $profile = $request->user()->profile;
    	return view('profile.phone_add')->with('profile', $profile);
    }

    public function phoneAddNew(Request $request){
    	$this->validate($request, [
	        'phone' => 'required|numeric',
	    ]);

	    Auth::user()->phone()->create([
	    	'number'	=> $request->phone,
            'is_private'=> $request->is_private
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

        Image::make(storage_path() . '/app/' . $store)->fit(100)->save();


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
        return view('profile.delete')->with('user', $request->user);
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
}




