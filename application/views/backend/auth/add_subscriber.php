<div class="row">
    <div class="col-lg-6">
        <div class="card">
          <div class="card-header"> <h5 class="m-0 mr-5">Add New Subscriber</h5></div>
            <form method="POST" action="<?= base_url("admin/auth/create_subscriber");?>" class="form-submit">
                <?= csrf();?>
                <div class="card-body">
                    <div class="card-content">
                        <div class="form-group">
                            <label>Username</label>
                            <input class="form-control" type="text" name="username" id="username" placeholder="Name" value="<?=isset($data->name)? $data->name:""; ;?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="Name">Package List</label>
                           	<select name="package_id" class="form-control niceSelect wide" id="packageList">
                           		<option value="">Select package</option>
                           		<?php foreach ($package_list as $key => $package): ?>
                           			<option value="<?= $package['id'];?>"><?= $package['package_name'];?></option>
                           		<?php endforeach ?>
                           	</select>
                        </div>
                      
                    </div>
                </div>
                <div class="card-footer text-right"> 
                    <?= hidden('id', isset($data->id)?$data->id:0);?>
                    <a href="<?= base_url("admin/auth/user_list");?>" class="btn btn-default float-left">Cancel</a>
                    <button type="submit" class="btn btn-secondary">Submit</button>
                </div>
            </form>
        </div>
  
      </div>
</div>
