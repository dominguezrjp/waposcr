<?php  $pricing = get_by_section_name('pricing');
		$settings = settings();
 ?>
<?php if($this->settings['is_registration']==1): ?>
	<section class="home_pricing teamSections">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 features-heading" data-aos="fade-down" data-aos-delay="100">
					<h2 class="heading-text"><?= html_escape($pricing['heading']) ;?></h2>
					<p><?= $pricing['sub_heading'] ;?></p>
				</div>
			</div>
			<?php include "inc/pricing_".html_escape($settings['pricing_layout']).".php"; ?>
		</div>
	</section>
<?php endif;?>