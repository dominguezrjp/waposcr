<style>
	.updateModal .modal-body {
	    min-height: 250px;
	    display: flex;
	    align-items: center;
	    justify-content: center;
	    flex-direction: column;
	}
	.updatingArea img, .showOnprocess img {
	    width: 120px;
	    margin-top: 20px;
	}

	.updateModal h4, .updateModal h5, .updateModal h1{
		font-weight: bold;
	}
	.updateModal{
		font-weight: normal;
	}
	h4.finishUpdate {
	    height: 70px;
	    width: 70px;
	    background: #4AA96C;
	    color: #fff;
	    font-size: 47px;
	    border-radius: 100%;
	    line-height: 70px;
	    margin: auto;
	    box-shadow: 0 0 5px #ddd;
	    margin-bottom: 20px;
	}
</style>
<div class="modal fade" id="updateModal" data-backdrop='static'>
	<div class="modal-dialog">
		<div class="modal-content updateModal">
			<?php include 'initial_page.php'; ?>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#updateModal').modal('show');

		setTimeout( () => {
			$('.updatingArea').slideUp();
			$('.finishedArea, .modal-footer').slideDown();
		},2000);
	});

	$(document).on('click','.startUpdate',function(){
		$('.showOnprocess').slideDown();
		$('.finishedArea').slideUp();

	    $version = `<?= settings()['version'];?>`;
	    $update = $(this).data('update');
	    var url = `<?= base_url();?>admin/system_update/start_update/${$update}`;
	    $(this).prop('disabled',true);
	    $.get(url, {'csrf_test_name': `<?= $this->security->get_csrf_hash(); ?>` }, function(json){
	      if(json.st == 1){
	        $('.updateModal').html(json.load_data);
	        $('.orderStatus').prop('disabled',false);
	        setTimeout( () => {
				$('.showOnprocess').slideUp();
				$('.updatingArea').slideUp();
				$('.finishedArea, .modal-footer, .showAfterSuccess').slideDown();
			},2000);

	      }
	    },'json');
	    return false;
  });
</script>