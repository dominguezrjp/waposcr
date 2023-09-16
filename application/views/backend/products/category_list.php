    <div class="row">

    <?php if($is_edit==True): ?>
        <div class="col-lg-6">
            <div class="card">
              <div class="card-header"> <h5 class="m-0 mr-5">Add New Category</h5></div>
                <form method="POST" action="<?= base_url("admin/products/add_category");?>" class="form-submit">
                    <?= csrf();?>
                    <div class="card-body">
                        <div class="card-content">
                            <div class="form-group">
                                <label for="Name">Category Name</label>
                                <input id="Name" class="form-control" type="text" name="category_name" placeholder="Category Name" value="<?=isset($data->category_name)? $data->category_name:""; ;?>">
                            </div>

                            <div class="form-group">
                                <label for="Name">Slug</label>
                                <input id="slug" class="form-control" type="text" name="slug" placeholder="slug" value="<?=isset($data->slug)? $data->slug:""; ;?>" >
                            </div>

                        </div>
                    </div>
                    <div class="card-footer text-right"> 
                        <?= hidden('id', isset($data->id)?$data->id:0);?>
                        <a href="<?= base_url("admin/products/categories");?>" class="btn btn-default float-left">Cancel</a>
                        <button type="submit" class="btn btn-secondary">Submit</button>
                    </div>
                </form>
            </div>

        </div>

    <?php endif; ?>
        <div class="col-lg-6">           
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">All Categories</h5>
                    <div class="card-tools">
                        <a href="<?= base_url("admin/products/create_category");?>" class="btn btn-secondary text-right btn-sm addBtn"><i
                                class="fa fa-plus"></i> Add New Category</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-content">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($category_list as $key => $row): ?>
                                        <tr id="hide_<?= $row['id'];?>">
                                            <td><?= $key + 1;?></td>
                                            <td><?= $row['category_name'] ?></td>
                                            <td><?= $row['slug'] ?></td>
                                            <td>
                                                <a href="<?= base_url("/admin/products/edit_category/{$row['id']}") ?>"
                                                    class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                                <a href="<?= base_url("/delete-item/{$row['id']}") ?>"
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