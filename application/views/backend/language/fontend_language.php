<div class="row">
	<div class="col-md-12">
		<div class="hide_lang_details">
			<label class="fz-16"><input type="checkbox" value="1" class="details_check"> <?= lang('show_details'); ?></label>
		</div>
	</div>
	<div class="col-md-6">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title"><?= !empty(lang('fontend_languages'))?lang('fontend_languages'):"Fontent Language Values";?></h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<ul class="nav nav-tabs">
					<?php foreach ($fontend_languages as $key => $row): ?>
						<li class="<?= $key ==0?"active":"";?>"><a data-toggle="tab" href="#<?= html_escape($row['slug']);?>"><?= html_escape($row['lang_name']);?></a></li>
					<?php endforeach ?>
					</ul>

					<div class="tab-content">
					<?php foreach ($fontend_languages as $key => $row): ?>
						  <div id="<?= html_escape($row['slug']);?>" class="tab-pane fade in <?= $key ==0?"active":"";?>">
							 <form action="<?php echo base_url('admin/home/add_languages_value/'.$row['slug']); ?>" method="post">
							 	<!-- csrf token -->
								<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
							    <div class="table-responsive">
							    	<table class="table table-bordered table-striped">
							    		<thead>
							    			<tr>
							    				<th><?= !empty(lang('sl'))?lang('sl'):"sl";?></th>
							    				<th><?= !empty(lang('keywords'))?lang('keywords'):"Keywords";?></th>
							    				<th class="hide_details"><?= !empty(lang('details'))?lang('details'):"Details";?></th>
							    				<th><?= !empty(lang('value'))?lang('value'):"value";?></th>
							    				
							    			</tr>
							    		</thead>
							    		<tbody>
							    			<?php foreach($row['lang_data'] as $key2 => $value): ?>
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
							    	<button type="submit" class="btn btn-info"><?= !empty(lang('save_change'))?lang('save_change'):"save change";?></button>
							    </div>
						    </form>
						  </div>
						<!--  -->
					<?php endforeach ?>
					</div>
				</div><!-- /.box-body -->
			</div>
	</div>
	<div class="col-md-6">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title"><?= !empty(lang('others'))?lang('others'):"Label / button/ others Values";?></h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<ul class="nav nav-tabs">
					<?php foreach ($label_languages as $key => $row): ?>
						<li class="<?= $key ==0?"active":"";?>"><a data-toggle="tab" href="#<?= html_escape($row['slug']).'_1';?>"><?= html_escape($row['lang_name']);?></a></li>
					<?php endforeach ?>
					</ul>

					<div class="tab-content">
					<?php foreach ($label_languages as $key => $row): ?>
						  <div id="<?= html_escape($row['slug'])."_1";?>" class="tab-pane fade in <?= $key ==0?"active":"";?>">
						  	
							 <form action="<?php echo base_url('admin/home/add_languages_value/'.$row['slug']); ?>" method="post">
							 	<!-- csrf token -->
								<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

							    <div class="table-responsive">
							    	<table class="table table-bordered table-striped">
							    		<thead>
							    			<tr>
							    				<th><?= !empty(lang('sl'))?lang('sl'):"sl";?></th>
							    				<th><?= !empty(lang('keywords'))?lang('keywords'):"Keywords";?></th>
							    				<th class="hide_details"><?= !empty(lang('details'))?lang('details'):"Details";?></th>
							    				<th><?= !empty(lang('value'))?lang('value'):"value";?></th>
							    				
							    			</tr>
							    		</thead>
							    		<tbody>
							    			<?php foreach($row['lang_data'] as $key2 => $value): ?>
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
							    	<button type="submit" class="btn btn-info"><?= !empty(lang('save_change'))?lang('save_change'):"save change";?></button>
							    </div>
						    </form>
						  </div>
						<!--  -->
					<?php endforeach ?>
					</div>
				</div><!-- /.box-body -->
			</div>
	</div>
</div>
