
<!DOCTYPE html>
<html lang="en">
<?php $settings = settings(); ?>
<head>
    <title><?=isset($page_title) && $page_title !=""?$page_title:''; ?> | <?php echo html_escape($settings['site_name']);?></title>
</head>
<meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<style>
 
.payment_success_area {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  height: 100vh;
  width: 100%;
}
.payment_success {
    background: #eee;
    padding: 30px 10px;
    width: 100%;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
}
.payment_icon {
    height: 80px;
    width: 80px;
    border: 1px solid #ddd;
    border-radius: 100%;
    background: #fff;
}

.payment_icon i {
    font-size: 37px;
    line-height: 74px;
}

.buttons a {
    padding: 6px 28px;
}

.buttons {
    margin-top: 11px;
}

.buttons a.btn_left {
    margin-right: 10px;
}
h4,h5,h6{
    padding: 0;
    margin: 0;
}
.c_green{
    color: green;
}
.c_red{
    color: red;
}
.fz-13{
  font-size: 13px;
}
.mr-25{
  margin-right: 25%;
}
.successOrder {
    margin-top: 6rem;
}
.okbtn_area {
    padding: 18px 0 60px 0;
}
.redirect_btn {
    padding: 6px 30px;
}
</style>
<body style="background:#fafafa">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-md-6">
                  <div class="successOrder">
                    <div class="confirmMsgArea payInCash">
                     <i class="icofont-check-circled fa-3x successIcon success-light mb-7"></i>
                      <h4><?= !empty(lang('order_confirmed'))?lang('order_confirmed'):'order confirmed' ;?>.</h4>
                      <h5> <?= !empty(lang('your_order_id'))?lang('your_order_id'):'your order id' ;?>: #<span class="order_id"><?= $info['order_id'];?></span></h5>
                      <?php if(isset($txn_id)): ?>
                        <p><?= lang('txn_id'); ?> : <?= $txn_id ;?></p>
                      <?php endif;?>
                      <p><?= !empty(lang('track_your_order_using_phone'))?lang('track_your_order_using_phone'):'You can track you order using your phone number' ;?></p>
                      <div class="qr_link">
                        <img src="<?= base_url($info['qrlink'])?>" alt="" id="qr_link">
                        <a href="<?= base_url($info['qrlink'])?>" download target="blank" data-link="" class="qrDownloadBtn" id="downloadLink" data-placement="top" data-toggle="tooltip" title="Download Qr for Quick access your order"><i class="fa fa-download"></i> <?= !empty(lang('download'))?lang('download'):'download' ;?></a>
                        
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
                  </div>
            </div>
        </div>
    </div>
    <a href="<?php echo base_url() ?>" id="base_url"></a>
    <a href="<?php echo $this->security->get_csrf_hash(); ?>" id="csrf_value"></a>
    <script src="<?= base_url();?>assets/frontend/js/payment.js?v=<?= settings()['version'];?>&time=<?= time();?>" ></script>
</body>
</html>
