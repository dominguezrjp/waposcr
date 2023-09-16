    <div class="row">
        <div class="col-lg-6">           
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Categories</h5>
                    <div class="card-tools">
                        <a href="<?= base_url("admin/settings/create_category");?>" class="btn btn-secondary text-right btn-sm addBtn"><i
                                class="fa fa-plus"></i> Create Category</a>
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
                                        <th>Category</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($category_list as $key => $row): ?>
                                        <tr id="hide_<?= $row['id'] ?>">
                                            <td><?= $key + 1;?></td>
                                            <td><?= $row['title'] ?></td>                                            <td><?= $row['category'] ?></td>
                                            <td>
                                                <a href="<?= base_url("admin/package/edit_package/{$row['id']}") ?>"
                                                    class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                                <a href="<?= base_url("/delete-feature/{$row['id']}") ?>"
                                                    data-id="<?= $row['id'] ?>" data-msg="Want to delete?"
                                                    class="btn btn-danger btn-sm ajaxDelete"><i class="fa fa-trash"></i>
                                                    Delete</a>
                                            </td>
                                        </tr>
                                
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

