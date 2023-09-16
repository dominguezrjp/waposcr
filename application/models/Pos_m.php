<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pos_m extends CI_Model {
	public function __construct(){
		$this->db->query("SET sql_mode = ''");
		$this->site_lang = site_lang();

	}
	public function get_my_all_items($catId,$limit,$per_page,$offset,$total)
	{
		$is_lang = isset(restaurant()->is_multi_lang) && restaurant()->is_multi_lang==1?1:0;
		$this->db->select('i.*,i.id as item_id,a.name as allergen,c.id as cat_id,c.status,c.name as category_name');
		$this->db->from('items i');
		$this->db->join('allergens a','a.id = i.allergen_id','LEFT');
		$this->db->join('menu_type c','c.id = i.cat_id','LEFT');
	

		if(isset($_GET['q']) && !empty($_GET['q'])):
			if(is_numeric($_GET['q'])){
				$this->db->where('i.uid',$_GET['q']);
			}else{
				$this->db->like('i.title',$_GET['q']);
			}

		endif;

		
		if(isset($_REQUEST['catId']) && !empty($_REQUEST['catId']) && $_REQUEST['catId']!='all'):
			$this->db->where('md5(i.cat_id)',$_REQUEST['catId']);
			$this->db->where('c.status',1);
		endif;

		$this->db->where('i.status',1);
		$this->db->where('i.user_id',auth('id'));
		if (isset($is_lang) && $is_lang==1) {
		 	$this->db->where('i.language',$this->site_lang);
		}
		$this->db->order_by('id','ASC');
		if($total==1):
			$query = $this->db->get();
			$query = $query->num_rows();
		else:
			$query = $this->db->get('',$per_page,$offset);
			$query = $query->result_array();
		endif;
		return $query;

	}


	public function get_item_name()
	{
		$this->db->select('s.title');
		$this->db->from('items s');
		if(isset($_GET['itemName']) && !empty(isset($_GET['itemName']))){
			$this->db->like('s.title',$_GET['itemName']);
		}
		$this->db->order_by('id','ASC');
		$query = $this->db->get();
		$query = $query->result_array();
		return $query;

	} 

	public function get_single_items_details($id)
    {
        $this->db->select('i.*,i.id as item_id,a.name as allergen');
        $this->db->from('items i');
        $this->db->join('allergens a','a.id = i.allergen_id','LEFT');
        $this->db->where('i.id',$id);
        $this->db->where('i.status',1);
        $this->db->limit(1);
        $query = $this->db->get();
        $query = $query->row();
        if(!empty($query)):
        	$this->db->select('ie.*');
	    	$this->db->from('item_extras ie');
	    	$this->db->where('ie.item_id',$id);
	    	$this->db->order_by('ie.id','ASC');
	    	$query2 = $this->db->get();
	    	$query2 = $query2->result_array();
	    	$query->extras =  ['is_extra'=>1,'result' =>$query2];
        endif;
        return $query;

    }

    public function get_item_extras($id)
    {
    	$this->db->select('ie.*');
    	$this->db->from('item_extras ie');
    	$this->db->where('ie.item_id',$id);
    	$this->db->order_by('ie.id','ASC');
        $query = $this->db->get();
        if($query->num_rows() > 0):
        	$query = (object)['is_extra'=>1,'result' =>$query->result()];
        else:
        	$query = (object)['is_extra'=>0];
        endif;
        return $query;

    }

    public function get_extras_name_by_id($ids,$item_id)
    {
    	$this->db->select('ie.*');
    	$this->db->from('item_extras ie');
    	$this->db->where_in('ie.id',json_decode($ids));
    	$this->db->where('ie.item_id',$item_id);
    	$query = $this->db->get();
    	$query = $query->result();
    	return $query;
    }



    public function check_booked_table($table_id,$shop_id)
    {
    	$today = today();
    	$this->db->select('sum(or.total_person) AS all_person');
    	$this->db->from('order_user_list or');
    	$this->db->where('or.table_no',$table_id);
    	$this->db->where('or.shop_id',$shop_id);
    	$this->db->where_in('or.status',[0,1]);
    	$this->db->where("DATE_FORMAT(or.created_at,'%Y-%m-%d')", $today);
    	$query = $this->db->get();
    	$query = $query->row()->all_person;
    	return $query;
    }

	public function check_total_booked_table($table_id,$shop_id)
    {
    	$today = today();
    	$this->db->select('or.*');
    	$this->db->from('order_user_list or');
    	$this->db->where('or.table_no',$table_id);
    	$this->db->where('or.shop_id',$shop_id);
    	$this->db->where_in('or.status',[0,1]);
    	$this->db->where("DATE_FORMAT(or.created_at,'%Y-%m-%d')", $today);
    	$query = $this->db->get();
    	$query = $query->result();
    	$sum_user = 0;
    	foreach ($query as $key => $value) {
    		$this->db->select('SUM(or.total_person) as all_person');
    		$this->db->from('order_user_list or');
    		$this->db->where('or.uid',$value->uid);
    		$this->db->where_in('or.status',[0,1]);
    		$this->db->where("DATE_FORMAT(or.created_at,'%Y-%m-%d')", $today);
    		$query2 = $this->db->get();
    		$query2 = $query2->row()->all_person;
    		$query[$key]->all_person = $query2;
    	}
    	return $query;
    }

    public function get_table_size($table_id,$shop_id)
    {
    	$this->db->select('tl.*,ta.area_name,ta.id as table_area_id');
    	$this->db->from('table_list tl');
    	$this->db->join('table_areas ta','ta.id=tl.area_id','LEFT');
    	$this->db->where('tl.id',$table_id);
    	$this->db->where('tl.shop_id',$shop_id);
    	$query = $this->db->get();
    	$query = $query->row()->size;
    	return $query;
    }



    public function get_my_coupon($shop_id)
    {
    	$today = today();
    	$this->db->select('c.*');
    	$this->db->from('coupon_list c');
	    $this->db->where('c.start_date <=', $today);
	    $this->db->where('c.end_date >=', $today);
    	$this->db->where('c.shop_id',$shop_id);
	    $this->db->where('c.status',1);
    	$query = $this->db->get();
    	$query = $query->result_array();
    	return $query;
    }


    public function order_qr($orderId,$shopId){
    	$shop = $this->common_m->get_restaurant_info_by_id($shopId);
    	$this->load->library('ciqrcode');
    	$qr_image= $shop['username'].'_'.rand().'.png';
    	$params['data'] = base_url('track-order/'.$shop['username'].'?orderId='.$orderId);
    	$params['level'] = 'H';
    	$params['size'] = 8;
    	$params['savename'] =FCPATH."uploads/orders_qr/".$qr_image;
    	if($this->ciqrcode->generate($params))
    	{
    		$data = array(
    			'qr_link' =>'uploads/orders_qr/'.$qr_image,
    		);
    		$update = $this->admin_m->update_by_type($data,$orderId,'uid','order_user_list');
    	}

    	return $data['qr_link'];
	}


	public function check_order_by_id($id)
    {
        $this->db->select();
        $this->db->from('order_user_list');
        $this->db->where('uid',$id);
        $query = $this->db->get();
        if($query->num_rows() >0):
        	return ['check'=>1,'result'=>$query->row_array()];
        else:
        	return ['check'=>0,'result'=>[]];
        endif;
        
    }

    public function get_my_expenses()
    {
    	$today = today();
    	$this->db->select('ex.*,ex.id as expense_id,ec.category_name,ec.id as category_id');
    	$this->db->from('expense_list ex');
    	$this->db->join('expense_category_list ec','ec.id=ex.category_id','LEFT');

    	$get = $_GET;
    	if(!empty($get['category'])){
    		$this->db->where("ex.category_id",$get['category']);
    	}
    	if(!empty($get['date'])){
    		$date = date("Y-m", strtotime($get['date']));
    		$this->db->where("DATE_FORMAT(ex.created_at,'%Y-%m')",$date);
    	}else{
    		$date = date("Y-m", strtotime($today));
    		$this->db->where("DATE_FORMAT(ex.created_at,'%Y-%m')",$date);
    	}
    	$this->db->order_by('ex.created_at','DESC');
    	$query = $this->db->get();
    	$query = $query->result();
    	return $query;
    }


    public function get_expense_month_year()
    {
    	$today = today();
    	$this->db->select('ex.*,ex.id as expense_id,ec.category_name,ec.id as category_id');
    	$this->db->from('expense_list ex');
    	$this->db->join('expense_category_list ec','ec.id=ex.category_id','LEFT');
    	$this->db->group_by("DATE_FORMAT(ex.created_at,'%Y-%m')");
    	$this->db->order_by("ex.created_at","DESC");
    	$query = $this->db->get();
    	$query = $query->result();
    	return $query;
    }


    public function get_my_menu_type($shop_id,$limit)
    {
        $this->db->select('mt.*');
        $this->db->from('menu_type mt');
        $this->db->where('user_id',auth('id'));
        $this->db->where('status',1); 
        if($limit !=0){
            $this->db->limit($limit); 
        }
        $this->db->order_by('orders','ASC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;

    }


	public function get_my_categories_ln($shop_id,$limit)
	{
	    $this->db->select('mt.*');
	    $this->db->from('menu_type mt');
	    $this->db->join('item_category_list ic','ic.id=mt.category_id','LEFT');
	    $this->db->where('ic.shop_id',$shop_id);
	    $this->db->where('mt.user_id',auth('id'));
	    $this->db->where('mt.language',$this->site_lang);
	     if($limit !=0){
            $this->db->limit($limit); 
        }
	    $this->db->order_by('mt.orders',"ASC");
	    $query = $this->db->get();
	    $query = $query->result_array();
	    return $query;
	    
	}



	

}
