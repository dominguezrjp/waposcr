<div class="row">
    <div class="col-lg-6">
        <div class="card">
          <div class="card-header"> <h5 class="m-0 mr-5">Create Category</h5></div>
            <form method="POST" action="<?= base_url("admin/settings/add_category");?>" class="form-submit">
                <?= csrf();?>
                <div class="card-body">
                    <div class="card-content">
                        <div class="form-group">
                            <label for="Name">Title</label>
                            <input id="Name" class="form-control" type="text" name="title" placeholder="Title" value="<?=isset($data->name)? $data->name:""; ;?>">
                        </div>

                        <div class="form-group">
                            <label for="Name">Category</label>
                            <select name="category" class="form-control niceSelect wide" id="field_type">
                            	<option value="">Select Field type</option>
                            	<?php foreach (category_list() as $key => $field): ?>
                            		<option value="<?= $key;?>"><?= $field;?></option>
                            	<?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="Name">Fields</label>
                            <div class="fieldList">
                            	<?php foreach ($field_list as $key => $field): ?>
                            		<label class="custom-checkbox"><input type="checkbox" name="field_ids[]" value="<?= $field['id'];?>"> <?= $field['title']?> </label>
                            	<?php endforeach ?>
                            	
                            </div>
                        </div>

                        
                      
                    </div>
                </div>
                <div class="card-footer text-right"> 
                    <?= hidden('id', isset($data->id)?$data->id:0);?>
                    <a href="<?= base_url("admin/pcakage/feature_list");?>" class="btn btn-default float-left">Cancel</a>
                    <button type="submit" class="btn btn-secondary">Submit</button>
                </div>
            </form>
        </div>
  
     </div>
</div>
