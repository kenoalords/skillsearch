<script>
	var sw;
	if ( 'serviceWorker' in navigator ){
		window.addEventListener('load', function(){
			navigator.serviceWorker.register('./service-worker.js', { scope: '/' }, ( registration ) => {
				sw = registration;
				sw.pushManager.getSubscription().then( (sub) => {
					console.log(sub);
				}).catch( (error) => {
					console.log(error);
				});
			}).catch ( ( error ) => {
				console.log(error) 
			});
		});
	} else {
		console.log('No service worker')
	}

	
</script>