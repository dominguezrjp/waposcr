<div class="row">
    <?php foreach ($profile_list as $row): ?>
        <div class="col-md-4 mb-15">
            <div class="card">
                <div class="card-body text-center">
                    <div class="single_profile">
                        <div class="imgArea p-r">
                            <img src="<?= base_url(!empty($row['thumb'])?$row['thumb']:'assets/images/avatar.png') ;?>" class="profile_img" alt="">
                            <span class="cardIcon" data-toggle="tooltip" title="vCard">
                                <i class="icofont-id-card"></i>
                            </span>
                        </div>
                        <div class="profileDetails">
                            <h4 class="fw-bold"><?= !empty($row['name'])?$row['name']:$row['username'] ;?></h4>
                            <p><?= !empty($row['dial_code'])?$row['dial_code']:"" ;?> <?= !empty($row['phone'])?$row['phone']:"" ;?></p>
                        </div>
                        <div class="buttonArea">
                            <a href="<?= base_url($row['username']); ?>" class="btn btn-sm btn-secondary"><i class="fa fa-eye"></i></a>
                            <div class="dropdown p-r">
                              <button class="btn btn-primary dropdown-toggle btn-sm p-r" type="button" data-toggle="dropdown">Configuration &nbsp;&nbsp;&nbsp;
                                  <span class="caret"></span></button>
                                  <ul class="dropdown-menu">

                                    <li><a href=""><?= lang('edit_add_information');?> </a></li>
                                    <li><a href=""><?= lang('edit_add_icon');?></a></li>
                                    <li><a href=""><?= lang('change_layouts'); ?></a></li>
                                    <li class=""><a href=""><?= lang('config_pwa'); ?></a></li>
                                    <li class=""><a href=""><?= lang('settings'); ?></a></li>
                                    <li class="divider"></li>
                                    <li><a href=""><?= lang('edit'); ?></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>
    <div class="col-lg-4">
        <div class="card">
                <form method="POST" action="<?= base_url(" ");?>" class="form-submit">
                 <?= csrf();?>
                 <div class="card-body">
                     <div class="card-content">
                     	<a href="javascript:;"  class="showSidebar">
                        <!-- <a href="#createModal" data-toggle="modal" class="showSidebar"> -->
                     		<div class="create_new_card">
                     			<i class="fa fa-plus"></i>
                     			<h4>Create new shop</h4>
                     		</div>
                     	</a>

                     </div><!-- card-content -->
                 </div><!-- card-body -->
                </form><!-- from -->
        </div><!-- card -->
    </div><!-- col-6 -->

</div><!-- row -->



<div class="sidebar-modal">
    <div class="heading">Create Category</div>
    <div class="sidebar-content">
        <form method="POST" action="<?= base_url("admin/vendor/create_vendor_account");?>" class="form-submit">
           <?= csrf();?>
            <div class="sidebar-wrapper">
                <div class="sidebar-body">
                    <div class="form-group">
                        <label>Category</label>
                        <select name="category_id" class="form-control" id="">
                            <option value="">Select Category</option>
                             <?php foreach ($category_list as $category): ?>
                                 <option value="<?= $category['category'];?>"><?= $category['title'];?></option>
                             <?php endforeach ?>
                        </select>
                    </div>

                    <div class="form-group">
                         <label>Username</label>
                         <input type="text" name="username" id="username" class="form-control" placeholder="Username">
                     </div>
                     <div class="form-group">
                         <label>Email</label>
                         <input type="text" name="email" id="email" class="form-control" placeholder="Email">
                     </div>
                     <div class="form-group">
                        <label>phone</label>
                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone">
                    </div>
                </div><!--sidebar-body  -->
                <div class="sidebar-footer text-right"> 
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div><!-- card-footer --> 
            </div>
        </form><!-- form -->
    </div><!-- sidebar-content -->

</div><!-- sidebar-modal -->

