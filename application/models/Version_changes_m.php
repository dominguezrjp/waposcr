<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Version_changes_m extends CI_Model {
	public function __construct(){
		// parent::__construct();
		$this->db->query("SET sql_mode = ''");
		$this->load->model('Updated_queries','up_m');
		$this->load->dbforge();
		$this->config->load('config');
	}

	/*----------------------------------------------
	  IF Update Available, First verify the purchase code
	----------------------------------------------*/

	public function verify_purchase_code($purchase_code){
		$form_data = [
			'purchase_code' => $purchase_code,
			'site_url' => SITE_URL,
			'author' => AUTHOR,
			'is_localhost' => $this->isLocalHost(),
			'ip' => $this->getIpAddress(),
		];

		$form_data = json_encode($form_data);
		$ch = curl_init(URL."verify-purchase");  
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $form_data); 

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		curl_setopt($ch, CURLOPT_POST, 1);                                          
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			$error_msg = curl_error($ch);
			echo "<pre>";print_r($error_msg);exit();
		}

		curl_close($ch);
		$result = @json_decode($result);

		if(isset($result->st) && $result->st==1):
			$this->check_files();
			return ['st'=>1, 'msg' =>''];
		else:
			return ['st'=>0,'msg'=>$result->msg];
		endif;
	}







	/*----------------------------------------------
	  				FROM MY_CONTROLLER
	----------------------------------------------*/
	public function  import_database_changes($purchase_code,$version)
	{
			$data = [];
			$installed = $this->up_m->install_version($version);

			if(isset($installed['st']) && $installed['st']==1):

				if(isset($installed['version']) && $installed['version']==$this->config->item('app_version')):
					$this->createVersion($purchase_code,$installed['version'],settings()['license_code']);
					$this->checkFolders();
				endif;
				
				$data = ['st'=>1,'msg'=> $installed['msg'],'version'=>$installed['version']];
			else:
				$data = ['st'=>0,'msg'=>$installed['msg'],'version'=>$installed['version']];
			endif;
		

		return $data;
	}

	

	public function  checkExistFields($table,$fields)
	{
		if(!$this->db->field_exists($fields, $table)){
			return 1;
		}else{
			return 0;
		}
	}


	

	
	public function createVersion($purchase_code,$app_version,$license_code=''){
		error_reporting(0);
		$version = "<?php \n";
		$version .= "define('VERSION', '". $app_version ."'); \n";
		$version .= "define('SCRIPT_NAME', 'qmenu'); \n";
		$version .= "define('AUTHOR', 'codetrick'); \n";
		$version .= "define('CODECANYON_LICENSE', '".$purchase_code."'); \n";
		$version .= "define('AUTHOR_LICENSE', '".$license_code."'); \n";
		file_put_contents(APPPATH."config/version.php", $version);
		
	}


	public function checkFolders()
	{
		$rootDir = ['big','files','orders_qr','pwa','qr_image','site_banners','site_images','thumb'];
		$mainDir = 'uploads';
		$base = FCPATH;
		 foreach ($rootDir as $key => $dir) {
            $directory = $base.$mainDir.'/'.$dir;
            if (!file_exists($directory)) {
               $create = mkdir($directory, 0777, true);
               echo 'done';
            } else{
              $msg[] = "{$dir} Is Not Writable, Set 777 Permission to: {$mainDir} / {$dir}";
            }

        }

	}

  

    protected function isLocalHost(){
        $localhost = array(
            '127.0.0.1',
            '::1'
        );

        return in_array($_SERVER['REMOTE_ADDR'], $localhost);
    }


/*----------------------------------------------
Features for all user
----------------------------------------------*/
public function insert_features($user_id){
	$fetaures = $this->admin_m->select('features');
	$check_feature = $this->admin_m->select_all_by_user_id($user_id,'users_active_features');

	if(count($check_feature) == 0){
		foreach ($fetaures as $key => $row) {
			$data =  array(
				'feature_id' => $row['id'],
				'user_id' => $user_id,
				'status' => 1
			);
			$this->admin_m->insert($data,'users_active_features');
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
					'status' => 1
				);
				$this->admin_m->insert($data,'users_active_features');
			}
			
		}
	}
	
	return true;
}


/*----------------------------------------------
	Order Types for all users
----------------------------------------------*/

public function add_order_types($user_id){
	$fetaures = $this->admin_m->select_with_status('order_types');
	$check_feature = $this->admin_m->select_all_by_user_id($user_id,'users_active_order_types');
	$shop_id = isset(restaurant($user_id)->id)?restaurant($user_id)->id:0;
	if(count($check_feature) == 0){
		foreach ($fetaures as $key => $row) {
			$data =  array(
				'type_id' => $row['id'],
				'user_id' => $user_id,
				'shop_id' => $shop_id,
				'status' => 1,
				'created_at' => d_time(),

			);
			$this->admin_m->insert($data,'users_active_order_types');
		}

	}elseif(count($check_feature) == count($fetaures)){
		return true;
	}elseif(count($check_feature) < count($fetaures)){
		
		foreach ($fetaures as $key => $row) {
			$feature_id = $this->admin_m->get_users_active_order_types($row['id'],$user_id);
			
			if($feature_id['type_id']!=$row['id']){
				$data =  array(
					'type_id' => $row['id'],
					'user_id' => $user_id,
					'status' => 1,
					'shop_id' => $shop_id,
					'created_at' => d_time(),
				);
				$this->admin_m->insert($data,'users_active_order_types');
			}
			
		}
	}
	
	return true;
}

/*----------------------------------------------
  			QR code For Restaurant	
----------------------------------------------*/
public function qr_code($username,$is_forced=0){

	$check = get_user_info_by_slug($username);
	if(empty($check['qr_link']) || !file_exists($check['qr_link'])):
		$this->createQr($username);
	elseif($is_forced==1):
		$this->createQr($username);
	endif;
	return true;
}

protected function createQr($username){
	$this->load->library('ciqrcode');
	$qr_image=$username.'_'.rand().'.png';
	$params['data'] = url($username);
	$params['level'] = 'H';
	$params['size'] = 8;
	$params['savename'] =FCPATH."uploads/qr_image/".$qr_image;
	if($this->ciqrcode->generate($params))
	{
		$data = array(
			'qr_link' =>'uploads/qr_image/'.$qr_image,
		);
		$update = $this->admin_m->update_by_username($data,$username,'users');
		return true;
	}
}

public function pusher($id,$action_name,$order_id=[]){

	if($action_name!='order_status'){
		$this->input->set_cookie('is_ring', '1', 300);
	}
	
	$push = pusher_config($id);
	$shop_name = shop($id)->username;
	if(isset($push->status) && $push->status==1 && !empty($push->app_id)):
		$options = array(
			'cluster' => $push->cluster,
			'useTLS' => true
		);
		$pusher = new Pusher\Pusher(
			$push->auth_key,
			$push->secret,
			$push->app_id,
			$options
		);

		$data = json_encode(['st'=>1,'action_name'=>$action_name,'order_id'=>$order_id]);
		$pusher->trigger($shop_name, 'notification', $data);
	endif;
}



function getIpAddress() {
        // check for shared internet/ISP IP
	if (!empty($_SERVER['HTTP_CLIENT_IP']) && $this->validateIpAddress($_SERVER['HTTP_CLIENT_IP'])) {
		return $_SERVER['HTTP_CLIENT_IP'];
	}
	
        // check for IPs passing through proxies
	if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // check if multiple IP addresses are passed using comma separator
		$ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
		foreach ($ips as $ip) {
			if ($this->validateIpAddress($ip)) {
				return $ip;
			}
		}
	}
	
        // check for the remote IP address
	if (!empty($_SERVER['REMOTE_ADDR']) && $this->validateIpAddress($_SERVER['REMOTE_ADDR'])) {
		return $_SERVER['REMOTE_ADDR'];
	}
	
        // return default local IP address
	return '127.0.0.1';
}

function validateIpAddress($ip) {
	if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
		return false;
	}
	return true;
}


protected function check_files(){
	$frontendCssPath = 'assets/frontend/css/';
	$frontendCss = ['custom_rtl.css','default.php','fonts.php','frontend.css','print.css','responsive.css','style.css'];

	foreach ($frontendCss as $key => $fcss) {
		if(file_exists($frontendCssPath.$fcss)){
			unlink($frontendCssPath.$fcss);
		}
	}




	$frontendJsPath = 'assets/frontend/js/';
	$frontendjs = ['auth.js','main.js','customer-notify.js'];

	foreach ($frontendjs as $key => $fjs) {
		if(file_exists($frontendJsPath.$fjs)){
			unlink($frontendJsPath.$fjs);
		}
	}


	$backendCssPath = 'assets/admin/';
	$backendCss = ['admin_rtl.css','default.css','default.php','pos.css','style.main.css','kds.js','main.js','notify.js','pos.js'];

	foreach ($backendCss as $key => $bcss) {
		if(file_exists($backendCssPath.$bcss)){
			unlink($backendCssPath.$bcss);
		}
	}

}


}
