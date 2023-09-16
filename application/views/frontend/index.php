<?php include 'inc/header.php' ?>
<?php include 'inc/home_menu.php' ?>
<?php echo $main_content ?>
<?php if(isset($page) && $page=="Home"): ?>
	<?php include 'inc/home_footer.php' ?>
<?php endif;?>
<?php include 'inc/footer.php' ?>
