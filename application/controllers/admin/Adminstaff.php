<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adminstaff extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		check_valid_auth();
	}

	
	public function index()
	{
		$data = array();
		$data['page_title'] = "Staff";
		$data['page'] = "Staff";
		$data['data'] = false;
		$data['edit'] = 0;
		$data['staff_list'] = $this->admin_m->get_admin_staf();
		$data['permission_list'] = $this->admin_m->select_permossion('admin_staff');
		$data['main_content'] = $this->load->view('backend/admin_staff/staff_list', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function permission_list()
	{
		$data = array();
		$data['page_title'] = "Permission List";
		$data['page'] = "Staff";
		$data['data'] = false;
		$data['edit'] = 0;
		$data['permission_list'] = $this->admin_m->select('permission_list');
		$data['main_content'] = $this->load->view('backend/admin_staff/permission_list', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function staff()
	{
		$data = array();
		$data['page_title'] = "Staff";
		$data['page'] = "Staff";
		$data['edit'] = 1;
		$data['data'] = false;
		$data['staff_list'] = $this->admin_m->get_my_all_staf('staff_list');
		$data['permission_list'] = $this->admin_m->select_permossion('admin_staff');
		$data['main_content'] = $this->load->view('backend/admin_staff/add_staff', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function activities($id)
	{
		$data = array();
		$data['page_title'] = "Staff";
		$data['page'] = "Staff";
		$data['edit'] =0;
        $data['staff_info'] = $this->admin_m->get_staff_info_by_id($id);
		$data['activities_list'] = $this->admin_m->get_my_activities_list($id);
		$data['main_content'] = $this->load->view('backend/admin_staff/activities', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function edit_staff($id)
	{
		$data = array();
		$data['page_title'] = "Staff";
		$data['page'] = "Staff";
		$data['edit'] = 1;
		$data['data'] = $this->admin_m->single_select_by_id($id,'staff_list');
		valid_user($data['data']['user_id']);
		$data['staff_list'] = $this->admin_m->get_my_all_staf('staff_list');
		$data['permission_list'] = $this->admin_m->select_permossion('admin_staff');
		$data['main_content'] = $this->load->view('backend/admin_staff/add_staff', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function add_permission_list(){
		is_test();
		$this->form_validation->set_rules('title[]', 'Title', 'required|trim|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}else{	

			foreach ($_POST['title'] as $key => $value) {
				$data = array(
					'title' => $value,
				); 
				$id = $_POST['id'][$key];
				$insert = $this->admin_m->update($data,$id,'permission_list');
			}

			if($insert){
				$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
				redirect($_SERVER['HTTP_REFERER']);
			}	
		}
	}



	public function add_new_permission_list(){
		is_test();
		$this->form_validation->set_rules('title', 'Title', 'required|trim|xss_clean');
		$this->form_validation->set_rules('slug', 'Slug', 'required|trim|xss_clean|is_unique[permission_list.slug]');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}else{	

			$data = array(
				'title' => $_POST['title'],
				'slug' => str_slug($_POST['slug']),
				'role' => 'admin_staff',
			); 
			$insert = $this->admin_m->insert($data,'permission_list');

			if($insert){
				$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
				redirect($_SERVER['HTTP_REFERER']);
			}	
		}
	}




	public function add_staff(){
		is_test();
		$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean');
		$this->form_validation->set_rules('permission_id[]', 'Permission', 'required|trim|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}else{	
			$id = $this->input->post('id',TRUE);
		
			$check_staff_email = $this->admin_m->check_exits_staff(strtolower(trim($this->input->post('email',true))));
			if($check_staff_email==1 && $id ==0){
				$this->session->set_flashdata('error', lang('email_alreay_exits'));
				redirect($_SERVER['HTTP_REFERER']);
				exit();

			}else{
				$uid = date('Y').random_string('numeric',4);
				if(isset($id) && $id !=0):
					$data = array(
						'name' => $this->input->post('name',TRUE),
						'email' => $this->input->post('email',TRUE),
						'user_id' => auth('id'),
						'status' => 1,
						'role' => 'admin_staff',
						'permission' => json_encode($_POST['permission_id']),
						'created_at' => d_time(),

					);
				else:
					$data = array(
						'uid' => $uid,
						'name' => $this->input->post('name',TRUE),
						'email' => $this->input->post('email',TRUE),
						'password' => md5(1234),
						'user_id' => auth('id'),
						'status' => 1,
						'role' => 'admin_staff',
						'permission' => json_encode($_POST['permission_id']),
						'created_at' => d_time(),

					);
				endif;
			}

			
			if(isset($id) && $id !=0){
				$insert = $this->admin_m->update($data,$id,'staff_list');
			}else{
				$insert = $this->admin_m->insert($data,'staff_list');
			}

			if($insert){
				$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
				redirect(base_url('admin/adminstaff/'));
			}else{
				$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
				redirect(base_url('admin/adminstaff/'));
			}	
		}
	}
	public function update_staff_profile(){
		is_test();
		$this->form_validation->set_rules('name', 'name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('phone', 'phone', 'trim|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/adminstaff/staff_profile'));
		}else{	
			$data = array(
				'name' => $this->input->post('name',TRUE),
				'phone' => $this->input->post('phone',TRUE),
			);
			$id = $this->input->post('id');
			if($id==0){
				$insert = $this->admin_m->insert($data,'staff_list');
			}else{
				$insert = $this->admin_m->update($data,$id,'staff_list');
			}

			if($insert){
				$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
				redirect(base_url('admin/adminstaff/staff_profile'));
			}else{
				$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
				redirect(base_url('admin/adminstaff/staff_profile'));
			}	
		}
	}





	public function staff_profile(){

		$data = array();
		$data['page_title'] = "Profile";
		$data['page'] = "Auth";
		$data['auth_info'] = $this->admin_m->single_select_by_id(auth('staff_id'),'staff_list');
		$data['permission_list'] = $this->admin_m->select_permossion('admin_staff');
		$data['main_content'] = $this->load->view('backend/admin_staff/staff_profile', $data, TRUE);
		$this->load->view('backend/index',$data);
	}



	public function upload_profile(){
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
					$this->admin_m->update(array('thumb' => $value['thumb']),auth('staff_id'),'staff_list');
				}
				echo json_encode(array('st'=>1,'msg' =>'Upload Suceessfully','img'=>$value['thumb']));
			else:
				echo json_encode(array('st'=>0,'msg' =>$up_load['data']));
			endif;

		}else{
			echo json_encode(array('st'=>0,'msg' =>'Please select an image'));
		}

	}

	public function change_pass()
	{	
		is_test();
		$this->form_validation->set_rules('old_pass', 'Old Password', 'trim|required|min_length[3]|xss_clean');		
		$this->form_validation->set_rules('new_pass', 'New Password', 'trim|required|min_length[3]|xss_clean');
		$this->form_validation->set_rules('c_pass', 'Confirm Password', 'trim|required|min_length[3]|xss_clean|matches[new_pass]');
		if ($this->form_validation->run() == FALSE) {
			$msg = '<div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			'.validation_errors().'
			</div>';
			echo json_encode(array('st' => 0, 'msg'=> $msg));
		}else{	
			$pass = $this->input->post('old_pass');

			$check = $this->admin_m->check_staff_pass($pass);

			if($check){
				$data = array(
					'password' => md5($this->input->post('new_pass')),
				);	
				$insert = $this->admin_m->update($data,auth('staff_id'),'staff_list');
				if($insert){
					$msg = '<div class="alert alert-success alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Thank You ! </strong> Your password change successfully <i class="fa fa-smile-o"></i>
					</div>';

					echo json_encode(array('st' => 1, 'msg'=> $msg));

				}else{
					$msg = '<div class="alert alert-danger alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Sorry </strong> Try again later
					</div>';

					echo json_encode(array('st' => 2, 'msg'=> $msg));
				}
			}else{
				$msg = '<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Sorry </strong> Your Old password was wrong!
				</div>';

				echo json_encode(array('st' => 3, 'msg'=> $msg));
			}	

		}
	}

}

/* End of file Adminstaff.php */
/* Location: ./application/controllers/Adminstaff.php */