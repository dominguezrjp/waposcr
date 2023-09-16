<div class="row">
	<ul class="nav nav-tabs" id="myTab" role="tablist">
		  <li class="nav-item">
		    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#paypal" role="tab" aria-controls="home" aria-selected="true">Paypal</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#stripe" role="tab" aria-controls="profile" aria-selected="false">Stripe</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#offline" role="tab" aria-controls="contact" aria-selected="false">Offline</a>
		  </li>
	</ul>
	<div class="tab-content" id="myTabContent">
	  <div class="tab-pane fade show active" id="paypal" role="tabpanel" aria-labelledby="home-tab">
	  	<div class="payment_area">
			<div class="payment_icon">
				<img src="<?php echo base_url('assets/images/paypal.png'); ?>" alt="">
			</div>
			<div class="payment_details">
				<h4> <?= isset($u_info['username'])?html_escape($u_info['username']):'';?></h4>
				<div class="">
					<h2>&#36; <?= isset($u_info['price'])?html_escape($u_info['price']):'';?> / Year</h2>
					<p><b>Account Type : </b> <?= html_escape($u_info['type_name']);?></p>
				</div>
				<p class="payment_text">*Please Payment on <i class="fa fa-cc-paypal fa-2x"></i></p>
			</div>
			<a href="<?php echo base_url('payment-method/'.html_escape($u_info['user_id'])); ?>" class="btn btn-success pay_now">Pay Now</i></a>
			<div class="offline_payment">*For offline payment <a href="<?php echo base_url('home/contact'); ?>">click here</a></div>
		</div><!-- payment area -->
	  </div>
	  
	  <div class="tab-pane fade" id="stripe" role="tabpanel" aria-labelledby="profile-tab">
	  	<div class="payment_area">
			<div class="payment_icon">
				<img src="<?php echo base_url('assets/images/paypal.png'); ?>" alt="">
			</div>
			<div class="payment_details">
				<h4> <?= isset($u_info['username'])?html_escape($u_info['username']):'';?></h4>
				<div class="">
					<h2>&#36; <?= isset($u_info['price'])?html_escape($u_info['price']):'';?> / Year</h2>
					<p><b>Account Type : </b> <?= html_escape($u_info['type_name']);?></p>
				</div>
				<p class="payment_text">*Please Payment on <i class="fa fa-cc-paypal fa-2x"></i></p>
			</div>
			<a href="<?php echo base_url('payment-method/'.html_escape($u_info['user_id'])); ?>" class="btn btn-success pay_now">Pay Now</i></a>
			<div class="offline_payment">*For offline payment <a href="<?php echo base_url('home/contact'); ?>">click here</a></div>
		</div><!-- payment area -->

	  </div>
	  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
	</div>
	
</div>