<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'PortfolioController@homepagePortfolio')->name('home');

Route::get('/search', 'SearchController@searchProfiles');
Route::get('/search/jobs', 'SearchController@searchJobs')->name('job_search');

Route::get('/about', 'PagesController@about');
Route::get('/work', 'PortfolioController@workPage')->name('work');
Route::get('/contact', 'PagesController@contact');
Route::get('/how-it-works', 'PagesController@works');
Route::get('/privacy', 'PagesController@privacy');
Route::get('/points', 'PagesController@points')->name('points');

Auth::routes();

Route::get('/auth/facebook', 'SocialAuthController@redirect')->name('facebook');
Route::get('/auth/facebook/callback', 'SocialAuthController@callback');

Route::get('/auth/google', 'SocialGoogleAuthController@redirect')->name('google');
Route::get('/auth/google/callback', 'SocialGoogleAuthController@callback');

Route::get('/portfolio/{portfolio}/comments', 'PortfolioCommentController@index');
Route::post('/portfolio/{portfolio}/comment/add', 'PortfolioCommentController@addComment');

Route::post('/portfolio/{portfolio}/views', 'ViewsController@create');

Route::get('/invite', 'InviteContactController@index');
Route::get('/invite/gmail', 'InviteContactController@gmailContactInvite');
Route::post('/invite/gmail', 'InviteContactController@gmailContactInviteRequest');
Route::get('/invite/success', 'InviteContactController@thankYou');

Route::get('/jobs/submit', 'TaskController@submitJobTeaser');

Route::group(['middleware'=>'auth'], function(){

	Route::post('/comment/{comment}/like', 'CommentController@likeComment');
	Route::delete('/comment/{comment}/delete', 'CommentController@deleteComment');

	Route::group(['prefix'=>'home'], function(){
		Route::get('/', 'HomeController@index')->middleware('user_profile_setup');
		Route::get('/start', 'UserProfileController@setupUserProfile')->name('start');
		Route::post('/start', 'UserProfileController@saveSocialUserProfile');

		Route::get('/start-twitter', 'UserProfileController@setupTwitterUserProfile')->name('start_twitter');
		Route::post('/start-twitter', 'UserProfileController@saveTwitterSocialUserProfile');

		Route::get('/start/skills', 'UserProfileController@setupUserSkills');
		Route::get('/users-verify', 'UserProfileController@verifyUserAccounts')->name('verify_user_accounts');
		Route::get('/users', 'UserProfileController@getVerifyUserAccounts');
		Route::post('/users/cancel', 'UserProfileController@cancelUserVerifyRequest');
		Route::post('/users/ok', 'UserProfileController@approveUserVerifyRequest');
		Route::get('/jobs', 'TaskController@approveJobs')->name('approve_jobs');
		Route::get('/linkedin_upload', 'LinkedinContactController@index')->name('linkedin_contacts');
		Route::post('/linkedin_upload/submit', 'LinkedinContactController@upload')->name('submit_linkedin_contacts');
	});
	
	Route::post('/home/upload', 'HomeController@uploadBackgroundImage');

	// BLOG ROUTES
	// Route::get('/blog/add', 'BlogController@addBlogPost');
	// Route::post('/blog/add', 'BlogController@submitBlogPost');
	// Route::post('/blog/add/image', 'BlogController@submitBlogPostImage');

	Route::group(['prefix'=>'profile'], function(){

		Route::get('/edit', 'UserProfileController@edit')->name('edit_profile');
		Route::put('/edit', 'UserProfileController@store');
		Route::post('/upload-image', 'UserProfileController@uploadImage');

		Route::get('/phone', 'UserProfileController@phoneIndex')->name('phone');

		Route::get('/phone/add', 'UserProfileController@phoneAdd')->name('add_phone');
		Route::post('/phone/add', 'UserProfileController@phoneAddNew');

		Route::get('/portfolio', 'PortfolioController@index')->name('portfolio_index');
		Route::get('/portfolio/add', 'PortfolioController@add');
		Route::post('/portfolio/add', 'PortfolioController@savePortfolio');
		Route::post('/portfolio/thumbnail', 'PortfolioController@savePortfolioThumbnail');
		Route::get('/portfolio/instagram', 'InstagramPortfolioController@index')->name('instagram_index');
		Route::get('/portfolio/instagram/get', 'InstagramPortfolioController@get');
		Route::get('/portfolio/instagram/delete', 'InstagramPortfolioController@delete');
		Route::get('/portfolio/instagram/callback', 'InstagramPortfolioController@redirect');
		Route::get('/portfolio/{portfolio}/edit', 'PortfolioController@edit')->name('edit_portfolio');
		Route::put('/portfolio/{portfolio}/update', 'PortfolioController@update')->name('update_portfolio');
		Route::get('/portfolio/{portfolio}/delete', 'PortfolioController@delete')->name('delete_portfolio');
		Route::get('/portfolio/{portfolio}/delete/ok', 'PortfolioController@deletePortfolio');
		Route::delete('/files/{file}', 'FileController@deleteFile');
		

		// Message Routes
		Route::get('/message', 'MessageController@index')->name('message');

		// Tasks Routes
		Route::get('/jobs', 'TaskController@index')->name('user_jobs');
		Route::get('/jobs/applications', 'TaskController@applications')->name('user_applications');
		Route::get('/jobs/add', 'TaskController@add')->name('add_task');
		Route::get('/jobs/saved', 'TaskController@savedJobs')->name('saved_task');
		Route::get('/jobs/{task}/edit', 'TaskController@edit')->name('edit_task');
		Route::get('/jobs/{task}/delete', 'TaskController@delete')->name('delete_task');
		Route::get('/jobs/{task}/delete/ok', 'TaskController@deleteOk')->name('delete_task_ok');
		Route::put('/jobs/{task}/update', 'TaskController@update')->name('update_task');
		Route::put('/jobs/{task}/reject', 'TaskController@rejectJob')->name('reject_task');
		Route::put('/jobs/{task}/approve', 'TaskController@approveJob')->name('approve_task');
		Route::post('/jobs/{task}/flag', 'TaskController@flagJob')->name('flag_task');
		Route::get('/jobs/{task}/flag/check', 'TaskController@flagJobCheck')->name('flag_task_check');
		Route::post('/jobs/{task}/save', 'TaskController@saveJob')->name('save_task');
		Route::get('/jobs/{task}/save/check', 'TaskController@saveCheckJob')->name('save_check_task');
		Route::get('/jobs/{task}/interests', 'TaskController@interests')->name('task_interest');
		Route::post('/jobs/add', 'TaskController@createTask')->name('create_task');
		Route::post('/jobs/application/response', 'TaskController@submitApplicationResponse');
		Route::post('/jobs/application/accept', 'TaskController@acceptApplication');

		// Service Requests Routes
		Route::get('/requests', 'ServiceRequestController@getServiceRequests')->name('requests');
		Route::get('/response/{request_id}', 'ServiceRequestController@getServiceRequestResponses');
		Route::post('/response/{request_id}', 'ServiceRequestController@postServiceRequestResponses');

		// Reviews
		Route::get('/reviews', 'UserProfileController@reviews')->name('reviews');

		// Identity Verification
		Route::get('/identity-verify', 'VerifyIdentityController@verify')->name('verify_identity');
		Route::post('/identity-verify', 'VerifyIdentityController@upload');

		// Profile Privacy Control
		Route::get('/set/{option}', 'UserProfileController@setAccountPrivacy');
		Route::get('/get-privacy', 'UserProfileController@getAccountPrivacy');

		// Delete Account
		Route::get('/delete', 'UserProfileController@deleteAccount');
		Route::get('/delete/proceed', 'UserProfileController@deleteAccountConfirm');
	});

	// Send Message Routes
	Route::get('/{user}/message', 'MessageController@message')->name('send_message');
	Route::post('/{user}/message', 'MessageController@sendMessage');
	Route::post('/message-reply', 'MessageController@replyMessage');
	Route::get('/message-replies/{id}', 'MessageController@messageReplies');

	// Followership Routes
	Route::post('/follower/{user}', 'FollowerController@addFollower');
	Route::delete('/follower/{user}', 'FollowerController@deleteFollower');

	// Reviews Routes
	Route::post('/reviews/{user}', 'UserReviewController@submitReview');

	// Service request routes
	Route::post('/services/{user}', 'ServiceRequestController@submitServiceRequests');

	// Submit Likes Route
	Route::post('/likes/{portfolio}', 'LikesController@add');
	Route::delete('/likes/{portfolio}', 'LikesController@remove');
});

// Verify User Email Account Route
Route::get('/verify', 'HomeController@verify')->name('verify');
Route::get('/verify/resend', 'HomeController@resendVerify')->name('resend_verify');
Route::get('/verify/{verify_key}', 'HomeController@verifyUser')->name('verify_user');

// Unsubscribe Routes
Route::get('/unsubscribe/invite-reminder/', 'UnsubscribeController@unsubscribeContactInviteReminder');

Route::get('/reviews/{user}', 'UserReviewController@reviews');
Route::get('/portfolio/{user}', 'PortfolioController@getPortfolioItems');

Route::get('/jobs', 'TaskController@allTasks')->name('tasks');
Route::get('/job/{task}/{slug}', 'TaskController@getTask')->name('task');
Route::get('/job/{task}/{slug}/apply', 'TaskController@applyForTask')->name('apply')->middleware('auth');
Route::post('/job/{task}/{slug}/apply', 'TaskController@submitApplicationForTask');

Route::get('/people', 'People@index')->name('people');

// Link account routes
Route::get('/account-merge', 'SocialAccountLinkupController@index')->name('merge_account');
Route::post('/account-merge', 'SocialAccountLinkupController@mergeAccounts');

// External Links
Route::get('/external-link', 'ExternalLinkController@index')->name('external_link');

Route::get('/social/{portfolio}/share', 'SocialShareController@portfolio')->name('portfolio_share');

Route::get('/{user}', 'People@profile')->name('view_profile');
Route::get('/{user}/hire', 'People@hire')->name('hire');
Route::get('/{user}/about', 'People@about')->name('about');
Route::get('/{user}/instagram', 'People@instagram')->name('instagram');
Route::get('/{user}/instagram/feed', 'People@instagramFeed')->name('instagram_feed');
Route::get('/{user}/portfolio/{portfolio}', 'PortfolioController@view')->name('view_portfolio');

Route::get('/autocomplete_cities/{cities}', 'HomeController@getCities');
Route::get('/skills/all', 'HomeController@getSkills');
Route::get('/skills/user', 'HomeController@getUserSkills');
Route::post('/skills/add', 'HomeController@addUserSkill');
Route::delete('/skills/delete/{skill}', 'HomeController@deleteUserSkill');

// Followers Route
Route::get('/follower/{user}', 'FollowerController@getFollowers');

// Likes Route
Route::get('/likes/{portfolio}', 'LikesController@get');













