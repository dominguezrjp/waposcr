<div class="row">
    <div class="col-lg-6">
        <div class="card">
          <div class="card-header"> <h5 class="m-0 mr-5">Create Fields</h5></div>
            <form method="POST" action="<?= base_url("admin/settings/add_fields");?>" class="form-submit">
                <?= csrf();?>
                <div class="card-body">
                    <div class="card-content">
                        <div class="form-group">
                            <label for="Name">Title</label>
                            <input id="Name" class="form-control" type="text" name="title" placeholder="Title" value="<?=isset($data->name)? $data->name:""; ;?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="Name">Field Name</label>
                            <input id="slug" class="form-control remove_space" type="text" name="field_name" placeholder="field name" value="<?=isset($data->slug)? $data->slug:""; ;?>" >
                        </div>

                        <div class="form-group">
                            <label for="Name">Field Type</label>
                            <select name="field_type" class="form-control niceSelect wide" id="field_type">
                            	<option value="">Select Field type</option>
                            	<?php foreach (field_types() as $key => $field): ?>
                            		<option value="<?= $key;?>"><?= $field;?></option>
                            	<?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="Name">Placeholder</label>
                            <input id="slug" class="form-control" type="text" name="placeholder" placeholder="Placeholder" value="<?=isset($data->slug)? $data->slug:""; ;?>" >
                        </div>

                        <div class="form-group mt-10">
                            <label class="custom-checkbox"><input type="checkbox" name="is_required"  value="1"> Is Required</label>
                            
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
     <div class="col-lg-6">           
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">All Fields</h5>
                    <div class="card-tools">
                        <a href="<?= base_url("admin/package/create_feature");?>" class="btn btn-secondary text-right btn-sm addBtn"><i
                                class="fa fa-plus"></i> Add New Feature</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-content">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Title</th>
                                        <th>Field Name</th>
                                        <th>Field Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($field_list as $key => $row): ?>
                                        <tr id="hide_<?= $row['id'];?>">
                                            <td><?= $key + 1;?></td>
                                            <td><?= $row['title'] ?></td>
                                            <td><?= $row['field_name'] ?></td>
                                            <td><?= $row['field_type'] ?></td>
                                            <td>
                                                <a href="<?= base_url("/admin/package/edit_features/{$row['id']}") ?>"
                                                    class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                                <a href="<?= base_url("/delete-feature/{$row['id']}") ?>"
                                                    data-id="<?= $row['id']; ?>" data-msg="Want to delete?"
                                                    class="btn btn-danger btn-sm ajaxDelete"><i class="fa fa-trash"></i>
                                                    Delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
</div>
