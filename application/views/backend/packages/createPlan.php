<div class="row">
    <div class="col-lg-8">
        <div class="card">
          <div class="card-header"> <h5 class="m-0 mr-5">Create Plan</h5></div>
            <form method="POST" class="form-submit" action="<?= base_url("admin/package/add_packages");?>">
            <?=csrf() ;?>
                <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                         <div class="card-content">
                        <div class="form-group">
                            <label for="Name">Name</label>
                            <input id="Name" class="form-control" type="text" name="package_name" placeholder="Name" value="<?=isset($data->package_name)? $data->package_name:""; ;?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="Name">Slug</label>
                            <input id="slug" class="form-control" type="text" name="slug" placeholder="slug" value="<?=isset($data->slug)? $data->slug:""; ;?>">
                         
                        </div>
                        <div class="form-group mb-15">
                            <label for="Name">Type</label>
                            <div class="nice-selects">
                                <select name="package_type" id="planType" class="form-control niceSelect wide" >
                                    <option value="">Select Type</option>
                                    <?php foreach (feature_types() as $key => $type): ?>
                                        <option <?= isset($data->slug) && $data->package_type==$key?"selected":""; ?> value="<?= $key;?>"><?= $type;?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Name">Price</label>
                            <input id="price" class="form-control" type="number" name="price" placeholder="price" value="<?=isset($data->price)? $data->price:""; ;?>" >
                        </div>
                    </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card-content">
                            <ul class="featureList">
                                <?php foreach ($feature_list as $key => $feature): ?>
                                    <?php if(isset($data->id)): ?>
                                        <?php $feature_id = $this->admin_m->check_feature_id_by_package_id($feature->id,$data->id); ?>
                                    <?php endif ?>
                                    <li>
                                        <label class="custom-checkbox"><span><?= $key+1;?></span><input type="checkbox"  <?= isset($feature_id['feature_id']) && $feature_id['feature_id']==$feature->id?"checked":'' ;?>  name="feature_id[]" value="<?= $feature->id ?>"> &nbsp; <?= html_escape($feature->name); ?> </label>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                </div>
                   
                </div>
                <div class="card-footer text-right"> 
                    <?= hidden('id', isset($data->id)?$data->id:0);?>
                    <a href="<?= base_url('admin/package/') ?>" class="btn btn-default float-left">Cancel</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
  
      </div>
</div>
@endsection