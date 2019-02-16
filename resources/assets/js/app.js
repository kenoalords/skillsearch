
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example', require('./components/Example.vue'));
// Vue.component('referral-code', require('./components/ReferralCode.vue').default);
// Vue.component('referral', require('./components/Referral.vue').default);
// Vue.component('contact-request', require('./components/ContactRequest.vue').default);
Vue.component('comments', require('./components/Comments.vue').default);
Vue.component('skills', require('./components/Skills.vue').default);
Vue.component('upload-image', require('./components/UploadProfileImage.vue').default);
// Vue.component('portfolio-form', require('./components/PortfolioForm.vue').default);
Vue.component('portfolio-upload-form', require('./components/PortfolioUploadForm.vue').default);
// Vue.component('message', require('./components/Message.vue').default);
// Vue.component('send-message', require('./components/SendMessage.vue').default);
Vue.component('follow', require('./components/Follow.vue').default);
Vue.component('Biography', require('./components/Biography.vue').default);
// Vue.component('reviews', require('./components/Review.vue').default);
Vue.component('portfolio', require('./components/Portfolio.vue').default);
// Vue.component('request-service', require('./components/RequestService.vue').default);
Vue.component('requests', require('./components/Requests.vue').default);
Vue.component('user-background', require('./components/UserBackground.vue').default);
Vue.component('like-button', require('./components/LikeButton.vue').default);
// Vue.component('privacy-toggle', require('./components/PrivacyToggle.vue').default);
Vue.component('portfolio-comments', require('./components/PortfolioComments.vue').default);
Vue.component('register-view', require('./components/Views.vue').default);
// Vue.component('application-actions', require('./components/ApplicationActions.vue').default);
Vue.component('video-player', require('./components/VideoPlayer.vue').default);
Vue.component('blog-form', require('./components/BlogForm.vue').default);
Vue.component('verify-users', require('./components/VerifyUsers.vue').default);
// Vue.component('task-form-apply', require('./components/TaskFormApply.vue').default);
// Vue.component('job-actions', require('./components/JobActions.vue').default);
// Vue.component('flag-job', require('./components/FlagJob.vue').default);
// Vue.component('save-job', require('./components/SaveJob.vue').default);
Vue.component('blog-like', require('./components/BlogLike.vue').default);
Vue.component('blog-subscribe', require('./components/BlogSubscribe.vue').default);
// Vue.component('phone-number', require('./components/PhoneNumber.vue').default);
Vue.component('portfolio-list', require('./components/PortfolioList.vue').default);
Vue.component('portfolio-item', require('./components/PortfolioItem.vue').default);
// Vue.component('gig-form', require('./components/GigForm.vue').default);
Vue.component('featured', require('./components/Featured.vue').default);
Vue.component('send-reminder', require('./components/SendReminder.vue').default);
Vue.component('blog-comment', require('./components/BlogComment.vue').default);
Vue.component('enquiry', require('./components/Enquiry.vue').default);
Vue.component('email-broadcast', require('./components/EmailBroadcast.vue').default);
Vue.component('email-subscription', require('./components/EmailSubscription.vue').default);
Vue.component('notification', require('./components/Notification.vue').default);
Vue.component('tracker', require('./components/Tracker.vue').default);

const app = new Vue({
    el: '#app',

    data(){
    	return {

    	}
    },

    methods: {
    	
    },
    mounted(){
    	
    }
});

$('.slick-js').slick({
	infinite: true,
	slidesToShow: 4,
	slidesToScroll: 1,
	autoplay: true,
	autoplaySpeed: 3000,
	responsive: [{

		breakpoint: 1240,
			settings: {
			slidesToShow: 3,
			infinite: true
			}

		}, {

		breakpoint: 960,
		settings: {
			slidesToShow: 2,
		}

		}, {

		breakpoint: 481,
		settings: {
			slidesToShow: 1,
		}
	}], 
});

let userPrompt = null;
window.addEventListener("beforeInstallPrompt", function(e){
	e.preventDefault();
	userPrompt = e;
	return;
});

$('body').on('click tap', '#mobile-menu-tigger', (e) => {
	e.preventDefault();
	if ( userPrompt !== null ){
		let confirm = confirm("Would you like to add Ubanji to your home screen for easy access?");
		if ( confirm === true ){
			userPrompt.prompt();
			userPrompt = null;
		} else {
			$('.slide-in-menu').addClass('is-active');
			return;
		}
	}
	$('.slide-in-menu').addClass('is-active');
});

$('body').on('click tap', '.close-slide-in-menu', (e) => {
	e.preventDefault();
	$('.slide-in-menu').removeClass('is-active');
});


var bLazy = new Blazy({
	offset: 0
});

// $('.with-popup').popup();
// var waypoint = new Waypoint();

$('body').on('click', '#google-invite', function(e){
	$('body').addClass('loading');
});


$('body').on('click', '#delete-instagram', function(e){
	if(!confirm('Are you sure you want to delete this Instagram account? This action cannot be undone.')){
		return false;
	}
})
.on('click', '#close-instagram-notification', function(e){
	e.preventDefault();
	$('#instagram-notification').slideUp('fast');
})
.on('click', '#admin-menu-trigger', function(e){
	e.preventDefault();
	$(window).scrollTop(0);
	$(this).toggleClass('is-active');
	$('#sidebar').toggleClass('is-hidden-touch');
})
.on('click', '#app-menu-tigger', function(e){
	e.preventDefault();
	$(window).scrollTop(0);
	$(this).toggleClass('is-active');
	$('.navbar-menu').toggleClass('is-active');
});

$('body').on('click', '#get-location', function(e){
	e.preventDefault();
	UserLocation.getLocation();
});

var UserLocation = {
	getLocation: function(){
		var pos;
		if(UserLocation.canGeolocate){
			pos = navigator.geolocation.getCurrentPosition(function(position){
				console.log(position);
			});
		} else {
			alert('Sorry your browser does not support this feature');
		}
	},
	canGeolocate: function(){
		return ("geolocation" in navigator) ? true : false;
	},
}

var Portfolio = {
	loadActivities: function(){
		var btn = document.getElementById('load-more-activity'),
			id = btn.dataset.page,
			limit = btn.dataset.limit;
		$(btn).addClass('loading');
		axios.get('/home/load-activity/'+id+'/'+limit).then(function(response){
			if(response.data.html){
				$('#user-portfolio-activity').append(response.data.html);
				$(btn).removeClass('loading')
				btn.dataset.page = parseInt(id) + 1;
			}
		}).catch( (error) => {
			$(btn).hide();
		});
	}
}

var UserProfiles = {
	loadDefault: function(){
		var btn = document.getElementById("get-more-users"),
			id = btn.dataset.page,
			container = document.getElementById("peoples-list");
		$(btn).addClass('loading');
		axios.get('/people/'+id).then( (response) => {
			$(btn).removeClass('loading');
			$(container).append(response.data.html);
			btn.dataset.page = parseInt(id) + 1;
		}).catch( (error) => {
			$(btn).hide();
		});
	}
}

// import waypoint from "waypoints/src/waypoint";

$('body').on('click', '#load-more-activity', function(e){
	e.preventDefault();
	Portfolio.loadActivities();
});

$('body').on('click', '#get-more-users', function(e){
	e.preventDefault();
	UserProfiles.loadDefault();
});


try{
	var waypoints = new Waypoint({
	     element: document.getElementById('social-share'),
		handler: function(direction){
			// console.log(direction);
			var status = sessionStorage.getItem('modal');
			var url = window.location.href;
			var sharedUrl = sessionStorage.getItem('url');
			if ( direction === 'down' && status == null && sharedUrl !== url ){
				$('#social-share').find('.modal').addClass('is-active');
				$('body').on('click', '.close-share-modal', function(e){
					e.preventDefault();
					sessionStorage.setItem('modal', 'dismissed');
					$(this).parents('.modal').removeClass('is-active');
				}).find('.share-links').on('click', 'a', function(e){
					
					var data = {
						network: $(this).attr('class'),
						url: url,
						agent: navigator.userAgent,
					}
					axios.post('/blog/track-social-shares', data).then( (response)=>{
						sessionStorage.setItem('url', url);
					} ).catch( (e)=>{
						console.log(e);
					} );
					$(this).parents('.modal').removeClass('is-active');
				});
				waypoints.disable();
			}
		},
		offset: "100%"
	});
} catch(e){
	// console.log(e);
}

$('body').on('click', '.dropdown-trigger a', function(e){
	e.preventDefault();
	$(this).parents('.dropdown').toggleClass('is-active');
});

if( $('.user-links').length > 0 ){
	$('.user-links').on('click', '.delete-portfolio', function(e){
		e.preventDefault();
		$('body').addClass('is-loading');
		var $this = $(this);
		var uid = $this.data('uid');
		if ( window.confirm("Are you sure you want to delete this portfolio? This action cannot be undone.") ){
			axios.delete('/dashboard/portfolio/'+ uid +'/edit').then( response => {
				if ( response.data === true ){
					$this.closest('.column').remove();
					$('body').removeClass('is-loading');
					iziToast.success({ title: 'Portfolio deleted successfully.' })
				} else {
					$('body').removeClass('is-loading');
					iziToast.error({ title: 'Portfolio deleted failed.' });
				}
			} ).catch( e => {
				$('body').removeClass('is-loading');
				iziToast.error({ title: 'Something went wrong.' });
			})
		} else {
			$('body').removeClass('is-loading');
			return;
		}
	});
}

if ( $('.homepage-tabs').length > 0 ){
	var tablink = $('.homepage-tabs').find('li'),
		index = 0,
		tabs = $('#tabs').find('li');
	tablink.each(function(i, el) {
		if ( $(el).hasClass('is-active') ){
			index = i;
		}
		$(el).on('click', function(e){
			tabs.each(function(index, el) {
				$(el).removeClass('is-active');
			});
			tablink.each(function(index, el) {
				$(el).removeClass('is-active');
			});
			$(el).addClass('is-active');
			tabs.eq(i).addClass('is-active');
			var bLazy = new Blazy({
				offset: 0
			});
		});
	});
	tabs.eq(index).addClass('is-active');
}

if ( $('.blog-excerpt').length > 0 ){
	$('.blog-excerpt').find('.delete-blog').each(function(index, el){
		$(el).on('click', function(e){
			var id = $(this).data('id');
			var data = { _method: 'delete' };
			$('body').addClass('is-loading');
			var confirm = window.confirm("Are you sure you want to delete this blog post? This action cannot be undone");
			if ( confirm ){
				axios.delete('/dashboard/blog/' + id + '/delete', data).then( (response) => {
					if ( response.data === true ){
						$(el).closest('.blog-excerpt').remove();
						iziToast.success({ title: 'Blog post deleted successfully.' })
					} else {
						iziToast.error({ title: 'Error occured while deleting blog post.' })
					}
					$('body').removeClass('is-loading');
					// console.log(response);
				} ).catch ( error => $('body').removeClass('is-loading') );
			} else {
				return;
			}
		})
	});
}
let isSearchOpen = false;
$('body').on('click tap', '#search-trigger', function(e){
	e.preventDefault();
	if ( !isSearchOpen ){
		$(this).find('i').removeClass('fa-search').addClass('fa-times');
		$('.search-wrapper').addClass('is-active');
		isSearchOpen = true;
	} else {
		$(this).find('i').removeClass('fa-times').addClass('fa-search');
		$('.search-wrapper').removeClass('is-active');
		isSearchOpen = false;
	}
});

const webpush = require("web-push");
// const vapidKeys = webpush.generateVAPIDKeys();
vapidPublicKey = "BN7vMXUSxoinsYZ0wSm9NfGt7D17FRuniWGqH0LqcpJ1eDK7mGhcbmNIZffzDtPo1sMSOV2FilOnmBh7RGKz2SE=";


function urlB64ToUint8Array(base64String) {
   const padding = '='.repeat((4 - base64String.length % 4) % 4);
   const base64 = (base64String + padding)
                   .replace(/\-/g, '+')
                   .replace(/_/g, '/');

   const rawData = window.atob(base64);
   const outputArray = new Uint8Array(rawData.length);

   for (let i = 0; i < rawData.length; ++i) {
       outputArray[i] = rawData.charCodeAt(i);
   }
   return outputArray;
}
const vapidPublicKeyConverted = urlB64ToUint8Array(vapidPublicKey);
let sw;
if ( 'serviceWorker' in navigator ){
	navigator.serviceWorker.register('/service-worker.js', { scope: '/' }).then( (registration) => {
		console.log(registration.scope);
		sw = registration;
		if ( window.Laravel.userLoggedIn === true ){
			sw.pushManager.getSubscription().then( (subscription) => {
				// Subscription is null
				if ( subscription === null ){
					$('.push-notification-modal').addClass('is-active');
					$('body').on('click tap', '.push-notification', function(e){
						$('body').addClass('is-loading');
						sw.pushManager.subscribe({
							userVisibleOnly: true,
							applicationServerKey: vapidPublicKeyConverted
						}).then( (subscription) => {
							localStorage.setItem('push_notification', true);
							let data = {
								endpoint: JSON.stringify(subscription)
							}

							axios.post('/push_notification', data).then( (response) => {
								$('body').removeClass('is-loading');
								if ( $('.slide-in-menu').hasClass('is-active') ){
									$('.slide-in-menu').removeClass('is-active')
								}
								$('.push-notification-modal').removeClass('is-active');
								iziToast.success({ title: "You have successfully subscribed for notification" });
							}).catch( (error) => {
								$('body').removeClass('is-loading');
								localStorage.setItem('push_notification', false);
							});

						}).catch( (error) => {
							iziToast.error({ title: "Notification subscription unsuccessful" });
							$('body').removeClass('is-loading');
							console.log(error);
						})
					});
				} else {
					// console.log(subscription)
				}

			}).catch( (error) => {
				console.log(error);
			});
		}
		switch ( Notification.permission ){
			case 'granted':
				break;
			case 'denied':
				$('.desktop-notification').removeClass('is-hidden');
				break;
			default:
				$('.desktop-notification').removeClass('is-hidden');
				console.log('No idea')
		}
	}).catch( (error) => {
		console.log(error); 
	});

} else {
	console.log('No service worker')
}

$('body').on('click tap', '.close-push-notification-modal', function(e){
	e.preventDefault();
	$(this).closest('.modal').removeClass('is-active');
});

$('body').on('submit', '.follow-user-form', function(e){
	e.preventDefault();
	var _this = $(this);
	_this.find('button').addClass('is-loading');
	axios.post(_this.attr('action')).then( (response) => {
		if ( response.data === true ){
			iziToast.success({ title: 'Now following' });
			_this.closest('.user-to-follow').fadeOut();
		}
	}).catch( (error) => {
		iziToast.error({ title: 'Something went wrong, please try again' })
	});
});







