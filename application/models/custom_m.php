<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Custom_m extends CI_Model {
	public function __construct(){
		// parent::__construct();
		$this->db->query("SET sql_mode = ''");
	}

public function insert_features($user_id){
	$fetaures = $this->default_m->select('feature_list');
	$check_feature = $this->default_m->select_all_by_user_id($user_id,'subscribe_features');

	if(count($check_feature) == 0){
		foreach ($fetaures as $key => $row) {
			$data =  array(
				'feature_id' => $row['id'],
				'user_id' => $user_id,
				'status' => 1,
				'created_at' => d_time(),
			);
			$this->default_m->insert($data,'subscribe_features');
		}

	}elseif(count($check_feature) == count($fetaures)){
		return true;
	}elseif(count($check_feature) < count($fetaures)){
		
		foreach ($fetaures as $key => $row) {
			$feature_id = $this->admin_m->get_users_active_features($row['id'],$user_id);
			
			if($feature_id['feature_id']!=$row['id']){
				$data =  array(
					'feature_id' => $row['id'],
					'user_id' => $user_id,
					'status' => 1,
					'created_at' => d_time(),
				);
				$this->default_m->insert($data,'subscribe_features');
			}
			
		}
	}
	
	return true;
}
	

}
