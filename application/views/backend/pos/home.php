<?php if(is_demo()==1): ?>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="callout callout-danger">
				<h4>It's an Addon <span class="fz-11">Not included in this script</span></h4>
				<p>If you want to use this system then purchase it from <a href="https://codecanyon.net/item/qpos-pos-system-addon-for-qrexorder/41813677"><u>here</u></a></p>
			</div>
		</div>
	</div>
<?php endif ?>
<?php include "inc/pos_menu.php";?>
<div class="row">
	<div class="col-md-4">
		<form action="<?= base_url(isset($this->link['pos_order_link'])?$this->link['pos_order_link']:'');?>" method="post" class="addOrderForm">
			<?= csrf();?>
			<div class="card menu-card">
				<div class="card-body">
					<div class="form-group custom-fields" id="customerList">
						<?php include 'inc/customer_list.php'; ?>
					</div>
				</div>
				<?php include 'inc/pos_home.php'; ?>
			</div><!-- card -->
		</form>
	</div>
	<div class="col-md-8">
		<div class="card">
			<div class="card-header">
				<div class="col-md-6">
					<div class="categoryBtn">
						<a href="javascript:;" class="catIcon"><i class="fa fa-window-restore"></i> <?= lang('categories');?></a>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="card-content">
					<div class="row">
						<div class="col-md-6">
							<form action="">
								<div class="itemSearch custom-fields">
									<div class="searcharea">
										<div class="search-input">
											<input type="text" name="item_name" id="search-box" class="form-control autocomplete-input" placeholder="<?= lang('search');?>">
											<span class="btn-loading"></span>
										</div>
									</div>
								</div>
							</form><!-- search form -->
						</div><!-- col-6 -->
					</div><!-- row -->
					<div class="row">
						<div class="col-md-12">
							<div class="itemListArea">
								<?php include 'inc/item-thumb.php'; ?>
							</div>
						</div>
					</div>
				</div><!-- card-content -->
			</div><!-- card-body -->
		</div><!-- card -->
	</div>
</div>

<div class="categoryArea">
	<div class="categoryAreaContent">
		
		<div class="categoryList">
			<div class="catHeader">
				<a href="javascript:;" class="catIcon"><i class="icofont-close-line"></i></a>
				<h4><?= lang('categories');?></h4>
			</div>
			<ul>
				<li><a href="<?= base_url("admin/pos/ajax_pagination?catId=all");?>" class="bg-success-soft catId">
					<div class="categoryDiv">
						<img src="<?= get_img('','',1) ;?>" alt="">
						<span><?= lang('all');?></span>
					</div>
					</a></li>
				<?php foreach ($category_list as $key => $cat): ?>
					<li><a href="<?= base_url("admin/pos/ajax_pagination?catId=".md5(multi_lang(auth('id'),$cat)));?>" class="bg-success-soft catId">
						<div class="categoryDiv">
							<img src="<?= get_img($cat['thumb'],'',1) ;?>" alt="">
							<span><?= $cat['name'];?></span>
						</div>
						</a></li>
				<?php endforeach ?>
				
			</ul>
		</div>
	</div>
</div>


<?php include 'inc/all_modals.php'; ?>



<div class="modal fade" id="itemDetails">
	<div class="modal-dialog">
		<div class="modal-content" >
			<div id="showDetails">
				<!-- codeHere -->
			</div>
		</div>
	</div>
</div>






<script>
	
	function isNumber(evt) {
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}
		return true;
	}

</script>

<a href="<?= restaurant()->id;?>" data-shop-id="<?= base64_encode(restaurant()->id);?>" class="data-token"></a>