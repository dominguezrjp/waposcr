<?php header("Content-type: text/css; charset: UTF-8"); ?>

<?php for($i=0;$i<100;$i++){ ?>
	.pt-<?= $i;?>{
		padding-top:<?= $i;?>px!important;
	}

	.pb-<?= $i;?>{
		padding-bottom:<?= $i;?>px!important;
	}

	.pl-<?= $i;?>{
		padding-left:<?= $i;?>px!important;
	}

	.pr-<?= $i;?>{
		padding-right:<?= $i;?>px!important;
	}

	.mt-<?= $i;?>{
		margin-top:<?= $i;?>px!important;
	}

	.mb-<?= $i;?>{
		margin-bottom:<?= $i;?>px!important;
	}

	.ml-<?= $i;?>{
		margin-left:<?= $i;?>px!important;
	}

	.mr-<?= $i;?>{
		margin-right:<?= $i;?>px!important;
	}

	.p-<?= $i;?>{
		padding:<?= $i;?>px!important;
	}

	.m-<?= $i;?>{
		margin:<?= $i;?>px!important;
	}

	.fz-<?= $i;?>{
		font-size:<?= $i;?>px!important;
	}

	.ht-<?= $i;?>{
		height:<?= $i;?>px!important;
	}

	.wd-<?= $i;?>{
		width:<?= $i;?>px!important;
	}

	.min-w-<?= $i;?>{
		min-width:<?= $i;?>px!important;
	}

	.py-<?= $i;?>{
		padding-top:<?= $i;?>px!important;
		padding-bottom:<?= $i;?>px!important;
	}

	.px-<?= $i;?>{
		padding-left:<?= $i;?>px!important;
		padding-right:<?= $i;?>px!important;
	}
	
<?php } ?>