 <?php if(isset(restaurant()->id) && !empty(restaurant()->id)):?>
 <?php $dine = $this->admin_m->get_new_dine_order(restaurant()->id);?>
 <?php $waiter = $this->admin_m->get_todays_waiter_notification(restaurant()->id,1);?>
 <a href="<?= base_url("admin/auth/tables");?>" class="fz-20 <?= $dine > 0 || $waiter > 0?"activNotify":"";?>"><i class="icofont-bell"></i></a>
 <?php endif;?>