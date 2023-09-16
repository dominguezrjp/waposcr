<?php if(is_feature($id,'contacts')==1 && is_active($id,'contacts')): ?>
<?php $settings = settings(); ?>
<section class="sectionDefault">
  <?php include APPPATH.'views/common_layouts/topMenu.php' ?>
  <div class="section_items">
        <section class="profile " id="contacts">
          <div class="container">
            <div class="contact_content">
                <div class="sction_title">
                  <h4 class="section_heading"><?= get_title($id,'contacts',1) ;?></h4>
                  <?php if(!empty(get_title($id,'contacts',2))): ?>
                    <p><?= get_title($id,'contacts',2) ;?></p>
                  <?php endif;?>
                </div>
                <div class="contacts_area theme_5">
                  <div class="row">
                    <div class="col-md-5">
                      <div class="contact_top">
                        <?php if(!empty($social['whatsapp'])): ?>
                        <div class="single_contact_wizard">
                          <a href="<?= redirect_url($social['whatsapp'],'whatsapp',$user['dial_code'])?>">
                            <div class="contact_top_content">
                              <div class="single_contact_top">
                                <i class="fa fa-whatsapp"></i>
                                <div class="bottom_down">
                                  <h4><?= !empty(lang('whatsapp'))?lang('whatsapp'):'' ;?></h4>
                                  <p><?= $shop['dial_code'] ;?><?= html_escape($social['whatsapp']) ;?></p>
                                </div>
                              </div>
                            </div>
                          </a>
                        </div>
                      <?php endif;?>

                      <?php if(!empty($shop['phone'])): ?>
                        <div class="single_contact_wizard">
                          <a href="<?= redirect_url($shop['phone'],'phone',$user['dial_code'])?>">
                            <div class="contact_top_content">
                              <div class="single_contact_top">
                                <i class="fa fa-phone"></i>
                                <div class="bottom_down">
                                  <h4><?= !empty(lang('phone'))?lang('phone'):'' ;?></h4>
                                  <p><?= $shop['dial_code'] ;?><?= html_escape($shop['phone']) ;?></p>
                                </div>
                              </div>
                            </div>
                          </a>
                        </div>
                      <?php endif;?>

                      <?php if(!empty($shop['location'])): ?>
                        <div class="single_contact_wizard">
                          <a href="<?= redirect_url($shop['location'],'gmap')?>" target="blank">
                            <div class="contact_top_content">
                              <div class="single_contact_top">
                                <i class="fas fa-map-marker-alt"></i>
                                <div class="bottom_down">
                                  <h4><?= !empty(lang('address'))?lang('address'):'' ;?></h4>
                                  <p><?= $shop['address'];?></p>
                                </div>
                              </div>
                            </div>
                          </a>
                        </div>
                      <?php endif;?>

                      <?php if(!empty($shop['email'])): ?>
                        <div class="single_contact_wizard">
                          <a href="<?= redirect_url($shop['email'],'email')?>">
                            <div class="contact_top_content">
                              <div class="single_contact_top">
                                <i class="fa fa-envelope-o"></i>
                                <div class="bottom_down">
                                  <h4><?= !empty(lang('email'))?lang('email'):'' ;?></h4>
                                  <p><?= html_escape($shop['email'])?></p>
                                </div>
                              </div>
                            </div>
                          </a>
                        </div>
                      <?php endif;?>
                      </div>
                    </div>
                    <div class="col-md-7">
                        <form action="<?= base_url('profile/send_mail/') ;?>" method="post" id="home_contact" autocomplete="off">
                          <span class="reg_msg"></span>
                          <?=  csrf();?>
                          <div class="form_fields">
                            <div class="form-group">
                              <input type="text" name="name" class="form-control" placeholder="<?= !empty(lang('name'))?lang('name'):'Name';?>" value="">
                            </div>

                            <div class="form-group">
                              <input type="text" name="email" class="form-control" placeholder="<?= !empty(lang('email'))?lang('email'):'email';?>" value="">
                            </div>
                          </div>

                          <div class="form-group">
                            <input type="text" name="subjects" class="form-control" placeholder="<?= !empty(lang('subject'))?lang('subject'):'subjects';?>" value="">
                          </div>

                           <div class="form-group">
                            <textarea name="msg" class="form-control" placeholder="<?= !empty(lang('message'))?lang('message'):'message';?>" cols="5" rows="5"></textarea>
                          </div>
                          <div class="form-group">
                              <?php if(isset($settings['is_recaptcha']) && $settings['is_recaptcha']==1): ?>
                                <?php if(isset($this->settings['recaptcha']->site_key) && !empty($this->settings['recaptcha']->site_key)): ?>
                                <div class="g-recaptcha" data-sitekey="<?= $this->settings['recaptcha']->site_key;?>"></div>
                              <?php endif;?>
                            <?php endif;?>
                          </div>
                            <div class="form-group">
                              <div class="download_btn_area p-0">
                                <input type="hidden" name="id" value="<?=  base64_encode($id);?>">
                                 <button type="submit" class="btn btn-info custom_btn c_btn mail_send_btn" > <?= !empty(lang('send'))?lang('send'):'send';?> &nbsp;<i class="fas fa-angle-double-right"></i></button>
                              </div>
                            </div>
                        </form>
                    </div>
                  </div>
                </div>
                
            </div>
          </div>
        </section>
   </div>
</section>
<?php endif;?>