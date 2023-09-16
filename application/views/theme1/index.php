<?php include(APPPATH.'views/frontend/inc/header.php'); ?>
<?php echo $main_content ?>
<?php if(isset($is_footer) && $is_footer == TRUE): ?>
	<?php include(APPPATH.'views/frontend/inc/user_footer.php'); ?>
<?php endif;?>
<?php include(APPPATH.'views/frontend/inc/footer.php'); ?>
