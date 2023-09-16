<?php header("Content-type: text/css; charset: UTF-8"); ?>
<?php 
	if(isset($_GET['color'])){
		$color= '#'.$_GET['color'];
		$hex_color = $_GET['color'];
	}

?>

<?php if(isset($_GET['themes'])) {
	$themes = $_GET['themes'];

}?>

<?php if(isset($_GET['theme_color'])) {
	$theme_color = $_GET['theme_color'];

}?>

<?php if(isset($_GET['btn_style'])) {
	$btn_style = $_GET['btn_style'];
}?>

<?php 
	function hex2rgb($color)
	{
	    list($r, $g, $b) = array($color[0].$color[1],
	                             $color[2].$color[3],
	                             $color[4].$color[5]);
	    $r = hexdec($r); $g = hexdec($g); $b = hexdec($b);
	    return $r.','.$g.','.$b;
	}

 ?>

 .bg-color{
 	background: <?= $color ;?>!important;
 }
 .f-color, .couponArea > a, .loading::before {
 	color: <?= $color ;?>!important;
 }
 .bg-color-soft{
 	 background-color: rgba(<?= hex2rgb($hex_color); ?>,.1)!important;
 }

.singleCatItem:hover{
	border-color:<?= $color ;?>!important;
}

 .color-soft{
 	color: <?= $color ;?>!important;
 	 background-color: rgba(<?= hex2rgb($hex_color); ?>,.1)!important;
 }
.search-box:hover .search-btn, .search-box-2:hover .search-btn{
	background:<?= $color ;?>!important;
	color: #fff!important;
}
/*----------------------------------------------
	VERSION 1.9
----------------------------------------------*/
.custom-checkbox input[type=checkbox]:checked {
    background-color: <?= $color ;?>!important;
    border-color: <?= $color ;?>!important;
}
.custom-checkbox input[type=checkbox] {
    background-color: rgba(<?= hex2rgb($hex_color); ?>,.1)!important;
}

/*----------------------------------------------
	1.8
----------------------------------------------*/

.port_d_flex.home_view a, .port_d_flex a{
	border:rgba(<?= hex2rgb($hex_color); ?>,.5);
	color: <?= $color ;?>;
}
.port_d_flex a{
	background: rgba(<?= hex2rgb($hex_color); ?>,.1);
}
.port_d_flex a:hover{
	background:<?= $color ;?>;
	color: #fff;
}
/*   start color
================================================== */

.homeBanner_Service ul li i,
.UserMobileMenu ul li.active a,
.left_footer ul li a:hover,
ul.row_ul li a i,
.userMenu nav ul li.active a,
.singleMenuItem ul li a:hover,
ul.ci-pagination li a,
.search-box button,
a.seeMore_link,
.live_order_status,
.d_color,
.cat__btn,
.trackLink a,
.customerEdit a:hover,
.couponCode {
	color:<?= $color ;?>!important;
}

.text-center.seeMore_btn a:hover,
.order-btn,
.home-book-btn,
button.btn.btn-primary.add_to_cart_form,
button.btn.btn-primary.add_to_cart,
button.btn.btn-primary.add_to_cart_btn,
button.btn.btn-primary.confirm_btn,
.order-btn.show_order_btn,
.add_to_order{
	background:<?= $color ;?>!important;
	border-color:<?= $color ;?>;
}

.text-center.seeMore_btn a:hover,
.order-btn,
.home-book-btn,
button.btn.btn-primary.add_to_cart_form:hover,
button.btn.btn-primary.add_to_cart:hover,
button.btn.btn-primary.confirm_btn:hover,
a.btn.custom-btn.add_to_order:hover{
	background:transparent;
	border-color:<?= $color ;?>;
	color:<?= $color ;?>;
}

label.btn.btn-sizes{
	border-color: rgba(<?= hex2rgb($hex_color); ?>,.1);;
	background: rgba(<?= hex2rgb($hex_color); ?>,.1);
	color: rgba(<?= hex2rgb($hex_color); ?>,1);
}

label.btn.btn-sizes:hover, label.btn.btn-sizes.active,.order-btn.show_order_btn,
ul.ci-pagination li.active a,
ul.ci-pagination li.page-num:hover a,
ul.ci-pagination li:first-child:hover a,
ul.ci-pagination li:last-child:hover a{
    background: <?=  $color;?>;
    color: #fff!important;
}

a.btn.custom-btn.seemomre:hover, .tipsHeader ul li label.active {
    background: <?=  $color;?>!important;
    color: #fff!important;
}
a.btn.custom-btn.seemomre {
	background: transparent;
    color: <?=  $color;?>;
    border-color:<?=  $color;?>;
}

.port_d_flex.home_view .btn.custom-btn.add_to_cart{
	border-color: #eee;
}
.defaultHeading h1::before{
	background: rgba(<?= hex2rgb($hex_color); ?>,.3)!important;
}
.defaultHeading h1::after,
ul.gallery_sort li button.active, ul.gallery_sort li button:hover{
	background: rgba(<?= hex2rgb($hex_color); ?>,1)!important;
}

a.base {
    background: radial-gradient(<?= $color ;?> 55%, #f1f3f4 58%)!important;
}




/*background*/
.slider-nav .slick-arrow,
.scroll-top,
.sction_title::before,
.c_btn,
.second_media ul li a i,
.username_section h3::before,
.or::before,
.or::after,
.available i{
	background: <?= $color;?>
}

.c_btn{
	color:#fff;
}

.custom_btn{
	border-color: <?= $color;?>;
	background: <?= $color;?>;
	color: #fff;
}
.custom-btn:hover, .port_d_flex.home_view a:hover{
	background: <?= $color;?>;
	color: #fff;
	transition: all .3s;
}


/*background and border*/
.nicescroll-cursors{
	background: <?= $color;?>!important;
	border-color: <?= $color;?>!important;
}

/*background and border*/


.d_bg{
	background: <?=  $color;?>;
	color:#fff;
	transition: all .3s ease-in-out;
}
a.btn.custom-btn.add_to_cart{
	border-color: <?=  $color;?>;
}

/*text_color*/
a.scrollto.active,
.menu_list ul li a:hover,
.single_contact_wizard:hover i,
.modal_btn,
.mouse-wrapper{
	color: <?= $color;?>;
}

.hero_share ul li a:hover{
	background: <?=  $color;?>;
	color: #fff;
}
.all_social_sites_icon ul.circle a:hover,.package_header_right.text-center a:hover {
    border-color: <?= $color;?>;
    background:  <?= $color;?>;
	transition: all .3s ease-in-out;
}
.all_social_sites_icon ul.circle a {
    border-color: <?= $color;?>;
    color: <?= $color;?>;
}

.home_social.list.style_2 ul li a{
	border-color: <?=  $color;?>;
	color: <?=  $color;?>;
}
.home_social.list.style_2 ul li a:hover{
	border-color: <?=  $color;?>;
	background: <?=  $color;?>;
	color:#fff;
}
.home_social.list.style_2 ul li a:hover:before{
	display: none;
}

.all_social_sites_icon.about_social ul li a:hover{
	background: <?=  $color;?>;
	color:#fff;
}

.all_social_sites_icon.about_social ul li a{
	color: <?=  $color;?>;
	background: #fff;
}

.about_me_heading h4:before {
    background: <?=  $color;?>;
}

.c_btn:hover{
	background: rgba(<?= hex2rgb($hex_color); ?>,.7)!important;
	border-color:<?= $color;?>;
	color:#fff;
}
a.share_me_btn{
	background: rgba(<?= hex2rgb($hex_color); ?>,.2)!important;
	border-color:<?= $color;?>;
	color:<?= $color;?>;
}

a.share_me_btn:hover{
	background: rgba(<?= hex2rgb($hex_color); ?>,1)!important;
	border-color:<?= $color;?>;
	color:#fff;
}
.mouse{
	border-color:<?= $color;?>;
}

.mouse .wheel{
	background:<?= $color;?>;
}
.home_social.style_4 ul li a:hover{
	color:rgba(<?= hex2rgb($hex_color); ?>,1)!important;
}

.single_serivce_area:hover {
    box-shadow: 0px 5px 0px <?= $color;?>;
}

.scroll-top{
	box-shadow: 0px 8px 16px 0px rgba(<?= hex2rgb($hex_color); ?>,.5)!important;
}

.single_contact_wizard:hover{
	box-shadow: 0 0 5px <?= $color;?>!important;
}
.home_service_icon.circle i{
	background: rgba(<?= hex2rgb($hex_color); ?>,.1);
	color:<?=  $color;?>;
}
.video_play_btn .play-btn{
	background: radial-gradient(<?= $color;?> 50%, rgba(<?= hex2rgb($hex_color); ?>,.4) 52%);
}
.video_play_btn .play-btn::before {
	border-color:<?=  $color;?>;
}
.theme_5 .single_contact_top i{
	background: rgba(<?= hex2rgb($hex_color); ?>,.1);
	color:<?=  $color;?>;
}
.theme_5 .single_contact_wizard:hover i{
  background:<?=  $color;?>;
  color:#fff;
}
/*   End color
================================================== */

<?php 
if($themes==2){ ?>

.single_home {
   margin-top: 25px;
}

.home_profile_bottom {
    padding-bottom: 30px;
}
.section_details {
    width: 100%;
    padding: 15px 15px 30px;
}
.download_btn_area {
    text-align: center;

}
.download_btn_area a{
   display: block;
   padding: 15px;
}

section.services_area.how_it_works{
	background: #fff;
}
section.default{
	padding: 0;
}
.services_content {
    padding-bottom: 77px;
    padding-top: 16px;
    padding: 16px 15px 77px;
}
section.profile {
    padding: 20px 0;
}

.portfolio_content {
    padding: 15px 15px 80px;
}
.single_contact_wizard {
    display: block;
    width: 100%;
}
.contact_top {
    flex-wrap: wrap;
}
.form_fields .form-group{
	width: 100%;
}

.contact_content {
    padding: 15px 15px 20px;
}

.xs-container::before {
    content: ' ';
    width: 45px;
    height: 84px;
    position: absolute;
    left: 0;
    top: 0;
    border-top: 7px solid <?= $color;?>;
    border-left: 7px solid <?= $color;?>;
    /*border-left: 7px solid #2ec1ac;*/
    z-index:1;
}

.xs-container::after {
    content: ' ';
    width: 45px;
    height: 84px;
    position: absolute;
    right: 0;
    bottom: 0;
    border-bottom: 7px solid <?= $color;?>;
    border-right: 7px solid <?= $color;?>;
    z-index:1;
}

<?php if($themes==2): ?>





<?php endif; ?> /*theme*/



<?php } ?>


<?php if($theme_color==1): ?>
	section.services_area.how_it_works{
		background: #1a1a2e!important;
	} 
	.single_service.profile {
	    color: #000;
	}
	.single_contact_wizard{
		border-color: #333;
		box-shadow: 0 0 5px #333;
	}
	.single_contact_wizard a{
		color: #fff;
	}
	.contacts_area .form-control{
		background: transparent;
		color: #fff;
		border-color:#333;
	}
	.single_serivce_area{
		border: 1px solid #1b262c;
	    background: rgb(26, 30, 44,.5);
	    box-shadow: none;
	    
	}
	.single_service.profile{
		color: #a4acc4;
	}
    .service_details a{
    	color: <?= $color;?>;
    }
    .modal > * {
	    color: #000;
	}
	.profile_menu{
		background: #343a40!important;
		box-shadow: 0 0 5px #222!important;
	}
	.menu_list ul li a{
		color: #fff;
	}
	.container.xs-container {
	    border: 1px solid #1b262c;
	    box-shadow: 1px 2px 15px #48484833;
	}
	/*1a1a2e #191d2b*/
<?php endif;?> /*theme color*/

<?php if(isset($themes) && $themes==1): ?>
	.theme_1 .itemPrice_area.i_small {
		flex-wrap: nowrap;
		white-space: nowrap;
		overflow-x: auto;
	}




	/* .theme_1 ::-webkit-scrollbar-track
	{
		-webkit-box-shadow: inset 0 0 2px #fff;
		background-color: rgba(<?= hex2rgb($hex_color); ?>,.7)!important;
		cursor: pointer;
	}

	.theme_1 ::-webkit-scrollbar {
		width: 2px;
		background-color: #fff;
		height: 5px;
		cursor: pointer;
	}

	.theme_1 ::-webkit-scrollbar-thumb {
		background: #f9f9f9;
		cursor: pointer;
	} */
<?php endif ?>

<?php if(isset($themes) && $themes==2): ?>
	.homeItemDetails.list_view .itemPrice_area.i_small {
		flex-wrap: nowrap;
		white-space: nowrap;
		overflow-x: auto;
	}

<?php endif ?>

<?php if(isset($themes) && $themes==3): ?>
<?php endif ?>

button.btn.btn-primary.add_to_cart_btn:hover{
   background: #fff!important;
   color: rgba(<?= hex2rgb($hex_color); ?>,1)!important;
   border-color: rgba(<?= hex2rgb($hex_color); ?>,1)!important;
}

<?php for($i=0;$i<100;$i++){ ?>
	.pt-<?= $i;?>{
		padding-top:<?= $i;?>px!important;
	}

	.pb-<?= $i;?>{
		padding-bottom:<?= $i;?>px!important;
	}

	.pl-<?= $i;?>{
		padding-left:<?= $i;?>px!important;
	}

	.pr-<?= $i;?>{
		padding-right:<?= $i;?>px!important;
	}

	.mt-<?= $i;?>{
		margin-top:<?= $i;?>px!important;
	}

	.mb-<?= $i;?>{
		margin-bottom:<?= $i;?>px!important;
	}

	.ml-<?= $i;?>{
		margin-left:<?= $i;?>px!important;
	}

	.mr-<?= $i;?>{
		margin-right:<?= $i;?>px!important;
	}

	.p-<?= $i;?>{
		padding:<?= $i;?>px!important;
	}

	.m-<?= $i;?>{
		margin:<?= $i;?>px!important;
	}

	.fz-<?= $i;?>{
		font-size:<?= $i;?>px!important;
	}

	.ht-<?= $i;?>{
		height:<?= $i;?>px!important;
	}

	.wd-<?= $i;?>{
		width:<?= $i;?>px!important;
	}
	
<?php } ?>