<?php if(is_feature($id,'online-payment')==1 && is_active($id,'online-payment')): ?>
<?php $settings = settings(); ?>
<?php  $shop = $this->admin_m->get_restaurant_info_slug($slug);?>
<?php if(!empty(auth('payment')) && count($this->cart->contents()) >0): ?>
<?php $payment = auth('payment'); ?>
	<div class="payment_warper <?= is_package;?>">
		<div class="container">
			<div class="row justify-content-center sm-column-reverse">
				
				<div class="col-md-8">
					<div class="card mt-50 payment_card sm-column-reverse">
						

						<div class="card-header">
							<ul class="nav nav-tabs payment_nav" >
								<?php foreach (payment_methods() as $key => $pay): ?>
									<?php if($pay['slug'] != 'offline'): ?>
											<?php if($shop[$pay['active_slug']]==1 && $shop[$pay['status_slug']]==1): ?>
												<li class="nav-item <?=  isset($_GET['method']) && $_GET['method']==$pay['slug']?"active":"";?>">
												    <a class="nav-link"  href="<?= base_url("profile/payment/{$slug}?method={$pay['slug']}") ;?>"><span class="payout_img" style="background:url(<?=  base_url(IMG_PATH.'payout/'.$pay['slug'].'.png');?>)"></span><?= lang($pay['slug']) ;?></a>
												  </li>
											<?php endif;?>
									<?php endif;?>
								<?php endforeach; ?>
							</ul>
						</div>

						<div class="card-body <?= is_package;?>">

							<?php 
								$total_amount = grand_total($this->cart->total(),$payment['delivery_charge'],$payment['discount'],$payment['tax_fee'],$payment['coupon_percent'],$payment['tips'],$payment['order_type'],shop($payment['shop_id'])->tax_status,0);
							?>
								<div class="tab-content" id="myTabContent">

				  					<div class="tab-pane show active">
										<?php  if(isset($_GET['method'])):?>
											<?php 
												$method = $_GET['method'];
											 ?>
											<?php foreach (payment_methods() as $key => $pay): ?>
												<?php if($pay['slug'] != 'offline'): ?>
														<?php if($method==$pay['slug']): ?>
															<?php include "inc/{$pay['slug']}.php"; ?>
														<?php endif;?>
												<?php endif;?>
											<?php endforeach; ?>
										<?php else: ?>
											<div class="tab-pane active" >
												<div class="selectPaymentMsg">
													<p><i class="icofont-pay"></i></p>
													<h4><?= lang('please_select_your_payment_menthod'); ?></h4>
												</div>
											</div>
										<?php endif;?>

									</div>

			  					
								<a href="<?php echo base_url() ?>" id="base_url"></a>
								<a href="<?= $this->security->get_csrf_hash(); ?>" id="csrf_value"></a>
			  				</div><!-- tab-content -->
						</div>
					</div><!-- card -->

				</div>
				<div class="col-md-4">
					<?php include "inc/rightsideBar.php"; ?>
				</div>

			</div>
		</div>
	</div>

<?php else: ?>
	
	<?php redirect(base_url($slug)) ?>
<?php endif;?>


 <script src="<?= base_url();?>assets/frontend/js/payment.js?v=<?= settings()['version'];?>&time=<?= time();?>" ></script>

<script type="text/javascript">

$('a.back').on("click",function(){
    parent.history.back();
});

</script>
<?php else: ?>
	<div class="container mt-50">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="card">
					<div class="card-body text-center" style="min-height: 250px; display: flex; align-items: center;justify-content: center; flex-direction:column;">
						<h4>
							<i class="icon fa fa-frown"></i>
							<?= !empty(lang('sorry'))?lang('sorry'):"Sorry!" ;?>
						</h4>
						<p><?= !empty(lang('payment_not_available'))?lang('payment_not_available'):"Payment is not available!" ;?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php $url = base_url($slug); ?>
	<script>
		var url = '<?= $url;?>';
		setTimeout(function() { window.location.href = url }, 5000);
	</script>		

<?php endif;?>


  <?php if(LICENSE!=MY_LICENSE): ?>
  <script>
    $(document).ready(function(){
      $(".stripe_fpx, .mercado, .flutterwave, .paystack, .paytm").html('')
    })
  </script>
  <?php endif ?>