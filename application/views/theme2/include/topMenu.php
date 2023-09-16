  <?php $u_info = get_user_info_by_slug($slug); ?>
 <div class="userMenu navbar-light bg-light">
 	<div class="container">
	 	<nav class="navbar navbar-expand-lg ">

		  <a class="navbar-brand" href="<?= base_url($slug) ;?>"><?=  !empty(restaurant($id)->name)? restaurant($id)->name:restaurant($id)->username;?></a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>
		  <div class="collapse navbar-collapse" id="navbarNavDropdown">
		    <div class="container-fluid">
		    	<div class="userMenu_flex">
			    	<ul class="navbar-nav">
			    	<?php if(is_feature($id,'welcome')==1 && is_active($id,'welcome')): ?>
				      <li class="nav-item <?= isset($page_title) && $page_title=="Profile"?"active":"" ;?>">
				        <a class="nav-link" href="<?= base_url($slug) ;?>"><?= lang('home');?> <span class="sr-only">(current)</span></a>
				      </li>
				  	<?php endif;?>

				  	<?php if(is_feature($id,'menu')==1 && is_active($id,'menu')): ?>
				      <li class="nav-item <?= isset($page_title) && $page_title=="Menus"?"active":"" ;?>">
				        <a class="nav-link" href="<?= base_url('menu/'.$slug) ;?>"><?= get_features_name('menu');?></a>
				      </li>
				  	<?php endif;?>

				  	<?php if(is_feature($id,'packages')==1 && is_active($id,'packages')): ?>
				      <li class="nav-item <?= isset($page_title) && $page_title=="Packages"?"active":"" ;?>">
				        <a class="nav-link" href="<?= base_url('packages/'.$slug) ;?>"><?= get_features_name('packages');?></a>
				      </li>
				  	<?php endif;?>

				  	<?php if(is_feature($id,'specialities')==1 && is_active($id,'specialities')): ?>
				      <li class="nav-item <?= isset($page_title) && $page_title=="Specialties"?"active":"" ;?>">
				        <a class="nav-link" href="<?= base_url('specialities/'.$slug) ;?>"><?= get_features_name('specialities');?></a>
				      </li>
				  	<?php endif;?>
				      
			    	</ul>
			    	<div class="rightMenu">
				    	<ul>
				    	
				    		<?php if($shop['is_call_waiter']==1): ?>
					    		<li class="callwaiter"><a class="nav-link" href="javascript:;" data-toggle="modal" data-target="#waiterModal"><i class="icofont-bell-alt"></i> <?= lang('call_waiter'); ?></a></li>
					    	<?php endif;?>
				    	</ul>
			    	</div>
			    </div>
		    </div>
		  </div>
		</nav>
	</div>
 </div>

 <div class="UserResponsive_menu">
 	<div class="UserMobileMenu">
 		<ul>
 			<?php if(is_feature($id,'welcome')==1 && is_active($id,'welcome')): ?>
 				<li data-toggle="tooltip" title="Home" class="<?= isset($page_title) && $page_title=="Profile"?"active":"" ;?>"><a href="<?= base_url($slug) ;?>"><i class="icofont-home"></i></a></li>
 			<?php endif;?>

 			<?php if(is_feature($id,'menu')==1 && is_active($id,'menu')): ?>
	 			<li data-toggle="tooltip" title="Menu" class="<?= isset($page_title) && $page_title=="Menus"?"active":"" ;?>"><a href="<?= base_url('menu/'.$slug) ;?>"><i class="icofont-culinary fz-36"></i></a></li>
	 		<?php endif;?>

 			<li data-toggle="tooltip" title=""><a href="javascript:;" class="base"><i class="icofont-gears"></i></a></li>

 			<?php if(is_feature($id,'packages')==1 && is_active($id,'packages')): ?>
	 			<li data-toggle="tooltip" title="Packages" class="<?= isset($page_title) && $page_title=="Packages"?"active":"" ;?>"><a href="<?= base_url('packages/'.$slug) ;?>"><i class="icofont-gift"></i></a></li>
	 		<?php endif;?>

	 		<?php if(is_feature($id,'specialities')==1 && is_active($id,'specialities')): ?>
	 			<li data-toggle="tooltip" title="Specialties" class="<?= isset($page_title) && $page_title=="Specialties"?"active":"" ;?>"><a href="<?= base_url('specialities/'.$slug) ;?>"><i class="icofont-touch"></i></a></li>
	 		<?php endif;?>

 		</ul>
 	</div>
 	<div class="show_menu_details">
 		<a href="javascript:;" class="closeNavMenu"><i class="icofont-close-line"></i></a>
 		<ul>
 			<li><a href="<?= base_url('track-order/'.$slug) ;?>"><?= lang('track_order'); ?></a></li>
 			<?php if(is_feature($id,'reservation')==1 && is_active($id,'reservation')): ?>
	 			<li><a href="<?= base_url('reservation/'.$slug);?>"><?= get_features_name('reservation');?></a></li>
	 		<?php endif;?>
 			<?php if(is_feature($id,'contacts')==1 && is_active($id,'contacts')): ?>
	 			<li><a href="<?= base_url('contacts/'.$slug);?>"><?= get_features_name('contacts');?></a></li>
	 		<?php endif;?>
 			<li><a href="<?= base_url('about-us/'.$slug);?>"><?= lang('about_us'); ?></a></li>
 			<li><a href="<?= base_url('login') ;?>"><?= lang('login'); ?></a></li>
 		</ul>
 	</div>

 </div>
<?php if(isset($page_title) && $page_title !="Payment Gateway" && $page_title !="All Orders"): ?>
<div class="cart navCart CartIcon <?= $this->cart->total_items() > 0?'active':'' ;?>" ><a class="nav-link" href="javascript:;"><i class="icofont-cart-alt fa-2x"></i> <span class="cart_count total_count"><?= $this->cart->total_items() ;?></span></a></div>
<?php endif; ?>


 <div class="shopping_cart">
 	<div class="shopping_cart_content">
 		<div class="cart_heading">
			<h4><?= lang('my_cart'); ?> </h4>
			<span class="cartItemList cartActive"><a class="" href="javascript:;"><i class="icofont-close-line-squared fa-2x c_red"></i></a></span>
		</div>
		<?php $time =$this->common_m->get_single_appoinment(date('w'),isset($shop_id)?$shop_id:0); ?>
		<?php if(isset($time) && !empty($time)): ?>
				<?php if(is_active($id,'order')): ?>
						<?php 
							 $total = $this->common_m->count_table_shop_id($shop['id'],'order_user_list');
							 $limit = limit($id,0);
						 ?>
					 
					 <?php if($limit != 0 && $total >= $limit):  ?>
					 	<div class="top_cart_order">
					 		<div class="limit_msg">
								<i class="fa fa-frown fa-3x"></i>
								<h4><?= lang('maximum_order_alert'); ?></h4>
								<a href="<?= base_url('contacts/'.$slug) ;?>" class="btn btn-info custom_btn mt-15"><?= lang('contact_us'); ?></a>
							</div>
					 	</div>
					 	<?php else: ?>
					 		<div class="top_cart_order style_2">
					 			<ul class="cartItems">
					 				<?php include APPPATH.'views/layouts/ajax_cart_item.php'; ?>
					 			</ul>
					 		</div>
					 		<div class="bottom_cart_order">
					 			<div class="sub_total_list">
					 				<?php if(shop($shop['id'])->currency_position==1): ?>
					 				<h4><?= lang('total'); ?>: <?= lang('qty'); ?> <span class="cart_count"><?= $this->cart->total_items();?></span> =  	<?= lang('price'); ?> <span class="total_price"><?= number_formats($this->cart->total(),shop($shop['id'])->number_formats)  ;?></span> <?= shop($shop['id'])->icon;?> </h4>
					 			<?php else: ?>
					 					<h4><?= lang('total'); ?>: <?= lang('qty'); ?> <span class="cart_count"><?= $this->cart->total_items();?></span> =  	<?= lang('price'); ?> <?= shop($shop['id'])->icon;?> <span class="total_price"><?= number_formats($this->cart->total(),shop($shop['id'])->number_formats)  ;?></span>  </h4>
					 			<?php endif;?>
					 			</div>
				 			
				 				<a href="<?= base_url('checkout/'.$slug) ;?>" class="btn btn-info btn-block order-btn"><?= !empty(lang('checkout'))?lang('checkout'):'Checkout'  ;?></a>
						 		
					 		</div>
					 	<?php endif;?>

				<?php else: ?> <!-- is_active by pcakage-->
					<div class="top_cart_order">
						<div class="limit_msg">
							<i class="fa fa-frown fa-3x"></i>
							<h4><?= lang('sorry_cant_take_order'); ?></h4>
							<a href="<?= base_url('contacts/'.$slug) ;?>" class="btn btn-info custom_btn mt-15"><?= lang('contact_us'); ?></a>
						</div>
					</div>
				<?php endif;?> <!-- is_active -->
		<?php else: ?>
			<div class="top_cart_order">
				<div class="limit_msg">
					<i class="fa fa-frown fa-3x"></i>
					<h4><?= lang('today_remaining_off'); ?></h4>
					<a href="<?= base_url('contacts/'.$slug) ;?>" class="btn btn-info custom_btn mt-15"><?= lang('contact_us'); ?></a>
				</div>
			</div>
		<?php endif;?>
 	</div>
 </div>


<!-- cart notify -->
<div class="cartNotify_wrapper">
	
</div>
<!-- cart notify -->

 <!-- Modal -->
<div class="modal fade itemPopupModal" id="itemModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" id="item_details">
    
  </div>
</div>




<!-- Modal -->
<div class="modal fade" id="orderModal"  data-backdrop="static">
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content" id="showOrderModal">
        
    </div>
  </div>
</div>

<!--  -->
<div class="modal fade" id="closeModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"><?= lang('alert'); ?></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="closeShop">
        	<i class="fa fa-frown fa-2x"></i>
        	<div class="mt-10">
        		<h4><?= !empty(lang('sorry_we_are_closed'))?lang('sorry_we_are_closed'):"Sorry We are closed" ;?></h4>
        		<p><?= !empty(lang('please_check_the_available_list'))?lang('please_check_the_available_list'):"please check the available list" ;?></p>
        	</div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?= lang('close'); ?></button>
      </div>

    </div>
  </div>
</div>

<?php  include APPPATH."views/layouts/waiterModal.php";?>