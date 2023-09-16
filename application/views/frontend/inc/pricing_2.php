<div class="pricing_2">
    <div class="newPriceLayout m-auto text-center">
        <?php foreach ($packages as $key => $package): ?>
            <div class="princing-item red bg-white mt-0 shadow">
                <div class="priceTopCard">
                    <div class="pricing-divider ">
                        <h3 class="text-light"><?= html_escape($package['package_name']);?></h3>
                        <?php if($package['package_type']=='free'): ?>
                            <h4 class="my-0  text-light font-weight-normal mb-3"><span class="h3"><?= !empty(lang('free'))?lang('free'):'Free';?></span></h4>
                        <?php elseif($package['package_type']=='trial'): ?>
                            <h4 class="my-0  text-light font-weight-normal mb-3"><span class="h3"><?= !empty(lang('free'))?lang('free'):'Free';?> <span class="h5"> / <?= !empty(lang('month'))?lang('month'):'month';?></span></h4>

                        <?php elseif($package['package_type']=='weekly'): ?>
                            <h4 class="my-0  text-light font-weight-normal mb-3"><span class="h3"><?= !empty(lang('free'))?lang('free'):'Free';?> <span class="h5"> / <?= !empty(lang('week'))?lang('week'):'week';?></span></h4>

                        <?php elseif($package['package_type']=='fifteen'): ?>
                            <h4 class="my-0  text-light font-weight-normal mb-3"><span class="h3"><?= !empty(lang('free'))?lang('free'):'Free';?> <span class="h5"> / <?= !empty(lang('15_days'))?lang('15_days'):'15 days';?></span></h4>

                        <?php else: ?>
                            <h4 class="my-0  text-light font-weight-normal mb-3"> <?= admin_currency_position(html_escape($package['price'])) ;?> <span class="h5"> / <?= !empty($package['package_type'])?get_package_type($package['package_type'],$package['duration'],$package['duration_period']):get_package_type($package['package_type'],$package['duration'],$package['duration_period']);?></span></h4>
                        <?php endif;?>
                         
                        <svg class='pricing-divider-img' enable-background='new 0 0 300 100' height='100px' id='Layer_1' preserveAspectRatio='none' version='1.1' viewBox='0 0 300 100' width='300px' x='0px' xml:space='preserve' y='0px'>
                            <path class='deco-layer deco-layer--4' d='M-34.667,62.998c0,0,56-45.667,120.316-27.839C167.484,57.842,197,41.332,232.286,30.428 c53.07-16.399,104.047,36.903,104.047,36.903l1.333,36.667l-372-2.954L-34.667,62.998z' fill='#FFFFFF'></path>
                        </svg>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled position-relative">
                            <?php foreach ($all_features as $key2 => $feature): ?>
                                <?php $feature_id = get_price_feature_id($feature['id'],$package['id']); ?>

                                 <?php if(LICENSE == '6fa1b959a5580d843a4ea03422873009' && $feature['slug'] == 'online-payment'): ?>
                                 <?php else: ?>

                                <li><i class="fas <?= isset($feature_id['feature_id']) && $feature_id['feature_id']==$feature['id']?'fa-check c_green':'fa-times c_red';?> "></i> <?= html_escape($feature['features']);?> <?= html_escape($feature['slug'])=='menu'?' <b>('.limit_text($package['item_limit']).' '. lang('items').') </b>':'' ;?>  <?= html_escape($feature['slug'])=='order'?' <b>('.limit_text($package['order_limit']).') </b>':'' ;?></li>

                                <?php endif;?>
                            <?php endforeach; ?>


                            <?php $customFields = isset($package['custom_fields_config']) && !empty($package['custom_fields_config'])?json_decode($package['custom_fields_config'],true):[]; ?>

                        <?php if(is_array($customFields) && !empty($customFields)): ?>
                            <?php foreach ($customFields as $fields): ?>
                                <?php if(!empty($fields)): ?>
                                    <li><span class="fas"><i class="fas fa-check c_green"></i></span> <?= $fields;?></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        </ul> 
                    </div>
                  
                </div>
                  <div class="priceCardFooter">
                      <a href="<?= base_url('signup-'.$package['slug']) ;?>" class="btn btn-lg btn-block btn-custom "><?= !empty(lang('select_package'))?lang('select_package'):'Select Package' ;?></a>
                  </div>
            </div>
        <?php endforeach; ?>
        
        </div>
    </div>
</div>