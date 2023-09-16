<?php if(!empty($pages['title'])): ?>
<div class="terms_page">
	<div class="container">
		<div class="row mt-50">
			<div class="col-md-12">
				<h4 class="terms_heading"><?= $pages['title'];?></h4>
				<p><?= $pages['details'];?></p>
			</div>
		</div>
	</div>
</div>
<?php endif;?>