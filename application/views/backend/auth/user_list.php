    <div class="row">
        <div class="col-lg-8">           
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Subscriber list</h5>
                    <div class="card-tools">
                        <a href="<?= base_url("admin/auth/add_subscriber");?>" class="btn btn-secondary text-right btn-sm addBtn"><i
                                class="fa fa-plus"></i> Add New Subscriber</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-content">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Username</th>
                                        <th>Account Type</th>
                                        <th>Active Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($user_list as $key => $row): ?>
                                        <tr id="hide_<?= $row['id'];?>">
                                            <td><?= $key + 1;?></td>
                                            <td><?= $row['username'] ?></td>
                                            <td>
                                            	<label class="badge badge-primary"><?= $row['package_name'] ?></label>
                                            	<label class="badge badge-info"><?= $row['package_type'] ?></label>
                                            </td>
                                            <td><label class="badge badge-success">Activated</label></td>
                                            <td><?= full_time($row['active_date']) ?></td>
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

