<?php if(isset($page) && $page != 'Profile'): ?>
	<!-- Home page pwa -->
	<?php $pwa1 = !empty($settings['pwa_config'])?json_decode($settings['pwa_config']):''; ?>
	<?php if((isset($settings['is_pwa']) && $settings['is_pwa']==1) && (isset($pwa1->is_pwa_active) && $pwa1->is_pwa_active==1)): ?>
		<meta name="mobile-wep-app-capable" content="yes">
		<meta name="apple-mobile-wep-app-capable" content="yes">
		<?php 
		$thumb = !empty($pwa1->logo)? $pwa1->logo:"uploads/pwa/logo.png";
		$Fdata = [
			'img_144' => resize_img($thumb,144,144),
			'img_192' => resize_img($thumb,192,192),
			'img_512' => resize_img($thumb,512,512),
			'theme_color' => !empty($pwa1->theme_color)?$pwa1->theme_color:'FF9800',
			'background_color' => !empty($pwa1->background_color)?$pwa1->background_color:'FF9800',
			'title' => !empty($pwa1->title)?$pwa1->title:$settings['site_name'],
			'url' => base_url(),
			'name' => $settings['site_name'],
		];
		$q = serialize($Fdata);
		?>
		<meta name="apple-mobile-web-app-status-bar-style" content="#<?= $Fdata['theme_color'] ;?>">
		<link rel="apple-touch-icon" href="<?=$Fdata['img_144'] ;?>" type="image/png" sizes="144x144">
		<link rel="apple-touch-icon" href="<?=$Fdata['img_192'] ;?>" type="image/png" sizes="192x192">
		<link rel="apple-touch-icon" href="<?=$Fdata['img_512'] ;?>" type="image/png" sizes="512x512">

		<link rel="icon" href="<?= $Fdata['img_512'] ;?>" type="image/png" sizes="512x512">
		<link rel="icon" href="<?= $Fdata['img_144'] ;?>" type="image/png" sizes="144x144">
		<link rel="manifest" href="<?= base_url(); ?>assets/manifest-2.php?Hdata=<?= urlencode($q);?>&t=<?= time() ;?>" type="text/html">

	<?php endif ?>
<!-- pwa -->
<?php endif;?>

<?php if(isset($page) && $page=="Profile"): ?>
	<?php if(isset($id)): ?>
		<?php $u_info = user_info_by_id($id); ?>
		<?php $u_settings = $this->common_m->get_user_settings($id); ?>
		<!-- User pwa -->
		<?php $pwa = !empty($u_settings['pwa_config'])?json_decode($u_settings['pwa_config']):''; ?>
		<?php if(isset($settings['is_pwa']) && $settings['is_pwa']==1 && (isset($pwa->is_pwa_active) && $pwa->is_pwa_active==1)): ?>
			<meta name="mobile-wep-app-capable" content="yes">
			<meta name="apple-mobile-wep-app-capable" content="yes">
			<?php 
			$thumb = !empty($pwa->logo)? $pwa->logo:"uploads/pwa/avatar.png";
			$Fdata = [
				'img_144' => resize_img($thumb,144,144),
				'img_192' => resize_img($thumb,192,192),
				'img_512' => resize_img($thumb,512,512),
				'theme_color' => !empty($pwa->theme_color)?$pwa->theme_color:'FF9800',
				'background_color' => !empty($pwa->background_color)?$pwa->background_color:'FF9800',
				'title' => !empty($pwa->title)?$pwa->title:$u_info['username'],
				'url' => base_url($u_info['username']),
				'username' => $u_info['username'],
			];
			$q = serialize($Fdata);
			?>
			<meta name="apple-mobile-web-app-status-bar-style" content="#<?= $Fdata['theme_color'] ;?>">
			<link rel="apple-touch-icon" href="<?=$Fdata['img_144'] ;?>" type="image/png" sizes="144x144">
			<link rel="apple-touch-icon" href="<?=$Fdata['img_192'] ;?>" type="image/png" sizes="192x192">
			<link rel="apple-touch-icon" href="<?=$Fdata['img_512'] ;?>" type="image/png" sizes="512x512">
			<link rel="icon" href="<?= $Fdata['img_512'] ;?>" type="image/png" sizes="512x512">
			<link rel="icon" href="<?= $Fdata['img_144'] ;?>" type="image/png" sizes="144x144">
			<link rel="manifest" href="<?= base_url(); ?>assets/manifest.php?Fdata=<?= urlencode($q);?>&t=<?= time() ;?>" type="text/html">

		<?php endif ?>
	<?php endif ?>
<!-- pwa -->
<?php endif;?>