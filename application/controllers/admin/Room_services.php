<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Room_services extends MY_Controller {
	public function __construct(){
		parent::__construct();
		is_login();
		$this->per_page = 14;
		$this->load->library('pagination');
	}


	public function index()
	{
		$data = array();
		$data['page_title'] = "Room Services";
		$data['page'] = "Profile";
		$data['data'] = FALSE;
		$data['hotel_list'] = $this->admin_m->select_all_by_user('hotel_list');
		$data['main_content'] = $this->load->view('backend/room_services/home', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function add_new_hotel()
	{
		$data = array();
		$data['page_title'] = "Add Hotel";
		$data['page'] = "Profile";
		$data['data'] = FALSE;
		$data['hotel_list'] = $this->admin_m->select_all_by_user('hotel_list');
		$data['main_content'] = $this->load->view('backend/room_services/create_hotel', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function edit_hotel($id)
	{
		$data = array();
		$data['page_title'] = "Add Hotel";
		$data['page'] = "Profile";
		$data['data'] = $this->admin_m->single_select_by_id($id,'hotel_list');
		$data['hotel_list'] = $this->admin_m->select_all_by_user('hotel_list');
		 valid_user($data['data']['user_id']);
		$data['main_content'] = $this->load->view('backend/room_services/create_hotel', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function create_new_hotel()
	{
		is_test();
	$id =  $this->input->post('id',true);
	$this->form_validation->set_rules('hotel_name', 'Hotel name', 'trim|xss_clean|required');
	if ($this->form_validation->run() == FALSE) {
		$this->session->set_flashdata('error', validation_errors());
		redirect($_SERVER['HTTP_REFERER']);
	}else{

		$room_numbers=[];
		foreach ($_POST['room_numbers'] as $key => $value) {
			if(!empty($value)):
				$room_numbers[] = $value;
			endif;
		}
			
		
		$data = array(
			'user_id' => auth('id'),
			'shop_id' => restaurant()->id,
			'hotel_name' => $this->input->post('hotel_name',TRUE),
			'room_numbers' => json_encode($room_numbers),
			'created_at' => d_time(),
		);
		if($id !=0){
			$insert = $this->admin_m->update($data,$id,'hotel_list');
		}else{
			$insert = $this->admin_m->insert($data,'hotel_list');
		}
		if($insert){
			$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
			redirect(base_url('admin/room_services/'));
		}else{
			$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
			redirect(base_url('admin/room_services/'));
		}	
	}
}


public function delete_room_number($id){
	if(isset($_GET['key'])){
		$old = single_select_by_id($id,'hotel_list');
		$old_img = json_decode($old['room_numbers'],TRUE);
		$getImg = $old_img[$_GET['key']];

		unset($old_img[$_GET['key']]);
		$this->admin_m->update(['room_numbers'=>json_encode($old_img)],$id,'hotel_list');
		redirect($_SERVER['HTTP_REFERER']);
	}

}


} // end of the class

