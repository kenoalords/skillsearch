self.addEventListener("push", function(event){
	if ( event.data ){
		// console.log(event.data.json())
		data = event.data.json();
		var options = {
			icon: '/images/icon.png',
			badge: '/images/badge.png',
			body: data.body,
			image: data.image,
			vibrate: [300, 100, 800],
			data: {
				link: data.actions[0].action,
				title: data.actions[0].title,
			}
		}
		event.waitUntil(self.registration.showNotification(data.title, options));
	} else {
		console.log('This push has no data');
	}
});

self.addEventListener('notificationclick', function(event){
    var link = event.notification.data.link;
    event.notification.close();
    event.waitUntil(clients.matchAll({
        type: "window"
      }).then(function(clientList) {
        for (var i = 0; i < clientList.length; i++) {
          var client = clientList[i];
          if (client.url == link && 'focus' in client)
            return client.focus();
        }
        if (clients.openWindow)
          return clients.openWindow(link);
      })
    );
})