<!doctype html>
<html lang="en" dir="<?= direction();?>">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<?php $settings = settings(); ?>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/frontend/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>assets/frontend/plugins/jquery-ui/jquery-ui.main.css">

	<?php if(direction()=='rtl'): ?>
	    <link rel="stylesheet" href="<?= base_url()?>assets/frontend/css/bootstrap-rtl.css?v=<?= $settings['version'];?>">
	    <link rel="stylesheet" href="<?= base_url()?>assets/frontend/css/custom_rtl.css?v=<?= $settings['version'];?>">
	  <?php endif ?>
	<!-- Bootstrap CSS -->
	
	


	<!-- animate css 3.7.2 -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/plugins/animate/animate.css">
	<!-- animate -->
	<!-- lightbox lightbox css 2.11.1-->

	<!--aos-animation -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/plugins/animation/aos-animation.css">
	<!-- animate -->
	
	<!-- fontawsome 4.7 and 5.8.1 -->
	<link href="<?php echo base_url(); ?>assets/frontend/css/font-awesome-5.8.1.main.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/frontend/css/font-awesome.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/frontend/css/icofont.css" rel="stylesheet">
	<!-- fontawsome 4.7 and 5.8.1 -->

	<!-- custom loader css -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/frontend/plugins/loader.css?v=<?= $settings['version'];?>">
	<!-- custom loader css -->



	<!-- custom css -->
	<link rel="stylesheet" href="<?= base_url(); ?>public/frontend/css/frontend.css?v=<?= $settings['version'];?>&time=<?=time() ;?>">
	<link rel="stylesheet" href="<?= base_url(); ?>public/frontend/css/style.css?v=<?= $settings['version'];?>&time=<?=time() ;?>">
	<!-- custom css -->
	<!-- custom css -->
	<?php if(isset($settings['custom_css']) && !empty($settings['custom_css'])): ?>
		<style>
			<?=  $settings['custom_css'];?>
		</style>
	<?php endif;?>
	<!-- custom css -->

	<?php if(isset($id)): ?>
		<?php $u_info = user_info_by_id($id); ?>


		<?php if(isset($u_info['menu_style']) && $u_info['menu_style']==1): ?>
			<style>
				@media only screen and (max-width: 767px){
					.UserMobileMenu {
						display: block!important; 
					}
					.userMenu {
						display: none!important; 
					}
				}
			</style>
		<?php else: ?>
			<style>
				@media only screen and (max-width: 767px){
					.userMenu {
						display: block!important; 
					}
					.allow-sm{
						display: block
					}
					.UserMobileMenu, .rightMenu {
						display: none!important; 
					}
				}
			</style>
		<?php endif;?>



	<!-- custom css -->
		<link rel="stylesheet" href="<?= base_url(); ?>public/frontend/css/default.php?themes=<?= $u_info['theme']  ;?>&theme_color=<?= $u_info['theme_color'] ;?>&color=<?= $u_info['colors'];?>">
	<?php endif;?>

<?php if(isset($settings['system_fonts']) && !empty($settings['system_fonts'])): ?>
	<link href="https://fonts.googleapis.com/css2?family=<?= $settings['system_fonts'] ;?>:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="<?= base_url(); ?>public/frontend/css/fonts.php?name=<?= $settings['system_fonts'] ;?>">
<?php endif;?>




	<!-- responsive css -->
	<link rel="stylesheet" href="<?= base_url(); ?>public/frontend/css/responsive.css?v=<?= $settings['version'];?>&t=<?= time();?>">
	<!-- responsive css-->
	
	<link rel="icon" href="<?= !empty($settings['favicon'])?base_url(html_escape($settings['favicon'])):'';?>" type="image/*" sizes="16x16">
	
	<title><?= !empty($settings['site_name'])?$settings['site_name']:'Qmenu';?> | <?= isset($page_title) && $page_title!=''?$page_title:''; ?></title>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?= base_url();?>assets/frontend/js/jquery-3.4.1.min.js"></script>
    <!-- ==========
   		 Default Js
    =============== -->
    <script src="<?= base_url();?>assets/frontend/js/bootstrap.min.js" ></script>
    <script src="<?= base_url();?>public/frontend/js/auth.js?v=<?= $settings['version'];?>&t=<?= time();?>" ></script>
	<!-- ==========
   		End Default Js
    =============== -->
    <body>
	<?php //include APPPATH.'views/'.get_view_layouts_by_slug($slug).'/include/banner.php'; ?>
	<?php include APPPATH.'views/common_layouts/topMenu.php' ?>


	<?php echo $main_content; ?>

	<a href="<?php echo base_url() ?>" id="base_url"></a>
	<a href="<?= $this->security->get_csrf_hash(); ?>" id="csrf_value"></a>

 	<script>
	$(window).on('load', function(){
		setTimeout(function(){
			amarLeazyLoad();
			amarbgLoad();
		},500);

	});

	var amarbgLoad = function(){
		$('.bg_loader').each(function() {

			var lazy = $(this);
			var src = lazy.data('src');
			lazy.css("background-image", "url(" + src + ")");
			$('.bg_loader').removeClass('bg_loader');
		});
	}

	var amarLeazyLoad = function(){
		$('.img_loader').each(function() {
			var lazy = $(this);
			var src = lazy.data('src');
			lazy.attr('src', src);
			$('.img_loader').removeClass('.bg_loader');

		});
	}
</script>
	
    </body>
</html>
