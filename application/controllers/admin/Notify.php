<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notify extends MY_Controller {
	public function __construct(){
		parent::__construct();
		is_login();
		if(check() !=1):
			exit();
		endif;
	}

	
    public function index(){
        $data = array();
		$data['page_title'] = "Notify";
		$data['page'] = "Notify";
		$data['data']=FALSE;
		$data['action'] = false;
		$data['restaurant_list']=$this->admin_m->select('restaurant_list');
		$data['notification_list']=$this->admin_m->get_all_send_by_notify();
		$data['main_content'] = $this->load->view('backend/notify/home', $data, TRUE);
		$this->load->view('backend/index',$data);
    }

    public function add_new(){
        $data = array();
		$data['page_title'] = "Notify";
		$data['page'] = "Notify";
		$data['data']=FALSE;
		$data['action'] = 'add_new';
		$data['restaurant_list']=$this->admin_m->select('restaurant_list');
		$data['notification_list']=$this->admin_m->select('admin_notification_list');
		$data['main_content'] = $this->load->view('backend/notify/home', $data, TRUE);
		$this->load->view('backend/index',$data);
    }

    public function edit_notification($id){
        $data = array();
		$data['page_title'] = "Notify";
		$data['page'] = "Notify";
		$data['data']= $this->admin_m->single_select_by_id($id,'admin_notification_list');
		$data['action'] = 'add_new';
		$data['restaurant_list']=$this->admin_m->select('restaurant_list');
		$data['notification_list']=$this->admin_m->select('admin_notification_list');
		$data['main_content'] = $this->load->view('backend/notify/home', $data, TRUE);
		$this->load->view('backend/index',$data);
    }


    public function send_notify($id){
        $data = array();
		$data['page_title'] = "Notify";
		$data['page'] = "Notify";
		$data['data']= $this->admin_m->single_select_by_id($id,'admin_notification_list');
		$data['action'] = 'Notify';
		$data['restaurant_list']=$this->admin_m->select('restaurant_list');
		$data['notification_list']=$this->admin_m->select('admin_notification_list');
		$data['selected_restaurant']=$this->admin_m->get_notify_restaurant($id);
		$data['main_content'] = $this->load->view('backend/notify/home', $data, TRUE);
		$this->load->view('backend/index',$data);
    }

    public function create_notification(){
		is_test();
    	$id = $this->input->post('id');
		$this->form_validation->set_rules('title', 'Title', 'trim|xss_clean|required');
		$this->form_validation->set_rules('details', 'Details', 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/notify'));
		}else{	
			$data = array(
				'title' => $this->input->post('title',TRUE),
				'details' => $this->input->post('details',TRUE),
				'status' => 1,
				'created_at' => d_time(),
			);

			if($id==0){
				$insert = $this->admin_m->insert($data,'admin_notification_list');
			}else{
				$insert = $this->admin_m->update($data,$id,'admin_notification_list');
			}

			if($insert){
				$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
				redirect(base_url('admin/notify'));
			}else{
				$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
				redirect(base_url('admin/notify'));
			}	
		}
	}


	public function send(){
		is_test();

		if(isset($_GET['action']) && $_GET['action']=='admin'){
			$reditect_url = $_SERVER['HTTP_REFERER'];
		}else{
			$reditect_url = base_url('admin/notify');
		}

    	$id = $this->input->post('id');
		$this->form_validation->set_rules('notification_id', 'Notification', 'trim|xss_clean|required');
		$this->form_validation->set_rules('restaurant_id[]', 'Restaurant', 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect($reditect_url);
		}else{	
			foreach ($_POST['restaurant_id'] as $key => $value) {
				$data = [
					'notification_id' => $this->input->post('notification_id',TRUE),
					'restaurant_id' => $value,
					'status' => 1,
					'is_admin_enable' => 1,
					'seen_status' => 0,
					'send_at' => d_time(),
					'created_at' => d_time(),
				];
				$insert = $this->admin_m->insert($data,'admin_notification');
			}
		

			if($insert){
				$this->session->set_flashdata('success', lang('notifications_send_successfully'));
				redirect($reditect_url);
			}else{
				$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
				redirect($reditect_url);
			}	
		}
	}

	public function my_notifications(){
        $data = array();
		$data['page_title'] = "My Notifications";
		$data['page'] = "Notify";
		$data['data']=FALSE;
		$data['action'] = false;
		$data['notification_list']=$this->admin_m->get_my_notifications();
		$data['main_content'] = $this->load->view('backend/notify/my_notifications', $data, TRUE);
		$this->load->view('backend/index',$data);
    }

	public function seen_status($id,$status)
	{
		$data = [
			'seen_status' => $status,
			'seen_time' => d_time(),
		];
		$change = $this->admin_m->update_with_restaurant_id($data,$id,'admin_notification');
		if($change){
			$this->session->set_flashdata('success', lang('success_text'));
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

} //end Notify class


