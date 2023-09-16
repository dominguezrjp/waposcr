<html>
    <head>
        <style>
        	.pos_page{
			  position: absolute;
			  top: 0;
			  right: 0;
			  width: 100%;
			  min-height: 100vh;
			}

			#invoice-POS h1, 
			#invoice-POS h2,  
			#invoice-POS h3, 
			#invoice-POS h4, 
			#invoice-POS h5, 
			#invoice-POS h6{
			  color: #05070b;
			  font-weight: bolder;
			}
			#pos .pos-detail{
			  height: 42vh!important;
			}
			#pos .pos-detail .table-responsive{
			  max-height: 40vh!important;
			  height: 40vh!important;
			  border-bottom: none!important;
			}

			#pos .pos-detail .table-responsive tr{
			  font-size: 14px
			}

			#pos .card-order{
			  min-height: 100%;
			}

			#pos .card-order .main-header{
			  position: relative;
			}

			#pos .grandtotal{
			  text-align: center;
			  height: 40px;
			  background-color: #7ec8ca;
			  margin-bottom: 20px;
			  font-size: 1.2rem;
			  font-weight: 800;
			  padding: 5px;
			}
			#pos .list-grid .list-item .list-thumb img {
			  width: 100%!important;
			  height: 100px!important;
			  max-height: 100px!important;
			  object-fit: cover;
			}

			#pos .list-grid{
			  height: 100%;
			  min-height: 100%;
			  overflow: scroll;
			}

			#pos .brand-Active{
			border: 2px solid;
			}

			.centred{
			text-align: center;
			align-content: center;
			}



			@media (min-width: 1024px){
			  #pos .list-grid{
			    height: 100vh;
			    min-height: 100vh;
			    overflow: scroll;
			  };

			}

			#pos .card.o-hidden {
			  width: 19%;;
			  max-width: 19%;;
			  min-width: 130px;
			}
			#pos .input-customer{
			  position: relative;
			  display: flex;
			  flex-wrap: unset;
			  align-items: stretch;
			  width: 100%;
			}

			#pos .card.o-hidden:hover {
			  cursor: pointer;
			  border: 1px solid;
			}

			* {
			  font-size: 14px;
			  line-height: 20px;
			  font-family: 'Ubuntu', sans-serif;
			  text-transform: capitalize;

			}

			td,
			th,
			tr,
			table {
			    border-collapse: collapse;
			}
			tr {border-bottom: 2px dotted #ddd;}

			table {width: 100%;}
			tfoot tr th:first-child {text-align: left;}

			/* .table-bordered th, .table-bordered td {
			  border: 1px solid #D1D5DB;
			} */
			.total{
			  font-weight: bold;
			  font-size: 12px;
			  /* text-transform: uppercase; */
			  /* height: 36px; */
			}


			.change{
			  font-size: 10px;
			  margin-top: 25px;
			}
			.centered {
			    text-align: center;
			    align-content: center;
			}

			#invoice-POS{
			  max-width:400px;
			  margin:0px auto;
			}

			@media print { 

			  .change{
			    font-size: 10px!important;
			  }

			  * {
			    font-size: 12px;
			    line-height: 18px;   
			  }

			  body{
			    margin: 0.5cm;
			    margin-bottom:1.6cm;
			  }

			  td,th {padding: 1px 0;}

			  /* .table_data tr{
			    border-bottom: 2px dotted #05070b;
			  } */

			  #invoice-POS table tr{
			    border-bottom: 2px dotted #05070b;
			  }
			 

			  @page {
			    margin: 0;
			    }
			   
			  tbody::after {
			    content: '';
			    display: block;
			    page-break-after: always;
			    page-break-inside: always;
			    page-break-before: avoid; 

			  }
			}
			  

			#top .logo{
			    height: 100px;
			    width: 100px;
			    background-size: 100px 100px;
			}

			.info{
			  margin-bottom: 20px;
			}

			.info>h2{
			  text-align: center;
			  font-size: 1.5rem;

			}
			.title{
			  float: right;
			}
			.title p{text-align: right;} 
			table{
			  width: 100%;
			  border-collapse: collapse;
			}
			#invoice-POS table tr{
			  border-bottom: 2px dotted #05070b;
			}

			.tabletitle{
			  font-size: .5em;
			  background: #EEE;
			}
			#legalcopy{
			  margin-top: 5mm;
			}
			#legalcopy p{
			text-align: center;
			}
			#bar{
			  text-align: center;
			}

			.quantity {
			  max-width: 95px;
			  width: 95px;
			}  

			.quantity input {
			  text-align: center;
			      border: none;
			}

			.quantity .form-control:focus {
			    color: #374151;
			    background-color:unset;
			    border-color: #e1d5fd;
			    outline: 0;
			    box-shadow: unset;
			}

			.quantity span {
			  padding: 8px;
			}
			tr.spacer {
			    padding: 10px!important;
			    border-collapse: separate!important;
			    border-spacing: 0 1em!important;
			    border: 6px solid #fff;
			    border-top: 2px dotted;
			}
        </style>
    </head>
    <body>
        <div style="max-width: 400px; margin: 0px auto;">
            <div class="info">
                <h2 class="text-center"><?= !empty($shop->name)?$shop->name:$shop->username;?></h2>
                <p>
                    Date : <?= full_date(d_time());?>
                    <br />
                    Address : <?= !empty($shop->address)?$shop->address:"";?>
                    <br />
                    Email : <?= !empty($shop->email)?$shop->email:"";?>
                    <br />
                    Phone : <?= !empty($shop->phone)?$shop->phone:"";?>
                    <br />
                    Customer : <?= $order_info['name'];?>
                </p>
            </div>
            <table class="table_data">
                <tbody>
                	<?php $qty=0;$sub_total=0;$total_price = 0;$net_total=0; ?>
                	<?php foreach ($items as $key => $row): ?>
	                    <tr style="margin-bottom: 5px;">
	                        <td colspan="3">
	                            <span>
	                                <?= $row['name'];?>
	                                <br />
	                                <?= $row['qty'];?> x <?= $row['item_price'];?>
	                            </span>
	                        </td>
	                        <td style="text-align: right; vertical-align: bottom;"><?= html_escape($row['sub_total']) ;?>  <?= restaurant($id)->icon ;?></td>
	                   
	                    </tr>
	                    <tr class="spacer"><td></td><td></td></tr>
	                    <?php 
	                    $qty = $qty+ $row['qty'];
	                    $sub_total = $sub_total+ $row['sub_total'];
	                    $net_total = $net_total+ $row['sub_total'];
	                    $grand_total = ($net_total+$order_info['delivery_charge'])-$order_info['discount'];

	                    
	                    ?>
                	<?php endforeach ?>
                    <tr class="spacer"><td></td><td></td></tr>
                    <tr style="margin-top: 10px;">
                        <td colspan="3" class="">Sub Total</td>
                        <td class="total" style="text-align: right;"><?= $sub_total ;?> <?= restaurant($id)->icon ;?></td>
                    </tr>
                    <tr style="margin-top: 10px;">
                        <td colspan="3" class="">shipping</td>
                        <td class="total" style="text-align: right;"><?= $order_info['delivery_charge'];?> <?= restaurant($id)->icon ;?></td>
                    </tr>
                    <tr style="margin-top: 10px;">
                        <td colspan="3" class="">Discount</td>
                        <td class="total" style="text-align: right;"><?= $order_info['discount'];?> <?= restaurant($id)->icon ;?></td>
                    </tr>
                    <tr style="margin-top: 10px; border-color: #05070b;">
                        <td colspan="3" class="total">Grand Total</td>
                        <td class="total" style="text-align: right;"><?= $grand_total ;?> <?= restaurant($id)->icon ;?></td>
                    </tr>
                </tbody>
            </table>
            <table class="change mt-3" style="font-size: 10px;">
                <thead>
                    <tr style="background: rgb(238, 238, 238);">
                        <th colspan="1" style="text-align: left;">Paid By:</th>
                        <th colspan="2" style="text-align: center;">Amount:</th>
                        <th colspan="1" style="text-align: right;">Change:</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="1" style="text-align: left;">Cash</td>
                        <td colspan="2" style="text-align: center;"><?= $grand_total;?></td>
                        <td colspan="1" style="text-align: right;"><?= lang('paid'); ?></td>
                    </tr>
                </tbody>
            </table>
            <div id="legalcopy" class="ml-2">
                <p class="legal"><strong>Thank you for shopping with us . Please come again</strong></p>
                
            </div>
        </div>
        <script>
	window.print();
</script>
    </body>
</html>
