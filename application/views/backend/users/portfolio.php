<div class="row">
	<div class="col-md-6">
			<?php if($limit ==0): ?>
				<div class="single_alert alert alert-info alert-dismissible">
		            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		            <div class="d_flex_alert ">
		                <h4><i class="fas fa-exclamation-triangle"></i> Info!</h4>
		                <div class="double_text">
		                    <div class="text-left">
		                        <h5>You can added <b class="underline"> Unlimited </b> Portfolios</h5>
		                    </div>
		                    	
		                </div>
		            </div>
		        </div>
			<?php elseif($total > $limit): ?>
				<div class="single_alert alert alert-danger alert-dismissible">
		            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		            <div class="d_flex_alert ">
		                <h4> <i class="fas fa-exclamation-triangle"></i> Alert!</h4>
		                <div class="double_text">
		                    <div class="text-left">
		                        <h5><i class="fas fa-frown"></i> Sorry!</h5>
		                        <p>You reached the maximum limit <?= $limit ;?></p>
		                    </div>
		                    	
		                </div>
		            </div>
		        </div>
	        <?php else: ?>
	        	<div class="single_alert alert alert-info alert-dismissible">
		            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		            <div class="d_flex_alert ">
		                <h4><i class="fas fa-exclamation-triangle"></i> Info!</h4>
		                <div class="double_text">
		                    <div class="text-left">
		                        <h5>You have remaining  <b class="underline"> &nbsp; <?=  ($limit-$total);?> &nbsp;</b> Portfolios out of <b class="underline"> &nbsp; <?=  ($limit);?> &nbsp;</b></h5>
		                    </div>
		                    	
		                </div>
		            </div>
		        </div>
	        <?php endif;?>
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"><?= ucfirst(get_features_name('portfolio'));?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<div class=" box-body mt-15">

				<div class="portfolio-box-body">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#image" data-toggle="tab" aria-expanded="false">Image</a></li>
						<li class=""><a href="#video" data-toggle="tab" aria-expanded="true">Video</a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane fade in active" id="image">
							<form action="<?= base_url('admin/auth/add_portfolio') ?>" method="post" enctype="multipart/form-data" id="">
								<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

								<div class="col-md-12">
									<input type="file" accept="image/*" class="info_file image_upload" name="file[]" multiple  />
								</div>

								<div class="col-md-12 ">
							    	<div class="img_progress">
								        <div class="show_progress"style="display: none;">
								            <div class="progress">
								               <div class="progress-bar progress-bar-success progress-bar-striped myprogress" role="progressbar" style="width:0%">0%</div>
								        	</div>
								        </div>
								    </div>
							    </div>

								<div class="col-md-12">
									<div class="post_btn">
										<input type="hidden" name="is_video" value="0">
										<button type="submit" name="submit" class="btn btn-default custom_btn"><?= !empty(lang('submit'))?lang('submit'):"submit";?></button>
									</div>
								</div>
							</form>
						</div>
						<!-- /.tab-pane -->
						<div class="tab-pane fade" id="video">
							<form action="<?php echo base_url('admin/auth/add_portfolio') ?>" method="post" id="">

				              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
				              
					              <div class="gallery_body">
					                  <div class="online_up_area_content">
					                      <div id="video_fields" class="view_gallery_field"></div>
					                     
					                     <div class="input-group-btn">
					                        <button class="btn btn-info add_image" type="button"  onclick="video_fields();"> Add Link <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> </button>
					                      </div>
					                  </div>
					                   <div class="col-md-12">
					                    <div class="form-group">
					                          <div class="image_link_btn text-center" >
					                          	<input type="hidden" name="is_video" value="1">
					                            <button type="submit" class="btn btn-primary btn-lg image_link_btns" style="display: none;"  >Submit</button>
					                          </div>
					                        </div>
					                   </div>
					              </div>
					            <!-- progress area -->
					            <div class="online_progress" style="width: 99%;margin-left: 9px; display: none;">
					              <div class="progress">
					                <div class="progress-bar progress-bar-success progress-bar-striped myprogress" role="progressbar" style="width:0%">0%</div>
					              </div>
					            </div>
				            <!-- progress area -->


				          </form>
						</div>
						<!-- /.tab-pane -->
					</div>
						<!-- /.tab-content -->
				</div>
				
			</div>
		</div>
	</div>
	<!-- col-6 -->
</div>

<div class="row">
	<div class="col-md-12">
		<div id="grid_view" class="grid_4">
			<?php foreach ($portfolio as $img): ?>
				<div class="item" id="hide_image_<?= html_escape($img['id']);?>">
					<div class="single_image ">
						<?php if($img['is_video']==1): ?>
							<img src="<?= html_escape($img['thumb']); ?>" alt="">
						<?php else: ?>
							<img src="<?= base_url(html_escape($img['thumb'])); ?>" alt="">
						<?php endif;?>
						<a href="javascript:;" class="img_delete" data-id="<?= html_escape($img['id']);?>"><i class="fa fa-trash"></i></a>
					</div>
				</div>	
			<?php endforeach ?>
		</div>
	</div>
</div>


<script> 
	var j =0;
	function video_fields() {

    j++;
    var objTo = document.getElementById('video_fields')
    var divtest = document.createElement("div");
	divtest.setAttribute("class", "form-group removeclass"+j);
	var rdiv = 'removeclass'+j;
    divtest.innerHTML = 
    `<div class="col-md-6 pl-sm-0 pr-sm-0">
        <div class="gallery_image_area">
            <div class="image_link_area" style="height:250px;">
                <div id="loader-image_${j}" class="loader_image" style="display:none;"><span id="round_loader"></span></div>
                <iframe src="" id="img_${j}" data-id=${j} frameborder="0" height="250" style="width:100%;"></iframe>
            </div>
            <div class="form_group">
              <div class="row">
                  <div class="col-md-12">
                   <input type="text" name="link[]" id="image_link" data-id=${j} class="form-control image_link" placeholder="*link" required>
                  </div>
              </div><!-- row -->
                <div class="row">
                <div class="col-md-12">
                    <input type="text" name="titles[]" id="image_titles" class="form-control" placeholder="Titles" required>
                  </div>
                </div>
                
            </div>
            <div class="input-group-btn img_c_btn">
                <button class="btn btn-danger close_p_btn" type="button" data-id="${j}" onclick="remove_video_fields('${j}');"> <i class="fa fa-times" aria-hidden="true"></i> </button>
            </div>
        </div>
    </div>`;
    
    objTo.appendChild(divtest);
    $('.image_link_btns').hide();
    var numItems = $('.gallery_image_area').length;
   
    if(numItems > 0){
        $('.image_link_btns').show();
     }else{
      $('.image_link_btns').hide();
     }


     $(".image_link").keyup(function(){
      $('#loader-image_'+j+'').fadeIn(500);
      var id = $(this).attr('data-id');
      var url = $(this).val();
      var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
      var match = url.match(regExp);
      var new_url = 'https://www.youtube.com/embed/'
        if (match && match[2].length == 11) {
          var get_url = new_url+match[2];
          $("#img_"+id).attr("src",get_url);
           $('#img_'+j+'').on('load', function(){
              // hide/remove the loading image
              $('#loader-image_'+j+'').fadeOut(500);
            });
        } else {
            $('#url').val('Sorry, Please enter youtube link').css({"color":"red"});
        }
        return false;
    });

      return false;
}

   function remove_video_fields(rid) {
	   $('.removeclass'+rid).remove();
     var numItems = $('.gallery_image_area').length;
     if(numItems==0){
        $('.image_link_btns').hide();
     }else{
      $('.image_link_btns').show();
     }

   }


</script>