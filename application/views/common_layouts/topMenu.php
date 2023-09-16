  <?php $u_info = get_user_info_by_slug($slug); ?>
  <?php $language = shop_languages($id); ?>
  <?php $glang = glang($id); ?>
  <?php $settings = settings(); ?>
 <div class="userMenu ">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <div class="container">
                  <a class="navbar-brand" href="<?=url($slug) ;?>"><img src="<?=  !empty(restaurant($id)->thumb)? base_url(restaurant($id)->thumb):base_url("assets/frontend/images/logo-example.png") ?>" alt="shopLogo" class="shopLogo"> </a>
                  <ul class="smDropdown">
                    <?php if ($shop['is_language']==1) : ?>
                        <?php if (isset($glang['is_glang']) && $glang['is_glang']==1) : ?>
                        <li class="gLanguage allow-sm">
                            <div class="gtranslate_wrapper"></div>
                        </li>
                        <?php else : ?>
                            <?php if (sizeof($language) > 1) : ?>
                                <li class="dropdownMenu allow-sm"><a class="nav-link p-r" href="javascript:;" ><i class="icofont-globe"></i> <span class=""><?= !empty(auth('site_lang'))?auth('site_lang'):$settings['language'] ;?></span></a>
                                    <div class="dropdownArea dropdownList" style="display: none;">
                                        <ul>
                                            <?php foreach ($language as $ln) : ?>
                                                <li><a href="<?= base_url('home/lang_switch/'.$ln->slug) ;?>"><?= $ln->lang_name;?></a></li>
                                            <?php endforeach ?>
                                        </ul>
                                    </div>
                                </li>
                            <?php endif;?>
                        <?php endif; ?>
                    <?php endif;?>
                    
                    <?php if ($shop['is_call_waiter']==1) : ?>
                        <li  class="nav-item allow-sm" ><a class="nav-link" class="nav-link" href="javascript:;" data-toggle="modal" data-target="#waiterModal"><i class="icofont-bell-alt"></i></a></li>
                    <?php endif;?>
                   
                  </ul>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <div class="container-fluid">
                        <div class="userMenu_flex">
                            <ul class="navbar-nav">
                            <?php if (is_feature($id, 'welcome')==1 && is_active($id, 'welcome')) : ?>
                              <li class="nav-item <?= isset($page_title) && $page_title=="Profile"?"active":"" ;?>">
                                <a class="nav-link" href="<?= url($slug) ;?>"><?= lang('home');?> <span class="sr-only">(current)</span></a>
                              </li>
                            <?php endif;?>

                            <?php if (is_feature($id, 'menu')==1 && is_active($id, 'menu')) : ?>
                              <li class="nav-item <?= isset($page_title) && $page_title=="Menus"?"active":"" ;?>">
                                <a class="nav-link" href="<?= url('menu/'.$slug) ;?>"><?= get_features_name('menu');?></a>
                              </li>
                            <?php endif;?>

                            <?php if (is_feature($id, 'packages')==1 && is_active($id, 'packages')) : ?>
                              <li class="nav-item <?= isset($page_title) && $page_title=="Packages"?"active":"" ;?>">
                                <a class="nav-link" href="<?=url('packages/'.$slug) ;?>"><?= get_features_name('packages');?></a>
                              </li>
                            <?php endif;?>
                            <?php if (is_feature($id, 'specialities')==1 && is_active($id, 'specialities')) : ?>
                              <li class="nav-item <?= isset($page_title) && $page_title=="Specialties"?"active":"" ;?>">
                                <a class="nav-link" href="<?= url('specialities/'.$slug) ;?>"> <?= get_features_name('specialities');?></a>
                              </li>
                            <?php endif;?>

                                <li class="dropdownMenu moreMenuBtn"><a href="javascript:;" class=""><?= lang('more') ;?> <i class="icofont-rounded-down"></i></a>
                                
                                <div class="dropdownArea" style="display: none;">
                                    <ul>



                                        <li class="nav-item allow-sm"><a class="nav-link" href="<?= url('track-order/'.$slug) ;?>">  <?= lang('track_order'); ?></a></li>

                                        <?php if (is_feature($id, 'reservation')==1 && is_active($id, 'reservation')) : ?>
                                            <li  class="nav-item allow-sm" ><a class="nav-link" href="<?= url('reservation/'.$slug);?>"> <?= get_features_name('reservation');?></a></li>
                                        <?php endif;?>

                                        <?php if (is_feature($id, 'contacts')==1 && is_active($id, 'contacts')) : ?>
                                        <li  class="nav-item allow-sm" ><a class="nav-link" href="<?= url('shop-contacts/'.$slug);?>"><?= get_features_name('contacts');?></a></li>
                                        <?php endif;?>

                                        <li  class="nav-item allow-sm" ><a class="nav-link" href="<?= url('about-us/'.$slug);?>"><?= lang('about_us'); ?></a></li>

                                        <li  class="nav-item allow-sm" ><a class="nav-link" href="<?= base_url('login') ;?>"><?= lang('login'); ?></a></li>
                                      
                                      </ul>
                                </div>
                                </li>

                            </ul>
                            <div class="rightMenu">
                                <ul>
                                    <li class="cart navCart dis_none" style="display:none;"><a class="nav-link" href="javascript:;" data-slug="<?= $slug;?>"><i class="icofont-cart-alt fa-2x"></i> <span class="cart_count total_count"><?= $this->cart->total_items() ;?></span></a></li>
                                    <?php if ($shop['is_language']==1) : ?>
                                        <?php if (isset($glang['is_glang']) && $glang['is_glang']==1) : ?>
                                            <li class="gLanguage">
                                                <div class="gtranslate_wrapper"></div>
                                            </li>
                                        <?php else : ?>
                                            <?php if (count($language) > 1) : ?>
                                                <li class="dropdownMenu"><a class="nav-link p-r btn" href="javascript:;" ><i class="icofont-globe"></i> <?= !empty(auth('site_lang'))?auth('site_lang'):$settings['language'] ;?></a>
                                                    <div class="dropdownArea dropdownList" style="display: none;">
                                                        <ul>
                                                            <?php foreach ($language as $ln) : ?>
                                                                    <li><a href="<?= base_url('home/lang_switch/'.$ln->slug) ;?>"><?= $ln->lang_name;?></a></li>
                                                            <?php endforeach ?>
                                                        </ul>
                                                    </div>
                                                </li>
                                            <?php endif;?>
                                        <?php endif;?><!-- glang -->
                                    <?php endif;?>


                                    <?php if ($shop['is_call_waiter']==1) : ?>
                                        <li class="callwaiter"><a class="nav-link" href="javascript:;" data-toggle="modal" data-target="#waiterModal"><i class="icofont-bell-alt"></i> <?= lang('call_waiter'); ?></a></li>

                                    <?php endif;?>

                                    <li class="nav-item ml-10" ><a href="<?= base_url("staff-login/customer");?>"> <i class="icofont-login"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                  </div>
          </div>
        </nav>
    </div>
 </div>

<!-- style 1 -->





  
 <?php $disable_pages = ['Payment Gateway','All Orders','Checkout']; ?>
 <?php if (isset($page_title) && !in_array($page_title, $disable_pages)) : ?>
     <div class="cartFloatingIcon menuStyle<?= $u_info['menu_style'];?>">  
        <?php include  APPPATH."views/common_layouts/cart_floating_icon.php"; ?>      
    </div>      
 <?php endif; ?>

<!-- cart right sidebar -->
 <div class="shopping_cart style_2">
    <div class="shopping_cart_content">
        <?php include APPPATH."views/common_layouts/cart_sidebar.php"; ?>
    </div>
 </div>

 <?php if ($shop['is_language']==1) : ?>
        <?php if (isset($glang['is_glang']) && $glang['is_glang']==1 && $u_info['menu_style']==1) : ?>
            <li class="gLanguage allow-sm menuStyle_<?= $u_info['menu_style'];?>">
                <div class="gtranslate_wrapper"></div>
            </li>
        <?php endif; ?>
 <?php endif; ?>


<!-- cart notify / cart added msg -->
<div class="cartNotify_wrapper">
    
</div>
<!-- cart notify -->

<!-- responsive Menu -->

<div class="UserResponsive_menu">
    <div class="UserMobileMenu">
        <ul>
        
                <li data-toggle="tooltip" title="Home" class="<?= isset($page_title) && $page_title=="Profile"?"active":"" ;?>">
                    <?php if (is_feature($id, 'welcome')==1 && is_active($id, 'welcome')) : ?>
                        <a href="<?= url($slug) ;?>"><i class="icofont-home"></i></a>
                    <?php endif;?>
                </li>
            

            
                <li data-toggle="tooltip" title="<?= lang('track_order');?>" class="<?= isset($page_title) && $page_title=="Track Order"?"active":"" ;?>">
                        <a href="<?= url('track-order/'.$slug) ;?>"><i class="icofont-direction-sign"></i></a>
                </li>
            

            <li data-toggle="tooltip" title=""><a href="javascript:;" class="base"><i class="icofont-gears"></i></a></li>

            <li data-toggle="tooltip" title="<?= lang('call_waiter'); ?>" class="">
                <?php if ($shop['is_call_waiter']==1) : ?>
                    <a  href="javascript:;" data-toggle="modal" data-target="#waiterModal"><i class="icofont-bell-alt"></i></a>
                <?php endif;?>
            </li>

             <div class="cartFloatingIcon">  
                <?php include  APPPATH."views/common_layouts/cart_floating_icon.php"; ?> 
            </div>     
       
        </ul>
    </div>

    <div class="show_menu_details">
        <a href="javascript:;" class="closeNavMenu"><i class="icofont-close-line"></i></a>
        <ul>
            <?php if (is_feature($id, 'welcome')==1 && is_active($id, 'welcome')) : ?>
                <li class="nav-item allow-sm"><a class="nav-link" href="<?= url($slug) ;?>"><i class="icofont-home"></i> <?= lang('home'); ?></a></li>
            <?php endif ?>

        <?php if (is_feature($id, 'menu')==1 && is_active($id, 'menu')) : ?>
            <li class="nav-item allow-sm"><a class="nav-link" href="<?= url('menu/'.$slug);?>"><i class="icofont-culinary"></i> <?= lang('menu'); ?></a></li>
        <?php endif ?>

            <?php if (is_feature($id, 'packages')==1 && is_active($id, 'packages')) : ?>
            <li class="nav-item allow-sm"><a class="nav-link" href="<?= url('packages/'.$slug);?>"><i class="icofont-gift"></i> <?= lang('packages'); ?></a></li>
            <?php endif ?>

         <?php if (is_feature($id, 'specialities')==1 && is_active($id, 'specialities')) : ?>
         <li class="nav-item allow-sm"><a class="nav-link" href="<?= url('specialities/'.$slug);?>"><i class="icofont-touch"></i> <?= lang('specialities'); ?></a></li>
         <?php endif ?>


            <li><a href="<?= url('track-order/'.$slug) ;?>"><i class="fa fa-tasks"></i> <?= lang('track_order'); ?></a></li>
            <?php if (is_feature($id, 'reservation')==1 && is_active($id, 'reservation')) : ?>
                <li><a href="<?= url('reservation/'.$slug);?>"><?= get_features_name('reservation');?></a></li>
            <?php endif;?>
            <?php if (is_feature($id, 'contacts')==1 && is_active($id, 'contacts')) : ?>
                <li><a href="<?= url('shop-contacts/'.$slug);?>"><i class="icofont-live-support"></i> <?= get_features_name('contacts');?></a></li>
            <?php endif;?>
            <?php if ($shop['is_call_waiter']==1) : ?>
                <li><a class="nav-link" href="javascript:;" data-toggle="modal" data-target="#waiterModal"><i class="icofont-bell-alt"></i> <?= lang('call_waiter'); ?></a></li>
            <?php endif;?>
            <?php if ($shop['is_language']==1) : ?>
                <li class="dropdownMenu allow-sm"><a class="nav-link p-r" href="javascript:;" ><i class="icofont-globe"></i> <?= !empty(auth('site_lang'))?auth('site_lang'):$settings['language'] ;?></a>
                    <div class="dropdownArea dropdownList" style="display: none;">
                        <ul>
                            <?php foreach ($language as $ln) : ?>
                                <li><a href="<?= base_url('home/lang_switch/'.$ln->slug) ;?>"><?= $ln->lang_name;?></a></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </li>
            <?php endif;?>
            <li><a href="<?= url('about-us/'.$slug);?>"><i class="icofont-info-circle"></i> <?= lang('about_us'); ?></a></li>
            <li><a href="<?= base_url('login') ;?>"><i class="icofont-sign-in"></i> <?= lang('login'); ?></a></li>
        </ul>
    </div>

 </div>

<!-- responsive Menu -->

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
<div class="modal" id="closeModal">
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