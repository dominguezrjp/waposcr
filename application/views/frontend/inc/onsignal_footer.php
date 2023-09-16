
 <script>
 	OneSignal.push(function() {
 		/* These examples are all valid */
 		var isPushSupported = OneSignal.isPushNotificationsSupported();
 		if (isPushSupported) {
 			console.log('Push notifications are supported');

 			OneSignal.isPushNotificationsEnabled(function(isEnabled) {
 				if (isEnabled){
 					OneSignal.getUserId(function(userId) {
 						console.log("OneSignal User ID:", userId);  
 						setUser(userId);
					});
 					console.log("Push notifications are enabled!");
 				}else{
 					console.log("Push notifications are not enabled yet."); 
 					OneSignal.push(function() {
 						OneSignal.showSlidedownPrompt();
 					});

 				}


 			});



 		} else {
 			console.log('Push notifications are not supported');

 		}
 	});

function setUser(userId){
	// var shopId = `<?= isset($id)?$id:0; ?>`;
	// var auth_id = `<?= !empty(auth('id'))?auth('id'):0; ?>`;
	// var url = `<?= base_url();?>profile/get_users/${userId}/${shopId}/${auth_id}`;
	// var csrf_value = `<?= $this->security->get_csrf_hash(); ?>`;

	// $.get(url, {'csrf_test_name': csrf_value }, function(json){
	// 	if(json.st == 1){
	// 		console.log(json.userId);
			
	// 	}
	// },'json');
}

 </script>