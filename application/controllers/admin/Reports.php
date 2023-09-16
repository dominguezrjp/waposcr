<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends MY_Controller {
	public function __construct(){
		parent::__construct();
		is_login();
		check_valid_user();
		$this->per_page = 14;
		$this->load->library('pagination');
	}

	public function statistics()
	{

		$data = array();
		$data['page_title'] = "Statistics";
		$data['page'] = "Reports";
		$data['top_item'] = $this->admin_m->top_10_popular_item();
		$data['top_sell_price'] = $this->admin_m->top_10_sell_qty_item();
		$data['top_popular_customer'] = $this->admin_m->top_10_popular_customers();
		$data['main_content'] = $this->load->view('backend/reports/statistics', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function earnings($year=null,$month=null)
	{

		$data = array();
		$data['page_title'] = "Earnings";
		$data['page'] = "Reports";
		$data['month'] = $month;
		$data['year'] = $year;
		$data['shop_id'] = restaurant()->id;
		$data['earning_list'] = $this->admin_m->get_my_earnings(restaurant()->id,$year,$month);
		$data['main_content'] = $this->load->view('backend/reports/earnings', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

}