<?php 
    if(check() !=1):
        exit();
    endif;

 ?>

<div class="row">
    <?php include 'inc/leftsidebar.php'; ?>
    <?php $notification = !empty($settings['onesignal_config']) ? json_decode($settings['onesignal_config']) : ""; ?>
    <div class="col-md-9">
        <div class="row">
            <?php if (isset($notification->is_active_onsignal) && $notification->is_active_onsignal == 1) : ?>
                <div class="col-md-6">
                    <form action="<?= base_url('admin/onesignal/send_notification'); ?>" method="post" class="validForm"
                        enctype="multipart/form-data">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                            value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="card">
                            <div class="card-header">
                                <h4><?= lang('send_notifications'); ?></h4>
                            </div>
                            <div class="card-body">

                                <div class="row">

                                    <div class="form-group col-md-12">
                                        <label for=""><?= lang('heading'); ?> </label>
                                        <input type="text" name="headings" class="form-control"
                                            placeholder="<?= lang('heading'); ?>">

                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for=""><?= lang('message'); ?></label>
                                        <textarea name="msg" class="form-control" id="msg" cols="5" rows="5"
                                            placeholder="<?= lang('message'); ?>"></textarea>

                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for=""><?= lang('custom_link'); ?> </label>
                                        <input type="text" name="url" class="form-control"
                                            placeholder="<?= lang('custom_link'); ?>">

                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for=""><?= lang('subscriber list'); ?> <label href="javascript:;" class="pl-5 label success-light pointer custom-checkbox"><input type="checkbox" class="checkAll" data-lang="<?= lang('checked_all');?>"> <?= lang('select_all');?></label></label>
                                        <select name="user_id[]" class="form-control select2" id="checkedItem" multiple placeholder="<?= lang('select');?>">
                                            <?php foreach ($allUsers as $key => $value) { ?>
                                            <option value="<?= $value; ?>"><?= $value ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>

                                </div>

                            </div><!-- card-body -->
                            <div class="card-footer text-right">
                                <input type="hidden" name="app_id"
                                    value="<?= isset($notification->onsignal_app_id) && !empty($notification->onsignal_app_id) ? $notification->onsignal_app_id : 0; ?>">

                                <button type="submit" class="btn btn-secondary"><?= lang('submit'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            <?php endif ?>

            <div class="col-md-6">
                <form action="<?= base_url('admin/onesignal/add_notification'); ?>" method="post" class="validForm"
                    enctype="multipart/form-data">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                        value="<?= $this->security->get_csrf_hash(); ?>">
                    <div class="card">
                        <div class="card-header">
                            <h4><?= lang('onesignal_configuration'); ?></h4>
                        </div>
                        <div class="card-body">

                            <div class="row">

                                <div class="form-group col-md-12">
                                    <label for=""><?= lang('onsignal_app_id'); ?> </label>
                                    <input type="text" name="onsignal_app_id" class="form-control"
                                        placeholder="<?= lang('onsignal_app_id'); ?>"
                                        value="<?= !empty($notification->onsignal_app_id) ? $notification->onsignal_app_id : ""; ?>">

                                </div>
                                <div class="form-group col-md-12">
                                    <label for=""><?= lang('rest_api_key'); ?></label>
                                    <input type="text" name="user_auth_key" class="form-control"
                                        placeholder="<?= lang('rest_api_key'); ?>"
                                        value="<?= !empty($notification->user_auth_key) ? $notification->user_auth_key : ""; ?>">

                                </div>

                                

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="custom-radio" style="margin-right:20px;"> <input type="radio"
                                                name="is_active_onsignal" checked
                                            <?= isset($notification->is_active_onsignal) && $notification->is_active_onsignal == 1 ? "checked" : ""; ?>
                                                value="1"><?= lang('active') ?></label>

                                        <label class="custom-radio"> <input type="radio" name="is_active_onsignal" value="0"
                                            <?= isset($notification->is_active_onsignal) && $notification->is_active_onsignal == 0 ? "checked" : ""; ?>><?= lang('disable') ?></label>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                               <hr/>

                               <div class="form-group col-md-12">
                                    <label for=""><?= lang('onesignal_user_id'); ?></label>
                                    <input type="text" name="user_id" class="form-control"
                                    placeholder="<?= lang('user_auth_key'); ?>"
                                    value="<?= !empty($notification->user_id) ? $notification->user_id : ""; ?>">

                                </div>

                                <div class="form-group col-md-12 mt-5">
                                    <label class="custom-checkbox"><input type="checkbox" name="is_order_push" value="1" <?= isset($notification->is_order_push) && $notification->is_order_push==1 ? "checked" : ""; ?>><?= lang('enable_push_for_new_order'); ?></label>
                                </div>
                        </div>

                        </div><!-- card-body -->
                        <div class="card-footer text-right">
                            <input type="hidden" name="id"
                                value="<?= isset($settings['id']) && !empty($settings['id']) ? $settings['id'] : 0; ?>">

                            <button type="submit" class="btn btn-secondary"><?= lang('submit'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
            </div>
    </div><!-- col-md-12 -->
</div>

