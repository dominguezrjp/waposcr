 <li class="nav-drawer-header"><?= lang('account_management'); ?></li>
 <li class="treeview <?= isset($page) && $page=="Users"?"active":"";?>">
 	<a href="#">
 		<i class="fa fa-users"></i>
 		<span><?= !empty(lang('restaurant_list'))?lang('restaurant_list'):"restaurant list";?></span>
 		<span class="pull-right-container">
 			<i class="fa fa-angle-left pull-right"></i>
 		</span>
 	</a>
 	<ul class="treeview-menu">
 		<li class="<?= $page_title =="Total Users"?"active":"";?>">
 			<a href="<?= base_url('admin/dashboard/total_users') ?>">
 				<i class="fa fa-users"></i> <span><?= !empty(lang('total_restaurant'))?lang('total_restaurant'):"total restautant";?></span>
 			</a>
 		</li>
      <?php if(is_access('add-user')==1): ?>
    		<li class="<?= $page_title =="Add User"?"active":"";?>">
    			<a href="<?= base_url('admin/dashboard/add_user') ?>">
    				<i class="fa fa-plus"></i> <span><?= !empty(lang('add_restaurant'))?lang('add_restaurant'):"Add New restaurant";?></span>
    			</a>
    		</li>
      <?php endif ?>
 	</ul>
 </li>

<?php if(is_access('settings-control')==1): ?>
 <!-- settings --> 
     <li class="nav-drawer-header"><?= lang('settings'); ?></li>
     <li class="treeview <?= isset($page) && $page=="Settings" || isset($page) && $page=="Banner Settings" ||  isset($page) && $page=="Upgrade" ||  isset($page) && $page=="Change Domain"?"active":"";?>">
     	<a href="#">
     		<i class="fa fa-cogs"></i>
     		<span><?= !empty(lang('settings'))?lang('settings'):"Settings";?></span>
     		<span class="pull-right-container">
     			<i class="fa fa-angle-left pull-right"></i>
     		</span>
     	</a>
     	<ul class="treeview-menu">
         		<li class="<?= isset($page) && $page =="Settings"?"active":"";?>">
         			<a href="<?= base_url('admin/settings/settings') ?>">
         				<i class="fa fa-cog"></i> <span><?= !empty(lang('site_settings'))?lang('site_settings'):"Site Settings";?></span>
         			</a>
         		</li>

         		<li class="<?= $page_title =="Home Banner Settings"?"active":"";?>">
         			<a href="<?= base_url('admin/settings/banner_settings') ?>">
         				<i class="fa fa-file-image-o"></i> <span><?= !empty(lang('home_banner_setting'))?lang('home_banner_setting'):"Banner settings";?></span>
         			</a>
         		</li>


            <?php if(auth('user_role') ==1 && !auth('is_staff')): ?>

         		<li class="<?= $page_title =="Upgrade"?"active":"";?>">
         			<a href="<?= base_url('admin/dashboard/upgrade/'); ?>">
         				<i class="fa fa-cloud-upload"></i> <span><?= !empty(lang('upgrade_license'))?lang('upgrade_license'):"Upgrade License";?></span>
         			</a>
         		</li> 

         		<li class="<?= $page_title =="Change Domain"?"active":"";?>">
         			<a href="<?= base_url('admin/dashboard/change_domain/'); ?>">
         				<i class="icofont-exchange"></i> <span><?= lang('change_domain');?></span>
         			</a>
         		</li>

              <li class="<?= $page_title =="Add Ons"?"active":"";?>">
                 <a href="<?= base_url('admin/addons/'); ?>">
                    <i class="icofont-ui-rate-add"></i> <span><?= lang('add_ons');?></span>
                 </a>
              </li>
          <?php endif ?>
     		
     	</ul>
     </li>
  <?php endif; ?>
 <?php if(check()==1): ?>
 <li class="<?= $page_title =="Notify"?"active":"";?> <?= is_package;?>">
    <a href="<?= base_url('admin/notify/'); ?>">
        <i class="icofont-bell"></i> <span><?= lang('notifications');?></span>
    </a>
</li>
<?php endif ?>
 <!-- settings -->
<?php if(is_access('package-control')==1): ?>
 <li class="nav-drawer-header"><?= lang('packages_management'); ?></li>
 <li class="treeview <?= isset($page) && $page=="Dashboard"?"active":"";?>">
 	<a href="#">
 		<i class="icofont-addons fz-20"></i>
 		<span><?= !empty(lang('packages'))?lang('packages'):"packages";?></span>
 		<span class="pull-right-container">
 			<i class="fa fa-angle-left pull-right"></i>
 		</span>
 	</a>
 	<ul class="treeview-menu">
 		
 		<li class="<?= $page_title =="Packages"?"active":"";?>">
 			<a href="<?= base_url('admin/dashboard/packages') ?>">
 				<i class="fa fa-angle-double-right"></i> <span><?= !empty(lang('package_list'))?lang('package_list'):"Package List";?></span>
 			</a>
 		</li>
 		<li class="<?= $page_title =="Order Types"?"active":"";?>">
 			<a href="<?= base_url('admin/dashboard/order_types') ?>">
 				<i class="fa fa-angle-double-right"></i> <span><?= !empty(lang('order_types'))?lang('order_types'):"Order Types";?></span>
 			</a>
 		</li>

 		<li class="<?= $page_title =="Features"?"active":"";?>">
 			<a href="<?= base_url('admin/dashboard/features') ?>">
 				<i class="fa fa-angle-double-right"></i> <span><?= !empty(lang('features'))?lang('features'):"Features";?></span>
 			</a>
 		</li>

 		
 		
 	</ul>  
 </li>
<?php endif ?>

<?php if(is_access('home-control')==1): ?>
 <li class="nav-drawer-header"><?= lang('site_management'); ?></li>
 <li class="treeview <?= isset($page) && $page=="Home"?"active":"";?>">
 	<a href="#">
 		<i class="fa fa-home"></i>
 		<span><?= !empty(lang('home'))?lang('home'):"Home";?></span>
 		<span class="pull-right-container">
 			<i class="fa fa-angle-left pull-right"></i>
 		</span>
 	</a>
 	<ul class="treeview-menu">
 		
 		<li class="<?= $page_title =="Services"?"active":"";?>">
 			<a href="<?= base_url('admin/home/services') ?>">
 				<i class="fa fa-angle-double-right"></i> <span><?= !empty(lang('services'))?lang('services'):"Services";?></span>
 			</a>
 		</li>
 		
 		<li class="<?= $page_title =="FAQ"?"active":"";?>">
 			<a href="<?= base_url('admin/home/faq') ?>">
 				<i class="fa fa-angle-double-right"></i> <?= !empty(lang('faq'))?lang('faq'):"Faq / others";?>
 			</a>
 		</li>

 		<li class="<?= $page_title =="Site Features"?"active":"";?>">
 			<a href="<?= base_url('admin/home/site_features') ?>">
 				<i class="fa fa-angle-double-right"></i> <?= !empty(lang('site_features'))?lang('site_features'):"Site Features";?>
 			</a>
 		</li>

 		<li class="<?= $page_title =="Team Members"?"active":"";?>">
 			<a href="<?= base_url('admin/home/team') ?>">
 				<i class="fa fa-angle-double-right"></i> <?= !empty(lang('team'))?lang('team'):"Team";?>
 			</a>
 		</li>


 		<li class="<?= $page_title =="How It Works"?"active":"";?>">
 			<a href="<?= base_url('admin/home/how_it_works') ?>">
 				<i class="fa fa-angle-double-right"></i> <?= !empty(lang('how_it_works'))?lang('how_it_works'):"how it works";?>
 			</a>
 		</li>

 		<li class="<?= $page_title =="Questions"?"active":"";?>">
 			<a href="<?= base_url('admin/home/questions') ?>">
 				<i class="fa fa-question-circle"></i> <?= lang('signup_questions');?>
 			</a>
 		</li>
 		
 	</ul>  
 </li>
 <?php endif ?>
 <?php if(is_access('Language-control')==1): ?>
 <li class="nav-drawer-header"><?= lang('international'); ?></li>
 <li class="treeview <?= isset($page) && $page=="Languages"?"active":"";?>">
 	<a href="#">
 		<i class="fa fa-language"></i>
 		<span><?= !empty(lang('languages'))?lang('languages'):"Languages";?></span>
 		<span class="pull-right-container">
 			<i class="fa fa-angle-left pull-right"></i>
 		</span>
 	</a>
 	<ul class="treeview-menu">
 		<li class="<?= $page_title =="Language"?"active":"";?>"><a href="<?= base_url('admin/home/languages') ?>"><i class="fa fa-angle-double-right"></i> <?= lang('language_list');?></a></li>

 		<li class="<?= $page_title =="Dashboard Language"?"active":"";?>"><a href="<?= base_url('admin/home/dashboard_languages') ?>"><i class="fa fa-angle-double-right"></i> <?= !empty(lang('language_data'))?lang('language_data'):"Languages Data";?></a></li>
 		
 		
 	</ul>
 </li>
<?php endif ?>
 <?php if(is_access('page-control')==1): ?>
 <li class="nav-drawer-header"><?= lang('content'); ?></li>
 <li class="treeview <?= isset($page) && $page=="Pages"?"active":"";?>">
 	<a href="#">
 		<i class="fa fa-files-o"></i>
 		<span><?= !empty(lang('pages'))?lang('pages'):"Pages";?></span>
 		<span class="pull-right-container">
 			<i class="fa fa-angle-left pull-right"></i>
 		</span>
 	</a>
 	<ul class="treeview-menu">

 		<li class="<?= isset($page_title) && $page_title=="Create Pages"?"active":"";?>">
 			<a href="<?= base_url('admin/dashboard/pages') ?>">
 				<i class="fa fa-angle-double-right"></i> <span><?= !empty(lang('add_page'))?lang('add_page'):"Add Pages";?></span>
 			</a>
 		</li>

 		<li class="<?= isset($page_title) && $page_title =="Terms & Conditions"?"active":""; ?>">
 			<a href="<?= base_url('admin/dashboard/terms') ?>">
 				<i class="fa fa-angle-double-right"></i> <span><?= !empty(lang('terms_condition'))?lang('terms_condition'):"Terms & Conditions";?> </span>
 			</a>
 		</li>

 		<li class="<?= isset($page_title) && $page_title =="Cookies & Privacy"?"active":""; ?>">
 			<a href="<?= base_url('admin/dashboard/privacy') ?>">
 				<i class="fa fa-angle-double-right"></i> <span><?= !empty(lang('cookies_privacy'))?lang('cookies_privacy'):"Cookie & Privacy";?> </span>
 			</a>
 		</li>

 		
 		
 	</ul>
 	
 </li>
<?php endif ?>


   <?php if(auth('account_type') ==0 && !auth('is_staff')): ?>
      <li class="treeview <?= isset($page) && $page=="Staff"?"active":"";?>">
        <a href="#">
          <i class="icofont-users-social fz-20"></i>
          <span><?= !empty(lang('staffs'))?lang('staffs'):"Staffs";?></span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="<?= isset($page_title) && $page_title =="Staff"?"active":""; ?>">
            <a href="<?= base_url('admin/adminstaff/') ?>">
             <i class="fa fa-angle-double-right"></i> <?= !empty(lang('staff'))?lang('staff'):"staff";?></span>
           </a>
         </li>  
          <li class="<?= isset($page_title) && $page_title =="Permission List"?"active":""; ?>">
            <a href="<?= base_url('admin/adminstaff/permission_list') ?>">
             <i class="fa fa-angle-double-right"></i> <?= !empty(lang('permission_list'))?lang('permission_list'):"permission_list";?></span>
           </a>
         </li>  
      </ul>
    </li>
  <?php endif; ?>
  
  
<?php if($this->db->table_exists('custom_domain_list')): ?>
     <?php if(auth('account_type') ==0 && !auth('is_staff')): ?>
        <?php if(check()==1): ?>
         <li class="<?= isset($page_title) && $page_title =="Custom Domain"?"active":""; ?> <?= is_package;?>">
            <a href="<?= base_url('admin/dashboard/domain_list') ?>">
                <i class="fa fa-globe" ></i> <span><?= !empty(lang('domain_list'))?lang('domain_list'):"Domain List";?><?php if($this->admin_m->count_table_by_status(0,'custom_domain_list') > 0): ?> <span class="notify"><?= $this->admin_m->count_table_by_status(0,'custom_domain_list') ;?></span><?php endif; ?></span>
            </a>
         </li>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>


<li class="<?= isset($page_title) && $page_title =="Offline Payments"?"active":""; ?>">
    <a href="<?= base_url('admin/dashboard/shop_reviews') ?>">
        <i class="fa fa-star-o" ></i> <span><?= !empty(lang('shop_reviews'))?lang('shop_reviews'):"Shop Reviews";?></span>
    </a>
 </li>


 <li class="<?= isset($page_title) && $page_title =="Reviews"?"active":""; ?>">
    <a href="<?= base_url('admin/dashboard/offline_payments') ?>">
        <i class="fa fa-credit-card-alt" ></i> <span><?= !empty(lang('offline_payments'))?lang('offline_payments'):"Offline Payments";?><?php if($this->admin_m->count_table_by_status(0,'offline_payment') > 0): ?> <span class="notify"><?= $this->admin_m->count_table_by_status(0,'offline_payment') ;?></span><?php endif; ?></span>
    </a>
 </li>


 <li class="<?= isset($page_title) && $page_title =="Transactions"?"active":""; ?>">
 	<a href="<?= base_url('admin/dashboard/transactions') ?>">
 		<i class="fa fa-exchange"></i> <span><?= !empty(lang('user_transaction'))?lang('user_transaction'):"User's Transactions";?> </span>
 	</a>
 </li>


 

 <li class="<?= $page_title =="App Info"?"active":"";?>">
 	<a href="<?= base_url("admin/settings/app_info");?>">
 		<i class="icofont-question-circle fz-20"></i> <span><?= lang('info');?></span>
 	</a>
 </li>




