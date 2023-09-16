<?php

if(isset($_POST['purchase_code']) && !isset($_POST['submit'])) {
	require_once 'helper.php';
	
	$form_data = [
		'purchase_code' => $_POST['purchase_code'],
		'site_url' => root_url(),
		'author' => AUTHOR,
		'is_localhost' => isLocalHost(),
	];
	$form_data = json_encode($form_data);
	$ch = curl_init("https://api.thinkncode.net/verify-purchase");  
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                     
	curl_setopt($ch, CURLOPT_POSTFIELDS, $form_data); 

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	curl_setopt($ch, CURLOPT_FAILONERROR, true);
	curl_setopt($ch, CURLOPT_POST, 1);                                          
	$result = curl_exec($ch);
	if (curl_errno($ch)) {
		$error_msg = curl_error($ch);
		echo "<pre>";print_r($error_msg);exit();
	}

	curl_close($ch);
	$result = @json_decode($result);

	if(isset($result->st) && $result->st==1):
		session_start();
		$_SESSION['purchase_code'] = $_POST['purchase_code'];
		$_SESSION['buyer'] = $result->buyer;
		$json['buyer'] = $result->buyer;
		$json['st'] = 1;
		$json['msg'] = "Purchase Code Verified Successfully";
	else:
		session_start();
		$_SESSION['buyer'] = '';
		$_SESSION['account_email'] = '';
		$_SESSION['step'] = 'step_1';
		$_SESSION['st'] = 0;
		$json['st'] = 0;
		$json['msg'] = $result->msg;
		
	endif;


}else {
    $json['st'] = 0;
    $json['msg'] = "Access Denied!";
}




echo json_encode($json);
