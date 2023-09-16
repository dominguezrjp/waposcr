<?php $apps = isJson($u_settings['extra_config'])?json_decode($u_settings['extra_config']):'' ?>
<div class="row">
        <?php include APPPATH.'views/backend/users/inc/leftsidebar.php'; ?>
    <div class="col-md-8">
        <form action="<?= base_url("admin/auth/add_extra_config");?>" method="post">
            <?= csrf();?>
            <div class="card">
                <div class="card-header"> <h5 class="m-0 mr-5"><?= lang('extras');?> </h5></div>
                <div class="card-body">
                    <div class="card-content">
                       <div class="row">
                            <div class="form-group col-md-4">
                                <select name="language_type" id="language_type" class="form-control" onchange="changeLang(this.value)">
                                    <option value="system" <?= isset($apps->language_type) && $apps->language_type=="system"?"selected":"";?> selected>System Language</option>
                                    <option value="google" <?= isset($apps->language_type) && $apps->language_type=="google"?"selected":"";?>>Google translate</option>
                                </select>
                            </div>
                       </div>

                       <?php if(isset($apps->language_type) && $apps->language_type=="system"):
                            $language_type = "system";
                       elseif (isset($apps->language_type) && $apps->language_type=="google"):
                            $language_type = "google";
                        else:
                            $language_type = "system";
                       endif;



                        ?>
                        <div class="languages_section">
                            <div class="languageItems system <?= isset($language_type) && $language_type=="system"?"":"dis_none";?>">
                                <?php $language = isset($apps->languages) && isJson($apps->languages)?json_decode($apps->languages):''; ?>
                            
                                <h4><?= lang('languages');?></h4>
                                <ul>
                                    <?php foreach (get_languages() as $key => $lang) : ?>
                                        <li><label class="custom-checkbox"><input type="checkbox" name="languages[]" value="<?= $lang->slug;?>" <?= isset($language) && !empty($language) &&  in_array($lang->slug, $language)==1?"checked":"" ;?>> <?= $lang->lang_name;?></label></li>
                                    <?php endforeach ?>
                                </ul>

                            </div>

                            <div class="languageItems google  <?= isset($language_type) && $language_type=="google"?"":"dis_none";?>">
                                <?php $glang = isset($apps->glanguage) && isJson($apps->glanguage)?json_decode($apps->glanguage):''; ?>
                                <div class="mb-20">
                                    <label for="">Default Language</label>
                                    <select name="default_language" id="languages" class="form-control select2">
                                         <?php foreach (glanguage() as $key => $val) : ?>
                                            <option value="<?= $key;?>" <?= isset($apps->default_language) && $apps->default_language==$key?"selected":"";?>><?= $val;?></option>
                                         <?php endforeach; ?>
                                    </select>
                                </div>
                                <h4 class="mb-5"><?= lang('languages');?></h4>
                                <select name="glanguage[]" id="languages" class="form-control multiselct" multiple>
                                     <?php foreach (glanguage() as $key => $val) : ?>
                                        <option value="<?= $key;?>" <?= isset($glang) && !empty($glang) &&  in_array($key, $glang)==1?"selected":"" ;?>><?= $val;?></option>
                                     <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <!--     -->
                        </div>
                        <div class="thirdparty-app">
                            <h4 class="extra-title"><?= lang('third-party_chatting_app');?></h4>
                            <hr>
                            

                            <div class="form-group">
                                <label for=""><?= lang('choose_an_app');?></label>
                                <select name="app" id="Third-party" class="form-control">
                                    <option value="1" <?= isset($apps->app) && $apps->app=='elfsight'?"selected":"";?>>Elfsight</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label><?= lang('app_id');?> (<small><?= lang('whatsapp_message');?></small>)</label>
                                <input type="text" name="app_id" class="form-control" value="<?= isset($apps->app_id)?$apps->app_id:'';?>" placeholder="<?= lang('app_id');?>">
                            </div>

                            <div class="form-group">
                                <label><?= lang('app_id');?> (<small><?= lang('cookies_privacy');?></small>)</label>
                                <input type="text" name="app_id_cookies" class="form-control" value="<?= isset($apps->app_id_cookies)?$apps->app_id_cookies:'';?>" placeholder="<?= lang('app_id');?>">
                            </div>

                            <div class="form-group">
                                <label class="custom-radio-2 mr-10"><input type="radio" name="elfsight_status" value="1" <?= isset($apps->elfsight_status) && $apps->elfsight_status==1?"checked":"";?> checked><?= lang('active');?></label>
                                <label class="custom-radio-2"><input type="radio" name="elfsight_status" value="0" <?= isset($apps->elfsight_status) && $apps->elfsight_status==0?"checked":"";?>><?= lang('deactive');?></label>
                                
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label><?= lang('pagination_limit');?></label>
                                <input type="number" name="pagination_limit" class="form-control" value="<?= isset($apps->pagination_limit)?$apps->pagination_limit:15;?>">
                            </div>

                            <div class="form-group col-md-4">
                                <label><?= lang('scroll_top_arrow');?></label>
                                <select name="is_scroll_top" id="is_scroll_top" class="form-control">
                                    <option value="1" <?= isset($apps->is_scroll_top) && $apps->is_scroll_top==1?"selected":'';?>><?= lang('enable');?></option>
                                    <option value="0" <?= isset($apps->is_scroll_top) && $apps->is_scroll_top==0?"selected":'';?>><?= lang('disable');?></option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label><?= lang('edit_order');?></label>
                                <select name="edit_order_type" id="edit_order_type" class="form-control">
                                    <option value="0" <?= isset($apps->edit_order_type) && $apps->edit_order_type==0?"selected":'';?>><?= lang('order_details');?></option>
                                    <?php if (file_exists(APPPATH.'controllers/admin/Pos.php')) : ?>
                                        <option value="1" <?= isset($apps->edit_order_type) && $apps->edit_order_type==1?"selected":'';?>><?= lang('pos');?></option>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label><?= lang('item_limit');?></label>
                                <input type="number" name="item_limit" class="form-control" value="<?= isset($apps->item_limit)?$apps->item_limit:8;?>">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class=" form-group col-md-12">
                                <label><?= lang('terms_condition');?></label>
                                <textarea name="terms" id="terms" cols="30" rows="10" class="form-control textarea"><?= isset($apps->terms)?json_decode($apps->terms):'';?></textarea>
                            </div>
                        </div>
                    </div><!-- card-content -->
                </div><!-- card-body -->
                <div class="card-footer text-right"> 
                    <input type="hidden" name="id" value="<?= isset($u_settings['id'])?$u_settings['id']:0;?>">
                    <button type="submit" class="btn btn-secondary"><?= lang('save_change');?></button>
                </div>
            </div><!-- card -->
        </form>
    </div>
</div>

<script>
    function changeLang(val){
        $('.languageItems').slideUp();
        $(`.${val}`).slideDown();
    }
</script>