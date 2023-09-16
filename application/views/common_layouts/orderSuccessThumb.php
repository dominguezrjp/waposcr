<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<div class="successMsgArea single__page__order">
				<div class="successMsg singleSuccessPage">
					<div class="confirmMsgArea">
						<i class="icofont-check-circled fa-3x successIcon success-light"></i>
						<h4><?= !empty(lang('order_confirmed'))?lang('order_confirmed'):'order confirmed' ;?>.</h4>
						<h5> <?= !empty(lang('your_order_id'))?lang('your_order_id'):'your order id' ;?>: #<span class="order_id"><?= $info['order_id'] ;?></span></h5>
						<p><?= !empty(lang('track_your_order_using_phone'))?lang('track_your_order_using_phone'):'You can track you order using your phone number' ;?></p>
						<div class="qr_link">
							<img src="<?= base_url($info['qrlink']) ;?>" alt="qrCode" id="qr_link">
							<a href="<?= base_url($info['qrlink']);?>" download target="blank" data-link="<?= base_url($info['qrlink']);?>" class="qrDownloadBtn" id="downloadLink" data-placement="top" data-toggle="tooltip" title="Download Qr for Quick access your order"><i class="fa fa-download"></i> <?= !empty(lang('download'))?lang('download'):'download' ;?></a>

						</div>

						<?php if(isset($is_whatsapp) && $is_whatsapp==1): ?>
							<div class="whatsapp_share_data">
								<div class="whatsapp_share">
									<a href='<?= base_url("profile/whatsapp/{$order_id}");?>' style="text-decoration:none" data-action="share/whatsapp/share" class="redirect_whatsapp">
										<div>
											<i class="fa fa-whatsapp"></i>&nbsp;&nbsp;<?= lang('order_on_whatsapp'); ?>
										</div>
									</a>
								</div>
							</div>
						<?php endif ?>

					</div>
					<div class="trackLink">
						<a href="<?= $track_link ;?>" id="track_order_btn" target="blank" class="fz-14"><?= lang('track_order') ;?></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>