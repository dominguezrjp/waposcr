<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends MY_Controller{

		public function __construct(){
		parent::__construct();
		check_valid_auth();
		is_login();
	}

	/**
	  ***  settings
	**/ 
	public function settings()
	{
		$data = array();
		$data['page_title'] = "Settings";
        $data['page'] = "Settings";
        $data['settings']=$this->admin_m->single_select('settings');
        $data['languages']=$this->admin_m->select_with_status('languages');
        $data['currencies']=$this->admin_m->select('country');
		$data['main_content'] = $this->load->view('backend/settings/setting', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function landing_page()
	{
		$data = array();
		$data['page_title'] = "Landing Page Settings";
        $data['page'] = "Settings";
        $data['settings']=$this->admin_m->single_select('settings');
		$data['main_content'] = $this->load->view('backend/settings/landing_page', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function preferences()
	{
		$data = array();
		$data['page_title'] = "Preferences";
        $data['page'] = "Settings";
        $data['settings']=$this->admin_m->single_select('settings');
		$data['main_content'] = $this->load->view('backend/settings/preference', $data, TRUE);
		$this->load->view('backend/index',$data);
	}


	/**
	  ***  Email Settings
	**/ 
	public function email_settings()
	{
		
		$data = array();
		$data['page_title'] = "Email Settings";
        $data['page'] = "Settings";
        $data['settings']=$this->admin_m->single_select('settings');
		$data['main_content'] = $this->load->view('backend/settings/email_setting', $data, TRUE);
		$this->load->view('backend/index',$data);
	}


	public function recaptcha_settings()
	{
		
		$data = array();
		$data['page_title'] = "Recaptcha Settings";
        $data['page'] = "Settings";
        $data['settings']=$this->admin_m->single_select('settings');
		$data['main_content'] = $this->load->view('backend/settings/recaptcha_settings', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	/**
	  ***  Email Settings
	**/ 
	public function payment_settings()
	{
		
		$data = array();
		$data['page_title'] = "Payment Settings";
        $data['page'] = "Settings";
        $data['settings']=$this->admin_m->single_select('settings');
        $data['url'] = 'admin/settings/add_payment_settings';
        $data['install_url'] = 'admin/settings/install_payment/';
		$data['main_content'] = $this->load->view('backend/settings/payment_settings', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	/**
	  ***  Email Settings
	**/ 
	public function home_settings()
	{
		
		$data = array();
		$data['page_title'] = "Social Settings";
        $data['page'] = "Settings";
        $data['data'] = false;
        $data['faq']=$this->admin_m->select('faq');
        $data['settings']= $this->admin_m->single_select('settings');
        $data['site_banners']= $this->admin_m->single_select('section_banners');
        $data['banners']= $this->admin_m->select('section_banners');
		$data['main_content'] = $this->load->view('backend/settings/home_settings', $data, TRUE);
		$this->load->view('backend/index',$data);
	}


	/**
	  ***  banner Settings
	**/ 
	public function banner_settings()
	{
		
		$data = array();
		$data['page_title'] = "Home Banner Settings";
        $data['page'] = "Banner Settings";
        $data['data'] = false;
        $data['faq']=$this->admin_m->select('faq');
        $data['settings']= $this->admin_m->single_select('settings');
        $data['site_banners']= $this->admin_m->single_select('section_banners');
        $data['banners']= $this->admin_m->select('section_banners');
		$data['main_content'] = $this->load->view('backend/settings/banner_settings', $data, TRUE);
		$this->load->view('backend/index',$data);
	}


	/**
	  ***  edit section banner
	**/ 
	public function edit_section_banners($id)
	{
		
		$data = array();
		$data['page_title'] = "Home Settings";
        $data['page'] = "Settings";
        $data['data'] = $this->admin_m->single_select_by_id($id,'section_banners');
        $data['setting']= $this->admin_m->single_select('settings');
        $data['site_banners']= $this->admin_m->single_select('section_banners');
        $data['banners']= $this->admin_m->select('section_banners');
		$data['main_content'] = $this->load->view('backend/settings/banner_settings', $data, TRUE);
		$this->load->view('backend/index',$data);
	}
	public function extras()
	{
		$data = array();
		$data['page_title'] = "Extras";
        $data['page'] = "Settings";
        $data['settings']=$this->admin_m->single_select('settings');
		$data['main_content'] = $this->load->view('backend/settings/extras', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	/**
	   ***  Home settings
	**/ 

	public function add_home_setting(){
		is_test();
    	$id = $this->input->post('id');
		$this->form_validation->set_rules('facebook', 'Facebook', 'trim|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/dashboard/home_settings'));
			}else{	
				$social = array(
					'facebook' => $this->input->post('facebook',TRUE),
					'whatsapp' => $this->input->post('whatsapp',TRUE),
					'instagram' => $this->input->post('instagram',TRUE),
					'linkedin' => $this->input->post('linkedin',TRUE),
					'phone' => $this->input->post('phone',TRUE),
					'youtube' => $this->input->post('youtube',TRUE),
					'email' => $this->input->post('email',TRUE),
					'order_video' => get_embeded($this->input->post('order_video',TRUE)),
				);

				$data = array(
					'social_sites' => json_encode($social),
				);
				
				if($id==0){
					$insert = $this->admin_m->insert($data,'settings');
				}else{
					$insert = $this->admin_m->update($data,$id,'settings');
				}

				if($insert){
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/settings/home_settings'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/settings/home_settings'));
				}	
		}
	}

	public function seo_settings()
	{
		
		$data = array();
		$data['page_title'] = "Seo Settings";
        $data['page'] = "Settings";
        $data['settings']= $this->admin_m->single_select('settings');
		$data['main_content'] = $this->load->view('backend/settings/seo_settings', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function add_seo_settings(){
		is_test();
    	$id = $this->input->post('id');
		$this->form_validation->set_rules('title', 'Title', 'trim|xss_clean|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|xss_clean|required');
		$this->form_validation->set_rules('keywords', 'keywords', 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/settings/seo_settings'));
			}else{	
				$social = array(
					'title' => $this->input->post('title',TRUE),
					'description' => $this->input->post('description',TRUE),
					'keywords' => $this->input->post('keywords',TRUE),
				);

				$data = array(
					'seo_settings' => json_encode($social),
				);
				if($id==0){
					$insert = $this->admin_m->insert($data,'settings');
				}else{
					$insert = $this->admin_m->update($data,$id,'settings');
				}

				if($insert){
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/settings/seo_settings'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/settings/seo_settings'));
				}	
		}
	}




	public function map_config(){
		is_test();
    	$id = $this->input->post('id');
    	$is_gmap_key =  $this->input->post('is_gmap_key',TRUE);
    	if(isset($is_gmap_key) && $is_gmap_key==1):
			$this->form_validation->set_rules('gmap_key', 'Gmap Key', 'trim|xss_clean|required');
		else:
			$this->form_validation->set_rules('gmap_key', 'Gmap Key', 'trim|xss_clean');
		endif;
		    $this->form_validation->set_rules('system_fonts', 'Fonts', 'trim|xss_clean');
		    $this->form_validation->set_rules('custom_css', 'Custom CSS', 'trim|xss_clean');
		    $this->form_validation->set_rules('nearby_length', 'Nearby Radius', 'trim|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/settings/extras'));
			}else{	
				
				$gmap = array(
					'gmap_key' => $this->input->post('gmap_key',TRUE),
					'is_gmap_key' => isset($is_gmap_key)?$is_gmap_key:0,
				);

				$data = array(
					'gmap_config' => json_encode($gmap),
					'system_fonts' => str_replace(' ','+',$this->input->post('system_fonts',TRUE)),
					'custom_css' => $this->input->post('custom_css',TRUE),
					'nearby_length' => $this->input->post('nearby_length',TRUE),
				);
				if($id==0){
					$insert = $this->admin_m->insert($data,'settings');
				}else{
					$insert = $this->admin_m->update($data,$id,'settings');
				}

				if($insert){
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/settings/extras'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/settings/extras'));
				}	
		}
	}

	public function add_landing_page(){
		is_test();
    	$id = $this->input->post('id');
		$this->form_validation->set_rules('landing_page_url', 'Landing Page Url', 'trim|xss_clean');
		$this->form_validation->set_rules('restaurant_demo', 'Restaurant Demo', 'trim|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/dashboard/landing_page'));
			}else{	
				$is_landing_page = $this->input->post('is_landing_page',TRUE);
				$data = array(
					'is_landing_page' => isset($is_landing_page)?$is_landing_page:0,
					'landing_page_url' => $this->input->post('landing_page_url',TRUE),
					'restaurant_demo' => $this->input->post('restaurant_demo',TRUE),
				);
				if($id==0){
					$insert = $this->admin_m->insert($data,'settings');
				}else{
					$insert = $this->admin_m->update($data,$id,'settings');
				}

				if($insert){
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/settings/landing_page'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/settings/landing_page'));
				}	
		}
	}

	public function add_home_banner(){
		is_test();
		$id = $this->input->post('id');
		if (!empty($_FILES['file']['name'])) {
	 		$up_load = $this->upload_m->upload(400);
		 	if($up_load['st']==1):
			 	foreach ($up_load['data'] as $key => $value) {
			 		$data = array(
			 			'home_banner' => $value['image'],
			 			'home_banner_thumb' => $value['thumb'],
			 		);
			 		
			 	}
			 	if($id !=0):
			 		$insert =$this->admin_m->update($data,$id,'settings');
				else:
				 	$insert =$this->admin_m->insert($data,'settings');
				endif;
			 else:
			 	$this->session->set_flashdata('success', $up_load['data']['error']);
			 endif;
		 	
		}
		if($insert){
			$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
			redirect(base_url('admin/settings/banner_settings'));
		}else{
			$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
			redirect(base_url('admin/settings/banner_settings'));
		}	
	}


	/**
	   *** add all home banners  
	**/ 

	public function add_section_banner(){
		is_test();
    	$id = $this->input->post('id');
		$this->form_validation->set_rules('section_name', 'Section name', 'trim|xss_clean|required');
		$this->form_validation->set_rules('heading', 'Section Heading', 'trim|xss_clean|required');
		$this->form_validation->set_rules('sub_heading', 'Sub Heading', 'trim|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/settings/banner_settings'));
			}else{	
				$section_name = $this->input->post('section_name',TRUE);

				$data = array(
					'section_name' => $section_name,
					'heading' => $this->input->post('heading',TRUE),
					'sub_heading' => $this->input->post('sub_heading',TRUE),
					'created_at' => d_time(),
				);

				
				if($id==0){
					$check = $this->admin_m->single_select_by_section_name($section_name);
					if(!empty($check)){
						$this->session->set_flashdata('error', ' Sorry! you already insert this section, Try with edit option');
						redirect(base_url('admin/settings/banner_settings'));
						exit();
					}else{
						$insert = $this->admin_m->insert($data,'section_banners');
					}
					
				}else{
					$insert = $this->admin_m->update($data,$id,'section_banners');
				}

				if($insert){
					$this->upload_banner($insert,$table='section_banners');
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/settings/banner_settings'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/settings/banner_settings'));
				}	
		}
	}


	/**===== Upload images dashboard ====**/
	public function upload_banner($id,$table){
		is_test();
		if (!empty($_FILES['file']['name'])) {
	 		$up_load = $this->upload_m->upload_banner('site_banners');
		 	if($up_load['st']==1):
			 	foreach ($up_load['data'] as $key => $value) {
			 		$data = array(
			 			'images' => $value['image'],
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
	  *** add setting
	**/ 
	public function add_settings(){
		is_test();
		$this->form_validation->set_rules('site_name', 'Site Name', 'trim|xss_clean|required');
		$this->form_validation->set_rules('language', 'Language', 'trim|xss_clean|required');
		$this->form_validation->set_rules('currency', 'Currencies', 'trim|xss_clean|required');
		$this->form_validation->set_rules('country_id', 'Country', 'trim|xss_clean|required');
		$this->form_validation->set_rules('long_description', 'Description', 'trim');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/settings/settings'));
			}else{

				$check = $this->isValidTimezone($this->input->post('time_zone',TRUE));

				if($check!=1):
					$this->session->set_flashdata('error','Timezone is not correct! try with valid timezone');
					redirect(base_url('admin/settings/settings'));
				else:	

				$data = array(
					'site_name' => $this->input->post('site_name',TRUE),
					'language' => $this->input->post('language',TRUE),
					'time_zone' => $this->input->post('time_zone',TRUE),
					'description' => $this->input->post('description',TRUE),
					'country_id' => $this->input->post('country_id',TRUE),
					'analytics' => $this->input->post('analytics'),
					'copyright' => $this->input->post('copyright',TRUE),
					'pricing_layout' => $this->input->post('pricing_layout',TRUE),
					'currency' => $this->input->post('currency',TRUE),
					'pixel_id' => $this->input->post('pixel_id',TRUE),
					'currency_position' => $this->input->post('currency_position',TRUE),
					'number_formats' => $this->input->post('number_formats',TRUE),
					'long_description' => $this->input->post('long_description'),
					'created_at' => d_time(),
					'invoice_config'=> json_encode(['tax_percent'=>$_POST['tax_percent'],'tax_number'=>$_POST['tax_number'],'company_details'=> trim($this->input->post('company_details'))]),
				);
				$id = $this->input->post('id',TRUE);

				if($id != 0):
					$insert = $this->admin_m->update($data,$id,'settings');
				else:
					$insert = $this->admin_m->insert($data,'settings');
				endif;

				if($insert){
					$this->upload_favicon($insert);
					$this->upload_logo($insert,'settings');

					$this->session->unset_userdata('site_lang');
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/settings/settings'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/settings/settings'));
				}	
			endif;
		}
	}

	/**
	  ** check valid timezone
	**/
	public function isValidTimezone($timezone) {
	    return in_array($timezone, timezone_identifiers_list());
	} 

	public function add_recaptcha(){
		is_test();
		$this->form_validation->set_rules('site_key', 'Site Key', 'trim|required|xss_clean|required');
		$this->form_validation->set_rules('secret_key', 'Secret Key', 'required|trim|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/settings/recaptcha_settings'));
			}else{	
				$recaptcha = array(
					'site_key' => $this->input->post('site_key',TRUE),
					'secret_key' => $this->input->post('secret_key',TRUE),
				);
				$data = array(
					'recaptcha_config' => json_encode($recaptcha),
					'is_recaptcha' => $this->input->post('is_recaptcha',TRUE)
				);
				$id = $this->input->post('id');
				if($id==0){
					$insert = $this->admin_m->insert($data,'settings');
				}else{
					$insert = $this->admin_m->update($data,$id,'settings');
				}

				if($insert){
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/settings/recaptcha_settings'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/settings/recaptcha_settings'));
				}	
		}
	}

	/**
	  *** add setting
	**/ 
	public function add_email_settings(){
		is_test();
		$this->form_validation->set_rules('smtp_mail', 'SMTP Email', 'required|trim|xss_clean|valid_email');
		
		$setting = settings();
		
		if(isset($setting['email_type']) && $setting['email_type'] ==2 || $this->input->post('email_type',TRUE)==2){
			$this->form_validation->set_rules('smtp_port', 'SMTP PORT', 'trim|required|xss_clean|numeric');
			$this->form_validation->set_rules('smtp_host', 'SMTP HOST', 'trim|required|xss_clean');
			$this->form_validation->set_rules('smtp_password', 'SMTP Email Password', 'trim|required|xss_clean');
		}

		if(isset($setting['email_type']) && $setting['email_type'] ==3 || $this->input->post('email_type',TRUE)==3){
			$this->form_validation->set_rules('sendgrid_api_key', 'SendGrid API Key', 'trim|required|xss_clean');
		}


		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/settings/email_settings'));
			}else{	

				$subject = array(
					'registration' => $this->input->post('registration',TRUE),
					'payment' => $this->input->post('payment',TRUE),
					'recovery' => $this->input->post('recovery',TRUE),
				);
				$smtp = array(
					'smtp_host' => $this->input->post('smtp_host'),
					'smtp_port' => $this->input->post('smtp_port'),
					'smtp_password' => base64_encode($this->input->post('smtp_password')),
				);
				
				$data = array(
					'subjects' => json_encode($subject),
					'smtp_config' => json_encode($smtp),
					'smtp_mail' => $this->input->post('smtp_mail',TRUE),
					'email_type' => $this->input->post('email_type',TRUE),
					'sendgrid_api_key' => $this->input->post('sendgrid_api_key',TRUE),
					'created_at' => d_time(),
				);
				$id = $this->input->post('id',TRUE);

				if($id != 0):
					$insert = $this->admin_m->update($data,$id,'settings');
				else:
					$insert = $this->admin_m->insert($data,'settings');
				endif;

				if($insert){
					$this->session->set_flashdata('success',!empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/settings/email_settings'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/settings/email_settings'));
				}	
		}
	}


	public function add_payment_settings(){
		is_test();
		$setting = settings();
		
		$this->form_validation->set_rules('paypal_email', 'Paypal Email', 'trim|xss_clean');

		$this->form_validation->set_rules('public_key', 'Stripe Public Key', 'trim|xss_clean');
		$this->form_validation->set_rules('secret_key', 'Stripe Secret Key', 'trim|xss_clean');

		$this->form_validation->set_rules('razorpay_key', 'Razorpay Keys', 'trim|xss_clean');
		$this->form_validation->set_rules('razorpay_key_id', 'Razorpay Key ID', 'trim|xss_clean');
	

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/settings/payment_settings'));
			}else{	

				$id = $this->input->post('id',TRUE);

				$stripe = array(
					'public_key' => $this->input->post('public_key',TRUE),
					'secret_key' => $this->input->post('secret_key',TRUE),
				);

				$paypal = array(
					'paypal_email' => $this->input->post('paypal_email',TRUE),
					'is_live' => $this->input->post('is_live',TRUE)!=1?0:1,
				);
				$mercado = array(
					'mercado_public_key' => $this->input->post('mercado_public_key',TRUE),
					'access_token' => $this->input->post('access_token',TRUE),
				);
				$paytm = array(
					'merchant_key' => $this->input->post('merchant_key',TRUE),
					'merchant_id' => $this->input->post('merchant_id',TRUE),
					'is_paytm_live' => $this->input->post('is_paytm_live',TRUE)!=1?0:1,
				);


				$flutterwave = array(
					'fw_public_key' => $this->input->post('fw_public_key',TRUE),
					'fw_secret_key' => $this->input->post('fw_secret_key',TRUE),
					'is_flutterwave_live' => $this->input->post('is_flutterwave_live',TRUE)!=1?0:1,
					'encryption_key' => $this->input->post('encryption_key',TRUE),
				);
				
				$fpx = array(
					'fpx_public_key' => $this->input->post('fpx_public_key',TRUE),
					'fpx_secret_key' => $this->input->post('fpx_secret_key',TRUE),
				);

				$paystack = array(
					'paystack_public_key' => $this->input->post('paystack_public_key',TRUE),
					'paystack_secret_key' => $this->input->post('paystack_secret_key',TRUE),
				);

				$pagadito = array(
					'is_pagadito_live' => isset($_POST['is_pagadito_live'])?$_POST['is_pagadito_live']:0,
					'pagadito_uid' => $this->input->post('pagadito_uid',TRUE),
					'pagadito_wsk_key' => $this->input->post('pagadito_wsk_key',TRUE),
				);

				$netseasy = array(
					'is_netseasy_live' => isset($_POST['is_netseasy_live'])?$_POST['is_netseasy_live']:0,
					'netseasy_merchant_id' => $this->input->post('netseasy_merchant_id',TRUE),
					'netseasy_secret_key' => $this->input->post('netseasy_secret_key',TRUE),
					'netseasy_checkout_key' => $this->input->post('netseasy_checkout_key',TRUE),
				);

				$offline = array(
					'offline_details' => $this->input->post('offline_details'),
					'is_transaction_field' => isset($_POST['is_transaction_field'])?1:0,
				);

				if(check()==1):
					$data = array(
						'is_paypal' => $this->input->post('is_paypal',TRUE)!=1?0:1,
						'is_stripe' => $this->input->post('is_stripe',TRUE)!=1?0:1,
						'is_razorpay' => $this->input->post('is_razorpay',TRUE)!=1?0:1,
						'razorpay_key' => $this->input->post('razorpay_key',TRUE),
						'razorpay_key_id' => $this->input->post('razorpay_key_id',TRUE),

						'is_paytm' => $this->input->post('is_paytm',TRUE)!=1?0:1,
						'is_flutterwave' => $this->input->post('is_flutterwave',TRUE)!=1?0:1,
						'is_fpx' => $this->input->post('is_fpx',TRUE)!=1?0:1,
						'is_mercado' => $this->input->post('is_mercado',TRUE)!=1?0:1,
						'is_paystack' => $this->input->post('is_paystack',TRUE)!=1?0:1,
						'is_offline' => $this->input->post('is_offline',TRUE)!=1?0:1,
						'is_pagadito' => $this->input->post('is_pagadito',TRUE)!=1?0:1,
						'is_netseasy' => $this->input->post('is_netseasy',TRUE)!=1?0:1,

						'mercado_config' => json_encode($mercado),
						'stripe_config' => json_encode($stripe),
						'paypal_config' => json_encode($paypal),
						'paytm_config' => json_encode($paytm),
						'flutterwave_config' => json_encode($flutterwave),
						'fpx_config' => json_encode($fpx),
						'paystack_config' => json_encode($paystack),
						'offline_config' => json_encode($offline),
						'pagadito_config' => json_encode($pagadito),
						'netseasy_config' => json_encode($netseasy),
					);
				else:
					$data = array(
						'is_paypal' => $this->input->post('is_paypal',TRUE)!=1?0:1,
						'is_stripe' => $this->input->post('is_stripe',TRUE)!=1?0:1,
						'is_razorpay' => $this->input->post('is_razorpay',TRUE)!=1?0:1,
						'razorpay_key' => $this->input->post('razorpay_key',TRUE),
						'razorpay_key_id' => $this->input->post('razorpay_key_id',TRUE),
						'stripe_config' => json_encode($stripe),
						'paypal_config' => json_encode($paypal),

					);

				endif;
				

				if($id != 0):
					$insert = $this->admin_m->update($data,$id,'settings');
				else:
					$insert = $this->admin_m->insert($data,'settings');
				endif;

				if($insert){
					$this->session->set_flashdata('success',!empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/settings/payment_settings'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/settings/payment_settings'));
				}	
		}
	}


	public function install_payment($field,$status){
		$settings = settings();
		$data = [$field => $status];
		$this->admin_m->update($data,$settings['id'],'settings');
		$this->session->set_flashdata('success',!empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
		redirect(base_url('admin/settings/payment_settings'));
	}

	public function payment_action($id,$status){
		$data = ['status' => $status];
		$this->admin_m->update($data,$id,'payment_method_list');
		$this->session->set_flashdata('success',!empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
		redirect(base_url('admin/settings/payment_settings'));
	}

/**
   ** upload favicon
 **/ 
	public function upload_favicon($id)
	{
		is_test();

		if(!empty($_FILES['favicon']['name'])){

			$dir = "uploads/site_images/";
			$name = $_FILES['favicon']['name'];
			list($txt, $ext) = explode(".", $name);
			$image_name = md5(time()).".".$ext;
			$tmp = $_FILES['favicon']['tmp_name'];
		   if(move_uploaded_file($tmp, $dir.$image_name)){
			    $url = $dir.$image_name;
			    $data = array('favicon' => $url);
				$this->admin_m->update($data,$id,'settings');	
		   }else{
		      echo "image uploading failed";
		   }
		}

	}

	public function upload_logo($id=0, $table=0)
	{
		is_test();
		
		if(!empty($_FILES['images']['name'])){
			$directory = 'uploads/site_images/';
			$dir = $directory;
			$name = $_FILES['images']['name'];
			list($txt, $ext) = explode(".", $name);
			$image_name = md5(time()).".".$ext;
			$tmp = $_FILES['images']['tmp_name'];
		   if(move_uploaded_file($tmp, $dir.$image_name)){
			    $url = $dir.$image_name;
			    $data = array('logo' => $url);
				$this->admin_m->update($data,$id,$table);	
		   }else{
		      echo "image uploading failed";
		   }
		}

	}


public function enable_extras($id,$type,$status)
{
    $data = array(
    	$type => $status
    );

    $this->admin_m->update_by_user_id($data,$id,'restaurant_list');
    $this->session->set_flashdata('success',!empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
    redirect(base_url('admin/dashboard/total_users'));
}

public function pwa_config()
{
	$data = array();
	$data['page_title'] = "PWA Config";
	$data['page'] = "PWA";
	$data['settings'] = $this->admin_m->get_settings();
	$data['main_content'] = $this->load->view('backend/settings/pwa', $data, TRUE);
	$this->load->view('backend/index',$data);

	$file = base_url('uploads/pwa/logo.png');
	$filePath = 'assets/frontend/images/logo.jpg';
	/* Store the path of destination file */
	$destinationFilePath = 'uploads/pwa/logo.png';
	if (!file_exists($file)) {
		copy($filePath, $destinationFilePath);
	}
}

public function add_pwa(){
	is_test();
	if(check() !=1):
		exit();
	endif;
	$id = $this->input->post('id');
	$this->form_validation->set_rules('title', 'Title', 'trim|xss_clean|required');
	$this->form_validation->set_rules('theme_color', 'Theme Color', 'trim|xss_clean');
	$this->form_validation->set_rules('background_color', 'background Color', 'trim|xss_clean');
	if ($this->form_validation->run() == FALSE) {
		$this->session->set_flashdata('error', validation_errors());
		redirect(base_url('admin/settings/pwa_config/'));
	}else{	
		$logo = $this->upload_pwa_logo();
		$is_pwa_active = $this->input->post('is_pwa_active');
		$old_img = $this->input->post('old_img');
		$pwaData = array(
			'title' => $this->input->post('title',TRUE),
			'theme_color' => substr($this->input->post('theme_color',TRUE),1),
			'background_color' => substr($this->input->post('background_color',TRUE),1),
			'is_pwa_active' => isset($is_pwa_active)?$is_pwa_active :0,
			'logo' => !empty($logo)?$logo:$old_img,
		);

		$data = array(
			'pwa_config' => json_encode(xs_clean($pwaData)),
		);


		if($id==0){
			$insert = $this->admin_m->insert($data,'settings');
		}else{
			$insert = $this->admin_m->update($data,$id,'settings');
		}

		if($insert){
			$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
			redirect(base_url('admin/settings/pwa_config'));
		}else{
			$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
			redirect(base_url('admin/settings/pwa_config'));
		}	
	}
}


public function upload_pwa_logo()
{

	if(!empty($_FILES['images']['name'])){
		$directory = 'uploads/pwa/';
		$dir = $directory;
		$name = $_FILES['images']['name'];
		list($txt, $ext) = explode(".", $name);
		$image_name = md5(time()).".".$ext;
		$tmp = $_FILES['images']['tmp_name'];
		if(move_uploaded_file($tmp, $dir.$image_name)){
			$url = $dir.$image_name;
			$data = array('logo' => $url);
			return $url;
		}else{
			echo "image uploading failed";
		}
	}

}

	public function notification()
	{
		$data = array();
		$data['page_title'] = "Notification";
        $data['page'] = "Settings";
        $data['settings']=$this->admin_m->single_select('settings');
		$data['main_content'] = $this->load->view('backend/settings/notification', $data, TRUE);
		$this->load->view('backend/index',$data);
	}


	

	public function add_notification(){
		is_test();
		$this->form_validation->set_rules('onsignal_app_id', 'onsignal_app_id', 'trim|xss_clean');
		$this->form_validation->set_rules('user_auth_key', 'user_auth_key', 'trim|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}else{	
			$is_onsignal_active = $this->input->post('is_active_onsignal',TRUE);
			$onsignal = array(
				'onsignal_app_id' => $this->input->post('onsignal_app_id',TRUE),
				'user_auth_key' => $this->input->post('user_auth_key',TRUE),
				'is_active_onsignal' => isset($is_onsignal_active)?$is_onsignal_active:0,
			);
			$data = array(
				'notifications' => json_encode(xs_clean($onsignal)),
			);
			$id = $this->input->post('id');
			if($id==0){
				$insert = $this->admin_m->insert($data,'settings');
			}else{
				$insert = $this->admin_m->update($data,$id,'settings');
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


	public function appearance()
	{
		$data = array();
		$data['page_title'] = "Appearance";
        $data['page'] = "Settings";
        $data['settings']=$this->admin_m->single_select('settings');
		$data['main_content'] = $this->load->view('backend/settings/appearance', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function add_appearance(){
		$this->form_validation->set_rules('site_color', 'Frontend Color', 'required|trim|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}else{	
			
			$data = array(
				'site_color' => substr($this->input->post('site_color',TRUE),1),
				'site_theme' => isset($_POST['site_theme'])?$_POST['site_theme']:1,
			);
			
			$id = $this->input->post('id');
			if($id==0){
				$insert = $this->admin_m->insert($data,'settings');
			}else{
				$insert = $this->admin_m->update($data,$id,'settings');
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


	public function app_info()
	{
		$data = array();
		$data['page_title'] = "App Info";
        $data['page'] = "Auth";
        $data['settings']=$this->admin_m->single_select('settings');
		$data['main_content'] = $this->load->view('backend/settings/app_info', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function pusher()
	{
		$data = array();
		$data['page_title'] = "Pusher";
        $data['page'] = "Auth";
        $data['settings']=$this->admin_m->single_select('settings');
		$data['main_content'] = $this->load->view('backend/settings/pusher', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function add_pusher(){
		is_test();
		$this->form_validation->set_rules('app_id', 'APP ID', 'required|trim|xss_clean');
		$this->form_validation->set_rules('auth_key', 'Auth key', 'required|trim|xss_clean');
		$this->form_validation->set_rules('secret', 'Secret', 'required|trim|xss_clean');
		$this->form_validation->set_rules('cluster', 'Cluster', 'required|trim|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}else{	
			
			$pdata = array(
				'app_id' => $this->input->post('app_id',TRUE),
				'auth_key' => $this->input->post('auth_key',TRUE),
				'secret' => $this->input->post('secret',TRUE),
				'cluster' => $this->input->post('cluster',TRUE),
				'status' => $this->input->post('status',TRUE),
			);

			$data = ['pusher_config'=>json_encode($pdata)];

			
			$id = $this->input->post('id');
			if($id==0){
				$insert = $this->admin_m->insert($data,'settings');
			}else{
				$insert = $this->admin_m->update($data,$id,'settings');
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


	public function add_email_content(){
		is_test();
    	$id = $this->input->post('id');
		$this->form_validation->set_rules('subject[]', lang("subject"), 'trim');
		$this->form_validation->set_rules('message[]', lang("message"), 'trim');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
			}else{	
				$data = [];
				foreach($_POST['message'] as $key=> $value):
					$data[$key] = [
						 'subject'=> $_POST['subject'][$key],
						 'message'=> $value,
					];
				endforeach;
				$insert = $this->admin_m->update(['email_template_config'=>json_encode(xs_clean($data))],$this->settings['id'],'settings');

				if($insert){
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect($_SERVER['HTTP_REFERER']);
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect($_SERVER['HTTP_REFERER']);
				}	
		}
	}




}
