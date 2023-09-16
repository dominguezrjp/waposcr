<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends MY_Controller {
	public function __construct(){
		parent::__construct();
	}

	public function login($type)
	{
		$data = array();
		$data['page_title'] = "Login";
		$data['page'] = "Login";
		$data['type'] = $type;
		$data['main_content'] = $this->load->view('frontend/login/staff_login', $data, TRUE);
		$this->load->view('frontend/index',$data);
	}


	public function user_login($type)
	{
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required|xss_clean');		
		$this->form_validation->set_rules('password', 'password', 'trim|required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$msg = '<div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong><i class="fas fa-frown"></i> Sorry ! </strong> '.validation_errors().'
			</div>';
			echo json_encode(array('st' => 0, 'msg'=> $msg,));
		}else{	
				$setting = settings();
				if(isset($setting['is_recaptcha']) && $setting['is_recaptcha']==1):
					if($this->recaptcha()==FALSE){
						$msg = '<div class="alert alert-danger alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong><i class="fas fa-frown"></i> Sorry! </strong> Robot verification Failed
						</div>';
						echo json_encode(array('st' => 0, 'msg'=> $msg));
						exit();
					}
				endif;

				$phone = $this->input->post('phone',TRUE);
				$password = $this->input->post('password',TRUE); //check email / user name and password
				if(preg_match('/^[0-9]+$/', $phone)) {
					if($type=='customer'){
						$is_staff = $this->admin_m->check_customer_login_status($phone,$password);
					}else{
						$is_staff = $this->admin_m->check_staff_login_status($phone,$password);
					}
					
					$isAdmin = FALSE;
				}elseif(filter_var($phone, FILTER_VALIDATE_EMAIL)){
					$is_staff = $this->admin_m->check_staff_login_info($phone,$password);
					$isAdmin = TRUE;
				}else{
					$isAdmin = FALSE;
					$msg = '<div class="alert alert-danger alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong><i class="fas fa-frown"></i> '.lang("sorry").' </strong>'.lang('invalid_login').' <i class="fa fa-frown-o" ></i>
					</div>';
					echo json_encode(array('st' => 0, 'msg'=> $msg));
					exit();
				};
			

				if($is_staff['result']==0):
					$msg = '<div class="alert alert-danger alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong><i class="fas fa-frown"></i> '.lang("sorry").' </strong>'.lang('invalid_login').' <i class="fa fa-frown-o" ></i>
					</div>';
					echo json_encode(array('st' => 0, 'msg'=> $msg));
					exit();
				else:
					$s_array= array();
					foreach($is_staff['result'] as $row):
						if($isAdmin){
							$s_array = array(
								'id' => $row->user_id,
								'username' => $row->username,
								'email' => $row->email,
								'phone' => $row->phone,
								'user_role' => $row->user_role,
								'is_active' => $row->is_active,
								'is_verify' => $row->is_verify,
								'account_type' => $row->account_type,
								'is_login' => TRUE,
								'is_staff' => TRUE,
								'staff_id' => $row->staff_id,
							);
						}else{
							if($type=='customer'){
								$s_array = array(
									'customer_name' => $row->customer_name,
									'email' => $row->email,
									'phone' => $row->phone,
									'is_customer' => TRUE,
									'role' => 'customer',
									'customer_id' => $row->id,
								);
							}else{
								$s_array = array(
									'name' => $row->name,
									'email' => $row->email,
									'phone' => $row->phone,
									'is_'.$row->role => TRUE,
									'role' => $row->role,
									'staff_id' => $row->id,
								);
							}
							
						}

						


						if($row->role == 'customer'):
							$url = base_url('staff/order_list');
						elseif($row->role == 'staff' || $row->role == 'admin_staff'):
							if($row->role=='staff'){
								$this->session->set_userdata(['is_user'=>TRUE,'user_staff'=>TRUE]);
							}
							if($row->role=='admin_staff'){
								$this->session->set_userdata(['is_auth'=>TRUE,'admin_staff'=>TRUE]);
							}
							$url = base_url('admin/dashboard');
						else:
							if($row->status==1):
								$url = base_url('staff/new_order_list');
							else:
								$msg = '<div class="alert alert-warning alert-dismissible">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong><i class="far fa-smile"></i> Sorry ! </strong> Permission denied...

								</div>';
								echo json_encode(array('st' => 0, 'msg'=> $msg));
								exit();
							endif;
						endif;
						
						$this->session->set_userdata($s_array);
						$msg = '<div class="alert alert-success alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong><i class="far fa-smile"></i> Welcome ! </strong> Login successfull, Redirecting...

						</div>';
						echo json_encode(array('st' => 1, 'msg'=> $msg, 'url'=> $url));
					endforeach;
				endif;
		} 
		//end validation 
	}


	public function customer()
	{
		$data = array();
		$data['page_title'] = "Customer Panel";
		$data['page'] = "Customer";
		if(auth('is_customer')==FALSE){
			 redirect('staff-login/customer');
		}
		$data['info'] = $this->admin_m->single_select_by_id(auth('customer_id'),'customer_list');
    	$data['countries'] = $this->admin_m->select('country');
    	$data['question_list'] = $this->admin_m->select('question_list');
		$data['main_content'] = $this->load->view('frontend/customer/customer_profile', $data, TRUE);
		$this->load->view('frontend/customer/index',$data);
	}


    public function password(){
    	if(empty(auth('is_customer'))){
        	redirect(base_url());
        }
    	$data= [];
    	$data['page_title'] = "Customer Password";
    	$data['info'] = $this->admin_m->single_select_by_id(auth('customer_id'),'customer_list');
        $data['main_content'] = $this->load->view('frontend/customer/change_password', $data, TRUE);
		$this->load->view('frontend/customer/index',$data);

    }


    public function update_profile()
	{

		$sorry = !empty(lang("sorry"))?lang("sorry"):"sorry";
		$success = !empty(lang("success"))?lang("success"):"success";
		$reg_success = !empty(lang("registration_successfull"))?lang("registration_successfull"):"Registration successfull";
		$invalid = !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!';


		$phone = $this->input->post('phone',true);
		$active_phone = $this->input->post('active_phone',true);

		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('address', 'Address', 'trim|xss_clean');	
		$this->form_validation->set_rules('question', 'Question', 'trim|xss_clean');	
		$this->form_validation->set_rules('answer', 'Answer', 'trim|xss_clean');	
		if($phone==$active_phone):		
			$this->form_validation->set_rules('phone', 'phone', 'trim|required|xss_clean');	
		else:
			$this->form_validation->set_rules('phone', 'phone', 'trim|required|xss_clean|is_unique[customer_list.phone]',array('is_unique'=>'The phone is already Exists'));
		endif;
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('staff/customer'));
		}else{	

			$name = $this->input->post('name',true);
			$country_id = $this->input->post('country_id',true);
			$question = [
				'id' => $this->input->post('question',true),
				'answer' => $this->input->post('answer',true),
			];
		
			$data = array(
				'customer_name' => $name,
				'phone' => $phone,
				'email' => $this->input->post('email',true),
				'address' => $this->input->post('address',true),
				'gmap_link' => $this->input->post('gmap_link',true),
				'question' => json_encode($question),
				'country_id' => $country_id,
			);
			$insert = $this->common_m->update($data,auth('customer_id'),'customer_list');
			
			
			if($insert):
				$this->upload_profile('customer');
				$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
				redirect(base_url('staff/customer'));
			else:
				$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
				redirect(base_url('staff/customer'));
			endif;

		} 
	}

	
	public function change_password()
	{   is_test();
		
		$this->form_validation->set_rules('password', 'password', 'trim|required|xss_clean|min_length[3]');
		$this->form_validation->set_rules('cpassword', 'Confirm password', 'trim|required|xss_clean|matches[password]');
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('staff/password'));
		}else{	

			$data = array(
				'password' => md5($this->input->post('password',true)),
			);
			$insert = $this->common_m->update($data,auth('customer_id'),'customer_list');
			if($insert):
				$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
				redirect(base_url('staff/customer'));
			else:
				$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
				redirect(base_url('staff/customer'));
			endif;

		} 
	}


	

	public function logout()
	{

        $this->session->unset_userdata('is_customer');
        $this->session->sess_destroy();
        $this->session->set_flashdata('success', 'Successfully logout');
        if(isset($_GET['type']) && $_GET['type']=="customer"):
	        redirect(base_url('staff-login/customer'));
	    elseif(isset($_GET['type']) && $_GET['type']=="delivery"):
	    	redirect(base_url('staff-login/delivery'));
	    endif;
    }

    public function order_list(){
    	if(empty(auth('is_customer'))){
        	redirect(base_url());
        }
    	$data= [];
    	$data['page_title'] = "Customer OrderList";
    	$data['info'] = $this->admin_m->single_select_by_id(auth('customer_id'),'customer_list');
    	$data['order_list'] = $this->admin_m->get_customer_order_list(auth('customer_id'));
        $data['main_content'] = $this->load->view('frontend/customer/order_list', $data, TRUE);
		$this->load->view('frontend/customer/index',$data);

    }

    public function my_invoice($slug=null,$uid=null){
    	$data= [];
    	$id = get_id_by_slug($slug);
		$data['id']=$id;
        if(empty($id) || empty($uid)){
        	redirect(base_url('error-404'));
        }
        $data['shop'] = restaurant($id);
        $data['shop_id'] = $data['shop']->id;
        $data['slug'] = $slug;
    	$data['page_title'] = "Customer OrderList";
    	$data['info'] = $this->admin_m->single_select_by_id(auth('customer_id'),'customer_list');
		$data['order_info'] = $this->admin_m->single_select_by_uid($uid,'order_user_list');
    	$data['item_list'] = $this->admin_m->get_customer_order_item_list($data['shop_id'],$uid);
        $data['main_content'] = $this->load->view('frontend/invoice/my_invoice', $data, TRUE);
		$this->load->view('frontend/invoice/index',$data);

    }
    public function print_invoice($slug=null,$uid=null){
    	$data= [];
    	$id = get_id_by_slug($slug);
    	$data['id']=$id;
    	if(empty($id) || empty($uid)){
    		redirect(base_url('error-404'));
    	}
    	$data['shop'] = restaurant($id);
    	$data['shop_id'] = $data['shop']->id;
    	$data['slug'] = $slug;
    	$data['page_title'] = "Customer OrderList";
    	$data['info'] = $this->admin_m->single_select_by_id(auth('customer_id'),'customer_list');
    	$data['order_info'] = $this->admin_m->single_select_by_uid($uid,'order_user_list');
    	$data['item_list'] = $this->admin_m->get_customer_order_item_list($data['shop_id'],$uid);
    	$data['main_content'] = $this->load->view('frontend/invoice/my_invoice', $data, TRUE);
		$this->load->view('frontend/invoice/index',$data);

    }


    public function pos_invoice($slug=null,$uid=null){
    	$data= [];
    	$id = get_id_by_slug($slug);
    	$data['id']=$id;
    	if(empty($id) || empty($uid)){
    		redirect(base_url('error-404'));
    	}
    	$data['shop'] = restaurant($id);
    	$data['shop_id'] = $data['shop']->id;
    	$data['slug'] = $slug;
    	$data['page_title'] = "Customer OrderList";
    	$data['info'] = $this->admin_m->single_select_by_id(auth('customer_id'),'customer_list');
    	$data['order_info'] = $this->admin_m->single_select_by_uid($uid,'order_user_list');
    	$data['item_list'] = $this->admin_m->get_customer_order_item_list($data['shop_id'],$uid);
    	$load = $this->load->view('frontend/invoice/pos_invoice', $data, true);
		echo json_encode(['st'=>1,'result'=>$load]);
    }


    public function change_status($status,$id){
    	$data = [
    		'status' => $status
    	];

    	$this->admin_m->update($data,$id,'service_order');
    	redirect($_SERVER['HTTP_REFERER']);
    }



	
    /*----------------------------------------------
     DELIVERY STAFF AREA
    ----------------------------------------------*/
    public function delivery()
	{
		
		$data = array();
		$data['page_title'] = "Delivery Panel";
		$data['page'] = "Delivery";
		if(auth('is_delivery')==FALSE){
			 redirect('staff-login/delivery');
		}
		$data['info'] = $this->admin_m->single_select_by_id(auth('staff_id'),'staff_list');
    	$data['countries'] = $this->admin_m->select('country');
		$data['main_content'] = $this->load->view('frontend/delivery/profile', $data, TRUE);
		$this->load->view('frontend/customer/index',$data);
	}

	public function account()
	{
		
		$data = array();
		$data['page_title'] = "Delivery Account";
		$data['page'] = "Delivery";
		if(auth('is_delivery')==FALSE){
			 redirect('staff-login/delivery');
		}
		$data['info'] = $this->admin_m->single_select_by_id(auth('staff_id'),'staff_list');
		$data['order_list'] = $this->admin_m->get_all_accepted_delivery_order_list(auth('staff_id'));
		$data['main_content'] = $this->load->view('frontend/delivery/account', $data, TRUE);
		$this->load->view('frontend/customer/index',$data);
	}


	public function report()
	{
		
		$data = array();
		$data['page_title'] = "Delivery Report";
		$data['page'] = "Delivery";
		if(auth('is_delivery')==FALSE){
			 redirect('staff-login/delivery');
		}
		$data['info'] = $this->admin_m->single_select_by_id(auth('staff_id'),'staff_list');
		$data['order_list'] = $this->statistics_m->get_dboy_statistics(auth('staff_id'));
		$data['dboy_date'] = $this->statistics_m->get_dboy_date(auth('staff_id'));
		$data['main_content'] = $this->load->view('frontend/delivery/statistics', $data, TRUE);
		$this->load->view('frontend/customer/index',$data);
	}


    public function update_delivery_profile()
	{

		is_test();
		$sorry = !empty(lang("sorry"))?lang("sorry"):"sorry";
		$success = !empty(lang("success"))?lang("success"):"success";
		$reg_success = !empty(lang("registration_successfull"))?lang("registration_successfull"):"Registration successfull";
		$invalid = !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!';


		$phone = $this->input->post('phone',true);
		$active_phone = $this->input->post('active_phone',true);

		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');	
		if($phone==$active_phone):		
			$this->form_validation->set_rules('phone', 'phone', 'trim|required|xss_clean');	
		else:
			$this->form_validation->set_rules('phone', 'phone', 'trim|required|xss_clean|is_unique[staff_list.phone]',array('is_unique'=>'The phone is already Exists'));
		endif;
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('staff/delivery'));
		}else{	

			$name = $this->input->post('name',true);
			$country_id = $this->input->post('country_id',true);
			$data = array(
				'name' => $name,
				'phone' => $phone,
				'email' => $this->input->post('email',true),
				'country_id' => $country_id,
			);
			$insert = $this->common_m->update($data,auth('staff_id'),'staff_list');
			if($insert):
				$this->upload_profile('dboy');
				$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
				redirect(base_url('staff/delivery'));
			else:
				$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
				redirect(base_url('staff/delivery'));
			endif;

		} 
	}	


    public function change_delivery_password()
	{
		is_test();
		
		$this->form_validation->set_rules('password', 'password', 'trim|required|xss_clean|min_length[3]');
		$this->form_validation->set_rules('cpassword', 'Confirm password', 'trim|required|xss_clean|matches[password]');
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('staff/password'));
		}else{	

			$data = array(
				'password' => md5($this->input->post('password',true)),
			);
			$insert = $this->common_m->update($data,auth('staff_id'),'staff_list');
			if($insert):
				$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
				redirect(base_url('staff/delivery'));
			else:
				$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
				redirect(base_url('staff/delivery'));
			endif;

		} 
	}

	public function delivery_password(){
    	if(empty(auth('is_delivery'))){
        	redirect(base_url());
        }
    	$data= [];
    	$data['page_title'] = "Delivery Password";
    	$data['info'] = $this->admin_m->single_select_by_id(auth('staff_id'),'staff_list');
        $data['main_content'] = $this->load->view('frontend/delivery/change_password', $data, TRUE);
		$this->load->view('frontend/customer/index',$data);

    }

    public function new_order_list($type="new"){
    	if(empty(auth('is_delivery'))){
        	redirect(base_url());
        }
    	$data= [];
    	$data['info'] = $this->admin_m->single_select_by_id(auth('staff_id'),'staff_list');
    	if($type=="new"){
    		$data['page_title'] = "New OrderList";
    		$status = 0;
    		$is_picked = 0;
    		$data['order_list'] = $this->admin_m->get_all_delivery_order_list($data['info']['user_id'],$status,$is_picked);
    	}elseif($type=="accepted"){
    		$data['page_title'] = "Accepted OrderList";
    		$status = 1;
    		$is_picked = 0;
    		$data['order_list'] = $this->admin_m->get_all_active_delivery_order_list(auth('staff_id'),$status,$is_picked);
    	}elseif($type=="picked"){
    		$data['page_title'] = "Picked OrderList";
    		$status = 2;
    		$is_picked = 1;
    		$data['order_list'] = $this->admin_m->get_all_active_delivery_order_list(auth('staff_id'),$status,$is_picked);
    	}
    	
    	$data['page'] = "Delivery OrderList";
    	
        $data['main_content'] = $this->load->view('frontend/delivery/order_list', $data, TRUE);
		$this->load->view('frontend/customer/index',$data);

    }

    public function get_order_list($type="new"){
    	if(empty(auth('is_delivery'))){
        	redirect(base_url());
        }
    	$data= [];
    	$data['info'] = $this->admin_m->single_select_by_id(auth('staff_id'),'staff_list');
    	if($type=="new"){
    		$data['page_title'] = "New OrderList";
    		$status = 0;
    		$is_picked = 0;
    		$data['order_list'] = $this->admin_m->get_all_delivery_order_list($data['info']['user_id'],$status,$is_picked);
    	}elseif($type=="accepted"){
    		$data['page_title'] = "Accepted OrderList";
    		$status = 1;
    		$is_picked = 0;
    		$data['order_list'] = $this->admin_m->get_all_active_delivery_order_list(auth('staff_id'),$status,$is_picked);
    	}elseif($type=="picked"){
    		$data['page_title'] = "Picked OrderList";
    		$status = 2;
    		$is_picked = 1;
    		$data['order_list'] = $this->admin_m->get_all_active_delivery_order_list(auth('staff_id'),$status,$is_picked);
    	}
    	
    	$data['page'] = "Delivery OrderList";
    	$load_data = $this->load->view('frontend/delivery/order_thumb', $data, TRUE);
        echo json_encode(['st'=>1,'load_data'=>$load_data]);

    }

    public function order_details($slug=null,$uid=null){
    	$data= [];
    	$id = get_id_by_slug($slug);
    	$data['id']=$id;
    	if(empty($id) || empty($uid) || empty(auth('is_delivery'))){
    		redirect(base_url('error-404'));
    	}
    	$data['shop'] = restaurant($id);
    	$data['shop_id'] = $data['shop']->id;
    	$data['slug'] = $slug;
    	$data['page_title'] = "Customer OrderList";
    	$data['info'] = $this->admin_m->single_select_by_id(auth('staff_id'),'staff_list');
    	$data['order_info'] = $this->admin_m->single_select_by_uid($uid,'order_user_list');
    	$data['item_list'] = $this->admin_m->get_customer_order_item_list($data['shop_id'],$uid);
    	$data['main_content'] = $this->load->view('frontend/delivery/order_details', $data, TRUE);
		$this->load->view('frontend/customer/index',$data);
    }

    public function accept_order($uid=null,$dboy_id=null){
    	$data= [];
    	if(empty($dboy_id) || empty($uid) || empty(auth('is_delivery'))){
    		redirect(base_url('error-404'));
    	}
    	$data = array(
    		'dboy_id' =>$dboy_id,
    		'dboy_accept_time' => d_time(),
    		'dboy_status' => 1,
    		'is_db_accept' => 1,
    	);
    	$this->admin_m->update_by_uid($data,$uid);
    	$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
    	redirect($_SERVER['HTTP_REFERER']);
    }

    public function picked_order($uid=null,$dboy_id=null){
    	$data= [];
    	if(empty($dboy_id) || empty($uid) || empty(auth('is_delivery'))){
    		redirect(base_url('error-404'));
    	}
    	$data = array(
    		'dboy_picked_time' => d_time(),
    		'dboy_status' => 2,
    		'is_picked' => 1,
    	);
    	$this->admin_m->update_by_uid_dboy_id($data,$uid,$dboy_id);
    	$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
    	redirect($_SERVER['HTTP_REFERER']);
    }

    public function completed_order($uid=null,$dboy_id=null){
    	$data= [];
    	if(empty($dboy_id) || empty($uid) || empty(auth('is_delivery'))){
    		redirect(base_url('error-404'));
    	}
    	$data = array(
    		'dboy_completed_time' => d_time(),
    		'dboy_status' => 3,
    		'is_db_completed' => 1,
    	);
    	$this->admin_m->update_by_uid_dboy_id($data,$uid,$dboy_id);
    	$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
    	redirect($_SERVER['HTTP_REFERER']);
    }

    public function upload_profile($type){
    	is_test();
    	$data = array();
    	if (!empty($_FILES['file']['name'])) {
    		$up_load = $this->upload_m->upload(250);
    		if($up_load['st']==1):
    			foreach ($up_load['data'] as $key => $value) {
    				$data = array(
    					'images' => $value['image'],
    					'thumb' => $value['thumb'],
    				);
					if($type=='customer'){
						$this->admin_m->update(array('thumb' => $value['thumb'],'images' => $value['image']),auth('customer_id'),'customer_list');
					}else{
						$this->admin_m->update(array('thumb' => $value['thumb'],'images' => $value['image']),auth('staff_id'),'staff_list');
					}
    				
    			}
    			 return true;
    		else:
    			// $this->session->set_flashdata('error', $up_load['data']);
    			return false;
    		endif;

    	}else{
    		$this->session->set_flashdata('error', 'Please select an image');
    	}

    }
	
    public function track_order($slug=null,$uid=null){
    	$data= [];
    	$id = get_id_by_slug($slug);
		$data['id']=$id;
        if(empty($id) || empty($uid)){
        	redirect(base_url('error-404'));
        }
        $data['shop'] = restaurant($id);
        $data['shop_id'] = $data['shop']->id;
        $data['slug'] = $slug;
    	$data['page_title'] = "Customer OrderList";
    	$data['info'] = $this->admin_m->single_select_by_id(auth('staff_id'),'staff_list');
		$data['order_info'] = $this->admin_m->single_select_by_uid($uid,'order_user_list');
        $data['main_content'] = $this->load->view('frontend/customer/track_status', $data, TRUE);
		$this->load->view('frontend/customer/index',$data);

    }
    public function order_item_list($uid,$shop_id){
    	$data = [];
    	$data['order_list'] = $this->common_m->order_item_details_by_order_id($uid,$shop_id);
    	$load_data = $this->load->view('frontend/customer/customer_item_list', $data, true);
    	echo json_encode(['st'=>1,'load_data'=>$load_data]);
    }
    public function recaptcha(){
		$settings =  settings();
		$recaptchaResponse = trim($this->input->post('g-recaptcha-response'));
	    $userIp=$this->input->ip_address();
	    $secret = $this->settings['recaptcha']->secret_key;

	    $url="https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$recaptchaResponse."&remoteip=".$userIp;

	    $ch = curl_init(); 
	    curl_setopt($ch, CURLOPT_URL, $url); 
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	    $output = curl_exec($ch); 
	    curl_close($ch);      
	     
	    $status= json_decode($output, true);
	    if($status['success']){
	    	return TRUE;
	    }else{
	    	return FALSE;
	    }
	}


}