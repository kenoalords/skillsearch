
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
Vue.component('referral-code', require('./components/ReferralCode.vue'));
Vue.component('referral', require('./components/Referral.vue'));
Vue.component('contact-request', require('./components/ContactRequest.vue'));
Vue.component('comments', require('./components/Comments.vue'));
Vue.component('skills', require('./components/Skills.vue'));
Vue.component('upload-image', require('./components/UploadProfileImage.vue'));
Vue.component('portfolio-form', require('./components/PortfolioForm.vue'));
Vue.component('portfolio-upload-form', require('./components/PortfolioUploadForm.vue'));
Vue.component('message', require('./components/Message.vue'));
Vue.component('send-message', require('./components/SendMessage.vue'));
Vue.component('follow', require('./components/Follow.vue'));
Vue.component('reviews', require('./components/Review.vue'));
Vue.component('portfolio', require('./components/Portfolio.vue'));
Vue.component('request-service', require('./components/RequestService.vue'));
Vue.component('requests', require('./components/Requests.vue'));
Vue.component('user-background', require('./components/UserBackground.vue'));
Vue.component('like-button', require('./components/LikeButton.vue'));
Vue.component('privacy-toggle', require('./components/PrivacyToggle.vue'));
Vue.component('portfolio-comments', require('./components/PortfolioComments.vue'));
Vue.component('register-view', require('./components/Views.vue'));
Vue.component('application-actions', require('./components/ApplicationActions.vue'));
Vue.component('video-player', require('./components/VideoPlayer.vue'));
Vue.component('blog-form', require('./components/BlogForm.vue'));
Vue.component('verify-users', require('./components/VerifyUsers.vue'));
Vue.component('instagram', require('./components/Instagram.vue'));
Vue.component('task-form', require('./components/TaskForm.vue'));
Vue.component('task-form-apply', require('./components/TaskFormApply.vue'));
Vue.component('job-actions', require('./components/JobActions.vue'));
Vue.component('flag-job', require('./components/FlagJob.vue'));
Vue.component('save-job', require('./components/SaveJob.vue'));
Vue.component('blog-like', require('./components/BlogLike.vue'));
Vue.component('blog-subscribe', require('./components/BlogSubscribe.vue'));
Vue.component('phone-number', require('./components/PhoneNumber.vue'));
Vue.component('portfolio-list', require('./components/Portfolios.vue'));
Vue.component('portfolio-item', require('./components/PortfolioItem.vue'));

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



var bLazy = new Blazy({
	offset: 0
});
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
});

$('.ui.sticky').sticky({
	context: '#sidebar',
	offset: 70,
});

var dropdownDefault;
if ($('.ui.selection').length > 0){
	dropdownDefault = $('.ui.selection').find('div.menu')[0].dataset.default;
}
// console.log(dropdownDefault);

$('.ui.checkbox').checkbox();
$('.ui.dropdown').dropdown('set selected', dropdownDefault);
// $('#gender').dropdown();
$('.ui.progress').progress();

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

import jPlayer from 'jplayer';

$("#jquery_jplayer_1").jPlayer({
    ready: function () {
      $(this).jPlayer("setMedia", {
        // title: $('#jquery_jplayer_1').data('title'),
        m4a: $('#jquery_jplayer_1').data('src'),
      });
    },
    cssSelectorAncestor: "#jp_container_1",
    swfPath: "/js",
    supplied: "m4a",
    useStateClassSkin: true,
    autoBlur: false,
    smoothPlayBar: true,
    keyEnabled: true,
    remainingDuration: true,
    toggleDuration: true
});

$('#mobile-menu-admin').sidebar({
    // context: $('#app')
}).sidebar('attach events', '#mobile-admin-trigger');

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

// var waypoints = $('#how').waypoint({
//     // element: document.getElementById('how'),
//     handler: function(direction){
//         console.log(direction);
//     }
// });













