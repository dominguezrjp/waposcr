
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
    margin-top: 35px;
}
.okbtn_area {
    padding: 18px 0 60px 0;
}
.ok_btn {
    padding: 6px 30px;
}
.cancled_order {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 350px;
}
</style>
<body style="background:#fafafa">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-md-6">
                  <div class="cancled_order">
                    <div class="confirmMsgArea">
                      <i class="fa fa-frown fa-2x"></i>
                      <h4><?= !empty(lang('sorry_payment_faild'))?lang('sorry_payment_faild'):'Sorry Payment Fail' ;?>.</h4>
                     
                      <div class="okbtn_area">
                        <a href="<?= base_url($slug) ;?>" class="btn btn-success ok_btn"><i class="fa fa-arrow-left"></i> <?= lang('back'); ?></a>
                      </div>
                    </div>
                  </div>
            </div>
        </div>
    </div>

</body>
</html>
