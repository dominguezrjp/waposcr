<?php  $contacts = get_by_section_name('contacts'); ?>
<?php $settings = settings(); ?>
<?php if(!empty($contacts) && $contacts['status']==1): ?>
  <section class="profile home_contact homeSection" id="contacts">
    <div class="container">
      <div class="contact_content">
          <div class="sction_title">
              <h4 class="heading-text"><?= html_escape($contacts['heading']) ;?></h4>
              <p><?= html_escape($contacts['sub_heading']) ;?></p>
          </div>
          <div class=" contacts_area col-md-8 offset-md-2">
              <form action="<?= base_url('home/send_mail/') ;?>" method="post" id="home_contact">
                <span class="reg_msg"></span>
                <?=  csrf();?>
                <div class="row">
                  <div class="form-group col-md-6">
                    <input type="text" name="name" class="form-control" placeholder="<?= !empty(lang('name'))?lang('name'):"Name" ;?>" value="">
                  </div>

                  <div class="form-group col-md-6">
                    <input type="text" name="email" class="form-control" placeholder="<?= !empty(lang('email'))?lang('email'):"email" ;?>" value="">
                  </div>
                </div>

                <div class="form-group">
                  <input type="text" name="subjects" class="form-control" placeholder="<?= !empty(lang('subject'))?lang('subject'):"subject" ;?>" value="">
                </div>

                 <div class="form-group">
                  <textarea name="msg" class="form-control" placeholder="<?= !empty(lang('message'))?lang('message'):"message" ;?>" cols="5" rows="5"></textarea>
                </div>
                  <div class="form-group">
                    <?php if(isset($settings['is_recaptcha']) && $settings['is_recaptcha']==1): ?>
                      <?php if(isset($this->settings['recaptcha']->site_key) && !empty($this->settings['recaptcha']->site_key)): ?>
                      <div class="g-recaptcha" data-sitekey="<?= $this->settings['recaptcha']->site_key;?>"></div>
                    <?php endif;?>
                  <?php endif;?>
                </div>
                  <div class="form-group">
                    <div class="download_btn_area p-0 text-center">
                       <button type="submit" class="btn btn-info c_btn mail_send_btn custom_btn" > <?=  !empty(lang('send'))?lang('send'):"send";?> &nbsp;<i class="fas fa-angle-double-right"></i></button>
                    </div>
                  </div>
              </form>
          </div>
      </div>
    </div>
  </section>
  <?php endif;?>