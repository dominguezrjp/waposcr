<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" defer></script>
<script>
	let isLocalhost = `<?= isLocalHost()==1?true:false;?>`
	window.OneSignal = window.OneSignal || [];
	OneSignal.push(function() {
		OneSignal.init({
			appId: `<?= $appID ;?>`,
			allowLocalhostAsSecureOrigin: isLocalhost,
		});
	});
</script>
