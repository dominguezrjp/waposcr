<?php header("Content-type: text/css; charset: UTF-8"); ?>
<?php 
	if(isset($_GET['name']) && !empty($_GET['name'])){
		$font_name = $_GET['name'];
	}
?>
	body, a, span, p{
		font-family: '<?= $font_name ;?>',sans-serif!important;
	}

<?php for($i=1;$i<=6; $i++):?>
	h<?= $i ;?>{
		font-family: '<?= $font_name ;?>',sans-serif!important;
	}
<?php endfor; ?>