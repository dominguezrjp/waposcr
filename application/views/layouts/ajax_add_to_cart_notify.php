<div class="cartNofify">
    <div class="leftNotify">
        <p><strong><?= html_escape($name) ;?></strong> &nbsp; <?= lang('has_been_add_to_cart'); ?>. </p> <a href="javascript:;" class="navCart" data-slug="<?= $slug??'';?>"> <?= lang(''); ?></a>
    </div>
    <div class="rightNotify">
        <a href="javascript:;" class="closeNotify"><i class="icofont-close-line"></i></a>
    </div>
</div>