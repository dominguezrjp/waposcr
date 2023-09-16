<div class="row">
	<div class="col-md-6">
		<form action="<?= base_url('admin/coupon/create_coupon') ;?>" method="post" class="validForm">
			<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
			<div class="card">
				<div class="card-header"><h4><?= lang('add_coupon'); ?></h4></div>
				<div class="card-body">
					<div class="row">
						<div class="form-group col-md-12">
							<label for=""><?= lang('title'); ?></label>
							<input type="text" name="title" class="form-control" placeholder="<?= lang('title'); ?>" value="<?= !empty($data['title'])?$data['title']:'' ;?>">
						</div>

						<div class="form-group col-md-12">
							<label for=""><?= lang('coupon_code'); ?> <span class="error">*</span></label>
							<div class="input-group">
								<input type="text" name="coupon_code" class="form-control showCode remove_space" placeholder="<?= lang('coupon_code'); ?>" required value="<?= !empty($data['coupon_code'])?$data['coupon_code']:'' ;?>">
								<span class="input-group-addon btn btn-default"><label class="pointer d-flex-center generateCode" onclick="makeid(8)"><?= lang('generate_code'); ?></label></span>
							</div>
							
						</div>
						<div class="form-group col-md-6">
							<label for=""><?= lang('limit'); ?></label>
							<input type="number" name="total_limit" class="form-control" placeholder="<?= lang('limit'); ?>" value="<?= !empty($data['total_limit'])?$data['total_limit']:'' ;?>">
						</div>

						<div class="form-group col-md-6">
							<label for=""><?= lang('discount'); ?></label>
							<div class="input-group">
								<input type="number" class="form-control" name="discount" required value="<?= !empty($data['discount'])?$data['discount']:'' ;?>" placeholder="<?= lang('discount'); ?>">
								<span class="input-group-addon">%</span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							<label for=""><?= lang('start_date');?></label>
							<div class="input-group">
								<input type="text" name="start_date" class="form-control datepicker pl-10" placeholder="yyyy-mm-dd" value="<?= !empty($data['start_date'])?$data['start_date']:'' ;?>">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							</div>
						</div>

						<div class="form-group col-md-6">
							<label for=""><?= lang('end_date');?></label>
							<div class="input-group">
								<input type="text" name="end_date" class="form-control datepicker pl-10" placeholder="yyyy-mm-dd" required value="<?= !empty($data['end_date'])?$data['end_date']:'' ;?>">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							</div>
						</div>
					</div>
				</div><!-- card-body -->
				<div class="card-footer text-right">
					<input type="hidden" name="id" value="<?= isset($data['id']) && !empty($data['id'])?$data['id']:0 ;?>">
					<a href="<?= base_url("admin/coupon");?>" class="btn btn-default pull-left"><?= lang('cancel');?></a>
					<button type="submit" class="btn btn-secondary"><?= lang('submit'); ?></button>
				</div>
			</div>
		</form>
	</div>
</div>


<script>
	function makeid(length) {
		var result           = '';
		var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		var charactersLength = characters.length;
		for ( var i = 0; i < length; i++ ) {
			result += characters.charAt(Math.floor(Math.random() * 
				charactersLength));
		}

		$('.showCode').val(result.toUpperCase());
		return result;
	}
</script>