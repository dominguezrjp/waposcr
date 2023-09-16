    <div class="row">
        <div class="col-lg-6">           
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">All Features</h5>
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
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($feature_list as $key => $row): ?>
                                        <tr id="hide_<?= $row['id'];?>">
                                            <td><?= $key + 1;?></td>
                                            <td><?= $row['name'] ?></td>
                                            <td><?= $row['slug'] ?></td>
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

