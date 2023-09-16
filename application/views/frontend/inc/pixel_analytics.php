<!-- Users -->
<?php if(isset($id)): ?>
	<?php $user_settings = $this->common_m->get_user_settings($id); ?>
	<?php if(isset($user_settings['pixel_id']) && !empty($user_settings['pixel_id'])): ?>
	<!-- Facebook Pixel Code -->
	<script>
		!function(f,b,e,v,n,t,s)
		{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
			n.callMethod.apply(n,arguments):n.queue.push(arguments)};
			if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
			n.queue=[];t=b.createElement(e);t.async=!0;
			t.src=v;s=b.getElementsByTagName(e)[0];
			s.parentNode.insertBefore(t,s)}(window, document,'script',
				'https://connect.facebook.net/en_US/fbevents.js');
			fbq('init', `<?= $user_settings['pixel_id'];?>`);
			fbq('track', 'PageView');
		</script>
		<noscript>
			<img height="1" width="1" style="display:none" 
			src="https://www.facebook.com/tr?id=<?= $user_settings['pixel_id'];?>&ev=PageView&noscript=1"/>
		</noscript>
		<!-- End Facebook Pixel Code -->
	<?php endif; ?>
<?php if(isset($user_settings['analytics_id']) && !empty($user_settings['analytics_id'])): ?>

	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=<?= $user_settings['analytics_id'];?>"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', '<?= $user_settings['analytics_id'];?>');
	</script>


	
<!-- End Google Analytics -->
<?php endif; ?>

<?php endif; ?>
<!-- Users -->

<?php if(isset($page) && $page=="Home"): ?>
<!-- Admin -->
	<?php if(isset($settings['pixel_id']) && !empty($settings['pixel_id'])): ?>
	<!-- Facebook Pixel Code -->
		<script>
			!function(f,b,e,v,n,t,s)
			{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
				n.callMethod.apply(n,arguments):n.queue.push(arguments)};
				if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
				n.queue=[];t=b.createElement(e);t.async=!0;
				t.src=v;s=b.getElementsByTagName(e)[0];
				s.parentNode.insertBefore(t,s)}(window, document,'script',
					'https://connect.facebook.net/en_US/fbevents.js');
				fbq('init', `<?= $settings['pixel_id'];?>`);
				fbq('track', 'PageView');
		</script>
		<noscript>
			<img height="1" width="1" style="display:none" 
			src="https://www.facebook.com/tr?id=<?= $settings['pixel_id'];?>&ev=PageView&noscript=1"/>
		</noscript>
		<!-- End Facebook Pixel Code -->
	<?php endif; ?>
	<?php if(isset($settings['analytics']) && !empty($settings['analytics'])): ?>
	<!-- Google Analytics -->
		<!-- Google tag (gtag.js) -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=<?= $settings['analytics'];?>"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', '<?= $settings['analytics'];?>');
		</script>
	<!-- End Google Analytics -->
	<!-- Admin -->
	<?php endif; ?>
<?php endif; ?>
