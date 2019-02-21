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

Route::get('/email-broadcast', 'HomeController@trackEmail');
Route::post('/email-subscription', 'EmailSubscriptionController@emailSubscription');

Route::get('/about', 'PagesController@about');
Route::get('/showcase', 'PortfolioController@workPage')->name('showcase');
Route::get('/work/search', 'PortfolioController@workSearchPage')->name('work_search');
Route::get('/contact', 'PagesController@contact');
Route::get('/how-it-works', 'PagesController@works');
Route::get('/privacy', 'PagesController@privacy');
Route::get('/community', 'PagesController@community');
Route::get('/points', 'PagesController@points')->name('points');

// Track User Activity
Route::post('/tracker/add', 'UserTrackerController@addPageActivity');

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
Route::get('/portfolio/{portfolio}/files', 'PortfolioController@getFiles');

Route::get('/invite', 'InviteContactController@index')->name('gmail_invite');
Route::get('/invite/gmail', 'InviteContactController@gmailContactInvite');
Route::post('/invite/gmail', 'InviteContactController@gmailContactInviteRequest');
Route::get('/invite/success', 'InviteContactController@thankYou');

Route::get('/logout', 'HomeController@logout')->name('logout');

Route::group(['middleware'=>'auth'], function(){

	Route::post('/push_notification', 'PushNotificationController@subscribe');

	Route::get('/invite/delete', 'InviteContactController@deleteInvites')->name('delete_invites')->middleware('admin');
	Route::post('/invite/delete', 'InviteContactController@delete')->middleware('admin');
	

	Route::post('/comment/{comment}/like', 'CommentController@likeComment');
	Route::delete('/comment/{comment}/delete', 'CommentController@deleteComment');

	// Admin route groups
	Route::group(['prefix'=>'admin', 'middleware' => ['admin']], function(){
		Route::post('/{portfolio}/make-featured', 'PortfolioController@makeFeaturedPortfolio');
	});

	Route::group(['prefix'=>'dashboard'], function(){
		// send contact reminder
		Route::post('/send-reminder', 'InviteContactController@sendReminder')->middleware('admin');

		Route::get('/', 'HomeController@index')->middleware('user_profile_setup')->name('dashboard');
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

		Route::get('/linkedin_upload', 'LinkedinContactController@index')->name('linkedin_contacts');
		Route::post('/linkedin_upload/submit', 'LinkedinContactController@upload')->name('submit_linkedin_contacts');
		Route::post('/linkedin_upload/delete', 'LinkedinContactController@delete')->name('delete_linkedin_contacts');

		// Upload background image
		Route::post('/upload', 'HomeController@uploadBackgroundImage');

		// Send email broadcast to members
		Route::match(['get', 'post'], '/email-broadcast', 'HomeController@emailBroadcast')->middleware('admin')->name('email_broadcast');

		/*
		*	Portfolio links
		*/

		Route::group(['prefix'=>'portfolio'], function(){
			Route::get('/', 'PortfolioController@index')->name('portfolio_index');
			Route::match(['get', 'post'], '/new', 'PortfolioController@add')->name('new_portfolio')->middleware(['profile', 'skills']);
			Route::get('/likes', 'PortfolioController@myLikedPortfolios')->name('portfolio_likes');
			// Route::post('/thumbnail', 'PortfolioController@savePortfolioThumbnail');
			// Route::post('/add-thumbnail', 'PortfolioController@addPortfolioThumbnail');

			// Route::post('/file-upload', 'PortfolioController@fileUpload');
			Route::delete('/{portfolio}/{file}/delete', 'PortfolioController@deleteFileUpload');

			// Route::get('/instagram', 'InstagramPortfolioController@index')->name('instagram_index');
			// Route::get('/instagram/get', 'InstagramPortfolioController@get');
			// Route::get('/instagram/delete', 'InstagramPortfolioController@delete');
			// Route::get('/instagram/callback', 'InstagramPortfolioController@redirect');
			Route::match(['get', 'put', 'delete'], '/{portfolio}/edit', 'PortfolioController@edit')->name('edit_portfolio');
			// Route::put('/{portfolio}/update', 'PortfolioController@update')->name('update_portfolio');
			Route::get('/{portfolio}/delete', 'PortfolioController@delete')->name('delete_portfolio');
			Route::get('/{portfolio}/delete/ok', 'PortfolioController@deletePortfolio');
			Route::delete('/{portfolio}/files/{file}/delete', 'FileController@deleteFile');
		});

		

		/*
		*	Profile links
		*/

		Route::group(['prefix'=>'profile'], function(){

			Route::get('/edit', 'UserProfileController@edit')->name('edit_profile');
			Route::put('/edit', 'UserProfileController@store');
			Route::post('/upload-image', 'UserProfileController@uploadImage');
			Route::post('/biography', 'UserProfileController@biography');

			// Route::get('/phone', 'UserProfileController@phoneIndex')->name('phone');

			// Route::get('/phone/add', 'UserProfileController@phoneAdd')->name('add_phone');
			// Route::post('/phone/add', 'UserProfileController@phoneAddNew');

			// Route::get('/phone/{phone}/edit', 'UserProfileController@phoneEdit')->name('edit_phone');
			// Route::post('/phone/{phone}/edit', 'UserProfileController@phoneEditSave')->name('edit_phone');

			// Route::get('/phone/{phone}/delete', 'UserProfileController@phoneDelete')->name('delete_phone');
			// Route::post('/phone/{phone}/delete', 'UserProfileController@phoneDeleteSubmit')->name('delete_phone');
			// Message Routes
			// Route::get('/message', 'MessageController@index')->name('message');
			// Service Requests Routes
			// Route::get('/requests', 'ServiceRequestController@getServiceRequests')->name('requests');
			// Route::get('/response/{request_id}', 'ServiceRequestController@getServiceRequestResponses');
			// Route::post('/response/{request_id}', 'ServiceRequestController@postServiceRequestResponses');

			// Reviews
			Route::get('/reviews', 'UserProfileController@reviews')->name('reviews');

			// Identity Verification
			Route::match(['get', 'post'], '/verify-identity', 'VerifyIdentityController@verify')->name('verify_identity');
			// Route::post('/verify-identity', 'VerifyIdentityController@upload');

			// Delete Account
			Route::get('/delete', 'UserProfileController@deleteAccount');
			Route::get('/delete/proceed', 'UserProfileController@deleteAccountConfirm');
		});

		// BLOG ROUTES
		Route::group(['prefix'=>'blog'], function(){
			Route::get('/', 'BlogController@userBlog')->name('blog');
			Route::match(['get', 'post'], '/new', 'BlogController@handleBlogForm')->name('add_blog');
			Route::match(['get', 'put', 'delete'], '/{blog}/edit', 'BlogController@editBlogPost')->middleware('can:update-blog,blog')->name('edit_blog');
			Route::delete('/{blog}/delete', 'BlogController@deleteBlog')->middleware('can:update-blog,blog')->name('delete_blog');
			Route::get('/subscribers', 'BlogController@subscribers')->name('subscribers');
			Route::post('/subscribe/{blog}/subscribe-user', 'BlogController@subscribeRegisteredUser');
			Route::post('/subscribe/{blog}/check', 'BlogController@checkBlogSubscription');
			Route::post('/like/{blog}/submit', 'BlogController@submitBlogLike');
			Route::post('/{blog}/comment', 'BlogController@submitComment');
			Route::post('/{blog}/comment/reply', 'BlogController@submitCommentReply');
			Route::post('/{blog}/comment/{comment}/like', 'BlogController@submitCommentLike');
			Route::post('/image-upload', 'BlogController@imageUpload');
		});

		Route::group(['prefix'=>'enquiries'], function(){
			Route::match(['get', 'put'], '/', 'EnquiryController@enquiries')->name('enquiries');
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
}); /* End of auth middleware */

Route::get('/blog/like/{blog}/check', 'BlogController@checkBlogLike');
Route::get('/blog/like/{blog}/count', 'BlogController@countBlogLike');
Route::get('/blog/{blog}/comments/count', 'BlogController@commentCount');
Route::get('/blog/{user}/{blog}/{slug}', 'BlogController@viewBlogPost')->name('view_blog');
Route::post('/blog/subscribe/{blog}/visitor', 'BlogController@subscribeVisitor');

// Verify User Email Account Route
Route::get('/verify', 'HomeController@verify')->name('verify');
Route::get('/verify/resend', 'HomeController@resendVerify')->name('resend_verify');
Route::get('/verify/{verify_key}', 'HomeController@verifyUser')->name('verify_user');

// Unsubscribe Routes
Route::get('/unsubscribe/invite-reminder/', 'UnsubscribeController@unsubscribeContactInviteReminder');

Route::get('/reviews/{user}', 'UserReviewController@reviews');
Route::get('/portfolio/{user}', 'PortfolioController@getPortfolioItems');

Route::get('/people/{page?}', 'People@index')->name('people');

// Link account routes
Route::get('/account-merge', 'SocialAccountLinkupController@index')->name('merge_account');
Route::post('/account-merge', 'SocialAccountLinkupController@mergeAccounts');

// External Links
// Route::get('/external-link', 'ExternalLinkController@index')->name('external_link');

Route::get('/social/{portfolio}/share', 'SocialShareController@portfolio')->name('portfolio_share');

Route::get('/{user}', 'People@profile')->name('view_profile');
Route::get('/{user}/hire', 'People@hire')->name('hire');

// Enquiry form
Route::match(['get', 'post'], '/{user}/enquiry', 'EnquiryController@form')->name('make_enquiry');
// Route::get('/{user}/contact-request', 'ContactRequestController@index')->name('contact_request');
// Route::post('/{user}/contact-request/submit', 'ContactRequestController@submit')->name('contact_request_post');
// Route::get('/{user}/contact-request/status', 'ContactRequestController@status')->name('contact_request_status');

// Route::get('/{user}/instagram', 'People@instagram')->name('instagram');
// Route::get('/{user}/instagram/feed', 'People@instagramFeed')->name('instagram_feed');
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

// Track social shares
Route::post('/blog/track-social-shares', 'BlogController@trackSocialShares');











