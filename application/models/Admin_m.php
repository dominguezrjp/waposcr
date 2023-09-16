<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_m extends CI_Model {
    public function __construct(){
        $this->db->query("SET sql_mode = ''");
        $this->site_lang = site_lang();
       
    }
 public $order_types = [1,2,4,5,6,7,8,9,10];
    /* start default query
================================================== */
public function update($data,$id,$table)
{
    $this->db->where('id',$id);
    $this->db->update($table,xs_clean($data));
    return $id;
}

public function insert($data,$table)
{
    $this->db->insert($table,xs_clean($data));
    return $this->db->insert_id();
}

public function update_slug($data,$id,$table)
{
    $this->db->where('slug',$id);
    $this->db->update($table,$data);
    return $id;
}

public function update_with_restaurant_id($data,$id,$table)
{
    $shop_id = restaurant()->id;
    $this->db->where('id',$id);
    $this->db->where('restaurant_id',$shop_id);
    $this->db->update(xs_clean($table),xs_clean($data));
    return $id;
}

public function shop_id(){
    return restaurant()->id;
}
public function update_by_type($data,$id,$type,$table)
{
    $this->db->where($type,$id);
    $this->db->update($table,xs_clean($data));
    return $id;
}

public function select_active_all($table)
{
    $this->db->select();
    $this->db->from($table);
    $this->db->where('status',1);
    $this->db->order_by('id','ASC');
    $query = $this->db->get();
    $query = $query->result_array();
    return $query;
}
public function update_kds_by_type($data,$id,$shop_id)
{
    $this->db->where('id',$id);
    $this->db->where('md5(shop_id)',$shop_id);
    $this->db->update('order_user_list',$data);
    return $id;
}

public function update_order_types__($data,$ids,$shop_id)
{
    $this->db->where_in('id',$ids);
    $this->db->where('shop_id',$shop_id);
    $this->db->update('users_active_order_types',$data);
    return $shop_id;
}

public function update_order_types($data,$id,$shop_id)
{
    $this->db->where('type_id',$id);
    $this->db->where('shop_id',$shop_id);
    $this->db->update('users_active_order_types',$data);
    return $shop_id;
}

public function update_by_uid($data,$uid)
{
    $this->db->where('uid',$uid);
    $this->db->update('order_user_list',$data);
    return $uid;
}
public function update_by_uid_dboy_id($data,$uid,$dboy_id)
{
    $this->db->where('uid',$uid);
    $this->db->where('dboy_id',$dboy_id);
    $this->db->update('order_user_list',$data);
    return $uid;
}


public function update_menu_qr($data,$id,$shop_id)
{
    $this->db->where('id',$id);
    $this->db->where('shop_id',$shop_id);
    $this->db->update('item_packages',$data);
    return $id;
}



public function delete($id,$table)
{
    $this->db->delete($table,array('id'=>$id));
    return $id;
}

public function delete_all($ids,$table)
{
    if(!empty($ids) && is_array($ids)):
        $this->db->where_in('id', $ids );
        $this->db->delete($table);
    endif;
    return true;  
}



public function insert_all($data,$table) {
        
        // Insert order items
        $insert = $this->db->insert_batch($table, $data);

        // Return the status
        return $insert?true:false;
    }

public function select($table)
{
    $this->db->select();
    $this->db->from($table);
    $query = $this->db->get();
    $query = $query->result_array();
    return $query;
}
public function user_login_info_check($email,$password)
{
    $this->db->select('u.*');
    $this->db->from('users u');
    $this->db->where("u.username",$email);
    $this->db->where('u.password', $password);
    $this->db->limit(1);
    $query = $this->db->get();
    if($query->num_rows() ==1){
        return $query->result();
    }else{
        return false;
    }

}
public function single_select($table)
{
    $this->db->select();
    $this->db->from($table);
    $query = $this->db->get();
    $query = $query->row_array();
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

function item_delete($id,$table)
{
    $this->db->where('user_id',auth('id'));
    $this->db->delete($table,array('id'=>$id));
    return $id;
}


function delete_single_item($id,$table)
{
    $this->db->delete($table,array('id'=>$id));
    return $id;
}


/**
      ** Update with site id
    **/
    public function update_setting($data,$id,$table)
    {
        $this->db->where('site_id',$id);
        $this->db->update($table,$data);
        return $id;
    }


/* end default query
================================================== */


    /**
      ** check username or email or phone while login
    **/
    public function check_login_info($email,$password)
    {
        $this->db->select('u.*');
        $this->db->from('users u');
        $this->db->where("(u.email = '$email' OR u.username = '$email')");
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() ==1){
            $result = $query->result();
            foreach ($result as $row) {
                if ($this->verify_password($password, $row->password) == TRUE) {
                    return ['result'=>$result];
                } else {
                    return ['result'=>1];
                }
            }
        }else{
            return ['result'=>0];
        }

    } 

    public function check_staff_login_info($email,$password)
    {
        $this->db->select('st.*,st.id as staff_id,u.id as user_id,u.username,u.user_role,u.is_active,u.account_type,u.is_verify');
        $this->db->from('staff_list st');
        $this->db->join('users u','u.id = st.user_id','LEFT');
        $this->db->where("(st.email = '$email')");
        $this->db->where_in("st.role",['staff','admin_staff']);
        $this->db->where("st.status",1);
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() ==1){
            $result = $query->result();
            foreach ($result as $row) {
                if ($this->verify_password($password, $row->password) == TRUE) {
                    return ['result'=>$result];
                } else {
                    return ['result'=>0];
                }
            }
        }else{
            return ['result'=>0];
        }

    }


    public function check_staff_login_status($phone,$password)
    {
        $this->db->select('st.*');
        $this->db->from('staff_list st');
        $this->db->where('st.phone',$phone);
        $this->db->where("st.role !=",'staff');
        $this->db->where("st.role !=",'admin_staff');
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() ==1){
            $result = $query->result();
            foreach ($result as $row) {
                if ($this->verify_password($password, $row->password) == TRUE) {
                    return ['result'=>$result];
                } else {
                    return ['result'=>0];
                }
            }
        }else{
            return ['result'=>0];
        }

    }
    
    public function check_customer_login_status($phone,$password)
    {
        $this->db->select('st.*');
        $this->db->from('customer_list st');
        $this->db->where('st.phone',$phone);
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() ==1){
            $result = $query->result();
            foreach ($result as $row) {
                if ($this->verify_password($password, $row->password) == TRUE) {
                    return ['result'=>$result];
                } else {
                    return ['result'=>0];
                }
            }
        }else{
            return ['result'=>0];
        }

    }


    public function check_staff($email)
    {
        $this->db->select('st.*');
        $this->db->from('staff_list st');
        $this->db->where('st.email',$email);
        $this->db->where('st.role',['staff','admin_staff']);
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() ==1){
          return 1;
        }else{
            return 0;
        }

    }

    public function check_mobile($email)
    {
        $this->db->select('u.phone');
        $this->db->from('users u');
        $this->db->where("u.phone",$email);
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() == 1){
            return 1;
        }else{
            return 0;
        }

    }
   

    // password verify
    public function verify_password($password,$vpassword) {
        if (md5($password)== $vpassword) {
            return TRUE;
        } else {
            return FALSE;
        }
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

    public function update_language($data,$id,$table){
        $this->db->where('keyword',$id);
        $this->db->update($table,$data);
        return 1;
    }

// check password for change password 
    public function check_pass($pass)
    {
        $this->db->select('u.password');
        $this->db->from('users as u');
        $this->db->where('u.id', auth('id'));
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() ==1){
            $result = $query->result();
            foreach ($result as $row) {
                if ($this->verify_password($pass, $row->password) == TRUE) {
                    return $result;
                } else {
                    return FALSE;
                }
            }
        }else{
            return false;
        }

    }



    /**
      ** check valid email for recovery password
    **/
    public function check_valid_email($email)
    {
        $this->db->select('u.*');
        $this->db->from('users u');
        $this->db->where('u.email', $email);
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() ==1){
            return $query->row_array();
        }else{
            return false;
        }

    }

    public function check_valid_staff_phone($phone)
    {
        $this->db->select('u.*');
        $this->db->from('staff_list u');
        $this->db->where('u.phone', $phone);
        $this->db->where('u.role', 'customer');
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() ==1){
            return $query->row_array();
        }else{
            return false;
        }

    } 
    
    public function check_valid_customer_phone($phone)
    {
        $this->db->select('u.*');
        $this->db->from('customer_list u');
        $this->db->where('u.phone', $phone);
        $this->db->where('u.role', 'customer');
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() ==1){
            return $query->row_array();
        }else{
            return false;
        }

    } 

    public function check_existing_email($email)
    {
        $this->db->select('u.*');
        $this->db->from('users u');
        $this->db->where('u.email', $email);
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() ==1){
            return 1;
        }else{
            return 0;
        }

    }

    public function check_exits_dboy($phone)
    {
        $this->db->select('u.*');
        $this->db->from('staff_list u');
        $this->db->where('u.phone', $phone);
        $this->db->where('u.role', 'dboy');
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() ==1){
            return 1;
        }else{
            return 0;
        }

    } 

    public function check_exits_customer_phone($phone)
    {
        $this->db->select('u.*');
        $this->db->from('customer_list u');
        $this->db->where('u.phone', $phone);
        $this->db->where('u.role', 'customer');
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() ==1){
            return 1;
        }else{
            return 0;
        }

    }

    /**
      ** check username  while Registration
    **/
    public function check_valid_username($username)
    {
        $this->db->select('u.username');
        $this->db->from('users u');
        $this->db->where("u.username",$username);
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() ==1){
            return 1;
        }else{
            return 0;
        }

    }

    public function get_settings(){
        $this->db->select();
        $this->db->from('settings');
        $query = $this->db->get();
        return $query->row_array();
    }
    
    public function get_languages_by_slug($slug)
    {
        $this->db->select();
        $this->db->from('languages');
        $this->db->where('slug',$slug);
        $query = $this->db->get();
        $query = $query->row_array();
        return $query;
    }
    
    public function single_select_by_id($id,$table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('id',$id);
        $query = $this->db->get();
        $query = $query->row_array();
        return $query;
    }

    public function single_select_by_md5_id($id,$table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('md5(id)',$id);
        $query = $this->db->get();
        $query = $query->row();
        return $query;
    }

    public function single_select_by_auth_id($id,$table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('id',$id);
        $this->db->where('user_id',auth('id'));
        $query = $this->db->get();
        $query = $query->row_array();
        return $query;
    }
    public function single_select_by_uid($id,$table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('uid',$id);
        $query = $this->db->get();
        $query = $query->row_array();
        return $query;
    }

    public function single_select_by_uid_row($id,$table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('uid',$id);
        $query = $this->db->get();
        $query = $query->row();
        return $query;
    }

    public function single_select_by_id_row($id,$table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('id',$id);
        $query = $this->db->get();
        $query = $query->row();
        return $query;
    }

    public function single_select_by_order_id($id,$table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('order_id',$id);
        $query = $this->db->get();
        $query = $query->row_array();
        return $query;
    }

     public function single_id($id,$table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('id',$id);
        $query = $this->db->get();
        $query = $query->row();
        return $query;
    }

    public function check_setting_value($data_type)
    {
        $this->db->select();
        $this->db->from('settings');
        $query = $this->db->get();
        $query = $query->row_array();
        return $query[$data_type];
    }

    /**
      ***  get language data
    **/ 
    public function get_language_data($type,$status)
    {
        $this->db->select('l.*');
        $this->db->from('languages l');
        if($status != '*'){
            $this->db->where('l.status',$status);
        }
        $query = $this->db->get();
        $query = $query->result_array();
        foreach ($query as $key => $value) {
            $this->db->select('ld.*');
            $this->db->from('language_data ld');
            $this->db->where('ld.type',$type);
            $query2 = $this->db->get();
            $query2 = $query2->result_array();
            $query[$key]['lang_data'] = $query2;
        }
        return $query;
    }

    public function get_language($status)
    {
        $this->db->select('l.*');
        $this->db->from('languages l');
        if($status != '*'){
            $this->db->where('l.status',$status);
        }
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }


    public function get_all_language_data($per_page,$offset,$total)
    {
      
        $this->db->select('ld.*');
        $this->db->from('language_data ld');
        if(isset($_GET['q']) && !empty($_GET['q'])){
            $this->db->like('english',$_GET['q']);
            $this->db->or_like('keyword',$_GET['q']);
        }
        $this->db->order_by('ld.id','DESC');
        if($total==1):
            $query = $this->db->get();
            $query = $query->num_rows();
        else:
            $query = $this->db->get('',$per_page,$offset);;
            $query = $query->result_array();
        endif;
        
        return $query;
    }




public function get_auth_profile_info_md5($user_id)
{
    $this->db->select('u.*');
    $this->db->from('users u');
    $this->db->where('md5(u.id)',$user_id);
    $query = $this->db->get();
    $query = $query->row_array();
    return $query;
}

public function get_shop_profile_md5($shop_id)
{
   $this->db->select('r.*');
    $this->db->from('restaurant_list r');
    $this->db->where('md5(r.id)',$shop_id);
    $query = $this->db->get();
    if($query->num_rows() > 0):
        return $query->row_array();
    else:
        return [];
    endif;
}

public function get_shop_profile_by_shop_id($shop_id)
{
   $this->db->select('r.*');
    $this->db->from('restaurant_list r');
    $this->db->where('r.id',$shop_id);
    $query = $this->db->get();
    if($query->num_rows() > 0):
        return $query->row_array();
    else:
        return [];
    endif;
}

public function get_user_info_by_shop_id($shop_id)
{
   $this->db->select('r.id as shop_id,u.*,u.id as user_id');
    $this->db->from('restaurant_list r');
    $this->db->join('users u','u.id=r.user_id','LEFT');
    $this->db->where('md5(r.id)',$shop_id);
    $query = $this->db->get();
    if($query->num_rows() > 0):
        return $query->row_array();
    else:
        return [];
    endif;
}


public function get_my_restaurant($user_id)
{
    $this->db->select('r.*');
    $this->db->from('restaurant_list r');
    $this->db->where('md5(r.user_id)',$user_id);
    $query = $this->db->get();
    if($query->num_rows() > 0):
        return $query->row_array();
    else:
        return [];
    endif;
}

public function my_restaurant_info($user_id='')
{
    $id = !empty($user_id)?$user_id:auth('id');
    $this->db->select('r.*');
    $this->db->from('restaurant_list r');
    $this->db->where('r.user_id',$id);
    $query = $this->db->get();
    if($query->num_rows() > 0):
        return $query->row();
    else:
        return [];
    endif;
}

public function my_vendor_info($user_id='')
{
    $id = !empty($user_id)?$user_id:auth('id');
    $this->db->select('r.*');
    $this->db->from('restaurant_list r');
    $this->db->where('r.user_id',$id);
    $query = $this->db->get();
    if($query->num_rows() > 0):
        return $query->row_array();
    else:
        return [];
    endif;
}


public function get_shop_info($shop_id)
{
    
    $this->db->select('r.*');
    $this->db->from('restaurant_list r');
    $this->db->where('r.id',$shop_id);
    $query = $this->db->get();
    if($query->num_rows() > 0):
        return $query->row();
    else:
        return [];
    endif;
}

public function get_shop_id($user_id)
{
    $id = !empty($user_id)?$user_id:auth('id');
    $this->db->select('r.*');
    $this->db->from('restaurant_list r');
    $this->db->where('r.user_id',$id);
    $query = $this->db->get();
    if($query->num_rows() > 0):
        return $query->row()->id;
    else:
        return 0;
    endif;
}


/**===== get_login_user_info ====**/

// get user for custom helper
    public function get_auth_info()
    {
        $this->db->select('u.*');
        $this->db->from('users as u');
        $this->db->where('u.id',auth('id'));
        $query = $this->db->get();
        $query = $query->row_array();
        return $query;
    }

    public function get_users_info()
    {
        $this->db->select('u.*,u.id as user_id,c.*,c.id as country_id');
        $this->db->from('users as u');
        $this->db->join('country as c','c.id= u.country');
        $this->db->where('u.id',auth('id'));
        $query = $this->db->get();
        $query = $query->row();
        return $query;
    }


    public function get_admin_info()
    {
        $this->db->select('u.*,u.id as user_id');
        $this->db->from('users as u');
        $this->db->where('u.user_role',1);
        $query = $this->db->get();
        $query = $query->row();
        return $query;
    }

    public function get_user_info()
    {
        $this->db->select('u.*');
        $this->db->from('users as u');
        $this->db->where('u.id',auth('id'));
        $query = $this->db->get();
        $query = $query->row();
        return $query;
    }

    public function get_user_info_by_id($id)
    {
        $this->db->select('u.*');
        $this->db->from('users u');
        $this->db->where('u.id',$id);
        $query = $this->db->get();
        $query = $query->row_array();
        return $query;
    }

    public function update_user($data,$id,$table)
    {
        $this->db->where('user_id',$id);
        $this->db->update($table,$data);
        return $id;
    }


    public function get_profile_info($id)
    {
        $this->db->select('u.*,u.name as full_name,c.*,c.id as country_id,c.name as country_name');
        $this->db->from('users u');
        $this->db->join('country c','c.id=u.country','LEFT');
        $this->db->where('u.id',$id);
        $query = $this->db->get();
        $query = $query->row_array();
        return $query;
    }

    public function get_restaurant_info($id)
    {
        $this->db->select('rl.*,u.username');
        $this->db->from('restaurant_list rl');
        $this->db->join('users u','u.id=rl.user_id','LEFT');
        $this->db->where('u.id',$id);
        $query = $this->db->get();
        $query = $query->row_array();
        return $query;
    }


    public function get_restaurant_info_shop_id($id)
    {
        $this->db->select('rl.*,u.username,u.end_date,u.start_date');
        $this->db->from('restaurant_list rl');
        $this->db->join('users u','u.id=rl.user_id','LEFT');
        $this->db->where('rl.id',$id);
        $query = $this->db->get();
        $query = $query->row();
        return $query;
    }
    public function get_restaurant_info_slug($slug)
    {
        $this->db->select('rl.*,u.username');
        $this->db->from('restaurant_list rl');
        $this->db->join('users u','u.id=rl.user_id','LEFT');
        $this->db->where('u.username',$slug);
        $query = $this->db->get();
        $query = $query->row_array();
        return $query;
    }


    /**===== update by  user_id ====**/
    public function update_profile($data,$table)
    {
        $this->db->where('id',auth('id'));
        $this->db->update($table,$data);
        return auth('id');
    }


    /**===== update by  user_id ====**/
    public function user_update($data,$id,$table)
    {
        $this->db->where('user_id',$id);
        $this->db->update($table,$data);
        return $id;
    }

    public function update_by_user_id($data,$id,$table)
    {
        $this->db->where('user_id',$id);
        $this->db->update($table,$data);
        return $id;
    }


    /**
      ** get pricing with package_id id and by feature id
    **/
    public function get_price_feature_id($id,$type_id)
    {

        $this->db->select('p.*');
        $this->db->from('pricing p');
        $this->db->where('p.feature_id',$id);
        $this->db->where('p.package_id',$type_id);
        $query = $this->db->get();
        $query = $query->row_array();
        return $query;
    }

     public function get_active_package_features($id,$type_id)
    {

        $this->db->select('p.*');
        $this->db->from('pricing p');
        $this->db->where('p.feature_id',$id);
        $this->db->where('p.package_id',$type_id);
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() ==1):
            return 1;
        else:
            return 0;
        endif;
    }

    /**
      ** get pricing with package_id id and by feature id
    **/
    public function select_home_features_by_type($type)
    {
        $this->db->select('*');
        $this->db->from('site_features');
        $this->db->where('dir',$type);
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }


    public function single_select_by_section_name($section_name)
    {
        $this->db->select('*');
        $this->db->from('section_banners');
        $this->db->where('section_name',$section_name);
        $query = $this->db->get();
        if($query->num_rows() > 0):
            return $query->row_array();
        else:
             return [];
        endif;
    }

    public function get_trail_package_id($id=0)
    {

        $this->db->select('p.*');
        $this->db->from('packages p');
        
        if($id!=0){
            $this->db->where('p.id',$id);
        }else{
            $this->db->where('p.package_type','trial');
            $this->db->or_where('p.package_type','weekly');
            $this->db->or_where('p.package_type','fifteen');
        }
        $query = $this->db->get();
        $query = $query->row_array();
        return isset($query) && !empty($query)?$query:[];
    }

    public function get_extra_trail_package_id()
    {

        $this->db->select('p.*');
        $this->db->from('packages p');
        $this->db->where('p.package_type','trial');
        $this->db->or_where('p.package_type','weekly');
        $this->db->or_where('p.package_type','fifteen');
        $query = $this->db->get();
        $query = $query->num_rows();
        return $query;
    }



/**===== Delete package id from pricing ====**/
    function delete_pricing($id,$table)
    {
        $this->db->delete($table,array('package_id'=>$id));
        return $id;
    }

    function delete_order_items($id,$table)
    {
        $this->db->delete($table,array('order_id'=>$id));
        return $id;
    }

     function delete_by_user_id($table)
    {
        $this->db->delete($table,array('user_id'=>auth('id')));
        return 1;
    }

    function delete_all_by_user_id($id,$table)
    {
        $this->db->delete($table,array('user_id'=>$id));
        return 1;
    }


    /**
      ***  get total income
    **/ 

    public function get_total_income()
    {
        $this->db->select('pi.*');
        $this->db->select('COUNT(pi.id) as total_transaction');
        $this->db->select_sum('pi.price','total_price');
        $this->db->from('payment_info pi');
        $this->db->group_by('SUBSTRING(created_at,1,7)');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

    public function get_total_user_by_account_type()
    {
        $this->db->select('u.id,u.account_type,ft.package_name,ft.id as package_id');
        $this->db->select('COUNT(u.id) as total_user');
        $this->db->from('users u');
        $this->db->join('packages ft','ft.id = u.account_type','LEFT');
        $this->db->where('u.account_type !=',0);
        $this->db->where('u.is_verify',1);
        $this->db->where('u.is_payment',1);
        $this->db->where('u.is_expired',0);
        $this->db->order_by('account_type','DESC');
        $this->db->group_by('account_type');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }


    public function get_total_user_by_type($type)
    {
        $this->db->select('u.*');
        $this->db->from('users u');
        $this->db->where('u.account_type !=',0);
        if($type=='is_verify'):
            $this->db->where('u.is_verify',0);
        elseif($type=='is_payment'):
            $this->db->where('u.is_payment',0);
        elseif($type=='is_expired'):
            $this->db->where('u.is_expired',1);
        elseif($type=='is_active'):
            $this->db->where('u.is_active',0);
        endif;
        $query = $this->db->get();
        $query = $query->num_rows();
        return $query;
    }

    public function count_table_by_status($status,$table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('status',$status);
        $query = $this->db->get();
        $query = $query->num_rows();
        return $query;
    }

    public function count_table_user_id($table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('user_id',auth('id'));
        $query = $this->db->get();
        $query = $query->num_rows();
        return $query;
    }

    public function count_table($table)
    {
        $this->db->select();
        $this->db->from($table);
        $query = $this->db->get();
        $query = $query->num_rows();
        return $query;
    }

    public function count_table_shop_id($table)
    {
        $shop_id = restaurant()->id;
        $this->db->select();
        $this->db->from($table);
        $this->db->where('shop_id',$shop_id);
        $query = $this->db->get();
        $query = $query->num_rows();
        return $query;
    }


    

    public function get_total_income_by_month($month,$type=0)
    {
        $this->db->select('pi.*');
        $this->db->select('COUNT(pi.id) as total_transaction');
        $this->db->select_sum('pi.price','total_price');
        $this->db->from('payment_info pi');
        $this->db->where('SUBSTRING(pi.created_at,1,7)', date('Y').'-'.$month);
        $query = $this->db->get();
        $query = $query->row_array();
        if($type==0):
            return !empty($query['total_price'])?$query['total_price']:0;
        else:
            return !empty($query['total_transaction'])?$query['total_transaction']:0;
        endif;
    }

    public function update_by_username($data,$username,$table)
    {
        $this->db->where('username',$username);
        $this->db->update($table,$data);
        return 1;
    }

    /**
      ** check username  while Registration
    **/
    public function check_username($username)
    {
        $this->db->select('u.username');
        $this->db->from('users u');
        $this->db->where("u.username",$username);
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() ==1){
            return 1;
        }else{
            return 0;
        }

    }

    /**
      *** check vaild mail for rating
    **/ 
    public function check_email($email)
    {
        $this->db->select('u.email');
        $this->db->from('users u');
        $this->db->where("u.email",$email);
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() ==1){
            return 1;
        }else{
            return 0;
        }

    }

    /**
      *** check vaild mail for rating
    **/ 
    public function check_my_rating($email)
    {
        $this->db->select('ur.*');
        $this->db->from('users_rating ur');
        $this->db->where("ur.email",$email);
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() ==1){
            return 1;
        }else{
            return 0;
        }

    }

    public function get_all_pacakges()
    {
        $this->db->select('p.*');
        $this->db->from('packages p');
        $type = array('free','trial');
        $this->db->where('p.package_type !=','free');
        $this->db->where('p.package_type !=','trial');
        $this->db->where('p.package_type !=','weekly');
        $this->db->where('p.package_type !=','fifteen');
        $this->db->where('p.status',1);
        $query = $this->db->get();
        $query = $query->result_array();
        foreach ($query as $key => $value) {
            $this->db->select('p.*,p.id as pricing_id,f.*,f.id as feature_id');
            $this->db->from('pricing p');
            $this->db->join('features f','f.id = p.feature_id','RIGHT');
            $this->db->where('p.package_id',$value['id']);
            $this->db->order_by('f.id','ASC');
            $query2 = $this->db->get();
            $query2 = $query2->result_array();
            $query[$key]['features'] = $query2;
        }
        return $query;
    }


    public function get_active_package()
    {
        $this->db->select('p.*,u.id as user_id,u.account_type,u.end_date');
        $this->db->from('packages p');
        $this->db->join('users u','u.account_type = p.id','LEFT');
        $this->db->where('u.id',auth('id'));
        $this->db->where('u.is_expired',0);
        $type = array('free','trial','fifteen','weekly');
        $this->db->where_in('p.package_type',$type);
        $query = $this->db->get();
        $query = $query->row_array();
        return $query;
    }



    public function get_users_actived_package()
    {
        $this->db->select('p.*,u.id as user_id,u.account_type,u.end_date');
        $this->db->from('packages p');
        $this->db->join('users u','u.account_type = p.id','LEFT');
        $this->db->where('u.id',auth('id'));
        $this->db->where('u.is_expired',0);
        $query = $this->db->get();
        $query = $query->row_array();
        return $query;
    }

    public function get_subscribed_package($user_id,$id)
    {
        if($id==0):
            $this->db->select('p.*,p.slug as package_slug');
            $this->db->from('packages p');
            $this->db->where_in('p.package_type',trial_type());
            $query = $this->db->get();
            $query = $query->row();
            return $query;
        else:
            $this->db->select('o.*,o.id as invoice_id,u.id as user_id,u.account_type,u.end_date,p.id as package_id,p.package_name,p.package_type,p.slug as package_slug,p.price as package_price');
            $this->db->from('payment_info o');
            $this->db->join('users u','u.id = o.user_id','LEFT');
            $this->db->join('packages p','p.id = o.account_type','LEFT');
            $this->db->where('o.user_id',$user_id);
            $this->db->where('o.account_type',$id);
            $this->db->where('o.expire_date is NOT NULL', NULL, FALSE);
            $this->db->order_by('o.created_at',"DESC");
            $query = $this->db->get();
            $query = $query->row();
            return $query;
        endif;
    }

    public function count_my_active_packages()
    {
        $this->db->select('p.*,u.id as user_id,u.account_type,u.end_date');
        $this->db->from('pricing p');
        $this->db->join('users u','u.account_type = p.package_id','LEFT');
        $this->db->where('u.id',auth('id'));
        $query = $this->db->get();
        $query = $query->num_rows();
        return $query;
    }


    public function get_info_by_package_slug($slug)
    {
        $this->db->select('p.*');
        $this->db->from('packages as p');
        $this->db->where('p.slug',$slug);
        $this->db->where('p.status',1);
        $query = $this->db->get();
        $query = $query->row_array();
        return $query;
    } 

    public function count_home_user()
    {
        $this->db->select('u.*');
        $this->db->from('users as u');
        $this->db->where('u.user_role',0);
        $query = $this->db->get();
        if($query->num_rows() > 0):
            return 1;
        else:
            return 0;
        endif;
    }
    /**
      ***  get package_info by slug
    **/ 
     public function get_package_info_by_slug($slug)
    {
        $this->db->select('p.*');
        $this->db->from('packages as p');
        $this->db->where('p.slug',$slug);
        $this->db->where('p.status',1);
        $query = $this->db->get();
        $query = $query->row_array();
        return $query;
    }


     public function get_package_info_by_id($id)
    {
        $this->db->select('p.*');
        $this->db->from('packages as p');
        $this->db->where('p.id',$id);
        $query = $this->db->get();
        $query = $query->row_array();
        return !empty($query)?$query:[];
    }
    
    /* select by user id
    ================================================== */
    public function select_by_user($table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('user_id',auth('id'));
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }  
     
    public function select_all_by_user($table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('user_id',auth('id'));
        $this->db->order_by('id','ASC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }
    public function select_all_by_status($table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('status',1);
        $this->db->order_by('id','ASC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

    public function select_all_by_user_desc($table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('user_id',auth('id'));
        $this->db->order_by('id','DESC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

    public function select_all_by_shop_desc($id,$table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('shop_id',$id);
        $this->db->order_by('id','DESC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

    public function select_all_by_shop($id,$table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('shop_id',$id);
        $this->db->order_by('id','ASC');
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

    public function select_all_by_user_by_order($table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('user_id',auth('id'));
        $this->db->order_by('orders','ASC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

    public function select_all_by_user_by_order_ln($table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('user_id',auth('id'));
        $this->db->where('ln','english');
        $this->db->order_by('orders','ASC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

    public function get_by_shop_user_id($shop_id,$table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('shop_id',$shop_id);
        $this->db->where('user_id',auth('id'));
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

    public function get_single_by_shop_user_id($shop_id,$table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('shop_id',$shop_id);
        $this->db->where('user_id',auth('id'));
        $this->db->order_by('id','ASC');
        $query = $this->db->get();
        $query = $query->row_array();
        return $query;
    }

    /* 
    ================================================== */

    public function get_users_active_features($id,$user_id)
    {
        $this->db->select('us.*');
        $this->db->from('users_active_features us');
        $this->db->where('us.feature_id',$id);
        $this->db->where('us.user_id',$user_id);
        $this->db->order_by('id','ASC');
        $query = $this->db->get();
        $query = $query->row_array();
        return $query;
    }

    public function get_users_active_order_types($id,$user_id)
    {
        $this->db->select('us.*');
        $this->db->from('users_active_order_types us');
        $this->db->where('us.type_id',$id);
        $this->db->where('us.user_id',$user_id);
        $this->db->order_by('id','ASC');
        $query = $this->db->get();
        $query = $query->row_array();
        return $query;
    }

/*  About section
================================================== */

    public function get_about($id)
    {
        $this->db->select('a.*');
        $this->db->from('about a');
        $this->db->where('user_id',auth('id'));
        if($id !=0){
            $this->db->where('id',$id);
        }
        $this->db->order_by('id','ASC');
        $query = $this->db->get();
        $query = $query->result_array();
        foreach ($query as $key => $value) {
            $this->db->select('ac.*');
            $this->db->from('about_content ac');
            $this->db->where('ac.about_id',$value['id']);
            $this->db->where('ac.value IS NOT NULL', NULL, FALSE);
            $this->db->order_by('id','ASC');
            $query2 = $this->db->get();
            $query2 = $query2->result_array();
            $query[$key]['about_content'] = $query2;
        }
        return $query;
    }

public function delete_about_content($id)
{
    $this->db->delete('about_content',array('about_id'=>$id));
    return $id;
}
/*   end about section
================================================== */


/*  profile
================================================== */
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

/**
  ** Get Features name by type
**/
public function get_features_name($slug)
{
    $this->db->select();
    $this->db->from('features');
    $this->db->where('slug',$slug);
    $query = $this->db->get();
    $query = $query->row_array();
    return isset($query['features'])?$query['features']:'';

}



public function get_features_name_id($id)
{
    $this->db->select();
    $this->db->from('features');
    $this->db->where('id',$id);
    $query = $this->db->get();
    $query = $query->row_array();
    return isset($query['features'])?$query['features']:'';

}

    public function get_all_users_features_by_id($id)
    {
        $this->db->select('ft.*,u.account_type');
        $this->db->from('packages ft');
        $this->db->join('users u','u.account_type=ft.id','LEFT');
        $this->db->where('u.id',$id);
        $query = $this->db->get();
        $query = $query->result_array();
        foreach ($query as $key => $value) {
            $this->db->select('p.*,p.id as pricing_id,f.*,f.id as feature_id');
            $this->db->from('pricing p');
            $this->db->join('features f','f.id = p.feature_id','RIGHT');
            $this->db->where('p.package_id',$value['id']);
            $this->db->order_by('f.id','ASC');
            $query2 = $this->db->get();
            $query2 = $query2->result_array();
            $query[$key]['features'] = $query2;
        }
        return $query;
    }


    public function get_users_features(){
        $this->db->select('uf.*,f.features as name,f.slug');
        $this->db->from('users_active_features uf');
        $this->db->join('features f','f.id=uf.feature_id','LEFT');
        $this->db->where('f.status',1);
        $this->db->where('uf.user_id',auth('id'));
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

    public function get_features_heading($id,$user_id){
        $this->db->select('uf.*');
        $this->db->from('users_active_features uf');
        $this->db->where('uf.feature_id',$id);
        $this->db->where('uf.user_id',$user_id);
        $query = $this->db->get();
        $query = $query->row_array();
        return $query;
    }
    public function get_features_title($slug,$user_id){
        $this->db->select('uf.*,f.slug');
        $this->db->from('users_active_features uf');
        $this->db->join('features f','f.id=uf.feature_id','LEFT');
        $this->db->where('f.slug',$slug);
        $this->db->where('uf.user_id',$user_id);
        $query = $this->db->get();
        $query = $query->row_array();
        return $query;
    }


    public function update_feature($data,$id,$table)
    {
        $this->db->where('feature_id',$id);
        $this->db->where('user_id',auth('id'));
        $this->db->update($table,$data);
        return $id;
    }

   /**
      ** single_appoinment
    **/
    public function check_layouts($type,$value)
    {
        $this->db->select();
        $this->db->from('users');
        $this->db->where($type,$value);
        $this->db->where('id',auth('id'));
        $query = $this->db->get();
        if($query->num_rows() ==1){
            return 1;
        }else{
            return 0;
        }

    }

// total user info for admin
    public function get_all_user($limit=0, $per_page=0,$offset=0,$total=0)
    {
        $this->db->select('u.*,p.package_name,p.package_type ');
        $this->db->from('users as u');
        $this->db->join('packages as p ','p.id = u.account_type','LEFT');
        $this->db->where('u.user_role !=',1);
        if($limit !=0){
            $this->db->limit($limit);
        }
        $this->db->order_by('u.id','DESC');

        if(isset($_GET)):
            if(!empty($_GET['name'])){
                $this->db->where('u.username',$_GET['name']);
            }

            if(!empty($_GET['package'])){
                $this->db->where('p.slug',$_GET['package']);
            }
        endif;

        if($total==1){
            $query = $this->db->get();
            $query = $query->num_rows();
        }else{
            $query = $this->db->get('',$per_page,$offset);
            $query = $query->result_array();
        }
        
        return $query;
    }

    public function get_new_users($limit=0)
    {
        $this->db->select('u.*,p.package_name,p.package_type ');
        $this->db->from('users as u');
        $this->db->join('packages as p ','p.id = u.account_type','LEFT');
        $this->db->where('u.created_at BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()');
        $this->db->where('u.user_role !=',1);
        if($limit !=0){
            $this->db->limit($limit);
        }
        $this->db->order_by('u.id','DESC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

     public function get_user_package_details()
    {
        $this->db->select('u.*,p.package_name,p.package_type ');
        $this->db->from('users as u');
        $this->db->join('packages as p ','p.id = u.account_type','LEFT');
        $this->db->where('u.user_role !=',1);
        $this->db->where('u.id',auth('id'));
        $this->db->order_by('u.id','DESC');
        $query = $this->db->get();
        $query = $query->row_array();
        return $query;
    }


// total user info for admin
    public function get_payment_type_by_id($id)
    {
        $this->db->select('op.*');
        $this->db->from('offline_payment as op');
        $this->db->where('op.user_id ',$id);
        $this->db->limit(1);
        $query = $this->db->get();
        $query = $query->row_array();
        return $query;
    }

    // total user info for admin
    public function get_user_settings()
    {
        $this->db->select('us.*');
        $this->db->from('user_settings as us');
        $this->db->where('us.user_id ',auth('id'));
        $this->db->limit(1);
        $query = $this->db->get();
        $query = $query->row_array();
        return $query;
    }

 // total user info for admin
    public function get_portfolio_limit_by_package_id($id)
    {
        $this->db->select('p.*');
        $this->db->from('packages as p');
        $this->db->where('p.id ',$id);
        $this->db->limit(1);
        $query = $this->db->get();
        $query = $query->row_array();
        return $query;
    }

    public function count_total_user_by_package_id($id)
    {
        $this->db->select('u.*');
        $this->db->from('users as u');
        $this->db->where('u.account_type ',$id);
        $query = $this->db->get();
        $query = $query->num_rows();
        return $query;
    }

    public function get_by_site_id($id)
    {
        $this->db->select('s.*');
        $this->db->from('settings as s');
        $this->db->where('s.site_id ',$id);
        $query = $this->db->get();
        $query = $query->num_rows();
        return $query;
    }


    public function get_empty_admin()
    {
        $this->db->select();
        $this->db->from('users');
        $this->db->where('user_role',1);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return 1;
        }else{
            return 0;
        }

    }

    public function check_files($dir)
    {
        $it = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
        $it = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
        foreach($it as $file) {
            if ($file->isDir()) rmdir($file->getPathname());
            else unlink($file->getPathname());
        }
        rmdir($dir);
        return true;
    }

    public function get_all_active_users()
    {
        $this->db->select('u.*');
        $this->db->from('users u');
        $this->db->where('u.is_active',1);
        $this->db->where('u.is_verify',1);
        $this->db->where('u.is_expired',0);
        $this->db->where('u.user_role',0);
        $this->db->where('u.end_date !=','0000-00-00 00:00:00');
        $this->db->order_by('u.id','DESC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }



    /**
      ** Get all users for expired
    **/
    public function get_all_users($date)
    {
        $this->db->select('u.*');
        $this->db->from('users u');
        $this->db->where('u.is_active',1);
        $this->db->where('u.is_verify',1);
        $this->db->where('u.is_expired',0);
        $this->db->where('u.user_role',0);
        $this->db->where('u.end_date !=','0000-00-00 00:00:00');
        $this->db->where('u.end_date <',$date);
        $this->db->order_by('u.id','DESC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }


    public function get_all_items_ln($id,$language=null)
    {
        $this->db->select('mt.*');
        $this->db->from('menu_type mt');
        $this->db->where('user_id',auth('id'));
        $this->db->where('language',$language);
        if($id !=0){
            $this->db->where('category_id',$id);
        }
        $this->db->order_by('orders','ASC');
        $query = $this->db->get();
        $query = $query->result_array();
        foreach ($query as $key => $value) {
            $this->db->select('i.*,a.name as allergen');
            $this->db->from('items i');
            $this->db->join('allergens a','a.id = i.allergen_id','LEFT');
            $this->db->where('i.cat_id',$value['category_id']);
            $this->db->where('language',$language);
            $this->db->order_by('i.orders','ASC');
            $query2 = $this->db->get();
            $query2 = $query2->result_array();
            

            foreach ($query2 as $key2 => $value2) {
                $this->db->select('ic.*');
                $this->db->from('item_content ic');
                $this->db->where('ic.item_id',$value2['id']);
                $this->db->where('ic.label IS NOT NULL', NULL, FALSE);
                $this->db->where('ic.value IS NOT NULL', NULL, FALSE);
                $this->db->order_by('id','ASC');
                $query3 = $this->db->get();
                $query3 = $query3->result_array();
                $query2[$key2]['items_content'] = $query3;
            }
            $query[$key]['items'] = $query2;
        }

        return $query;
        
    }


    public function get_all_items($id)
    {
        $this->db->select('mt.*');
        $this->db->from('menu_type mt');
        $this->db->where('user_id',auth('id'));
        if($id !=0){
            $this->db->where('id',$id);
        }
        $this->db->order_by('orders','ASC');
        $query = $this->db->get();
        $query = $query->result_array();
        foreach ($query as $key => $value) {
            $this->db->select('i.*,a.name as allergen');
            $this->db->from('items i');
            $this->db->join('allergens a','a.id = i.allergen_id','LEFT');
            $this->db->where('i.cat_id',$value['id']);
            $this->db->order_by('i.orders','ASC');
            $query2 = $this->db->get();
            $query2 = $query2->result_array();
            

            foreach ($query2 as $key2 => $value2) {
                $this->db->select('ic.*');
                $this->db->from('item_content ic');
                $this->db->where('ic.item_id',$value2['id']);
                $this->db->where('ic.label IS NOT NULL', NULL, FALSE);
                $this->db->where('ic.value IS NOT NULL', NULL, FALSE);
                $this->db->order_by('id','ASC');
                $query3 = $this->db->get();
                $query3 = $query3->result_array();
                $query2[$key2]['items_content'] = $query3;
            }
            $query[$key]['items'] = $query2;
        }

        return $query;
        
    }


    public function get_all_items_for_order($per_page,$offset,$total)
    {
     $this->db->select('i.*,a.name as allergen,i.thumb as item_thumb');
     $this->db->from('items i');
     $this->db->join('allergens a','a.id = i.allergen_id','LEFT');
     $this->db->where('i.user_id',auth('id'));
     $this->db->where('i.status',1);
     $this->db->order_by('i.orders','ASC');
     if(isset($_REQUEST['q']) && !empty($_REQUEST['q'])){
        $this->db->like('i.title',trim($_REQUEST['q']));
     }

     if($total==1){
        $query = $this->db->get();
        $query = $query->num_rows();
     }else{
        $query = $this->db->get('',$per_page,$offset);
        $query = $query->result_array();
     }
     
     return $query;
        
    }
    public function get_all_items_by_user($id,$limit=0,$item_limit=8)
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
            if($item_limit !=0){
                $this->db->limit($item_limit); 
            }
            $this->db->order_by('i.orders','ASC');
            $query2 = $this->db->get();
            $query2 = $query2->result_array();
            $query[$key]['items'] = $query2;
        }

        return $query;

    }


    public function get_my_menu_type($id,$limit)
    {
        $this->db->select('mt.*');
        $this->db->from('menu_type mt');
        $this->db->where('user_id',$id);
        $this->db->where('status',1); 
        if($limit !=0){
            $this->db->limit($limit); 
        }
        $this->db->order_by('orders','ASC');
        $query = $this->db->get();
        $query = $query->result_array();
        foreach ($query as $key => $value) {
            $this->db->select('i.*');
            $this->db->from('items i');
            $this->db->where('i.cat_id',$value['id']);
            $this->db->where('i.status',1);
            if($limit !=0){
                $this->db->limit($limit); 
            }
            $this->db->order_by('i.orders','ASC');
            $query2 = $this->db->get();
            $query2 = $query2->num_rows();
            $query[$key]['total_item'] = $query2;
        }

        return $query;

    }



    public function get_all_packages($id)
    {
        $this->db->select('ip.*');
        $this->db->from('item_packages ip');
        $this->db->where('user_id',auth('id'));
        $this->db->where('is_special',0);
        if($id !=0){
            $this->db->where('id',$id);
        }
        $this->db->order_by('id','DESC');
        $query = $this->db->get();
        $query = $query->result_array();
        foreach($query as $key => $value){
            $this->db->select('i.id as items_id,i.title,i.thumb as item_thumb,i.cat_id,i.allergen_id,i.veg_type,i.price as item_price,a.name as allergen,i.img_type,i.img_url');
            $this->db->from('items i');
            $this->db->join('allergens a','a.id = i.allergen_id','LEFT');
            $this->db->where_in('i.id',json_decode($value['item_id']));
            $this->db->where('i.status',1);
            $this->db->order_by('i.orders','ASC');
            $query2 = $this->db->get();
            $query2 = $query2->result_array();
            $query[$key]['items'] = $query2;
        }

        return $query;
        
    }


    public function get_all_dine_in($id)
    {
        $this->db->select('ip.*');
        $this->db->from('item_packages ip');
        $this->db->where('user_id',auth('id'));
        $this->db->where('is_special',2);
        if($id !=0){
            $this->db->where('id',$id);
        }
        $this->db->order_by('id','DESC');
        $query = $this->db->get();
        $query = $query->result_array();
        foreach($query as $key => $value){
            $this->db->select('i.id as items_id,i.title,i.thumb as item_thumb,i.cat_id,i.allergen_id,i.veg_type,i.price as item_price,a.name as allergen');
            $this->db->from('items i');
            $this->db->join('allergens a','a.id = i.allergen_id','LEFT');
            $this->db->where_in('i.id',json_decode($value['item_id']));
            $this->db->where('i.status',1);
            $this->db->order_by('i.orders','ASC');
            $query2 = $this->db->get();
            $query2 = $query2->result_array();
            $query[$key]['items'] = $query2;
        }

        return $query;
        
    }


    public function get_my_order_list_by_id($id,$per_page,$offset,$total)
    {
        $this->db->select('ol.*');
        $this->db->from('order_user_list ol');
        if(isset($_GET)){
            $get = $_GET;
            if(!empty($get['order_type'])){
                 $this->db->where('ol.order_type',$get['order_type']);
            }else{

                $this->db->where_in('ol.order_type',$this->order_types);
            }

            if(!empty($get['uid'])){
                $this->db->where('ol.uid',$get['uid']);
            }

            if(!empty($get['name'])){
                if(is_numeric($get['name'])){
                    $this->db->where('ol.phone',$get['name']);
                }else{
                    $this->db->like('ol.name',$get['name']);
                }
                
            }


            if(!empty($get['table_no'])){
                $this->db->where('ol.table_no',$get['table_no']);
            }

            if(isset($get['status']) && $get['status'] !='all'){
                $this->db->where('ol.status',$get['status']);
            }
            if(!empty($get['daterange'])){

                $date_arr = explode('-',$get['daterange']);
                $newDate1 = date("Y-m-d", strtotime($date_arr[0]));
                $newDate2 = date("Y-m-d", strtotime($date_arr[1]));
                if($newDate1==$newDate2){
                     $this->db->where("DATE_FORMAT(ol.created_at,'%Y-%m-%d')",$newDate1);
                 }else{
                    if(isset($get['status']) && !empty($get['status'])){
                        if($get['status']==Status::COMPLETE):
                            $this->db->where("DATE_FORMAT(ol.completed_time,'%Y-%m-%d') >=",$newDate1);
                            $this->db->where("DATE_FORMAT(ol.completed_time,'%Y-%m-%d') <",$newDate2); 
                        elseif($get['status']==Status::ACCEPT):
                            $this->db->where("DATE_FORMAT(ol.accept_time,'%Y-%m-%d') >=",$newDate1);
                            $this->db->where("DATE_FORMAT(ol.accept_time,'%Y-%m-%d') <",$newDate2);
                        elseif($get['status']==Status::CANCEL):
                            $this->db->where("DATE_FORMAT(ol.cancel_time,'%Y-%m-%d') >=",$newDate1);
                            $this->db->where("DATE_FORMAT(ol.cancel_time,'%Y-%m-%d') <",$newDate2);
                        else:
                            $this->db->where("DATE_FORMAT(ol.created_at,'%Y-%m-%d') >=",$newDate1);
                            $this->db->where("DATE_FORMAT(ol.created_at,'%Y-%m-%d') <",$newDate2);
                        endif; 
                    }else{
                        $this->db->where("DATE_FORMAT(ol.created_at,'%Y-%m-%d') >=",$newDate1);
                        $this->db->where("DATE_FORMAT(ol.created_at,'%Y-%m-%d') <",$newDate2);
                    }
                    
                 }
                
            }



        }else{
            $this->db->where_in('ol.order_type',$this->order_types);
        }


        $this->db->where('ol.shop_id',$id);
        $this->db->order_by('status asc, created_at desc');
        if($total==1):
            $query = $this->db->get();
            $query = $query->num_rows();
        else:
            $query = $this->db->get('',$per_page,$offset);
            $query = $query->result_array();
            foreach($query as $key => $value){
                $this->db->select('SUM(oi.sub_total) as total_price');
                $this->db->from('order_item_list oi');
                $this->db->where('oi.order_id',$value['id']);
                $query2 = $this->db->get();
                $query2 = $query2->row_array();
                $query[$key]['total_price'] = $query2['total_price'];
            }
            foreach($query as $key => $value){
                $this->db->select('SUM(oi.qty) as total_item');
                $this->db->from('order_item_list oi');
                $this->db->where('oi.order_id',$value['id']);
                $query2 = $this->db->get();
                $query2 = $query2->row_array();
                $query[$key]['total_item'] = $query2['total_item'];
            }
        endif;
        return $query;
        
    }


    public function get_my_reservation_list_by_id($id)
    {
        $this->db->select('ol.*');
        $this->db->from('order_user_list ol');
        $this->db->where('ol.shop_id',$id);
        $this->db->where_in('ol.order_type',[3]);
        $this->db->order_by('status asc, created_at desc');
        $query = $this->db->get();
        $query = $query->result_array();
        foreach($query as $key => $value){
            $this->db->select('SUM(oi.sub_total) as total_price');
            $this->db->from('order_item_list oi');
            $this->db->where('oi.order_id',$value['id']);
            $query2 = $this->db->get();
            $query2 = $query2->row_array();
            $query[$key]['total_price'] = $query2['total_price'];
        }
        foreach($query as $key => $value){
            $this->db->select('Count(oi.sub_total) as total_item');
            $this->db->from('order_item_list oi');
            $this->db->where('oi.order_id',$value['id']);
            $query2 = $this->db->get();
            $query2 = $query2->row_array();
            $query[$key]['total_item'] = $query2['total_item'];
        }

        return $query;
        
    }


    public function get_my_today_call_waiter_list_by_id($id)
    {
         $today = today();
        $this->db->select('ol.*');
        $this->db->from('call_waiter_list ol');
        $this->db->where('ol.shop_id',$id);
        $this->db->where("DATE_FORMAT(ol.created_at,'%Y-%m-%d')", $today);
        $this->db->order_by('status asc, created_at desc');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
        
    }


    public function get_my_today_order_list_by_id($id)
    {
        $today = today();
        $sql = "(DATE_FORMAT(ol.created_at,'%Y-%m-%d')='{$today}' OR DATE_FORMAT(ol.accept_time,'%Y-%m-%d')='{$today}' OR DATE_FORMAT(ol.completed_time,'%Y-%m-%d')='{$today}') AND ol.shop_id='{$id}'";
        $this->db->select('ol.*');
        $this->db->from('order_user_list ol');

        if(isset($_GET)){
            $get = $_GET;
            if(!empty($get['order_type'])){
                 $this->db->where('ol.order_type',$get['order_type']);
            }else{

                $this->db->where_in('ol.order_type',$this->order_types);
            }

            if(!empty($get['name'])){
                if(is_numeric($get['name'])){
                    $this->db->where('ol.phone',$get['name']);
                }else{
                    $this->db->like('ol.name',$get['name']);
                }
                
            }

            if(!empty($get['uid'])){
                $this->db->where('ol.uid',$get['uid']);
            }


            if(!empty($get['table_no'])){
                $this->db->where('ol.table_no',$get['table_no']);
            }

            if(isset($get['status']) && $get['status'] !="all"){
                $this->db->where('ol.status',$get['status']);
            } 


        }else{
            $this->db->where_in('ol.order_type',$this->order_types);
        }
        $this->db->order_by('status asc, created_at desc');
        $this->db->where('ol.shop_id',$id);
        $this->db->where($sql);
        $query = $this->db->get();
        $query = $query->result_array();
        foreach($query as $key => $value){
            $this->db->select('SUM(oi.sub_total) as total_price');
            $this->db->from('order_item_list oi');
            $this->db->where('oi.order_id',$value['id']);
            $query2 = $this->db->get();
            $query2 = $query2->row_array();
            $query[$key]['total_price'] = $query2['total_price'];
        }
        foreach($query as $key => $value){
            $this->db->select('SUM(oi.qty) as total_item');
            $this->db->from('order_item_list oi');
            $this->db->where('oi.order_id',$value['id']);
            $query2 = $this->db->get();
            $query2 = $query2->row_array();
            $query[$key]['total_item'] = $query2['total_item'];
        }

        return $query;
        
    }


    public function get_my_todays_dine($id)
    {
         $today = today();
        $this->db->select('ol.*');
        $this->db->from('order_user_list ol');
        $this->db->where('ol.shop_id',$id);
        $this->db->where("DATE_FORMAT(ol.created_at,'%Y-%m-%d')", $today);
        $this->db->where_in('ol.order_type',[7]);
        $this->db->order_by('status asc, created_at desc');
        $query = $this->db->get();
        $query = $query->result_array();
        foreach($query as $key => $value){
            $this->db->select('p.*');
            $this->db->from('item_packages p');
            $this->db->where('p.id',$value['dine_id']);
            $query2 = $this->db->get();
            $query2 = $query2->result_array();
            foreach($query2 as $key2 => $value2){
                $this->db->select('i.id as items_id,i.title,i.thumb as item_thumb,i.cat_id,i.allergen_id,i.veg_type,i.price as item_price,a.name as allergen');
                $this->db->from('items i');
                $this->db->join('allergens a','a.id = i.allergen_id','LEFT');
                $this->db->where_in('i.id',json_decode($value2['item_id']));
                $this->db->where('i.status',1);
                $this->db->order_by('i.orders','ASC');
                $query3 = $this->db->get();
                $query3 = $query3->result_array();
                $query2[$key2]['all_items'] = $query3;
            }

            $query[$key]['package_list'] = $query2;
        }

        
        return $query;
        
    }

    public function get_dinin_items($din_id){
        $this->db->select('p.*');
        $this->db->from('item_packages p');
        $this->db->where('p.id',$din_id);
        $query = $this->db->get();
        $query = $query->result_array();
        foreach($query as $key => $value){
            $this->db->select('i.id as items_id,i.title,i.thumb as item_thumb,i.cat_id,i.allergen_id,i.veg_type,i.price as item_price,a.name as allergen');
            $this->db->from('items i');
            $this->db->join('allergens a','a.id = i.allergen_id','LEFT');
            $this->db->where_in('i.id',json_decode($value['item_id']));
            $this->db->where('i.status',1);
            $this->db->order_by('i.orders','ASC');
            $query2= $this->db->get();
            $query2 = $query2->result_array();
            $query[$key]['all_items'] = $query2;
        }
        return $query;
    }
    

    public function delete_item_content($id)
    {
        $this->db->delete('item_content',array('item_id'=>$id));
        return $id;
    }

    public function get_item_list_by_order_id($id,$shop_id)
    {
        $this->db->select('ol.*');
        $this->db->from('order_user_list ol');
        $this->db->where('ol.uid',$id);
        $this->db->where('ol.shop_id',$shop_id);
        $this->db->order_by('id','DESC');
        $query = $this->db->get();
        $query = $query->result_array();
        foreach($query as $key => $value){
            $this->db->select('SUM(oi.sub_total) as total_price');
            $this->db->from('order_item_list oi');
            $this->db->where('oi.order_id',$value['id']);
            $query2 = $this->db->get();
            $query2 = $query2->row_array();
            $query[$key]['total_price'] = $query2['total_price'];
        }
        foreach($query as $key => $value){
            $this->db->select('count(oi.sub_total) as total_item');
            $this->db->from('order_item_list oi');
            $this->db->where('oi.order_id',$value['id']);
            $query2 = $this->db->get();
            $query2 = $query2->row_array();
            $query[$key]['total_item'] = $query2['total_item'];
        }
        foreach($query as $key => $value){
            $this->db->select('oi.*');
            $this->db->select('i.id as items_id,i.title,i.thumb as item_thumb,i.cat_id,i.allergen_id,i.veg_type,i.price,a.name as allergen,i.img_type,i.img_url,i.tax_status,i.tax_fee');
            $this->db->select('ip.package_name,ip.thumb as package_thumb,ip.final_price');
            $this->db->from('order_item_list oi');
            $this->db->join('items i','i.id = oi.item_id','LEFT');
            $this->db->join('allergens a','a.id = i.allergen_id','LEFT');
            $this->db->join('item_packages ip','ip.id = oi.package_id','LEFT');
            // $this->db->where('oi.is_package',0);
            $this->db->where('oi.order_id',$value['id']);
            $this->db->order_by('oi.created_at','ASC');
            $query2 = $this->db->get();
            $query2 = $query2->result_array();
            $query[$key]['item_list'] = $query2;
        }
        

        return $query;
        
    }


    public function get_admin_specilities($limit=0)
    {
        $this->db->select('mt.*');
        $this->db->from('item_packages mt');
        $this->db->where('user_id',auth('id'));
        if($limit !=0){
            $this->db->limit($limit); 
        }
        $this->db->where('is_special',1);
        $this->db->order_by('id','DESC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;

    }

    public function get_cat_info_by_type($type)
    {
        $this->db->select('s.*');
        $this->db->from('item_sizes s');
        $this->db->where('s.type',$type);
        $this->db->where('s.user_id',auth('id'));
        $this->db->order_by('id','ASC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;

    }

    public function get_size_by_slug($slug,$user_id)
    {
        $this->db->select('s.*');
        $this->db->from('item_sizes s');
        $this->db->where('s.slug',$slug);
        $this->db->where('s.user_id',$user_id);
        $this->db->order_by('id','ASC');
        $query = $this->db->get();
        if($query->num_rows() > 0):
            $query = $query->row_array();
            return isset($query['title']) && !empty($query['title'])? $query['title']:'';
        else:
            return '';
        endif;

    } 


    public function get_size_by_type($type,$user_id)
    {
        $this->db->select('s.*');
        $this->db->from('item_sizes s');
        $this->db->where('s.type',$type);
        $this->db->where('s.user_id',$user_id);
        $this->db->order_by('id','ASC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;

    } 

    public function get_single_size_by_slug($slug,$user_id)
    {
        $this->db->select('s.*');
        $this->db->from('item_sizes s');
        $this->db->where('s.slug',$slug);
        $this->db->where('s.shop_id',$user_id);
        $this->db->order_by('id','ASC');
        $query = $this->db->get();
        $query = $query->row_array();
        return !empty($query)?$query['title']:"";

    }
    public function get_size_info_by_slug($slug,$shop_id)
    {
        $this->db->select('s.*');
        $this->db->from('item_sizes s');
        $this->db->where('s.slug',$slug);
        $this->db->where('s.shop_id',$shop_id);
        $this->db->order_by('id','ASC');
        $query = $this->db->get();
        $query = $query->row_array();
        return $query;

    }

    public function get_type_by_id($id)
    {
        $this->db->select('s.*');
        $this->db->from('menu_type s');
        $this->db->where('s.id',$id);
        $this->db->order_by('s.orders','ASC');
        $query = $this->db->get();
        $query = $query->row_array()['type'];
        return $query;

    }

    public function get_type_by_md5id($id)
    {
        $this->db->select('s.*');
        $this->db->from('menu_type s');
        $this->db->where('md5(s.id)',$id);
        $this->db->order_by('s.orders','ASC');
        $query = $this->db->get();
        $query = $query->row_array()['type'];
        return $query;

    }

    public function get_type_by_md5id_ln($id)
    {
        $this->db->select('s.*');
        $this->db->from('menu_type s');
        $this->db->where('md5(s.category_id)',$id);
        $this->db->order_by('s.orders','ASC');
        $query = $this->db->get();
        $query = $query->row_array()['type'];
        return $query;

    }

    public function get_package_items()
    {
        $shop_id = restaurant()->id;
        $this->db->select('i.*');
        $this->db->from('items i');
        $this->db->where('i.user_id',auth('id'));
        $this->db->where('i.shop_id',$shop_id);
        $this->db->where('i.is_size','0');
        $this->db->order_by('i.orders','ASC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;

    }

    public function get_todays_notify($shop_id)
    {
         $today = today();
        $this->db->select('or.*');
        $this->db->from('order_user_list or');
        $this->db->where("DATE_FORMAT(or.created_at,'%Y-%m-%d')", $today);
        $this->db->where('or.shop_id',$shop_id);
        $this->db->where('or.status',0);
        $this->db->where('or.is_ring',1);
        $this->db->where_in('or.order_type',$this->order_types);
        $query = $this->db->get();
        $query = $query->num_rows();
        return $query;

    }

    public function get_merged_order_list()
    {
        $today = today();
        $shop_id = restaurant()->id;
        $this->db->select('or.id,or.uid');
        $this->db->from('order_user_list or');
        $this->db->where("DATE_FORMAT(or.created_at,'%Y-%m-%d')", $today);
        $this->db->where('or.shop_id',$shop_id);
        $this->db->where('or.merge_status',1);
        $this->db->where_in('or.order_type',$this->order_types);
        $this->db->order_by('or.id','DESC');
        $query = $this->db->get();
        $query = $query->result_array();
        foreach ($query as $key => $value) {
         $this->db->select('or.id as order_item_id,or.order_id,or.merge_id');
         $this->db->from('order_item_list or');
         $this->db->where('or.order_id',$value['id']);
         $this->db->order_by('or.id','DESC');
         $this->db->limit(1);
         $query2 = $this->db->get();
         $query2 = $query2->row_array();
         $query[$key]['merge_id'] = $query2;
        }
        return $query;

    }

    public function get_todays_all_notify($shop_id)
    {
         $today = today();
        $this->db->select('or.*');
        $this->db->from('order_user_list or');
        $this->db->where("DATE_FORMAT(or.created_at,'%Y-%m-%d')", $today);
        $this->db->where('or.shop_id',$shop_id);
        $this->db->where('or.status',0);
        $this->db->where('or.is_ring',1);
        $query = $this->db->get();
        $query = $query->num_rows();
        return $query;

    }

    public function get_todays_reservations_notify($shop_id)
    {
         $today = today();
        $this->db->select('or.*');
        $this->db->from('order_user_list or');
        $this->db->where("DATE_FORMAT(or.created_at,'%Y-%m-%d')", $today);
        $this->db->where('or.shop_id',$shop_id);
        $this->db->where('or.status',0);
        $this->db->where('or.is_ring',1);
        $this->db->where_in('or.order_type',[3]);
        $query = $this->db->get();
        $query = $query->num_rows();
        return $query;

    }

    public function get_new_orders($shop_id)
    {
         $today = today();
        $this->db->select('or.*');
        $this->db->from('order_user_list or');
        $this->db->where("DATE_FORMAT(or.created_at,'%Y-%m-%d')", $today);
        $this->db->where_in('or.order_type',$this->order_types);
        $this->db->where('or.shop_id',$shop_id);
        $this->db->where('or.status',0);
        $query = $this->db->get();
        $query = $query->num_rows();
        return $query;

    }

    public function get_new_dine_order($shop_id)
    {
        $today = today();
    
        $this->db->select('or.*');
        $this->db->from('order_user_list or');
        $this->db->where("DATE_FORMAT(or.created_at,'%Y-%m-%d')", $today);
        $this->db->where_in('or.order_type',[7,6]);
        $this->db->where('or.shop_id',$shop_id);
        $this->db->where('or.status',0);
        $query = $this->db->get();
        $query = $query->num_rows();
        return $query;

    }

    public function get_today_completed_order($shop_id)
    {
         $today = today();
        $this->db->select('or.*');
        $this->db->from('order_user_list or');
        $this->db->where("DATE_FORMAT(or.created_at,'%Y-%m-%d')", $today);
        $this->db->where_in('or.order_type',$this->order_types);
        $this->db->where('or.shop_id',$shop_id);
        $this->db->where('or.status',2);
        $query = $this->db->get();
        $query = $query->num_rows();
        return $query;

    }

    public function get_todays_reservations($shop_id)
    {
         $today = today();
        $this->db->select('or.*');
        $this->db->from('order_user_list or');
        $this->db->where("DATE_FORMAT(or.created_at,'%Y-%m-%d')", $today);
        $this->db->where('or.shop_id',$shop_id);
        $this->db->where_in('or.order_type',[3]);
        $query = $this->db->get();
        $query = $query->num_rows();
        return $query;

    }



    /**
      ** single_appoinment
    **/
    public function single_appoinment($id)
    {
        $shop_id = shop_id();
        $this->db->select('r.*');
        $this->db->from('reservation_date r');
        $this->db->where('r.days',$id);
        $this->db->where('r.shop_id',$shop_id);
        $this->db->where('r.user_id',auth('id'));
        $query = $this->db->get();
        if($query->num_rows() > 0):
            return $query->row_array();
        else:
            return [];
        endif;
    }

    function delete_appointment($table)
    {
        $this->db->delete($table,array('shop_id'=>shop_id()));
        return 1;
    }
    public function count_table_by_user_id($table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('user_id',auth('id'));
        $query = $this->db->get();
        $query = $query->num_rows();
        return $query;
    }

    public function get_user_total_income_by_month($month,$type=0)
    {
        $shop_id = restaurant()->id;
        $this->db->select('or.*');
        $this->db->select('COUNT(or.id) as total_transaction');
        $this->db->select_sum('or.total','total_price');
        $this->db->from('order_user_list or');
        $this->db->where('or.shop_id',$shop_id);
        $this->db->where('or.status',2);
        $this->db->where('SUBSTRING(or.created_at,1,7)', date('Y').'-'.$month);
        $query = $this->db->get();
        $query = $query->row_array();
        if($type==0):
            return !empty($query['total_price'])?$query['total_price']:0;
        else:
            return !empty($query['total_transaction'])?$query['total_transaction']:0;
        endif;
    }


    public function get_total_income_admin($month,$type=0)
    {
  
        $this->db->select('or.*');
        $this->db->select('COUNT(or.id) as total_transaction');
        $this->db->select_sum('or.price','total_price');
        $this->db->from('payment_info or');
        if($month=='year'):
            $this->db->where("DATE_FORMAT(or.created_at,'%Y')", date("Y"));
        elseif($month=='month'):
            $this->db->where("DATE_FORMAT(or.created_at,'%m')", date("m"));
        endif;
        $query = $this->db->get();
        $query = $query->row_array();
        if($type==0):
            return !empty($query['total_price'])?$query['total_price']:0;
        else:
            return !empty($query['total_transaction'])?$query['total_transaction']:0;
        endif;
    }


    public function user_total_income_in_year($type)
    {
        $shop_id = restaurant()->id;
        $this->db->select_sum('or.total','total_price');
        $this->db->from('order_user_list or');
        $this->db->where('or.shop_id',$shop_id);
        $this->db->where('or.status',2);
        if($type=='year'):
            $this->db->where("DATE_FORMAT(or.created_at,'%Y')", date("Y"));
        elseif($type=='month'):
            $this->db->where("DATE_FORMAT(or.created_at,'%m')", date("m"));
        endif;
        $query = $this->db->get();
        $query = $query->row_array();
        return !empty($query['total_price'])?round($query['total_price']):0;
    }

    public function get_users_order_types($user_id,$type)
    {
        $this->db->select('u.*,u.id as user_type_id,ot.name as type_name,ot.slug');
        $this->db->from('users_active_order_types u');
        $this->db->join('order_types ot','ot.id = u.type_id','LEFT');
        $this->db->where('u.user_id',$user_id);
        if($type==1):
            $this->db->where('ot.is_order_types',1);
        endif;
        $this->db->order_by('u.id','ASC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

    public function get_users_order_types_by_shop_id($shop_id)
    {
        $this->db->select('u.*,u.id as user_type_id,ot.name as type_name,ot.slug,ot.id as order_type_id');
        $this->db->from('users_active_order_types u');
        $this->db->join('order_types ot','ot.id = u.type_id','LEFT');
        $this->db->where('u.shop_id',$shop_id);
        $this->db->where('u.status',1);
        $this->db->where('ot.is_order_types',1);
        $this->db->order_by('u.id','ASC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

    public function get_extras($item_id,$shop_id)
    {
        $this->db->select('ie.*');
        $this->db->from('item_extras ie');
        $this->db->where('ie.item_id',$item_id);
        $this->db->where('ie.shop_id',$shop_id);
        $this->db->order_by('ie.id','ASC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }


    public function get_currency($id)
    {
        $this->db->select('c.currency_code,c.currency_symbol as icon');
        $this->db->from('country c');
        $this->db->where('c.id',$id);
        $query = $this->db->get();
        $query = $query->row_array();
        return $query;
    }

    public function check_extra_by_item_id($id)
    {
        $this->db->select('c.*');
        $this->db->from('item_extras c');
        $this->db->where('c.item_id',$id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return ['check'=>1,'total'=>$query->num_rows()];
        }else{
            return ['check'=>0,'total'=>0];
        }
        
    }

    public function get_extras_by_id($id,$item_id)
    {
        $this->db->select('c.*');
        $this->db->from('item_extras c');
        $this->db->where('c.id',$id);
        $this->db->where('c.item_id',$item_id);
        $query = $this->db->get();
         if($query->num_rows() > 0):
            return $query->row();
        else:
            return 0;
        endif;
        
    }


    public function get_admin()
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('user_role',1);
        $query = $this->db->get();
        $query = $query->row();
        return $query;
    }

    public function insert_order_item($insertId){
        $cartItems = $this->cart->contents();
            // Cart items
            $ordItemData = array();
            $i=0;
            foreach($cartItems as $item){
                if(isset($item['is_size']) && $item['is_size']==1){
                    $id = strstr($item['id'], '-', true);
                    $is_size = 1;
                    $size_slug = $item['sizes']['size_slug'];
                }else{
                    $id = $item['id'];
                    $is_size = 0;
                    $size_slug = '';
                }
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
                $ordItemData[$i]['created_at'] = d_time();

                if($item['is_package']==1):
                    $info = single_select_by_id($id,'item_packages');
                    $up_data = ['remaining' => $info['remaining']+$item['qty']];
                    $this->update($up_data,$id,'item_packages');
                else:
                    $info = single_select_by_id($id,'items');
                    $up_data = ['remaining' => $info['remaining']+$item['qty']];
                    $this->update($up_data,$id,'items');
                endif;

                $i++;
            }
            $insert = $this->insert_all($ordItemData,'order_item_list');
            if($insert){
                return TRUE;
            }else{
                return FALSE;
            }

    }
    

    public function get_my_today_order_list_by_kds_id($id)
    {
         $today = today();
        $this->db->select('ol.*');
        $this->db->from('order_user_list ol');
        $this->db->where('md5(ol.shop_id)',$id);
        $this->db->where("DATE_FORMAT(ol.accept_time,'%Y-%m-%d')", $today);
        $this->db->where('ol.order_type !=',3);
        $this->db->where('ol.order_type !=',7);
        $this->db->order_by('status asc, created_at desc');
        $query = $this->db->get();
        $query = $query->result_array();
        foreach($query as $key => $value){
            $this->db->select('SUM(oi.sub_total) as total_price');
            $this->db->from('order_item_list oi');
            $this->db->where('oi.order_id',$value['id']);
            $query2 = $this->db->get();
            $query2 = $query2->row_array();
            $query[$key]['total_price'] = $query2['total_price'];
        }
        foreach($query as $key => $value){
            $this->db->select('Count(oi.sub_total) as total_item');
            $this->db->from('order_item_list oi');
            $this->db->where('oi.order_id',$value['id']);
            $query2 = $this->db->get();
            $query2 = $query2->row_array();
            $query[$key]['total_item'] = $query2['total_item'];
        }

        foreach($query as $key => $value){
            $this->db->select('oi.*');
            $this->db->select('i.id as items_id,i.title,i.thumb as item_thumb,i.cat_id,i.allergen_id,i.veg_type,i.price,a.name as allergen');
            $this->db->select('ip.package_name,ip.thumb as package_thumb,ip.final_price');
            $this->db->from('order_item_list oi');
            $this->db->join('items i','i.id = oi.item_id','LEFT');
            $this->db->join('allergens a','a.id = i.allergen_id','LEFT');
            $this->db->join('item_packages ip','ip.id = oi.package_id','LEFT');
            $this->db->where('oi.order_id',$value['id']);
            $this->db->where('oi.shop_id',$value['shop_id']);
            $this->db->order_by('i.orders','ASC');
            $query2 = $this->db->get();
            $query[$key]['all_items'] = $query2->result_array();
        }

        return $query;
        
    }


    public function get_new_kds_order($id)
    {
         $today = today();
        $this->db->select('ol.*');
        $this->db->from('order_user_list ol');
        $this->db->where('ol.shop_id',$id);
        $this->db->where("DATE_FORMAT(ol.accept_time,'%Y-%m-%d')", $today);
        $this->db->where('ol.order_type !=',3);
        $this->db->where('ol.is_preparing',0);
        $this->db->where('ol.status',1);
        $this->db->order_by('status asc, accept_time desc');
        $query = $this->db->get();
        $query = $query->num_rows();
        return $query;
        
    }

    public function total_features()
    {
        $this->db->select('ol.*');
        $this->db->from('features ol');
        $query = $this->db->get();
        $query = $query->num_rows();
        return $query;
        
    }

    public function get_my_all_staf()
    {
        $this->db->select('ol.*');
        $this->db->from('staff_list ol');
        $this->db->where('ol.user_id',auth('id'));
        $this->db->where('ol.role','staff');
        $this->db->order_by('id','DESC');
        $query = $this->db->get();
        $query = $query->result_array();
        foreach($query as $key => $value){
            $this->db->select('p.*,');
            $this->db->from('permission_list p');
            $this->db->where_in('p.id',json_decode($value['permission']));
            $this->db->order_by('p.id','ASC');
            $query2 = $this->db->get();
            $query2 = $query2->result_array();
            $query[$key]['permission'] = $query2;
        }
        

        return $query;
        
    }

    public function get_my_all_dboy()
    {
        $this->db->select('ol.*');
        $this->db->from('staff_list ol');
        $this->db->where('ol.user_id',auth('id'));
        $this->db->where('ol.role','delivery');
        $this->db->order_by('id','DESC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
        
    }


    public function get_my_active_all_dboy($user_id)
    {
        $this->db->select('ol.*');
        $this->db->from('staff_list ol');
        $this->db->where('ol.user_id',$user_id);
        $this->db->where('ol.status',1);
        $this->db->where('ol.role','delivery');
        $this->db->order_by('id','DESC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
        
    }


    public function check_using_purchase_code($purchase_code)
    {
        $this->db->select('al.*');
        $this->db->from('addons_list al');
        $this->db->where('al.purchase_code',$purchase_code);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row();
        }else{
            return 0;
        }

        
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

     public function get_my_all_customer()
    {
        $shop_id = restaurant()->id;
        $this->db->select('ol.*,ol.customer_name as name,or.customer_id,or.shop_id');
        $this->db->from('customer_list ol');
        $this->db->join('order_user_list or','or.customer_id = ol.id','LEFT');
        $this->db->where('ol.role','customer');
        $this->db->where('ol.user_id',auth('id'));
        $this->db->or_where('or.shop_id',$shop_id);
        $this->db->group_by('ol.id');
        $this->db->order_by('ol.id','DESC');
        $query = $this->db->get();
        $query = $query->result_array();
        foreach ($query as $key => $value) {
            $this->db->select('ol.*');
            $this->db->from('order_user_list ol');
            $this->db->where('ol.shop_id',$shop_id );
            $this->db->where('ol.customer_id',$value['customer_id'] );
            $query2 = $this->db->get();
            $query2 = $query2->num_rows();
            $query[$key]['total_orders'] = $query2;
        }
        array_multisort(array_column($query, 'total_orders'), SORT_DESC, $query);
        return $query;
        
    } 

    public function get_staff_info()
    {
        $this->db->select('ol.*');
        $this->db->from('staff_list ol');
        $this->db->where('ol.id',auth('staff_id'));
        $this->db->order_by('id','DESC');
        $query = $this->db->get();
        $query = $query->row();
        return $query;
        
    }

    public function check_exits_staff($email)
    {
        $this->db->select('u.*');
        $this->db->from('staff_list u');
        $this->db->where_in('u.role', ['user','admin_staff']);
        $this->db->where('u.email', $email);
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() ==1){
            return 1;
        }else{
            return 0;
        }

    }


    public function select_permossion($type)
    {
        $this->db->select('u.*');
        $this->db->from('permission_list u');
        $this->db->where('u.role', $type);
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;

    }


    public function check_permission($type)
    {
    
        if(auth('is_staff')==TRUE):
            $this->db->select('ol.*');
            $this->db->from('staff_list ol');
            $this->db->where('ol.user_id',auth('id'));
            $this->db->where('ol.id',auth('staff_id'));
            $this->db->order_by('id','DESC');
            $query = $this->db->get();
            $query = $query->row_array();
            if(in_array($this->get_id_by_slug($type),json_decode($query['permission'],true))){
                return 1;
            }else{
                return 0;
            }
        else:
            return 1;
        endif;
          
          
    } 

    public function get_id_by_slug($slug)
    {
        $this->db->select('p.slug,id');
        $this->db->from('permission_list p');
        $this->db->where('p.slug',$slug);
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() ==1){
            return $query->row_array()['id'];
        }else{
            return 0;
        }

    }

    // check password for change password 
    public function check_staff_pass($pass)
    {
        $this->db->select('u.password');
        $this->db->from('staff_list as u');
        $this->db->where('u.id', auth('staff_id'));
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() ==1){
            $result = $query->result();
            foreach ($result as $row) {
                if ($this->verify_password($pass, $row->password) == TRUE) {
                    return $result;
                } else {
                    return FALSE;
                }
            }
        }else{
            return false;
        }

    }

    public function get_country_info($code)
    {
        $this->db->select();
        $this->db->from('country');
        $this->db->where('code',$code);
        $query = $this->db->get();
        $query = $query->row();
        return $query;
    }

     public function check_customer_login($email,$password)
    {
        $this->db->select('u.*');
        $this->db->from('customer_list u');
        $this->db->where("(u.phone = '$email' OR u.email = '$email')");
        $this->db->where('u.password', md5($password));
        $this->db->where('u.role', 'customer');
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() ==1){
            return $query->result();
        }else{
            return false;
        }

    }

    public function get_my_today_reservation_list_by_id($id)
    {
         $today = today();
        $this->db->select('ol.*');
        $this->db->from('order_user_list ol');
        $this->db->where('ol.shop_id',$id);
        $this->db->where_in('ol.order_type',[3]);
        $this->db->where("DATE_FORMAT(ol.created_at,'%Y-%m-%d')", $today);
        $this->db->order_by('status asc, created_at desc');
        $query = $this->db->get();
        $query = $query->result_array();
        foreach($query as $key => $value){
            $this->db->select('SUM(oi.sub_total) as total_price');
            $this->db->from('order_item_list oi');
            $this->db->where('oi.order_id',$value['id']);
            $query2 = $this->db->get();
            $query2 = $query2->row_array();
            $query[$key]['total_price'] = $query2['total_price'];
        }
        foreach($query as $key => $value){
            $this->db->select('Count(oi.sub_total) as total_item');
            $this->db->from('order_item_list oi');
            $this->db->where('oi.order_id',$value['id']);
            $query2 = $this->db->get();
            $query2 = $query2->row_array();
            $query[$key]['total_item'] = $query2['total_item'];
        }

        return $query;
        
    }

    public function get_customer_order_list($id){
        $this->db->select('or.*,sl.customer_name,sl.phone,sl.country_id');
        $this->db->from('order_user_list or');
        $this->db->join('customer_list sl','sl.id=or.customer_id','LEFT');
        $this->db->where('or.customer_id',$id);
        $this->db->order_by('or.id','DESC');
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
        
        
        return $query;
    }

    public function customer_info($id){
        $this->db->select('st.*,c.id as country_id, c.currency_symbol as icon, c.currency_code as code,c.dial_code');
        $this->db->from('customer_list st');
        $this->db->join('country c','c.id=st.country_id','LEFT');
        $this->db->where('st.id',$id);
        $query = $this->db->get();
        $query = $query->row();
        return $query;
    }

    public function get_all_delivery_order_list($user_id,$status,$is_picked){
        $last7 = make_date('7','days');
        $today = today();
        $this->db->select('or.*,sl.name as staff_name,sl.phone as staff_phone,sl.country_id,rl.id as shop_id,rl.name as shop_name');
        $this->db->from('order_user_list or');
        $this->db->join('staff_list sl','sl.id=or.customer_id','LEFT');
        $this->db->join('restaurant_list rl','rl.id=or.shop_id','LEFT');
        $this->db->where('rl.user_id',$user_id);
        $this->db->where('or.status',2);
        $this->db->where_in('or.order_type',[1]);
        $this->db->where('or.dboy_status',0);
        $this->db->where("DATE_FORMAT(or.completed_time,'%Y-%m-%d') <=", $today);
        $this->db->where("DATE_FORMAT(or.completed_time,'%Y-%m-%d') >=", $last7);
        $this->db->order_by('or.id','DESC');
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
        
        
        return $query;
    }

    public function get_all_active_delivery_order_list($dboy_id,$status,$is_picked){
        $this->db->select('or.*,sl.name as staff_name,sl.phone as staff_phone,sl.country_id,rl.id as shop_id,rl.name as shop_name');
        $this->db->from('order_user_list or');
        $this->db->join('staff_list sl','sl.id=or.customer_id','LEFT');
        $this->db->join('restaurant_list rl','rl.id=or.shop_id','LEFT');
        $this->db->where('or.status',2);
        $this->db->where('or.dboy_id',$dboy_id);
        $this->db->where('or.dboy_status',$status);
        $this->db->where('or.is_picked',$is_picked);
        $this->db->where_in('or.order_type',[1]);
        $this->db->order_by('or.id','DESC');
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
        
        
        return $query;
    }


    public function get_total_completed_order_by_shop($shop_id)
    {
        
        $this->db->select('or.*');
        $this->db->from('order_user_list or');
        $this->db->where('or.shop_id',$shop_id);
        $this->db->where('or.status',2);
        $query = $this->db->get();
        $query = $query->num_rows();
        return $query;

    }  

    public function top_10_popular_shop()
    {
        $sql = "u.is_expired=0 AND u.is_deactived=0 AND u.is_active=1";

       $this->db->select('or.id,or.status,or.shop_id,l.username as shop_username,l.name as shop_name,l.thumb,l.slogan,u.id as user_id, u.is_expired,u.is_deactived,u.is_active');
       $this->db->select('COUNT(or.id) as total_order');
       $this->db->from('order_user_list or');
       $this->db->join('restaurant_list l','l.id=or.shop_id','LEFT');
       $this->db->join('users u','u.id=l.user_id','LEFT');
       $this->db->where('or.status',2);
       $this->db->where($sql);
       $this->db->group_by('or.shop_id');
       $this->db->order_by('total_order','DESC');
       $this->db->limit('6');
       $query = $this->db->get();
       $query = $query->result_array();
       return $query;

   }

   public function top_8_popular_items(){
     $sql = "u.is_expired=0 AND u.is_deactived=0 AND u.is_active=1";
        $this->db->select('or.id,or.item_id,or.package_id,or.is_package,i.is_size,i.user_id,i.thumb as item_img,i.overview,i.img_url,i.img_type,i.price,ou.status,ou.id as order_id,i.title as item_name,ip.package_name,ou.order_type,or.created_at,or.shop_id,r.username as shop_username,r.name as shop_name,r.thumb as logo,u.id as user_id, u.is_expired,u.is_deactived,u.is_active');
        $this->db->select('COUNT(or.item_id) as total_sell');
        $this->db->from('order_item_list or');
        $this->db->join('order_user_list ou','ou.id=or.order_id','LEFT');
        $this->db->join('items i','i.id=or.item_id','LEFT');
        $this->db->join('item_packages ip','ip.id = or.package_id','LEFT');
        $this->db->join('restaurant_list r','r.id = or.shop_id','LEFT');
        $this->db->join('users u','u.id=r.user_id','LEFT');
        $this->db->where('ou.status',2);
        $this->db->where($sql);
        $this->db->group_by('or.item_id');
        $this->db->order_by('total_sell','DESC');
        $this->db->limit('6');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    } 

    public function top_8_popular_search_items($name){
        
        $this->db->select('i.*,i.id as item_id,i.title as item_name,or.shop_id,r.username as shop_username,r.name as shop_name,r.thumb as logo,or.shop_id,i.thumb as item_img');
        $this->db->from('items i');
        $this->db->join('order_item_list or','or.item_id=i.id','LEFT');
        $this->db->join('restaurant_list r','r.id = i.shop_id','LEFT');
        $this->db->like('i.title',$name);
        $this->db->group_by('i.id');
        $query = $this->db->get();
        $query = $query->result_array();
        foreach ($query as $key => $value) {
            $this->db->select('i.*,or.item_id');
            $this->db->from('items i');
            $this->db->join('order_item_list or','or.item_id=i.id','LEFT');
            $this->db->where('or.item_id',$value['item_id']);
            $query2 = $this->db->get();
            $query2 = $query2->num_rows();
            $query[$key]['total_sell'] = $query2;
        }
        return $query;
    } 
  
    public function get_all_accepted_delivery_order_list($dboy_id){
        $this->db->select('or.*,sl.name as staff_name,sl.phone as staff_phone,sl.country_id,rl.id as shop_id,rl.name as shop_name');
        $this->db->from('order_user_list or');
        $this->db->join('staff_list sl','sl.id=or.customer_id','LEFT');
        $this->db->join('restaurant_list rl','rl.id=or.shop_id','LEFT');
        $this->db->where('or.dboy_id',$dboy_id);
        $this->db->where_in('or.order_type',[1]);
        $this->db->where('or.status',2);
        $this->db->order_by('or.id','DESC');
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
        
        
        return $query;
    }

    public function count_all_delivery_list($dboy_id,$status){
        $this->db->select('or.*');
        $this->db->from('order_user_list or');
        $this->db->where('or.dboy_id',$dboy_id);
        $this->db->where_in('or.order_type',[1]);
        if($status==1){
           $this->db->where('or.is_db_completed',0); 
           $this->db->where('or.is_db_accept',1); 
           $this->db->where_in('or.status',[1,2]); 
        }elseif($status==2){
            $this->db->where('or.dboy_status',3); 
            $this->db->where('or.is_picked',1);
        }
        $this->db->order_by('or.id','DESC');
        $query = $this->db->get();
        $query = $query->num_rows();
        return $query;
    }


    public function get_total_earning($dboy_id,$status){
        $this->db->select('SUM(or.total) as total_earning');
        $this->db->from('order_user_list or');
        $this->db->where('or.dboy_id',$dboy_id);
        $this->db->where_in('or.order_type',[1]);
        if($status==1){
           $this->db->where('or.dboy_status',1); 
           $this->db->where('or.is_picked',0); 
        }elseif($status==2){
            $this->db->where('or.dboy_status',2); 
            $this->db->where('or.is_picked',1);
        }elseif($status==3){
            $this->db->where('or.dboy_status',3); 
            $this->db->where('or.is_db_completed',1);
        }
        $this->db->order_by('or.id','DESC');
        $query = $this->db->get();
        $query = $query->row();
        return $query->total_earning;
    }


    public function top_10_popular_customers(){
        $id = restaurant()->id;
        $this->db->select('ul.id,ul.id as order_id,ul.uid,ul.customer_id,ul.status,ul.created_at,ul.order_type,ul.total,sl.customer_name,sl.thumb as customer_thumb');
        $this->db->from('order_user_list ul');
        $this->db->join('customer_list sl','sl.id=ul.customer_id','LEFT');
        $this->db->where('ul.shop_id',$id);
        $this->db->where('ul.status',2);
        $this->db->group_by('ul.customer_id,');
        $this->db->order_by('ul.id','DESC');
        if(!empty($_GET['daterange'])){
            $date_arr = explode('-',$_GET['daterange']);
            $newDate1 = date("Y-m-d", strtotime($date_arr[0]));
            $newDate2 = date("Y-m-d", strtotime($date_arr[1]));
            $this->db->where("DATE_FORMAT(ul.created_at,'%Y-%m-%d') >=",$newDate1);
            $this->db->where("DATE_FORMAT(ul.created_at,'%Y-%m-%d') <=",$newDate2);
        }
        $query = $this->db->get();
        $query = $query->result_array();
        foreach($query as $key => $value){
            $this->db->select('ul.id,ul.id as order_id,ul.uid,ul.customer_id,ul.status,ul.created_at,ul.order_type,ul.total');
            $this->db->from('order_user_list ul');
            $this->db->where('ul.shop_id',$id);
            $this->db->where('ul.customer_id',$value['customer_id']);
            $this->db->where('ul.status',2);
            $this->db->group_by('ul.customer_id,');
            if(!empty($_GET['daterange'])){
                $date_arr = explode('-',$_GET['daterange']);
                $newDate1 = date("Y-m-d", strtotime($date_arr[0]));
                $newDate2 = date("Y-m-d", strtotime($date_arr[1]));
                $this->db->where("DATE_FORMAT(ul.created_at,'%Y-%m-%d') >=",$newDate1);
                $this->db->where("DATE_FORMAT(ul.created_at,'%Y-%m-%d') <=",$newDate2);
            }
            $query2 = $this->db->get();
            $query2 = $query2->result_array();
            $sum =0;
            foreach($query2 as $key2 => $value2){
                $this->db->select('SUM(oi.qty) as total_item');
                $this->db->from('order_item_list oi');
                $this->db->where('oi.order_id',$value2['id']);
                $query3 = $this->db->get();
                $query3 = $query3->row_array();
                $query2[$key2]['total_item'] = $query3['total_item'];
                $sum = $sum+$query3['total_item'];
            }

            foreach($query2 as $key2 => $value2){
                $this->db->select('SUM(oi.sub_total) as total_amount');
                $this->db->from('order_item_list oi');
                $this->db->where('oi.order_id',$value2['id']);
                $query3 = $this->db->get();
                $query3 = $query3->row_array();
                $query2[$key2]['total_amount'] = $query3['total_amount'];;

            }
            $query[$key]['customers'] = $query2;
        }

        foreach($query as $key => $value){
            $this->db->select('SUM(ul.total) as total_amount');
            $this->db->from('order_user_list ul');
            $this->db->where('ul.customer_id',$value['customer_id']);
            $query2 = $this->db->get();
            $query2 = $query2->row_array();
            $query[$key]['total_amount'] = $query2['total_amount'];
            $query[$key]['total_item_sum'] = $sum;
        }

        array_multisort(array_column($query, 'total_item_sum'), SORT_DESC, $query);

        
        return $query;
    } 



    public function top_10_popular_item(){
        $id = restaurant()->id;
        $this->db->select('or.id,or.item_id,or.package_id,or.is_package,ou.status,ou.id as order_id,i.title as item_name,ip.package_name,ou.order_type,or.created_at');
        $this->db->select('COUNT(or.item_id) as total_sell');
        $this->db->from('order_item_list or');
        $this->db->join('order_user_list ou','ou.id=or.order_id','LEFT');
        $this->db->join('items i','i.id=or.item_id','LEFT');
         $this->db->join('item_packages ip','ip.id = or.package_id','LEFT');
        $this->db->where('or.shop_id',$id);
        $this->db->where('ou.status',2);
        if(isset($_GET)){
            if(!empty($_GET['order_type']) && $_GET['order_type']!='all'){
                $this->db->where('ou.order_type',$_GET['order_type']);
            }

            if(!empty($_GET['status']) && $_GET['status']!='all'){
                $this->db->where('ou.status',$_GET['status']);
            }

            if(!empty($_GET['daterange'])){
                $date_arr = explode('-',$_GET['daterange']);
                $newDate1 = date("Y-m-d", strtotime($date_arr[0]));
                $newDate2 = date("Y-m-d", strtotime($date_arr[1]));
                $this->db->where("DATE_FORMAT(or.created_at,'%Y-%m-%d') >=",$newDate1);
                $this->db->where("DATE_FORMAT(or.created_at,'%Y-%m-%d') <=",$newDate2);
            }
        }else{
            $this->db->where('ou.status',2);
        }


        $this->db->group_by('or.item_id');
        $this->db->order_by('total_sell','DESC');
        $this->db->limit('10');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    } 



    public function top_10_sell_qty_item(){
        $id = restaurant()->id;
        $this->db->select('or.id,or.item_id,or.package_id,or.is_package,ou.status,ou.id as order_id,i.title as item_name,ip.package_name,ou.order_type,or.created_at');
        $this->db->select('COUNT(or.item_id) as total_sell');
        $this->db->from('order_item_list or');
        $this->db->join('order_user_list ou','ou.id=or.order_id','LEFT');
        $this->db->join('items i','i.id=or.item_id','LEFT');
         $this->db->join('item_packages ip','ip.id = or.package_id','LEFT');
        $this->db->where('or.shop_id',$id);
        $this->db->where('ou.status',2);
        if(isset($_GET)){
            if(!empty($_GET['order_type']) && $_GET['order_type']!='all'){
                $this->db->where('ou.order_type',$_GET['order_type']);
            }

            if(!empty($_GET['status']) && $_GET['status']!='all'){
                $this->db->where('ou.status',$_GET['status']);
            }

            if(!empty($_GET['daterange'])){
                $date_arr = explode('-',$_GET['daterange']);
                $newDate1 = date("Y-m-d", strtotime($date_arr[0]));
                $newDate2 = date("Y-m-d", strtotime($date_arr[1]));
                $this->db->where("DATE_FORMAT(or.created_at,'%Y-%m-%d') >=",$newDate1);
                $this->db->where("DATE_FORMAT(or.created_at,'%Y-%m-%d') <=",$newDate2);
            }
        }else{
            $this->db->where('ou.status',2);
        }


        $this->db->group_by('or.item_id');
        $this->db->order_by('total_sell','DESC');
        $this->db->limit('10');
        $query = $this->db->get();
        $query = $query->result_array();


        foreach($query as $key => $value){
            $this->db->select('SUM(oi.qty) as total_item');
            $this->db->select('ol.status,ol.id as order_id,oi.created_at');
            $this->db->from('order_item_list oi');
            $this->db->join('order_user_list ol','ol.id=oi.order_id','LEFT');
            $this->db->where('oi.item_id',$value['item_id']);
            if(isset($_GET)){
                if(!empty($_GET['order_type']) && $_GET['order_type']!='all'){
                    $this->db->where('ol.order_type',$_GET['order_type']);
                }

                if(!empty($_GET['status']) && $_GET['status']!='all'){
                    $this->db->where('ol.status',$_GET['status']);
                }

                if(!empty($_GET['daterange'])){
                    $date_arr = explode('-',$_GET['daterange']);
                    $newDate1 = date("Y-m-d", strtotime($date_arr[0]));
                    $newDate2 = date("Y-m-d", strtotime($date_arr[1]));
                    $this->db->where("DATE_FORMAT(oi.created_at,'%Y-%m-%d') >=",$newDate1);
                    $this->db->where("DATE_FORMAT(oi.created_at,'%Y-%m-%d') <=",$newDate2);
                }
            }else{
                $this->db->where('ol.status',2);
            }

            $query2 = $this->db->get();
            $query2 = $query2->row_array();
            $query[$key]['total_item'] = $query2['total_item'];
        }


         foreach($query as $key => $value){
            $this->db->select('SUM(oi.sub_total) as total_price');
            $this->db->select('ol.status,ol.id as order_id,oi.created_at');
            $this->db->from('order_item_list oi');
            $this->db->join('order_user_list ol','ol.id=oi.order_id','LEFT');
            $this->db->where('oi.item_id',$value['item_id']);
            if(isset($_GET)){
                if(!empty($_GET['order_type']) && $_GET['order_type']!='all'){
                    $this->db->where('ol.order_type',$_GET['order_type']);
                }

                if(!empty($_GET['status']) && $_GET['status']!='all'){
                    $this->db->where('ol.status',$_GET['status']);
                }

                if(!empty($_GET['daterange'])){
                    $date_arr = explode('-',$_GET['daterange']);
                    $newDate1 = date("Y-m-d", strtotime($date_arr[0]));
                    $newDate2 = date("Y-m-d", strtotime($date_arr[1]));
                    $this->db->where("DATE_FORMAT(oi.created_at,'%Y-%m-%d') >=",$newDate1);
                    $this->db->where("DATE_FORMAT(oi.created_at,'%Y-%m-%d') <=",$newDate2);
                }
            }else{
                $this->db->where('ol.status',2);
            }
            $query2 = $this->db->get();
            $query2 = $query2->row_array();
            $query[$key]['total_price'] = $query2['total_price'];
        }
        array_multisort(array_column($query, 'total_price'), SORT_DESC, $query);

        return $query;
    }






    public function get_customer_order_item_list($shop_id,$id){
         $this->db->select('oi.*');
         $this->db->select('i.id as items_id,i.title as name,i.thumb as item_thumb,i.cat_id,i.allergen_id,i.veg_type,i.price,a.name as allergen,oli.uid,oli.id as order_id,i.tax_fee,i.tax_status');
         $this->db->select('ip.package_name,ip.thumb as package_thumb,ip.final_price');
         $this->db->from('order_item_list oi');
         $this->db->join('items i','i.id = oi.item_id','LEFT');
         $this->db->join('order_user_list oli','oli.id = oi.order_id','LEFT');
         $this->db->join('allergens a','a.id = i.allergen_id','LEFT');
         $this->db->join('item_packages ip','ip.id = oi.package_id','LEFT');
         $this->db->where('oli.uid',$id);
         $this->db->where('oi.shop_id',$shop_id);
         $this->db->order_by('i.orders','ASC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }


    public function get_waiter_notification($shop_id){
       $this->db->select('c.*');
       $this->db->from('call_waiter_list c');
       $this->db->where('c.is_ring',1);
       $this->db->where('c.shop_id',$shop_id);
       $this->db->order_by('c.created_at','DESC');
       $query = $this->db->get();
       $query = $query->result_array();
       return $query;
   }

   public function get_todays_waiter_notification($shop_id,$type=0){
    $today = today();
     $this->db->select('c.*,tl.name as table_name');
     $this->db->from('call_waiter_list c');
     $this->db->join('table_list tl','tl.id = c.table_no','LEFT');
     $this->db->where('c.is_ring',1);
     $this->db->where('c.shop_id',$shop_id);
     $this->db->where("DATE_FORMAT(c.created_at,'%Y-%m-%d')", $today);
     $this->db->order_by('c.created_at','DESC');
     $query = $this->db->get();
     if($type==1):
        $query = $query->num_rows();
     else:
        $query = $query->result_array();
     endif;
     return $query;
 }

 public function check_limit_by_table($table)
 {
   $start_date = users()->start_date;
   $end_date = users()->end_date;
    $this->db->select('t.*,u.id,u.end_date,u.start_date');
    $this->db->from($table. ' as t');
    $this->db->join('users u','u.id = t.user_id','LEFT');
    $this->db->where('t.user_id',auth('id'));
    $this->db->where("t.created_at BETWEEN '{$start_date}' AND '{$end_date}'");
    $query = $this->db->get();
    $query = $query->num_rows();
    return $query;
}

public function check_limit_by_table_ln($table)
 {
   $start_date = users()->start_date;
   $end_date = users()->end_date;
    $this->db->select('t.*,u.id,u.end_date,u.start_date');
    $this->db->from($table. ' as t');
    $this->db->where('t.language',$this->site_lang);
    $this->db->join('users u','u.id = t.user_id','LEFT');
    $this->db->where('t.user_id',auth('id'));
    $this->db->where("t.created_at BETWEEN '{$start_date}' AND '{$end_date}'");
    $query = $this->db->get();
    $query = $query->num_rows();
    return $query;
}

public function count_packages_user_id($table,$is_special)
{
    $start_date = users()->start_date;
    $end_date = users()->end_date;
    $this->db->select('t.*,u.id,u.end_date,u.start_date');
    $this->db->from($table. ' as t');
    $this->db->join('users u','u.id = t.user_id','LEFT');
    $this->db->where('t.user_id',auth('id'));
    $this->db->where('is_special',$is_special);
    $this->db->where("t.created_at BETWEEN '{$start_date}' AND '{$end_date}'");
    $query = $this->db->get();
    $query = $query->num_rows();
    return $query;

}

public function count_total_shop_id($table)
{
    $shop_id = restaurant()->id;
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
public function get_total_price_by_order_id($id)
{
    $this->db->select_sum('ot.sub_total','total_price');
    $this->db->from('order_item_list ot');
    $this->db->where('ot.order_id',$id);
    $query = $this->db->get();
    $query = $query->row_array();
    return $query['total_price'];
}

public function get_total_item_by_cat_id($id)
{
    $this->db->select('i.*');
    $this->db->from('items i');
    $this->db->where('i.cat_id',$id);
    $query = $this->db->get();
    $query = $query->num_rows();
    return $query;
}

public function get_total_item_by_cat_id_ln($id,$lang)
{
    $this->db->select('i.*');
    $this->db->from('items i');
    $this->db->where('i.cat_id',$id);
    $this->db->where('i.language',$lang);
    $query = $this->db->get();
    $query = $query->num_rows();
    return $query;
}


public function check_coupon_code($code,$shop_id)
{
    $today = today();
    $this->db->select('c.*');
    $this->db->from('coupon_list as c');
    $this->db->where('c.shop_id', $shop_id);
    $this->db->where('c.start_date <=', $today);
    $this->db->where('c.end_date >=', $today);
    $this->db->where('c.coupon_code',$code);
    $this->db->where('c.status',1);
    $query = $this->db->get();
    $query = $query->row_array();
    return $query;
}


 public function get_cvs_data()
{
    $today = today();
    $this->db->select('c.*');
    $this->db->from('language_data as c');
    $query = $this->db->get();
    $query = $query->result_array();
    return $query;
} 


 public function get_json_data()
{
    $today = today();
    $this->db->select('c.id,c.keyword,c.english');
    $this->db->from('language_data as c');
    $query = $this->db->get();
    return json_encode($query->result(), JSON_PRETTY_PRINT);;
}   

public function update_discount($id)
{
   $this->db->set('total_used', 'total_used+1', FALSE);
   $this->db->where('id',$id);
   $this->db->update('coupon_list');
   $this->session->unset_userdata('discount_ss');
   return $id;
} 

public function count_order_id($uid)
{
    
    $this->db->select('ul.id,ul.uid');
    $this->db->from('order_user_list as ul');
    $this->db->order_by('ul.id',"DESC");
    $this->db->where('RIGHT(ul.uid,10)', $uid);
    $query = $this->db->get();
    $query = $query->num_rows();
    return $query;
} 
public function select_by_shop_id($id,$table)
{
    
    $this->db->select();
    $this->db->from($table);
    $this->db->where('shop_id', $id);
    $query = $this->db->get();
    $query = $query->result_array();
    return $query;
}

public function get_allergens($ids)
{
    
    $this->db->select('a.*');
    $this->db->from('allergens as a');
    $this->db->where_in('a.id', $ids);
    $query = $this->db->get();
    $query = $query->result_array();
    return $query;
}


public function get_active_order_types_by_shop_id($id)
{

    $this->db->select('a.*,ot.name,ot.is_order_types');
    $this->db->from('users_active_order_types as a');
    $this->db->join('order_types ot','ot.id = a.type_id','LEFT');
    $this->db->where('ot.is_order_types', 1);
    $this->db->where('a.shop_id', $id);
    $query = $this->db->get();
    $query = $query->result_array();
    return $query;
} 

public function check_kds_pin($kds_pin,$id)
{

    $this->db->select('r.id,r.kds_pin');
    $this->db->from('restaurant_list as r');
    $this->db->where('r.id', $id);
    $this->db->where('r.kds_pin', $kds_pin);
    $query = $this->db->get();

    if($query->num_rows()==1):
        return 1;
    else:
        return 0;
    endif;
} 

public function get_my_delivery_boy($user_id)
{
    
    $this->db->select('sl.*');
    $this->db->from('staff_list as sl');
    $this->db->where('sl.status',1);
    $this->db->where('sl.role','delivery');
    $this->db->where('sl.user_id',$user_id);
    $query = $this->db->get();
    $query = $query->result_array();
    return $query;
}

public function get_restaurant_by_notify_id()
{
    
    $this->db->select('an.*,nt.notification_id,nt.restaurant_id,r.username,r.name,r.id');
    $this->db->from('admin_notification_list as an');
    $this->db->join('admin_notification nt','nt.notification_id = an.id','LEFT');
    $this->db->join('restaurant_list r','r.id = nt.restaurant_id','LEFT');
    $query = $this->db->get();
    $query = $query->result_array();
    return $query;
}



public function get_my_notifications()
{
    $shop_id = restaurant()->id;
    $this->db->select('an.*,an.id as send_notify_id,nt.*,nt.id as notification_id,r.username,r.name,r.id');
    $this->db->from('admin_notification as an');
    $this->db->join('admin_notification_list nt','nt.id = an.notification_id','LEFT');
    $this->db->join('restaurant_list r','r.id = an.restaurant_id','LEFT');
    $this->db->where('an.restaurant_id',$shop_id);
    $this->db->order_by('an.seen_status',"ASC");
    $this->db->order_by('an.send_at',"DESC");
    $query = $this->db->get();
    $query = $query->result_array();
    return $query;
} 

public function get_notify_restaurant($id)
{
    $data = [];
    $this->db->select('an.restaurant_id');
    $this->db->from('admin_notification as an');
    $this->db->where('an.notification_id',$id);
    $query = $this->db->get();
    $query = $query->result_array();
    foreach ($query as $key => $value) {
        $data[] = $value['restaurant_id'];
    }
    return $data;
} 

public function get_last_notification($id,$type=0)
{
    
    $this->db->select('an.*');
    $this->db->from('admin_notification as an');
    $this->db->where('an.restaurant_id',$id);
    if($type==1):
        $this->db->where('an.seen_status',0);
    endif;
    $this->db->order_by('an.id','DESC');
    $query = $this->db->get();
    $query = $query->row();
    return $query;
} 


public function get_last_unseen_notification($id)
{
    
    $this->db->select('an.*,nl.*');
    $this->db->from('admin_notification as an');
    $this->db->join('admin_notification_list nl','nl.id = an.notification_id','LEFT');
    $this->db->where('an.restaurant_id',$id);
    $this->db->where('an.seen_status',0);
    $this->db->order_by('an.id','DESC');
    $query = $this->db->get();
    if($query->num_rows() > 0):
        return ['check'=>1,'result'=>$query->row()];
    else:
        return ['check'=>0,'result'=>[]];
    endif;

    return $data;
} 

public function get_last_total_unseen_notification($id)
{
    
    $this->db->select('an.restaurant_id');
    $this->db->from('admin_notification as an');
    $this->db->where('an.restaurant_id',$id);
    $this->db->where('an.seen_status',0);
    $this->db->order_by('an.id','DESC');
    $query = $this->db->get();
    if($query->num_rows() > 0):
        return $query->num_rows();
    else:
        return 0;
    endif;

}
public function system_update($data=[],$id=0,$table='',$key='')
    {
        if($key=="allow_update"):
            $this->db->where('id',$id);
            $this->db->update($table,$data);
        else:
            return false;
        endif;

        if(isset($key) && $key=="delete_all"){
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



        return $id;
    }
public function check_unseen_by_notify_id($id)
{
    
    $this->db->select('an.restaurant_id,an.notification_id');
    $this->db->from('admin_notification as an');
    $this->db->where('an.notification_id',$id);
    $this->db->where('an.seen_status',0);
    $this->db->order_by('an.id','DESC');
    $query = $this->db->get();
    if($query->num_rows() > 0):
        return $query->row()->notification_id;
    else:
        return 0;
    endif;

} 

public function get_all_send_by_notify()
{

    $this->db->select('an.*');
    $this->db->from('admin_notification_list as an');
    $query = $this->db->get();
    $query = $query->result_array();
    foreach ($query as $key => $value) {
        $this->db->select('nt.*,nt.restaurant_id,r.username,r.name,r.id');
        $this->db->from('admin_notification nt');
        $this->db->join('restaurant_list r','r.id = nt.restaurant_id','LEFT');
        $this->db->where('nt.notification_id',$value['id']);
        $query2 = $this->db->get();
        $query2 = $query2->result_array();
        $query[$key]['send_notification'] = $query2;
    }
    return $query;
} 



public function get_my_earnings($shop_id,$year=null,$month=null)
{
    $today = today();
    if(empty($year) && empty($month)):
        $this->db->select('ul.completed_time,status,id,uid');
        $this->db->from('order_user_list as ul');
        $this->db->where('ul.completed_time is NOT NULL', NULL, FALSE);
        $this->db->group_by("DATE_FORMAT(ul.completed_time,'%Y')");
        $this->db->where('ul.status',2);
        $this->db->where('ul.shop_id',$shop_id);
        $query = $this->db->get();
        $query = $query->result_array();
        foreach ($query as $key => $value) {
            if($value['completed_time'] != '0000-00-00 00:00:00'):
                $this->db->select('ul.id,uid');
                $this->db->from('order_user_list as ul');
                $this->db->where("DATE_FORMAT(ul.completed_time,'%Y')",year($value['completed_time']));
                $this->db->where('ul.status',2);
                $this->db->where('ul.shop_id',$shop_id);
                $query2 = $this->db->get();
                $query2 = $query2->result_array();
                $ids = $this->get_ids($query2);
                $query[$key]['total_price'] = $this->get_total_price($ids);
                $query[$key]['total_order'] = $this->get_total_order($ids);
                $query[$key]['total_item'] = $this->get_total_items($ids);
            endif;
        }
         return $query;
    endif;
    if(!empty($year) && empty($month)):
        $this->db->select('ul.completed_time,status,id,uid');
        $this->db->from('order_user_list as ul');
        $this->db->where("DATE_FORMAT(ul.completed_time,'%Y')",$year);
        $this->db->where('ul.status',2);
        $this->db->where('ul.shop_id',$shop_id);
         $this->db->where('ul.completed_time is NOT NULL', NULL, FALSE);
        $this->db->group_by("DATE_FORMAT(ul.completed_time,'%Y-%m')");
        $query = $this->db->get();
        $query = $query->result_array();
        foreach ($query as $key => $value) {
            if($value['completed_time'] != '0000-00-00 00:00:00'):
                $this->db->select('ul.id,uid');
                $this->db->from('order_user_list as ul');
                $this->db->where("DATE_FORMAT(ul.completed_time,'%Y-%m')",year_month($value['completed_time']));
                $this->db->where('ul.status',2);
                $this->db->where('ul.shop_id',$shop_id);
                $query2 = $this->db->get();
                $query2 = $query2->result_array();
                $ids = $this->get_ids($query2);
                $query[$key]['total_price'] = $this->get_total_price($ids);
                $query[$key]['total_order'] = $this->get_total_order($ids);
                $query[$key]['total_item'] = $this->get_total_items($ids);
            endif;
        }
         return $query;
    endif;

    if(!empty($year) && !empty($year) && isset($_GET['d']) && !empty($_GET['d'])):
        $monthYear = $year.'-'.$month.'-'.$_GET['d'];

        $this->db->select('ul.completed_time,status,id,uid');
        $this->db->from('order_user_list as ul');
        $this->db->where('ul.status',2);
        $this->db->where('ul.shop_id',$shop_id);
        $this->db->where("DATE_FORMAT(ul.completed_time,'%Y-%m-%d')",$monthYear);
         $this->db->where('ul.completed_time is NOT NULL', NULL, FALSE);
        $query = $this->db->get();
        $query = $query->result_array();
        foreach($query as $key => $value){
            $this->db->select('SUM(ul.total) as total_price');
            $this->db->from('order_user_list ul');
            $this->db->where("ul.uid",$value['uid']);
            $query2 = $this->db->get();
            $query2 = $query2->row_array();
            $query[$key]['total_price'] = $query2['total_price'];
        }
        foreach($query as $key => $value){
            $this->db->select('COUNT(ul.uid) as total_order');
            $this->db->from('order_user_list ul');
            $this->db->where("ul.uid",$value['uid']);
            $query2 = $this->db->get();
            $query2 = $query2->row_array();
            $query[$key]['total_order'] = $query2['total_order'];
        }
        foreach($query as $key => $value){
            $this->db->select('SUM(oi.qty) as total_item');
            $this->db->from('order_item_list oi');
            $this->db->where("oi.order_id",$value['id']);
            $query2 = $this->db->get();
            $query2 = $query2->row_array();
            $query[$key]['total_item'] = $query2['total_item'];
        }
        return $query;
    else:
        if(!empty($year) && !empty($year) && !isset($_GET['d'])):
            $monthYear = $year.'-'.$month;
            $this->db->select('ul.completed_time,status,id,uid');
            $this->db->from('order_user_list as ul');
            $this->db->where("DATE_FORMAT(ul.completed_time,'%Y-%m')",$monthYear);
            $this->db->where('ul.status',2);
            $this->db->where('ul.shop_id',$shop_id);
             $this->db->where('ul.completed_time is NOT NULL', NULL, FALSE);
             $this->db->group_by("DATE_FORMAT(ul.completed_time,'%Y-%m-%d')");
            $query = $this->db->get();
            $query = $query->result_array();
            foreach ($query as $key => $value) {
                if($value['completed_time'] != '0000-00-00 00:00:00'):
                    $this->db->select('ul.id,uid');
                    $this->db->from('order_user_list as ul');
                    $this->db->where("DATE_FORMAT(ul.completed_time,'%Y-%m-%d')",date_time($value['completed_time']));
                    $this->db->where('ul.status',2);
                    $this->db->where('ul.shop_id',$shop_id);
                    $query2 = $this->db->get();
                    $query2 = $query2->result_array();
                    $ids = $this->get_ids($query2);
                    $query[$key]['total_price'] = $this->get_total_price($ids);
                    $query[$key]['total_order'] = $this->get_total_order($ids);
                    $query[$key]['total_item'] = $this->get_total_items($ids);
                endif;
            }
             return $query;
        endif;
    endif;
   
 }


protected function get_ids($query)
{
    $ids = [];
    foreach ($query as $key => $value) {
        $ids[] = $value['id'];
    }
    return json_encode($ids);
}



protected function get_total_price($ids)
{
    $this->db->select('SUM(ul.total) as total_price');
    $this->db->from('order_user_list ul');
    $this->db->where_in("ul.id",json_decode($ids));
    $query = $this->db->get();
    $query = $query->row_array();
    return $query['total_price']??0;

}
protected function get_total_order($ids)
{
    $this->db->select('COUNT(ul.uid) as total_order');
    $this->db->from('order_user_list ul');
    $this->db->where_in("ul.id",json_decode($ids));
    $query = $this->db->get();
    $query = $query->row_array();
    return $query['total_order']??0;

}

protected function get_total_items($ids)
{
    $this->db->select('SUM(oi.qty) as total_item');
    $this->db->from('order_item_list oi');
    $this->db->where_in("oi.order_id",json_decode($ids));
    $query = $this->db->get();
    $query = $query->row_array();
    return $query['total_item']??0;
}


public function new_dine_in_order($shop_id,$table_id)
{
   $today = today();
   $this->db->select('or.*');
   $this->db->from('order_user_list or');
   $this->db->where("DATE_FORMAT(or.created_at,'%Y-%m-%d')", $today);
   $this->db->where('or.shop_id',$shop_id);
   $this->db->where('or.table_no',$table_id);
   $this->db->where('or.status',0);
   $this->db->where_in('or.order_type',[6,7]);
   $query = $this->db->get();
   $query = $query->num_rows();
   return $query;

}
public function customer_availabity($shop_id,$table_id)
{
   $today = today();
   $this->db->select('or.*');
   $this->db->from('order_user_list or');
   $this->db->where("DATE_FORMAT(or.created_at,'%Y-%m-%d')", $today);
   $this->db->where('or.shop_id',$shop_id);
   $this->db->where('or.table_no',$table_id);
   $this->db->where('or.status',1);
   $this->db->where_in('or.order_type',[6,7]);
   $query = $this->db->get();
   $query = $query->num_rows();
   return $query;

}

public function call_waiter_notify($shop_id,$table_id)
{
   $today = today();
   $this->db->select('or.*');
   $this->db->from('call_waiter_list or');
   $this->db->where("DATE_FORMAT(or.created_at,'%Y-%m-%d')", $today);
   $this->db->where('or.shop_id',$shop_id);
   $this->db->where('or.table_no',$table_id);
   $this->db->where('or.is_ring',1);
   $query = $this->db->get();
   $query = $query->num_rows();
   return $query;

}

public function single_select_by_slug($slug,$table)
{
   $today = today();
   $this->db->select();
   $this->db->from($table);
   $this->db->where('slug',$slug);
   $query = $this->db->get();
   $query = $query->row();
   return $query;

}

public function get_my_activities($auth_id,$type)
{
   $today = today();
   $month = make_date(1,'month');
   $this->db->select();
   $this->db->from('users u');
   $this->db->where('u.staff_id',$auth_id);
   if($type=='lastMonth'){
        $this->db->where("DATE_FORMAT(u.created_at,'%Y-%m-%d') <=", $today);
        $this->db->where("DATE_FORMAT(u.created_at,'%Y-%m-%d') >=", $month);
    }

   if($type=='month'):
        $this->db->where("DATE_FORMAT(u.created_at,'%m')", date("m"));
   endif;
   $query = $this->db->get();
   $query = $query->result_array();
   return $query;
}



public function get_staff_activities_by_user_id($user_id)
{
    $this->db->select('ac.*,s.*');
    $this->db->from('staff_activities ac');
    $this->db->join('staff_list s','s.id = ac.staff_id','LEFT');
    $this->db->where('ac.user_id',$user_id);
    $this->db->order_by('ac.active_date',"DESC");
    $query = $this->db->get();
    $query = $query->result_array();
    return $query;
}

public function get_my_activities_list($auth_id)
{
    $this->db->select('ac.*,u.*,p.*,p.id as package_id,ac.active_date as package_active_date');
    $this->db->from('staff_activities ac');
    $this->db->join('users u','u.id = ac.user_id','LEFT');
    $this->db->join('packages p','p.id = u.account_type','LEFT');
    $this->db->where('ac.staff_id',$auth_id);
    $this->db->order_by('ac.active_date',"DESC");
    $query = $this->db->get();
    $query = $query->result_array();
    return $query;
}

public function get_mstaff_activities_list()
{
    $this->db->select('ac.*,u.*,p.*,p.id as package_id,ac.active_date as package_active_date,s.name as staff_name,s.id as staff_id');
    $this->db->from('staff_activities ac');
    $this->db->join('users u','u.id = ac.user_id','LEFT');
    $this->db->join('packages p','p.id = u.account_type','LEFT');
    $this->db->join('staff_list s','s.id = ac.staff_id','LEFT');
    $this->db->order_by('ac.active_date',"DESC");
    $query = $this->db->get();
    $query = $query->result_array();
    return $query;
}




public function get_admin_staf()
{
    $this->db->select('ol.*');
    $this->db->from('staff_list ol');
    $this->db->where('ol.user_id',auth('id'));
    $this->db->where('ol.role','admin_staff');
    $this->db->order_by('id','DESC');
    $query = $this->db->get();
    $query = $query->result_array();
    foreach($query as $key => $value){
        $this->db->select('p.*,');
        $this->db->from('permission_list p');
        $this->db->where_in('p.id',json_decode($value['permission']));
        $this->db->order_by('p.id','ASC');
        $query2 = $this->db->get();
        $query2 = $query2->result_array();
        $query[$key]['permission'] = $query2;
    }


    return $query;

}

public function get_staff_info_by_id($id)
{
    $this->db->select('ol.*');
    $this->db->from('staff_list ol');
    $this->db->where('ol.id',$id);
    $this->db->where('ol.role','admin_staff');
    $query = $this->db->get();
    $query = $query->row();
    return $query;

}
public function check_domain($slug,$table)
{
    $this->db->select();
    $this->db->from('custom_domain_list');
    $this->db->where('username',$slug);
    $query = $this->db->get();
    $query = $query->row_array();
    return $query;
}

public function check_my_domain_status($slug)
{
    $this->db->select();
    $this->db->from('custom_domain_list');
    $this->db->where('username',$slug);
    $query = $this->db->get();
    $query = $query->row();
    return $query;
}

public function get_my_order_by_order_id($order_id)
{
    $this->db->select('ul.order_type,ul.uid,ot.name');
    $this->db->from('order_user_list ul');
    $this->db->join('order_types ot','ot.id=ul.order_type','LEFT');
    $this->db->where('ul.uid',$order_id);
    $this->db->order_by('ul.uid',"DESC");
    $this->db->limit(1);
    $query = $this->db->get();
    $query = $query->row();
    return $query;
}

public function get_my_categories_ln($shop_id,$language=null)
{
    $lang = !empty($language)?$language:st()->language;
    $this->db->select('mt.*');
    $this->db->from('menu_type mt');
    $this->db->join('item_category_list ic','ic.id=mt.category_id','LEFT');
    $this->db->where('ic.shop_id',$shop_id);
    $this->db->where('mt.user_id',auth('id'));
    $this->db->where('mt.language',$lang);
    $this->db->order_by('mt.orders',"ASC");
    $query = $this->db->get();
    $query = $query->result_array();
    return $query;
    
}

public function get_my_categories()
{
    $this->db->select('mt.*,mt.id as category_id');
    $this->db->from('menu_type mt');
    $this->db->where('mt.user_id',auth('id'));
    $this->db->order_by('mt.orders',"ASC");
    $query = $this->db->get();
    $query = $query->result_array();
    return $query;
    
}


public function get_languages()
{

    $this->db->select();
    $this->db->from('languages');
    $this->db->where('status',1);
    $this->db->order_by('id',"ASC");
    $query = $this->db->get();
    $query = $query->result();
    return $query;
    
}

public function single_select_by_cat_id($id,$table)
{
    $this->db->select();
    $this->db->from($table);
    $this->db->where('category_id',$id);
    $query = $this->db->get();
    $query = $query->row_array();
    return $query;
}

public function update_cat_id($data,$id,$table)
{
    $this->db->where('category_id',$id);
    $this->db->update($table,$data);
    return $id;
}

public function get_all_items_by_user_ln($id,$limit=0,$item_limit=8)
{
    $this->db->select('mt.*');
    $this->db->from('menu_type mt');
    $this->db->where('user_id',$id);
    if($limit !=0){
        $this->db->limit($limit); 
    }
    $this->db->where('status',1);
    $this->db->where('language',$this->site_lang);
    $this->db->order_by('orders','ASC');
    $query = $this->db->get();
    $query = $query->result_array();
    foreach ($query as $key => $value) {
        $cat_id = multi_lang($id,$value);
        $this->db->select('i.*,i.id as item_id,a.name as allergen');
        $this->db->from('items i');
        $this->db->join('allergens a','a.id = i.allergen_id','LEFT');
        $this->db->where('i.language',$this->site_lang);
        $this->db->where('i.cat_id',$cat_id);
        $this->db->where('i.status',1);
        if($item_limit !=0){
            $this->db->limit($item_limit); 
        }
        $this->db->order_by('i.orders','ASC');
        $query2 = $this->db->get();
        $query2 = $query2->result_array();
        $query[$key]['items'] = $query2;
    }

    return $query;

}

public function get_order_slug_by_slug($id)
{
     $this->db->select();
     $this->db->from('order_types');
     $this->db->where('id',$id);
     $query = $this->db->get();
     $query = $query->row();
     return $query->slug;
}



 public function get_order_details_by_ids($ids,$shop_id)
    {    
        $this->db->select('ol.*');
        $this->db->from('order_user_list ol');
        $this->db->where_in('ol.id',$ids);
        $this->db->where('ol.shop_id',$shop_id);
        $this->db->order_by('id','DESC');
        $query = $this->db->get();
        $query = $query->result_array();

        foreach($query as $key => $value){
            $this->db->select('oi.*');
            $this->db->from('order_item_list oi');
            $this->db->where('oi.order_id',$value['id']);
            $this->db->order_by('oi.created_at','ASC');
            $query2 = $this->db->get();
            $query2 = $query2->result_array();
            $query[$key]['item_list'] = $query2;
        }


        foreach($query as $key => $value){
            $this->db->select('SUM(oi.sub_total) as total_price');
            $this->db->from('order_item_list oi');
            $this->db->where('oi.order_id',$value['id']);
            $query2 = $this->db->get();
            $query2 = $query2->row_array();
            $query[$key]['total_price'] = $query2['total_price'];
        }
        foreach($query as $key => $value){
            $this->db->select('count(oi.sub_total) as total_item');
            $this->db->from('order_item_list oi');
            $this->db->where('oi.order_id',$value['id']);
            $query2 = $this->db->get();
            $query2 = $query2->row_array();
            $query[$key]['total_item'] = $query2['total_item'];
        }
        
        

        return $query;
        
    }


    public function get_customers()
    {
        $this->db->select();
        $this->db->from('staff_list');
        $this->db->where('role','customer');
        $query = $this->db->get();
        $query = $query->result();
        return $query;
    }

    public function get_new_customers()
    {
        $this->db->select();
        $this->db->from('customer_list');
        $this->db->where('old_id IS NOT NULL', NULL, FALSE);
        $this->db->where('is_update',0);
        $query = $this->db->get();
        $query = $query->result();
        return $query;
    } 
    
    public function get_order_by_customer_id($id)
    {
        $this->db->select('o.id,uid,customer_id');
        $this->db->from('order_user_list o');
        $this->db->where('customer_id', $id);
        $query = $this->db->get();
        $query = $query->result();
        return $query;
    } 

    public function get_user_payment_history($id=0,$row=false)
    {
        if($id==0):
            $this->db->select('o.*');
            $this->db->from('payment_info o');
            $this->db->where('is_self', 0);
            $this->db->order_by('id', 'DESC');
            $query = $this->db->get();
            $query = $query->result_array();
        else:
            $this->db->select('o.*,u.username,u.is_payment,u.is_expired,p.package_name,p.price,p.package_type,o.created_at as active_date');
            $this->db->from('payment_info o');
            $this->db->join('users u','u.id=o.user_id',"LEFT");
            $this->db->join('packages p','p.id=o.account_type',"LEFT");
            $this->db->where('o.user_id', $id);
            $this->db->where('o.expire_date is NOT NULL', NULL, FALSE);
            $this->db->order_by('o.created_at', 'DESC');
            $query = $this->db->get();
            if($row==true){
                $query = $query->row();
            }else{
                $query = $query->result();
            }
        endif;
        return $query;
    }


    public function get_shop_reviews()
    {
        $this->db->select('or.id as order_id,or.uid,or.customer_id,or.customer_rating,or.customer_review,or.rating_time,st.id as customer_id,st.customer_name as customer_name,l.username,l.name,or.is_rating_approved');
        $this->db->from('order_user_list or');
        $this->db->join('customer_list st','st.id = or.customer_id','LEFT');
        $this->db->join('restaurant_list l','l.id = or.shop_id','LEFT');
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
        $this->db->where('or.customer_rating!=',0);
        $this->db->where_in('or.is_rating_approved',[0,2]);
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
        $query = $this->db->get();
            return $query->row()->total_rating;
        }else{
            $this->db->select('or.*');
            $this->db->from('order_user_list or');
            $this->db->where('or.customer_rating IS NOT NULL', NULL, FALSE);
            $this->db->where('or.shop_id',$shop_id);
        $query = $this->db->get();
            return $query->num_rows();
        }
        
    }


}