<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor extends CI_Controller {
	public function __construct(){
		parent::__construct();
		 check_login_user();
	}

	public function order_list()
	{
		$data = array();
		$data['page_title'] = "Order List";
		$data['page'] = "Order";
		$data['data'] = false;
		$data['order_list'] = $this->admin_m->get_my_today_order_list_by_id(vendor()->id);
		$data['main_content'] = $this->load->view('backend/vendor/order_list', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function all_orders()
	{
		$data = array();
		$data['page_title'] = "All Order List";
		$data['page'] = "Order";
		$data['data'] = false;
		$data['order_list'] = $this->admin_m->get_all_order_list_by_id(vendor()->id);
		$data['main_content'] = $this->load->view('backend/vendor/all_order_list', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function create_vendor_account(){
		$this->form_validation->set_rules('category_id', 'Category', 'required|trim|xss_clean');
		$this->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean|is_unique[vendor_list.username]');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean');
		$this->form_validation->set_rules('phone', 'Phone', 'required|trim|xss_clean|is_unique[vendor_list.phone]');
		if ($this->form_validation->run() == FALSE) {
			$response =  ['st' => 0, 'msg'=> validation_errors(),'url'=>''];
		}else{	
			$is_required = $this->input->post('is_required',TRUE);

			$data = array(
				'category_id' => $this->input->post('category_id',TRUE),
				'user_id' => auth('id'),
				'username' => $this->input->post('username',TRUE),
				'phone' => $this->input->post('phone',TRUE),
				'email' => $this->input->post('email',TRUE),
				'created_at' => d_time(),
			);
			$id = $this->input->post('id',TRUE);
			if($id != 0):
				$insert = $this->default_m->update($data,$id,'vendor_list');
			else:
				$insert = $this->default_m->insert($data,'vendor_list');

			endif;

			if($insert){
				$response =  ['st' => 1, 'msg'=> 'Save Change Successful','url'=>base_url('admin/profile/')];

			}else{
				$response =  ['st' => 0, 'msg'=> 'Somethings Were Wrong!!','url'=>''];

			}	
		}
		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($response));
		;	
	}


	public function change_status($id){
		$data = ['is_due' =>0, 'payment_date'=>d_time()];
		$update = $this->default_m->update($data,$id,'order_list');

		if($update){
			$response =  ['st' => 1, 'msg'=> 'Save Change Successful','url'=>''];

		}else{
			$response =  ['st' => 0, 'msg'=> 'Somethings Were Wrong!!','url'=>''];

		}

		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($response));
		;	
	}

}
