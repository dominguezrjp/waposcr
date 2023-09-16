<?php 
	session_start();
	if(isset($_POST)){
		$_SESSION['purchase_code'] = $_POST['purchase_code'];
		$_SESSION['buyer'] = $_POST['username'];
		$_SESSION['step'] = 'step_2';
		$_SESSION['account_email'] = $_POST['account_email'];
		$_SESSION['LAST_ACTIVITY'] = time();
		$json['step'] = 'step_2';
		$json['st'] = 1;

	}else{
		$json['st'] = 0;
		$json['step'] = 'step_1';
	}

	echo json_encode($json);


 ?>