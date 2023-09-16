<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Default_m extends CI_Model {
		public function __construct(){
			// parent::__construct();
			$this->db->query("SET sql_mode = ''");
		}

		public function add_payment($u_info=[],$package_info=[],$payment_type='')
		{
			$this->admin_m->update_by_user_id(['is_running'=>0],$u_info['user_id'],'payment_info');
			$random_number = random_string('alnum',16);
			$data = array(
                'user_id' => $u_info['user_id'],
                'account_type' => $package_info['id'],
                'price' => $package_info['price'],
                'txn_id' => $random_number,
                'payment_type' => !empty($payment_type)?$payment_type:0,
                'currency_code' => get_currency('currency_code'),
                'status' => 'Completed',
                'created_at' => d_time(),
                'expire_date' => add_year($package_info['package_type']),
                'is_running' => 1,
            );
            $insert = $this->admin_m->insert($data,'payment_info');

            return $insert;
		}

		public function single_select_by_id($id,$table)
		{
			$this->db->select();
			$this->db->from($table);
			$this->db->where('id',$id);
			$query = $this->db->get();
			return $query->row_array();
		}

		public function single_select_by_row_id($id,$table)
		{
			$this->db->select();
			$this->db->from($table);
			$this->db->where('id',$id);
			$query = $this->db->get();
			return $query->row();
		}

		public function update($data,$id,$table)
		{
			$this->db->where('id',$id);
			$this->db->update($table,$data);
			return $id;
		}



		public function delete($id,$table)
		{
			$this->db->delete($table,array('id'=>$id));
			return $id;
		}


		public function insert($data,$table)
		{
			$this->db->insert($table,$data);
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

		public function select_row($table)
		{
			$this->db->select();
			$this->db->from($table);
			$query = $this->db->get();
			$query = $query->result();
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

		public function update_by_type($data,$id,$type,$table)
		{
			$this->db->where($type,$id);
			$this->db->update($table,$data);
			return $id;
		}

		public function update_by_user_id($data,$user_id,$table)
		{
			$this->db->where('user_id',$user_id);
			$this->db->update($table,$data);
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

		public function insert_all($data,$table) {
        // Insert order items
			$insert = $this->db->insert_batch($table, $data);

        // Return the status
			return $insert?true:false;
		}

		function delete_by_auth_id($id,$table)
		{
			$this->db->where('user_id',auth('id'));
			$this->db->delete($table,array('id'=>$id));
			return $id;
		}


		public function select_all_by_user($id,$table,$limit)
		{
			$this->db->select();
			$this->db->from($table);
			$this->db->where('user_id',$id);
			$this->db->where('status',1);
			$this->db->order_by('id','ASC');
			if($limit !=0){
				$this->db->limit($limit);
			}
			$query = $this->db->get();
			$query = $query->result_array();
			return $query;
		}

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


		public function get_settings()
		{
			$this->db->select();
			$this->db->from('settings');
			$query = $this->db->get();
			$query = $query->row_array();
			return $query;
		} 

		public function settings(){
	        $this->db->select();
	        $this->db->from('settings');
	        $query = $this->db->get();
	        return $query->row();
	    }

	    
	    public function get_user_info()
	    {
	    	$this->db->select('u.*');
	    	$this->db->from('users as u');
	    	$this->db->where('u.id',auth('id'));
	    	$query = $this->db->get();
	    	$query = $query->row_array();
	    	return $query;
	    }

	    public function get_all_users()
	    {
	    	$this->db->select('u.*,u.id as user_id');
	    	$this->db->select('sl.*,sl.id as sl_id');
	    	$this->db->select('pl.*,pl.id as package_id');
	    	$this->db->from('users as u');
	    	$this->db->join('subscription_list as sl','sl.user_id=u.id','left');
	    	$this->db->join('package_list as pl','pl.id=sl.package_id','left');
	    	$this->db->where('u.user_role','user');
	    	$query = $this->db->get();
	    	$query = $query->result_array();
	    	return $query;
	    }

	    public function user()
	    {
	    	$this->db->select('u.*,u.id as user_id');
	    	$this->db->select('sl.*,sl.id as sl_id');
	    	$this->db->select('pl.*,pl.id as package_id');
	    	$this->db->from('users as u');
	    	$this->db->join('subscription_list as sl','sl.user_id=u.id','left');
	    	$this->db->join('package_list as pl','pl.id=sl.package_id','left');
	    	$this->db->where('u.id',auth('id'));
	    	$this->db->where('u.user_role','user');
	    	$query = $this->db->get();
	    	$query = $query->row();
	    	return $query;
	    }

	    public function users()
	    {
	    	$this->db->select('u.*');
	    	$this->db->from('users as u');
	    	$this->db->where('u.id',auth('id'));
	    	$query = $this->db->get();
	    	$query = $query->row();
	    	return $query;
	    }

	    public function single_select($table)
	    {
	    	$this->db->select();
	    	$this->db->from($table);
	    	$query = $this->db->get();
	    	$query = $query->row_array();
	    	return $query;
	    }
	    public function single_select_row($table)
	    {
	    	$this->db->select();
	    	$this->db->from($table);
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

		public function verify_password($password,$vpassword) {
			if (md5($password)== $vpassword) {
				return TRUE;
			} else {
				return FALSE;
			}
		}



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
						return $result;
					} else {
						return 0;
					}
				}
			}else{
				return 0;
			}

		}
			

}
