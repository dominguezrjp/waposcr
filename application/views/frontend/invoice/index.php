<?php $settings = settings(); ?>
<html>
    <head>
	<link href="<?php echo base_url(); ?>assets/frontend/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="<?= base_url(); ?>assets/frontend/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>public/frontend/css/style.css">
	<link rel="stylesheet" href="<?= base_url(); ?>public/frontend/css/print.css">
    <link href="https://fonts.googleapis.com/css?family=Catamaran|Mitr|Open+Sans|Montserrat|Poppins|Rubik|Roboto+Condensed|Ubuntu&display=swap" rel="stylesheet">
    <title><?= !empty($settings['site_name'])?$settings['site_name']:'Qmenu';?> | <?= $order_info['uid'] ;?></title>
    <link rel="icon" href="<?= !empty($settings['favicon'])?base_url(html_escape($settings['favicon'])):'';?>" type="image/*" sizes="16x16">
    </head>
    <body style="background: #f3f5f9;">
        
		<?php echo $main_content ?>
        <!-- printThis -->
    	<script type="text/javascript" src="<?= base_url();?>assets/frontend/js/jquery-3.4.1.min.js"></script>
    	<script type="text/javascript" src="<?= base_url();?>assets/frontend/html2pdf/html2pdf.bundle.js"></script>

        <a href="<?php echo base_url() ?>" id="base_url"></a>
		<a href="<?php echo $this->security->get_csrf_hash(); ?>" id="csrf_value"></a>

		<script>
			var order="<?= $order_info['uid'];?>";
			$('#printBtn').on("click", function () {
				window.print();  
			});
			$('#exportBtn').on("click", function () {
				var element = document.getElementById('print_area');
				var opt = {
                   // margin:       1,
                   filename:     'order_'+order+'.pdf',
                   image:        { type: 'jpeg', quality: 0.98 },
                   html2canvas:  { scale: 2 },
                   jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
               };

               html2pdf().set(opt).from(element).save();
           });
       </script>


        <script type="text/javascript">
        	var base_url = $('#base_url').attr('href');
        	var csrf_value = $('#csrf_value').attr('href');
        	var username = '<?= $slug;?>';
        	var uid = <?= $order_info['uid'];?>;
        	$(document).on('click','#pos-print',function(){
        		var url = `${base_url}staff/pos_invoice/${username}/${uid}`;
        		$.post(url, {'csrf_test_name': csrf_value }, function(json){
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
    </body>
</html>


