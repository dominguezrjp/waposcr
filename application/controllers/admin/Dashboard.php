<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function __construct(){
		parent::__construct();
		is_login();
		$this->get_expired_users();
		$this->per_page = 12;

	}

	public function index()
	{

		if($this->is_redirect==1 && $this->auth['user_role'] ==1){
			redirect($this->redirect_url);
		}

		if($this->is_restautant==1 && $this->auth['user_role'] ==0){
			redirect($this->restaurant_url);
		}

		if(settings()['is_update']==1):
			redirect('admin/dashboard/update');
		endif;
		$data = array();
		$data['page_title'] = "Dashboard";
		$data['page'] = "Auth";
        $data['all_user'] = $this->admin_m->get_new_users(0);
        $data['user_type']=$this->admin_m->get_total_user_by_account_type();
        $data['package']=$this->admin_m->get_user_package_details();
        $data['active_package'] = $this->admin_m->get_users_actived_package();
         if($this->db->table_exists('staff_activities')):
	        $data['staff_list'] = $this->admin_m->get_mstaff_activities_list();
	    endif;
        if(!empty(auth('is_staff')) && auth('user_role')==1):

			$data['activities_list'] = $this->admin_m->get_my_activities_list(auth('staff_id'));
        	$data['staff_info'] = $this->admin_m->get_staff_info_by_id(auth('staff_id'));
			$data['main_content'] = $this->load->view('backend/dashboard/staff_dashboard', $data, TRUE);
	    else:
	    	if(auth('user_role')==0):
	    		$data['daily_statistics'] = $this->statistics_m->get_daily_statistics($_ENV['ID'],0);
	    	endif;
			$data['main_content'] = $this->load->view('backend/dashboard/dashboard', $data, TRUE);
	    endif;

		$this->load->view('backend/index',$data);
	}


	

	public function update(){
		$data = array();
		$data['page_title'] = "Update";
		$data['page'] = "Auth";
		$data['main_content'] = $this->load->view('backend/dashboard/check_valid', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function total_users()
	{
		check_valid_auth();
		$data = array();
		$data['page_title'] = "Total Users";
		$data['page'] = "Users";
		$data['data']=FALSE;

		$config = [];
		$this->load->library('pagination');
		$per_page = $this->per_page;

		$page = $this->input->get('page');
		if (empty($page)) {
			$page = 0;
		}

		if ($page != 0) {
			$page = $page-1;
		}
		$offset = ceil($page * $per_page);

		$total = $this->admin_m->get_all_user(0,0,0,$is_total=1);
		$config['base_url'] = base_url('admin/dashboard/total_users');
		$config['total_rows'] = $total;
		$config['per_page'] =  $per_page;
		$this->pagination->initialize($config);

		$data['all_user'] = $this->admin_m->get_all_user(0,$per_page,$offset,0);
		$data['packages'] = $this->admin_m->select_with_status('packages');
		$data['main_content'] = $this->load->view('backend/dashboard/total_user', $data, TRUE);
		$this->load->view('backend/index',$data);
	}


	

	/**
	  ** registration and email verify status changer
	**/

	public function setting_status($type,$value)
	{
		is_test();
		if($value==0){
			$data_value = 1;
		}else{
			$data_value = 0;
		}

		$data = array(
			$type => $data_value,
		);

		$this->admin_m->update($data,1,'settings');
		echo json_encode(array('st' => 1,'value'=>$data_value));
	}


	public function features_toggle($id,$value)
	{
		is_test();
		if($value==0){
			$data_value = 1;
		}else{
			$data_value = 0;
		}

		$data = array(
			'status' => $data_value,
		);

		$this->admin_m->update_feature($data,$id,'users_features');
		echo json_encode(array('st' => 1,'value'=>$data_value));
	}

	
	public function change_content_status($id,$status,$table)
	{
		is_test();
		if($status==1){
			$data_status =0;
		}else{
			$data_status =1;
		}
		$data = array(
			'status' => $data_status,
		);

		$this->admin_m->update($data,$id,$table);
		echo json_encode(array('st' => 1,'value'=>$data_status));
	}


	/**
	  *** site pricing
	**/ 
	public function pricing()
	{

		check_valid_auth();
		$data = array();
		$data['page_title'] = "Packages";
        $data['page'] = "Dashboard";
        $data['data'] = FALSE;
        $data['packages']=$this->admin_m->select('packages');
        $data['features']=$this->admin_m->select('features');
		$data['main_content'] = $this->load->view('backend/packages/add_pricing', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	


	/**
	  ***  Packages
	**/ 
	public function packages()
	{
		check_valid_auth();
		$data = array();
		$data['page_title'] = "Packages";
        $data['page'] = "Dashboard";
        $data['data'] = FALSE;
        $data['type_data'] = FALSE;
        $data['packages']=$this->admin_m->select('packages');
        $data['features']=$this->admin_m->select('features');
		$data['main_content'] = $this->load->view('backend/packages/packages', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	/**
	  ** edit features type
	**/
	public function edit_packages($id)
	{
		check_valid_auth();
		$data = array();
		$data['page_title'] = "Packages";
        $data['page'] = "Dashboard";
        $data['data'] = FALSE;
        $data['type_data'] = $this->admin_m->single_select_by_id($id,'packages');
        $data['packages']=$this->admin_m->select('packages');
        $data['features']=$this->admin_m->select('features');
		$data['main_content'] = $this->load->view('backend/packages/add_pricing', $data, TRUE);
		$this->load->view('backend/index',$data);
	}


	/**
	  *** add add_packages
	**/ 
		public function add_packages(){
			is_test();
			check_valid_auth();
			$id = $this->input->post('id',TRUE);
			$type = $this->input->post('package_type',TRUE);
			$is_trial = $this->input->post('is_trial',TRUE);

			$this->form_validation->set_rules('package_name', lang('package_name'), 'required|trim|xss_clean|max_length[15]');
			$this->form_validation->set_rules('slug', 'Slug','required|trim|xss_clean|max_length[15]|callback_english_check');
			$this->form_validation->set_rules('package_type', 'Package Types', 'trim|xss_clean|required');
			$this->form_validation->set_rules('order_limit', 'Order Limit', 'trim|xss_clean|required|callback_number_check');
			$this->form_validation->set_rules('item_limit', 'Item Limit', 'trim|xss_clean|required|callback_number_check');
			$this->form_validation->set_rules('feature_id[]', 'Features', 'trim|xss_clean|required');
			$this->form_validation->set_rules('custom_fields[]', 'Features', 'trim|xss_clean');

			if($type=='free' || $type=='trial' || $type=='weekly' || $type=='fifteen'){
				$this->form_validation->set_rules('price', 'Price', 'trim|xss_clean');
				$price = 0;
			}else{
				$this->form_validation->set_rules('price', 'Price', 'required|xss_clean|trim|callback_number_check');
				$price = $this->input->post('price',TRUE);
			}
			
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			}else{	
				if($type=='trial' || $type=='weekly' || $type=='fifteen'){
					if($is_trial==0):
						if(isset($id) && $id !=0):
							$account_type = $this->admin_m->get_trail_package_id($id);
							if(!empty($account_type)){
								$this->session->set_flashdata('error', 'Sorry! Trial package already exists. You can create only one Trial package');
								redirect(base_url('admin/dashboard/packages'));
								exit();
							};
						else:
							$account_type = $this->admin_m->get_trail_package_id(0);
							if(!empty($account_type)){
								$this->session->set_flashdata('error', 'Sorry! You can create only one Trial package');
								redirect(base_url('admin/dashboard/packages'));
								exit();
							};

						endif;
					endif;
				};

				$order_limit = $this->input->post('order_limit',TRUE);
				$item_limit = $this->input->post('item_limit',TRUE);
				$custom_fields = $this->input->post('custom_fields',TRUE);
				$duration = $this->input->post('duration',TRUE);
				$duration_period = $this->input->post('duration_period',TRUE);
				$data = array(
					'package_name' => $this->input->post('package_name',TRUE),
					'slug' => str_slug($this->input->post('slug',TRUE)),
					'price' => $price,
					'package_type' => $type,
					'order_limit' => isset($order_limit) && !empty($order_limit)?$order_limit:0,
					'item_limit' => isset($item_limit) && !empty($item_limit)?$item_limit:0,
					'custom_fields_config' => json_encode($custom_fields),
					'duration' => isset($duration)?$duration:'',
					'duration_period' => isset($duration_period)?$duration_period:'',
					'created_at' => d_time(),
				);
				
				if($id != 0):
					$insert = $this->admin_m->update($data,$id,'packages');
				else:
					$insert = $this->admin_m->insert($data,'packages');
				endif;

				if($insert){
					$feature_id = $this->input->post('feature_id',TRUE);
					if(isset($feature_id)){
						if($this->input->post('id')!=0){
							$this->admin_m->delete_pricing($this->input->post('id'),'pricing');
						}
						foreach ($feature_id as $value):
							$data = array(
								'package_id' => $insert,
								'feature_id' => $value,
								'created_at' => d_time(),
							);
							$add_features_id = $this->admin_m->insert($data,'pricing');
						endforeach;
					}

					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/dashboard/packages'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/dashboard/packages'));
				}	
		}
	}


	public function number_check($val)
    {
        if (!preg_match('/^[0-9]+(\\.[0-9]+)?$/', $val)) {
            $this->form_validation->set_message('number_check', 'The {field} field must be a number or decimal.');
            return FALSE;
        } else {
            return TRUE;
        }
    }



//check english string for username
public function english_check($string){
	if (preg_match('/[^A-Za-z0-9  -]/', $string))  {
		    //string contains only letters from the English alphabet
		$this->form_validation->set_message('english_check', 'The {field} field contains only letters from the English alphabet.');
		return FALSE;
	}else{
		return true;
	}
}

	/**
	  *** site features
	**/ 
	public function features()
	{
		check_valid_auth();
		$data = array();
		$data['page_title'] = "Features";
        $data['page'] = "Dashboard";
        $data['data'] = FALSE;
        $data['features']=$this->admin_m->select('features');
		$data['main_content'] = $this->load->view('backend/packages/features', $data, TRUE);
		$this->load->view('backend/index',$data);
	}


	/**
	  ** Edit features
	**/
	public function edit_features($id)
	{
		$data = array();
		$data['page_title'] = "Features";
        $data['page'] = "Dashboard";
        $data['data'] = $this->admin_m->single_select_by_id($id,'features');
        $data['features']=$this->admin_m->select('features');
		$data['main_content'] = $this->load->view('backend/packages/features', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	/**
	  *** add features
	**/ 
	public function add_features(){
		is_test();
		check_valid_auth();
		$this->form_validation->set_rules('features', 'Feature name', 'required|trim|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/dashboard/features'));
			}else{	
				$data = array(
					'features' => $this->input->post('features',TRUE),
					'created_at' => d_time(),
				);
				$id = $this->input->post('id',TRUE);
				if($id != 0):
					$insert = $this->admin_m->update($data,$id,'features');
				else:
					$insert = $this->admin_m->insert($data,'features');
					$this->session->set_flashdata('error', 'You can only Update features name');
					redirect(base_url('admin/dashboard/features'));
				endif;

				if($insert){
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/dashboard/features'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/dashboard/features'));
				}	
		}
	}



/*----------------------------------------------
	Order Types
----------------------------------------------*/
public function order_types()
{
	check_valid_auth();
	$data = array();
	$data['page_title'] = "Order Types";
    $data['page'] = "Dashboard";
    $data['data'] = FALSE;
    $data['order_types']=$this->admin_m->select('order_types');
	$data['main_content'] = $this->load->view('backend/packages/order_types', $data, TRUE);
	$this->load->view('backend/index',$data);
}


public function add_order_types(){
	is_test();
	check_valid_auth();
	$this->form_validation->set_rules('name[]', 'Types name', 'required|trim|xss_clean');
	if ($this->form_validation->run() == FALSE) {
		$this->session->set_flashdata('error', validation_errors());
		redirect(base_url('admin/dashboard/order_types'));
	}else{	

		foreach ($_POST['name'] as $key => $value) {
		   $data = array(
				'name' => $value,
			); 
		   $id = $_POST['id'][$key];
		   $insert = $this->admin_m->update($data,$id,'order_types');
		}

		if($insert){
			$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
			redirect(base_url('admin/dashboard/order_types'));
		}else{
			$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
			redirect(base_url('admin/dashboard/order_types'));
		}	
	}
}



	

	public function item_delete($id,$table)
	{
		is_test();
		$del=$this->admin_m->delete($id,$table);
		if($del){
			$this->session->set_flashdata('success', 'Item Deleted');
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			$this->session->set_flashdata('error', 'Somthing worng. Error!!');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	public function delete_user($id)
	{
		is_test();
		$del=$this->admin_m->delete($id,'users');
		$del=$this->admin_m->delete_all_by_user_id($id,'users_active_features');
		$del=$this->admin_m->delete_all_by_user_id($id,'user_settings');
		$del=$this->admin_m->delete_all_by_user_id($id,'restaurant_list');
		if($del){
			$this->session->set_flashdata('success', 'Item Deleted');
			redirect(base_url('admin/dashboard/total_users'));
		}else{
			$this->session->set_flashdata('error', 'Somthing worng. Error!!');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	/**===== Upload images dashboard ====**/
	public function upload_img($id,$table){
		if (!empty($_FILES['file']['name'])) {
	 		$up_load = $this->upload_m->upload(400);
		 	if($up_load['st']==1):
			 	foreach ($up_load['data'] as $key => $value) {
			 		$data = array(
			 			'images' => $value['image'],
			 			'thumb' => $value['thumb'],
			 		);
			 		$this->admin_m->update($data,$id,$table);
			 	}
			 	return true;
			 else:
			 	$this->session->set_flashdata('success', $up_load['data']['error']);
			 endif;
		 	
		}
	}


	/**
	  **change  package with offline payment of by admin 
	**/ 
	public function change_packege_by_admin($id)
	{
		is_test();
		check_valid_auth();
		$user_info = get_all_user_info_id($id);
		$this->session->set_tempdata('temp_data', ['old_package_id'=>$user_info['account_type']], 600);

		$package_id =  $this->input->post('package_id',TRUE);
		$package_info = get_package_info_by_id($package_id);
		$data = array(
			'account_type' => $this->input->post('package_id',TRUE),
			'start_date'=>d_time(),
			'end_date'=>add_year($package_info['package_type'],$package_info['duration'],$package_info['duration_period']),
			'is_payment'=>1,
			'is_expired'=>0,
			'staff_id'=>!empty(auth('staff_id'))?auth('staff_id'):0,
		);	
		$edit = $this->admin_m->update($data,$id,'users');
		if($edit){
			$this->admin_m->update_by_user_id(['is_running'=>0],$id,'payment_info');

			$random_number = random_string('alnum',16);

            $data = array(
                'user_id' => $user_info['user_id'],
                'account_type' => $package_info['id'],
                'price' => $package_info['price'],
                'txn_id' => $random_number,
                'payment_type' => 0,
                'currency_code' => get_currency('currency_code'),
                'status' => 'Completed',
                'created_at' => d_time(),
                'expire_date' => add_year($package_info['package_type']),
                'is_running' => 1,
            );
            $insert = $this->admin_m->insert($data,'payment_info');

            if(!empty(auth('is_staff')) && !empty(auth('staff_id'))):
            	$staffData = [
            		'staff_id' => auth('staff_id'),
            		'user_id' => $user_info['user_id'],
            		'auth_id' => 0,
            		'active_date' => d_time(),
            		'is_renewal' => 1,
            		'is_change_package' => 1,
            		'package_id' => $package_info['id'],
            		'role' => 'admin_staff',
            		'is_new' => 0,
            		'price' => $package_info['price'],
            		'old_package_id' => !empty(temp('old_package_id'))?temp('old_package_id'):0,
            	];
            	$this->admin_m->insert($staffData,'staff_activities');
            endif;



            if($insert){
            	if(isset($_POST['is_mail']) && $_POST['is_mail']==1):
	            	$this->email_m->send_payment_verified_email($data,'Author');
	            endif;
	            $this->session->unset_userdata('temp_data');
            	$this->session->set_flashdata('success', 'Package Change Successfully');
				redirect($_SERVER['HTTP_REFERER']);
            }
		}else{
			$this->session->set_flashdata('error', 'Somthing worng. Error!!');
			redirect($_SERVER['HTTP_REFERER']);
		}
		
	}

	/**
	  ** email verify by admin (offline verify)
	**/
	public function verify_by_admin($username,$status){
		is_test();
		check_valid_auth();
		$u_info = get_all_user_info_slug($username);
		$package_info = get_package_info_by_id($u_info['account_type']);
		
		if($u_info['package_type'] == 'trial' ||$u_info['package_type'] == 'weekly' || $u_info['package_type'] == 'fifteen' || $u_info['account_type']==0){

		$data = array('is_verify'=>$status,'verify_time'=>d_time(),'is_payment'=>1,'is_expired'=>0,'is_request'=>0,'start_date'=>d_time(),'end_date'=>add_year($package_info['package_type'],$package_info['duration'],$package_info['duration_period']));

		}elseif($u_info['package_type']=='free'){
			$data = array('is_verify'=>$status,'verify_time'=>d_time(),'is_payment'=>1,'is_expired'=>0,'is_request'=>0,'start_date'=>d_time(),'end_date'=>'');
		}else{
			$data = array('is_verify'=>$status,'verify_time'=>d_time());
		};
		
		if(isset($data['is_payment']) && $data['is_payment']==1):
			$this->default_m->add_payment($u_info,$package_info,0);
		endif;

		$this->admin_m->update_by_username($data, $username,'users');
		$this->session->set_flashdata('verify', ' Account verify successfully');
		redirect($_SERVER['HTTP_REFERER']);
	}



	/**
	  ** offline_payment by admin 
	**/
	public function payment_by_admin($username,$status){
		is_test();
		check_valid_auth();
		$user_info = get_all_user_info_slug($username);
		$package_info = get_package_info_by_id($user_info['account_type']);

		$data = array('is_payment'=>1,'is_expired'=>0,'is_request'=>0,'start_date'=>d_time(),'end_date'=>add_year($package_info['package_type'],$package_info['duration'],$package_info['duration_period']),'is_request'=>0);

		$edit = $this->admin_m->update_by_username($data, $username,'users'); //update payment/verify status

		if($edit):
			//add payment info
            $insert = $this->default_m->add_payment($user_info,$package_info,0);


            if($insert){
            	if($status==0):
	            	$off_data = array(
	            		'approve_time' => d_time(),
	            		'status'=>1,
	            	);
	            	$this->admin_m->update_by_user_id($off_data,$user_info['user_id'],'offline_payment');
            	endif;
            }
            $this->session->set_flashdata('success', $username.' \'s Payment verified successfull');
			redirect($_SERVER['HTTP_REFERER']);
        else:
			$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
			redirect($_SERVER['HTTP_REFERER']);
          endif;  

		
	}



	/**
	  ** offline_payment by admin 
	**/
	public function accept_payment_form_offline($username,$status){
		is_test();
		$user_info = get_all_user_info_slug($username);
		$package_info = get_package_info_by_id($user_info['account_type']);

		$data = array('is_payment'=>1,'is_expired'=>0,'is_request'=>0,'start_date'=>d_time(),'end_date'=>add_year($package_info['package_type'],$package_info['duration'],$package_info['duration_period']),'is_request'=>0);

		$edit = $this->admin_m->update_by_username($data, $username,'users'); //update payment/verify status

		if($edit):
			
            if($status==0):
	        	$off_data = array(
	        		'approve_time' => d_time(),
	        		'status'=>1,
	        	);
	        	$this->admin_m->update_by_user_id($off_data,$user_info['user_id'],'offline_payment');
	    	endif;
            $this->session->set_flashdata('success', $username.' \'s Payment verified successfull');
			redirect($_SERVER['HTTP_REFERER']);
        else:
			$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
			redirect($_SERVER['HTTP_REFERER']);
          endif;  

		
	}


	public function transactions()
	{
		$data = array();
		$data['page_title'] = "Transactions";
	    $data['page'] = "Admin Activities";
	    $data['transactions']=$this->admin_m->get_user_payment_history();
		$data['main_content'] = $this->load->view('backend/admin_activities/transactions', $data, TRUE);
		$this->load->view('backend/index',$data);
	}


	public function offline_payments()
	{
		$data = array();
		$data['page_title'] = "Offline Payments";
	    $data['page'] = "Admin Activities";
	    $data['offline']=$this->admin_m->select_desc('offline_payment');
		$data['main_content'] = $this->load->view('backend/admin_activities/offline_payments', $data, TRUE);
		$this->load->view('backend/index',$data);
	}


	

	public function terms(){
        $data = array();
        $data['page_title'] = "Terms & Conditions";
        $data['page'] = "Pages";
        $data['data']=$this->admin_m->single_select('terms');
        $data['main_content'] = $this->load->view('backend/admin_activities/terms', $data, TRUE);
        $this->load->view('backend/index', $data);
    }

    /**
	  *** add terms
	**/ 
	public function add_terms(){
		is_test();
		$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
		$this->form_validation->set_rules('details', 'Details', 'required|trim|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/dashboard/terms'));
			}else{	
				$data = array(
					'title' => $this->input->post('title',TRUE),
					'details' => $this->input->post('details',TRUE),
					'status' => $this->input->post('status',TRUE),
				);
				$id = $this->input->post('id');
				if($id==0){
					$insert = $this->admin_m->insert($data,'terms');
				}else{
					$insert = $this->admin_m->update($data,$id,'terms');
				}

				if($insert){
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/dashboard/terms'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/dashboard/terms'));
				}	
		}
	}

	public function privacy(){
        $data = array();
        $data['page_title'] = "Cookies & Privacy";
        $data['page'] = "Pages";
        $data['data']=$this->admin_m->single_select('privacy');
        $data['main_content'] = $this->load->view('backend/admin_activities/privacy', $data, TRUE);
        $this->load->view('backend/index', $data);
    }

    /**
	  *** add terms
	**/ 
	public function add_privacy(){
		is_test();
		$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
		$this->form_validation->set_rules('details', 'Details', 'required|trim|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/dashboard/privacy'));
			}else{	
				$data = array(
					'title' => $this->input->post('title',TRUE),
					'details' => $this->input->post('details',TRUE),
					'status' => $this->input->post('status',TRUE),
				);
				$id = $this->input->post('id');
				if($id==0){
					$insert = $this->admin_m->insert($data,'privacy');
				}else{
					$insert = $this->admin_m->update($data,$id,'privacy');
				}

				if($insert){
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/dashboard/privacy'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/dashboard/privacy'));
				}	
		}
	}

	public function pages(){
        $data = array();
        $data['page_title'] = "Create Pages";
        $data['page'] = "Pages";
        $data['data']=false;
        $data['pages']=$this->admin_m->select('pages');
        $data['main_content'] = $this->load->view('backend/admin_activities/create_pages', $data, TRUE);
        $this->load->view('backend/index', $data);
    }

    public function edit_page($id){
        $data = array();
        $data['page_title'] = "Create Pages";
        $data['page'] = "Pages";
        $data['data']=$this->admin_m->single_select_by_id($id,'pages');
        $data['pages']=$this->admin_m->select('pages');
        $data['main_content'] = $this->load->view('backend/admin_activities/create_pages', $data, TRUE);
        $this->load->view('backend/index', $data);
    }



    public function create_page(){
    	is_test();
    	$id = $this->input->post('id');
		$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
		if($id==0):
		$this->form_validation->set_rules('slug', 'Slug', 'trim|required|xss_clean|is_unique[pages.slug]|callback_english_check');
		else:
			$this->form_validation->set_rules('slug', 'Slug', 'trim|required|xss_clean|callback_english_check');
		endif;
		$this->form_validation->set_rules('details', 'Details', 'required|trim|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/dashboard/pages'));
			}else{	
				$data = array(
					'title' => $this->input->post('title',TRUE),
					'slug' => str_slug($this->input->post('slug',TRUE)),
					'details' => $this->input->post('details',TRUE),
					'status' => $this->input->post('status',TRUE),
					'created_at' => d_time(),
				);
				
				if($id==0){
					$insert = $this->admin_m->insert($data,'pages');
				}else{
					$insert = $this->admin_m->update($data,$id,'pages');
				}

				if($insert){
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/dashboard/pages'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/dashboard/pages'));
				}	
		}
	}


	public function email(){
        $data = array();
        $data['page_title'] = "Email";
        $data['page'] = "Pages";
        $data['data']=false;
        $data['pages']=$this->admin_m->select('email_template');
        $data['main_content'] = $this->load->view('backend/admin_activities/email', $data, TRUE);
        $this->load->view('backend/index', $data);
    }


	 public function add_email(){
	 	is_test();
    	$id = $this->input->post('id');
		$this->form_validation->set_rules('type', 'type', 'trim|required|xss_clean');
		$this->form_validation->set_rules('msg', 'Details', 'required|trim|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/dashboard/email'));
			}else{	
				$data = array(
					'msg' => json_encode($this->input->post('msg')),
					'created_at' => d_time(),
				);

				
				if($id==0){
					$insert = $this->admin_m->insert($data,'email_template');
				}else{
					$insert = $this->admin_m->update($data,$id,'email_template');
				}

				if($insert){
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/dashboard/email'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/dashboard/email'));
				}	
		}
	}


	/**
	  **change user status by admin 
	**/ 
	public function change_status($id,$is_active)
	{

		is_test();
		if($is_active==0):
			$data = array('is_active' => 1,);
		else:
			$data = array('is_active' => 0,);
		endif;	
		$edit = $this->admin_m->update($data,$id,'users');
		if($edit){
			if($is_active==0):
				$this->session->set_flashdata('success', 'User Account is Active Now');
			else:
				$this->session->set_flashdata('success', 'User Account is  Deactive Now ');
			endif;
			redirect($_SERVER['HTTP_REFERER']);
			}else{
			$this->session->set_flashdata('error', 'Somthing worng. Error!!');
			redirect($_SERVER['HTTP_REFERER']);
		}
		
	}


	/**
	  *** add new user by admin
	**/ 
	public function add_user()
	{
		check_valid_auth();
		$data = array();
		$data['page_title'] = "Add User";
        $data['page'] = "Users";
        $data['features'] = $this->admin_m->select_with_status('packages');
		$data['main_content'] = $this->load->view('backend/admin_activities/add_user', $data, TRUE);
		$this->load->view('backend/index',$data);
	}


/**
  *** Add user 
**/ 
	public function new_user(){
		is_test();
		check_valid_auth();
		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|is_unique[users.username]|callback_english_check',array(
            'is_unique'=> 'This '.$this->input->post('username').' already exists.'
        ));		
		
		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email|is_unique[users.email]',array(
            'is_unique'=> 'This '.$this->input->post('email').' already exists.'
        ));	

		$this->form_validation->set_rules('package', 'Package', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/dashboard/add_user'));
		}else{	

			if($this->input->post('is_password')==1):
				$password = $this->input->post('password');
			else:
				$password = '1234';
			endif;
			$package = $this->admin_m->get_package_info_by_id($this->input->post('package'));
			$data = array(
				'username' => str_slug($this->input->post('username')),
				'email' => $this->input->post('email'),
				'account_type' => $this->input->post('package'),
				'password' => md5($password),
				'start_date' => d_time(),
				'verify_time' => d_time(),
				'created_at' => d_time(),
				'end_date' => add_year($package['package_type'],$package['duration'],$package['duration_period']),
				'is_active' => 1,
				'is_verify' => 1,
				'is_payment' => 1,
				'staff_id' => !empty(auth('staff_id'))?auth('staff_id'):auth('id'),
			);
			$insert = $this->admin_m->insert($data,'users');
			if($insert){
				$shop_data = array(
					'user_id' => $insert,
					'shop_id' => $insert.random_string('alnum',6),
					'username' => $this->input->post('username'),
					'created_at' => d_time(),
				);
				$this->admin_m->insert($shop_data,'restaurant_list');

				$this->admin_m->insert(['user_id' => $insert],'user_settings');


				if(!empty(auth('is_staff')) && !empty(auth('staff_id'))):
					$staffData = [
						'staff_id' => auth('staff_id'),
						'user_id' => $insert,
						'auth_id' => 0,
						'active_date' => d_time(),
						'is_renewal' => 0,
						'is_change_package' => 0,
						'package_id' => $package['id'],
						'role' => 'admin_staff',
						'is_new' => 1,
						'price' => $package['price'],
					];
					$this->admin_m->insert($staffData,'staff_activities');
				endif;

				// insert Features
				$this->insert_features($insert);
				
				// $this->email_m->new_user_create_mail_by_author($data,$package,$password);
			
				$this->session->set_flashdata('success', 'New account created successfully');
				redirect(base_url('admin/dashboard/total_users'));
			}else{
				$this->session->set_flashdata('error', 'Somethings were wrong');
				redirect(base_url('admin/dashboard/add_users'));
			}
		}
	}



	public function insert_features($user_id){
		is_test();
		$fetaures = $this->admin_m->select('features');
		foreach ($fetaures as $key => $row) {
			$data =  array(
				'feature_id' => $row['id'],
				'user_id' => $user_id,
				'status' => 1
			);
			$this->admin_m->insert($data,'users_active_features');
		}
		return true;
	}


	public function reset_password($id){
		is_test();
		$data =  array(
				'password' => md5(1234),
			);
		$update = $this->admin_m->update($data,$id,'users');
		if($update){
			echo json_encode(array('st'=>1));
		}else{
			echo json_encode(array('st'=>0));
		}
	}

// check expired users	
public function get_expired_users()
{
	$all_users = $this->admin_m->get_all_users(d_time());
	if(count($all_users) > 0){
		foreach ($all_users as $users) {
			$data = array('is_expired' =>1);
			$this->admin_m->update($data,$users['id'],'users');
			$this->admin_m->update_by_user_id(['is_running'=>0],$u_info['user_id'],'payment_info');
		}
	}
	
}

public function change_domain()
{
	check_valid_auth();
	$data = array();
	$data['page_title'] = "Change Domain";
	$data['page'] = "Change Domain";
	$data['settings'] = $this->admin_m->single_select('settings');
	$data['main_content'] = $this->load->view('backend/admin_activities/change_domain', $data, TRUE);
	$this->load->view('backend/index',$data);
}

public function upgrade()
{
	check_valid_auth();
	$data = array();
	$data['page_title'] = "Upgrade";
	$data['page'] = "Upgrade";
	$data['settings'] = $this->admin_m->single_select('settings');
	$data['main_content'] = $this->load->view('backend/admin_activities/upgrade', $data, TRUE);
	$this->load->view('backend/index',$data);
}

public function apply_upgrade(){
	$this->form_validation->set_rules('purchase_code', 'Purchases Code', 'trim|required|xss_clean');
	$this->form_validation->set_rules('site_id', 'Site Id Code', 'trim|required|xss_clean');
	$this->form_validation->set_rules('old_code', 'Old Code', 'trim|required|xss_clean');
	if ($this->form_validation->run() == FALSE) {
		$this->session->set_flashdata('error', validation_errors());
		redirect(base_url('admin/dashboard/upgrade'));
		}else{	
			
			$purchase_code = $this->input->post('purchase_code',true);
			$old_code = $this->input->post('old_code',true);
			$site_id = $this->input->post('site_id',true);
			$site_url = $this->input->post('site_url',true);

			$site_data = array(
				'purchase_code' => $purchase_code,
				'old_code' => $old_code,
				'site_id' => $site_id,
				'site_url' => $site_url,
			);


			$check_valid = $this->check_vaild($site_data);
			if($check_valid->st ==1):
				$data = array(
					'supported_until' => $check_valid->supported_until,
					'active_code' => $check_valid->active_code,
					'purchase_code' =>$purchase_code,
					'site_info' =>$check_valid->li,
					'site_url' => SITE_LINK,
					'active_key' => $check_valid->active_key,
					'purchase_date' => $check_valid->sold_at,
					'license_code' => $check_valid->li_code,
					'license_name' => $check_valid->license_name,
					'created_at' =>d_time(),
				);
				$insert = $this->admin_m->update_setting($data,$site_id,'settings');
				if($insert):
					$this->version_changes_m->createVersion($data['purchase_code'],settings()['version'],$data['license_code']);
					redirect(base_url('admin/dashboard'));
				else:
					$this->session->set_flashdata('error', 'Somethings were wrong');
					redirect(base_url('admin/dashboard/upgrade'));
				endif;
			else:
				$this->session->set_flashdata('error', 'Invalid Purchases Code / PUrchase code already used');
				redirect(base_url('admin/dashboard/upgrade'));
			endif;
				
	}
}


	public function check_vaild($data){
		// check_valid_purchases
		$form_data = array(
			'purchase_code' => $data['purchase_code'],
			'old_code' => $data['old_code'],
			'site_id' => $data['site_id'],
			'site_url' => $data['site_url'],
			'is_localhost' => isLocalHost(),
			'author' => 'codetrick',
			'ip' => $this->version_changes_m->getIpAddress(),
		);

		$form_data = json_encode($form_data);
		$ch = curl_init(URL."upgrade-license/");  
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $form_data);                   
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
		curl_setopt($ch, CURLOPT_POST, 1);                                    
		$result = curl_exec($ch);

		curl_close($ch);
		return $result = json_decode($result);
	}



	public function active_site(){
		$this->form_validation->set_rules('code', 'Purchase code', 'trim|required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			$this->update();
			}else{	
				$code = $this->input->post('code',true);
				$site_id = $this->input->post('site_id',true);
				$check_valid = $this->check_vaild_code($code,$site_id);
				if($check_valid->st ==1):
					$data = array(
						'supported_until' => $check_valid->supported_until,
						'active_code' => $check_valid->active_code,
						'purchase_code' =>$code,
						'site_url' => SITE_LINK,
						'active_key' => $check_valid->active_key,
						'is_update' => 0,
						'license_name' => $check_valid->license_name,
						'site_info' => $check_valid->li,
						'license_code' => $check_valid->li_code,
						'purchase_date' => $check_valid->sold_at,
						'created_at' =>d_time(),
					);
					$insert = $this->admin_m->update_setting($data,$site_id,'settings');
					$this->session->set_flashdata('success','Thank you! Your site is active now');
					redirect(base_url('admin/dashboard/'));
				else:
					$this->session->set_flashdata('error', $check_valid->msg);
					redirect(base_url('admin/dashboard/active_site'));
				endif;	
		}
	}

	public function check_vaild_code($code,$site_id){
		// check_valid_purchases
			$form_data = array(
				'purchase_code'  => $code,
				'site_id'  => $site_id,
				'site_url'  => SITE_LINK,
				'author'  => 'codetrick',
				'version'  =>  settings()['version'],
				'is_localhost'  => isLocalHost(),
			);

			$form_data = json_encode($form_data);
			$ch = curl_init(URL."check-valid");  
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                     
			curl_setopt($ch, CURLOPT_POSTFIELDS, $form_data);                   
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
			curl_setopt($ch, CURLOPT_POST,1);                                    
			$result = curl_exec($ch);
			curl_close($ch);
			return $result = json_decode($result);
	}




public function backup_db()
{
	is_test();
    $this->load->dbutil();
	$prefs = array(     
	    'format'      => '.sql',             
	    'filename'    => 'my_db_backup.sql'
	    );
	$backup =$this->dbutil->backup($prefs);
	$project = explode('/', $_SERVER['REQUEST_URI'])[1];
	$db_name =$project.'-'. date("d-m-Y-H-i-s") .'.sql';
	$save = 'database/'.$db_name;
	$this->load->helper('file');
	write_file($save, $backup); 
	$this->session->set_flashdata('success', 'Database backup Successfully');
	redirect($this->agent->referrer());
}


	public function request_change_domain(){
		$this->form_validation->set_rules('code', 'Purchase code', 'trim|required|xss_clean');
		$this->form_validation->set_rules('site_url', 'New Url', 'trim|required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			}else{	
				$code = $this->input->post('code',true);
				$site_id = $this->input->post('site_id',true);
				$site_url = get_domain($this->input->post('site_url',true));
				$check_valid = $this->check_vaild_pruchase_code($code,$site_id,$site_url);
				if($check_valid->st ==1):
					$data = array(
						'supported_until' => $check_valid->supported_until,
						'active_code' => $check_valid->active_code,
						'purchase_code' =>$code,
						'site_url' => $site_url,
						'active_key' => $check_valid->active_key,
						'is_update' => 0,
						'license_name' => $check_valid->license_name,
						'site_info' => $check_valid->li,
						'license_code' => $check_valid->li_code,
						'purchase_date' => $check_valid->sold_at,
						'created_at' =>d_time(),
					); 
					$insert = $this->admin_m->update_setting($data,$site_id,'settings');
					$this->session->set_flashdata('success','Thank you! Your URL changed Successfully');
					if($insert){
						$this->version_changes_m->createVersion($data['purchase_code'],settings()['version'],$data['license_code']);
						$this->reset_qr();
					}
					redirect($_SERVER['HTTP_REFERER']);
				else:
					$this->session->set_flashdata('error', $check_valid->msg);
					redirect($_SERVER['HTTP_REFERER']);
				endif;	
		}
	}

	public function check_vaild_pruchase_code($code,$site_id,$site_url){
		// check_valid_purchases
			$form_data = array(
				'purchase_code'  => $code,
				'site_id'  => $site_id,
				'site_url'  => $site_url,
				'is_exchange'  => 1,
				'is_change_domain_request'  => 1,
				'author'  => 'codetrick',
				'ip'  => $this->version_changes_m->getIpAddress(),
			);

			$form_data = json_encode($form_data);
			$ch = curl_init(URL."change-domain");  
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                     
			curl_setopt($ch, CURLOPT_POSTFIELDS, $form_data);                   
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
			curl_setopt($ch, CURLOPT_POST,1);                                    
			$result = curl_exec($ch);
			curl_close($ch);
			return $result = json_decode($result);
	}

	public function summernote_image_upload() {
			if ($_FILES['file']['name']) {
				if (!$_FILES['file']['error']) {
					$name = md5(rand(100, 200));
					$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
					$filename = $name.'.'.$ext;
			    $destination = 'uploads/'.$filename; //change this directory
			    $location = $_FILES["file"]["tmp_name"];
			    move_uploaded_file($location, $destination);
			    echo base_url('uploads/'.$filename); //change this URL
			} else {
				echo $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['file']['error'];
			}
		}
	}


	function createVersion($purchase_code,$license_code){
		error_reporting(0);
		include BASEPATH.'/application/config/config.php';
		$dir =  BASEPATH.'/application/config/version.php';
		$version = "<?php \n";
		$version .= "define('VERSION', '". $config['app_version'] ."'); \n";
		$version .= "define('SCRIPT_NAME', 'qmenu'); \n";
		$version .= "define('AUTHOR', 'codetrick'); \n";
		$version .= "define('CODECANYON_LICENSE', '".$purchase_code."'); \n";
		$version .= "define('AUTHOR_LICENSE', '".$license_code."'); \n";
		file_put_contents(BASEPATH."/application/config/version.php", $version);
		
	}

	public function reset_qr(){
	   $users = $this->admin_m->select('users');
		foreach ($users as $key => $user) {
			$this->load->library('ciqrcode');
			$qr_image=$user['username'].'_'.rand().'.png';
			$params['data'] = base_url($user['username']);
			$params['level'] = 'H';
			$params['size'] = 8;
			$params['savename'] =FCPATH."uploads/qr_image/".$qr_image;
			if($this->ciqrcode->generate($params))
			{
				$data = array(
					'qr_link' =>'uploads/qr_image/'.$qr_image,
				);
				$update = $this->admin_m->update_by_username($data,$user['username'],'users');
				
			}
		}
		$settings = settings();
		$this->load->library('ciqrcode');
		$qr_image='site_qr_'.rand().'.png';
		$params['data'] = base_url('sign-up');
		$params['level'] = 'H';
		$params['size'] = 8;
		$params['savename'] =FCPATH."uploads/qr_image/".$qr_image;
		if($this->ciqrcode->generate($params))
		{
			$data = array(
				'site_qr_link' =>'uploads/qr_image/'.$qr_image,
			);
			$update = $this->admin_m->update($data,$settings['id'],'settings');
			
		}

		$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
		redirect(base_url('admin/dashboard'));

	}



	public function send_notification(){
		$this->form_validation->set_rules('headings', 'Headings', 'trim|required|xss_clean');
		$this->form_validation->set_rules('msg', 'Message', 'trim|required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			}else{

				$settings = settings();	
				$notification = !empty($settings['notifications'])?json_decode($settings['notifications']):"";

				$headings = $this->input->post('headings');
				$msg = $this->input->post('msg',true);
				$appId = $this->input->post('app_id',true);
				$url = $this->input->post('url',true);


				$headings      = array(
					"en" => $headings
				);

				$content      = array(
					"en" => $msg
				);
 				

			    $fields = array(
			        'app_id' => $appId,
			        'included_segments' => array(
			            'Subscribed Users'
			        ),
			        'data' => array(
			            "foo" => "bar"
			        ),

			        'contents' => $content,
			        'headings' => $headings,
			        'url' => !empty($url)?$url:base_url('dashboard'),
			    );

			    $fields = json_encode($fields);
			    
			    $ch = curl_init();
			    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
			    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			        'Content-Type: application/json; charset=utf-8',
			        'Authorization: Basic '.$notification->user_auth_key,
			    ));
			    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			    curl_setopt($ch, CURLOPT_HEADER, FALSE);
			    curl_setopt($ch, CURLOPT_POST, TRUE);
			    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
			    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			    
			    $response = curl_exec($ch);
			    curl_close($ch);
			    $result = json_decode($response);
			    if($result->id !=''):

				$this->session->set_flashdata('success', 'notifications_send_successfully');
				redirect($_SERVER['HTTP_REFERER']);
				else:
					$this->session->set_flashdata('error', lang('error_text'));
					redirect($_SERVER['HTTP_REFERER']);
				endif;	
		}
	}



	public function domain_list()
	{
		if(check() !=1):
			exit();
		endif;

		check_valid_auth();
		$data = array();
		$data['page_title'] = "Custom Domain";
        $data['page'] = "Custom Domain";
        $data['data'] = FALSE;
        $data['domain_list']=$this->admin_m->select('custom_domain_list');
        $data['settings']= settings();
		$data['main_content'] = $this->load->view('backend/admin_activities/custom_domain_list', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function change_domain_status()
	{
		if(check() !=1):
			exit();
		endif;
		is_test();

		$this->form_validation->set_rules('id', 'ID', 'trim|xss_clean|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|xss_clean|required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}else{	

			$status = $this->input->post('status',TRUE);
			$id = $this->input->post('id',TRUE);

			if($status==1){
				$data = [
					'status' => $status,
					'is_ready' =>0,
					'comments' => $_POST['approved_msg'],
				];
			}elseif($status==2){
				$data = [
					'status' => $status,
					'is_ready' => 1,
					'comments' => '',
					'approved_date' => d_time(),
				];
			}elseif($status==3){
				$data = [
					'status' => $status,
					'is_ready' =>0,
					'comments' => $_POST['cancled_msg'],
				];
			}

			$this->admin_m->update($data,$id,'custom_domain_list');
			$this->session->set_flashdata('success',lang('success_text'));
			redirect($_SERVER['HTTP_REFERER']);

		}
		
	}


	public function add_default_comments(){
		is_test();
		if(check() !=1):
			exit();
		endif;
		
		$this->form_validation->set_rules('approved_msg', 'Comments', 'trim|xss_clean');
		$this->form_validation->set_rules('cancled_msg', 'Comments', 'trim|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			}else{	

				$id = $this->input->post('id',TRUE);
				$data_msg = [
					'approved_msg' => $this->input->post('approved_msg'),
					'cancled_msg' => $this->input->post('cancled_msg'),
					'custom_domain_msg' => $this->input->post('custom_domain_msg'),
				];

				$data = ['custom_domain_comments' => json_encode($data_msg)];

			if($id==0):
				$insert = $this->admin_m->insert($data,'settings');
			else:
				$insert = $this->admin_m->update($data,$id,'settings');
			endif;
					
			if($insert):
				$this->session->set_flashdata('success',lang('success_text'));
				redirect($_SERVER['HTTP_REFERER']);
			else:
				$this->session->set_flashdata('error', lang('error_text'));
				redirect($_SERVER['HTTP_REFERER']);
			endif;	
		}
	}




	public function enable_custom_domain()
	{
		$this->admin_m->update(['is_custom_domain'=>1],$this->settings['id'],'settings');
		$this->session->set_flashdata('success',lang('success_text'));
		redirect($_SERVER['HTTP_REFERER']);
	}




	public function shop_reviews()
	{
		$data = array();
		$data['page_title'] = "Shop Reviews";
        $data['page'] = "Shop Reviews";
        $data['data'] = FALSE;
        $data['review_list']=$this->admin_m->get_shop_reviews();
        $data['settings']= settings();
		$data['main_content'] = $this->load->view('backend/admin_activities/shop_reviews', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function review_status($id,$status)
	{
		if(!empty($id)){
			if($status=='delete'){
				$data = [
					'is_rating_approved' => 0,
					'customer_rating' => '',
					'customer_review' => '',
				];

				$update = $this->admin_m->update($data,$id,'order_user_list');
			}else{
				$data = [
					'is_rating_approved' => $status,
				];

				$update = $this->admin_m->update($data,$id,'order_user_list');
			}
			

			if($update){
				$this->session->set_flashdata('success',lang('success_text'));
			}else{
				$this->session->set_flashdata('error',lang('error_text'));
			}
		}

		redirect($_SERVER['HTTP_REFERER']);
	}




}