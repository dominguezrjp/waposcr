<div class="row">
	<div class="col-md-6">
		<form action="<?= base_url("admin/dashboard/request_change_domain");?>" method="post">
			<?= csrf() ;?>
			<div class="card">
				<div class="card-header">
					<h4>Change Domain / Site Url</h4>
				</div>
				<div class="card-body">
					<div class="form-group">
						<label>Domain / Site Url</label>
						<input type="text" name="site_url" class="form-control" placeholder="Your New Url">
					</div>
					<div class="form-group">
						<label>Old Url</label>
						<input type="text" name="old_url" class="form-control" placeholder="Your Old Url" value="<?= get_domain(base_url());?>" readonly>
					</div>
					<div class="form-group">
						<label>Purchase Code</label>
						<input type="text" name="code" class="form-control" placeholder="Purchase Code">
					</div>
				</div>
				<div class="card-footer text-right">
					<input type="hidden" name="site_id" value="<?= $settings['site_id'];?>">
					<button type="submit" class="btn btn-secondary"><?= lang('submit')?></button>
				</div>
			</div>
		</form>
	</div>
</div>