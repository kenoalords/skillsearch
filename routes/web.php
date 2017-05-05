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

Route::get('/', 'PortfolioController@homepagePortfolio');

Route::get('/search', 'SearchController@searchProfiles');

Route::get('/about', 'PagesController@about');
Route::get('/contact', 'PagesController@contact');
Route::get('/how-it-works', 'PagesController@works');
Route::get('/privacy', 'PagesController@privacy');

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

Route::group(['middleware'=>'auth'], function(){

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

		Route::get('/portfolio', 'PortfolioController@index');
		Route::get('/portfolio/add', 'PortfolioController@add');
		Route::post('/portfolio/add', 'PortfolioController@savePortfolio');
		Route::post('/portfolio/thumbnail', 'PortfolioController@savePortfolioThumbnail');
		Route::get('/portfolio/instagram', 'InstagramPortfolioController@index');
		Route::get('/portfolio/instagram/get', 'InstagramPortfolioController@get');
		Route::get('/portfolio/instagram/callback', 'InstagramPortfolioController@redirect');
		Route::get('/portfolio/{portfolio}/edit', 'PortfolioController@edit')->name('edit_portfolio');
		Route::put('/portfolio/{portfolio}/update', 'PortfolioController@update')->name('update_portfolio');
		Route::get('/portfolio/{portfolio}/delete', 'PortfolioController@delete')->name('delete_portfolio');
		Route::get('/portfolio/{portfolio}/delete/ok', 'PortfolioController@deletePortfolio');
		Route::delete('/files/{file}', 'FileController@deleteFile');
		

		// Message Routes
		Route::get('/message', 'MessageController@index')->name('message');

		// Tasks Routes
		Route::get('/tasks', 'TaskController@index')->name('user_tasks');
		Route::get('/tasks/add', 'TaskController@add')->name('add_task');
		Route::get('/tasks/{task}/edit', 'TaskController@edit')->name('edit_task');
		Route::put('/tasks/{task}/update', 'TaskController@update')->name('update_task');
		Route::post('/tasks/add', 'TaskController@createTask')->name('create_task');

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

Route::get('/reviews/{user}', 'UserReviewController@reviews');
Route::get('/portfolio/{user}', 'PortfolioController@getPortfolioItems');

Route::get('/tasks', 'TaskController@allTasks')->name('tasks');
Route::get('/tasks/{task}/{slug}', 'TaskController@getTask')->name('task');

Route::get('/people', 'People@index')->name('people');

// Link account routes
Route::get('/account-merge', 'SocialAccountLinkupController@index')->name('merge_account');
Route::post('/account-merge', 'SocialAccountLinkupController@mergeAccounts');

// External Links
Route::get('/external-link', 'ExternalLinkController@index')->name('external_link');

Route::get('/social/{portfolio}/share', 'SocialShareController@portfolio')->name('portfolio_share');

Route::get('/{user}', 'People@profile')->name('view_profile');
Route::get('/{user}/hire', 'People@hire')->name('hire');
Route::get('/{user}/portfolio/{portfolio}', 'PortfolioController@view')->name('view_portfolio');

Route::get('/autocomplete_cities/{cities}', 'HomeController@getCities');
Route::get('/skills/all', 'HomeController@getSkills');
Route::get('/skills/user', 'HomeController@getUserSkills');
Route::post('/skills/add', 'HomeController@addUserSkill');
Route::delete('/skills/delete/{skill}', 'HomeController@deleteUserSkill');

Route::get('/verify', 'HomeController@verify')->name('verify');

Route::get('/verify/{verify_key}', 'HomeController@verifyUser')->name('verify_user');

// Followers Route
Route::get('/follower/{user}', 'FollowerController@getFollowers');

// Likes Route
Route::get('/likes/{portfolio}', 'LikesController@get');













