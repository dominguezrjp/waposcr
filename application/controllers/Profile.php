<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('cart');
        if (d_auth('is_discount')==true) {
            $this->coupon_id = !empty(d_auth('coupon_id'))?d_auth('coupon_id'):0;
        } else {
            $this->coupon_id = 0;
        }
    }


    public function push()
    {
        $this->input->set_cookie('is_ring', '1', 300);
        // $this->system_model->order_push(8,'20230452101621');
    }

    public function index($slug = '')
    {
        $slug = custom_domain($this->url, $slug);
        $data = array();
        $data['page_title'] = "Profile";
        $data['page'] = "Profile";
        $data['slug'] = $slug;
        $data['is_share'] = 1;
        $data['is_footer'] = true;
        $id = get_id_by_slug($slug);
        $data['id']=$id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }
        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['shop_id'] = $data['shop']['id'];
        $data['social'] = json_decode($data['shop']['social_list'], true);

        
        $data['packages'] = $this->common_m->get_all_home_menu_packages($id, $limit=3);
        $data['specialties'] = $this->common_m->get_home_specilities($id, $limit=8);

        if (isset($data['shop']['is_multi_lang']) && $data['shop']['is_multi_lang']==1) {
            $data['all_items'] = $this->admin_m->get_all_items_by_user_ln($id, $limit=0, product_limit($id));
            $data['categories'] = $this->common_m->get_my_categories($id, site_lang(), limit($id, 1));
        } else {
            $data['all_items'] = $this->common_m->get_all_items_by_user($id, $limit=0, product_limit($id));
            $data['categories'] = $this->admin_m->get_my_menu_type($id, limit($id, 1));
        }
        if (isset($_GET['table']) && !empty($_GET['table'])) {
            $s_array = ['is_table'=>1,'table_no' => $_GET['table'],'shop_id'=>$id];
            $this->session->set_userdata($s_array);
        }


        if (is_feature($id, 'welcome')==1 && is_active($id, 'welcome')) :
            $data['main_content'] = $this->load->view(get_view_layouts_by_slug($slug).'/home', $data, true);
            $this->load->view(get_view_layouts_by_slug($slug).'/index', $data);
        else :
            redirect(base_url('menu/'.$slug));
        endif;

        if (!empty($id)) {
            $this->load->helper('cookie');
            $this->common_m->count_post_hit($id, 'users');
        }
    }


    public function menu($slug = '')
    {
        $slug = custom_domain($this->url, $slug);

        $data = array();
        $data['page_title'] = "Menus";
        $data['page'] = "Profile";
        $data['slug'] = $slug;
        $data['is_share'] = 1;
        $data['is_footer'] = true;
        $id = get_id_by_slug($slug);
        $data['id']=$id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }


        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['shop_id'] = $data['shop']['id'];
        $data['social'] = json_decode($data['shop']['social_list'], true);

    

        if (isset($data['shop']['is_multi_lang']) && $data['shop']['is_multi_lang']==1) {
            $data['all_items'] = $this->admin_m->get_all_items_by_user_ln($id, limit($id, 1), product_limit($id));
            $data['cat_list'] = $this->common_m->get_my_categories($id, site_lang(), limit($id, 1));
        } else {
            $data['all_items'] = $this->admin_m->get_all_items_by_user($id, limit($id, 1), product_limit($id));
            $data['cat_list'] = $this->admin_m->get_my_menu_type($id, limit($id, 1));
        }

        $data['main_content'] = $this->load->view(get_view_layouts_by_slug($slug).'/single_menu', $data, true);
        $this->load->view(get_view_layouts_by_slug($slug).'/index', $data);
    }


    public function packages($slug = '')
    {
        $slug = custom_domain($this->url, $slug);

        $data = array();
        $data['page_title'] = "Packages";
        $data['page'] = "Profile";
        $data['slug'] = $slug;
        $data['is_footer'] = true;
        $id = get_id_by_slug($slug);
        $data['id']=$id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }
        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['shop_id'] = $data['shop']['id'];
        $data['social'] = json_decode($data['shop']['social_list'], true);

        $data['packages'] = $this->common_m->get_all_menu_packages($id, limit($id, 1));
        $data['main_content'] = $this->load->view(get_view_layouts_by_slug($slug).'/single_packages', $data, true);
        $this->load->view(get_view_layouts_by_slug($slug).'/index', $data);
    }

    public function specialities($slug = '')
    {
        $slug = custom_domain($this->url, $slug);
        $data = array();
        $data['page_title'] = "Specialties";
        $data['page'] = "Profile";
        $data['slug'] = $slug;
        $data['is_footer'] = true;
        $id = get_id_by_slug($slug);
        $data['id']=$id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }
        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['shop_id'] = $data['shop']['id'];
        $data['social'] = json_decode($data['shop']['social_list'], true);

        $data['specialties'] = $this->common_m->get_specilities($id, limit($id, 1));

        $data['main_content'] = $this->load->view(get_view_layouts_by_slug($slug).'/single_special', $data, true);
        $this->load->view(get_view_layouts_by_slug($slug).'/index', $data);
    }

    public function single($slug = '', $cat_id = '')
    {
        $slug = custom_domain($this->url, $slug);

        $data = array();
        $data['page_title'] = "Item";
        $data['page'] = "Profile";
        $data['slug'] = $slug;
        $data['cat_id'] = $cat_id;
        $data['is_search'] = true;
        $data['is_footer'] = true;
        $id = get_id_by_slug($slug);
        $data['id']=$id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }
        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['shop_id'] = $data['shop']['id'];
        $data['social'] = json_decode($data['shop']['social_list'], true);

        if (isset($data['shop']['is_multi_lang']) && $data['shop']['is_multi_lang']==1) :
            $data['cat_info'] = $this->common_m->get_cat_info_by_id_ln($id, $cat_id);
        else :
            $data['cat_info'] = $this->common_m->get_cat_info_by_id($id, $cat_id);
        endif;
        // pagination
        $config = [];
        $this->load->library('pagination');


        $per_page = $this->per_page($id);
        $total = $this->common_m->get_item_by_cat_id($id, $cat_id, limit($id, 1), 0, 0, $is_total=1);
        $config['base_url'] = base_url('profile/ajax_pagination/'.$slug.'/'.$cat_id);
        $config['total_rows'] = $total;
        $config['per_page'] =  $per_page;
        $this->pagination->initialize($config);
    
        if (!empty($data['cat_info'])) :
            if (isset($data['shop']['is_multi_lang']) && $data['shop']['is_multi_lang']==1) :
                $data['item_list'] = $this->common_m->get_item_by_cat_id_ln($id, $cat_id, limit($id, 1), $per_page, 0, 0);
            else :
                $data['item_list'] = $this->common_m->get_item_by_cat_id($id, $cat_id, limit($id, 1), $per_page, 0, 0);
            endif;
        else :
            $data['item_list'] = [];
        endif;

        if (isset($data['shop']['is_multi_lang']) && $data['shop']['is_multi_lang']==1) {
            $data['cat_list'] = $this->common_m->get_my_categories($id, site_lang(), limit($id, 1));
        } else {
            $data['cat_list'] = $this->admin_m->get_my_menu_type($id, limit($id, 1));
        }
        $data['main_content'] = $this->load->view(get_view_layouts_by_slug($slug).'/single_category', $data, true);
        $this->load->view(get_view_layouts_by_slug($slug).'/index', $data);
    }

    public function ajax_pagination($slug = '', $cat_id = '')
    {
        $slug = custom_domain($this->url, $slug);
        $data = array();
        $data['slug'] = $slug;
        $data['cat_id'] = $cat_id;
        $data['is_footer'] = true;
        $id = get_id_by_slug($slug);
        $data['id']=$id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }
        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['cat_info'] = $this->common_m->get_cat_info_by_id($id, $cat_id);
        $data['shop_id'] = $data['shop']['id'];
        $data['social'] = json_decode($data['shop']['social_list'], true);


        //pagination
        $config = [];
        $this->load->library('pagination');
        $per_page = $this->per_page($id);
        ;

        $page = $this->input->get('page');
        if (empty($page)) {
            $page = 0;
        }

        if ($page != 0) {
            $page = $page-1;
        }
        $offset = ceil($page * $per_page);

    

        if (isset($data['shop']['is_multi_lang']) && $data['shop']['is_multi_lang']==1) {
            $total = $this->common_m->get_item_by_cat_id_ln($id, $cat_id, limit($id, 1), 0, 0, $is_total=1);
        } else {
            $total = $this->common_m->get_item_by_cat_id($id, $cat_id, limit($id, 1), 0, 0, $is_total=1);
        }
        $config['base_url'] = base_url('profile/ajax_pagination/'.$slug.'/'.$cat_id);
        $config['total_rows'] = $total;
        $config['per_page'] =  $per_page;
        $this->pagination->initialize($config);




        if (isset($data['shop']['is_multi_lang']) && $data['shop']['is_multi_lang']==1) {
            $data['item_list'] = $this->common_m->get_item_by_cat_id_ln($id, $cat_id, limit($id, 1), $per_page, $offset, 0);
            $data['cat_list'] = $this->common_m->get_my_categories($id, site_lang(), limit($id, 1));
        } else {
            $data['cat_list'] = $this->admin_m->get_my_menu_type($id, limit($id, 1));
            $data['item_list'] = $this->common_m->get_item_by_cat_id($id, $cat_id, limit($id, 1), $per_page, $offset, 0);
        }


        $result = $this->load->view(get_view_layouts_by_slug($slug).'/include/ajax_single_item_list', $data, true);
        echo json_encode(array('st'=>1,'result'=>$result));
    }


    public function item_details($id, $type = 'item')
    {
        $data = array();
        if ($type=='item') :
            $data['item'] = $this->common_m->get_single_items($id);
            $data['extras'] = $this->common_m->get_extras($id);
            $item = $this->load->view('layouts/ajax_item_details_modal', $data, true);
        else :
            $data['item'] = $this->common_m->get_single_package_specilities($id);
            $item = $this->load->view('layouts/ajax_package_special_details_modal', $data, true);
        endif;

        echo json_encode(['st'=>1,'load_data'=>$item]);
    }

    public function check_existing_shop($shop_id)
    {
        $data = [];
        $cartItems = $this->cart->contents();
        if (!empty($cartItems)) :
            $get_shop_id = [];
            foreach ($cartItems as $key => $shop_ids) {
                $get_shop_id[] = $shop_ids['shop_id'];
            }
            $cartShop = $get_shop_id[0];
            if ($shop_id != $cartShop) {
                $shop_info = shop($cartShop);
                $data['shop_name'] = isset($shop_info->name) && !empty($shop_info->name)?$shop_info->name:$shop_info->username;
                $result =  $this->load->view('common_layouts/cart_conflict_modal', $data, true);
                echo json_encode(['st'=>0,'is_conflict'=>1,'load_data'=>$result]);
                exit();
            } else {
                return 1;
            }
        else:
            return 1;
        endif;
    }

    protected function cartInfo($id){
        if($id==0){
            return 0;
        }else{
            $data = [];
            $s = shop($id);
            $data['slug'] = $s->username;
            $data['shop_id'] = $id;
            $data['u_info'] = get_user_info_by_slug($s->username);
            return $this->load->view('common_layouts/cart_floating_icon', $data, true);
        }

    }
    public function add_to_cart($id, $type = '')
    {

        $data = array();
        if ($type =='package') :
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
                'options' => array('veg' => '',)
                );
                $is_cart = $this->check_existing_shop($cart_data['shop_id']);

                $this->cart->insert($cart_data);
                $data['name'] = $item['package_name'];
            }
        else :
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
            'options' => array('veg' => $item['veg_type'])
            );
           $is_cart =  $this->check_existing_shop($cart_data['shop_id']);
            $this->cart->insert($cart_data);
            $data['name'] = $item['title'];
        endif;

        $price = $this->cart->format_number($this->cart->total());
        if(isset($is_cart) && $is_cart==1):
            $count = $this->cartInfo($cart_data['shop_id']); // cart floating icon 
        else:
            $count = 0;
        endif;
        $item = $this->load->view('layouts/ajax_cart_item', $data, true);
        $notify = $this->load->view('layouts/ajax_add_to_cart_notify', $data, true);
        echo json_encode(['st'=>1,'load_data'=>$item,'notify'=>$notify,'total_item'=>$count,'total_price'=>$price]);
    }


    public function add_to_cart_item_form()
    {

        $data = array();
        $id = $this->input->post('item_id');
        $item_comments = $this->security->xss_clean(trim($_POST['item_comments']));
        $item = $this->common_m->get_single_cart_items($id);
        $is_extra = $this->admin_m->check_extra_by_item_id($id);
        if ($is_extra['check']==1 && !empty($this->input->post('extra_id'))) {
            $is_extras = 1;
            $extra_id = $this->input->post('extra_id');
            $ids =  $id.'-'.$this->input->post('item_size').random_string('numeric', 4);
        } else {
            $is_extras = 0;
            $extra_id = '';
            $ids = $id;
        }

        $cart_data = array(
        'id'      => $ids,
        'item_id' => $id,
        'qty'     => 1,
        'thumb'   =>$item['thumb'],
        'img_url'   =>$item['img_url'],
        'img_type'   =>$item['img_type'],
        'price'   => $this->input->post('item_price'),
        'name'    => $item['title'],
        'is_size' => 0,
        'is_package' => 0,
        'shop_id' => $item['shop_id'],
        'tax_fee'    => $item['tax_fee'],
        'tax_status'    => $item['tax_status'],
        'is_extras' => $is_extras,
        'extra_id' => $extra_id,
        'item_comments' => isset($item_comments)?$item_comments:'',
        'options' => array('veg' => $item['veg_type'])
        );
        $data['name'] = $item['title'];
        $is_cart =  $this->check_existing_shop($cart_data['shop_id']);
        $this->cart->insert($cart_data);
        $price = $this->cart->format_number($this->cart->total());
        if(isset($is_cart) && $is_cart==1):
            $count = $this->cartInfo($cart_data['shop_id']); // cart floating icon 
        else:
            $count = 0;
        endif;
        $notify = $this->load->view('layouts/ajax_add_to_cart_notify', $data, true);
        $item = $this->load->view('layouts/ajax_cart_item', $data, true);
        echo json_encode(['st'=>1,'load_data'=>$item,'notify'=>$notify,'total_item'=>$count,'total_price'=>$price]);
    }


    public function add_to_cart_form()
    {
        $data = array();
        $id = $this->input->post('item_id');
        $item = $this->common_m->get_single_cart_items($id);


        $is_extra = $this->admin_m->check_extra_by_item_id($id);

        if ($is_extra['check']==1 && !empty($this->input->post('extra_id'))) {
            $is_extras = 1;
            $extra_id = $this->input->post('extra_id');
            $title =  $item['title'];
            $ids =  $id.'-'.$this->input->post('item_size').random_string('numeric', 4);
        } else {
            $is_extras = 0;
            $extra_id = '';
            $title = $item['title'];
            $ids = $id.'-'.$this->input->post('item_size').'-1';
        }

        $item_comments = $this->security->xss_clean(trim($_POST['item_comments']));

        $cart_data = array(
        'id'      => $ids,
        'item_id' => $id,
        'qty'     => 1,
        'thumb'   =>$item['thumb'],
        'img_url'   =>$item['img_url'],
        'img_type'   =>$item['img_type'],
        'price'   => $this->input->post('item_price'),
        'name'    => $title,
        'is_size' => 1,
        'is_package' => 0,
        'shop_id' => $item['shop_id'],
        'is_extras' => $is_extras,
        'tax_fee'    => $item['tax_fee'],
        'tax_status'    => $item['tax_status'],
        'extra_id' => $extra_id,
        'item_comments' => isset($item_comments)?$item_comments:'',
        'sizes' =>['size_slug'=>$this->input->post('item_size')]
        );
        $data['name'] = $item['title'];
        $is_cart =  $this->check_existing_shop($cart_data['shop_id']);

        $this->cart->insert($cart_data);
        $price = $this->cart->format_number($this->cart->total());

        if(isset($is_cart) && $is_cart==1):
            $count = $this->cartInfo($cart_data['shop_id']); // cart floating icon 
        else:
            $count = 0;
        endif;
        $notify = $this->load->view('layouts/ajax_add_to_cart_notify', $data, true);
        $item = $this->load->view('layouts/ajax_cart_item', $data, true);
        echo json_encode(['st'=>1,'load_data'=>$item,'notify'=>$notify,'total_item'=>$count,'total_price'=>$price]);
    }

    public function update_cart_item($rowid, $qty)
    {
        $data =  array();
        $data=array(
        'rowid'=>$rowid,
        'qty'=> $qty
        );
        $update = $this->cart->update($data);
        ;

        if ($update) {
            $count = $this->cartInfo(cart_id()); // cart floating icon 
            $price = $this->cart->format_number($this->cart->total());
            $item = $this->load->view('layouts/ajax_cart_item', $data, true);
            $order_item = $this->load->view('layouts/ajax_checkout_order_modal', $data, true);
            $checkout_items = $this->load->view('layouts/checkout_content', $data, true);
            echo json_encode(['st'=>1,'load_data'=>$item,'order_item'=>$order_item,'total_item'=>$count,'total_price'=>$price,'checkout_items'=>$checkout_items]);
        }
    }


    public function show_order_modal()
    {
        if (ACTIVATE==0) {
            return false;
            exit();
        }
        $data = array();
        $price = $this->cart->format_number($this->cart->total());
        $count = $this->cart->total_items();
        $item = $this->load->view('layouts/ajax_checkout_order_modal', $data, true);

        echo json_encode(['st'=>1,'load_data'=>$item,'total_item'=>$count,'total_price'=>$price]);
    }

    function remove_cart_item($id)
    {
        $data = array(
        'rowid' => $id,
        'qty' => 0,
        );
        $this->cart->update($data);
        $count = $this->cartInfo(cart_id());
        $price = $this->cart->format_number($this->cart->total());
        $item = $this->load->view('layouts/ajax_cart_item', $data, true);
        $order_item = $this->load->view('layouts/ajax_checkout_order_modal', $data, true);
        $checkout_items = $this->load->view('layouts/checkout_content', $data, true);
        echo json_encode(['st'=>1,'load_data'=>$item,'order_item'=>$order_item,'total_item'=>$count,'total_price'=>$price,'checkout_items'=>$checkout_items]);
    }

    public function payment($slug = '')
    {
        $slug = custom_domain($this->url, $slug);

        $data = array();
        $data['page_title'] = "Payment Gateway";
        $data['page'] = "Profile";
        $data['slug'] = $slug;
        $data['is_footer'] = true;
        $id = get_id_by_slug($slug);
        $data['id']=$id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }
        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['social'] = json_decode($data['shop']['social_list'], true);

        $data['main_content'] = $this->load->view('payment/payment_gateway', $data, true);
        $this->load->view('payment_index', $data);
    }

    public function checkout($slug = '', $order_id = null)
    {
        $slug = custom_domain($this->url, $slug);
        if (ACTIVATE==0) {
            return false;
            exit();
        }
        $data = array();
        $data['page_title'] = 'Checkout';
        $data['slug'] = $slug;
        $data['is_footer'] = false;
        $id = get_id_by_slug($slug);
        $data['id']=$id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }
        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['shop_id'] = $data['shop']['id'];
        $data['social'] = json_decode($data['shop']['social_list'], true);

        $data['main_content'] = $this->load->view(get_view_layouts_by_slug($slug).'/checkout_page', $data, true);
        $this->load->view(get_view_layouts_by_slug($slug).'/index', $data);
    }





    public function order_success($slug = '', $order_id = null)
    {
        $slug = custom_domain($this->url, $slug);
        if (ACTIVATE==0) {
            return false;
            exit();
        }
        $data = array();
        $data['page_title'] = 'Checkout';
        $data['slug'] = $slug;
        $data['is_footer'] = true;
        $id = get_id_by_slug($slug);
        $data['id']=$id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }
        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['shop_id'] = $data['shop']['id'];
        $data['social'] = json_decode($data['shop']['social_list'], true);


        if (!empty($order_id)) :
            $check = $this->common_m->check_order($data['shop_id'], $order_id);
            $shop_id = $check['result']['shop_id'];
            $data['shop_id'] = $shop_id;
            $data['address'] = $check['result']['address'];
            $data['name'] = $check['result']['name'];
            $data['phone'] = $check['result']['phone'];
            $data['delivery_area'] = $check['result']['delivery_area'];
            $data['order_id'] = $check['result']['uid'];
            $data['shop_info'] = $this->common_m->get_restaurant_info_by_id($shop_id);
            $data['last_id'] = $check['result']['id'];
            $data['order_type'] = $check['result']['order_type'];
            $data['track_link'] = url('my-orders/'.$data['shop_info']['username'].'?phone='.$data['phone'].'&orderId='.$order_id);

            $order_slug = $this->common_m->single_select_by_id($data['order_type'], 'order_types')['slug'];

            if (shop($shop_id)->is_whatsapp ==1 && is_feature(shop($shop_id)->user_id, 'whatsapp')==1) :
                $whatsappfor = !empty($data['shop_info']['whatsapp_enable_for'])?json_decode($data['shop_info']['whatsapp_enable_for'], true):"";
                if (isset($whatsappfor[$order_slug]) && $whatsappfor[$order_slug]==1) :
                    $data['is_whatsapp'] = 1;
                else :
                    $data['is_whatsapp'] = 0;
                endif;
            else :
                $data['is_whatsapp'] = 0;
            endif;
            $data['info'] = ['st'=>1,'msg'=>'','load_data'=>'','order_id'=>$check['result']['uid'],'qrlink'=>$check['result']['qr_link'],'last_id'=>$check['result']['id']];
            $data['main_content'] = $this->load->view(get_view_layouts_by_slug($slug).'/order_success_page', $data, true);
            $this->load->view(get_view_layouts_by_slug($slug).'/index', $data);
        else :
            $data['main_content'] = $this->load->view(get_view_layouts_by_slug($slug).'/checkout_page', $data, true);
            $this->load->view(get_view_layouts_by_slug($slug).'/index', $data);
        endif; //check empty_order_id
    }

// add order action
    public function add_order($type = 1)
    {
        if (ACTIVATE==0) {
            return false;
            exit();
        }
        /* Get shop_id from Cart*/
        $cartItems = $this->cart->contents();
        $get_shop_id = [];
        foreach ($cartItems as $key => $shop_id) {
            $get_shop_id[] = $shop_id['shop_id'];
        }

        $order_type = $this->input->post('order_type', true);
        $is_payment = $this->input->post('is_payment', true);
        $use_payment = $this->input->post('use_payment', true);
        $is_guest_login = $this->input->post('is_guest_login', true);

        $is_change = $this->input->post('is_change', true);
        $change_amount = $this->input->post('change_amount', true);

        // shop info by id
        $shop_info = $this->common_m->shop_info($get_shop_id[0]);
        $shop_id = $get_shop_id[0];

        // available days by id
        $time =$this->common_m->get_single_appoinment(date('w'), $get_shop_id[0]);

        if (empty($time) && $order_type==4) :
            $this->form_validation->set_rules('pickup_time', lang('pickup_time'), 'trim|required|xss_clean', array('required' => !empty(lang('required_alert'))?lang('required_alert'):"%s field is required"));
        endif;

        if (isset($order_type) && $order_type==4) :
            $this->form_validation->set_rules('pickup_point_id', lang('pickup_area'), 'trim|required|xss_clean', array('required' => !empty(lang('required_alert'))?lang('required_alert'):"%s field is required"));
            $this->form_validation->set_rules('pickup_time', lang('pickup_time'), 'trim|required|xss_clean', array('required' => !empty(lang('required_alert'))?lang('required_alert'):"%s field is required"));
        endif;

        if (isset($is_guest_login) && $is_guest_login==1) :
            $guest_login =1;
        else :
            if ($shop_info['is_customer_login']==0) :
                $this->form_validation->set_rules('name', lang('name'), 'trim|required|xss_clean', array('required' => !empty(lang('required_alert'))?lang('required_alert'):"%s field is required"));

                $this->form_validation->set_rules('phone', lang('phone'), 'trim|xss_clean|required', array('required' => !empty(lang('required_alert'))?lang('required_alert'):"%s field is required"));

                if (isset($shop_info['is_checkout_mail'])&& $shop_info['is_checkout_mail']==1) {
                    $this->form_validation->set_rules('email', lang('email'), 'trim|xss_clean|required', array('required' => !empty(lang('required_alert'))?lang('required_alert'):"%s field is required"));
                }
            endif;
            $guest_login = 0;
        endif;

        if (isset($order_type) && $order_type==6) :
            $this->form_validation->set_rules('table_no', lang('table_no'), 'trim|required|xss_clean', array('required' => !empty(lang('required_alert'))?lang('required_alert'):"%s field is required"));

            $this->form_validation->set_rules('person', lang('person'), 'trim|required|xss_clean', array('required' => !empty(lang('required_alert'))?lang('required_alert'):"%s field is required"));
        endif;

        $this->form_validation->set_rules('order_type', lang('order_type'), 'trim|required|xss_clean', array('required' => !empty(lang('required_alert'))?lang('required_alert'):"%s field is required"));


        if (isset($order_type) && $order_type==1) :
            $this->form_validation->set_rules('address', lang('address'), 'trim|required|xss_clean', array('required' => !empty(lang('required_alert'))?lang('required_alert'):"%s field is required"));

            $this->form_validation->set_rules('delivery_area', 'Google Map link', 'trim|xss_clean');

            if ($shop_info['is_area_delivery']==1) :
                $this->form_validation->set_rules('shipping_area', lang('shipping_address'), 'trim|xss_clean|required', array('required' => !empty(lang('required_alert'))?lang('required_alert'):"%s field is required"));
            endif;
        elseif (isset($order_type) && $order_type==2) :
            $this->form_validation->set_rules('reservation_date', lang('booking_date'), 'trim|required|xss_clean', array('required' => !empty(lang('required_alert'))?lang('required_alert'):"%s field is required"));

            $this->form_validation->set_rules('total_person', lang('person'), 'trim|required|xss_clean', array('required' => !empty(lang('required_alert'))?lang('required_alert'):"%s field is required"));
        endif;

        
        
        if (isset($order_type) && $order_type==8) :
            $this->form_validation->set_rules('hotel_id', lang('hotel_name'), 'trim|required|xss_clean', array('required' => !empty(lang('required_alert'))?lang('required_alert'):"%s field is required"));
            $this->form_validation->set_rules('room_number', lang('room_numbers'), 'trim|required|xss_clean', array('required' => !empty(lang('required_alert'))?lang('required_alert'):"%s field is required"));
        endif;


        $this->form_validation->set_rules('comments', 'Any Special Request?', 'trim|xss_clean');
        $this->form_validation->set_rules('change_amount', 'Change Amount', 'trim|xss_clean');

        if ($this->form_validation->run() == false) {
            $msg = '<div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong><i class="fas fa-frown"></i> '.lang("sorry").' </strong> '.validation_errors().'
			</div>';
            echo json_encode(['st'=>0,'msg'=>$msg]);
        } else {
            $data= array();
            /* Get shop_id from Cart*/
            

            /*----------------------------------------------
                orde type 1, cash on delivery, 5 pay-in-cash
                ----------------------------------------------*/
                $shipping_id = $this->input->post('shipping_area', true);
            if ($order_type==1) {
                if ($shop_info['is_area_delivery']==1) :
                    $shipping = $this->common_m->delivery_area_by_shop_id($shipping_id, $shop_info['shop_id']);
                    $delivery_charge = $shipping['cost'];
                else :
                        $delivery_charge = $shop_info['delivery_charge_in'];
                endif;
            } else {
                $delivery_charge =0;
            }

            if ($order_type==1 || $order_type ==5) {
                $minPrice = $shop_info['min_order'];
                if ($_POST['get_price'] >= $minPrice || $minPrice == 0) {
                } else {
                    $msg = '<div class="alert alert-danger alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong><i class="fas fa-frown"></i> '.lang("sorry").' </strong> 
					<div>
						<h4>'.lang('minimum_price_msg_for_cod').'</h4>
						<p>'.lang('minimum_price').' : '.currency_position($shop_info['min_order'], $shop_info['shop_id']).'</p>
					</div>
					</div>';
                    echo json_encode(['st'=>0,'msg'=>$msg]);
                    exit();
                }
            }
                

                $reservation_date = $this->input->post('reservation_date');


            if ($order_type==2) {
                $total_person = $this->input->post('total_person', true);
            }

            /*----------------------------------------------
                order_type = 4, Pickup
                ----------------------------------------------*/
            if ($order_type==4) {
                $pickup_time = $this->input->post('pickup_time');
                $today = $this->input->post('today', true);

                $pickup_area = $this->input->post('pickup_point_id', true);
                $date =  date('Y-m-d ').$pickup_time.':00';


                if (isset($today) && $today==1) {
                    $pickup_date = today();
                } else {
                    $pickup_date =  $this->input->post('pickup_date');
                }
            } else {
                $date = $reservation_date;
                $pickup_time = '';
                $pickup_date = today();
            }

            /*----------------------------------------------
                order type 6  DINE-IN
                ----------------------------------------------*/

            if ($order_type==6) {
                $table_no = $this->input->post('table_no', true);
                $total_person = $this->input->post('person', true);
            }

                $customer_phone = $this->input->post('customer_phone');
                $customer_id = $this->input->post('customer_id');


            if (isset($is_guest_login) && $is_guest_login==1) :
                $guest_login =1;
            else :
                if ($shop_info['is_customer_login']==1) :
                    $customer_info = $this->admin_m->single_select_by_id(auth('customer_id'), 'customer_list');


                    if (empty($customer_info)) {
                        $msg = '<div class="alert alert-danger alert-dismissible">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<strong><i class="fas fa-frown"></i> '.lang("sorry").' </strong> Customer Information not found
							</div>';
                        echo json_encode(['st'=>0,'msg'=>$msg]);
                        exit();
                    } else {
                        $country = s_id($customer_info['country_id'], 'country');
                        $name = $customer_info['customer_name'];
                        $email = !empty($customer_info['email'])?$customer_info['email']:'';
                        $customer_id = !empty($customer_id)?$customer_id:$customer_info['id'];
                        $customer_phone = !empty($customer_phone)?$customer_phone:$customer_info['phone'];
                        $phone = customer_phone($customer_phone, $country->dial_code);
                    }
                else :
                        $name =  $this->input->post('name', true);
                        $email = isset($_POST['email'])?$_POST['email']:'';
                        $phone = $this->input->post('phone', true);
                        $customer_id = 0;
                endif;
                    $guest_login =0;
            endif;

                $is_coupon = $this->input->post('is_coupon', true);
            if (isset($is_coupon) && $is_coupon ==1) {
                $is_coupon = 1;
                $coupon_percent = $this->input->post('coupon_percent');
                $coupon_id = $this->input->post('coupon_id');
            } else {
                $is_coupon = 0;
                $coupon_percent = 0;
                $coupon_id = 0;
            }


                $tips = $this->input->post('tips', true);
            if (isset($tips)) {
                $tips = $tips;
            } else {
                $tips = 0;
            }

                $gmap_link = $this->input->post('delivery_area', true);
                


                $price = number_format((float)$this->cart->total(), 2, '.', '') ;
                $total_price = grand_total($price, $delivery_charge, $shop_info['discount'], $shop_info['tax_fee'], $coupon_percent, $tips, $order_type, $shop_info['tax_status']);

                $order_id = orderId();





                $data = array(
                    'uid' => $order_id,
                    'name' => $name??'',
                    'email' => $email??'',
                    'phone' => $phone??'',
                    'customer_id' => $customer_id??0,
                    'address' => $this->input->post('address', true),
                    'delivery_area' => $gmap_link,
                    'order_type' => $order_type,
                    'total_person' => isset($total_person)?$total_person:0,
                    'table_no' => isset($table_no)?$table_no:0,
                    'reservation_date' => $date,
                    'pickup_time' => $pickup_time,
                    'pickup_date' => $pickup_date,
                    'shop_id' => $get_shop_id[0],
                    'delivery_charge' => isset($delivery_charge)?$delivery_charge :0,
                    'shipping_id' => isset($shipping_id)?$shipping_id :0,
                    'is_ring' => 1,
                    'pickup_point' => isset($pickup_area) && $pickup_area !=0?$pickup_area:0,
                    'total' => $total_price,
                    'comments' => $this->input->post('comments', true),
                    'tax_fee' => $shop_info['tax_fee'],
                    'discount' => $shop_info['discount'],
                    'sub_total' => $price,
                    'is_coupon' => $is_coupon,
                    'use_payment' => isset($use_payment)?$use_payment:0,
                    'coupon_percent' => $coupon_percent,
                    'coupon_id' => $coupon_id,
                    'tips' => $tips,
                    'is_change' => isset($is_change)?$is_change:0,
                    'change_amount' => isset($change_amount)?$change_amount:0,
                    'room_number' => $this->input->post('room_number', true)??0,
                    'hotel_id' => $this->input->post('hotel_id', true)??0,
                    'is_guest_login' => $guest_login??0,
                    'created_at' => d_time(),
                );
                
                if (isset($is_payment) && $is_payment==1 && $order_type==5) :
                    $this->session->set_userdata('payment', $data);
                    $url = base_url('profile/payment/'.$shop_info['username']);
                    echo json_encode(['st'=>2,'url'=>$url]);
                    exit();
                endif;

                if (isset($use_payment) && $use_payment==1) :
                    $this->session->set_userdata('payment', $data);
                    $url = base_url('profile/payment/'.$shop_info['username']);
                    echo json_encode(['st'=>2,'url'=>$url]);
                    exit();
                endif;



                    // get merge config
                $order_merge_config = @!empty($shop_info['order_merge_config'])?json_decode($shop_info['order_merge_config']):'';

                if (isset($order_merge_config->is_order_merge) && $order_merge_config->is_order_merge==1 && $guest_login==0) :
                    $check_latest_order =  $this->common_m->check_latest_order($get_shop_id[0], $order_type, $email, $phone, $customer_id);


                    if (!empty($check_latest_order) && is_object($check_latest_order)) :
                        $recent_order = $check_latest_order;
                        $merge_id = $recent_order->uid.'_'.random_string('numeric', 4);

                        if (isset($order_merge_config->is_system) && $order_merge_config->is_system==2) {
                            if (!isset($_POST['is_merge'])) :
                                $details = "<div class='recentDetails'>
								<p class='mt-5'><b>".lang('previous_order')."</b></p>
								<ul>
								<li><span>".lang('order_id')."</span>:  <span>#{$recent_order->uid}</span></li>
								<li><span>".lang('grand_total')."</span>:  <span>".currency_position($recent_order->total, $recent_order->shop_id)."</span></li>
								</ul>
								<div>";
                                if ($order_type==6) {
                                    $table__no = $recent_order->table_no;
                                    if ($table_no==$table__no) {
                                        echo json_encode(['st'=>3,'is_merge'=>1,'details'=>$details]);
                                        exit();
                                    } else {
                                        $recent_order = 0;
                                    }
                                } elseif (in_array($order_type, ['1','9'])) {
                                    echo json_encode(['st'=>3,'is_merge'=>1,'details'=>$details]);
                                    exit();
                                };
                            elseif (isset($_POST['is_merge']) && $_POST['is_merge']==0) :
                                $recent_order = 0;
                            else :
                                $recent_order = $check_latest_order;
                            endif;
                        };
                    else :
                        $recent_order = 0;
                    endif;
                else : // check merge enable
                    $recent_order = 0;
                endif; // check merge enable



            

                if (isset($order_merge_config->is_order_merge) && $order_merge_config->is_order_merge==1 && $guest_login==0) :
                    if ($order_type == 6 && is_object($recent_order)) {
                        $table__no = $recent_order->table_no;
                        if ($table__no==$table_no) :
                            $data = [
                            'uid' =>$recent_order->uid,
                            'shop_id' =>$recent_order->shop_id,
                            'order_type' =>$recent_order->order_type,
                            'phone' =>$recent_order->phone,
                            'total' =>$total_price+$recent_order->total,
                            ];
                            $up_data = [
                            'total' => $total_price+$recent_order->total,
                            'sub_total' => $price+$recent_order->sub_total,
                            'is_order_merge' => 1,
                            'merge_status' => 1,
                            ];
                            $insert = $this->common_m->update($up_data, $recent_order->id, 'order_user_list');
                            $this->session->set_userdata(['is_merge' => 1,'merge_id'=>$merge_id]);

                            // order merge notification
                            $mergeIds = ['old_id'=>$recent_order->uid,'merge_id' => $merge_id];
                            $this->version_changes_m->pusher($shop_id, 'order_merge', $mergeIds);

                            $is_new_order = 0;
                        endif;
                    } elseif ($order_type == 1 && is_object($recent_order)) {
                        $recentData = (array) $recent_order;
                        $up_data = [
                            'total' => $total_price+$recent_order->total,
                            'sub_total' => $price+$recent_order->sub_total,
                            'is_order_merge' => 1,
                            'merge_status' => 1,
                        ];
                        $data = array_replace($recentData, $up_data);
                        $insert = $this->common_m->update($up_data, $recent_order->id, 'order_user_list');

                        $this->session->set_userdata(['is_merge' => 1,'merge_id'=>$merge_id]);

                        // order merge notification
                        $mergeIds = ['old_id'=>$recent_order->uid,'merge_id' => $merge_id];
                        $this->version_changes_m->pusher($shop_id, 'order_merge', $mergeIds);

                        $is_new_order = 0;
                    } elseif ($order_type == 9 && is_object($recent_order)) {
                        $recentData = (array) $recent_order;
                        $up_data = [
                            'total' => $total_price+$recent_order->total,
                            'sub_total' => $price+$recent_order->sub_total,
                            'is_order_merge' => 1,
                            'merge_status' => 1,
                        ];
                        $data = array_replace($recentData, $up_data);

                        $insert = $this->common_m->update($up_data, $recent_order->id, 'order_user_list');

                        $this->session->set_userdata(['is_merge' => 1,'merge_id'=>$merge_id]);

                        // order merge notification
                        $mergeIds = ['old_id'=>$recent_order->uid,'merge_id' => $merge_id];
                        $this->version_changes_m->pusher($shop_id, 'order_merge', $mergeIds);

                        $is_new_order = 0;
                    } else {
                        $is_new_order = 1;
                    }
                else :
                    $is_new_order = 1;
                endif;
                
              // $insert = 1;
                if (isset($is_new_order) && $is_new_order==1) :
                    $insert = $this->admin_m->insert($data, 'order_user_list');
                    $this->version_changes_m->pusher($shop_id, 'new_order');
                    if ($order_type == 6) :
                        $this->version_changes_m->pusher($shop_id, 'table_order');
                    endif;
                    $this->system_model->order_push($data['shop_id'], $data['uid'], 'new_order');
                endif;


                if ($insert) {
                    $this->order_info($insert, $data, $type);
                } else {
                    $msg = '<div class="alert alert-danger alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong><i class="fas fa-frown"></i> '.lang("sorry").' </strong> '.lang("error_text").'
					</div>';
                    echo json_encode(['st'=>0,'msg'=>$msg]);
                }
        }
    }

    public function order_info($insert, $info, $type)
    {
    
        $data =[];
        $order_id = $info['uid'];
        $shop_id = $info['shop_id'];
        $order_type = $info['order_type'];
        $insertItem = $this->insert_order_item($insert);
        $data['shop_info'] = $this->common_m->get_restaurant_info_by_id($shop_id);
        if ($insertItem==true) :
            $data['qrLink'] = $this->upload_m->order_qr($info['phone'], $order_id, $shop_id);
            $track_link = url('my-orders/'.$data['shop_info']['username'].'?phone='.$info['phone'].'&orderId='.$order_id);
            $msg = '<div class="alert alert-success alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong><i class="fas fa-frown"></i> '.lang("success").' </strong> '.lang("order_confirm_msg").'
				<p>'.lang("order_id").'r #'.$order_id.'</p>
				</div>';
        else :
                $msg = '<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong><i class="fas fa-frown"></i> '.lang("sorry").' </strong> '.lang("order_not_confirmed_please_try_again").'
				</div>';
        endif;


            $data['address'] = isset($info['address'])?$info['address']:'';
            $data['name'] = isset($info['name'])?$info['name']:'';
            $data['phone'] = isset($info['phone'])?$info['phone'] :"";
            ;
            $data['delivery_area'] = isset($info['delivery_area'])?$info['delivery_area'] :"";
            ;
        if ($order_type==4) {
            $data['pickup_time'] =  $info['pickup_time'];
            $data['pickup_date'] =  $info['pickup_date'];
            $pickup_point_id = $info['pickup_point'];
            $data['pickup_point'] = single_select_by_id($pickup_point_id, 'pickup_points_area')['address'];
        }




            $data['order_id'] = $order_id;
            $data['order_type'] = $order_type;
            $data['total_price'] = $info['total'];
            $data['last_id'] = $insert;

        if (shop($shop_id)->is_whatsapp ==1) :
            if ($order_type==1 || $order_type==4 || $order_type==5) :
                if ($data['shop_info']['delivery_charge_in'] !=0) {
                    $data['net_price'] = number_format($info['total'], 2);
                    $data['delivery_charge'] = $data['shop_info']['delivery_charge_in'].' '.shop($shop_id)->icon;
                } else {
                    $data['net_price'] = number_format($info['total'], 2);
                    $data['delivery_charge'] = lang('free');
                }
                $data['discount'] = get_percent($info['sub_total'], $data['shop_info']['discount']).' '.shop($shop_id)->icon;
                $data['tax_fee'] = get_percent($info['sub_total'], $data['shop_info']['tax_fee']).' '.shop($shop_id)->icon;
                $data['coupon_percent'] = get_percent($info['sub_total'], $info['coupon_percent']).' '.shop($shop_id)->icon;
                $data['tips'] = $info['tips'].' '.shop($shop_id)->icon;
                $data['sub_total'] = number_format($info['sub_total'], 2).' '.shop($shop_id)->icon;
                $load_data = $this->load->view('layouts/ajax_whatsapp_share', $data, true);
            else :
                    $load_data = '';
            endif;
        else :
                $load_data = '';
        endif;
        if ($type==1) {
            $link = '';
        } else {
            $link = base_url('order-success/'.$data['shop_info']['username'].'/'.$order_id);
        }

        if ($this->coupon_id !=0) {
            $this->admin_m->update_discount($this->coupon_id);
        }
            echo json_encode(['st'=>1,'msg'=>$msg,'shop_id'=>$shop_id,'order_id'=>$order_id,'load_data'=>$load_data,'qrlink'=>$data['qrLink'],'track_link'=>$track_link,'link'=>$link]);
            $this->cart->destroy();

            @$this->user_email_m->send_order_mail($order_id, $type=1);
    }

        
    public function insert_order_item($insertId)
    {
        $this->is__order();

        $cartItems = $this->cart->contents();
        // Cart items
        $ordItemData = array();
        $i=0;
        foreach ($cartItems as $item) {
            if (isset($item['is_size']) && $item['is_size']==1) {
                $id = $item['item_id'];
                $is_size = 1;
                $size_slug = $item['sizes']['size_slug'];
            } else {
                $id = $item['item_id'];
                $is_size = 0;
                $size_slug = '';
            }

            if (isset($item['is_extras']) && $item['is_extras']==1) :
                $is_extras = 1;
                $extra_id = $item['extra_id'];
            else :
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
                $ordItemData[$i]['is_merge'] = !empty(auth('is_merge'))?auth('is_merge'):0;
                $ordItemData[$i]['merge_id'] = !empty(auth('merge_id'))?auth('merge_id'):0;
                $ordItemData[$i]['item_comments'] = !empty($item["item_comments"])?$item["item_comments"]:'';
                $ordItemData[$i]['created_at'] = d_time();

                $check_settings = shop($item['shop_id'])->stock_status;

            if (isset($check_settings) && $check_settings==1) :
                if ($item['is_package']==1) :
                    $info = single_select_by_id($id, 'item_packages');
                    $up_data = ['remaining' => $info['remaining']+$item['qty']];
                    $this->admin_m->update($up_data, $id, 'item_packages');
                else :
                        $info = single_select_by_id($id, 'items');
                        $up_data = ['remaining' => $info['remaining']+$item['qty']];
                        $this->admin_m->update($up_data, $id, 'items');
                endif;
            endif;

                $i++;
        }
        $insert = $this->admin_m->insert_all($ordItemData, 'order_item_list');
        if ($insert) {
            $this->common_m->clear_auth_data();
            return true;
        } else {
            return false;
        }
    }

        

    public function destroy_cart()
    {
        $this->cart->destroy();
        echo json_encode(['st'=>1]);
    }

    public function clear_cart()
    {
        $this->cart->destroy();
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function number_check($val)
    {
        if (!preg_match('/^[0-9]+(\\.[0-9]+)?$/', $val)) {
            $this->form_validation->set_message('number_check', 'The {field} field must be a number or decimal.');
            return false;
        } else {
            return true;
        }
    }


    /**
      ** home page contact mail
    **/
    public function send_mail()
    {
        is_test();
        $this->form_validation->set_rules('name', 'your Name', 'trim|xss_clean|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|xss_clean|required');
        if ($this->form_validation->run() == false) {
            $msg = '<div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong><i class="fas fa-frown"></i> '.lang("sorry").' </strong> '.validation_errors().'
			</div>';
            echo json_encode(['st'=>0,'msg' =>$msg]);
        } else {
            if (isset($_POST)) :
                $setting = settings();

                if (isset($setting['is_recaptcha']) && $setting['is_recaptcha']==1) :
                    if ($this->recaptcha()==false) {
                        $msg = '<div class="alert alert-danger alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong><i class="fas fa-frown"></i> '.lang("sorry").' </strong> '.lang("robot_verification_failed").'
						</div>';
                        echo json_encode(array('st' => 0, 'msg'=> $msg));
                        exit();
                    }
                endif;

                
                $user_id = base64_decode($this->input->post('id', true));
                $setting = $this->common_m->get_user_settings($user_id);
                $site_setting = settings();
                $this->load->library('email');
                //SMTP & mail configuration
                if ($setting['email_type']==2 && isset($setting['smtp_config'])) :
                    $smtp = json_decode($setting['smtp_config'], true);
                    $config = array(
                        'protocol'  => 'smtp',
                        'smtp_host' => !empty($smtp['smtp_host'])?$smtp['smtp_host']:'smtp.gmail.com',
                        'smtp_port' => !empty($smtp['smtp_port'])?$smtp['smtp_port']:465,
                        'smtp_user' => $setting['smtp_mail'],
                        'smtp_pass' => !empty($smtp['smtp_password'])?base64_decode($smtp['smtp_password']):'',
                        'smtp_crypto' => $smtp['smtp_port']==465 || $smtp['smtp_port']==25?'ssl':'tls',
                        'mailtype'  => 'html',
                        'charset'   => 'utf-8',
                        'smtp_timeout' => 30
                    );
                    $this->email->initialize($config);
                endif;
                $this->email->set_mailtype("html");
                $this->email->set_newline("\r\n");

                $mail_array = array();
                $mail_array['name'] = $this->input->post('name', true);
                $mail_array['subject'] = $this->input->post('subjects', true);
                $mail_array['email'] = $this->input->post('email', true);
                $mail_array['message'] = $this->input->post('msg', true);

                $mail_body = $this->load->view('frontend/inc/mail_body', $mail_array, true);
                $this->email->to($setting['smtp_mail']);
                $this->email->from($this->input->post('email', true), $site_setting['site_name']);
                $this->email->subject($this->input->post('subjects', true));
                $this->email->message($mail_body);
                //Send email
                $send = $this->email->send();
                if ($send) {
                    $msg = '<div class="alert alert-success alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<p><strong>'.lang("success").' </strong>'.lang("mail_send_successfully").'</p>
					</div>';
                    echo json_encode(array('st'=>1,'msg'=>$msg));
                } else {
                    $msg = '<div class="alert alert-danger alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<p><strong>'.lang("sorry").' </strong>'.lang("error_text").'</p>
					</div>';
                    echo json_encode(array('st'=>0,'msg'=>$msg));
                }
            endif;
        }
    }

    public function track_order($slug = '')
    {
        $slug = custom_domain($this->url, $slug);
        $data = array();
        $data['page_title'] = "Track Order";
        $data['page'] = "Profile";
        $data['slug'] = $slug;
        $data['is_footer'] = false;
        $id = get_id_by_slug($slug);
        $data['id']=$id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }

        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['social'] = json_decode($data['shop']['social_list'], true);

        $data['main_content'] = $this->load->view(get_view_layouts_by_slug($slug).'/track_order', $data, true);
        $this->load->view(get_view_layouts_by_slug($slug).'/index', $data);
    }

    public function track_order_list($slug)
    {
        $this->form_validation->set_rules('phone', lang("phone"), 'trim|required|xss_clean');
        $this->form_validation->set_rules('order_id', lang("order_id"), 'trim|xss_clean');
        if ($this->form_validation->run() == false) {
            $msg = '<div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<p><strong>'.lang("sorry").' </strong>'.validation_errors().'</p>
			</div>';
            echo json_encode(['st'=>0,'msg'=>$msg]);
        } else {
            $data = [];
            $data['page_title'] = "Track Order";
            $data['page'] = "Profile";
            $data['slug'] = $slug;
            
            $phone = $this->input->post('phone', true);
            $order_id = $this->input->post('order_id', true);
            $shop_id = base64_decode($this->input->post('shop_id', true));
            if (isset($order_id) & !empty($order_id)) {
                $order_id=$order_id;
            } else {
                $order_id=0;
            }

            $pin_number = $this->input->post('pin_number', true);
            if (shop($shop_id)->is_pin==1) :
                $check_pin = $this->common_m->check_pin($shop_id, $pin_number);
            else :
                $check_pin = 1;
            endif;

            if ($check_pin==1) :
                $data['phone'] = $phone;
                $data['order_id'] = $order_id;

                $id = get_id_by_slug($slug);
                $data['id']=$id;
                if (empty($id)) {
                    redirect(base_url('error-404'));
                }
                $data['user'] = $this->admin_m->get_profile_info($id);
                $data['shop'] = $this->admin_m->get_restaurant_info($id);
                $data['order_list'] = $this->common_m->track_order($phone, $order_id, $shop_id);

                $item = $this->load->view('layouts/ajax_track_order_list', $data, true);
                echo json_encode(['st'=>1,'load_data'=>$item]);
            else :
                $msg = '<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong><i class="fas fa-frown"></i>'.lang('sorry').'! </strong> '.lang('security_pin_not_match').'
				</div>';
                echo json_encode(['st'=>0,'msg'=>$msg]);
            endif;
        }
    }





    public function all_orders($slug = '')
    {
        $slug = custom_domain($this->url, $slug);
        $data = array();
        $data['page_title'] = "All Orders";
        $data['page'] = "Profile";
        $data['slug'] = $slug;
        $data['is_footer'] = false;
        $id = get_id_by_slug($slug);
        $data['id']=$id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }
        $data['page'] = "Profile";
        $data['slug'] = $slug;
        if (isset($_GET)) {
            $phone = $_GET['phone'];
            $order_id = !empty($_GET['orderId'])?$_GET['orderId']:0;
            $shop_id = restaurant($id)->id;
            $data['order_list'] = $this->common_m->track_all_orders($phone, $shop_id, $order_id);
            $data['phone'] = $phone;
        }
        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['main_content'] = $this->load->view(get_view_layouts_by_slug($slug).'/track_order_list', $data, true);
        $this->load->view(get_view_layouts_by_slug($slug).'/index', $data);
    }

    public function get_time_by_date($id, $user_id)
    {
        $time = $this->common_m->get_time_using_id($id, $user_id);
        echo json_encode(['st'=>1,'end_time'=>$time['end_time'],'start_time'=>$time['start_time']]);
    }


    public function contacts($slug = '')
    {
        $slug = custom_domain($this->url, $slug);
        $data = array();
        $data['page_title'] = "Contacts";
        $data['page'] = "Profile";
        $data['slug'] = $slug;
        $data['is_footer'] = true;
        $id = get_id_by_slug($slug);
        $data['id']=$id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }
        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['social'] = json_decode($data['shop']['social_list'], true);


        $data['main_content'] = $this->load->view(get_view_layouts_by_slug($slug).'/contact', $data, true);
        $this->load->view(get_view_layouts_by_slug($slug).'/index', $data);
    }




    public function about($slug = '')
    {
        $slug = custom_domain($this->url, $slug);
        $data = array();
        $data['page_title'] = "About";
        $data['page'] = "Profile";
        $data['slug'] = $slug;
        $data['is_footer'] = true;
        $id = get_id_by_slug($slug);
        $data['id']=$id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }
        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['social'] = json_decode($data['shop']['social_list'], true);

        $data['main_content'] = $this->load->view(get_view_layouts_by_slug($slug).'/about', $data, true);
        $this->load->view(get_view_layouts_by_slug($slug).'/index', $data);
    }


    public function reservation($slug = '')
    {
        $slug = custom_domain($this->url, $slug);
        $data = array();
        $data['page_title'] = "Reservision";
        $data['page'] = "Profile";
        $data['slug'] = $slug;
        $data['is_footer'] = true;
        $id = get_id_by_slug($slug);
        $data['id']=$id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }
        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['social'] = json_decode($data['shop']['social_list'], true);
        $data['reservation_types'] = $this->common_m->get_all_by_shop_id(restaurant($id)->id, 'reservation_types');

        $data['main_content'] = $this->load->view(get_view_layouts_by_slug($slug).'/reservation', $data, true);
        $this->load->view(get_view_layouts_by_slug($slug).'/index', $data);
    }

    public function qr_menu($slug = '', $m_id = '')
    {
        $slug = custom_domain($this->url, $slug);
        $data = array();
        $data['page_title'] = "Single Menu";
        $data['page'] = "Profile";
        $data['slug'] = $slug;
        $data['is_footer'] = true;
        $id = get_id_by_slug($slug);
        $data['id']=$id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }
        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['shop_id'] = $data['shop']['id'];
        $data['social'] = json_decode($data['shop']['social_list'], true);

        $data['packages'] = $this->common_m->get_single_qr_menu_by_id($m_id);
        $data['main_content'] = $this->load->view(get_view_layouts_by_slug($slug).'/qr_menu', $data, true);
        $this->load->view(get_view_layouts_by_slug($slug).'/index', $data);
    }



    public function error_404()
    {
        $data = array();
        $data['page_title'] = "Error 404";
        $this->load->view('404');
    }

    public function count_copy($id)
    {
        $user = single_select_by_id($id, 'users');
        $data = array(
            'share_link' => $user['share_link'] + 1,
        );
        $this->common_m->update($data, $id, 'users');
        echo json_encode(['st'=>1]);
    }


    public function remove_customer_login()
    {
        $this->session->unset_userdata('is_customer');
        echo json_encode(['st'=>1]);
    }

    public function add_reservation()
    {
        $this->form_validation->set_rules('name', lang("your_name"), 'trim|xss_clean|required');
        $this->form_validation->set_rules('email', lang('email'), 'trim|xss_clean|valid_email');
        $this->form_validation->set_rules('phone', lang("phone"), 'trim|xss_clean|required');
        $this->form_validation->set_rules('total_guest', 'Number of guests', 'trim|xss_clean|required');
        $this->form_validation->set_rules('is_table', 'Table Reservision', 'trim|xss_clean|required');
        $this->form_validation->set_rules('reservation_date', 'Reservision Date', 'trim|xss_clean|required');
        $this->form_validation->set_rules('reservation_type', 'Reservision Type', 'trim|xss_clean|required');
        $this->form_validation->set_rules('comments', 'Any Special Request?', 'trim|xss_clean');
        if ($this->form_validation->run() == false) {
            $msg = '<div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong><i class="fas fa-frown"></i> '.lang("sorry").' </strong> '.validation_errors().'
			</div>';
            echo json_encode(['st'=>0,'msg' =>$msg]);
        } else {
            if (isset($this->setting['is_recaptcha']) && $this->setting['is_recaptcha']==1) :
                if ($this->recaptcha()==false) {
                    $msg = '<div class="alert alert-danger alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong><i class="fas fa-frown"></i> '.lang("sorry").' </strong> '.lang("robot_verification_failed").'
					</div>';
                    echo json_encode(array('st' => 0, 'msg'=> $msg));
                    exit();
                }
            endif;



            $email = $this->input->post('email', true);
            $name = $this->input->post('name', true);
            $phone = $this->input->post('phone', true);
            $total_guest = $this->input->post('total_guest', true);
            $is_table = $this->input->post('is_table', true);
            $reservation_date = $this->input->post('reservation_date', true);
            $reservation_type = $this->input->post('reservation_type', true);
            $comments = $this->input->post('comments', true);
            $shop_id = base64_decode($this->input->post('shop_id', true));

            if (isset($email) && !empty($email)) :
                $user_id = base64_decode($this->input->post('id', true));
                $setting = $this->common_m->get_user_settings($user_id);
                $site_setting = settings();
                $this->load->library('email');
                //SMTP & mail configuration
                if ($setting['email_type']==2 && isset($setting['smtp_config'])) :
                    $smtp = json_decode($setting['smtp_config'], true);
                    $config = array(
                    'protocol'  => 'smtp',
                    'smtp_host' => !empty($smtp['smtp_host'])?$smtp['smtp_host']:'smtp.gmail.com',
                    'smtp_port' => !empty($smtp['smtp_port'])?$smtp['smtp_port']:465,
                    'smtp_user' => $setting['smtp_mail'],
                    'smtp_pass' => !empty($smtp['smtp_password'])?base64_decode($smtp['smtp_password']):'',
                    'smtp_crypto' => $smtp['smtp_port']==465 || $smtp['smtp_port']==25?'ssl':'tls',
                    'mailtype'  => 'html',
                    'charset'   => 'utf-8',
                    'smtp_timeout' => 30
                    );
                    $this->email->initialize($config);
                endif;
                $this->email->set_mailtype("html");
                $this->email->set_newline("\r\n");

                $mail_array = array();
                $mail_array['name'] = $this->input->post('name', true);
                $mail_array['subject'] = 'Reservision';
                $mail_array['email'] = $this->input->post('email', true);
                $mail_array['message'] = $this->input->post('msg', true);

                $mail_body = $this->load->view('frontend/inc/mail_body', $mail_array, true);
                $this->email->to($setting['smtp_mail']);
                $this->email->from($this->input->post('email', true), $site_setting['site_name']);
                $this->email->subject($this->input->post('subjects', true));
                $this->email->message($mail_body);
            //Send email
                $send = $this->email->send();
            endif;
            $data = [
            'uid'=> random_string('numeric', 5),
            'name' =>$name,
            'phone' =>$phone,
            'email' =>$email,
            'total_person' =>$total_guest,
            'is_table' =>$is_table,
            'reservation_date' =>$reservation_date,
            'reservation_type' =>$reservation_type,
            'comments' =>$comments,
            'order_type' =>3,
            'shop_id' =>$shop_id,
            'is_ring' =>1,
            'created_at' => d_time(),
            ];
            $insert = $this->common_m->insert($data, 'order_user_list');
            if ($insert) {
                $msg = '<div class="alert alert-success alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<p><strong>'.lang("success").' </strong>'.lang("order_confirmed").'</p>
			</div>';
                echo json_encode(array('st'=>1,'msg'=>$msg));
            } else {
                $msg = '<div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<p><strong>'.lang("sorry").'</strong>'.lang("error_text").'</p>
			</div>';
                echo json_encode(array('st'=>0,'msg'=>$msg));
            }
        }
    }


    public function add_qr_order($id)
    {

        $items = $this->common_m->get_single_qr_menu_by_id($id);
        /* Get shop_id from Cart*/
        if (!empty(auth('qr_order')['item_id']) && auth('qr_order')['item_id'] == $id) {
            $check = $this->common_m->get_order_status_by_order_id(auth('qr_order')['order_id']);
            if ($check->status == 1 || $check->status == 0) :
                $msg = '<div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong><i class="fas fa-frown"></i> ! </strong> '.lang('order_running_msg').'
			</div>';
                echo json_encode(['st'=>0,'msg'=>$msg]);

                exit();
            elseif ($check->status == 2) :
                $this->session->unset_userdata('qr_order');
            endif;
        }


        $order_id = date('Y').random_string('numeric', 6);
        $token_number = date('d').'-'.random_string('numeric', 2);
        $data = array(
        'uid' => $order_id,
        'token_number' => $token_number,
        'order_type' => 7,
        'dine_id' => $items[0]['package_id'],
        'total_person' => 0,
        'table_no' => !empty($items[0]['table_no']) || $items[0]['table_no'] !=0?$items[0]['table_no']:0,
        'shop_id' => $items[0]['shop_id'],
        'is_ring' => 1,
        'status' => 0,
        'total' => $this->cart->format_number($items[0]['final_price']),
        'created_at' => d_time(),
        );

        $insert = $this->admin_m->insert($data, 'order_user_list');
        // $insert = 1;
        if ($insert) {
            $this->version_changes_m->pusher($payment['shop_id'], 'new_table_order');

            $s_array = array('order_id' =>$insert,'token_number'=>$token_number,'item_id'=>$id);
            $this->session->set_userdata('qr_order', $s_array);
            if (shop($items[0]['shop_id'])->is_kds==1) :
                $msg = '<div class="alert alert-success alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<h4>'.lang('token_number').': '.$token_number.'</h4>
			<strong><i class="fas fa-smile"></i> '.lang('congratulations').' </strong> '.lang('order_place_successfully').'
			<p> <strong>'.lang('order_number').'</strong> #'.$order_id.'.</p>
			<p>'.lang('please_wait_msg').'.</p>
			<a href='.base_url('admin/kds/live/'.md5($items[0]['shop_id'])).'>'.lang('track_order').'.</a>
			</div>';
            else :
                $msg = '<div class="alert alert-success alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<h4>'.lang('token_number').': '.$token_number.'</h4>
			<strong><i class="fas fa-smile"></i> '.lang('congratulations').' </strong> '.lang('order_place_successfully').'
			<p> <strong>'.lang('order_number').'</strong> #'.$order_id.'.</p>
			<p>'.lang('please_wait_msg').'.</p>
			
			</div>';
            endif;
            echo json_encode(['st'=>1,'msg'=>$msg]);
        } else {
            $msg = '<div class="alert alert-danger alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong><i class="fas fa-frown"></i> Sorry! </strong> Somethings were wrong!
		</div>';
            echo json_encode(['st'=>0,'msg'=>$msg]);
        }
    }

    public function review($slug = '')
    {
        $slug = custom_domain($this->url, $slug);
        $data = array();
        $data['page_title'] = "Reviews";
        $data['page'] = "Profile";
        $data['slug'] = $slug;
        $data['is_footer'] = true;
        $id = get_id_by_slug($slug);
        $data['id']=$id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }
        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['shop_id'] = $data['shop']['id'];
        $data['social'] = json_decode($data['shop']['social_list'], true);
        $data['reviews'] = $this->common_m->get_shop_reviews($data['shop_id']);
        $data['total_rating'] = $this->common_m->total_shop_rating($data['shop_id']);
        $data['total_review'] = $this->common_m->total_shop_rating($data['shop_id'], 'total');
        $data['main_content'] = $this->load->view('frontend/shop_review', $data, true);
        $this->load->view('user_index', $data);
    }



    public function call_waiter()
    {
        $this->form_validation->set_rules('table_no', lang('table_no'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $msg = '<div class="alert alert-danger alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong><i class="fas fa-frown"></i> '.lang("sorry").' </strong> '.validation_errors().'
		</div>';
            echo json_encode(['st'=>0,'msg' =>$msg]);
        } else {
            $user_id = $this->input->post('user_id', true);
            $shop_id = $this->input->post('shop_id', true);
            $table_no = $this->input->post('table_no', true);
            $pin_number = $this->input->post('pin_number', true);

            if (restaurant($user_id)->is_pin==1 && !isset($_GET)) :
                $check_pin = $this->common_m->check_pin($shop_id, $pin_number);
            else :
                $check_pin = 1;
            endif;


            if ($check_pin==1) :
                $check = $this->common_m->check_waiter_status($table_no, $shop_id);
                if ($check==1) {
                    $msg = '<div class="alert alert-danger alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong><i class="fas fa-frown"></i> '.lang('sorry').'! </strong> '.lang('waiting_notification_msg').'
					</div>';
                    echo json_encode(['st'=>0,'msg' =>$msg]);
                    exit();
                }

                $data = array(
                'table_no' => $table_no,
                'user_id' => $user_id,
                'shop_id' => $shop_id,
                'is_ring' => 1,
                'created_at' => d_time(),
                );
                $insert = $this->admin_m->insert($data, 'call_waiter_list');

                if ($insert) {
                    $this->version_changes_m->pusher($shop_id, 'call_waiter');
                    $msg = '<div class="alert alert-success alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong><i class="fas fa-smile"></i> '.lang('success').'! </strong> '.lang("call_waiter_msg").'
			</div>';
                    echo json_encode(['st'=>1,'msg' =>$msg]);
                } else {
                    $msg = '<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong><i class="fas fa-frown"></i>'.lang('sorry').'! </strong> '.lang('error_msg').'
				</div>';
                    echo json_encode(['st'=>0,'msg' =>$msg]);
                }
            else :
                $msg = '<div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong><i class="fas fa-frown"></i>'.lang('sorry').'! </strong> '.lang('security_pin_not_match').'
			</div>';
                echo json_encode(['st'=>0,'msg' =>$msg]);
            endif;
        }
    }

    public function qr_waiter($slug = '')
    {
        $slug = custom_domain($this->url, $slug);

        if (isset($_GET['table']) && !empty($_GET['table'])) :
            $table_no = $_GET['table'];

            $info = $this->common_m->single_select_by_username($slug, 'restaurant_list');

            $check = $this->common_m->check_waiter_status($table_no, $info['id']);

            if ($check==1) {
                $msg = '<div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong><i class="fas fa-frown"></i> '.lang('sorry').'! </strong> '.lang('waiting_notification_msg').'
			</div>';
                $this->session->set_flashdata('MSG', $msg);
                redirect(url("{$slug}?q=table&qr={$table_no}"));
                exit();
            }

            $data = array(
            'table_no' => $table_no,
            'user_id' => $info['user_id'],
            'shop_id' => $info['id'],
            'is_ring' => 1,
            'created_at' => d_time(),
            );
        
            $insert = $this->admin_m->insert($data, 'call_waiter_list');
        
            if ($insert) {
                $msg = '<div class="alert alert-success alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong><i class="fas fa-smile"></i> '.lang('success').'! </strong> '.lang("call_waiter_msg").'
			</div>';
                $this->session->set_flashdata('MSG', $msg);
                redirect(url("{$slug}?q=table&qr={$table_no}"));
            } else {
                $msg = '<div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong><i class="fas fa-frown"></i>'.lang('sorry').'! </strong> '.lang('error_msg').'
			</div>';
                $this->session->set_flashdata('MSG', $msg);
                redirect(url("{$slug}?q=table&qr={$table_no}"));
            }
        // else:
        //  $msg = '<div class="alert alert-danger alert-dismissible">
        //      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        //      <strong><i class="fas fa-frown"></i>'.lang('sorry').'! </strong> '.lang('error_msg').'
        //      </div>';
        //      $this->session->set_flashdata('msg', $msg);
        //      redirect(base_url("{$slug}?q=table"));
        endif;
    }

    public function reorder($uid)
    {
    
        $order_info = $this->admin_m->single_select_by_uid($uid, 'order_user_list');
        $item_details = $this->common_m->get_all_item_by_order_id($order_info['id']);
    

        $searchForValue = '-';
        $stringValue = $order_info['uid'];

        if (strpos($stringValue, $searchForValue) !== false) {
            $new_id = str_replace('-', '', strstr($stringValue, '-'));
        } else {
            $new_id = $order_info['uid'];
        }
        //count total re-order with the same uid
        $ul = $this->admin_m->count_order_id($new_id);


        $new_uid = $ul.'-'.$new_id;

        if ($order_info['use_payment']==1 || $order_info['is_payment']==1) :
            $this->cart->destroy();
            $this->session->unset_userdata('payment');


            foreach ($item_details as $key => $value) :
                $item = $this->common_m->get_single_cart_items($value['item_id']);

                if ($value['is_extras']==1) {
                    $is_extra = $this->admin_m->check_extra_by_item_id($item['id']);
                    $is_extras = 1;
                    $extra_id = $value['extra_id'];
                    $title =  $item['title'];
                    $ids =  $item['id'].'-'.$value['size_slug'].'-1';
                } else {
                    $is_extras = 0;
                    $extra_id = '';
                    $title = $item['title'];
                    $ids = $item['id'].'-'.$value['size_slug'];
                };
            

                $cart_data = array(
                    'id'      => $ids,
                    'item_id' => $item['id'],
                    'qty'     => $item['qty'],
                    'thumb'   =>$item['thumb'],
                    'img_url'   =>$item['img_url'],
                    'img_type'   =>$item['img_type'],
                    'price'   => $value['item_price'],
                    'name'    => $item['title'],
                    'is_size' => $value['is_size'],
                    'is_package' => 0,
                    'shop_id' => $item['shop_id'],
                    'is_extras' => $is_extras,
                    'extra_id' => $extra_id,
                    'sizes' =>['size_slug'=>$value['size_slug']]
                );
                $this->cart->insert($cart_data);
            endforeach;

            
            $data = array(
                'uid' => $new_uid,
                'name' => $order_info['name'],
                'email' => $order_info['email'],
                'phone' => $order_info['phone'],
                'customer_id' => $order_info['customer_id'],
                'address' => $order_info['address'],
                'delivery_area' => $order_info['delivery_area'],
                'order_type' => $order_info['order_type'],
                'total_person' => $order_info['total_person'],
                'table_no' => $order_info['table_no'],
                'reservation_date' => $order_info['reservation_date'],
                'pickup_time' => $order_info['pickup_time'],
                'pickup_date' => $order_info['pickup_date'],
                'shop_id' => $order_info['shop_id'],
                'delivery_charge' => $order_info['delivery_charge'],
                'shipping_id' => $order_info['shipping_id'],
                'is_ring' => 1,
                'pickup_point' => $order_info['pickup_point'],
                'total' => $order_info['total'],
                'comments' => $order_info['comments'],
                'tax_fee' => $order_info['tax_fee'],
                'discount' => $order_info['discount'],
                'sub_total' => $order_info['sub_total'],
                'is_coupon' => $order_info['is_coupon'],
                'use_payment' => $order_info['use_payment'],
                'coupon_percent' => $order_info['coupon_percent'],
                'tips' => $order_info['tips'],
                'created_at' => d_time(),
            );
            
            $this->session->set_userdata('payment', $data);
            redirect(base_url('profile/payment/'.shop($order_info['shop_id'])->username));
            exit();
        else :
                $new_arr = ['created_at'=>d_time(),'is_ring'=>1,'status'=>0,'uid'=>$new_uid];
                $order_info_marge = array_merge($order_info, $new_arr);
                array_splice($order_info_marge, 0, 1);
                $insert = $this->common_m->insert($order_info_marge, 'order_user_list');
            if ($insert) :
                $this->version_changes_m->pusher($payment['shop_id'], 'new_order');
                $order_list_arr = ['created_at'=>d_time(),'order_id' =>$insert];
                foreach ($item_details as $key => $value) {
                    $parray = array_merge($value, $order_list_arr);
                    array_splice($parray, 0, 1);
                    $data[] = $parray;
                }
                $this->admin_m->insert_all($data, 'order_item_list');
                $this->upload_m->order_qr($order_info['phone'], $new_uid, $order_info['shop_id']);
            endif;
                $this->session->set_flashdata('success', !empty(lang('order_place_successfully'))?lang('order_place_successfully'):'Order Place Successfully!');
                redirect($_SERVER['HTTP_REFERER']);
        endif;
    }


    public function tips($id, $tips)
    {
        $data = [];
        if (!empty(temp('is_shipping')==1)) {
            $shipping = temp('cost');
        } else {
            $shipping = 0;
        }

        if (!empty(temp('coupon_price'))) {
            $coupon_price = temp('coupon_price');
        } else {
            $coupon_price = 0;
        }

        $data['cost'] = $shipping;
        $data['coupon_price'] = $coupon_price;
        $data['tips'] = $tips;
        $data['shop_id'] = $id;
        $this->session->set_tempdata('temp_data', $data, 600);

        $load = $this->load->view('layouts/inc/checkout_total_area', $data, true);
        echo json_encode(['st'=>1,'load_data' => $load,'tips'=>$tips,'shipping'=>$shipping]);
    }

    public function shipping_address($id)
    {
        $data = [];
        $shipping  = single_select_by_id($id, 'delivery_area_list');
        $data['shop_id'] = $shipping['shop_id'];
        $data['cost'] =  $shipping['cost'];
        $data['shipping'] =  $shipping['cost'];
        $data['is_shipping'] =  1;
        $data['tips'] = !empty(temp('tips'))?temp('tips'):0;

        $this->session->set_tempdata('temp_data', $data, 600);
    
        $load = $this->load->view('layouts/inc/checkout_total_area', $data, true);
        echo json_encode(['st'=>1,'load_data' => $load,'shipping'=>$shipping['cost'],'id'=>$shipping['id']]);
    }

    public function check_coupon_code()
    {
        $this->is__order();
        $code = strtoupper($this->input->get('coupon_code', true));
        $shop_id = $this->input->get('shop_id', true);
        $price = $this->input->get('price', true);
        $shipping_cost = $this->input->get('shipping_cost');
        $last_order_type = $this->input->get('last_order_type');
        $available = $this->admin_m->check_coupon_code($code, $shop_id);
        if (!empty($available)) {
            if ($available['total_used'] < $available['total_limit']) {
                $coupon_price = get_percent($price, $available['discount']);
                $total_price = $price - $coupon_price;
                $coupon_data = [
                'is_discount'=>true,
                'discount' => $available['discount'],
                'total_user'=>$available['total_used']+1,
                'coupon_price'=>$coupon_price,
                'coupon_id'=>$available['id']
                ];

            

                $this->session->set_userdata('discount_ss', $coupon_data);

                if (isset($last_order_type) == "cash-on-delivery") :
                    if (isset($shipping_cost) && $shipping_cost !=0) :
                        $data['cost'] =  $shipping_cost;
                        $is_shipping = 1;
                    else :
                        $is_shipping = 0;
                    endif;
                else :
                    $is_shipping = 0;
                endif;

                $tData = ['coupon_price'=>$coupon_price,'is_shipping'=>$is_shipping,'shipping'=>isset($shipping_cost)?$shipping_cost:0,'tips'=>!empty(temp('tips'))?temp('tips'):0];
                $this->session->set_tempdata('temp_data', $tData, 600);

                $data['shop_id'] =$shop_id;
                $data['coupon_price'] =  $coupon_data['coupon_price'];
                $data['coupon_details'] =  $coupon_data;

                $data['tips'] = !empty(temp('tips'))?temp('tips'):0;
                $load = $this->load->view('layouts/inc/checkout_total_area', $data, true);

                $msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>'.lang('success').'!</strong> '.lang('coupon_applied_successfully').'
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
			</div>' ;
                echo json_encode(['st'=>1,'load_data' => $load,'coupon_percent'=>$available['discount'],'coupon_id'=>$available['id'],'is_shipping'=>$is_shipping]);
            } else {
                $msg = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
			<strong>'.lang('sorry').'!</strong> '.lang('coupon_code_reached_the_max_limit').'
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
			</div>' ;
                echo json_encode(['st'=>0,'msg'=>$msg,]);
            };
        } else {
            $msg = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
		<strong>'.lang('sorry').'</strong> '.lang('coupon_code_not_exists').'
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
		</button>
		</div>' ;
            echo json_encode(['st'=>0,'msg'=>$msg,]);
        }
    }


    public function reset()
    {
        $this->session->unset_userdata('temp_data');
        echo json_encode(['st'=>1]);
    }


    public function exportcvs()
    {
       // file name
        $filename = 'users_'.date('Ymd').'.csv';
         header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
         header("Content-Type: application/csv; ");

       // get data
        $usersData = $this->admin_m->get_cvs_data();

       // file creation
        $file = fopen('php://output', 'w');

        $header = array("id","keyword","english",'bn');
        fputcsv($file, $header);
        foreach ($usersData as $key => $line) {
            fputcsv($file, $line);
        }
        fclose($file);
        exit;
    }


    public function recaptcha()
    {
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
        if ($status['success']) {
            return true;
        } else {
            return false;
        }
    }


    public function get_users($user_id, $shop_id, $auth_id)
    {
        $find = $this->common_m->find_subscribers($user_id, $shop_id);
        if ($find==0) {
            $this->common_m->insert(['user_id'=>$user_id,'shop_id'=>$shop_id,'auth_id'=>$auth_id,'created_at'=>d_time()], 'subscriber_list');
        }
        echo json_encode(['st'=>1, 'userId'=>$user_id]);
    }

/*----------------------------------------------
            Check Pickup Avaialble times
----------------------------------------------*/

    public function get_pickup_available_time($shop_id, $type = 1)
    {
        $restaurant = $this->admin_m->get_shop_profile_by_shop_id($shop_id);
        $time_slots = json_decode($restaurant['pickup_time_slots'], true);

        $current_date = strtotime(d_time());

        if (date('i', $current_date) <  30) {
            $currentTime = date('H', $current_date).':00';
        } else {
            $currentTime = date('H', $current_date).':30';
        }

        $nextTime = strtotime("+30 minutes", strtotime($currentTime));
        $nextTime = date('H:i', $nextTime);


        $searchTime = $currentTime.'-'.$nextTime;
        $timeslots = $time_slots;
        ;
        $times=[];
        foreach ($timeslots as $key => $value) {
            if ($value >= $searchTime) {
                $times[] =$value;
            }
        }

        if ($type==1) {
            $data['getTmes'] =  $times;
        } else {
            $data['getTmes'] =  $time_slots;
        }

        $data['shop_id'] = $shop_id;
        $load_data = $this->load->view('layouts/inc/pickupTimeslots', $data, true);

        echo json_encode(['st'=>1,'times'=>$searchTime,'load_data'=>$load_data]);
    }

    public function is__order()
    {
        if ($this->common_m->is_order()==0) {
            return true;
            exit();
        }
    }

/*----------------------------------------------
                GET Room Numbers by Hotel ID
----------------------------------------------*/

    public function get_room_numbers($hotelId)
    {
        $restaurant = $this->admin_m->single_select_by_id($hotelId, 'hotel_list');
        $data['roomNumers'] = json_decode($restaurant['room_numbers'], true);

        $data['shop_id'] = $restaurant['shop_id'];
        $load_data = $this->load->view('layouts/inc/roomNumbers', $data, true);
        echo json_encode(['st'=>1,'load_data'=>$load_data]);
    }



    public function check_delivery_area($shop_id, $lat, $lang)
    {
        $st=$msg='';
        $restaurant = shop($shop_id);
        if (isset($restaurant->is_radius) && $restaurant->is_radius==1) :
            $radius_config = !empty($restaurant->radius_config)?json_decode($restaurant->radius_config):'';
            $radius = !empty($radius_config->radius)?$radius_config->radius:5;
            $location = [
                "lat" => $radius_config->latitude,
                "lng" => $radius_config->longitude,
            ];

            $poslat = $lat;
            $poslng = $lang;
            $get_dis = $this->distance($poslat, $poslng, $location['lat'], $location['lng'], "K");

            if ($radius >= $get_dis) {
                $latlang = 1;
            } else {
                $latlang = 0;
            };
            if ($latlang == 1) {
                $st = 1;
                $msg = $get_dis;
            } else {
                $st = 0;
                $msg = $radius_config->msg;
            }
        endif;
        echo json_encode(['st'=>$st,'msg'=>$msg]);
    }

    private function distance($lat1, $lon1, $lat2, $lon2, $unit)
    {
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
        if ($unit=="K") {
            $dist = $dist * 1.609344;
        }
        if ($unit=="N") {
            $dist = $dist * 0.8684;
        }
        return round($dist);
    }


    /*----------------------------------------------
                    GET PERSON BY TABLE ID
    ----------------------------------------------*/

    public function get_person($shop_id, $table_id)
    {
        $table_size = $this->admin_m->get_table_size($table_id, $shop_id);

        $checkTable = $this->admin_m->check_booked_table($table_id, $shop_id);
        $remainTable = !empty($checkTable)?$checkTable:0;
        $data='';
        if (isset($table_size) && !empty($table_size)) {
            if ($table_size > $remainTable) {
                for ($i = 1; $i <= ($table_size-$remainTable); $i++) {
                    echo  "<option value='${i}'>${i}</option>";
                }
                exit();
            } else {
                echo "<option value=''>".lang('table_already_booked_try_different_one')."</option>";
                ;
            }
        }
    }




    protected function per_page($id)
    {
        
        $user_settings = $this->common_m->get_user_settings($id);
        $apps = @!empty($user_settings['extra_config'])?json_decode($user_settings['extra_config']):'';
        return $per_page = isset($apps->pagination_limit) && !empty($apps->pagination_limit)?$apps->pagination_limit:12;
    }


    public function terms($slug = '')
    {
        $slug = custom_domain($this->url, $slug);
        $data = array();
        $data['page_title'] = "Terms";
        $data['page'] = "Profile";
        $data['slug'] = $slug;
        $data['is_footer'] = true;
        $id = get_id_by_slug($slug);
        $data['id']=$id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }

        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['social'] = json_decode($data['shop']['social_list'], true);

        $data['main_content'] = $this->load->view(get_view_layouts_by_slug($slug).'/terms', $data, true);
        $this->load->view(get_view_layouts_by_slug($slug).'/index', $data);
    }


    public function update_cart_sidebar($slug)
    {
        $data = [];
        $cart_id = cart_id();
        $data['slug'] = $slug;
        $id = get_id_by_slug($slug);
        $data['id']=$id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }
        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['shop_id'] = $data['shop']['id'];

        $load_data = $this->load->view('common_layouts/cart_sidebar', $data, true);
        echo json_encode(['st'=>1,'load_data'=>$load_data]);
       
    }

  
    public function whatsapp($order_id)
    {
        if (ACTIVATE==0) {
            return false;
            exit();
        }
        $order_details = $this->admin_m->single_select_by_uid_row($order_id, 'order_user_list');
        $shop_info = $this->common_m->get_restaurant_info_by_id($order_details->shop_id);
        $order_list = $this->common_m->get_order_item($order_details->id, $shop_info['shop_id']);


        $icon = $shop_info['icon'];
        $shop_id = $shop_info['shop_id'];
        $net_price = $order_details->total;

        if ($shop_info['is_area_delivery']==1) :
            $delivery_charge = $order_details->delivery_charge;
            $shpping_info = $this->common_m->delivery_area_by_shop_id($order_details->shipping_id, $shop_info['shop_id']);
        else :
            if ($shop_info['delivery_charge_in'] !=0) {
                $delivery_charge = $shop_info['delivery_charge_in'];
            } else {
                $delivery_charge = lang('free');
            };
        endif;


        $discount = get_percent($order_details->sub_total, $order_details->discount).' '.$icon;
        $coupon_percent = get_percent($order_details->sub_total, $order_details->coupon_percent).' '.$icon;
        $tax_fee = get_percent($order_details->sub_total, $order_details->tax_fee).' '.$icon;

        $tips = $order_details->tips;


        $sub_total = number_format($order_details->sub_total, 2).' '.$icon;



        $data = '';
        $i=1;

        $data .= lang('order_type')."\t : ".order_type($order_details->order_type)."\n";


        $data .= "---------------------------------------\n\n";

        foreach ($order_list as $key => $row) :
            if ($row['is_package']==1) :
                $data .= $i.". {$row['package_name']} \t {$row['qty']} x ".wh_currency_position($row['item_price'], $shop_id)."\n";
                $data .= "---------------------------------------\n";
            else :
                $data .= $i.". {$row['name']} \t {$row['qty']} x ".wh_currency_position($row['item_price'], $shop_id)."\n";
                
                if (isset($row['is_extras']) && $row['is_extras']==1) :
                    $extraId = json_decode($row['extra_id']);
                    foreach ($extraId as $key => $ex) :
                        $data .= "  1 x \t".  extras($ex, $row['item_id'])->ex_name." ".wh_currency_position(extras($ex, $row['item_id'])->ex_price, $shop_id)."\n";
                    endforeach;
                endif;
                $data .= "----------------------------------------\n";
            endif;

            
            $i++;
        endforeach;

        $data.= lang('sub_total')."\t : ".wh_currency_position($sub_total, $shop_id)."\n";

        if ($tax_fee !=0) :
            $data.= lang('tax')." \t \t: ".wh_currency_position($tax_fee, $shop_id)."\n";
        endif;

        if ($tips !=0) :
            $data.= lang('tips')."\t : ".wh_currency_position($tips, $shop_id)."\n";
        endif;

        if ($order_details->order_type ==1) :
            $data.= lang('shipping')."\t : ".wh_currency_position($delivery_charge, $shop_id)."\n";
        endif;

        if ($discount !=0) :
            $data.= lang('discount')."\t : ".wh_currency_position($discount, $shop_id)."\n";
        endif;

        if ($coupon_percent !=0) :
            $data.= lang('coupon_discount')."\t : ".wh_currency_position($coupon_percent, $shop_id)."\n";
        endif;


        $data.= "\n- - - - - - - - - - - - - - - - - - - -\n";
        $data.= "".lang('total')." : \t " . "" .wh_currency_position($net_price, $shop_id). " ";
        $data.= "\n- - - - - - - - - - - - - - - - - - - -\n\n";

        if ($order_details->is_payment==1 && !empty($order_details->payment_by)) :
            $data.= "".lang('payment_by')." : \t " . "" .$order_details->payment_by. " \n";
        endif;

        

        if ($order_details->order_type ==4) :
            if (!empty($order_details->pickup_time) || empty($order_details->pickup_point)) :
                $data .= "---------------------------------------\n";
                $data .= "\t".lang('order_details')."\n";

                if (isset($order_details->pickup_time) && !empty($order_details->pickup_time)) :
                    $data .= "- - - - - - - - - - - - - - - - - - - -\n";
                    if (isset($order_details->pickup_date)) :
                        $data.= lang('pickup_date')."\t : ".cl_format($order_details->pickup_date)."\n";
                    endif;
                    $data.= lang('pickup_time')."\t : ".$order_details->pickup_time."\n";
                endif;
                $pickup_point = single_select_by_id($order_details->pickup_point, 'pickup_points_area')['address'];
                if (isset($order_details->pickup_point) && !empty($pickup_point)) :
                    $data.= lang('pickup_point')."\t : ".$pickup_point."\n\n";
                    $data .= "---------------------------------------\n";
                endif;
            endif;
        endif; //order_details->order_type // Pickup


        if ($order_details->order_type ==2) :
            $data .= "---------------------------------------\n";
            $data .= "\t".lang('order_details')."\n";
            if (isset($order_details->total_person) && !empty($order_details->total_person)) :
                $data .= "- - - - - - - - - - - - - - - - - - - -\n";
                $data.= lang('total_person')."\t : ".$order_details->total_person."\n";
                $data.= lang('booking_date')."\t : ".cl_format($order_details->reservation_date)."\n";
            endif;
        endif; //booking

        if ($order_details->order_type ==6) :
            $data .= "---------------------------------------\n";
            $data .= "\t".lang('order_details')."\n";
            if (isset($order_details->total_person) && !empty($order_details->total_person)) :
                $table_name = single_select_by_id($order_details->table_no, 'table_list')['name'];
                $data .= "---------------------------------------\n";
                $data.= lang('total_person')."\t : ".$order_details->total_person."\n";
                $data.= lang('table_no')."\t : ".$table_name."\n";
            endif;
        endif;


        if ($order_details->order_type ==8) :
            $data .= "---------------------------------------\n";
            $data .= "\t".lang('order_details')."\n";
            if (isset($order_details->hotel_id) && !empty($order_details->hotel_id)) :
                $hotel_name = single_select_by_id($order_details->hotel_id, 'hotel_list')['hotel_name'];
                $data .= "- - - - - - - - - - - - - - - - - - - -\n";
                $data.= lang('hotel_name')."\t : ".$hotel_name."\n";
                $data.= lang('room_number')."\t : ".$order_details->room_number."\n";
            endif;
        endif; //dine-in



        $data .= "\n\n ---------------------------------------\n";
        $data .= "\t".lang('customer_details')."\n";
        $data .= "---------------------------------------\n";

        $data.= lang('phone')."\t : ".$order_details->phone."\n";


        if (isset($order_details->delivery_area) && !empty($order_details->delivery_area) && $order_details->order_type ==1) :
            $coordinates = getCoordinatesAttribute($order_details->delivery_area, $shop_info['shop_id']);
            $lat = isset($coordinates['latitude'])?$coordinates['latitude']:'';
            $lng = isset($coordinates['longitude'])?$coordinates['longitude']:'';
            $data.= lang('gmap_link')."\t : https://maps.google.com?q=".$lat.",".$lng."\n";
        endif;

        if (isset($shpping_info['area']) && !empty($shpping_info['area'])) :
            $data.= lang('delivery_area')."\t : ".$shpping_info['area']."\n";
        endif;

        if (!empty($order_details->address)) :
            $data.= lang('delivery_address')."\t : ".$order_details->address."\n";
            $data.= "---------------------------------------\n\n";
        endif;


        $track_url = base_url('my-orders/'.$shop_info['username'].'?phone='.$order_details->phone.'&orderId='.$order_id);


        $replace_data = array(
            '{CUSTOMER_NAME}' => $order_details->name,
            '{ORDER_ID}' => $order_id,
            '{ITEM_LIST}' => $data,
            '{SHOP_NAME}' => $shop_info['shop_name'],
            '{SHOP_ADDRESS}' => $shop_info['address'],
            '{TRACK_URL}' => $track_url,
        );

        $accept_message = json_decode($shop_info['whatsapp_msg']);
        $msg = create_msg($replace_data, $accept_message);
        redirect("https://api.whatsapp.com/send?phone=".$shop_info['dial_code'].$shop_info['whatsapp_number']."&text=".urlencode($msg));
        exit();
    }
}
