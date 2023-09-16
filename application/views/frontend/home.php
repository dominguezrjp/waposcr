<div class="home_wrapper">
	<?php $settings = settings(); ?>
	<?php $social = isJson($settings['social_sites'])?json_decode($settings['social_sites'],TRUE):''; ?>
	<?php  $home = section_name('home'); ?>
	<?php if($home['status']==1): ?>
		<div class="topHome_banner bg_loader" data-src="<?=!empty($home['images'])?base_url(html_escape($home['images'])):base_url('assets/frontend/images/banner.png');?>" id="hero" style="background: url(<?= bg_loader();?>)">
			<div class="homeTopBanner">
				<div class="container">
					<div class="row">
				        <div class="col-lg-7 pt-5 pt-lg-0 order-2 order-lg-1 d-flex align-items-center">
				          <div data-aos="zoom-out" data-aos-delay='1000'>
				            <h1><?= !empty($home)?html_escape($home['heading']):'Create Your space  With ' ;?><span> <?=  html_escape($settings['site_name']);?></span></h1>
				            <h2><?= !empty($home)?html_escape($home['sub_heading']):'Create The Great First Impression' ;?></h2>
				            <div class="text-center text-lg-left home_button">
				            	
				            <?php if(!empty(section_name('pricing')) && $settings['is_registration']==1): ?>
				              <a href="#pricing" class="btn-get-started nav-link scrollto"><?= lang('get_start'); ?></a>
				          	<?php endif;?>



				              <?php if(isset($social['youtube']) && !empty($social['youtube'])): ?>
					              <a href="<?= html_escape($social['youtube']) ;?>" class="video_play_btn venobox" data-autoplay="true" data-vbtype="video">
					              		<span  class="play-btn" ><i class="icofont-play"></i></span>
					              		<span class="hidden-xs"><?= lang('play_video'); ?></span>
					              </a>
					          <?php endif;?>
				              
				            </div>
				          </div>
				        </div>
				        <div class="col-lg-5 order-1 order-lg-2 hero-img">
				        	<div class="home_left_img">
								<img src="<?= !empty($settings['home_banner'])?base_url($settings['home_banner']): base_url(html_escape(settings()['site_qr_link']))?>" alt="home banner">
							</div>
				        </div>
				      </div>
				</div>
				<?php if(isset($settings['restaurant_demo'])  && !empty($settings['restaurant_demo'])): ?>
						<a href="<?= base_url($settings['restaurant_demo']) ;?>" class="resaurantDemo" style="position: absolute;
						    bottom: -30px;
						    z-index: 999;
						    display: inline-block;
						    background: #007bff;
						    color: #fff;
						    padding: 8px 20px;
						    border-radius: 8px; margin-bottom: 15px;">Restaurant Demo</a>
	  				<?php endif;?>
			</div>
		</div>
	<?php endif; ?>
	<div class="container">
		<div class="home_top_banner">
			<div class="row">
				<div class="col-md-8">
					<div class="home_right_test">
						<h4><?=  html_escape($settings['site_name']);?></h4>
						<p><?=  !empty($settings['long_description'])?$settings['long_description']:$settings['description'];?></p>
					</div>
				</div>
				<?php if($settings['is_order_video']==1): ?>
					<div class="col-md-4">
						<div class="device-wrapper animated">
						  <div class="device" data-device="iPhoneX" data-orientation="portrait" data-color="black">
						    <div class="screen">
						    	<iframe width="560" height="315" src="<?= !empty($social['order_video'])?$social['order_video']:'https://www.youtube.com/embed/c5XCpSv0WHk' ;?>?autoplay=1&loop=1&controls=0&showinfo=0&modestbranding=1&rel=0&iv_load_policy=3&playlist=<?= !empty($social['order_video'])?get_youtube_id($social['order_video']):"c5XCpSv0WHk" ;?>" frameborder="0" allowfullscreen></iframe>
						    </div>
						  </div>
						</div>
					</div>
				<?php endif;?>

				
			</div>
			
		</div>
	</div>
</div>


<?php if(isset($this->settings['is_item_search']) && $this->settings['is_item_search']==1): ?>

	<section class="nearbySection">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-8">
					<form action="#" method='post' class="searchItemForm">
						<div class="nearbyArea">
							<div class="searchInput">
								<input type="text" name="q" class="form-control sarchValue" placeholder="<?= lang('search_for_items'); ?>">
								<div class="user_right_btn_area">
									<button type="submit" class="btn btn-primary c_btn"><i class="icofont-search-user"></i> <?= lang('search'); ?></button>
								</div>
							</div>
							<?php  if($this->admin_m->count_table('shop_location_list') > 0):?>
								<div class="findNearby">
									<button type="button" class="btn btn-secondary c_btn" id="getLocation"><i class="icofont-google-map"></i> <?= lang('near_me'); ?></button>
								</div>
							<?php endif ?>
						</div>
					</form>
					<div class="errorMSG" id="errorMsg"></div>
				</div>
			</div>
			<div class="restaurantList " id="shopList">
				<div class="topPopularshop homePopular pb-80">
					<div class="row">
						<div class="col-md-12">
							<div class="itemHeading">
								<h4><?= lang('popular_store') ;?></h4>
							</div>
						</div>
					</div>
					<div class="row">
						<?php foreach ($top_8_shop as $key => $row): ?>
							<?php include 'inc/shop_thumb.php'; ?>
						<?php endforeach ?>
					</div>
				</div><!-- topPopularshop -->

				<div class="popularItem homePopular">
					<div class="row">
						<div class="col-md-12">
							<div class="itemHeading">
								<h4><?= lang('popular_items'); ?></h4>
							</div>
						</div>
					</div>
					<!-- popular item thumb -->
					<?php include 'inc/popularItem_thumb.php'; ?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>


<?php if(!empty(section_name('pricing')) && $settings['is_registration']==1): ?>
	<?php include "inc/hero_section.php"; ?>
<?php endif;?>




<!-- How it works -->
<?php  $how_it_works = section_name('how_it_works'); ?>
<?php if(!empty($how_it_works) && $how_it_works['status']==1): ?>
	<section class=" default services_area how_it_works">
		<div class="container">
			<?php if(count($how_works) >0): ?>
				<div class="row">
					<div class="col-md-12 col-sm-12 features-heading">
			             <h2 class="heading-text"><?= html_escape($how_it_works['heading']) ;?></h2>
			            <p><?= html_escape($how_it_works['sub_heading']) ;?></p>
			        </div>
					<?php foreach ($how_works as $key => $works):?>
						<div class="col-lg-4 col-sm-6" data-aos="fade-up" data-aos-delay="<?= $key+1 ;?>00">
							<div class="single_serivce_area" >
								<div class="single_service">
									<div class="home_service_img">
										<img src="<?= base_url($works['thumb']) ;?>" alt="<?= html_escape($works['title']) ;?>">
									</div>
									<div class="top_service">
										<h4 class=""><?= html_escape($works['title']) ;?></h4>
									</div>
									<div class="service_details">
										<p><?php if(strlen($works['details']) >= 80): ?>
										<?= character_limiter($works['details'],65);?><a href="#worksModal_<?= $works['id'];?>" data-toggle="modal" class="learn_more_link"><?= lang('read_more'); ?></a>
										<?php else: ?>
											<?= html_escape($works['details']);?>
										<?php endif;?>
											
										</p>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php else: ?>
				<div class="row">
					<div class="empty_area">
						<div class="empty_text">
							<i class="fa fa-frown fa-2x"></i>
							<h4>Sorry! Data Not found</h4>
							<code>Admin-> Home -> How it works -> Add How it works</code>
						</div>
					</div>
				</div>
			<?php endif;?>
		</div>
	</section>
<?php endif;?>

<?php  $features = section_name('features'); ?>
<?php if(!empty($features) && $features['status']==1): ?>
	<section class="default feature_area">
		<div class="container">
			<?php if(count($left_features) >0 && count($right_features) >0): ?>
				<div class="row">
			        <div class="col-md-12 col-sm-12 features-heading top_heading">
			            <h2 class="heading-text"><?= html_escape($features['heading']) ;?></h2>
			            <p><?= html_escape($features['sub_heading']) ;?></p>
			        </div>
			        <!--col-md-12-->
			        <div class="col-lg-4 col-sm-12 features-text mr-0 pr-0">
			            <?php foreach ($left_features as $key => $left): ?>
			            	<div class="features_warp_content" data-aos="fade-right" data-aos-delay="<?= $key+1 ;?>0">
				                <div class="features-wrap left_wrap">
				                    <div class="features-content">
				                        <h4><?=  html_escape($left['title']);?></h4>
				                        <p><?=  character_limiter(html_escape($left['details']),120);?> </p>
				                    </div>
				                    <!--features-content-->
				                    <?php if(!empty($left['icon'])): ?>
				                    	<?= $left['icon'] ;?>
				                    <?php else: ?>
				                    	 <img src="<?= html_escape(base_url($left['thumb'])) ;?>" alt="<?=  html_escape($left['title']);?>">
				                    <?php endif;?>
				                </div>
				            </div>
			             <?php endforeach;?>

			        </div>
			        <!--col-md-6-->
			        <div class=" col-lg-3 col-sm-6">
			            <div class="features-img" data-aos="zoom-in" data-aos-delay="100">
			                <img src="<?= !empty($features['images'])?base_url($features['images']):"" ;?>" alt="features-img">
			            </div>
			            <!--features-img-->
			        </div>

			        <!--col-md-4-->
			        <div class="col-lg-4 col-sm-12  features-text ml-0 pl-0">
			            <?php foreach ($right_features as $key => $right): ?>
			               <div class="features_warp_content" data-aos="fade-left" data-aos-delay="<?= $key+1 ;?>0">
				               	<div class="features-wrap right_wrap" >
				                    <?php if(!empty($right['icon'])): ?>
				                    	<?= $right['icon'] ;?>
				                    <?php else: ?>
				                    	 <img src="<?= base_url($right['thumb']) ;?>" alt="<?=  html_escape($right['title']);?>">
				                    <?php endif;?>
				                    <div class="features-content">
				                        <h4><?=  html_escape($right['title']);?></h4>
				                        <p><?=  character_limiter(html_escape($right['details']),120);?> </p>
				                    </div>
				                    <!--features-content-->
				                </div>
			               </div>
			             <?php endforeach; ?>
			           
			        </div>
			        <!--col-md-6-->
			    </div>
		    <!--row-->
		    <?php else: ?>
		    	<div class="row">
					<div class="empty_area">
						<div class="empty_text">
							<i class="fa fa-frown fa-2x"></i>
							<h4>Sorry! Data Not found</h4>
							<code>Admin-> settings -> Home settings -> Add Section Banners</code>
						</div>
					</div>
				</div>
		    <?php endif;?>
		</div>
	</section>
<?php endif;?>


<?php  $faq = section_name('faq'); ?>
<?php if(!empty($faq) && $faq['status']==1): ?>
	<section class=" default services_area">
		<div class="container">
			<?php if(count($faqs)>0): ?>
				<div class="row">
					<div class="col-md-12 col-sm-12 features-heading">
						 <h2 class="heading-text"><?= html_escape($faq['heading']) ;?></h2>
			            <p><?= $faq['sub_heading'] ;?></p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6" >
						<div class="accordion_area">
							<div class="accordions">
								<?php foreach ($faqs as $key=> $home_faq): ?>
									<div class="single_accordion" dir="<?= direction();?>" data-aos="fade-up" data-aos-delay="<?=  $key+1;?> 000">
										<div class="page_accordion_header active arrow_down"><?= html_escape($home_faq['title']);?></div>
										<div class="accordion_content block">
											<?=$home_faq['details'];?>
										</div>
									</div>
								<?php endforeach; ?>
							</div>   
						</div>
					</div>
					<div class="col-md-6" data-aos="fade-left" data-aos-delay="100">
						<div class="faq_images">
							<img src="<?=!empty($faq['images'])?base_url($faq['images']):base_url('assets/frontend/images/faq.jpg');?>" alt="Faq Image">
						</div>
					</div>
				</div>
			<?php else: ?>
				<div class="row">
					<div class="empty_area">
						<div class="empty_text">
							<i class="fa fa-frown fa-2x"></i>
							<h4>Sorry! Data Not found</h4>
							<code>Admin-> Home -> FAQ -> Add FAQ</code>
						</div>
					</div>
				</div>
			<?php endif;?> 
		</div>
	</section>
<?php endif;?> 

<?php  $pricing = section_name('pricing'); ?>
<?php if(!empty($pricing) && $settings['is_registration']==1): ?>
	<section class="home_pricing teamSections" id="pricing">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 features-heading">
					<h2 class="heading-text"><?= html_escape($pricing['heading']) ;?></h2>
					<p><?= html_escape($pricing['sub_heading']) ;?></p>
				</div>
			</div>
			<?php include "inc/pricing_".$settings['pricing_layout'].".php"; ?>
		</div>
	</section>
<?php endif;?>





<?php  $home_services = section_name('services'); ?>
<?php if(!empty($home_services) && $home_services['status']==1): ?>
	<section class="default service_area">
		<div class="container">
			<?php if(count($services)>0): ?>
				<div class="row">
					<div class="col-md-12 col-sm-12 features-heading">
						<h2 class="heading-text"><?= html_escape($home_services['heading']) ;?></h2>
						<p><?= html_escape($home_services['sub_heading']) ;?></p>
					</div>
				</div>
				<?php foreach ($services as $key=> $row): ?>
					<div class="row mtb-20 mi-shadow home_service_mr <?=($key+1)%2==0?'row_reverse':'';?> " data-aos="fade-down"  data-aos-delay="<?= $key+1;?>00">
						<div class="col-sm-6">
							<div class="service_home_img ">
								<img src="<?= base_url($row['images']);?>" alt="service_home_img">
							</div>
						</div>
						<div class="col-sm-6" >
							<div class="service_home_details <?=($key+1)%2==0?'text-right':'text-left';?>">
								<div class="service_home_title">
									<h4><?= html_escape($row['title']);?></h4>
								</div>
								<p><?= $row['details'];?></p>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			<?php else: ?>
					<div class="row">
						<div class="empty_area">
							<div class="empty_text">
								<i class="fa fa-frown fa-2x"></i>
								<h4>Sorry! Data Not found</h4>
								<code>Admin-> Home -> services -> Add services</code>
							</div>
						</div>
					</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>

<?php  $home_team = section_name('teams'); ?>
<?php if(!empty($home_team) && $home_team['status']==1): ?>
  <div class="default teamSections section-padding-top section-padding-bottom">
    <div class="container">
    	<?php if(count($team) > 0): ?>
        	<div class="row">
				<div class="col-md-12 col-sm-12 features-heading">
					 <h2 class="heading-text"><?= html_escape($home_team['heading']) ;?></h2>
	           		 <p><?= html_escape($home_team['sub_heading']) ;?></p>
				</div>
			</div>
            <div class="team_section">
                <div class="row team_slider slider-nav">
	              <?php foreach ($team as $key=> $row): ?>
	                <div class="teamLead">
	                  <div class="single_team style_2">
	                    <div class="team_header">
	                      <img src="<?= base_url($row['images']);?>" alt="team image">
	                      <div class="team_details">
	                        <h5><?= html_escape($row['name']);?></h5>
	                        <p><?= html_escape($row['designation']);?></p>
	                      </div>
	                    </div>
	                  </div>
	                </div>
            	<?php endforeach ?>
             	</div>
          	</div>
      	<?php else: ?>
          	<div class="row">
				<div class="empty_area">
					<div class="empty_text">
						<i class="fa fa-frown fa-2x"></i>
						<h4>Sorry! Data Not found</h4>
						<code>Admin-> Home -> Teams -> Add Teams</code>
					</div>
				</div>
			</div>
		<?php endif ?>
    </div>
  </div>
<?php endif; ?>



<?php if(!empty($how_it_works) && $how_it_works['status']==1 && count($how_works)>0): ?>

	<?php foreach ($how_works as $key => $works_modal): ?>
		<?php if(strlen($works_modal['details']) >= 40): ?>
			<!-- Modal -->
			<div class="modal fade" id="worksModal_<?= $works_modal['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel"><?= html_escape($works_modal['title']);?></h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<?= $works_modal['details'];?>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang('close'); ?></button>
						</div>
					</div>
				</div>
			</div>
		<?php endif;?>
	<?php endforeach ?>
<?php endif;?>

