
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

Vue.component('example', require('./components/Example.vue'));
// Vue.component('location', require('./components/Location.vue'));
Vue.component('skills', require('./components/Skills.vue'));
Vue.component('upload-image', require('./components/UploadProfileImage.vue'));
Vue.component('portfolio-form', require('./components/PortfolioForm.vue'));
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

const app = new Vue({
    el: '#app'
});

var bLazy = new Blazy();


// var masonry = new Masonry();
// var imagesLoaded = new imagesLoaded();

var waypoint = $('#portfolio-body').waypoint({
	handler: function(direction){
		var userBadge = $('#user-badge'),
			portfolio = $('#portfolio-summary');
		if(direction === 'down'){
			portfolio.addClass('reveal');
		}

		if(direction === 'up'){
			portfolio.removeClass('reveal');
		}
	},
	offset: 100
});

$('body').on('click', '#google-invite', function(e){
	$('body').addClass('loading');
});

if($('#audio').length > 0){
	loadAndPlayAudioFile();
}

function loadAndPlayAudioFile(){
	var audio = $('#audio').data('src');
	var wavesurfer = Wavesurfer.create({
		container: '#audio',
		waveColor: '#93b3ca',
		progressColor: '#0e74bc',
		barWidth: 2
	});

	wavesurfer.load(audio);

	$('body').on('click', '#play-audio', function(e){
		e.preventDefault();
		if(!wavesurfer.isPlaying()){
			$('#play-audio').find('i').removeClass('fa-play').addClass('fa-pause');
			wavesurfer.play();
		} else {
			$('#play-audio').find('i').removeClass('fa-pause').addClass('fa-play');
			wavesurfer.pause();
		}
	})
	.on('click', '#stop-audio', function(e){
		e.preventDefault();
		if(wavesurfer.isPlaying()){
			$('#play-audio').find('i').removeClass('fa-pause').addClass('fa-play');
		}
		wavesurfer.stop();
	});
}

$('body').on('click', '#delete-instagram', function(e){
	if(!confirm('Are you sure you want to delete this Instagram account? This action cannot be undone.')){
		return false;
	}
})
.on('click', '#close-instagram-notification', function(e){
	e.preventDefault();
	$('#instagram-notification').slideUp('fast');
});


