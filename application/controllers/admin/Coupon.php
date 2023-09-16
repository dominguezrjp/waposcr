<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coupon extends MY_Controller {
	public function __construct(){
		parent::__construct();
		is_login();
	}


	public function index()
	{
		$data = array();
		$data['page_title'] = "Coupon List";
		$data['page'] = "Coupon";
		$data['couponList'] = $this->admin_m->select_all_by_user_desc('coupon_list');
		$data['main_content'] = $this->load->view('backend/users/coupon_list', $data, TRUE);
		$this->load->view('backend/index',$data);
	}


	public function add_coupon()
	{
		
		$data = array();
		$data['page_title'] = "Coupon List";
		$data['page'] = "Coupon";
		$data['data'] = FALSE;
		$data['couponList'] = $this->admin_m->select_all_by_user_desc('coupon_list');
		$data['main_content'] = $this->load->view('backend/users/add_coupon', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function edit($id)
	{
		
		$data = array();
		$data['page_title'] = "Coupon List";
		$data['page'] = "Coupon";
		$data['data'] = single_select_by_id($id,'coupon_list');
		$data['couponList'] = $this->admin_m->select_all_by_user_desc('coupon_list');
		$data['main_content'] = $this->load->view('backend/users/add_coupon', $data, TRUE);
		$this->load->view('backend/index',$data);
	}


	public function create_coupon(){
		is_test();
    	$id = $this->input->post('id');
		$this->form_validation->set_rules('title', 'Title', 'trim|xss_clean');
		$this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|xss_clean|required');
		$this->form_validation->set_rules('discount', 'Discount', 'trim|xss_clean|required');
		$this->form_validation->set_rules('end_date', 'End Date', 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/coupon/'));
			}else{	
				$data = array(
					'user_id' => auth('id'),
					'shop_id' => restaurant()->id,
					'coupon_code' => strtoupper($this->input->post('coupon_code',TRUE)),
					'title' => $this->input->post('title',TRUE),
					'discount' => $this->input->post('discount',TRUE),
					'total_limit' => $this->input->post('total_limit',TRUE),
					'start_date' => $this->input->post('start_date',TRUE),
					'end_date' => $this->input->post('end_date',TRUE),
					'created_at' => d_time(),
				);

				if($id==0){
					$insert = $this->admin_m->insert($data,'coupon_list');
				}else{
					$insert = $this->admin_m->update($data,$id,'coupon_list');
				}

				if($insert){
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/coupon'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/coupon'));
				}	
		}
	}


}
