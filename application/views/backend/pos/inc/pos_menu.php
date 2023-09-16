<div class="row">
	<div class="col-md-12">
		<div class="posMenu">
			<ul>
				<li><a href="<?= base_url("dashboard");?>" class="<?= isset($page_title) && $page_title==""?"active":"";?>"><i class="icofont-long-arrow-left fz-20"></i></a></li>
				<li><a href="javascript:;" class="active expand mr-10"><i class="fa fa-expand fz-20 "></i></a></li>
				<li><a href="<?= base_url(isset($this->link['pos_link'])?$this->link['pos_link']:'');?>" class="<?= isset($page_title) && $page_title=="POS"?"active":"";?>"><img src="<?= base_url("assets/frontend/images/pos.png");?>" alt="" class="menuImg mr-5"> <?= lang('pos');?></a></li>
				<li><a href="<?= base_url(isset($this->link['pos_settings_link'])?$this->link['pos_settings_link']:'');?>" class="<?= isset($page_title) && $page_title=="POS Settings"?"active":"";?>"><i class="icofont-ui-settings mr-3"></i> <?= lang('settings');?></a></li>
			</ul>
		</div>
	</div>
</div>

<script>
	$(document).on('click','.expand',function(){
		$('.posMenu').toggleClass('active');
	})
</script>