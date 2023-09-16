
<div class="row">
	<div class="col-md-8">
		<div class="hide_lang_details">
			<label class="fz-16"><input type="checkbox" value="1" class="details_check"> <?= lang('show_details'); ?></label>
		</div>
	</div>	
	<div class="col-md-12 mb-30	">
		<form action="<?= base_url('admin/home/add_keyword') ;?>" method="post">
			<!-- csrf token -->
			<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

			<div class="row">
				<div class="col-md-3">
					<label><?= lang('keyword'); ?></label>
					<input type="text" name="keyword" class="form-control">
				</div>
				<div class="col-md-3">
					<label><?= lang('values'); ?></label>
					<input type="text" name="value" class="form-control">
				</div>

				<div class="col-md-3">
					<label>Types</label>
					<select name="types" id="" class="form-control">
						<option value="admin">Admin</option>
						<option value="user">User</option>
						<option value="home">Frontend</option>
						<option value="label">Label</option>
					</select>
				</div>
				<div class="col-md-3 mt-10">
					<div class=""><button type="submit" class="btn-primary custom_btn btn mt-10"><?= lang('submit'); ?></button></div>
				</div>
			</div>
		</form>
	</div>
	<div class="col-md-12 col-lg-10">
			<div class="box box-info">
				<div class="box-header with-border h-61">
					<div class="col-md-12">
						<h3 class="box-title"><?= !empty(lang('admin_language'))?lang('admin_language'):"Admin Language Values";?> </h3>
							<div class="box-tools pull-right">
								<select name="limit" class="form-control" id="" onchange="location=this.value;">
									<option value="<?= base_url('admin/home/dashboard_languages?limit=30') ;?>" <?= isset($_GET['limit']) && $_GET['limit']== 30?"selected":"";?>>30</option>
									<option value="<?= base_url('admin/home/dashboard_languages?limit=50') ;?>" <?= isset($_GET['limit']) && $_GET['limit']== 50?"selected":"";?>>50</option>
									<option value="<?= base_url('admin/home/dashboard_languages?limit=100') ;?>" <?= isset($_GET['limit']) && $_GET['limit']== 100?"selected":"";?>>100</option>
									<option value="<?= base_url('admin/home/dashboard_languages?limit=200') ;?>" <?= isset($_GET['limit']) && $_GET['limit']== 200?"selected":"";?>>200</option>
									<option value="<?= base_url('admin/home/dashboard_languages?limit=300') ;?>" <?= isset($_GET['limit']) && $_GET['limit']== 300?"selected":"";?>>300</option>
									<option value="<?= base_url('admin/home/dashboard_languages?limit=500') ;?>" <?= isset($_GET['limit']) && $_GET['limit']== 500?"selected":"";?>>500</option>
								</select>
							</div>
					</div>
					<div class="searchArea text-right col-md-12 pl-0">
						<form action="<?= base_url("admin/home/dashboard_languages");?>" method="get" class="col-md-4 mb-10 pl-0 mt-5">
							<div class="input-group">
							    <input type="text" name="q" class="form-control h-i" placeholder="<?= lang('search');?>">
							    <div class="input-group-btn">
							      <button class="btn btn-default" type="submit">
							        <i class="glyphicon glyphicon-search"></i>
							      </button>
							    </div>
							  </div>
						</form>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<ul class="nav nav-tabs">
					<?php foreach ($languages as $key => $row): ?>
						<li class="<?= $key ==0?"active":"";?>"><a data-toggle="tab" href="#<?= html_escape($row['slug']);?>"><?= html_escape($row['lang_name']);?></a></li>
					<?php endforeach ?>
					</ul>

					<div class="tab-content">
					<?php foreach ($languages as $key => $row): ?>
						  <div id="<?= html_escape($row['slug']);?>" class="tab-pane fade in <?= $key ==0?"active":"";?>">
						  	<div class="row">
						  		<div class="col-md-offset-6 col-md-6">
						  			<div class="exportDataArea text-right mt-10 mb-0">
								  		<a href="#lnModal_<?= $row['slug'];?>" data-toggle="modal" class="btn btn-success btn-sm"><i class="icofont-upload"></i> <?= lang('import');?> </a>
								  		<a href="<?= base_url("admin/auth/exportjson/{$row['slug']}");?>" class="btn btn-secondary btn-sm"> <i class="icofont-download"></i> <?= lang('export');?></a>

								  	</div>
						  		</div>

						  	</div>
							 <form action="<?php echo base_url('admin/home/add_languages_value/'.$row['slug']); ?>" method="post">
							 	<!-- csrf token -->
								<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

							    <div class="table-responsive mt-20">
							    	<table class="table table-bordered table-striped">
							    		<thead>
							    			<tr>
							    				<th width="5%"><?= !empty(lang('sl'))?lang('sl'):"sl";?></th>
							    				<th width="20%"><?= !empty(lang('keywords'))?lang('keywords'):"Keywords";?></th>
							    				<th class="hide_details " width="30%"><?= !empty(lang('details'))?lang('details'):"Details";?></th>
							    				<th width="45%"><?= !empty(lang('value'))?lang('value'):"value";?></th>
							    				
							    			</tr>
							    		</thead>
							    		<tbody>
							    			<?php foreach($admin_languages as $key2 => $value): ?>
						    					<tr>
						    						<td><?= $key2+1;?></td>
						    						<td><?=  $value['keyword']?></td>
						    						<td class="hide_details"><input type="text" name="details[]" class="form-control" value="<?=  $value['details']?>"></td>
						    						<td><input type="text" name="<?= $row['slug'];?>[]" class="form-control" value="<?=  $value[$row['slug']]?>"></td>
						    					</tr>
						    					<input type="hidden" name="keyword[]" value="<?= $value['keyword'];?>">
							    			<?php endforeach ?>
							    		</tbody>
							    	</table>
							    </div>
							    <div class="form-group text-right">
							    	<button type="submit" class="btn btn-info btn-block"><?= !empty(lang('save_change'))?lang('save_change'):"save change";?></button>
							    </div>
						    </form>
						  </div>
						<!--  -->
					<?php endforeach ?>
					</div>
				</div><!-- /.box-body -->
				<div class="row">
					<div class="col-md-12 text-center adminPagi">
						<?=  $this->pagination->create_links();;?>
					</div>
				</div>
			</div>
	</div>

	
</div>

<?php foreach ($languages as $key => $ln): ?>
<!-- Modal -->
<div id="lnModal_<?= $ln['slug'];?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?= $ln['lang_name'];?></h4>
      </div>
      <form action="<?= base_url("admin/auth/import_json/{$ln['slug']}");?>" method="post" enctype="multipart/form-data">
			<?= csrf();?>
	      <div class="modal-body">
	        <input type="file" name="file" required accept=".json">
	      </div>
	      <div class="modal-footer">
	        <button type="submit" class="btn btn-success"><?= lang('submit');?></button>
	      </div>
	    </div>
	</form>

  </div>
</div>
<?php endforeach; ?>