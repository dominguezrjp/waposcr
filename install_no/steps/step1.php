<form action="#" id="register_form">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Purchase code verification</h4>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="form-group col-md-12">
					<input type="text" name="purchase_code" class="form-control" placeholder="Enter Your Purchase code" required>
				</div>

			</div>
			<div class="row">
				<div class="form-group col-md-6">
					<input type="text" name="username" class="form-control" placeholder="Codecanyon Account Name " onfocus="this.removeAttribute('readonly');" onblur="this.setAttribute('readonly','readonly');" required readonly>
				</div>
				<div class="form-group col-md-6">
					<input type="email" name="account_email" class="form-control" placeholder="Codecanyon Account Email " required>
				</div>
			</div>
		</div>
		<div class="card-footer">
			<button type="submit" class="btn btn-secondary btn-block submit-btn" name="submit" id="submit-btn" value="submit" disabled> <i class="fa fa-check"></i> &nbsp;Verify </button>
		</div>
	</div>
</form>

<script>
	$("#register_form").submit(function(){
		$this = $(this);
		$.ajax({
			url:'step.php',
			type:'POST',
			dataType:'json',
			data:$this.serialize(),
			beforeSend:function(){$this.find("button[type=submit]").btn("loading");},
			complete:function(){$this.find("button[type=submit]").btn("reset");},
			success:function(json){
				if(json['st']==1){
					window.location.reload();
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


	$('[name="purchase_code"]').change(function(){
        $this = $(this);
        $btn =  $this.closest("form").find("button[type=submit]");
        $form = $("#register_form");
        $.ajax({
            url:'codecanyon.php',
            type:'POST',
            dataType:'json',
            data:{
                purchase_code: $this.val()
            },
            beforeSend:function(){ $btn.btn('loading');},
			complete:function(){ $btn.btn('reset');},
            success:function(json){               
                if(json['st']==0){
                    $('[name="username"]').val('');
                    jQuery.MSG(false,json['msg']);
                   $("#submit-btn").attr('disabled');
                   $btn.btn('reset');
                }else{
                    if(json.buyer){
                        $('[name="username"]').val(json.buyer);
                        $("#submit-btn").removeAttr('disabled');
                        jQuery.MSG(true,json['msg']);
                         $btn.btn('reset');
                    }

                }
            },
        })

        return false;
    })

   


</script>
