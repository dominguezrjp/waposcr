<link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css">
<style>
@media print {
	#top .logo {
    height: 100px;
    width: 100px;
    background-size: 100px 100px;
}

.info {
    display: block;
    margin-top: 20px;
    margin-left: 5px;
}
#invoice-POS table tr {
    border-bottom: 3px dotted #ddd!important;
}
table {
    width: 100%;
    border-collapse: collapse;
}
#invoice-POS table tr {
    border-bottom: 3px dotted #ddd!important;
}
#total tr {
    background-color: #ddd;
}
}
#top .logo {
    height: 100px;
    width: 100px;
    background-size: 100px 100px;
}
.info {
    display: block;
    margin-top: 20px;
    margin-left: 5px;
    margin-bottom: 10px;
}
#invoice-POS table tr {
    border-bottom: 3px dotted #ddd!important;
}
table {
    width: 100%;
    border-collapse: collapse;
}
#invoice-POS table tr {
    border-bottom: 3px dotted #ddd!important;
}
#total tr {
    background-color: #ddd;
}

h6{
	padding: 3px 0;
	margin: 0;
}
</style>
<div class="" style="width: 350px;">
	<div id="print">
	    <h6 class="text-right">Date : 2021-08-02</h6>
	    <center id="top">
	        <div class="logo "><img src=""  style="height:100px;width: 100px;"/></div>
	        <div class="info"><h2>Stocky</h2></div>
	    </center>
	    <div class="info">
	        <h6>Address : 3618 Abia Martin Drive</h6>
	        <h6>Email : admin@example.com</h6>
	        <h6>Phone : 6315996770</h6>
	        <h6>Customer : walk-in-customer</h6>
	    </div>
	    <table class="mt-3 ml-2 table-md">
	        <thead>
	            <tr style="background:#ddd;">
	                <th scope="col">Product</th>
	                <th scope="col">Qty</th>
	                <th scope="col">Subtotal</th>
	            </tr>
	        </thead>
	        <tbody>
	            <tr style="margin-bottom: 3px; border-bottom: 1px dashed #ddd; padding: 3px 0;">
	                <td>Limon</td>
	                <td>1.00</td>
	                <td>20.00</td>
	            </tr>

	            <tr style="margin-bottom: 3px; border-bottom: 1px dashed #ddd; padding: 3px 0;">
	                <td>Limon</td>
	                <td>1.00</td>
	                <td>20.00</td>
	            </tr>
	            <tr>
	                <th></th>
	                <th>Tax</th>
	                <td>0.00 (0 %)</td>
	            </tr>
	            <tr>
	                <th></th>
	                <th>Discount</th>
	                <td>0.00</td>
	            </tr>
	            <tr>
	                <th></th>
	                <th>Shipping</th>
	                <td>0.00</td>
	            </tr>
	        </tbody>
	    </table>
	    <table id="total" class="mt-2 ml-2">
	        <tbody>
	            <tr>
	                <th class="p-1 w-75">Grand Total</th>
	                <th class="p-1 w-25">USD 20.00</th>
	            </tr>
	        </tbody>
	    </table>
	</div>
</div>

<script>
	window.print();
</script>