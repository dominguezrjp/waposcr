<div class="share_card_area">
	<?php $user_info = $this->admin_m->get_profile_info($id); ?>
	<div class="share_card_content">
		<div class="share_card_header">
			<h4>Share with</h4>
			<a href="javascript:;" class="close_card"><i class="icofont-close-line"></i></a>
		</div>
		<div class="share_card_body">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
			  <li class="nav-item">
			    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#qr" role="tab" aria-controls="home" aria-selected="true"><?= !empty(lang('qr_share'))?lang('qr_share'):'QR code' ;?></a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#vcf" role="tab" aria-controls="profile" aria-selected="false"><?= !empty(lang('download_as_vcf'))?lang('download_as_vcf'):'Download VCF' ;?></a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#social" role="tab" aria-controls="contact" aria-selected="false"><?= !empty(lang('social_sites'))?lang('social_sites'):'Social Sites' ;?></a>
			  </li>
			</ul>


			<div class="tab-content" id="myTabContent">
			  <div class="tab-pane fade show active" id="qr" role="tabpanel" aria-labelledby="home-tab">
			  	<div class="card_titles">
			  		<div class="share_body_content">
			  			<?php if(get_user_features_by_id($id,'qr-code')==1): ?>
			  				<img src="<?= base_url($user_info['qr_link']) ;?>" alt="">
			  			<?php else: ?>
			  				<div class="not_available">
			  					<h4>Sorry Not Found</h4>
			  					<p>Not Available in your package</p>
			  				</div>
			  			<?php endif;?>
			  		</div>
			  	</div>
			  </div>

			  <div class="tab-pane fade" id="vcf" role="tabpanel" aria-labelledby="profile-tab">
			  	<div class="share_body_content">
			  		<?php if(get_user_features_by_id($id,'qr-code')==1): ?>
				  		<div class="hero_btn_area">
			              <a href="<?= base_url('vcard/'.$slug) ;?>" class="btn btn-success c_btn"><i class="fa fa-user-plus"></i> &nbsp;<?= !empty(lang('add_me_contact'))?lang('add_me_contact'):"Add me to your contact"?></b></a>
			            </div>
			            <div class="or share"><span><?= !empty(lang('or'))?lang('or'):"or" ;?></span></div>

			  			<img src="<?= base_url($user_info['qr_download']) ;?>" alt="">
		  			<?php else: ?>
		  				<div class="not_available">
		  					<h4>Sorry Not Found</h4>
		  					<p>Not Available in your package</p>
		  				</div>
		  			<?php endif;?>
		  		</div>
			  </div>

			  <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="contact-tab">
			  	<div class="share_body_content">
			  		<div class="share_whatsapp">
			  			<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text" id="basic-addon1"><i class="fa fa-whatsapp"></i></span>
						  </div>
						  <input type="text" class="form-control" id="whatsapp_number" placeholder="<?=  $user_info['dial_code'];?>  xxxxxxxx" >
						</div>
						<button type="button" class="btn btn-info whatsapp_btn" data-link="<?= base_url($slug) ;?>"><?= !empty(lang('share_on_whatsapp'))?lang('share_on_whatsapp'):"Share on whatsapp" ;?></button>
			  		</div>	
			  		<div class="or share"><span><?= !empty(lang('or'))?lang('or'):"or" ;?></span></div>	
			  		<div class="social_card_share_bottom">
			  			<ul>
			  				<li>Share with: <a href="javascript:;" onclick="window.open('http://www.facebook.com/sharer.php?u=<?= base_url($slug);?>', 'sharer', 'toolbar=0,status=0,width=620,height=280');"><i class="fa fa-facebook"></i> Facebook</a></li>
			  			</ul>
			  		</div>
		  		</div>

			  </div>
			</div>
		</div>	
	</div>
</div>