<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pos extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->per_page = $this->per_page();
		$this->load->library('cart');
		$this->load->model('pos_m');
		is_login();
	}

	public function new_order(){
		$this->cart->destroy();
		$this->session->unset_userdata(['temp_data','is_order_edit','cart']);
		redirect(base_url('admin/pos'));
	}

	public function index(){
		$data = array();
		$data['page_title'] = "POS";
		$data['page'] = "POS";
		$data['user_id'] = auth('id');
		$id = auth('id');
		$config = [];
        $this->load->library('pagination');

        $per_page = $this->per_page;
        $total = $this->pos_m->get_my_all_items($catId=0,limit($id,1),0,0,$is_total=1);

		$config['base_url'] = base_url('admin/pos/ajax_pagination/');
		$config['total_rows'] = $total;
		$config['per_page'] =  $per_page;
		$this->pagination->initialize($config);

        $data['all_items'] = $this->pos_m->get_my_all_items($catId=0,limit($id,1),$per_page,0,0);
        $data['customer_list'] = $this->common_m->select_all_by_user(auth('id'),'customer_list');

        if (isset(restaurant()->is_multi_lang) && restaurant()->is_multi_lang==1) {
            $data['category_list'] = $this->pos_m->get_my_categories_ln(restaurant()->id,limit($id, 1));
        } else {
            $data['category_list'] = $this->pos_m->get_my_menu_type(restaurant()->id, limit($id, 1));
        }
        $data['shop'] = shop();
		$data['main_content'] = $this->load->view('backend/pos/home', $data, TRUE);
		$this->load->view('backend/index',$data);

	}


	protected function per_page(){
		
		$user_settings = $this->common_m->get_user_settings(auth('id')); 
		$apps = @!empty($user_settings['extra_config'])?json_decode($user_settings['extra_config']):'';
		return $per_page = isset($apps->pagination_limit) && !empty($apps->pagination_limit)?$apps->pagination_limit:12;
		
	}


	/*----------------------------------------------
	  				ITEM LIST
	----------------------------------------------*/
	public function ajax_pagination(){
		$data = array();
		$id = auth('id');
		$data['id']=$id;
        if(empty($id)){
        	redirect(base_url('error-404'));
        }

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

        $total = $this->pos_m->get_my_all_items($catId=0,limit($id,1),0,0,$is_total=1);
		$config['base_url'] = base_url('admin/pos/ajax_pagination/');
		$config['total_rows'] = $total;
		$config['per_page'] =  $per_page;
        $this->pagination->initialize($config);

        $data['all_items'] = $this->pos_m->get_my_all_items($catId=0,limit($id,1),$per_page,$offset,0);

		$result = $this->load->view('backend/pos/inc/item-thumb', $data, TRUE);
		echo json_encode(array('st'=>1,'result'=>$result));
        
    		
			
		
	}


	/*----------------------------------------------
	  				ADD TO CART
	----------------------------------------------*/

	public function add_to_cart($id,$type='')
	{
		$data = array();
		
		if($type =='package'):
			$package = $this->common_m->get_single_package_by_id($id);
			foreach ($package as $item) {
				$cart_data = array(
					'id'      => $id,
					'item_id' => $id,
					'qty'     => 1,
					'thumb'   =>$item['thumb'],
					'img_type'   =>$item['img_type'],
					'img_url'   =>$item['img_url'],
					'price'   => $item['final_price'],
					'name'    => $item['package_name'],
					'tax_fee'    => isset($item['tax_fee'])?$item['tax_fee']:0,
					'is_package' => 1,
					'is_size' => 0,
					'shop_id' => $item['shop_id'],
					'options' => array('veg' => '',),
					'is_pos' => 1,
				);
				$this->cart->insert($cart_data); 
				$data['name'] = $item['package_name'];
			}
		else:
			$item = $this->common_m->get_single_cart_items($id);
			$cart_data = array(
				'id'      => $id,
				'item_id' => $id,
				'qty'     => 1,
				'thumb'   =>$item['thumb'],
				'img_url'   =>$item['img_url'],
				'img_type'   =>$item['img_type'],
				'price'   => $item['price'],
				'name'    => $item['title'],
				'tax_fee'    => $item['tax_fee'],
				'tax_status'    => $item['tax_status'],
				'is_package' => 0,
				'is_size' => 0,
				'shop_id' => $item['shop_id'],
				'options' => array('veg' => $item['veg_type']),
				'is_pos' => 1,
			);
			$this->cart->insert($cart_data);
			$data['name'] = $item['title'];
		endif;

		$price = $this->cart->total();
		$count = $this->cart->total_items();

		$item = $this->load->view('backend/pos/inc/ajax_cart_item', $data, true);
		echo json_encode(['st'=>1,'result'=>$item]);
	}

	/*----------------------------------------------
	  	ADD TO CART USING FORM / EXTRAS
	----------------------------------------------*/
	public function add_to_cart_form()
	{
		$data = array();
		$id = base64_decode($this->input->post('item_id'));

		$item = $this->pos_m->get_single_items_details($id);

		$itemPrice = $this->input->post('item_price',true);
		$mainPrice = $this->input->post('main_price',true);

		if(isset($item->extras['is_extra']) && $item->extras['is_extra']==1 && !empty(json_decode($this->input->post('extra_id')))){
			$is_extras = 1;
			$extra_id = $this->input->post('extra_id');
			$ids = $item->id.'-'.$itemPrice;;
			$extra_info = @$this->pos_m->get_extras_name_by_id($extra_id,$item->id);
			$price = $itemPrice;
		}else{
			$is_extras = 0;
			$extra_id = '';
			$ids = $item->id.'-'.$itemPrice;
			$extra_info = '';
			if(isset($item->is_size) && $item->is_size==1):
				$price = $itemPrice;
			else:
				$price = $mainPrice;
			endif;
		}

		if(isset($item->is_size) && $item->is_size==1):
			$is_size = 1;
			$size_price = $_POST['size_price'];
			$size_slug = $_POST['size_slug'];
		else:
			$is_size = 0;
			$size_price = 0;
			$size_slug = '';
		endif;

		$cart_data = array(
	        'id'      => $ids,
	        'item_id' => $id,
	        'qty'     => 1,
	        'thumb'   =>$item->thumb,
	        'price'   => $price,
	        'extra_price'  => @$mainPrice,
	        'img_url'   =>$item->img_url,
	        'img_type'   =>$item->img_type,
	        'name'    => $item->title,
	        'tax_fee'    => $item->tax_fee,
			'tax_status'    => $item->tax_status,
		    'is_package' => 0,
			'uid' => @$item->uid,
		   	'shop_id' => $item->shop_id,
		   	'extras' => ['is_extra' => $is_extras,'extra_info' =>$extra_info,'extra_id'=>$extra_id],
	        'sizes' =>['is_size' => $is_size,'size_slug' => $size_slug,'size_price'=>$size_price],
	        'is_pos' => 1,
		);
		$this->cart->insert($cart_data);
		$item = $this->load->view('backend/pos/inc/ajax_cart_item', $data, true);
		echo json_encode(['st'=>1,'result'=>$item]);
	}

	/*----------------------------------------------
	  			REMOVE CART ITEM	
	----------------------------------------------*/
	function remove_cart_item($id){ 
        $data = array(
            'rowid' => $id, 
            'qty' => 0, 
        );
        $this->cart->update($data);
        $count = $this->cart->total_items();
        if(empty($count) || $count==0):
        	$count = 0;
        	$this->session->unset_userdata('cart');
        else:
        	$count = 1;
        endif;
        $item = $this->load->view('backend/pos/inc/ajax_cart_item', $data, true);
		echo json_encode(['st'=>1,'result'=>$item,'count'=>$count]);
    }

    /*----------------------------------------------
      				UPDATE CART ITEM
    ----------------------------------------------*/
    public function update_cart_item($rowid,$qty){
    	$data =  array();
    	$data=array(
    		'rowid'=>$rowid,
    		'qty'=> $qty
    	);
    	$update = $this->cart->update($data);;

    	if($update){
    		$count = $this->cart->total_items();
    		$price = $this->cart->total();
    		$item = $this->load->view('backend/pos/inc/ajax_cart_item', $data, true);
    		echo json_encode(['st'=>1,'result'=>$item,'total_item'=>$count,'total_price'=>$price]);
    	}

    }

    /*----------------------------------------------
      				SET DISCOUNT
    ----------------------------------------------*/

	public function set_discount(){

		$this->form_validation->set_rules('discount', 'Discount Amount', 'trim|required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(['st'=>0,'msg'=>validation_errors()]);
		}else{	
			
			$data = $this->session->userdata('cart');  
			$data['discount'] = $this->input->post('discount',true); 
			$data['shop_id'] = restaurant()->id;   
			$this->session->set_userdata('cart', $data);


			$this->session->set_userdata('cart',$data);
			$result = $this->load->view('backend/pos/inc/ajax_cart_item', $data, true);
			echo json_encode(['st'=>1,'result'=>$result]);
		}
	}



	/*----------------------------------------------
      				SET SHIPPING
    ----------------------------------------------*/

	public function set_shipping(){

		$this->form_validation->set_rules('shipping', 'Shipping Amount', 'trim|required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(['st'=>0,'msg'=>validation_errors()]);
		}else{	

			$data = $this->session->userdata('cart');  
			$data['shipping'] = $this->input->post('shipping',true);  
			$data['shop_id'] = restaurant()->id;  
			$this->session->set_userdata('cart', $data);


			$result = $this->load->view('backend/pos/inc/ajax_cart_item', $data, true);
			echo json_encode(['st'=>1,'result'=>$result]);
		}
	}







/*----------------------------------------------
  			CHECK COUPON CODE
----------------------------------------------*/
public function check_coupon_code()
{
	$code = strtoupper($this->input->post('coupon_code',true));
	$available = $this->admin_m->check_coupon_code($code,restaurant()->id);
	if(!empty($available)){
		if($available['total_used'] < $available['total_limit']){

			$data = $this->session->userdata('cart');   
			$data['coupon'] = (object) [
				'is_coupon' => 1,
				'coupon_discount' => $available['discount'],
				'coupon_code' => $available['coupon_code'],
				'total_user'=>$available['total_used']+1,
				'coupon_id'=>$available['id']
			];
			$data['shop_id'] = restaurant()->id;
			$this->session->set_userdata('cart', $data);

			
			$msg = "<p>".lang('coupon_applied_successfully')."</p>";
			$result = $this->load->view('backend/pos/inc/ajax_cart_item', $data, true);
			echo json_encode(['st'=>1,'result'=>$result,'msg'=>$msg]);

		}else{
			$msg =   "<p>".lang('coupon_code_reached_the_max_limit')."</p>";
			echo json_encode(['st'=>0,'msg'=>$msg,]);
		};
	}else{
		$msg = "<p>".lang('coupon_code_not_exists')."</p>";
		echo json_encode(['st'=>0,'msg'=>$msg,]);
	}

}



/*----------------------------------------------
  		ITEM DETAILS FOR MODAL
----------------------------------------------*/
public function item_details($id,$type='item'){
	$data = array();
	if($type=='item'):
		$data['item'] = $this->pos_m->get_single_items_details($id);
		$data['extras'] = $this->common_m->get_extras($id);
		$result = $this->load->view('backend/pos/inc/item_details_modal', $data, true);
	else:
		$data['item'] = $this->common_m->get_single_package_specilities($id);
		$result = $this->load->view('layouts/ajax_package_special_details_modal', $data, true);
	endif;

	echo json_encode(['st'=>1,'result'=>$result]);
}


/*----------------------------------------------
  		GET ORDER DETAILS BY ID
----------------------------------------------*/
public function get_order_layouts($shop_id,$type='cash-on-delivery'){
	$data = array();
	$cData = array();
	$this->session->unset_userdata('temp_data');
	$this->session->unset_userdata('cData');
	$data['shop_info'] = shop($shop_id);
	$data['shop_id'] = $shop_id;
	if(isset($_GET['cId']) && $_GET['cId']!=0):
		$cData = $this->admin_m->single_id($_GET['cId'],'customer_list');
	else:
		$cData = [];
	endif;
	$this->session->set_tempdata('cData', $cData, 600);
	$result = $this->order_layouts($data,$type);
	echo json_encode(['st'=>1,'result'=>$result]);
}



/*----------------------------------------------
  				ADD TABLE FOR DINE-IN
----------------------------------------------*/

public function add_table(){

	$this->form_validation->set_rules('temp_person', 'Person', 'trim|required|xss_clean');
	if ($this->form_validation->run() == FALSE) {
		echo json_encode(['st'=>0,'msg'=>validation_errors()]);
	}else{	

		$this->session->unset_userdata('temp_data');
		$shop_id = base64_decode($_POST['shop_id']);
		$checkTable = $this->pos_m->check_booked_table($_POST['temp_table_no'],$shop_id);

		$data = $this->session->userdata('temp_data');  
		$data['dine-in'] = (object) [
			'temp_id' => $order_id = date('Y').random_string('numeric',4),
			'temp_person' => $this->input->post('temp_person'),
			'temp_table_no' => $this->input->post('temp_table_no'),
			'total_person' => $checkTable+$this->input->post('temp_person'),
		];
		$data['is_dine_in'] = TRUE;    
		$data['shop_id'] = $shop_id;  

		$this->session->set_tempdata('temp_data', $data, 600);

		$data['shop_info'] = shop($shop_id);
		$result = $this->order_layouts($data,'dine-in');
		echo json_encode(['st'=>1,'result'=>$result,'shopId'=>base64_encode($shop_id)]);
	}
}


/*----------------------------------------------
  				PICKUP DETAILS
----------------------------------------------*/
public function pickup_details(){
	$pickup_info = json_decode($_POST['data']);
	$shop_id = $_POST['shop_id'];

	$this->session->unset_userdata('temp_data');
	$data = $this->session->userdata('temp_data');  
	$data['pickup'] = (object) [
		'temp_id' => $order_id = date('Y').random_string('numeric',4),
		'pickup_point_id' => $pickup_info->pickup_point_id,
		'pickup_area' => $pickup_info->pickupArea,
		'pickup_time' => $pickup_info->pickupTime,
		'pickup_date' => $pickup_info->pickupDate,
		'today' => $pickup_info->today,
	];
	$data['is_pickup'] = TRUE;      
	$data['shop_id'] = $shop_id;  

	$this->session->set_tempdata('temp_data', $data, 600);

	$data['shop_info'] = shop($shop_id);
	$result = $this->order_layouts($data,'pickup');
	echo json_encode(['st'=>1,'result'=>$result,'shopId'=>base64_encode($shop_id)]);
	
}


/*----------------------------------------------
  				ROOM_SERVICE DETAILS
----------------------------------------------*/
public function room_service_details(){
	$room_info = json_decode($_POST['data']);
	$shop_id = $_POST['shop_id'];

	$this->session->unset_userdata('temp_data');
	$data = $this->session->userdata('temp_data');  
	$data['room'] = (object) [
		'temp_id' => $order_id = date('Y').random_string('numeric',4),
		'hotel_id' => $room_info->hotel_id,
		'room_number' => $room_info->room_number,
	];
	$data['is_room_service'] = TRUE;      
	$data['shop_id'] = $shop_id;  

	$this->session->set_tempdata('temp_data', $data, 600);

	$data['shop_info'] = shop($shop_id);
	$result = $this->order_layouts($data,'room-service');
	echo json_encode(['st'=>1,'result'=>$result,'shopId'=>base64_encode($shop_id)]);
	
}


/*----------------------------------------------
  				ROOM_SERVICE DETAILS
----------------------------------------------*/
public function shipping_details(){
	$cod = json_decode($_POST['data']);
	$shop_id = $_POST['shop_id'];
	$this->session->unset_userdata('temp_data');
	$data = $this->session->userdata('temp_data');  
	$data['cod'] = (object) [
		'temp_id' => $order_id = date('Y').random_string('numeric',4),
		'shipping_area' => @$cod->shipping_area,
		'address' => $cod->address,
		'delivery_area' => $cod->delivery_area,
	];
	$data['is_cod'] = TRUE;      
	$data['shop_id'] = $shop_id;  

	$this->session->set_tempdata('temp_data', $data, 600);

	$data['shop_info'] = shop($shop_id);
	$result = $this->order_layouts($data,'cash-on-delivery');
	echo json_encode(['st'=>1,'result'=>$result,'shopId'=>base64_encode($shop_id)]);
	
}









/*----------------------------------------------
  				ORDER LAYOUTS
----------------------------------------------*/

protected function order_layouts($data,$type){
	$result = $this->load->view("backend/pos/layouts/{$type}", $data, true);
	return $result;
}



/*----------------------------------------------
  		ADD CUSTOMERS		
----------------------------------------------*/

public function add_customer(){
	$this->form_validation->set_rules('customer_name', 'Name', 'trim|required|xss_clean');
	$this->form_validation->set_rules('phone', 'Phone', 'trim|xss_clean');
	if ($this->form_validation->run() == FALSE) {
		$msg = '<div class="alert alert-danger alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong><i class="fas fa-frown"></i> </strong>'.validation_errors().'
		</div>';
		echo json_encode(['st'=>0,'msg'=>$msg]);
	}else{

		$data = array(
			'customer_name' => $this->input->post('customer_name',true),
			'phone' => $this->input->post('phone',true),
			'email' => $this->input->post('email',true),
			'country' => $this->input->post('country',true),
			'city' => $this->input->post('city',true),
			'tax_number' => $this->input->post('tax_number',true),
			'is_membership' => !empty($this->input->post('is_membership',true))?$this->input->post('is_membership',true):0,
			'address' => $this->input->post('address',true),
			'user_id' => auth('id'),
			'shop_id' => restaurant()->id,
			'created_at' => d_time(),
			'role' => 'customer',

		);	
		$insert = $this->admin_m->insert($data,'customer_list');

		if($insert){
			$load_data =[];
			$load_data['customer_list'] = $this->common_m->select_all_by_user(auth('id'),'customer_list');
			$result = $this->load->view('backend/pos/inc/customer_list', $load_data, true);
			$msg = '<div class="alert alert-success alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong><i class="fas fa-smile"></i> </strong>'.lang('success_text').'
			</div>';
			echo json_encode(['st'=>1,'msg'=>$msg,'result'=>$result]);
		}else{
			$msg = '<div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong><i class="fas fa-frown"></i> </strong>'.lang('error_text').'
			</div>';
			echo json_encode(['st'=>1,'msg'=>$msg,'result'=>'']);


		}	
	}
}



public function add_order(){
	/* Get shop_id from Cart*/ 
	$cartItems = $this->cart->contents();
	$get_shop_id = restaurant()->id;

	if(!isset($_POST['order_type'])){
		$p = price_details($get_shop_id);
		$order_info = (object)order_info();
		$data = [
			'total' => $p->grand_total,
			'is_pos' => 1,
			'created_at' => d_time(),
			'is_live_order' => 1,
			'status' => $order_info->status,
			'is_payment' => $order_info->is_payment,
			'tax_fee' => $p->tax_percent,
			'discount' => $p->discount,
		];
		$insert = $this->admin_m->update($data,$order_info->id,'order_user_list');
		if($insert){			
			$this->insert_order_item($insert,$is_delete=1);
			$this->clear_cart();
			$this->common_m->clear_auth_data();
			echo json_encode(['st'=>1,'url'=>base_url("pos-success/{$order_info->uid}")]);
			exit();
		}else{
			$msg = '<div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong><i class="fas fa-frown"></i> Sorry! </strong> Somethings were wrong!
			</div>';
			echo json_encode(['st'=>0,'msg'=>$msg]);
			exit();
		}
	}


	$order_type = $this->admin_m->single_select_by_id($_POST['order_type'],'order_types');
	$this->form_validation->set_rules('customer_id', 'Select Customer', 'trim|xss_clean|required');

	if(isset($order_type['slug']) && $order_type['slug']=='dine-in'):
		$this->form_validation->set_rules('table_no', lang('table_no'), 'trim|xss_clean|required');
		$this->form_validation->set_rules('person', lang('person'), 'trim|xss_clean|required');
	endif;


	if ($this->form_validation->run() == FALSE) {
		echo json_encode(['st'=>0,'msg'=>validation_errors()]);
	}else{	

		$data= array();

			$customer_id = $this->input->post('customer_id',true);
			if($customer_id==0){
				$name = !empty(lang('walk-in-customer'))? lang('walk-in-customer'):"Walk in customer";
				$email = '';
				$phone = '';
			}else{
				$customer_info =  single_select_by_id($customer_id,'customer_list');
				$name = $customer_info['customer_name'];
				$email = $customer_info['email'];
				$phone = $customer_info['phone'];
			}

				/* Get shop_id from Cart*/ 
				$shop_info = $this->common_m->shop_info($get_shop_id);

				/*----------------------------------------------
				orde type 1, cash on delivery
				----------------------------------------------*/
				$p = price_details($get_shop_id);
				$shop_info = $this->common_m->shop_info($get_shop_id);

				if(!empty(cart('coupon')->is_coupon) && cart('coupon')->is_coupon ==1){
					$is_coupon = 1;
					$coupon_percent = cart('coupon')->coupon_discount;
					$coupon_id = cart('coupon')->coupon_id;
				}else{
					$is_coupon = 0;
					$coupon_percent = 0;
					$coupon_id = 0;
				}



				/*----------------------------------------------
				  				PICKUP TYPE=4
				----------------------------------------------*/

				if(isset($order_type['slug']) && $order_type['slug']=='pickup'){
					$pickup_time = temp('pickup')->pickup_time;
					$today = temp('pickup')->today;

					$pickup_area = temp('pickup')->pickup_point_id;
					$date =  date('Y-m-d ').'00:00';
					if(isset($today) && $today==1){
						$pickup_date = today();
					}else{
						$pickup_date = temp('pickup')->pickup_date;
					}
					
					
				}else{
					$pickup_area = 0;
					$date = today();
					$pickup_time = '';
					$pickup_date = today();
				}


				$total_price = $p->grand_total; 

				if($order_type['slug']=='dine-in'):
					$table_no = $this->input->post('table_no');
					$person = $this->input->post('person');
				endif;

				$order_id = orderId();
				$data = array(
					'uid' => $order_id,
					'name' => $name,
					'email' => $email,
					'phone' => $phone,
					'customer_id' => $customer_id,
					'address' => '',
					'delivery_area' => !empty(temp('cod')->address)?temp('cod')->address:'',
					'order_type' => $order_type['id'],
					'is_pos' =>1,
					'payment_by' => $this->input->post('payment_type',true),
					'coupon_percent' => $coupon_percent,
					'coupon_id' => $coupon_id,
					'is_coupon' => $is_coupon,
					'table_no' => isset($table_no)?$table_no:0,
					'total_person' => isset($person)?$person:0,
					'reservation_date' => '',
					'shop_id' => $get_shop_id,
					'discount' => $p->discount,
					'tax_fee' => $p->tax_percent,
					'is_ring' => 1,
					'pickup_point' => 0,
					'total' => $total_price,
					'received_amount' => isEmpty($this->input->post('received_amount',true)),
					'sell_notes' => isEmpty($this->input->post('sell_notes',true)),
					'payment_notes' => isEmpty($this->input->post('payment_notes',true)),
					'is_live_order' => isset($_POST['is_live_order'])?1:0,
					'status' => isset($_POST['is_completed'])?2:0,
					'is_payment' => isset($_POST['is_completed'])?1:0,
					'created_at' => d_time(),
					'reservation_date' => $date,
					'pickup_time' => $pickup_time,
					'pickup_date' => $pickup_date,
					'pickup_point' => isset($pickup_area) && $pickup_area !=0?$pickup_area:0,
					'delivery_charge' => !empty($p->shipping)?$p->shipping:0,
					'shipping_id' => !empty(temp('cod')->shipping_area)?temp('cod')->shipping_area:0,
					'completed_time' => isset($_POST['is_completed'])?d_time():'',
				);
				
				$insert = $this->admin_m->insert($data,'order_user_list');
				if($insert){
					$this->insert_order_item($insert);
					echo json_encode(['st'=>1,'url'=>base_url("pos-success/{$data['uid']}")]);
					$this->confirm_order($data);
					$this->clear_cart();
					$this->common_m->clear_auth_data();
				}else{
					$msg = '<div class="alert alert-danger alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong><i class="fas fa-frown"></i> Sorry! </strong> Somethings were wrong!
					</div>';
					echo json_encode(['st'=>0,'msg'=>$msg]);
				}	
			}
		}



	protected function confirm_order($data){
		if(!empty(cart('coupon')->is_coupon) && cart('coupon')->is_coupon ==1){
			$this->admin_m->update_discount(cart('coupon')->coupon_id);
		}
		$this->pos_m->order_qr($data['uid'],$data['shop_id']);
	}


	public function order_success($orderId){
		$data = [];
		$data['page_title'] = 'Order Success';
		$check = $this->pos_m->check_order_by_id($orderId);
		if($check['check']==1 && !empty($check['result']['qr_link'])):
			$data['qrLink'] = $check['result']['qr_link'];
		else:
			$data['qrLink'] = $this->pos_m->order_qr($check['result']['uid'],$check['result']['shop_id']);
		endif;
		$data['shop_info'] = $this->common_m->get_restaurant_info_by_id($check['result']['shop_id']);
		$data['order_info'] = $check['result'];
		$data['track_link'] = base_url('track-order/'.$data['shop_info']['username'].'?orderId='.$orderId);
		$this->clear_cart();
		$data['main_content'] = $this->load->view('backend/pos/order_success', $data, TRUE);
		$this->load->view('backend/index',$data);
		
	}



	public function insert_order_item($insertId,$isDelete=0){
		if($isDelete==1){
			$this->admin_m->delete_order_items($insertId,'order_item_list');
		}
    	$cartItems = $this->cart->contents();
            // Cart items
            $ordItemData = array();
            $i=0;
            foreach($cartItems as $item){
            	if(isset($item['sizes']['is_size']) && $item['sizes']['is_size']==1){
            		$id = $item['item_id'];
            		$is_size = 1;
            		$size_slug = $item['sizes']['size_slug'];
            	}else{
            		$id = $item['item_id'];
            		$is_size = 0;
            		$size_slug = '';
            	}

            	if(isset($item['extras']['is_extra']) && $item['extras']['is_extra']==1):
            		$is_extras = 1;
            		$extra_id = $item['extras']['extra_id'];
            	else:
            		$is_extras = 0;
            		$extra_id = '';
            	endif;

                $ordItemData[$i]['order_id']     = $insertId;
                $ordItemData[$i]['shop_id']     = $item['shop_id'];
                $ordItemData[$i]['item_id']     = $id;
                $ordItemData[$i]['qty']     = $item['qty'];
                $ordItemData[$i]['package_id']     = $item['is_package']==0?0:$item['id'];
                $ordItemData[$i]['is_package']     = $item['is_package'];
                $ordItemData[$i]['sub_total'] = $item["subtotal"];
                $ordItemData[$i]['item_price'] = $item["price"];
                $ordItemData[$i]['is_size'] = $is_size;
                $ordItemData[$i]['size_slug'] = $size_slug;
                $ordItemData[$i]['is_extras'] = $is_extras;
                $ordItemData[$i]['extra_id'] = $extra_id;
                $ordItemData[$i]['created_at'] = d_time();
               	
               	$check_settings = shop($item['shop_id'])->stock_status;

               	if(isset($check_settings) && $check_settings==1):
	                if($item['is_package']==1):
	                	$info = single_select_by_id($id,'item_packages');
	                	$up_data = ['remaining' => $info['remaining']+$item['qty']];
		               	$this->admin_m->update($up_data,$id,'item_packages');
	                else:
		                $info = single_select_by_id($id,'items');
		                $up_data = ['remaining' => $info['remaining']+$item['qty']];
		               	$this->admin_m->update($up_data,$id,'items');
		            endif;
		        endif;

                 $i++;
            }
            $insert = $this->admin_m->insert_all($ordItemData,'order_item_list');
            if($insert){
            	return TRUE;
            }else{
            	return FALSE;
            }

    }



    protected function clear_cart(){
    	$this->cart->destroy();
    	$this->session->unset_userdata('temp_data');
    	$this->session->unset_userdata('cart');
    	return true;
    }


    public function destroy_cart(){
    	$this->cart->destroy();
    	$this->session->unset_userdata('temp_data');
    	$this->session->unset_userdata('cart');
    	echo json_encode(['st'=>1]);
    }

    public function get_item_name(){
    	$data = [];
    	$config = [];
    	$id = auth('id');
        $this->load->library('pagination');

        $per_page = $this->per_page;
        $total = $this->pos_m->get_my_all_items($catId=0,limit($id,1),0,0,$is_total=1);

		$config['base_url'] = base_url('admin/pos/ajax_pagination/');
		$config['total_rows'] = $total;
		$config['per_page'] =  $per_page;
		$this->pagination->initialize($config);

        $data['all_items'] = $this->pos_m->get_my_all_items($catId=0,limit($id,1),$per_page,0,0);
    	$result = $this->load->view('backend/pos/inc/item-thumb', $data, TRUE);
	    echo json_encode(['st'=>1,'result'=>$result]);
    }


    public function order_confirm_modal(){
    	$data = [];
    	if(isset($_GET['id']) && !empty($_GET['id'])):
    		$shop_id = base64_decode($_GET['id']);
	    	$data['shopId'] = $shop_id;
	    	$data['order_types'] =  $this->admin_m->get_users_order_types_by_shop_id($shop_id);
	    	$data['u_settings'] =  $this->admin_m->get_user_settings(auth('id'));
	    	$data['orderJson'] =  @json_decode($data['u_settings']['pos_config']);
	    	$result = $this->load->view('backend/pos/inc/orderModal', $data, true);
	    else:
	    	$shop_id = 0;
	    	$result = 'sorry Not Found';
	    endif;
    	
	    echo json_encode(['st'=>1,'result'=>$result,'shopId'=>base64_encode($shop_id)]);
    } 

   	public function order_details_modal(){
    	$data = [];
    	if(isset($_GET['id']) && !empty($_GET['id'])):
    		if(is_numeric($_GET['id'])){
    			$shop_id = $_GET['id'];
    		}else{
    			$shop_id = base64_decode($_GET['id']);
    		}
    		
	    	$data['shopId'] = $shop_id;
	    	$data['shop_info'] = shop($shop_id);
	    	$data['p'] =  price_details($shop_id);
	    	$data['order_info'] = single($_GET['order_type'],'order_types');
	    	$result = $this->load->view('backend/pos/inc/order_details_modal', $data, true);
	    else:
	    	$shop_id = 0;
	    	$result = 'sorry Not Found';
	    endif;
    	
	    echo json_encode(['st'=>1,'result'=>$result,'shopId'=>base64_encode($shop_id)]);
    }



    public function get_item_name__old(){
    	$itemNames = $this->pos_m->get_item_name();
    	$output = '<ul id="searchResult">';
    	if(count($itemNames) >0):
	    	foreach ($itemNames as $key => $value) {
	    		$output .= '<li data-name="'.$value['title'].'">'.$value['title'].'</li>';
	    	};
	    else:
	    	$output .= '<li data-name="">Not Found</li>';
	    endif;
	    $output .= '</ul>';
	    echo json_encode(['st'=>1,'data'=>$output]);
    }


    public function settings(){
		$data = array();
		$data['page_title'] = "POS Settings";
		$data['page'] = "POS";
		$data['user_id'] = auth('id');
        $data['shop'] = shop();
        $data['order_types'] =  $this->admin_m->get_users_order_types_by_shop_id(restaurant()->id);
        $data['u_settings'] =  $this->admin_m->get_user_settings();
        $data['orderJson'] =  @json_decode($data['u_settings']['pos_config']);
		$data['main_content'] = $this->load->view('backend/pos/settings', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function pos_settings(){
		is_test();
		$this->form_validation->set_rules('is_pos[]', lang("order_typesy"), 'trim|xss_clean');
		$this->form_validation->set_rules('welcome_message', lang("welcome_message"), 'trim|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}else{	
			$is_pos = $this->input->post('is_pos');

			$pos = [
				'order_types' => json_encode($is_pos),
				'is_live_order' => $this->input->post('is_live_order',true),
				'is_completed' => $this->input->post('is_completed',true),
				'print_size' => $this->input->post('print_size',true),
				'font_size' => $this->input->post('font_size',true),
			];

			$data = [
				'pos_config' => json_encode($pos),
			];

			if($_POST['id']==0):
				$this->session->set_flashdata('error', 'Please config the settings first');
				redirect($_SERVER['HTTP_REFERER']);
			else:
				$insert = $this->admin_m->update($data,$_POST['id'],'user_settings');
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

public function expenses(){
	$data = array();
	$data['page_title'] = "Expenses";
	$data['page'] = "Expenses";
	$data['user_id'] = auth('id');
	$data['shop'] = shop();
	$data['u_settings'] =  $this->admin_m->get_user_settings();
	$data['category_list'] =  $this->admin_m->select_all_by_user('expense_category_list');
	$data['expense_list'] =  $this->pos_m->get_my_expenses();
	$data['main_content'] = $this->load->view('backend/pos/expenses', $data, TRUE);
	$this->load->view('backend/index',$data);
}

public function edit_expense($id){
	$data = array();
	$data['page_title'] = "Expenses";
	$data['page'] = "Expenses";
	$data['user_id'] = auth('id');
	$data['shop'] = shop();
	$data['is_edit'] = 1;
	$data['u_settings'] =  $this->admin_m->get_user_settings();
	$data['category_list'] =  $this->admin_m->select_all_by_user('expense_category_list');
    $data['data'] =$this->admin_m->single_select_by_id($id,'expense_list');
    valid_user($data['data']['user_id']);
	$data['main_content'] = $this->load->view('backend/pos/expenses', $data, TRUE);
	$this->load->view('backend/index',$data);
}


public function add_expense_category(){
	is_test();
	$this->form_validation->set_rules('category_name', 'Category Name', 'trim|xss_clean|required');
	if ($this->form_validation->run() == FALSE) {
		$this->session->set_flashdata('error', validation_errors());
		redirect($_SERVER['HTTP_REFERER']);
	}else{	
		$data = [
			'category_name' => $this->input->post('category_name',true),
			'shop_id' => restaurant()->id,
			'user_id' => auth('id'),
		];

		if($_POST['id']==0):
			$insert = $this->admin_m->insert($data,'expense_category_list');
		else:
			$insert = $this->admin_m->update($data,$_POST['id'],'expense_category_list');
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

public function add_expense(){
	is_test();
	$this->form_validation->set_rules('category_id', 'Category Name', 'trim|xss_clean|required');
	$this->form_validation->set_rules('title', 'Title', 'trim|xss_clean|required');
	$this->form_validation->set_rules('date', 'Date', 'trim|xss_clean|required');
	$this->form_validation->set_rules('amount', 'Amount', 'trim|xss_clean|required');
	if ($this->form_validation->run() == FALSE) {
		$this->session->set_flashdata('error', validation_errors());
		redirect($_SERVER['HTTP_REFERER']);
	}else{	
		$data = [
			'category_id' => $this->input->post('category_id',true),
			'title' => $this->input->post('title',true),
			'created_at' => date_time($this->input->post('date',true)),
			'notes' => $this->input->post('notes'),
			'amount' => $this->input->post('amount'),
			'shop_id' => restaurant()->id,
			'user_id' => auth('id'),
		];

		if(isset($_POST['id']) && $_POST['id']!=0):
			$insert = $this->admin_m->update($data,$_POST['id'],'expense_list');
		else:
			$insert = $this->admin_m->insert($data,'expense_list');
		endif;

		if($insert){
			$this->upload_img($insert,'expense_list');
			$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
			redirect($_SERVER['HTTP_REFERER']);
		}	
	}
}


public function reset(){
	$this->cart->destroy();
	$this->session->unset_userdata('temp_data');
	$this->session->unset_userdata('cart');
	redirect($_SERVER['HTTP_REFERER']);
}

public function upload_img($id=0,$table='')
{

	if(!empty($_FILES['images']['name'])){
		$directory = 'uploads/site_images/';
		$dir = $directory;
		$name = $_FILES['images']['name'];
		list($txt, $ext) = explode(".", $name);
		$image_name = md5(time()).".".$ext;
		$tmp = $_FILES['images']['tmp_name'];
		if(move_uploaded_file($tmp, $dir.$image_name)){
			$url = $dir.$image_name;
			$data = array('images' => $url);
			$this->admin_m->update($data,$id,$table);	
		}else{
			echo "image uploading failed";
		}
	}

}

}
