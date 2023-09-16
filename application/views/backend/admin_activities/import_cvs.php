<div class="row">
	<div class="col-md-6">
		<form action="<?= base_url("admin/auth/upload_file");?>" method="post" id="import_csv" enctype="multipart/form-data">
			<?= csrf();?>
			<div class="form-group">
				<label>Select CSV File</label>
				<input type="file" name="file" id="csv_file" required accept=".json" />
			</div>
			<br />
			<button type="submit" name="import_csv" class="btn btn-info" id="import_csv_btn">Import CSV</button>
		</form>
	</div>
</div>