<div class="row justify-content-center">
	<div class="col-md-4 col-md-offset-4 text-center">

		<div class="card">
			<div class="card-body">
				<div class="successOrder" id="prints">
					<div class="confirmMsgArea">
						<div class="mb-10">
							<i class="icofont-check-circled fa-4x c_green"></i>
						</div>
						<h5> <?= !empty(lang('order_id'))?lang('order_id'):'Order id' ;?>: #<span class="order_id"><?= $order_info['uid'];?></span></h5>
						<div class="userDetails mt-5">
							<h4><?= !empty(lang('customer_name'))?lang('customer_name'):"customer name"; ?>: <?= $order_info['name'];?></h4>
							<p><?= lang('phone'); ?>: <?= @$order_info['phone'];?></p>
						</div>
						<div class="qr_link">
							<img src="<?= base_url($order_info['qr_link'])?>" alt="" id="qr_link">
							<a href="<?= base_url($order_info['qr_link'])?>" download target="blank" data-link="" class="qrDownloadBtn" id="downloadLink" data-placement="top" data-toggle="tooltip" title="Download Qr for Quick access your order"><i class="fa fa-download"></i> <?= !empty(lang('download'))?lang('download'):'download' ;?></a>

						</div>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<a href="<?= base_url('invoice/'.auth('username').'/'.$order_info['uid']); ?>" target="blank" class="btn btn-success-light"><i class="fa fa-file-pdf-o"></i> <?= lang('invoice');?></a>
				<a href="<?= base_url("admin/pos");?>" class="btn btn-secondary"><i class="fa fa-plus"></i> <?= lang('new_order');?></a>
			</div>
		</div>










<script src="<?php echo base_url()?>assets/admin/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url()?>assets/admin/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<input type="hidden" class="base_url" value="<?= base_url(); ?>">

<script type="text/javascript">

	var base_url = $('.base_url').val();
	var csrf_value = $('#csrf_value').attr('href');
	var username = '<?= $shop_info['username'];?>';
	var uid = <?= $order_id;?>;
	$(document).on('click','.print3',function(){

   var url = `${base_url}admin/pos/print_bill/${username}/${uid}`;
  	$.get(url, {'csrf_test_name': csrf_value }, function(json){
  	console.log(json);
    if(json.st == 1){
     	  var myWindow=window.open('','','min-width=400px,min-height=500px');
          myWindow.document.write(json.result);
          myWindow.document.close();
          myWindow.focus();
          myWindow.print(); 
          // myWindow.close(); 
    }

  },'json');

 return false;

  });

</script>

<script type="text/javascript" src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
 <script>
 	$(document).on('click','.printInvoice',function () {
            printJS({
                maxWidth: 440, // the width of your paper
                printable: 'print', // the id
                type: 'html',
                css: 'public/frontend/css/print.css', // your css
                targetStyles: ['*']
            });
        });
 </script>
  

