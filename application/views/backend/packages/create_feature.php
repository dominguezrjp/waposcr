<div class="row">
    <div class="col-lg-6">
        <div class="card">
          <div class="card-header"> <h5 class="m-0 mr-5">Create Features</h5></div>
            <form method="POST" action="<?= base_url("admin/package/add_features");?>" class="form-submit">
                <?= csrf();?>
                <div class="card-body">
                    <div class="card-content">
                        <div class="form-group">
                            <label for="Name">Name</label>
                            <input id="Name" class="form-control" type="text" name="name" placeholder="Name" value="<?=isset($data->name)? $data->name:""; ;?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="Name">Slug</label>
                            <input id="slug" class="form-control" type="text" name="slug" placeholder="slug" value="<?=isset($data->slug)? $data->slug:""; ;?>" >
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
