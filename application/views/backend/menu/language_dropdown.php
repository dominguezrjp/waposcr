<?php $extra = extra_settings(auth('id')); ?>
<?php if(isset($extra['language_type']) && $extra['language_type']=="system"): ?>
    <div class="col-md-3">
        <div class="card">
            <select name="lang" class="form-control" onchange="location=this.value">
                <?php foreach (shop_languages(auth('id')) as $key => $row) : ?>
                        <option value="<?= base_url("admin/{$controller}/{$function}?lang={$row->slug}");?>" <?= isset($lang) && $lang==$row->slug?"selected":"";?>><?= $row->lang_name;?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
<?php endif; ?> <!-- language_type -->