<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Twilio\Rest\Client;
class Restaurant extends MY_Controller {

	public function __construct(){
		parent::__construct();
		is_login();
		check_valid_user();
		$this->per_page = 14;
		$this->load->library('pagination');
	}

	public function restaurant($user_id){

		$data = array();
		$data['page_title'] = "Profile";
		$data['page'] = "Auth";
		$data['user_id'] = $user_id;
		$data['countries'] = $this->admin_m->select('country');
		$data['auth_info'] = $this->admin_m->get_auth_profile_info_md5($user_id);
		$data['restaurant'] = $this->admin_m->get_my_restaurant($user_id);
		$data['main_content'] = $this->load->view('backend/common/profile', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function create_restaurant()
	{
		is_test();
	$id =  $this->input->post('id',true);
	
	$this->form_validation->set_rules('name', 'name', 'trim|xss_clean');
	$this->form_validation->set_rules('short_name', 'Short Name', 'trim|xss_clean');
	$this->form_validation->set_rules('location', 'location', 'trim|xss_clean|required');
	$this->form_validation->set_rules('slogan', 'Slogan', 'trim|xss_clean|required');
	$this->form_validation->set_rules('address', 'Address', 'trim|xss_clean');
	$this->form_validation->set_rules('about_short', 'Short About', 'trim|required|xss_clean|max_length[250]');
	$this->form_validation->set_rules('about', 'About', 'trim');
	$this->form_validation->set_rules('pixel_id', 'Pixel Id', 'trim|xss_clean');
	$this->form_validation->set_rules('analytics_id', 'Analytics ID', 'trim|xss_clean');
	if ($this->form_validation->run() == FALSE) {
		$this->session->set_flashdata('error', validation_errors());
		redirect($_SERVER['HTTP_REFERER']);
	}else{	
		if(!empty(restaurant()->shop_id)):
			$shop_id = restaurant()->shop_id;
		else:
			$shop_id = random_string('alnum',6);
		endif;


		$check = $this->isValidTimezone($this->input->post('time_zone',TRUE));

		if($check!=1):
			$this->session->set_flashdata('error','Timezone is not correct! try with valid timezone');
			redirect(base_url('admin/settings/settings'));
		endif;
		
		$data = array(
			'user_id' =>auth('id'),
			'shop_id' =>$shop_id,
			'username' => $this->input->post('username',TRUE),
			'name' => $this->input->post('name',TRUE),
			'location' => $this->input->post('location',TRUE),
			'address' => $this->input->post('address',TRUE),
			'slogan' => $this->input->post('slogan',TRUE),
			'about_short' => $this->input->post('about_short',TRUE),
			'about' => $this->input->post('about'),
			'time_zone' => $this->input->post('time_zone',TRUE),
			'created_at' => d_time(),
		);

		if($id !=0){
			$insert = $this->admin_m->update($data,$id,'restaurant_list');
		}else{
			$insert = $this->admin_m->insert($data,'restaurant_list');
		}
		
		if($insert){
			$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
			redirect(base_url('admin/restaurant/general'));
		}else{
			$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
			redirect(base_url('admin/restaurant/general'));
		}	
	}
}


public function isValidTimezone($timezone) {
	return in_array($timezone, timezone_identifiers_list());
} 


public function add_profile(){
	is_test();
	$this->form_validation->set_rules('about_short', 'Short About', 'trim|required|xss_clean|max_length[250]');
	if ($this->form_validation->run() == FALSE) {
		$this->session->set_flashdata('error', validation_errors());
		redirect(base_url('admin/restaurant/profile/'));
		}else{

			$social_data = array(
				'whatsapp' => $this->input->post('whatsapp',true),
				'facebook' => $this->input->post('facebook',true),
				'instagram' => $this->input->post('instagram',true),
				'twitter' => $this->input->post('twitter',true),
				'youtube' => $this->input->post('youtube',true),
				'website' => $this->input->post('website',true),

			);	

			$data = array(
				'user_id' => auth('id'),
				'social_list' => json_encode($social_data),
				'about' => $this->input->post('about'),
				'about_short' => $this->input->post('about_short',TRUE),
			);
			$id = $this->input->post('id');
			if($id==0){
				$insert = $this->admin_m->insert($data,'restaurant_list');
			}else{
				$insert = $this->admin_m->update($data,$id,'restaurant_list');
			}

			if($insert){
				$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
				redirect(base_url('admin/restaurant/profile'));
			}else{
				$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
				redirect(base_url('admin/restaurant/profile'));
			}	
	}
}


public function add_restaurant_config()
{
		is_test();
	$id =  $this->input->post('id',true);
	if(restaurant()->phone == $this->input->post('phone')){
		$this->form_validation->set_rules('phone', 'phone', 'trim|xss_clean');
	}else{
		$this->form_validation->set_rules('phone', 'phone', 'trim|xss_clean|required|is_unique[restaurant_list.phone]',array('is_unique'=>'Sorry This Phone already exits'));
	}
	$this->form_validation->set_rules('email', 'Email', 'trim|xss_clean|valid_email');
	$this->form_validation->set_rules('country', 'Country', 'trim|required|xss_clean');
	$this->form_validation->set_rules('currency', 'Currency', 'trim|required|xss_clean');
	$this->form_validation->set_rules('dial_code', 'Dial Code', 'trim|required|xss_clean');
	if ($this->form_validation->run() == FALSE) {
		$this->session->set_flashdata('error', validation_errors());
		redirect($_SERVER['HTTP_REFERER']);
	}else{	
		if(!empty(restaurant()->shop_id)):
			$shop_id = restaurant()->shop_id;
		else:
			$shop_id = random_string('alnum',6);
		endif;
		$currency = $this->input->post('currency',TRUE);
		$currency_icon = single_select_by_id($currency,'country');


		$social_data = array(
			'whatsapp' => $this->input->post('whatsapp',true),
			'facebook' => $this->input->post('facebook',true),
			'instagram' => $this->input->post('instagram',true),
			'twitter' => $this->input->post('twitter',true),
			'youtube' => $this->input->post('youtube',true),
			'website' => $this->input->post('website',true),

		);	

		$number_formats = $this->input->post('number_formats',TRUE);
		$currency_position = $this->input->post('currency_position',TRUE);
		$date_format = $this->input->post('date_format',TRUE);
		$time_format = $this->input->post('time_format',TRUE);

		$data = array(
			'user_id' =>auth('id'),
			'shop_id' =>$shop_id,
			'phone' => $this->input->post('phone',TRUE),
			'email' => $this->input->post('email',TRUE),
			'country_id' => $this->input->post('country',TRUE),
			'currency_code' => $currency_icon['currency_code'],
			'icon' => $currency_icon['currency_symbol'],
			'dial_code' => $this->input->post('dial_code',TRUE),
			'social_list' => json_encode($social_data),
			'number_formats' => isset($number_formats)?$number_formats:0,
			'currency_position' => isset($currency_position)?$currency_position:0,
			'date_format' => isset($date_format)?$date_format:0,
			'time_format' => isset($time_format)?$time_format:0,
			'created_at' => d_time(),
		);


		if($id !=0){
			$insert = $this->admin_m->update($data,$id,'restaurant_list');
		}else{
			$insert = $this->admin_m->insert($data,'restaurant_list');
		}
		
		if($insert){
			$settings = $this->admin_m->get_user_settings(auth('id'));
			if(empty($settings)):
				$this->admin_m->insert(['user_id' => auth('id'),'smtp_mail' =>$this->input->post('email',TRUE)],'user_settings');
			endif;
			$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
			redirect(base_url('admin/restaurant/profile'));
		}else{
			$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
			redirect(base_url('admin/restaurant/'.md5(auth('id'))));
		}	
	}
}

public function add_cover(){
	is_test();
	$id = $this->input->post('id');
	$insert = $this->upload_cover_img($id,'restaurant_list');

	if($insert){
		$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
		redirect($this->agent->referrer());
	}else{
		$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
		redirect($this->agent->referrer());
	}
}


/**===== Upload images dashboard ====**/
	public function upload_cover_img($id,$table){
		is_test();
		if (!empty($_FILES['file']['name'])) {
	 		$up_load = $this->upload_m->upload_banner();
		 	if($up_load['st']==1):
			 	foreach ($up_load['data'] as $key => $value) {
			 		$data = array(
			 			'cover_photo' => $value['image'],
			 			'cover_photo_thumb' => $value['image'],
			 		);
			 		$this->admin_m->update($data,$id,$table);
			 		return true;
			 	}
			 	
			 else:
			 	$this->session->set_flashdata('success', $up_load['data']['error']);
			 endif;
		 	
		}
	}


/**===== Upload images dashboard ====**/
public function upload_img($id,$table){
	is_test();
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



public function reservation($shop_id){

	$data = array();
	$data['page_title'] = "Available Days";
	$data['page'] = "Profile";
	$data['data'] = false;
	$data['shop_id'] = $shop_id;
	$data['restaurant'] = $this->admin_m->get_shop_profile_md5($shop_id);
	$data['auth_info'] = $this->admin_m->get_user_info_by_shop_id($shop_id);

	$data['reservation_type_list'] = $this->admin_m->get_by_shop_user_id($data['restaurant']['id'],'reservation_types');

	$data['main_content'] = $this->load->view('backend/restaurant/reservation', $data, TRUE);
	$this->load->view('backend/index',$data);
}

public function edit_reservation_types($shop_id,$id){

	$data = array();
	$data['page_title'] = "Available Days";
	$data['page'] = "Profile";
	$data['shop_id'] = $shop_id;
	$data['restaurant'] = $this->admin_m->get_shop_profile_md5($shop_id);
	$data['auth_info'] = $this->admin_m->get_user_info_by_shop_id($shop_id);
	$data['data'] = $this->admin_m->single_select_by_id($id,'reservation_types');
	$data['reservation_type_list'] = $this->admin_m->get_by_shop_user_id($data['restaurant']['id'],'reservation_types');

	$data['main_content'] = $this->load->view('backend/restaurant/reservation', $data, TRUE);
	$this->load->view('backend/index',$data);
}

public function add_reservation($shop_id){
	is_test();
	$this->form_validation->set_rules('days[]', 'Days', 'trim|required|xss_clean');
	$this->form_validation->set_rules('start_time[]', 'Start Time', 'trim|required|xss_clean');
	$this->form_validation->set_rules('end_time[]', 'End Time', 'trim|required|xss_clean');
	if ($this->form_validation->run() == FALSE) {
		$this->session->set_flashdata('error', validation_errors());
		redirect(base_url('admin/restaurant/reservation/'.$shop_id));
	}else{	
		 $this->admin_m->delete_appointment('reservation_date');
		$days = $this->input->post('days');
		
		if(!empty($days)):
			$i=1;
			foreach ($days as $key => $day):
				$data = array(
					'days' => $day,
					'start_time' => $this->input->post('start_time',true)[$day],
					'end_time' => $this->input->post('end_time',true)[$day],
					'is_24' => isset($_POST['is_24'][$day])?$_POST['is_24'][$day]:0,
					'user_id' => auth('id'),
					'shop_id' => shop_id(),
					'created_at' => d_time(),
				);
				 $insert = $this->admin_m->insert($data,'reservation_date');
			$i++;
			endforeach;
		endif;

		if(isset($_GET['q']) && $_GET['q']=='create_profile' && !empty(auth('profile'))):
			$auth = auth('profile');
			$users = [
				'country' => $auth->country_id,
				'dial_code' => $auth->dial_code,
				'phone' => $auth->phone,
				'address' => $auth->billing_address,
			];

			$restaurant = [
				'currency_code' => $auth->currency_code,
				'dial_code' => $auth->dial_code,
				'country_id' => $auth->country_id,
				'icon' => $auth->icon,
				'email' => $auth->email,
				'phone' => $auth->restaurant_phone,
			];
			$this->admin_m->update($users,auth('id'),'users');
			$this->admin_m->update($restaurant,restaurant()->id,'restaurant_list');

		endif;
		
		if($insert){
			if(isset($_GET['q']) && $_GET['q']=='create_profile' && !empty(auth('profile'))):
				$this->session->unset_userdata('profile');
				redirect(base_url('dashboard'));
			endif;
			$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
			redirect(base_url('admin/restaurant/reservation/'.$shop_id));
		}else{
			$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
			redirect(base_url('admin/restaurant/reservation/'.$shop_id));
		}	
	}
}

public function add_order_configuration(){
	is_test();
	$this->form_validation->set_rules('is_payment[]', 'Enable Payment', 'trim|xss_clean');
	if ($this->form_validation->run() == FALSE) {
		$this->session->set_flashdata('error', validation_errors());
		redirect(base_url('admin/auth/order_type_config'));
	}else{	
		$is_payment = $this->input->post('is_payment');
		$is_required = $this->input->post('is_required');
		$ids = $this->input->post('ids');
			$i=1;
			foreach ($ids as $key => $payment):
				if(isset($is_payment[$payment]) && $is_payment[$payment] == $payment):
					$data = array(
						'is_payment' => 1,
					);
					$insert = $this->admin_m->update($data,$payment,'users_active_order_types');
				else:
					$data = array(
						'is_payment' => 0,
					);
					$insert = $this->admin_m->update($data,$payment,'users_active_order_types');
				endif;

				if(isset($is_required[$payment]) && $is_required[$payment] == $payment):
					$data = array(
						'is_required' => 1,
					);
					$insert = $this->admin_m->update($data,$payment,'users_active_order_types');
				else:
					$data = array(
						'is_required' => 0,
					);
					$insert = $this->admin_m->update($data,$payment,'users_active_order_types');
				endif;
				
				 
			$i++;
			endforeach;		
		if($insert){
			$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
			redirect(base_url('admin/auth/order_type_config'));
		}else{
			$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
			redirect(base_url('admin/auth/order_type_config'));
		}	
	}
}



public function pickup_points($shop_id){

	$data = array();
	$data['page_title'] = "Pickup Points";
	$data['page'] = "Profile";
	$data['data'] = false;
	$data['shop_id'] = $shop_id;
	$data['restaurant'] = $this->admin_m->get_shop_profile_md5($shop_id);
	$data['auth_info'] = $this->admin_m->get_user_info_by_shop_id($shop_id);

	$data['pickup_points'] = $this->admin_m->get_by_shop_user_id($data['restaurant']['id'],'pickup_points_area');

	$data['main_content'] = $this->load->view('backend/restaurant/pickup_points', $data, TRUE);
	$this->load->view('backend/index',$data);
}


public function add_pickup_points($shop_id){
	is_test();
	$name_ex = $this->input->post('name_ex',true);
	if(!empty($name_ex)):
		$this->form_validation->set_rules('name_ex[]', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('latitude_ex[]', 'latitude', 'trim|required|xss_clean');
		$this->form_validation->set_rules('longitude_ex[]', 'longidute', 'trim|required|xss_clean');
		$this->form_validation->set_rules('address_ex[]', 'address', 'trim|required|xss_clean');
	else:
		$this->form_validation->set_rules('name[]', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('latitude[]', 'latitude', 'trim|required|xss_clean');
		$this->form_validation->set_rules('longitude[]', 'longidute', 'trim|required|xss_clean');
		$this->form_validation->set_rules('address[]', 'address', 'trim|required|xss_clean');
	endif;

	if ($this->form_validation->run() == FALSE) {
		$this->session->set_flashdata('error', validation_errors());
		redirect(base_url('admin/restaurant/pickup_points/'.$shop_id));
	}else{	

		$name = $this->input->post('name',true);
		
		if(!empty($name)):
			$i=1;
			foreach ($name as $key => $value):
				$data = array(
					'name' => $value,
					'latitude' => $this->input->post('latitude',true)[$key],
					'longitude' => $this->input->post('longitude',true)[$key],
					'address' => $this->input->post('address',true)[$key],
					'user_id' => auth('id'),
					'shop_id' => shop_id(),
					'created_at' => d_time(),
				);
				$insert = $this->admin_m->insert($data,'pickup_points_area');
			$i++;
			endforeach;
		endif;


		$name_ex = $this->input->post('name_ex',true);
		if(!empty($name_ex)){
			$j=0;	
			foreach ($name_ex as $key => $value_ex) {
				$data_ex = array(
					'name' => $value_ex,
					'latitude' => $this->input->post('latitude_ex',true)[$key],
					'longitude' => $this->input->post('longitude_ex',true)[$key],
					'address' => $this->input->post('address_ex',true)[$key],
					'user_id' => auth('id'),
					'shop_id' => shop_id(),
					'created_at' => d_time(),
				);
				$insert = $this->admin_m->update($data_ex,$this->input->post('ex_id')[$j],'pickup_points_area');
				$j++;
			}
		}


		
		if($insert){
			$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
			redirect(base_url('admin/restaurant/pickup_points/'.$shop_id));
		}else{
			$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
			redirect(base_url('admin/restaurant/pickup_points/'.$shop_id));
		}	
	}
}

public function add_reservation_type($shop_id){
	is_test();
	$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
	if ($this->form_validation->run() == FALSE) {
		$this->session->set_flashdata('error', validation_errors());
		redirect(base_url('admin/restaurant/reservation/'.$shop_id));
	}else{	
		
		$data = array(
			'name' => $this->input->post('name',true),
			'user_id' => auth('id'),
			'shop_id' => restaurant()->id,
			'created_at' => c_time(),
		);

		$id = $this->input->post('id',true);
		if(isset($id) & $id !=0):
			$insert = $this->admin_m->update($data,$id,'reservation_types');
		else:
			$insert = $this->admin_m->insert($data,'reservation_types');
		endif;
				
		
		
		if($insert){
			$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
			redirect(base_url('admin/restaurant/reservation/'.$shop_id));
		}else{
			$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
			redirect(base_url('admin/restaurant/reservation/'.$shop_id));
		}	
	}
}

public function todays_reservation()
{
	$data = array();
	$data['page_title'] = "Reservation List";
    $data['page'] = "Reservation List";
    $data['page_type'] = "Today";
    $data['data'] = false;
    $data['order_list'] = $this->admin_m->get_my_today_reservation_list_by_id(restaurant()->id);
	$data['main_content'] = $this->load->view('backend/restaurant/reservation_list', $data, TRUE);
	$this->load->view('backend/index',$data);
}


public function reservation_list()
{
	$data = array();
	$data['page_title'] = "Reservation List";
    $data['page'] = "Reservation List";
    $data['page_type'] = "All";
    $data['data'] = false;
    $data['order_list'] = $this->admin_m->get_my_reservation_list_by_id(restaurant()->id);
	$data['main_content'] = $this->load->view('backend/restaurant/reservation_list', $data, TRUE);
	$this->load->view('backend/index',$data);
}


public function call_waiter()
{
	$data = array();
	$data['page_title'] = "Call Waiter";
    $data['page'] = "Call Waiter";
    $data['page_type'] = "Today";
    $data['data'] = false;
    $data['order_list'] = $this->admin_m->get_my_today_call_waiter_list_by_id(restaurant()->id);
	$data['main_content'] = $this->load->view('backend/restaurant/call_waiter_list', $data, TRUE);
	$this->load->view('backend/index',$data);
}





/*----------------------------------------------
Order area
----------------------------------------------*/

public function todays_dine()
{
	redirect($_SERVER['HTTP_REFERER']);
	$data = array();
	$data['page_title'] = "Order List";
    $data['page'] = "Order";
    $data['data'] = false;
    $data['order_list'] = $this->admin_m->get_my_todays_dine(restaurant()->id);
	$data['main_content'] = $this->load->view('backend/order/todays_dine', $data, TRUE);
	$this->load->view('backend/index',$data);
}

public function order_list()
{
	$data = array();
	$data['page_title'] = "Order List";
    $data['page'] = "Order";
    $data['data'] = false;
    $data['is_filter'] = false;
    $this->load->library('pagination');
    $data['order_list'] = $this->admin_m->get_my_today_order_list_by_id(restaurant()->id);
	$data['main_content'] = $this->load->view('backend/order/order_list', $data, TRUE);
	$this->load->view('backend/index',$data);
}

public function update_order_list()
{
	$data = array();
	$data['is_filter'] = false;
	$data['hide'] = true;
    $data['order_list'] = $this->admin_m->get_my_today_order_list_by_id(restaurant()->id);
	$this->load->view('backend/order/order_list', $data);
	
}	


public function update_order_lists()
{
	$data = array();
	$data['is_filter'] = false;
	$data['hide'] = TRUE;
    $data['order_list'] = $this->admin_m->get_my_today_order_list_by_id(restaurant()->id);
	$load_data = $this->load->view('backend/order/order_list', $data, TRUE);
	echo json_encode(['st'=>1,'load_data'=>$load_data]);
	
}

public function new_order()
{
	$data = array();
	$data['is_filter'] = false;
	$data['hide'] = TRUE;
	$newOrder = $this->admin_m->get_todays_notify(restaurant()->id);
	if($newOrder > 0):
	    $data['order_list'] = $this->admin_m->get_my_today_order_list_by_id(restaurant()->id);
	    $load_data = $this->load->view('backend/order/order_list', $data, TRUE);
		echo json_encode(['st'=>1,'load_data'=>$load_data]);
	else:
		echo json_encode(['st'=>0,'load_data'=>'']);
	endif;
	
	
}	


public function get_item_list_by_order_id($id)
{
	$data = array();
	$data['page_title'] = "Order List";
    $data['page'] = "Order";
    $data['data'] = false;

    $config = [];
	$this->load->library('pagination');
	$per_page = $this->per_page;
	$total = $this->admin_m->get_all_items_for_order(0,0,$is_total=1);
	$config['base_url'] = base_url('admin/restaurant/ajax_pagination/'.$id);
	$config['total_rows'] = $total;
	$config['per_page'] =  $per_page;
	$this->pagination->initialize($config);



    $data['order_details'] = $this->admin_m->single_select_by_uid($id,'order_user_list');
    $data['item_list'] = $this->admin_m->get_item_list_by_order_id($id,restaurant()->id);

    $data['all_items'] = $this->admin_m->get_all_items_for_order($per_page,0,0);
    $data['settings'] = $this->admin_m->get_user_settings();
	$data['main_content'] = $this->load->view('backend/order/order_details', $data, TRUE);
	$this->load->view('backend/index',$data);
}


public function ajax_pagination($id){
	
	$data = array();
	$data['page_title'] = "Order List";
    $data['page'] = "Order";
    $data['data'] = false;


        //pagination
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

	$total = $this->admin_m->get_all_items_for_order(0,0,$is_total=1);
	$config['base_url'] = base_url('admin/restaurant/ajax_pagination/'.$id);
	$config['total_rows'] = $total;
	$config['per_page'] =  $per_page;
	$this->pagination->initialize($config);

	$data['order_details'] = $this->admin_m->single_select_by_uid($id,'order_user_list');
    $data['item_list'] = $this->admin_m->get_item_list_by_order_id($id,restaurant()->id);

	$data['all_items'] = $this->admin_m->get_all_items_for_order($per_page,$offset,0);

	$result = $this->load->view('backend/order/inc/item_modal_content', $data, TRUE);
	echo json_encode(array('st'=>1,'result'=>$result));




}



public function ajax_search($uid){
	$q = $this->input->post('qt');
	echo "<pre>";print_r($q);exit();
}





public function get_item_list_by_ajax_order_id($id)
{
	$data = array();
	$data['page_title'] = "Order List";
    $data['item_list'] = $this->admin_m->get_item_list_by_order_id($id,restaurant()->id);
	$load_view = $this->load->view('backend/order/order_ajax_view', $data, TRUE);
	echo json_encode(['st'=>1,'load_data'=>$load_view]);
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
	$data['info'] = $this->admin_m->single_select_by_id(auth('staff_id'),'staff_list');
	$data['order_info'] = $this->admin_m->single_select_by_uid($uid,'order_user_list');
	$data['item_list'] = $this->admin_m->get_customer_order_item_list($data['shop_id'],$uid);
	$data['main_content'] = $this->load->view('frontend/invoice/my_invoice', $data, TRUE);
	$this->load->view('frontend/invoice/index',$data);

}


public function all_order_list()
{
    //pagination
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

    $total = $this->admin_m->get_my_order_list_by_id(restaurant()->id,0,0,$is_total=1);
	$config['base_url'] = base_url('admin/restaurant/all_order_list');
	$config['total_rows'] = $total;
	$config['per_page'] =  $per_page;
    $this->pagination->initialize($config);


    $data = array();
	$data['page_title'] = "Order List";
    $data['page'] = "Order";
    $data['page_type'] = "restaurant";
    $data['is_filter'] = TRUE;
    $data['data'] = false;

    $data['order_list'] = $this->admin_m->get_my_order_list_by_id(restaurant()->id,$per_page,$offset,0);
	$data['main_content'] = $this->load->view('backend/order/order_list', $data, TRUE);
	$this->load->view('backend/index',$data);
}

protected function sendSMS($data) {
is_test();
	$sms = sms_settings(auth('id'));
          // Your Account SID and Auth Token from twilio.com/console
	$sid = $sms->account_sid;
	$token = $sms->auth_token;
	try {

		$twilio = new Client($sid, $token);

	 $message = $twilio->messages
	      ->create(
	      	$data['phone'], // to
	        array(
	          "from" => $sms->virtual_number,
	          "body" => $data['text']
	        )
	      );
		
		return $sms->account_sid;
	}catch (Exception $e) {
		
		return ['st'=>0,'msg'=>$e->getMessage()];
	}
}

public function order_status($id,$status)
{

	if($status==1 && restaurant()->es_time !=0):
		$id = $this->input->post('uid');
		$order_info =  $this->admin_m->single_select_by_uid($id,'order_user_list');
	elseif(strlen($id) > 9):
		$order_info =  $this->admin_m->single_select_by_uid($id,'order_user_list');
	else:
		$order_info =  single_select_by_id($id,'order_user_list');
	endif;

	$sms = sms_settings(auth('id'));

	if($status==1){

		
		if(restaurant()->es_time==0):
			$id =  $order_info['uid'];
			$time_data = array(
				'es_time' => '00:00',
				'time_slot' => '00:00',
				'is_preparing' => 0,
				'estimate_time' => '',
			);
		else:
			$id =  $this->input->post('uid');
			$time  = $this->input->post('es_time');
			$time_slot  = $this->input->post('time_slot');
			$time_data = array(
				'es_time' => $time,
				'time_slot' => $time_slot,
				'is_preparing' => 0,
				'estimate_time' => add_time($time,$time_slot),
			);
		endif;
		if(isset($sms->is_accept_sms) && $sms->is_accept_sms==1):
			$get_data = $this->get_msg($order_info);
			$data = ['phone' => $get_data['phone'], 'text' => create_msg($get_data['replace_data'],$get_data['accept_message'])];
			$send = $this->sendSMS($data);

			if(isset($send['st']) && $send['st']==0):
				$this->session->set_flashdata('error', $send['msg']);
			endif;
			
		endif;
		
		$this->admin_m->update_by_type($time_data,$id,$type='uid','order_user_list');

		$date = 'accept_time';
	}elseif($status==2){
		$this->order_completed($id,$order_info);
		$date = 'completed_time';
		$this->user_email_m->send_order_mail($order_info['uid'],2);
	}elseif($status==3){
		$date = 'cancel_time';
	}



	$data = array(
			'status' => $status,
			$date => d_time(),
		);
	$change = $this->admin_m->update_by_type($data,$id,$type='uid','order_user_list');
	$this->system_model->whatsapp_message($status,$order_info);
	if($change){
		redirect($_SERVER['HTTP_REFERER']);
	}
}



/*----------------------------------------------
  			Payment & Delivery status check	
----------------------------------------------*/
public function order_payment_status($id,$status)
{
	$order_info =  single_select_by_id($id,'order_user_list');

	if($status==1){
		$this->order_completed($order_info['uid'],$order_info);
		$data = [
			'status' => 2,
			'is_payment' =>1,
			'is_restaurant_payment' => 1,
			'payment_by' => 'restaurant',
			'accept_time' => d_time(),
			'completed_time' => d_time(),
		];

		$this->user_email_m->send_order_mail($order_info['uid'],2);
	}
	if($status == 2){
		$data = [
			'is_payment' =>1,
			'is_restaurant_payment' => 1,
			'payment_by' => 'restaurant',
		];
	}

	if($status ==3){
		$data = [
			'is_db_completed' =>1,
			'db_completed_by' => 'restaurant',
			'dboy_completed_time' => d_time(),
		];
	}
	$change = $this->admin_m->update($data,$id,'order_user_list');

	if($change){
		redirect($_SERVER['HTTP_REFERER']);
	}

}



protected function order_completed($id,$order_info)
{

	$sms = sms_settings(auth('id'));
	

	if(isset($sms->is_complete_sms) && $sms->is_complete_sms==1):
		$get_data = $this->get_msg($order_info);
		$complete_data = ['phone' => $get_data['phone'], 'text' => create_msg($get_data['replace_data'],$get_data['complete_message'])];
		$send = $this->sendSMS($complete_data);

		if(isset($send['st']) && $send['st']==0):
			$this->session->set_flashdata('error', $send['msg']);
		endif;
	endif;

	if($order_info['accept_time']=='0000-00-00 00:00:00' || empty($order_info['accept_time'])){
		$arr = array(
			'status' => 1,
			'accept_time' => d_time(),
		);
		$this->admin_m->update_by_type($arr,$id,$type='uid','order_user_list');
	}
}


// get msg
protected function get_msg($order_info){
	
	$sms = sms_settings(auth('id'));
	$phone = '+'.$order_info['phone'];

	$replace_data = array(
		'{USER_NAME}' => $order_info['name'],
		'{SHOP_NAME}' => restaurant()->username,
		'{ORDER_ID}' => $order_info['uid'],
	);
	$accept_message = json_decode($sms->accept_msg);
	$complete_message = json_decode($sms->complete_msg);

	return ['accept_message'=>$accept_message, 'complete_message'=>$complete_message,'replace_data'=>$replace_data,'phone'=>$phone];
}


public function reservation_order_status($id,$status)
{
	if($status==1){
	
	$date = 'accept_time';

	}elseif($status==2){
		$date = 'completed_time';
	}elseif($status==3){
		$date = 'cancel_time';
	}
	$data = array(
		'status' => $status,
		$date => d_time(),
	);
	$change = $this->admin_m->update_by_type($data,$id,$type='uid','order_user_list');
	if($change){
		redirect($_SERVER['HTTP_REFERER']);
	}
}

/*----------------------------------------------
	change order start from quick view
----------------------------------------------*/
public function order_status_by_ajax($id,$status)
{
	$msg = '';
	if($status==1 && restaurant()->es_time !=0):
		$id = $this->input->post('uid');
		$order_info =  single_select_by_id($id,'order_user_list');
	else:
		$order_info =  $this->admin_m->single_select_by_uid($id,'order_user_list');
	endif;

	$order_info =  $this->admin_m->single_select_by_uid($id,'order_user_list');
	$sms = sms_settings(auth('id'));

	$phone = restaurant()->dial_code.$order_info['phone'];


	$replace_data = array(
		'{USER_NAME}' => $order_info['name'],
		'{SHOP_NAME}' => restaurant()->username,
		'{ORDER_ID}' => $order_info['uid'],
	);


	if($status==1){
		$id =  $this->input->post('uid');
		
		if(restaurant()->es_time==0):
			$id =  $order_info['uid'];
			$time_data = array(
				'es_time' => '00:00',
				'time_slot' => '00:00',
				'is_preparing' => 0,
				'estimate_time' => '',
			);
		else:
			$id =  $this->input->post('uid');
			$time  = $this->input->post('es_time');
			$time_slot  = $this->input->post('time_slot');
			$time_data = array(
				'es_time' => $time,
				'time_slot' => $time_slot,
				'is_preparing' => 0,
				'estimate_time' => add_time($time,$time_slot),
			);
		endif;

		if(isset($sms->is_accept_sms) && $sms->is_accept_sms==1):
			$accept_message = json_decode($sms->accept_msg);
			$data = ['phone' => $phone, 'text' => create_msg($replace_data,$accept_message)];
 			$send = $this->sendSMS($data);
 			if(isset($send['st']) && $send['st']==0):
				$msg =  $send['msg'];
			endif;
		endif;


		$date = 'accept_time';
		$this->admin_m->update_by_type($time_data,$id,$type='uid','order_user_list');
	}elseif($status==2){

		if(isset($sms->is_complete_sms) && $sms->is_complete_sms==1):

			$complete_message = json_decode($sms->complete_msg);
			$complete_data = ['phone' => $phone, 'text' => create_msg($replace_data,$complete_message)];
 			$send = $this->sendSMS($complete_data);
 			if(isset($send['st']) && $send['st']==0):
				$msg =  $send['msg'];
			endif;
		endif;
		
		if($order_info['accept_time']=='0000-00-00 00:00:00' || empty($order_info['accept_time'])){
			$arr = array(
				'status' => 1,
				'accept_time' => d_time(),
			);
			$this->admin_m->update_by_type($arr,$id,$type='uid','order_user_list');
		}
		$date = 'completed_time';
		$this->user_email_m->send_order_mail($order_info['uid'],2);
	}elseif($status==3){
		$date = 'cancel_time';
	}
	$data = array(
		'status' => $status,
		$date => d_time(),
	);
	$change = $this->admin_m->update_by_type($data,$id,$type='uid','order_user_list');
	if($change){
		$this->system_model->whatsapp_message($status,$order_info);
		$data['item_list'] = $this->admin_m->get_item_list_by_order_id($id,restaurant()->id);
		$load_view = $this->load->view('backend/order/order_ajax_view', $data, TRUE);
		echo json_encode(['st'=>1,'load_data'=>$load_view,'msg'=>$msg]);
	}
}




/*  Profile home 
================================================== */
public function profile()
{
	$data = array();
	$data['page_title'] = "Restaurant Configuration";
    $data['page'] = "Profile";
    $data['countries'] = $this->admin_m->select('country');
	$data['restaurant'] = $this->admin_m->single_select_by_id(restaurant()->id,'restaurant_list');
	$data['main_content'] = $this->load->view('backend/restaurant/profile', $data, TRUE);
	$this->load->view('backend/index',$data);
}

public function general()
{
	$data = array();
	$data['page_title'] = "Profile";
    $data['page'] = "Profile";
    $user_id = md5(auth('id'));
    $data['countries'] = $this->admin_m->select('country');
	$data['auth_info'] = $this->admin_m->get_auth_profile_info_md5($user_id);
	$data['restaurant'] = $this->admin_m->get_my_restaurant($user_id);
	$data['main_content'] = $this->load->view('backend/common/create_restaurant', $data, TRUE);
	$this->load->view('backend/index',$data);
}




/**
  *** add home content
**/ 

public function delivery_config()
{
	$data = [
		'is_area_delivery' => isset($_POST['is_area_delivery'])?1:0,
	];
	$insert = $this->admin_m->update($data,$_ENV['ID'],'restaurant_list');
	$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
	redirect($_SERVER['HTTP_REFERER']);
}

public function add_configuration()
{
	is_test();
	$id =  $this->input->post('id',true);
	$this->form_validation->set_rules('delivery_charge_in', 'Delivery Charge', 'trim|xss_clean|required|callback_number_check');
	$this->form_validation->set_rules('tax_fee', 'Tax Fee', 'trim|xss_clean');
	$this->form_validation->set_rules('min_order', 'Minimum Order', 'trim|xss_clean|callback_number_check');
	$this->form_validation->set_rules('es_time', 'Time', 'trim|xss_clean|callback_number_check');
	$this->form_validation->set_rules('pin_number', 'Pin Number', 'trim|xss_clean');
	$this->form_validation->set_rules('kds_pin', 'KDS Pin', 'trim|xss_clean');
	if ($this->form_validation->run() == FALSE) {
		$this->session->set_flashdata('error', validation_errors());
		redirect($_SERVER['HTTP_REFERER']);
	}else{	
		$stock_status = $this->input->post('stock_status',TRUE);
		$is_stock_count = $this->input->post('is_stock_count',TRUE);
		$is_kds = $this->input->post('is_kds',TRUE);
		$is_review = $this->input->post('is_review',TRUE);
		$is_customer_login = $this->input->post('is_customer_login',TRUE);
		$is_call_waiter = $this->input->post('is_call_waiter',TRUE);
		$is_language = $this->input->post('is_language',TRUE);
		$is_pin = $this->input->post('is_pin',TRUE);
		$is_coupon = $this->input->post('is_coupon',TRUE);
		$is_question = $this->input->post('is_question',TRUE);
		$is_radius = $this->input->post('is_radius',TRUE);
		$is_tax = $this->input->post('is_tax',TRUE);
		$is_kds_pin = $this->input->post('is_kds_pin',TRUE);
		$is_checkout_mail = $this->input->post('is_checkout_mail',TRUE);
		$is_cart = $this->input->post('is_cart',TRUE);
		$guest_login = $this->input->post('guest_login',TRUE);
		$is_dine_in = $this->input->post('is_dine_in',TRUE);
		$is_pay_cash = $this->input->post('is_pay_cash',TRUE);
		$is_image = $this->input->post('is_image',TRUE);


		$is_order_merge = $this->input->post('is_order_merge',TRUE);
		$is_system = $this->input->post('is_system',TRUE);
		$mergeData = [
			'is_order_merge' => isset($is_order_merge)?1:0,
			'is_system' => isset($is_system)?$is_system:1,
		];
		$guest_config = [
			'is_guest_login' => isset($guest_login)?1:0,
			'is_dine_in' => isset($is_dine_in)?1:0,
			'is_pay_cash' => isset($is_pay_cash)?1:0,
		];
		$data = array(
			'delivery_charge_in' => $this->input->post('delivery_charge_in',TRUE),
			'time_slot' => $this->input->post('time_slot',TRUE),
			'es_time' => $this->input->post('es_time',TRUE),
			'tax_fee' => $this->input->post('tax_fee',TRUE),
			'min_order' => $this->input->post('min_order',TRUE),
			'discount' => $this->input->post('discount',TRUE),
			'pin_number' => $this->input->post('pin_number',TRUE),
			'tax_status' => $this->input->post('tax_status',TRUE),
			'kds_pin' => $this->input->post('kds_pin',TRUE),
			
			'stock_status' => isset($stock_status)?1:0,
			'is_stock_count' => isset($is_stock_count)?1:0,
			'is_kds' => isset($is_kds)?1:0,
			'is_customer_login' => isset($is_customer_login)?1:0,
			'is_call_waiter' => isset($is_call_waiter)?1:0,
			'is_review' => isset($is_review)?1:0,
			'is_language' => isset($is_language)?1:0,
			'is_pin' => isset($is_pin)?1:0,
			'is_coupon' => isset($is_coupon)?1:0,
			'is_question' => isset($is_question)?1:0,
			'is_radius' => isset($is_radius)?1:0,
			'is_tax' => isset($is_tax)?1:0,
			'is_kds_pin' => isset($is_kds_pin)?1:0,
			'is_checkout_mail' => isset($is_checkout_mail)?1:0,
			'order_merge_config' => json_encode($mergeData),
			'is_cart' => isset($is_cart)?1:0,
			'is_image' => isset($is_image)?1:0,
			'guest_config' => json_encode($guest_config),
		);
		$insert = $this->admin_m->update($data,$id,'restaurant_list');
		if($insert){
			$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
			redirect(base_url('admin/auth/order_config'));
		}else{
			$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
			redirect(base_url('admin/auth/order_config'));
		}	
	}
}


public function add_gmap($shop_id)
{
	is_test();
	$id =  $this->input->post('id',true);
	$this->form_validation->set_rules('is_gmap', 'Google Map status', 'trim|xss_clean');
	$this->form_validation->set_rules('gmap_key', 'Google map key', 'trim|xss_clean|required');
	if ($this->form_validation->run() == FALSE) {
		$this->session->set_flashdata('error', validation_errors());
		redirect($_SERVER['HTTP_REFERER']);
	}else{	
		$is_gmap = $this->input->post('is_gmap',TRUE);
		$data = array(
			'gmap_key' => $this->input->post('gmap_key',TRUE),
			'is_gmap' => isset($is_gmap)?1:0,
		);
		$insert = $this->admin_m->update($data,$id,'restaurant_list');
		if($insert){
			$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
			redirect(base_url('admin/restaurant/pickup_points/'.$shop_id));
		}else{
			$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
			redirect(base_url('admin/restaurant/pickup_points/'.$shop_id));
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



public function add_payment_method()
{
	is_test();
	$id =  $this->input->post('id',true);


	$is_paypal =  $this->input->post('is_paypal',true);
	$is_live =  $this->input->post('is_live',true);
	$this->form_validation->set_rules('paypal_email', 'Paypal Business mail', 'trim|xss_clean');
	/*----------------------------------------------
				STRIPE
	----------------------------------------------*/
	$this->form_validation->set_rules('public_key', 'Stripe Public key', 'trim|xss_clean');
	$this->form_validation->set_rules('secret_key', 'Stripe Secret key', 'trim|xss_clean');
	/*----------------------------------------------
				RAZORPAY
	----------------------------------------------*/

	$this->form_validation->set_rules('razorpay_key', 'Razorpay  key', 'trim|xss_clean');
	$this->form_validation->set_rules('razorpay_key_id', 'Razorpay  key ID', 'trim|xss_clean');


	if ($this->form_validation->run() == FALSE) {
		$this->session->set_flashdata('error', validation_errors());
		redirect($_SERVER['HTTP_REFERER']);
	}else{	

		$paypal = array(
			'is_live' => $this->input->post('is_live',TRUE)!=1?0:1,
			'paypal_email' => $this->input->post('paypal_email',TRUE),
		);

		$stripe = array(
			'public_key' => $this->input->post('public_key',TRUE),
			'secret_key' => $this->input->post('secret_key',TRUE),
		);

		$razorpay = array(
			'razorpay_key' => $this->input->post('razorpay_key',TRUE),
			'razorpay_key_id' => $this->input->post('razorpay_key_id',TRUE),
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

		$data = array(
			'is_paypal' => $this->input->post('is_paypal',TRUE)!=1?0:1,
			'is_stripe' => $this->input->post('is_stripe',TRUE)!=1?0:1,
			'is_razorpay' => $this->input->post('is_razorpay',TRUE)!=1?0:1,
			'is_paytm' => $this->input->post('is_paytm',TRUE)!=1?0:1,
			'is_flutterwave' => $this->input->post('is_flutterwave',TRUE)!=1?0:1,
			'is_fpx' => $this->input->post('is_fpx',TRUE)!=1?0:1,
			'is_mercado' => $this->input->post('is_mercado',TRUE)!=1?0:1,
			'is_paystack' => $this->input->post('is_paystack',TRUE)!=1?0:1,
			'is_pagadito' => $this->input->post('is_pagadito',TRUE)!=1?0:1,
			'is_netseasy' => $this->input->post('is_netseasy',TRUE)!=1?0:1,

					
			'paypal_config' => json_encode($paypal),
			'stripe_config' => json_encode($stripe),
			'razorpay_config' => json_encode($razorpay),
			'mercado_config' => json_encode($mercado),
			'paytm_config' => json_encode($paytm),
			'flutterwave_config' => json_encode($flutterwave),
			'fpx_config' => json_encode($fpx),
			'paystack_config' => json_encode($paystack),
			'pagadito_config' => json_encode($pagadito),
			'netseasy_config' => json_encode($netseasy),
		);

		if(check()==1):
			$insert = $this->admin_m->update($data,$id,'restaurant_list');
		endif;
		if($insert){
			$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
			redirect(base_url('admin/auth/payment_config'));
		}else{
			$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
			redirect(base_url('admin/auth/payment_config'));
		}	
	}
}






public function payment_history()
{
	$data = array();
	$data['page_title'] = "Payment History";
    $data['page'] = "Payment History";
    $data['payment_history'] = $this->admin_m->select_all_by_shop_desc(restaurant()->id,'order_payment_info');
	$data['main_content'] = $this->load->view('backend/restaurant/payment_history', $data, TRUE);
	$this->load->view('backend/index',$data);
}

public function tables($shop_id){

	$data = array();
	$data['page_title'] = "Tables";
	$data['page'] = "Profile";
	$data['data'] = false;
	$data['is_create'] = false;
	$data['shop_id'] = $shop_id;
	$data['restaurant'] = $this->admin_m->get_shop_profile_md5($shop_id);
	$data['auth_info'] = $this->admin_m->get_user_info_by_shop_id($shop_id);

	$data['table_list'] = $this->admin_m->get_by_shop_user_id($data['restaurant']['id'],'table_list');
	$data['table_areas'] = $this->admin_m->get_by_shop_user_id($data['restaurant']['id'],'table_areas');

	$data['main_content'] = $this->load->view('backend/restaurant/tables', $data, TRUE);
	$this->load->view('backend/index',$data);
}

public function create_table($shop_id){

	$data = array();
	$data['page_title'] = "Tables";
	$data['page'] = "Profile";
	$data['is_create'] = true;
	$data['data'] = false;
	$data['shop_id'] = $shop_id;
	$data['restaurant'] = $this->admin_m->get_shop_profile_md5($shop_id);
	$data['auth_info'] = $this->admin_m->get_user_info_by_shop_id($shop_id);

	$data['table_list'] = $this->admin_m->get_by_shop_user_id($data['restaurant']['id'],'table_list');
	$data['table_areas'] = $this->admin_m->get_by_shop_user_id($data['restaurant']['id'],'table_areas');

	$data['main_content'] = $this->load->view('backend/restaurant/tables', $data, TRUE);
	$this->load->view('backend/index',$data);
}

public function edit_tables($id,$shop_id){

	$data = array();
	$data['page_title'] = "Tables";
	$data['page'] = "Profile";
	$data['is_create'] = true;
	$data['data'] = single_select_by_id($id,'table_list');
	$data['shop_id'] = $shop_id;
	$data['restaurant'] = $this->admin_m->get_shop_profile_md5($shop_id);
	$data['auth_info'] = $this->admin_m->get_user_info_by_shop_id($shop_id);

	$data['table_list'] = $this->admin_m->get_by_shop_user_id($data['restaurant']['id'],'table_list');
	$data['table_areas'] = $this->admin_m->get_by_shop_user_id($data['restaurant']['id'],'table_areas');

	$data['main_content'] = $this->load->view('backend/restaurant/tables', $data, TRUE);
	$this->load->view('backend/index',$data);
}

public function add_tables($shop_id)
{
	is_test();
	$id =  $this->input->post('id',true);
	$this->form_validation->set_rules('name', 'Table Name', 'trim|xss_clean|required');
	$this->form_validation->set_rules('size', 'Table size', 'trim|xss_clean|required');
	$this->form_validation->set_rules('area_id', 'Table Area', 'trim|xss_clean|required');

	if ($this->form_validation->run() == FALSE) {
		$this->session->set_flashdata('error', validation_errors());
		redirect(base_url('admin/restaurant/tables/'.$shop_id));
	}else{	
		$data = array(
			'name' => $this->input->post('name',TRUE),
			'size' => $this->input->post('size',TRUE),
			'area_id' => $this->input->post('area_id',TRUE),
			'status' => 1,
			'user_id' => auth('id'),
			'shop_id' => restaurant()->id,
			'created_at' => d_time(),
		);
		
		if($id ==0){
			$insert = $this->admin_m->insert($data,'table_list');
		}else{
			$insert = $this->admin_m->update($data,$id,'table_list');
		}
		if($insert){
			$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
			redirect(base_url('admin/restaurant/tables/'.$shop_id));
		}else{
			$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
			redirect(base_url('admin/restaurant/tables/'.$shop_id));
		}	
	}
}


public function add_locations($shop_id)
{
	is_test();
	$id =  $this->input->post('id',true);
	$this->form_validation->set_rules('address', 'Address Name', 'trim|xss_clean|required');
	$this->form_validation->set_rules('latitude', 'Latitude', 'trim|xss_clean|required');
	$this->form_validation->set_rules('longitude', 'Llongidute', 'trim|xss_clean|required');

	if ($this->form_validation->run() == FALSE) {
		$this->session->set_flashdata('error', validation_errors());
		redirect(base_url('admin/restaurant/location/'.$shop_id));
	}else{	
		$data = array(
			'address' => $this->input->post('address',TRUE),
			'latitude' => $this->input->post('latitude',TRUE),
			'longitude' => $this->input->post('longitude',TRUE),
			'user_id' => auth('id'),
			'shop_id' => restaurant()->id,
			'created_at' => d_time(),
		);
		
		if($id ==0){
			$insert = $this->admin_m->insert($data,'shop_location_list');
		}else{
			$insert = $this->admin_m->update($data,$id,'shop_location_list');
		}
		if($insert){
			$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
			redirect(base_url('admin/restaurant/location/'.$shop_id));
		}else{
			$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
			redirect(base_url('admin/restaurant/location/'.$shop_id));
		}	
	}
}

public function location($shop_id){

	$data = array();
	$data['page_title'] = "Locations";
	$data['page'] = "Profile";
	$data['data'] = false;
	$data['is_create'] = false;
	$data['shop_id'] = $shop_id;
	$data['restaurant'] = $this->admin_m->get_shop_profile_md5($shop_id);
	$data['auth_info'] = $this->admin_m->get_user_info_by_shop_id($shop_id);

	$data['location_list'] = $this->admin_m->get_by_shop_user_id($data['restaurant']['id'],'shop_location_list');

	$data['main_content'] = $this->load->view('backend/restaurant/location', $data, TRUE);
	$this->load->view('backend/index',$data);
}
public function edit_location($id,$shop_id){

	$data = array();
	$data['page_title'] = "Locations";
	$data['page'] = "Profile";
	$data['is_create'] = true;
	$data['data'] = single_select_by_id($id,'shop_location_list');
	$data['shop_id'] = $shop_id;
	$data['restaurant'] = $this->admin_m->get_shop_profile_md5($shop_id);
	$data['auth_info'] = $this->admin_m->get_user_info_by_shop_id($shop_id);

	$data['location_list'] = $this->admin_m->get_by_shop_user_id($data['restaurant']['id'],'shop_location_list');

	$data['main_content'] = $this->load->view('backend/restaurant/location', $data, TRUE);
	$this->load->view('backend/index',$data);
}

public function add_area($shop_id)
{
	is_test();
	$id =  $this->input->post('id',true);
	$this->form_validation->set_rules('area_name', 'Area Name', 'trim|xss_clean|required');

	if ($this->form_validation->run() == FALSE) {
		$this->session->set_flashdata('error', validation_errors());
		redirect(base_url('admin/restaurant/tables/'.$shop_id));
	}else{	
		$data = array(
			'area_name' => $this->input->post('area_name',TRUE),
			'user_id' => auth('id'),
			'shop_id' => restaurant()->id,
		);
		
		if($id ==0){
			$insert = $this->admin_m->insert($data,'table_areas');
		}else{
			$insert = $this->admin_m->update($data,$id,'table_areas');
		}
		if($insert){
			$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
			redirect(base_url('admin/restaurant/tables/'.$shop_id));
		}else{
			$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
			redirect(base_url('admin/restaurant/tables/'.$shop_id));
		}	
	}
}



public function delivery_area($shop_id){

	$data = array();
	$data['page_title'] = "Delivery Area";
	$data['page'] = "Settings";
	$data['data'] = false;
	$data['is_create'] = false;
	$data['shop_id'] = $shop_id;
	$data['restaurant'] = $this->admin_m->get_shop_profile_md5($shop_id);
	$data['auth_info'] = $this->admin_m->get_user_info_by_shop_id($shop_id);

	$data['delivery_area_list'] = $this->admin_m->get_by_shop_user_id($data['restaurant']['id'],'delivery_area_list');

	$data['main_content'] = $this->load->view('backend/restaurant/delivery_area', $data, TRUE);
	$this->load->view('backend/index',$data);
}


public function qrbuilder($shop_id){

	$data = array();
	$data['page_title'] = "Qr Builder";
	$data['page'] = "Profile";
	$data['data'] = false;
	$data['is_create'] = false;
	$data['shop_id'] = $shop_id;

	$data['settings'] = $this->admin_m->get_user_settings(auth('id'));

	$data['main_content'] = $this->load->view('backend/restaurant/qrbuilder', $data, TRUE);
	$this->load->view('backend/index',$data);
}


public function table_qrbuilder($shop_id){

	$data = array();
	$data['page_title'] = "Table Qr Builder";
	$data['page'] = "Profile";
	$data['data'] = false;
	$data['is_create'] = false;
	$data['shop_id'] = $shop_id;

	$data['settings'] = $this->admin_m->get_user_settings(auth('id'));
	$data['table_list'] = $this->admin_m->select_all_by_user('table_list');
	$data['main_content'] = $this->load->view('backend/restaurant/table_qr', $data, TRUE);
	$this->load->view('backend/index',$data);
}






public function edit_delivery_area($id,$shop_id){

	$data = array();
	$data['page_title'] = "Delivery Area";
	$data['page'] = "Settings";
	$data['is_create'] = true;
	$data['data'] = single_select_by_id($id,'delivery_area_list');
	$data['shop_id'] = $shop_id;
	$data['restaurant'] = $this->admin_m->get_shop_profile_md5($shop_id);
	$data['auth_info'] = $this->admin_m->get_user_info_by_shop_id($shop_id);

	$data['delivery_area_list'] = $this->admin_m->get_by_shop_user_id($data['restaurant']['id'],'delivery_area_list');

	$data['main_content'] = $this->load->view('backend/restaurant/delivery_area', $data, TRUE);
	$this->load->view('backend/index',$data);
}

public function add_delivery_area($shop_id)
{
	is_test();
	$id =  $this->input->post('id',true);
	$this->form_validation->set_rules('area', 'Area Name', 'trim|xss_clean|required');
	$this->form_validation->set_rules('cost', 'Delivery Charge', 'trim|xss_clean|required|callback_number_check');

	if ($this->form_validation->run() == FALSE) {
		$this->session->set_flashdata('error', validation_errors());
		redirect(base_url('admin/restaurant/delivery_area/'.$shop_id));
	}else{	
		$data = array(
			'area' => $this->input->post('area',TRUE),
			'cost' => $this->input->post('cost',TRUE),
			'user_id' => auth('id'),
			'shop_id' => restaurant()->id,
		);
		
		if($id ==0){
			$insert = $this->admin_m->insert($data,'delivery_area_list');
		}else{
			$insert = $this->admin_m->update($data,$id,'delivery_area_list');
		}
		if($insert){
			$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
			redirect(base_url('admin/restaurant/delivery_area/'.$shop_id));
		}else{
			$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
			redirect(base_url('admin/restaurant/delivery_area/'.$shop_id));
		}	
	}
}
public function add_qr($shop_id)
{
	is_test();
	$id =  $this->input->post('id',true);
	$this->form_validation->set_rules('fg_color', 'Area Name', 'trim|xss_clean');

	if ($this->form_validation->run() == FALSE) {
		$this->session->set_flashdata('error', validation_errors());
		redirect(base_url('admin/restaurant/qrbuilder/'.$shop_id));
	}else{	

		$img = $this->upload_qr();
		if(!empty($img)){
			$img = $img;
		}else{
			$img = $this->input->post('old_img');
		}
		$data = array(
			'fg_color' => $this->input->post('fg_color',TRUE),
			'bg_color' => $this->input->post('bg_color',TRUE),
			'qr_mode' => $this->input->post('qr_mode',TRUE),
			'qr_text' => $this->input->post('qr_text',TRUE),
			'text_color' => $this->input->post('text_color',TRUE),
			'mode_size' => $this->input->post('mode_size',TRUE),
			'qr_position_x' => $this->input->post('qr_position_x',TRUE),
			'qr_position_y' => $this->input->post('qr_position_y',TRUE),
			'img' => $img,
			'user_id' => auth('id'),
		);
		$qrbuilder = array('qr_config' => json_encode($data));
		
		if($id ==0){
			$insert = $this->admin_m->insert($qrbuilder,'user_settings');
		}else{
			$insert = $this->admin_m->update($qrbuilder,$id,'user_settings');
		}
		if($insert){
			$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
			redirect(base_url('admin/restaurant/qrbuilder/'.$shop_id));
		}else{
			$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
			redirect(base_url('admin/restaurant/qrbuilder/'.$shop_id));
		}	
	}
}


public function add_table_qr($shop_id)
{
	is_test();
	$id =  $this->input->post('id',true);
	$this->form_validation->set_rules('fg_color', 'Color', 'trim|xss_clean');

	if ($this->form_validation->run() == FALSE) {
		$this->session->set_flashdata('error', validation_errors());
		redirect(base_url('admin/restaurant/table_qrbuilder/'.$shop_id));
	}else{	

		$img = $this->upload_qr();
		if(!empty($img)){
			$img = $img;
		}else{
			$img = $this->input->post('old_img');
		}
		$data = array(
			'fg_color' => $this->input->post('fg_color',TRUE),
			'bg_color' => $this->input->post('bg_color',TRUE),
			'qr_mode' => $this->input->post('qr_mode',TRUE),
			'qr_text' => $this->input->post('qr_text',TRUE),
			'text_color' => $this->input->post('text_color',TRUE),
			'mode_size' => $this->input->post('mode_size',TRUE),
			'qr_position_x' => $this->input->post('qr_position_x',TRUE),
			'qr_position_y' => $this->input->post('qr_position_y',TRUE),
			'table_no' => $this->input->post('table_no',TRUE),
			'qr_type' => $this->input->post('qr_type',TRUE),
			'img' => $img,
			'user_id' => auth('id'),
		);
		$qrbuilder = array('table_qr_config' => json_encode($data));
		
		if($id ==0){
			$insert = $this->admin_m->insert($qrbuilder,'user_settings');
		}else{
			$insert = $this->admin_m->update($qrbuilder,$id,'user_settings');
		}
		if($insert){
			$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
			redirect(base_url('admin/restaurant/table_qrbuilder/'.$shop_id));
		}else{
			$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
			redirect(base_url('admin/restaurant/table_qrbuilder/'.$shop_id));
		}	
	}
}

public function upload_qr()
{

	if(!empty($_FILES['images']['name'])){
		$directory = 'uploads/';
		$dir = $directory;
		$name = $_FILES['images']['name'];
		list($txt, $ext) = explode(".", $name);
		$image_name = md5(time()).".".$ext;
		$tmp = $_FILES['images']['tmp_name'];
		if(move_uploaded_file($tmp, $dir.$image_name)){
			$url = $dir.$image_name;
			return $url;	
		}
	}

}


public function staff_list()
{
	$data = array();
	$data['page_title'] = "Staff";
    $data['page'] = "Staff";
    $data['data'] = false;
    $data['edit'] = 0;
    $data['staff_list'] = $this->admin_m->get_my_all_staf('staff_list');
    $data['permission_list'] = $this->admin_m->select_permossion('user');
	$data['main_content'] = $this->load->view('backend/restaurant/staff_list', $data, TRUE);
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
    $data['permission_list'] = $this->admin_m->select_permossion('user');
	$data['main_content'] = $this->load->view('backend/restaurant/add_staff', $data, TRUE);
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
    $data['permission_list'] = $this->admin_m->select_permossion('user');
	$data['main_content'] = $this->load->view('backend/restaurant/add_staff', $data, TRUE);
	$this->load->view('backend/index',$data);
}

public function add_permission_list(){
	is_test();
	$this->form_validation->set_rules('title[]', 'Title', 'required|trim|xss_clean');
	if ($this->form_validation->run() == FALSE) {
		$this->session->set_flashdata('error', validation_errors());
		redirect(base_url('admin/restaurant/staff_list'));
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
			redirect(base_url('admin/restaurant/staff_list'));
		}else{
			$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
			redirect(base_url('admin/restaurant/staff_list'));
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
		redirect(base_url('admin/restaurant/staff'));
	}else{	
			$id = $this->input->post('id',TRUE);
			$check_email = $this->admin_m->check_existing_email(strtolower(trim($this->input->post('email',true))));
			
			if($check_email==1){
				$this->session->set_flashdata('error', lang('email_exits_in'));
				redirect(base_url('admin/restaurant/staff'));
				exit();
			}

			$check_staff_email = $this->admin_m->check_exits_staff(strtolower(trim($this->input->post('email',true))));
			if($check_staff_email==1 && $id ==0){
				
				$this->session->set_flashdata('error', lang('email_alreay_exits'));
				redirect(base_url('admin/restaurant/staff'));
				exit();

			}else{
				$uid = date('Y').random_string('numeric',4);
				if(isset($id) && $id !=0):
				$data = array(
					'name' => $this->input->post('name',TRUE),
					'email' => $this->input->post('email',TRUE),
					'user_id' => auth('id'),
					'status' => 1,
					'role' => 'staff',
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
						'role' => 'staff',
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
			redirect(base_url('admin/restaurant/staff_list'));
		}else{
			$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
			redirect(base_url('admin/restaurant/staff'));
		}	
	}
}
 public function update_staff_profile(){
 	is_test();
    	$this->form_validation->set_rules('name', 'name', 'trim|required|xss_clean');
    	$this->form_validation->set_rules('phone', 'phone', 'trim|xss_clean');
    	if ($this->form_validation->run() == FALSE) {
    		$this->session->set_flashdata('error', validation_errors());
    		redirect(base_url('admin/restaurant/staff_profile'));
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
    			redirect(base_url('admin/restaurant/staff_profile'));
    		}else{
    			$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
    			redirect(base_url('admin/restaurant/staff_profile'));
    		}	
    	}
    }





    public function staff_profile(){

		$data = array();
		$data['page_title'] = "Profile";
		$data['page'] = "Auth";
		$data['auth_info'] = $this->admin_m->single_select_by_id(auth('staff_id'),'staff_list');
    	$data['permission_list'] = $this->admin_m->select_permossion('user');
		$data['main_content'] = $this->load->view('backend/restaurant/staff_profile', $data, TRUE);
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
public function delete_img($id,$table)
{
	is_test();
	$img = single_select_by_id($id,$table);
	$data = [
		'thumb' =>'',
		'images' => '',
	];
	$del= $this->admin_m->update($data,$id,$table);
	if($del):
		delete_image_from_server($img['thumb']);
		delete_image_from_server($img['images']);
		$msg = 'Successfully Deleted';
		echo json_encode(array('st' => 1, 'msg'=> $msg));
	endif;
}


public function dboy_list()
{
	$data = array();
	$data['page_title'] = "Delivery Staff";
    $data['page'] = "Staff";
    $data['data'] = false;
    $data['edit'] = 0;
    $data['dboy_list'] = $this->admin_m->get_my_all_dboy();
	$data['main_content'] = $this->load->view('backend/restaurant/dboy_list', $data, TRUE);
	$this->load->view('backend/index',$data);
}

public function dboy()
{
	$data = array();
	$data['page_title'] = "Delivery Staff";
    $data['page'] = "Staff";
    $data['edit'] = 1;
    $data['data'] = false;
    $data['dboy_list'] = $this->admin_m->get_my_all_dboy();
	$data['main_content'] = $this->load->view('backend/restaurant/add_dboy', $data, TRUE);
	$this->load->view('backend/index',$data);
}

public function edit_dboy($id)
{
	$data = array();
	$data['page_title'] = "Delivery Staff";
    $data['page'] = "Delivery Staff";
    $data['edit'] = 1;
    $data['data'] = $this->admin_m->single_select_by_id($id,'staff_list');
    valid_user($data['data']['user_id']);
    $data['staff_list'] = $this->admin_m->select_all_by_user('staff_list');
	$data['main_content'] = $this->load->view('backend/restaurant/add_dboy', $data, TRUE);
	$this->load->view('backend/index',$data);
}

public function add_dboy(){
	is_test();

	$dphone = $this->input->post('data_phone',TRUE);
	$phone = $this->input->post('phone',TRUE);
	$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
	$this->form_validation->set_rules('email', 'Email', 'required|trim');
		$this->form_validation->set_rules('phone', 'Phone', 'required|trim|xss_clean');
	if ($this->form_validation->run() == FALSE) {
		$this->session->set_flashdata('error', validation_errors());
		redirect(base_url('admin/restaurant/dboy'));
	}else{	
			$id = $this->input->post('id',TRUE);
		
			$check_staff_phone = $this->admin_m->check_exits_dboy(trim($this->input->post('phone',true)));
			if($dphone !=0 && $dphone!=$phone){
				if($check_staff_phone==1):
					$this->session->set_flashdata('error', !empty(lang('phone_already_exits'))?lang('phone_already_exits'):"Phone already Exists");
					redirect($_SERVER['HTTP_REFERER']);
					exit();
				endif;
			
			}
			if($check_staff_phone==1 && $id ==0){
				
				$this->session->set_flashdata('error', !empty(lang('phone_already_exits'))?lang('phone_already_exits'):"Phone already Exists");
				redirect(base_url('admin/restaurant/dboy'));
				exit();

			}else{
				$uid = date('Y').random_string('numeric',6);
				if(isset($id) && $id !=0):
				$data = array(
					'name' => $this->input->post('name',TRUE),
					'email' => $this->input->post('email',TRUE),
					'phone' => $this->input->post('phone',TRUE),
					'user_id' => auth('id'),
					'country_id' => restaurant()->country_id,
					'status' => 1,
					'role' => 'delivery',
					'created_at' => d_time(),

				);
				else:
					$data = array(
						'uid' => $uid,
						'name' => $this->input->post('name',TRUE),
						'email' => $this->input->post('email',TRUE),
						'phone' => $this->input->post('phone',TRUE),
						'password' => md5(1234),
						'user_id' => auth('id'),
						'country_id' => restaurant()->country_id,
						'status' => 1,
						'role' => 'delivery',
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
			redirect(base_url('admin/restaurant/dboy_list'));
		}else{
			$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
			redirect(base_url('admin/restaurant/dboy'));
		}	
	}
}



public function customer_list()
{
	$data = array();
	$data['page_title'] = "Customer List";
    $data['page'] = "Customer";
    $data['data'] = false;
    $data['edit'] = 0;
    $data['dboy_list'] = $this->admin_m->get_my_all_customer();
	$data['main_content'] = $this->load->view('backend/restaurant/customer/customer_list', $data, TRUE);
	$this->load->view('backend/index',$data);
}

public function customer()
{
	$data = array();
	$data['page_title'] = "Customer List";
    $data['page'] = "Customer";
    $data['edit'] = 1;
    $data['data'] = false;
    $data['dboy_list'] = $this->admin_m->get_my_all_customer();
	$data['main_content'] = $this->load->view('backend/restaurant/customer/add_customer', $data, TRUE);
	$this->load->view('backend/index',$data);
}

public function edit_customer($id)
{
	$data = array();
	$data['page_title'] = "Customer List";
    $data['page'] = "Customer List";
    $data['edit'] = 1;
    $data['data'] = $this->admin_m->single_select_by_id($id,'customer_list');
    $data['staff_list'] = $this->admin_m->select_all_by_user('customer_list');
	$data['main_content'] = $this->load->view('backend/restaurant/customer/add_customer', $data, TRUE);
	$this->load->view('backend/index',$data);
}

public function add_customer(){
	is_test();

	$dphone = $this->input->post('data_phone',TRUE);
	$phone = $this->input->post('phone',TRUE);
	$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
	$this->form_validation->set_rules('email', 'Email', 'required|trim');
		$this->form_validation->set_rules('phone', 'Phone', 'required|trim|xss_clean');
	if ($this->form_validation->run() == FALSE) {
		$this->session->set_flashdata('error', validation_errors());
		redirect(base_url('admin/restaurant/customer'));
	}else{	
			$id = $this->input->post('id',TRUE);
		
			$check_staff_phone = $this->admin_m->check_exits_customer_phone(trim($this->input->post('phone',true)));
			if($dphone !=0 && $dphone!=$phone){
				if($check_staff_phone==1):
					$this->session->set_flashdata('error', !empty(lang('phone_already_exits'))?lang('phone_already_exits'):"Phone already Exists");
					redirect($_SERVER['HTTP_REFERER']);
					exit();
				endif;
			
			}
			if($check_staff_phone==1 && $id ==0){
				
				$this->session->set_flashdata('error', !empty(lang('phone_already_exits'))?lang('phone_already_exits'):"Phone already Exists");
				redirect($_SERVER['HTTP_REFERER']);
				exit();

			}else{
				$uid = date('Y').random_string('numeric',6);
				if(isset($id) && $id !=0):
				$data = array(
					'customer_name' => $this->input->post('name',TRUE),
					'email' => $this->input->post('email',TRUE),
					'phone' => $this->input->post('phone',TRUE),
					'user_id' => auth('id'),
					'country_id' => restaurant()->country_id,
					'status' => 1,
					'role' => 'customer',
					'created_at' => d_time(),

				);
				else:
					$data = array(
						'uid' => $uid,
						'customer_name' => $this->input->post('name',TRUE),
						'email' => $this->input->post('email',TRUE),
						'phone' => $this->input->post('phone',TRUE),
						'password' => md5(1234),
						'user_id' => auth('id'),
						'country_id' => restaurant()->country_id,
						'status' => 1,
						'role' => 'customer',
						'created_at' => d_time(),

					);
				endif;
			}

			
			if(isset($id) && $id !=0){
				$insert = $this->admin_m->update($data,$id,'customer_list');
			}else{
				$insert = $this->admin_m->insert($data,'customer_list');
			}

		if($insert){
			$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
			redirect(base_url('admin/restaurant/customer_list'));
		}else{
			$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
			redirect(base_url('admin/restaurant/customer'));
		}	
	}
}




public function add_pickup_slots(){
	$this->form_validation->set_rules('time_slots[]', 'Time Slots', 'trim|required|xss_clean');
	if ($this->form_validation->run() == FALSE) {
		$this->session->set_flashdata('error', validation_errors());
		redirect($_SERVER['HTTP_REFERER']);
	}else{	
		   	$id = $this->input->post('id');
		   	if(isset($_POST['time_slots'])):
		   		$data = array(
		   			'pickup_time_slots' => json_encode($_POST['time_slots']),
		   		);
		   		$insert =  $this->admin_m->update($data,$id,'restaurant_list');
		   	endif;
		if($insert){
			$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
			redirect($_SERVER['HTTP_REFERER']);
		}	
	}
}

public function customer_login($id){
	$row = single_select_by_id($id,'staff_list');
	if(!empty($row)):
		$s_array = array(
			'staff_id' => $row['id'],
			'name' => $row['name'],
			'phone' => $row['phone'],
			'email' => $row['email'],
			'role' =>  $row['role'],
			'is_'.$row['role'] => TRUE
		);
		
		$this->session->set_userdata($s_array);

		redirect(base_url('staff/order_list'));
	else:
		$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
		redirect($_SERVER['HTTP_REFERER']);
	endif;
}


public function reset_password($id){
		is_test();
		$data =  array(
				'password' => md5(1234),
			);
		$update = $this->admin_m->update($data,$id,'staff_list');
		if($update){
			echo json_encode(array('st'=>1));
		}else{
			echo json_encode(array('st'=>0));
		}
	}


public function add_order_item($uid,$id)
{
	$order_info = $this->admin_m->single_select_by_uid($uid,'order_user_list');
	$item_info = $this->admin_m->single_select_by_id($id,'items');
	$is_size = $this->input->post('is_size',true);
	$size_slug = $this->input->post('size_slug',true);
	$qty = $this->input->post('qty');
	if(isset($size_slug) && $is_size==1){
		$price = $this->input->post('item_price',true);
		$size_slug = $size_slug;
	}else{
		$size_slug = '';
		$price = $this->input->post('item_price',true);
	}
	$sub_price = $price*$qty;
	$previous_price = $this->admin_m->get_total_price_by_order_id($order_info['id']);
	$present_price = $previous_price+$sub_price;
	$price_format =number_format((float)$present_price, 2, '.', '') ;
	$total_price = grand_total($price_format,$order_info['delivery_charge'],$order_info['discount'],$order_info['tax_fee'],$order_info['coupon_percent'],$order_info['tips'],$order_info['order_type'],restaurant()->tax_status);
	
	$data = array(
		'order_id' => $order_info['id'],
		'shop_id' => $order_info['shop_id'],
		'item_id' => $id,
		'qty' => $qty,
		'sub_total' => $sub_price,
		'item_price' => $price,
		'is_size' => $is_size,
		'size_slug' => $size_slug,
		'created_at' => d_time(),
	);
	$this->admin_m->insert($data,'order_item_list');
	$user_order = array(
		'sub_total' => $price_format,
		'total' =>$total_price,
	);
	$this->admin_m->update($user_order,$order_info['id'],'order_user_list');
	$msg = '<div class="alert alert-success alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong> <i class="fa fa-check"></i> '.lang('success').' </strong> '.lang('item_added_successfully').'
				</div>';
	echo json_encode(['st'=>1,'msg'=>$msg]);

}



public function delete_order_items($uid,$id)
{

	$delete = $this->admin_m->delete($id,'order_item_list');
	if($delete):
		$order_info = $this->admin_m->single_select_by_uid($uid,'order_user_list');
		$previous_price = $this->admin_m->get_total_price_by_order_id($order_info['id']);
		$present_price = $previous_price;
		$price_format =number_format((float)$present_price, 2, '.', '') ;
		$total_price = grand_total($price_format,$order_info['delivery_charge'],$order_info['discount'],$order_info['tax_fee'],$order_info['coupon_percent'],$order_info['tips'],$order_info['order_type'],restaurant()->tax_status);

		$user_order = array(
			'sub_total' => $price_format,
			'total' =>$total_price,
		);
		$this->admin_m->update($user_order,$order_info['id'],'order_user_list');
		$this->session->set_flashdata('success', !empty(lang('delete_success'))?lang('delete_success'):'Deleted Successfully!');
		redirect($_SERVER['HTTP_REFERER']);
	else:
		$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
		redirect($_SERVER['HTTP_REFERER']);
	endif;

}

public function send_message(){
	$uid = $this->input->post('order_id',true);
	$dial_code = $this->input->post('dial_code',true);
	$phone = $this->input->post('phone',true);
	$status = $this->input->post('status',true);
	$order_details = $this->admin_m->single_select_by_uid($uid,'order_user_list');

	$accept_message = restaurant()->accept_message;
	$complete_message = restaurant()->completed_message;
	$delivered_message = restaurant()->delivered_message;

	if($status=="accepted"){
		$replace_data = array(
			'{ORDER_ID}' => $uid,
		);
		$accept_message = json_decode($accept_message);
		$msg = create_msg($replace_data,$accept_message);
	}

	if($status=="completed"){
		$replace_data = array(
			'{ORDER_ID}' => $uid,
		);
		$complete_message = json_decode($complete_message);
		$msg = create_msg($replace_data,$complete_message);
	}

	if($status=="delivered"){
		$replace_data = array(
			'{ORDER_ID}' => $uid,
			'{DELIVERY_COMPANY}' => !empty($order_details['company_details'])?$order_details['company_details']:'',
			'{TRACKING_NUMBER}' => !empty($order_details['tracking_number'])?$order_details['tracking_number']:'',
		);
		$delivered_message = json_decode($delivered_message);
		$msg = create_msg($replace_data,$delivered_message);
	}


	redirect("https://api.whatsapp.com/send?phone=".$dial_code.$phone."&text=".urlencode($msg),'refresh');


}

public function add_delivery_guy(){
	is_test();
	$this->form_validation->set_rules('db_boy_id', 'Delivery Boy', 'trim|xss_clean|required');
	if ($this->form_validation->run() == FALSE) {
		$this->session->set_flashdata('error', validation_errors());
		redirect($_SERVER['HTTP_REFERER']);
	}else{	
		$data = array(
			'dboy_id' => $this->input->post('db_boy_id',TRUE),
			'is_db_request' => 1,
		);
		$id = $this->input->post('id');
		$insert = $this->admin_m->update($data,$id,'order_user_list');

		if($insert){
			$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
			redirect($_SERVER['HTTP_REFERER']);
		}	
	}
}



public function order_action(){
	$this->form_validation->set_rules('actionIds', 'IDS', 'trim|xss_clean|required');
	if ($this->form_validation->run() == FALSE) {
		$this->session->set_flashdata('error', validation_errors());
		redirect($_SERVER['HTTP_REFERER']);
	}else{
		$ids = $_POST['actionIds'];
		$action = '';
		if(isset($_POST['merge'])):
			$action = 'merge';
		endif;	

		if(isset($_POST['delete'])):
			$action = 'delete';
		endif;

		$orderList = $this->admin_m->get_order_details_by_ids(json_decode($ids),$_ENV['ID']);
		if(sizeof($orderList) < 2):
			$this->session->set_flashdata('error', 'Need atleast 2 item for merge');
			redirect($_SERVER['HTTP_REFERER']);
		else:
			$orderDetails = $merge_ids = $order_delete_ids = $item_delete_ids =   [];

			$total_price = $sub_total = $total_item = 0;
			$mergeOrder = $this->admin_m->single_select_by_id($orderList[0]['id'],'order_user_list');

			if($action == 'delete'){
				is_test();
				foreach($orderList as $key => $order):
					$order_delete_ids[] = $order['id'];
					foreach ($order['item_list']  as $key1 => $item) {
						$item_delete_ids[] = $item['id'];
					}
				endforeach;
				$item_delete = $this->admin_m->delete_all($item_delete_ids,'order_item_list');
				$insert = $this->admin_m->delete_all($order_delete_ids,'order_user_list');
			}

			if($action=='merge'){
				foreach($orderList as $key => $order):
					$total_price += $order['total'];
					$sub_total += $order['sub_total'];
					$total_item += $order['total_item'];
					$merge_ids[] = $order['uid'];
					foreach ($order['item_list']	as $key1 => $item) {
						$orderDetails[] = $item;
					}
				endforeach;


				$up_data = [
					'uid' => orderId(),
					'total' => $total_price,
					'sub_total' => $sub_total,
					'merge_ids' =>  json_encode($merge_ids),
					'is_order_merge' => 1,
					'merge_status' => 1,
					'created_at' => d_time(),
				];

				$data = array_replace($mergeOrder, $up_data);
				array_splice($data, 0, 1);
				$insert = $this->admin_m->insert($data,'order_user_list');
				if($insert){

					foreach($orderDetails as $item):
						array_splice($item, 0, 1);
						$newData = [
							'order_id' => $insert,
							'is_merge' =>1,
							'merge_id' => $up_data['uid'].'_'.random_string('numeric',4)
						];
						$orderItems[] = array_replace($item, $newData);
					endforeach;
					$this->admin_m->insert_all($orderItems,'order_item_list');
				}

			}

			if($insert){
				$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
				redirect($_SERVER['HTTP_REFERER']);
			}	
		endif;
	}
}


public function add_delivery(){
	is_test();
	$this->form_validation->set_rules('tracking_number', 'Tracking Number', 'trim|xss_clean');
	if ($this->form_validation->run() == FALSE) {
		$this->session->set_flashdata('error', validation_errors());
		redirect($_SERVER['HTTP_REFERER']);
	}else{	
		$data = array(
			'is_delivery' => 1,
			'status' => 2,
			'dboy_status' => 3,
			'completed_time' => d_time(),
			'delivery_date' => d_time(),
			'tracking_number' => $this->input->post('tracking_number',TRUE),
			'company_details' => $this->input->post('company_details',TRUE),
		);
		$id = $this->input->post('id');
		$insert = $this->admin_m->update($data,$id,'order_user_list');

		if($insert){
			$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
			redirect($_SERVER['HTTP_REFERER']);
		}	
	}
}


public function edit_order($order_id)
{
	$this->load->library('cart');
	$this->cart->destroy();
	$order_info = $this->admin_m->single_select_by_uid($order_id,'order_user_list');
	$item_details = $this->common_m->get_all_order_item_by_order_id($order_info['id']);
	foreach ($item_details as $key => $item) {
		$cart_data = array(
			'id'      => random_string('numeric', 4),
			'item_id' => $item['id'],
			'qty'     => $item['qty'],
			'thumb'   =>$item['thumb'],
			'img_url'   =>$item['img_url'],
			'img_type'   =>$item['img_type'],
			'price'   => $item['item_price'],
			'name'    => $item['title'],
			'is_size' => $item['is_size'],
			'is_package' => 0,
			'shop_id' => $item['shop_id'],
			'is_extras' => $item['is_extras'],
			'extra_id' => $item['extra_id'],
			'tax_fee' => !empty($item['tax_fee'])?$item['tax_fee']:0,
			'is_size' => !empty($item['is_size'])?$item['is_size']:0,
			'size_slug' => !empty($item['size_slug'])?$item['size_slug']:'',
			'sizes' =>['size_slug'=>$item['size_slug']],
			'is_pos' =>1,
			
		);
		$this->cart->insert($cart_data);
	}

	$this->session->set_userdata(['order_info'=>$order_info,'is_pos' =>1,'is_order_edit'=>1]);
	
	redirect(base_url('admin/pos'));
}


public function sendMessages() {
    $content      = array(
        "en" => 'English Message'
    );
    $hashes_array = array();
    array_push($hashes_array, array(
        "id" => "like-button",
        "text" => "Like",
        "icon" => "http://i.imgur.com/N8SN8ZS.png",
        "url" => "https://yoursite.com"
    ));
    array_push($hashes_array, array(
        "id" => "like-button-2",
        "text" => "Like2",
        "icon" => "http://i.imgur.com/N8SN8ZS.png",
        "url" => "https://yoursite.com"
    ));
    $fields = array(
        'app_id' => "8293c687-29f4-4a3e-9aef-0bbae602b4de",
        'included_segments' => array(
            'Subscribed Users'
        ),
        'data' => array(
            "foo" => "bar"
        ),
        'contents' => $content,
        'web_buttons' => $hashes_array
    );
    
    $fields = json_encode($fields);
    print("\nJSON sent:\n");
    print($fields);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic YjI0MGQxMmItODQ3MC00NTBlLTg4NzItNGMwZWJhMDVkOWU1'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response;
}


public function delete_single_item($id,$table){
	is_test();
	$del=$this->admin_m->delete_single_item($id,$table);
	if($del){
		$this->session->set_flashdata('success', 'Item Deleted');
		redirect($_SERVER['HTTP_REFERER']);
	}else{
		$this->session->set_flashdata('error', 'Somthing worng. Error!!');
		redirect($_SERVER['HTTP_REFERER']);
	}
}

public function export_customer(){
	is_test();
	$customers=$this->admin_m->get_my_all_customer();
	$customer_list = [];
	foreach ($customers as $key => $row) {
		$customer_list[] = [
			lang('sl') => $key+1,
			lang('name') => $row['customer_name']??'',
			lang('phone') => $row['phone']??'',
			lang('email') => $row['email']??'',
			lang('address') => $row['address']??'',
		];
	}

		// Generate CSV content
        $csvData = $this->system_model->arrayToCsv($customer_list);

        // Set the headers for CSV download
        $filename = time().'_cusotmer_list.csv';
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=$filename");

        // Output the CSV file
        echo $csvData;
}




}


