<div class="" id="successMessage">
    <?php if ($this->session->flashdata('success')) { ?>
    <div class="alert alert-success alert-dismissible custom_alert" id="successMessage">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4>
            <i class="icon fa fa-check"></i>
            <?= !empty(lang('success'))?lang('success'):"Success";?>!
        </h4>
        <?= $this->session->flashdata('success'); ?>
    </div>
    <?php } ?>
     <?php if ($this->session->flashdata('error')) { ?>
        <div class="alert alert-danger alert-dismissible custom_alert" id="successMessage">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4>
                <i class="icon fa fa-exclamation-circle"></i>
                <?= !empty(lang('error'))?lang('error'):"Error";?>!!
            </h4>
            <?= $this->session->flashdata('error'); ?>
        </div>
    <?php } ?>
</div>

