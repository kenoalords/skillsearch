
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
Vue.component('video-player', require('./components/VideoPlayer.vue'));
Vue.component('blog-form', require('./components/BlogForm.vue'));
Vue.component('verify-users', require('./components/VerifyUsers.vue'));

const app = new Vue({
    el: '#app'
});

var bLazy = new Blazy();

var waypoint = $('#user-badge').waypoint({
	handler: function(direction){
		var userBadge = $('#user-badge'),
			portfolio = $('#portfolio');
		if(direction === 'down' && $(window).outerWidth() > 540){
			userBadge.addClass('fixit');
			portfolio.css({
				'margin-top' : userBadge.outerHeight() + 'px',
			});
		}

		if(direction === 'up'){
			userBadge.removeClass('fixit');
			portfolio.css({
				'margin-top' : 0,
			});
		}
	},
	offset: 0
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




