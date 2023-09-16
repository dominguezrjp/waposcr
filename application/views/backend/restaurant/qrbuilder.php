<div class="row">
    <?php include APPPATH.'views/backend/common/inc/leftsidebar.php'; ?>
       <?php $data = !empty($settings['qr_config'])?json_decode($settings['qr_config'],TRUE):''; ?>
        <div class="col-md-4">
            <form class="email_setting_form" action="<?= base_url('admin/restaurant/add_qr/'.$shop_id) ?>" method="post" enctype= "multipart/form-data" autocomplete="off">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" autocomplete="off">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4><?= lang('qr_generator'); ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="row p-15">
                            <div class="form-group d-flex justify-content-between">
                                <div class="">
                                    <h4><?= lang('foreground_color'); ?></h4>
                                </div>
                                <div class="qr-fg-color-wrapper">
                                    <button class="bm-color-picker"></button>
                                    <input type="hidden" class="color-input" name="fg_color" value="<?= !empty($data['fg_color'])?$data['fg_color']:'#2B2B2B'; ;?>">
                                </div>
                            </div><!-- form-group -->

                            <div class="form-group d-flex justify-content-between">
                                <div class="">
                                    <h4><?= lang('background_color'); ?></h4>
                                </div>
                                <div class="qr-bg-color-wrapper">
                                    <button class="bm-color-picker"></button>
                                    <input type="hidden" class="color-input" name="bg_color" value="<?= !empty($data['bg_color'])?$data['bg_color']:'#FFFFFF'; ;?>">
                                </div>
                            </div><!-- form-group -->
                            <div class="form-group mt-20 mb-20">
                                <label for=""><?= lang('padding'); ?></label>
                                <div class="">
                                     <input class="range-slider-single" name="qr_padding" id="qr-padding" type="text" data-slider-min="0"
                                           data-slider-max="5" data-slider-step="1" data-slider-value="<?= !empty($data['qr_padding'])?$data['qr_padding']:1; ;?>" value="<?= !empty($data['qr_padding'])?$data['qr_padding']:1; ;?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for=""><?= lang('mode'); ?></label>
                                <select id="qr-mode" name="qr_mode" class="with-border selectpicker form-control">
                                    <option value="0" <?= !empty($data['qr_mode']) && $data['qr_mode'] ==0?"selected":"" ;?>><?= lang('normal'); ?></option>
                                    <option value="2" <?= !empty($data['qr_mode']) && $data['qr_mode'] ==2?"selected":"" ;?> ><?= lang('text'); ?></option>
                                    <option value="4" <?= !empty($data['qr_mode']) && $data['qr_mode'] ==4?"selected":"" ;?>><?= lang('image'); ?></option>
                                </select>
                            </div><!-- form-group -->
                            
                            
                            <div id="qr-mode-customization">
                                <div id="qr-mode-label">
                                    <div class="submit-field">
                                       <label for=""><?= lang('text'); ?></label>
                                        <input id="qr-text" class="with-border form-control" name="qr_text" type="text" value="<?= !empty($data['qr_text'])?$data['qr_text']:restaurant()->username; ;?>">
                                    </div>
                                    <div class="form-group d-flex justify-content-between mt-15 mb-20">
                                        <div class="flex-grow-1">
                                           <label for=""><?= lang('text_color'); ?></label>
                                        </div>
                                        <div>
                                            <div class="qr-text-color-wrapper">
                                                <button class="bm-color-picker"></button>
                                                <input type="hidden" class="color-input" name="text_color"
                                                       value="<?= !empty($data['text_color'])?$data['text_color']:'#000000'; ;?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="qr-mode-image">
                                    <div class="form-group">
                                        <label for=""><?= lang('image'); ?></label>
                                        <div>
                                            <img id="img-buffer" src="<?= base_url(!empty($data['img'])?$data['img']:'assets/frontend/images/logo.jpg'); ?>" class="d-none">
                                            <label class="uploadButton-button btn btn-primary">
                                               <?= lang('upload_image'); ?>
                                             <input class="uploadButton-input opacity_0" type="file" accept="image/*" id="qr-image"
                                             name="images"/>
                                             <input type="hidden" name="old_img" value="<?= !empty($data['img'])?$data['img']:base_url('assets/frontend/images/logo.jpg'); ?>">
                                         </label>
                                        </div>
                                    </div>
                                </div>
                            
                            
                            <div class="form-group mt-20 mb-20">
                                <label for=""><?= lang('size'); ?></label>
                                <div class="">
                                     <input class="range-slider-single" name="mode_size" id="qr-mode-size" type="text" data-slider-min="8"
                                           data-slider-max="50" data-slider-step="3" data-slider-value="<?= !empty($data['mode_size'])?$data['mode_size']:8; ;?>" value="<?= !empty($data['mode_size'])?$data['mode_size']:8; ;?>">
                                </div>
                            </div>

                            <div class="form-group mt-20 mb-20">
                                <label for=""><?= lang('position_x'); ?></label>
                                <div class="">
                                     <input class="range-slider-single" name="qr_position_x" id="qr-position-x" type="text"
                                           data-slider-min="0" data-slider-max="100" data-slider-step="1"
                                           data-slider-value="<?= !empty($data['qr_position_x'])?$data['qr_position_x']:50; ;?>" value="<?= !empty($data['qr_position_x'])?$data['qr_position_x']:50; ;?>">
                                </div>
                            </div>
                             <div class="form-group mt-20 mb-20">
                                <label for=""><?= lang('position_y'); ?></label>
                                <div class="">
                                      <input class="range-slider-single" name="qr_position_y" id="qr-position-y" type="text"
                                           data-slider-min="0" data-slider-max="100" data-slider-step="1"
                                           data-slider-value="<?= !empty($data['qr_position_y'])?$data['qr_position_y']:50; ;?>" value="<?= !empty($data['qr_position_y'])?$data['qr_position_y']:50; ;?>">
                                </div>
                            </div>

                              </div> 
                        </div><!-- row -->
                            
                    </div><!-- card-body -->
                    <div class="card-footer">
                        <input type="hidden" name="id" value="<?= isset($settings['id']) && $settings['id'] !=0?html_escape($settings['id']):0 ?>">
                        <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> &nbsp;<?= !empty(lang('save_change'))?lang('save_change'):"Save Change";?></button>
                    </div>
                </div><!-- card -->
            </div><!-- col-9 -->
        </form>
            
        </div><!-- col-9 -->
    

    <div class="col-md-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4><?= lang('qrcode'); ?></h4>
                    </div>
                    <div class="card-body text-center p-0">
                        <div class="content with-padding">
                            <div id="qr-code-wrapper" class="margin-bottom-20" data-url="<?=  url(restaurant()->username);?>">
                                <img src="" alt="">
                            </div>
                            <button class="btn btn-primary qr-code-downloader mt-20"><i class="fa fa-download"></i> <?= lang('download'); ?></button>
                        </div>
                        
                    </div><!-- card-body -->
                </div><!-- card -->
            </div>
        </div>
    </div>      
</div>


