<div id="tableOrders">
	<?php include 'inc/table_orders.php';?>
</div>


<script type="text/javascript">

	function table_order(){
		var url = `<?= base_url();?>admin/notification/table_order/`;
		$.get(url, {'csrf_test_name': `<?= $this->security->get_csrf_hash(); ?>` }, function(json){
			if (json.st == 1) {
				$('#tableOrders').html(json.load_data);
			}
		},'json');
	}


$(document).ready(function() {
    setInterval(function(){
     	table_order();
    }, 10000);

});


</script> 