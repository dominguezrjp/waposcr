 <?php if ($this->session->flashdata('warning')) { ?>
	<div class="alert alert-danger alert-dismissible" role="alert">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	 <h4> <i class="icon fa fa-exclamation-circle"></i>
            <?= !empty(lang('error'))?lang('error'):"Error";?></h4>
        <p><?= $this->session->flashdata('warning');?></p>
	</div>
<?php } ?>