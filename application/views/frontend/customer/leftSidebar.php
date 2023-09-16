<div class="leftSidebar">
    <div class="topInfo">
        <div class="topImg">
            <img src="<?= base_url(!empty($info['thumb'])?$info['thumb']:IMG_PATH.'avatar.png') ;?>" alt="">
        </div>
        <div class="leftDetails">
            <h4><?= $info['customer_name'];?></h4>
            <p><?=  my_currency($info['country_id'],'dial_code');?> <?= $info['phone'] ;?></p>
            <p class="badge badge-secondary"><?= !empty(lang('customer'))?lang('customer'):"Customer"; ?></p>
        </div>
    </div>
    <div class="leftSideDetails">
        <ul>
            <li class="<?= isset($page_title) && $page_title=="Customer OrderList"?"active":"";?>"><a
                    href="<?= base_url('staff/order_list'); ?>"><i class="fa fa-shopping-basket"></i><span
                        class="hidden-xs hidden-sm"> <?= !empty(lang('order'))?lang('order'):"Order"; ?></span></a></li>

            <li class="<?= isset($page_title) && $page_title=="Customer Panel"?"active":"";?>"><a
                    href="<?= base_url('staff/customer') ;?>"><i class="fa fa-user-circle-o"></i> <span
                        class="hidden-xs hidden-sm"><?= !empty(lang('personal_info'))?lang('personal_info'):"Personal Info" ;?></span>
                </a></li>

            <li class="<?= isset($page_title) && $page_title=="Customer Password"?"active":"";?>"><a
                    href="<?= base_url('staff/password') ;?>"><i class="fa fa-key"></i> <span
                        class="hidden-xs hidden-sm">
                        <?= !empty(lang('change_pass'))?lang('change_pass'):"Change Password" ;?></span></a></li>

            <li><a href="<?= base_url('staff/logout?type=customer'); ?>"><i class="fa fa-sign-out"></i> <span
                        class="hidden-xs hidden-sm"><?= !empty(lang('logout'))?lang('logout'):"Logout" ;?></span></a>
            </li>
        </ul>
    </div>
</div>