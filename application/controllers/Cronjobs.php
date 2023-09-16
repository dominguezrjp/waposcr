<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cronjobs extends MY_Controller {

	public function check_expired_users()
	{
		$all_users = $this->admin_m->get_all_active_users();
		if(count($all_users) > 0){
			foreach ($all_users as $users) {
				$day_left = day_left(d_time(),$users['end_date']);
				
				if($day_left['day_left'] == 5):
					$this->email_m->expire_reminder_mail($users['username'],$day_left['date']);

				elseif($day_left['day_left'] == 2):
					$this->email_m->expire_reminder_mail($users['username'],$day_left['date']);

				elseif($day_left['day_left'] == 1):
					$this->email_m->expire_reminder_mail($users['username'],$day_left['date']);

				elseif($day_left['day_left'] == 0):
					$data = array('is_expired' =>1);
					$update = $this->admin_m->update($data,$users['id'],'users');
					if($update){
						$this->email_m->account_expire_mail($users['username']);
					}
				endif;
			}
		}
		
	}

	public function text_email_verification(){
		$data = [
			'username' => 'phplime',
			'email' => 'phplime.envato@gmail.com',
			'package_name'=> 'basic',
			'price'=>'50',
			'expire_date'=>'10-10-2023',
		];
		$package = ['package_name'=>'basic','price'=>'50.00'];
		$txn_id = '1234LKIF55LO';
		$password = '1234';
		$send = $this->email_m->account_expire_mail($data['username'],10);
   		 $send = $this->offline_payment_request_mail($data,$package,$txn_id);
		echo "<pre>";print_r($send);exit();
	}
	

}
