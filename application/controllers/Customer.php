<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends MY_Controller {
	public function __construct(){
		parent::__construct();
	}

	public function registration()
	{
		$sorry = !empty(lang("sorry"))?lang("sorry"):"sorry";
		$success = !empty(lang("success"))?lang("success"):"success";
		$reg_success = !empty(lang("registration_successfull"))?lang("registration_successfull"):"Registration successfull";
		$invalid = !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!';

		$shop_id = $_POST['shop_id'];



		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('phone', 'phone', 'trim|required|xss_clean|is_unique[customer_list.phone]',array('is_unique'=>'The phone is already Exists'));
		$this->form_validation->set_rules('password', 'password', 'trim|required|xss_clean|min_length[3]');
		$this->form_validation->set_rules('cpassword', 'Confirm password', 'trim|required|xss_clean|matches[password]');

		if(shop($shop_id)->is_question==1):
			$this->form_validation->set_rules('answer', 'Question Answer', 'trim|required|xss_clean');
		endif;


		if ($this->form_validation->run() == FALSE) {
			$msg = '<div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Sorry ! </strong> '.validation_errors().'
			</div>';
			echo json_encode(array('st' => 0, 'msg'=> $msg,));
		}else{

			$name = $this->input->post('name',true);
			$phone = $this->input->post('phone',true);
			$password = $this->input->post('password',true);
			$country_code = $this->input->post('country_code',true);
			$question_id = $this->input->post('question',true);
			$answer = $this->input->post('answer',true);
			$country_info = $this->admin_m->get_country_info($country_code);

			$q = ['id'=>$question_id, 'answer'=> $answer];
			$data = array(
				'customer_name' => $name,
				'phone' => $phone,
				'country_id' => !empty($country_info)?$country_info->id:0,
				'password' => md5($password),
				'created_at' => d_time(),
				'role' => 'customer',
				'question' => json_encode($q),
			);
			$insert = $this->common_m->insert($data,'customer_list');
			if($insert):


				$country = s_id($data['country_id'],'country');
				if(isset($country->dial_code) && !empty(isset($country->dial_code))):
					$dial_code = ltrim($country->dial_code,'+');
					$phone = $dial_code.$phone;
				else:
					$phone = $phone;
				endif;

				$s_array = array(
					'customer_id' => $insert,
					'customer_name' => $name,
					'customer_phone' => $phone,
					'question' => json_encode($q),
					'role' => 'customer',
					'is_customer' => TRUE,
				);
				$this->session->set_userdata($s_array);
				$info = '
					<div class="flex flex-column">
						<h4 class="bb_1_dashed w_100 pb-5">'.lang('customer_info').'</h4>
						<div class="customerInfoModal">
							<h4 class="pb-7 pt-5 fz-14"><i class="icofont-users-alt-4"></i> '.$name.'</h4>
							<p class="fz-14"><i class="icofont-ui-call"></i> '.$phone.'</p>
						</div>
					</div>
					<div class="customerEdit">
						<a href="#customereditModal" data-toggle="modal"><i class="fa fa-edit"></i></a>
					</div>
				';
				$msg = "<div class='alert alert-success alert-dismissible'>
					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					<strong>{$success} ! </strong> {$reg_success}  <i class='fa fa-smile-o'></i>

					</div>";
				 	$customer_data = $this->load->view('layouts/inc/customer_info_modal',$s_array,TRUE);
					echo json_encode(array('st' => 1, 'msg'=> $msg,'info'=>$info,'address'=>!empty($address)?$address:'','customer_data'=>$customer_data));
					exit();
				else:
					$msg = '<div class="alert alert-danger alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>'.$sorry.'</strong> '.$invalid.' <i class="fa fa-frown-o" ></i>
					</div>';
					echo json_encode(array('st' =>0, 'msg'=> $msg));
			endif;

	}
		//end validation
}

public function customer_login()
{
	$sorry = !empty(lang("sorry"))?lang("sorry"):"sorry";
	$welcome = !empty(lang("welcome"))?lang("welcome"):"Welcome";
	$login_success = !empty(lang("login_success"))?lang("login_success"):"Login successfull";
	$not_approve = !empty(lang("account_not_approve"))?lang("account_not_approve"):"Your account is not approved";
	$invalid = !empty(lang("invalid_login"))?lang("invalid_login"):"Login invalid";

	$this->form_validation->set_rules('phone', 'phone', 'trim|required|xss_clean');
	$this->form_validation->set_rules('password', 'password', 'trim|required|xss_clean');
	if ($this->form_validation->run() == FALSE) {
		$msg = '<div class="alert alert-danger alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Sorry ! </strong> '.validation_errors().'
		</div>';
		echo json_encode(array('st' => 0, 'msg'=> $msg,));
	}else{

		$email = $this->input->post('phone',TRUE);
		$password = $this->input->post('password',TRUE);

		$query = $this->admin_m->check_customer_login($email,$password); //check email / user name and password
		if($query){
			$s_array= array();
			foreach($query as $row):
				$country = s_id($row->country_id,'country');
				if(isset($country->dial_code) && !empty(isset($country->dial_code))):
					$phone = customer_phone($row->phone,$country->dial_code);
				else:
					$phone = $row->phone;
				endif;

				$s_array = array(
					'customer_id' => $row->id,
					'customer_name' => $row->customer_name,
					'customer_phone' => $phone,
					'customer_address' => $row->address,
					'gmap_link' => $row->gmap_link,
					'question' => $row->question,
					'role' =>  $row->role,
					'is_'.$row->role => TRUE,
				);
				$this->session->set_userdata($s_array);
					$msg = '<div class="alert alert-success alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>'.$welcome.' ! </strong> '.$login_success.'  <i class="fa fa-smile-o"></i>

					</div>';
					$info = '
						<div class="flex flex-column">
							<h4 class="bb_1_dashed w_100 pb-5">'.lang('customer_info').' <a href="javascript:;" class="customerRemove ml-20 text-danger"><i class="icofont-close-line "></i></a></h4>
							<div class="customerInfoModal">
								<h4 class="pb-7 pt-5 fz-14"><i class="icofont-users-alt-4"></i> '.$s_array["customer_name"].'</h4>
								<p class="fz-14"><i class="icofont-ui-call"></i> '.$phone.'</p>
							</div>
						</div>
						<div class="customerEdit">
							<a href="#customereditModal" data-toggle="modal"><i class="fa fa-edit"></i></a>
						</div>
					';
					$data = [];
					$data['shop_id'] = isset($row->shop_id)?$row->shop_id:0;
					$data['question_list'] = $this->admin_m->select('question_list');
					$data['customer_data'] = $s_array;
					$customer_data = $this->load->view('layouts/inc/customer_info_modal',$data,TRUE);
					echo json_encode(array('st' => 1, 'msg'=> $msg,'info'=>$info,'address'=>!empty($row->address)?$row->address:'','customer_data'=>$customer_data,'gmap_link'=>!empty($row->gmap_link)?$row->gmap_link:''));
					exit();
			endforeach;

		}else{
			$msg = '<div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>'.$sorry.'</strong> '.$invalid.' <i class="fa fa-frown-o" ></i>
			</div>';
			echo json_encode(array('st' => 0, 'msg'=> $msg));
		}
			//end login_info_check

	}
		//end validation
}


public function update_customer()
{
	$sorry = !empty(lang("sorry"))?lang("sorry"):"sorry";
	$welcome = !empty(lang("welcome"))?lang("welcome"):"Welcome";
	$success = !empty(lang("success_text"))?lang("success_text"):"Save change successfully";
	$phone = $this->input->post('phone',TRUE);

	$this->form_validation->set_rules('customer_name', 'Name', 'trim|required|xss_clean');
	if(isset($_POST['is_update']) && $_POST['is_update']==1):
		if(auth('customer_phone')==$phone ):
			$this->form_validation->set_rules('phone', 'phone', 'trim|required|xss_clean');
		else:
			$this->form_validation->set_rules('phone', 'phone', 'trim|required|xss_clean|is_unique[customer_list.phone]',array('is_unique'=>'The phone is already Exists'));
		endif;

	else:
		$this->form_validation->set_rules('phone', 'phone', 'trim|required|xss_clean');
	endif;



	$this->form_validation->set_rules('customer_address', 'address', 'trim|xss_clean');
	$this->form_validation->set_rules('gmap_link', 'Google Map Link', 'trim|xss_clean');
	if(isset($_POST['is_update']) && $_POST['is_update']==1):

	endif;
	if ($this->form_validation->run() == FALSE) {
		$msg = '<div class="alert alert-danger alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Sorry ! </strong> '.validation_errors().'
		</div>';
		echo json_encode(array('st' => 0, 'msg'=> $msg));
	}else{
		if($_POST){

				$question_id = $this->input->post('question',true);
				$answer = $this->input->post('answer',true);

				$q = ['id'=>$question_id, 'answer'=> $answer];


				$s_array = array(
					'customer_id' => $this->input->post('customer_id',TRUE),
					'customer_name' => $this->input->post('customer_name',TRUE),
					'customer_phone' => $phone,
					'customer_address' => $this->input->post('customer_address',TRUE),
					'gmap_link' => $this->input->post('gmap_link',TRUE),
					'question' => json_encode($q),
					'role' =>  'customer',
					'is_customer' => TRUE,
				);

				$update_data = array(
					'name' => $this->input->post('customer_name',TRUE),
					'phone' => $this->input->post('phone',TRUE),
					'address' => $this->input->post('customer_address',TRUE),
					'gmap_link' => $this->input->post('gmap_link',TRUE),
					'question' => json_encode($q),
				);

				if(isset($_POST['is_update']) && $_POST['is_update']==1):
					$this->admin_m->update($update_data,$this->input->post('customer_id',TRUE),'customer_list');
				endif;

				$this->session->set_userdata($s_array);
					$msg = '<div class="alert alert-success alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>'.$welcome.' ! </strong> '.$success.'  <i class="fa fa-smile-o"></i>

					</div>';
					$info = '
						<div class="flex flex-column">
							<h4 class="bb_1_dashed w_100 pb-5">'.lang('customer_info').' <a href="javascript:;" class="customerRemove ml-20 text-danger"><i class="icofont-close-line "></i></a></h4>
							<div class="customerInfoModal">
								<h4 class="pb-7 pt-5 fz-14"><i class="icofont-users-alt-4"></i> '.$s_array['customer_name'].'</h4>
								<p class="fz-14"><i class="icofont-ui-call"></i> '.$s_array['customer_phone'].'</p>
							</div>
						</div>
						<div class="customerEdit">
							<a href="#customereditModal" data-toggle="modal"><i class="fa fa-edit"></i></a>
						</div>
					';
					$customer_data = $this->load->view('layouts/inc/customer_info_modal',$s_array,TRUE);
					echo json_encode(array('st' => 1, 'msg'=> $msg,'info'=>$info,'address'=>!empty($s_array['customer_address'])?$s_array['customer_address']:'','customer_data'=>$customer_data,'phone'=>$s_array['customer_phone'],'gmap_link'=>$s_array['gmap_link']));
					exit();

		}else{
			$msg = '<div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>'.$sorry.'</strong> '.$invalid.' <i class="fa fa-frown-o" ></i>
			</div>';
			echo json_encode(array('st' => 0, 'msg'=> $msg));
		}
			//end login_info_check

	}
		//end validation
}

 public function profile(){
    	if(empty(auth('is_customer'))){
        	redirect(base_url());
        }
    	$data= [];
    	$data['page_title'] = "Customer Profile";
    	$data['info'] = $this->admin_m->single_select_by_id(auth('customer_id'),'customer_list');
    	$data['countries'] = $this->admin_m->select('countries');
    	$data['question_list'] = $this->admin_m->select('question_list');
        $data['main_content'] = $this->load->view('customer/customer_profile', $data, TRUE);
		$this->load->view('customer/index',$data);

    }

    public function password(){
    	if(empty(auth('is_customer'))){
        	redirect(base_url());
        }
    	$data= [];
    	$data['page_title'] = "Customer Password";
    	$data['info'] = $this->admin_m->single_select_by_id(auth('customer_id'),'customer_list');
        $data['main_content'] = $this->load->view('customer/change_password', $data, TRUE);
		$this->load->view('customer/index',$data);

    }



	public function logout()
	{
        $this->session->unset_userdata('is_customer');
        $sdata = array();
        $sdata['msg'] = 'Successfully logout';
        $this->session->set_userdata($sdata);
        redirect('login','refresh');
    }

    public function order_list(){
    	if(empty(auth('is_customer'))){
        	redirect(base_url());
        }
    	$data= [];
    	$data['page_title'] = "Customer OrderList";
    	$data['info'] = $this->admin_m->single_select_by_id(auth('customer_id'),'customer_list');
    	$data['order_list'] = $this->admin_m->get_customer_order_list(auth('customer_id'));
        $data['main_content'] = $this->load->view('customer/order_list', $data, TRUE);
		$this->load->view('customer/index',$data);

    }


    public function change_status($status,$id){
    	$data = [
    		'status' => $status
    	];

    	$this->admin_m->update($data,$id,'service_order');
    	redirect($_SERVER['HTTP_REFERER']);
    }


    public function add_rating(){

		$this->form_validation->set_rules('customer_rating', 'Rating', 'trim|required|xss_clean');
		$this->form_validation->set_rules('customer_review', 'Comments', 'trim|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			$data = [
				'customer_rating' => $this->input->post('customer_rating'),
				'customer_review' => $this->input->post('customer_review'),
				'rating_time' => d_time(),
			];
			$uid = $this->input->post('uid');
			$insert = $this->admin_m->update_by_uid($data,$uid);

			if($insert):
				$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
				redirect($_SERVER['HTTP_REFERER']);
			else:
				$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
				redirect($_SERVER['HTTP_REFERER']);
			endif;


		}
    }

    public function forgot($type='')
	{
		$data = array();
		$data['page_title'] = "Forgot";
		$data['page'] = "Login";
		$data['type'] = isset($type)?$type:"";
		$data['main_content'] = $this->load->view('frontend/customer/forgot', $data, TRUE);
		$this->load->view('frontend/index',$data);
	}


	public function check_customer_info(){
	is_test();
	$this->form_validation->set_rules('phone', 'Phone', 'trim|required|xss_clean');
	if ($this->form_validation->run() == FALSE) {
		$msg = '<div class="alert alert-danger alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong><i class="fas fa-frown"></i> Sorry! </strong> '.validation_errors().'
		</div>';
		echo json_encode(array('st' => 0, 'msg'=> $msg,));
		exit();
	}else{
		$check_email = $this->admin_m->check_valid_customer_phone(trim($this->input->post('phone',true)));
		if($check_email==FALSE){
			$msg = '<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong><i class="fas fa-frown"></i> Sorry! </strong>Your Phone is not Correct!
			</div>';
			echo json_encode(array('st' => 0, 'msg'=> $msg,));
			exit();
		}else{
			$data = [];

			$question = json_decode($check_email['question']);
			if(empty($question)){
				$msg = '<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong><i class="fas fa-frown"></i> Sorry! </strong>You are not added security questions. Please contact to your store!
				</div>';
				echo json_encode(array('st' => 0, 'msg'=> $msg,));
				exit();
			}else{

				$data['customer_data'] = $check_email;
				$data['question'] = $this->admin_m->single_select_by_id($question->id,'question_list');

				$load_data = $this->load->view('frontend/customer/question_field', $data, TRUE);
				echo json_encode(array('st' => 1, 'data'=> $load_data));
			}
		}

	}
}


public function recovery_password(){
	is_test();
	$this->form_validation->set_rules('answer', 'Question Answer', 'trim|required|xss_clean');
	$this->form_validation->set_rules('password', 'New Password', 'trim|required|xss_clean');
	$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean|matches[password]');
	if ($this->form_validation->run() == FALSE) {
		$msg = '<div class="alert alert-danger alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong><i class="fas fa-frown"></i> Sorry! </strong> '.validation_errors().'
		</div>';
		echo json_encode(array('st' => 0, 'msg'=> $msg,));
		exit();
	}else{
		$id = $_POST['customer_id'];
		$customer_data = $this->admin_m->single_select_by_id($id,'customer_list');
		$question = json_decode($customer_data['question']);
		$answer = $this->input->post('answer',true);
		if(isset($question) && !empty($customer_data)):
			if($answer==$question->answer){
				$data = [
					'password' => md5($_POST['password']),
				];
				$this->common_m->update($data,$id,'customer_list');

				 $msg = '<div class="alert alert-success alert-dismissible">
		 			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong><i class="fas fa-check"></i> Success! </strong> '.lang("password_change_successfully").'
		 		</div>';
	            echo json_encode(array('st' => 1, 'msg'=> $msg,'url'=>base_url('staff-login/customer')));


			}else{
				$msg = '<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong><i class="fas fa-frown"></i> '.lang("sorry").' </strong>'.lang("security_question_ans_not_correct").'
			</div>';
				echo json_encode(array('st' => 0, 'msg'=> $msg,));
			}
		endif;


	}
}



public function subscription_invoice($id){

	$data = array();
	$data['page_title'] = "subscriptions  Invoice";
	$info = $this->admin_m->single_select_by_md5_id($id,'payment_info');
	if(empty($info)){
		redirect($_SERVER['HTTP_REFERER']);
	}

	$data['st'] =(object) settings();
	$data['admin'] = admin();
	$data['u'] = (object) $this->admin_m->get_user_info_by_id($info->user_id);
	$data['invoice_info'] = $this->admin_m->get_subscribed_package($info->user_id,$info->account_type);
	$data['tax'] = isset($data['st']->invoice_config) && isJson($data['st']->invoice_config)?json_decode($data['st']->invoice_config):'';

	$data['main_content'] = $this->load->view('common/subscription_invoice', $data, TRUE);
	$this->load->view('index',$data);
}


}
