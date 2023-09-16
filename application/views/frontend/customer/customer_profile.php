<div class="topCustomerProfile">
    <h4><?= !empty(lang('customer_panel'))?lang('customer_panel'):"Customer panel"; ?></h4>
</div>
<div class="customer_profile">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?php include APPPATH.'views/frontend/customer/leftSidebar.php';  ?>
            </div>
            <div class="col-md-9">
                <div class="serviceRightSide">
                    <div class="profleForm">
                        <h4 class="header"><?= !empty(lang('personal_info'))?lang('personal_info'):"Personal Info" ;?>
                        </h4>
                        <form action="<?= base_url('staff/update_profile') ;?>" method="post"
                            enctype="multipart/form-data">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                                value="<?= $this->security->get_csrf_hash(); ?>">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <div class="user_profile_img text-center">
                                        <label title="Upload Profile Picture">
                                            <img src="<?= base_url(!empty($info['thumb'])?$info['thumb']:'') ;?>"
                                                class="load_image" id="preview_load_image" alt="">
                                            <input type="file" name="file[]" id="load_image" style="display: none;"
                                                accept="image/*">
                                        </label>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for=""><?= lang('name'); ?></label>
                                    <input type="text" name="name" class="form-control"
                                        value="<?=  $info['customer_name'];?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for=""><?= lang('email'); ?></label>
                                    <input type="text" name="email" class="form-control" value="<?=  $info['email'];?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for=""><?= !empty(lang('country'))?lang('country'):"Country" ;?></label>
                                    <select name="country_id" class="form-control">
                                        <?php foreach ($countries as $key => $country): ?>
                                        <option value="<?=  $country['id'];?>"
                                            <?= $info['country_id']==$country['id']?"selected":"" ;?>>
                                            <?=  $country['name'];?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for=""><?= lang('phone'); ?></label>
                                    <div class="input-group">
                                        <span
                                            class="input-group-addon"><?=  my_currency($info['country_id'],'dial_code');?></span>
                                        <input type="text" name="phone" class="form-control"
                                            placeholder="<?= !empty(lang('phone'))?lang('phone'):"Phone";?>"
                                            value="<?=  $info['phone'];?>">
                                    </div>

                                </div>
                                <?php $question = !empty($info['question'])?json_decode($info['question']):''; ?>
                                <div class="form-group col-md-6">
                                    <label for=""><?= lang('security_question'); ?></label>
                                    <select name="question" id="" class="form-control">
                                        <?php foreach ($question_list as $q): ?>
                                        <option value="<?= $q['id'];?>"
                                            <?= isset($question->id) && $question->id==$q['id']?"selected":"";?>>
                                            <?= $q['title'];?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for=""><?= lang('write_your_answer_here'); ?></label>
                                    <input type="text" name="answer" id="" class="form-control"
                                        placeholder="<?= lang('write_your_answer_here');?>"
                                        value="<?= isset($question->answer) && !empty($question->answer)? $question->answer:"";?>">
                                </div>

                                <div class="form-group col-md-12">
                                    <label for=""><?= lang('gmap_link'); ?></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                        <input type="text" name="gmap_link" class="form-control"
                                            placeholder="<?= !empty(lang('gmap_link'))?lang('gmap_link'):"gmap_link";?>"
                                            value="<?=  $info['gmap_link'];?>">
                                    </div>

                                </div>

                                <div class="form-group col-md-12">
                                    <label for=""><?= lang('address'); ?></label>
                                    <textarea name="address" id="" cols="5" rows="5"
                                        class="form-control"><?=  $info['address'];?></textarea>

                                </div>
                                <div class="form-group text-center mt-20 mb-0 col-md-12">
                                    <input type="hidden" name="active_phone" value="<?=  $info['phone'];?>">
                                    <button class="btn btn-primary"><?= lang('submit'); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>