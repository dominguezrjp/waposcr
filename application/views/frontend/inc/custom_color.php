<?php 
	$colors = $settings['site_color'];
	$hex_color = hex2rgb($settings['site_color']);
	function hex2rgb($color)
	{
	    list($r, $g, $b) = array($color[0].$color[1],
	                             $color[2].$color[3],
	                             $color[4].$color[5]);
	    $r = hexdec($r); $g = hexdec($g); $b = hexdec($b);
	    return $r.','.$g.','.$b;
	}

	function rgbColor($colors,$opacity){
		return "rgba({$colors},{$opacity})";
	}




 ?>
<style>
	.home_page_navbar nav li.active a, .home_page_navbar nav li a:hover, .learn_more_link, .features-wrap i {
		color: <?= rgbColor($hex_color,1);?>!important;
	}
	.right_bar a {
	    background: <?= rgbColor($hex_color,.1);?>;
	    color: <?= rgbColor($hex_color,1);?>;
	    border: 1px solid <?= rgbColor($hex_color,1);?>;
	}
	.right_bar a.create_profile, #hero .btn-get-started:hover {
	    background: <?= rgbColor($hex_color,1);?>;
	    color: #fff;
	}
	.right_bar a.create_profile:hover {
	    background: <?= rgbColor($hex_color,.1);?>;
	    color: <?= rgbColor($hex_color,1);?>;
	    border: 1px solid <?= rgbColor($hex_color,1);?>;
	}
	.right_bar a:hover {
	    background: <?= rgbColor($hex_color,1);?>;
	    border-color: <?= rgbColor($hex_color,1);?>;
	    color: #fff;
	}
	#hero .btn-get-started {
		background: <?= rgbColor($hex_color,.4);?>;
		border: 1px solid <?= rgbColor($hex_color,.4);?>;
	}

	.home_button .video_play_btn .play-btn {
		background: radial-gradient(<?= rgbColor($hex_color,1);?> 50%, <?= rgbColor($hex_color,.4);?> 52%);
	}
	.home_button .video_play_btn .play-btn::before {
		border: 5px solid <?= rgbColor($hex_color,.7);?>;
	}
	.home_button .video_play_btn:hover {
		border: 1px solid <?= rgbColor($hex_color,.7);?>;
	}
	button.btn.btn-primary.c_btn{
		background: <?= rgbColor($hex_color,1);?>;
		border-color: <?= rgbColor($hex_color,1);?>;
	}
	.form-group.resturant_name button {
		background: <?= rgbColor($hex_color,1);?>;
	}
	h2.heading-text::before, .slider-nav .slick-arrow  {
		background: <?= rgbColor($hex_color,1);?>;
	}
	.single_serivce_area:hover {
	    box-shadow: 0px 5px 0px  <?= rgbColor($hex_color,1);?>;
	}
	.arrow_down::after, .arrow_up::after, .left_footer p a, ul.row_ul li a i {
	    color: <?= rgbColor($hex_color,1);?>;
	}
	.pricing_3 .btn.price_btn {
	    background: <?= rgbColor($hex_color,1);?>;
	    border-color: <?= rgbColor($hex_color,1);?>;
	}
	.resaurantDemo, .topSigin .btn-info, .login_wrapper .btn-info{
		background: <?= rgbColor($hex_color,1);?>!important;
		border-color: <?= rgbColor($hex_color,1);?>;
	}
	body::-webkit-scrollbar-thumb {
		background-color: <?= rgbColor($hex_color,1);?>;;
	}
	a, .othersLogin ul li a:hover{
		color: <?= rgbColor($hex_color,1);?>;
	}

</style>