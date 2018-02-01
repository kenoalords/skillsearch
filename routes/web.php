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
Route::get('/load-portfolio/{page?}/{limit?}', 'PortfolioController@homepagePortfolioAjax');

Route::get('/search', 'SearchController@searchPortfolios');
Route::get('/search/jobs', 'SearchController@searchJobs')->name('job_search');

Route::get('/about', 'PagesController@about');
Route::get('/showcase', 'PortfolioController@workPage')->name('showcase');
Route::get('/work/search', 'PortfolioController@workSearchPage')->name('work_search');
Route::get('/contact', 'PagesController@contact');
Route::get('/how-it-works', 'PagesController@works');
Route::get('/privacy', 'PagesController@privacy');
Route::get('/points', 'PagesController@points')->name('points');

// Gigs Route
Route::get('/gigs', 'GigsController@gigs')->name('gigs');
Route::get('/gig/{gig}/{slug?}', 'GigsController@viewGig')->name('gig');

// Cart Routes
Route::get('/cart', 'CartController@cart')->name('cart');
Route::get('/cart/checkout', 'CartController@checkout')->name('checkout');
Route::get('/cart/{gig}/add', 'CartController@addToCart')->name('add_to_cart');
Route::get('/cart/{gig}/delete', 'CartController@deleteFromCart')->name('delete_from_cart');

// Payment Routes
Route::post('/pay', 'PaymentController@redirectToGateway')->name('pay');
Route::get('/payment/callback', 'PaymentController@handleGatewayCallback');

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

Route::get('/logout', 'HomeController@logout');

Route::group(['middleware'=>'auth'], function(){

	Route::get('/invite/delete', 'InviteContactController@deleteInvites')->name('delete_invites')->middleware('is_admin');
	Route::post('/invite/delete', 'InviteContactController@delete')->middleware('is_admin');

	Route::post('/comment/{comment}/like', 'CommentController@likeComment');
	Route::delete('/comment/{comment}/delete', 'CommentController@deleteComment');

	Route::group(['prefix'=>'dashboard'], function(){
		// send contact reminder
		Route::post('/send-reminder', 'InviteContactController@sendReminder')->middleware('is_admin');

		Route::get('/', 'HomeController@index')->middleware('user_profile_setup');
		Route::get('/start', 'UserProfileController@setupUserProfile')->name('start');
		Route::post('/start', 'UserProfileController@saveSocialUserProfile');

		Route::get('/referral', 'ReferralCodeController@index')->name('referral');
		Route::get('/referral/generate', 'ReferralCodeController@generate');

		Route::get('/start-twitter', 'UserProfileController@setupTwitterUserProfile')->name('start_twitter');
		Route::post('/start-twitter', 'UserProfileController@saveTwitterSocialUserProfile');

		Route::get('/load-activity/{page}/{limit}', 'HomeController@loadActivitiesAjax');

		Route::get('/start/skills', 'UserProfileController@setupUserSkills');
		Route::get('/users-verify', 'UserProfileController@verifyUserAccounts')->name('verify_user_accounts');
		Route::get('/users', 'UserProfileController@getVerifyUserAccounts');
		Route::post('/users/cancel', 'UserProfileController@cancelUserVerifyRequest');
		Route::post('/users/ok', 'UserProfileController@approveUserVerifyRequest');
		Route::get('/jobs', 'TaskController@approveJobs')->name('approve_jobs');
		Route::get('/linkedin_upload', 'LinkedinContactController@index')->name('linkedin_contacts');
		Route::post('/linkedin_upload/submit', 'LinkedinContactController@upload')->name('submit_linkedin_contacts');
		Route::post('/linkedin_upload/delete', 'LinkedinContactController@delete')->name('delete_linkedin_contacts');
		Route::get('/contact-requests', 'ContactRequestController@requests')->name('user_contact_requests');
		Route::post('/contact-requests/{contact_request}/approve', 'ContactRequestController@approveRequest');

		// Upload background image
		Route::post('/upload', 'HomeController@uploadBackgroundImage');

		// Send email broadcast to members
		Route::get('/email-broadcast', 'HomeController@membersEmailBroadcast');
		Route::post('/email-broadcast', 'HomeController@submitEmailBroadcast');

		/*
		*	Portfolio links
		*/

		Route::group(['prefix'=>'portfolio'], function(){
			Route::get('/', 'PortfolioController@index')->name('portfolio_index');
			Route::get('/add', 'PortfolioController@add')->name('portfolio_add');
			Route::get('/likes', 'PortfolioController@myLikedPortfolios')->name('portfolio_likes');
			Route::post('/add', 'PortfolioController@savePortfolio')->name('portfolio_add');
			Route::post('/{portfolio}/make-featured', 'PortfolioController@makeFeaturedPortfolio');
			Route::post('/thumbnail', 'PortfolioController@savePortfolioThumbnail');
			Route::post('/add-thumbnail', 'PortfolioController@addPortfolioThumbnail');

			Route::post('/file-upload', 'PortfolioController@fileUpload');
			Route::delete('/file-upload/{portfolio}/{file}/delete', 'PortfolioController@deleteFileUpload');

			Route::get('/instagram', 'InstagramPortfolioController@index')->name('instagram_index');
			Route::get('/instagram/get', 'InstagramPortfolioController@get');
			Route::get('/instagram/delete', 'InstagramPortfolioController@delete');
			Route::get('/instagram/callback', 'InstagramPortfolioController@redirect');
			Route::get('/{portfolio}/edit', 'PortfolioController@edit')->name('edit_portfolio');
			Route::put('/{portfolio}/update', 'PortfolioController@update')->name('update_portfolio');
			Route::get('/{portfolio}/delete', 'PortfolioController@delete')->name('delete_portfolio');
			Route::get('/{portfolio}/delete/ok', 'PortfolioController@deletePortfolio');
			Route::delete('/files/{file}', 'FileController@deleteFile');
		});

		Route::group(['prefix'=>'jobs'], function(){
			// Tasks Routes
			Route::get('/', 'TaskController@index')->name('user_jobs');
			Route::get('/applications', 'TaskController@applications')->name('user_applications');
			Route::get('/add', 'TaskController@add')->name('add_task');
			Route::get('/saved', 'TaskController@savedJobs')->name('saved_task');
			Route::get('/{task}/edit', 'TaskController@edit')->name('edit_task');
			Route::get('/{task}/delete', 'TaskController@delete')->name('delete_task');
			Route::get('/{task}/delete/ok', 'TaskController@deleteOk')->name('delete_task_ok');
			Route::put('/{task}/update', 'TaskController@update')->name('update_task');
			Route::put('/{task}/reject', 'TaskController@rejectJob')->name('reject_task');
			Route::put('/{task}/approve', 'TaskController@approveJob')->name('approve_task');
			Route::post('/{task}/flag', 'TaskController@flagJob')->name('flag_task');
			Route::get('/{task}/flag/check', 'TaskController@flagJobCheck')->name('flag_task_check');
			Route::post('/{task}/save', 'TaskController@saveJob')->name('save_task');
			Route::get('/{task}/save/check', 'TaskController@saveCheckJob')->name('save_check_task');
			Route::get('/{task}/interests', 'TaskController@interests')->name('task_interest');
			Route::post('/add', 'TaskController@createTask')->name('create_task');
			Route::post('/application/response', 'TaskController@submitApplicationResponse');
			Route::post('/application/accept', 'TaskController@acceptApplication');
		});

		/*
		*	Profile links
		*/

		Route::group(['prefix'=>'profile'], function(){

			Route::get('/edit', 'UserProfileController@edit')->name('edit_profile');
			Route::put('/edit', 'UserProfileController@store');
			Route::post('/upload-image', 'UserProfileController@uploadImage');

			Route::get('/phone', 'UserProfileController@phoneIndex')->name('phone');

			Route::get('/phone/add', 'UserProfileController@phoneAdd')->name('add_phone');
			Route::post('/phone/add', 'UserProfileController@phoneAddNew');

			Route::get('/phone/{phone}/edit', 'UserProfileController@phoneEdit')->name('edit_phone');
			Route::post('/phone/{phone}/edit', 'UserProfileController@phoneEditSave')->name('edit_phone');

			Route::get('/phone/{phone}/delete', 'UserProfileController@phoneDelete')->name('delete_phone');
			Route::post('/phone/{phone}/delete', 'UserProfileController@phoneDeleteSubmit')->name('delete_phone');
			
			
			

			// Message Routes
			Route::get('/message', 'MessageController@index')->name('message');

			

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

			// BLOG ROUTES
			Route::get('/blog', 'BlogController@userBlog');
			Route::get('/blog/add', 'BlogController@addBlogPost');
			Route::post('/blog/add', 'BlogController@submitBlogPost');
			Route::get('/blog/{blog}/edit', 'BlogController@editBlogPost');
			Route::post('/blog/add/image', 'BlogController@submitBlogPostImage');

			
		});

		/*
		*	Gigs Routes
		*/

		Route::group(['prefix'=>'gigs'], function(){
			// GIGS
			Route::get('/', 'GigsController@index')->name('user_gigs');
			Route::get('/add', 'GigsController@add')->name('add_gig');
			Route::post('/add', 'GigsController@submit')->name('add_gig');
		});
	});
	
	

	
	
	// Subscribe Registered User To Blog
	Route::post('/blog/subscribe/{blog}/user', 'BlogController@subscribeRegisteredUser');
	Route::post('/blog/subscribe/{blog}/check', 'BlogController@checkBlogSubscription');
	Route::get('/blog/like/{blog}/check', 'BlogController@checkBlogLike');
	Route::post('/blog/like/{blog}/submit', 'BlogController@submitBlogLike');

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

Route::post('/blog/subscribe/{blog}/visitor', 'BlogController@subscribeVisitor');

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

Route::get('/people/{page?}', 'People@index')->name('people');

// Link account routes
Route::get('/account-merge', 'SocialAccountLinkupController@index')->name('merge_account');
Route::post('/account-merge', 'SocialAccountLinkupController@mergeAccounts');

// External Links
Route::get('/external-link', 'ExternalLinkController@index')->name('external_link');

Route::get('/social/{portfolio}/share', 'SocialShareController@portfolio')->name('portfolio_share');

Route::get('/{user}', 'People@profile')->name('view_profile');
Route::get('/{user}/hire', 'People@hire')->name('hire');

// CONTACT REQUEST
Route::get('/{user}/contact-request', 'ContactRequestController@index')->name('contact_request');
Route::post('/{user}/contact-request/submit', 'ContactRequestController@submit')->name('contact_request_post');
Route::get('/{user}/contact-request/status', 'ContactRequestController@status')->name('contact_request_status');

Route::get('/{user}/instagram', 'People@instagram')->name('instagram');
Route::get('/{user}/instagram/feed', 'People@instagramFeed')->name('instagram_feed');
Route::get('/{user}/portfolio/{portfolio}', 'PortfolioController@view')->name('view_portfolio');
Route::get('/{user}/blog/{blog}/{slug}', 'BlogController@singleBlog')->name('blog');

Route::get('/autocomplete_cities/{cities}', 'HomeController@getCities');
Route::get('/skills/all', 'HomeController@getSkills');
Route::get('/skills/user', 'HomeController@getUserSkills');
Route::post('/skills/add', 'HomeController@addUserSkill');
Route::delete('/skills/delete/{skill}', 'HomeController@deleteUserSkill');

// Followers Route
Route::get('/follower/{user}', 'FollowerController@getFollowers');

// Likes Route
Route::get('/likes/{portfolio}', 'LikesController@get');













