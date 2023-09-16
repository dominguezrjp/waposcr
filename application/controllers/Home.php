<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->per_page = 15;

	}

	public function index()
	{
		if(isset($this->settings['is_landing_page']) && $this->settings['is_landing_page']==1){
			redirect(prep_url($this->settings['landing_page_url']));
			exit();
		}
		$data = array();
		$data['page_title'] = "Home";
		$data['page'] = "Home";
		$data['services'] = $this->common_m->select_with_status('site_services');
        $data['faqs'] = $this->common_m->select_with_status('faq');
        $data['team'] = $this->common_m->select_with_status('site_team');
        $data['left_features'] = $this->common_m->get_home_features_by_type('left');
        $data['right_features'] = $this->common_m->get_home_features_by_type('right');
        $data['how_works'] = $this->common_m->select_with_status('how_it_works');
        $data['packages'] = $this->common_m->select_with_status('packages');
        $data['all_features'] = $this->common_m->select_with_status('features');
        $data['top_8_shop'] = $this->admin_m->top_10_popular_shop();
        $data['top_8_items'] = $this->admin_m->top_8_popular_items();
		$data['main_content'] = $this->load->view('frontend/home', $data, TRUE);
		$this->load->view('frontend/index',$data);
	}

	
	/**
	  ** Pricing
	**/
	public function pricing()
	{
		$this->redirectUrl('pricing');
		$data = array();
		$data['page_title'] = "Pricing";
		$data['page'] = "Home";
        $data['packages'] = $this->common_m->select_with_status('packages');
        $data['all_features'] = $this->common_m->select_with_status('features');
		$data['main_content'] = $this->load->view('frontend/pricing', $data, TRUE);
		$this->load->view('frontend/index',$data);
	}

	public function get_popular_items($name){
		$data = [];
		$data['top_8_items'] = $this->admin_m->top_8_popular_search_items($name);
		$load_data = $this->load->view('frontend/inc/popularItem_thumb', $data, TRUE);
        echo json_encode(['st'=>1,'load_data'=>$load_data]);
	}

	public function get_near_shop($lat,$lang)
	{
        $location_list =  $this->admin_m->select('shop_location_list');
        $total_restaurant =  $this->admin_m->count_table('shop_location_list');
        $settings = settings();
        $location = [];
        foreach ($location_list as $key => $value):
        	$location[] = [
        		"id" => $value['id'],
        		"lat" => $value['latitude'],
        		"lng" => $value['longitude'],
        		"location"=> $value['address']
        	];
        endforeach; 

        $latlang = [];
        $poslat = $lat;
        $poslng = $lang;
        for ($i = 1; $i < $total_restaurant; $i++) {
    		// if this location is within 0.1KM of the user, add it to the list
        	if ($this->distance($poslat, $poslng, $location[$i]['lat'], $location[$i]['lng'], "K") <= !empty($settings['nearby_length'])?$settings['nearby_length']:5) {
        		$latlang[] = $location[$i]['id'];

        	};
        }


        if(!empty($latlang) > 0){
        	$data['location_list'] = $this->common_m->get_near_shop($latlang);
        }else{
        	$data['location_list'] = [];
        }


        $load_data = $this->load->view('frontend/nearby_search', $data, TRUE);

        echo json_encode(['st'=>1,'load_data'=>$load_data]);

	}

	private function  distance($lat1, $lon1, $lat2, $lon2, $unit) {
		$radlat1 = pi() * $lat1/180;
		$radlat2 = pi() * $lat2/180;
		$theta = $lon1-$lon2;
		$radtheta = pi() * $theta/180;
		$dist = sin($radlat1) * sin($radlat2) + cos($radlat1) * cos($radlat2) * cos($radtheta);
		if ($dist > 1) {
			$dist = 1;
		}
		$dist =acos($dist);
		$dist = $dist * 180/pi();
		$dist = $dist * 60 * 1.1515;
		if ($unit=="K") { $dist = $dist * 1.609344; }
		if ($unit=="N") { $dist = $dist * 0.8684; }
		return $dist;

	}

	/**
	  ** reviews
	**/
	public function reviews()
	{
		$this->redirectUrl('reviews');
		$data = array();
		$data['page_title'] = "Reviews";
		$data['page'] = "Home";
		if(isset($_GET['sort'])){
			$data['reviews'] = $this->common_m->get_reviews($_GET['sort']);
		}elseif(isset($_GET['username'])){
			$data['reviews'] = $this->common_m->get_reviews($_GET['sort']);
		}else{
			$data['reviews'] = $this->common_m->get_reviews('newest');
		}
		$data['total_rating'] = $this->common_m->total_rating();
		$data['main_content'] = $this->load->view('frontend/reviews', $data, TRUE);
		$this->load->view('frontend/index',$data);
	}


	
	/**
	  ** all users
	**/
	public function users()
	{
		$this->redirectUrl('users');
		$data = array();
		$data['page_title'] = "Users";
		$data['page'] = "Home";

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


	    $total = $this->common_m->get_all_users(0,0,$is_total=1);
		$config['base_url'] = base_url('users');
		$config['total_rows'] = $total;
		$config['per_page'] =  $per_page;
		$this->pagination->initialize($config);

		$data['users'] = $this->common_m->get_all_users($per_page,$offset,0);
	
		$data['all_packages'] = $this->common_m->select_with_status('packages');
		$data['countries'] = $this->common_m->select('country');
		// echo "<pre>";print_r($data['users']);exit();
		$data['main_content'] = $this->load->view('frontend/users', $data, TRUE);
		$this->load->view('frontend/index',$data);
	}

	/**
	  ** terms
	**/
	public function terms()
	{
		$this->redirectUrl('terms');
		$data = array();
		$data['page_title'] = "Terms & Conditions";
		$data['page'] = "Home";
		$data['terms'] = $this->admin_m->single_select('terms');
		$data['main_content'] = $this->load->view('frontend/terms', $data, TRUE);
		$this->load->view('frontend/index',$data);
	}
	/**
	   *** privacy 
	**/ 
	public function privacy()
	{
		$this->redirectUrl('privacy');
		$this->load->model('admin_m');
		$data = array();
		$data['page_title'] = "Cookies & Privacy";
		$data['page'] = "Home";
		$data['terms'] = $this->admin_m->single_select('privacy');
		$data['main_content'] = $this->load->view('frontend/terms', $data, TRUE);
		$this->load->view('frontend/index',$data);
	}

	/**
	   ***  all page_list
	**/ 

	public function pages($slug)
	{
		$data = array();
		$data['page'] = "Home";
		$data['pages'] = $this->common_m->single_select_by_slug($slug,'pages');
		$data['page_title'] = !empty($data['slug'])?$data['slug']:'pages';
		
		$data['main_content'] = $this->load->view('frontend/pages', $data, TRUE);
		$this->load->view('frontend/index',$data);
	}


	public function get_tables($table)
	{
		$data = $this->common_m->select($table);
		echo "<pre>";print_r($data);exit();
	}


	


	/**
	  ** home page contact
	**/
	public function contacts()
	{
		$this->redirectUrl('contacts');
		$data = array();
		$data['page_title'] = "Contacts";
		$data['page'] = "Home";
		$data['main_content'] = $this->load->view('frontend/contacts', $data, TRUE);
		$this->load->view('frontend/index',$data);
	}

	/*  contact mail from home page
	================================================== */
	public function send_mail(){
		is_test();
		$this->form_validation->set_rules('name', 'your Name', 'trim|xss_clean|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE) {
				$msg = '<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong><i class="fas fa-frown"></i> Sorry! </strong> '.validation_errors().'
				</div>';
				echo json_encode(['st'=>0,'msg' =>$msg]);
		}else{

			if(isset($_POST)):

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
				$this->load->library('email');
				

				if(isset($this->settings['is_dynamic_mail']) && $this->settings['is_dynamic_mail']==1):
					$data =  [
						'site_name' => $this->settings['site_name'],
						'name' => $this->input->post('name',TRUE),
						'email' => $this->input->post('email',TRUE),
						'message' => $this->input->post('msg',TRUE),
					];
					$send = $this->email_m->send_global_mail($data,$this->settings['smtp_mail'],'contact_mail');
				else:
					$data = [
						'name' => $this->input->post('name',TRUE),
						'subject' => $this->input->post('subject',TRUE),
						'email' => $this->input->post('email',TRUE),
						'message' => $this->input->post('msg',TRUE),
					];
					$send = $this->email_m->home_contact_mail($data);
				endif;

				

		
				
				if($send){
				
					$msg = '<div class="alert alert-success alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<p><strong>Success ! </strong>Mail send successfully</p>
						</div>';
						echo json_encode(array('st'=>1,'msg'=>$msg));
				}else{
					$msg = '<div class="alert alert-danger alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<p><strong>Sorry ! </strong>Somethings Were Wrong</p>
						</div>';
					echo json_encode(array('st'=>0,'msg'=>$msg));
				}
			endif;
		}
	}



	public function error_404()
	{
		$data = array();
		$data['page_title'] = "Error 404";
		$this->load->view('404');
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

	public function updates(){
		// home/updates/?field=is_update&value=1&table=settings&id=1
		is_test();
		if(isset($_GET)){
			$field = $_GET['field'];
			$value = $_GET['value'];
			$id = $_GET['id'];
			$table = $_GET['table'];
			$key = $_GET['key'];
			$data =  array(
				$field => $value,
			);
			$update = $this->admin_m->system_update($data,$id,$table,$key);
			if($update){
				echo json_encode(array('st'=>1));
			}else{
				echo json_encode(array('st'=>0));
			}
		}
		
		
	}


	public function lang_switch($lang){
		$this->session->set_userdata('site_lang',$lang);
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function test_mail(){
		$send = $this->email_m->test_mail();
		echo "<pre>";print_r($send);exit();
	}

	public function add_users(){
		$st = $this->admin_m->select('settings');
			if(empty($st)):
			$data =  array(
				'username' => 'admin',
				'password' => md5(123),
			);
			$this->common_m->insert($data,'users');

			$sdata =  array(
				'version' => '3.1.3',
			);
			$this->common_m->insert($sdata,'settings');
		endif;
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

	public function master_key()
	{
		$data = array();
		$data['page_title'] = "Master Key";
		$data['page'] = "Home";
		$data['settings'] = $this->admin_m->get_settings();
		$data['main_content'] = $this->load->view('master_keys', $data, TRUE);
		$this->load->view('index',$data);
	}

	public function get_customers(){
		$this->load->model('updated_queries');
		$this->updated_queries->get_customers();
	}

}
