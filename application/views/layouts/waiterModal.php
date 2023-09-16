<!--  -->
<div class="modal fade" id="waiterModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content b-gray">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title"><?= lang('call_waiter'); ?></h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <?php if($shop['is_call_waiter']==1): ?>
	      <?php  $table_list = $this->common_m->select_all_by_user($id,'table_list')?>
	      <form action="<?= base_url('profile/call_waiter') ;?>" class="defaultForm callWaiterForm">
	      	<?= csrf(); ;?>
		      <!-- Modal body -->
		      <div class="modal-body">
		      	<?php if($this->session->flashdata('MSG')): ?>
			      	<?= $this->session->flashdata('MSG'); ?>
			      <?php endif;?>
		      	<span class="reg_msg"></span>
		        <div class="form-group">
		        	<select name="table_no" id="table_no" class="form-control">
		        		<?php if(!isset($_GET['q'])): ?>
			        		<option value=""><?= lang('select_table'); ?></option>
			        	<?php endif; ?>
		        		<?php foreach ($table_list as $key => $table): ?>
		        					<?php if(isset($_GET['q']) && $_GET['q']=='table' && $_GET['qr']==$table['id']): ?>
			        					<option value="<?=  $table['id'];?>" <?= isset($_GET['qr']) && $_GET['qr']==$table['id']?"selected":'' ;?>><?= $table['name']; ?></option>
			        				<?php elseif(!isset($_GET['q'])): ?>
			        					<?php echo "<pre>";print_r('pp');?>
			        					<option value="<?=  $table['id'];?>"><?= $table['name']; ?></option>
		        					<?php endif; ?>
		        		<?php endforeach ?>
		        	</select>
		        </div>

		       	 <?php if(isset($_GET['q']) && $_GET['q']=='table'): ?>
		        	<?php else: ?>
			        <?php if(restaurant($id)->is_pin==1): ?>
				        <div class="form-group">
				        	<label for=""><?= lang('security_pin'); ?></label>
				        	<input type="password" name="pin_number" class="form-control" placeholder="<?= lang('security_pin'); ?>">
				        </div>
				      <?php endif;?>
				    <?php endif ?>
		      </div>
		      <!-- Modal footer -->
		      <div class="modal-footer">
		      	<input type="hidden" name="shop_id" value="<?= $shop['id'] ;?>">
		      	<input type="hidden" name="user_id" value="<?= $shop['user_id'] ;?>">
		        <button type="submit" class="btn btn-secondary"><?= lang('call'); ?> <i class="icofont-hand-drag1"></i> </button>
		      </div>
		    </form>
	  <?php else: ?>
	  	<div class="modal-body">
	  		<div class="empty_msg">
	  			<h4><?= lang('sorry_we_are_closed');?></h4>
	  		</div>
	  	</div>
	  <?php endif ?>
    </div>
  </div>
</div>