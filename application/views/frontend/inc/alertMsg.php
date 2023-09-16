<?php if ($this->session->flashdata('success')) { ?>
	<span id="alert_title" data-msg="<?= !empty(lang('success'))?lang('success'):"Success";?>!"></span>
	<span id="alert" data-msg="<?php echo $this->session->flashdata('success'); ?>"></span>
	<script>
		$.notify({
			icon: 'fa fa-check',
			title: $('#alert_title').data('msg'),
			message:$('#alert').data('msg')
		},{
			type: 'success'
		},{
			animate: {
				enter: 'animated fadeInRight',
				exit: 'animated fadeOutRight'
			}
		});
	</script>
<?php } ?>

<?php if ($this->session->flashdata('error')) { ?>
	<span id="alert_title" data-msg="<?= !empty(lang('error'))?lang('error'):"Error";?>!!"></span>
	<span id="alert" data-msg="<?php echo $this->session->flashdata('error'); ?>"></span>
	<script>
		$.notify({
			icon: 'fa fa-close',
			title: $('#alert_title').data('msg'),
			message:$('#alert').data('msg')
		},{
			type: 'danger'
		},{
			animate: {
				enter: 'animated fadeInRight',
				exit: 'animated fadeOutRight'
			}
		});
	</script>
	<?php } ?>