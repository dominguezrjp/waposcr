<div class="users_section homeSection mt-150">

	<div class="container">
		<form action="<?= base_url('home/users'); ?>" method="get" class="searchForm">
			<div class="formAreasearch">
				<div class="leftSearch">
					<div class="singleSearchUser">
						<h4><?= $this->common_m->count_total_user(); ?></h4>
						<p><?= !empty(lang('restaurants'))?lang('restaurants'):"Restaurants"; ?></p>
					</div>
				</div>
				<div class="rightSearch">
					<div class=" custom-col">
						<div class=" user_right_btn_area">
							<input type="text" class="form-control" name="username" placeholder="<?= lang('search_with_username'); ?>" value="<?= isset($_GET['username'])?$_GET['username']:"";?>">
						</div>
					</div>
					<div class=" custom-col">
						<div class="user_right_btn_area">
							<select name="package" id="" class="form-control">
								<option value=""><?= lang('select_package'); ?></option>
								<option <?= isset($_GET['sort']) && $_GET['sort']== 'all'?"selected":"";?>  value=""><?= lang('all'); ?></option>
								<?php foreach ($all_packages as $key => $package): ?>
									<option <?= isset($_GET['sort']) && $_GET['sort']== $package['slug']?"selected":"";?>  value="<?= $package['slug']; ?>"> <?= $package['package_name'];?> </option>
								<?php endforeach ?>
							</select>

						</div>
					</div>
					<div class="custom-col">
						<div class="user_right_btn_area">
							<select name="country" id="" class="form-control">
								<option value=""><?= lang('location'); ?></option>
								<option <?= isset($_GET['country']) && $_GET['country']== 'all'?"selected":"";?>  value=""><?= lang('all'); ?></option>
								<?php foreach ($countries as $key => $con): ?>
									<option <?= isset($_GET['country']) && $_GET['country']== $con['code']?"selected":"";?>  value="<?= $con['code']; ?>"> <?= $con['name'];?> </option>
								<?php endforeach ?>
							</select>

						</div>
					</div>
					<div class=" custom-col">
						<div class="user_right_btn_area">
							<button type="submit" class="btn btn-primary c_btn"><i class="icofont-search-user"></i> <?= lang('search'); ?></button>

						</div>
					</div>
				</div>
			</div>
		</form>
		<div class="row">
			<?php foreach ($users as $key => $row): ?>
				<div class="col-sm-4" data-aos="fade-up" data-aos-delay="<?= $key+1;?>00">
					<div class="single_users">
						<div class="single_user_top">
							<div class="home_user_profile">
								<img src="<?php echo base_url(!empty(restaurant($row['id'])->thumb)?restaurant($row['id'])->thumb:'assets/frontend/images/logo-example.png'); ?>" alt="user img">
							</div>
							<label class="badge badge-success"><?= html_escape($row['package_name']);?></label>
						</div>
						<div class="single_user_body">
							<h4 class="username"><?= !empty($row['restaurant_name'])?html_escape($row['restaurant_name']):$row['username'];?></h4>
							
							<div class="qr_area">
								<img src="<?= base_url(html_escape($row['qr_link'])) ;?>" alt="userImg">
							</div>
							<a href="<?php echo url(html_escape($row['username'])); ?>" target="blank" class="profile_btn"><i class="fa fa-eye"></i> <?= !empty(lang('view_profile'))?lang('view_profile'):"View Profile";?></a>
						</div>
					</div>
				</div>
			<?php endforeach ?>
		</div>
		<div class="row text-center">
			<div class="php-pagination">
				<?= $this->pagination->create_links();;?>
			</div>
		</div>
	</div>
</div>

