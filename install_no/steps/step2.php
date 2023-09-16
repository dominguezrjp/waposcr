<form action="#" id="register_form" method="post">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Database Information</h4>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="form-group col-md-12">
					<input type="text" name="db_hostname" class="form-control" placeholder="Database Host Name" required value="localhost">
				</div>

				<div class="form-group col-md-12">
					<input type="text" name="db_username" class="form-control" placeholder="Database Username "  required value="">
				</div>

				<div class="form-group col-md-12">
					<input type="password" name="db_password" class="form-control" placeholder="Database Password" onfocus="this.removeAttribute('readonly');" onblur="this.setAttribute('readonly','readonly');" readonly>
				</div>

				<div class="form-group col-md-12">
					<input type="text" name="db_name" class="form-control" placeholder="Database Name"  required value="">
				</div>

			</div>
			<hr>
			<div class="card-header mb-10">	<h4> SingUp / Login Information</h4></div>
			<div class="row">
				<div class="form-group col-md-12">
					<label for="">Your Email</label>
					<input type="text" name="email" class="form-control" required placeholder="Your email" value="">
				</div>

				<div class="form-group col-md-12">
					<label for="">Your Password</label>
					<input type="password" name="password" class="form-control" required placeholder="Your Password" value="">
				</div>
			</div>
			
		</div>
		<div class="card-footer">
			<input type="hidden" name="base_url" value="<?= root_url();?>">
			<input type="hidden" name="step_1" id="step_1" value="<?= isset($_SESSION['is_step_3'])?$_SESSION['is_step_3']:0;?>">
			<button type="submit" class="btn btn-secondary btn-block submit-btn" id="submit-btn">Continue &nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</form>

<script>
	$("#register_form").submit(function(){
		$this = $(this);
		$btn =  $this.closest("form").find("button[type=submit]");
		$.ajax({
			url:'install.php',
			type:'POST',
			dataType:'json',
			data:$this.serialize(),
			beforeSend:function(){$btn.btn('loading');},
			complete:function(){ $btn.btn('reset');},
			success:function(json){
				if(json['st']==1){
					window.location.reload();
				}else if(json['st']==0){
					jQuery.MSG(0,json['msg']);
				}               
				if(json['errors']){
					$.each(json['errors'], function(i,j){
						$ele = $this.find('[name="'+ i +'"]');
						if($ele){
							$ele.parents(".form-group").addClass("has-error");
							$ele.after("<span class='text-danger'>"+ j +"</span>");
						}
					})
				}
			},
		})

		return false;
	});
	


</script>