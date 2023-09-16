<?php
class Database {


	function check_database($data)
	{
		
			$conn = new mysqli($data['db_hostname'],$data['db_username'],$data['db_password'],$data['db_name']);
			try {
				try {
					mysqli_report(MYSQLI_REPORT_STRICT);
					$db = new \mysqli(
						$data['db_hostname'], 
						$data['db_username'], 
						html_entity_decode($data['db_password'], ENT_QUOTES, 'UTF-8'), 
						$data['db_name'],
					);
					
					if (isset($db->affected_rows)) { 
							$db->close();
							return ['st'=>1,'msg'=> ""];
					}else{  
						return ['st'=>0,'msg'=> "Error: Could not connect to the database please make sure the database server, username and password is correct!"];
					 }
				} catch (mysqli_sql_exception  $e) {
					return ['st'=>0,'msg'=> "Error: Could not connect to the database please make sure the database server, username and password is correct!"];
				}
			} catch(Exception $e) {
				return ['st'=>0,'msg'=> "Error: Could not connect to the database please make sure the database server, username and password is correct!"];
				
			}



	}

	function install($data){
			$conn = new mysqli($data['db_hostname'],$data['db_username'],$data['db_password'],$data['db_name']);
			if(mysqli_connect_errno())
				return false;

			$conn->query("SET sql_mode = ''");

			require_once 'helper.php';

			$sql_file = "../database/database.sql";
			if(file_exists($sql_file)){
				$databse_sql =  file_get_contents($sql_file);
				$res = mysqli_query($conn, "SHOW TABLES");
				if (mysqli_num_rows($res) == 0) {
					$lines = explode("\n", $databse_sql);
					$sql_query = '';
					foreach($lines as $line) {
						if ($line && (substr($line, 0, 2) != '--') && (substr($line, 0, 1) != '#')) {
							$sql_query .= $line;
							if (preg_match('/;\s*$/', $line)) {
								mysqli_query($conn, $sql_query);
								$sql_query = '';
							}
						}
					}
				}
				
			}
			
			
			$form_data = array(
				'site_url' => $data['base_url'],
				'username'  => 'admin',
				'email'  => $data['email'],
				'account_email'  => $_SESSION['account_email'],
				'purchase_code'  => $_SESSION['purchase_code'],
				'db_username'  => $data['db_username'],
				'db_password'  => $data['db_password'],
				'db_name'  => $data['db_name'],
				'script_name'  => SCRIPT_NAME,
				'author'  => AUTHOR,
				'is_localhost'  => isLocalHost(),
				'version'  => VERSION,
				'ip'  => $this->getIpAddress(),
			);

			$form_data = json_encode($form_data);
			$ch = curl_init("https://api.thinkncode.net/install-script");  
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


			if(isset($result->st) && $result->st==0):
				return ['st'=>0, 'msg'=> $result->msg];
				exit();
			endif;

			$user_role =  1;
			$site_id =  $result->site_id;
			
			$current_date = current_date();

			$settings_data = array(
				'supported_until' => $result->supported_until,
				'active_code' => $result->active_code,
				'purchase_code' =>$result->purchase_code,
				'site_url' => $result->site_url,
				'active_key' => $result->active_key,
				'is_update' => 0,
				'license_name' => $result->license_name,
				'site_info' => $result->li,
				'license_code' => $result->li_code,
				'purchase_date' => $result->sold_at,
				'created_at' =>$current_date,
				'site_id' =>$site_id,
				'version' => $result->version,
			);

			$settings_columns = implode(", ",array_keys($settings_data));
			$escaped_values = array_values($settings_data);
			$settings_values  = implode("', '", $escaped_values);


			$userData = array(
				'username' => 'admin',
				'email' => $data['email'],
				'password' => md5($data['password']),
				'user_role' => 1,
				'created_at' => $current_date,
			);
			$users_columns = implode(", ",array_keys($userData));
			$user_escaped_values = array_values($userData);
			$user_values  = implode("', '", $user_escaped_values);	

			$settings_table = 'settings';
			$users_table = 'users';


			if(isset($site_id) && $site_id !=0):

				$get = "SELECT * FROM `{$settings_table}`"; 
				$result = $conn->query($get);

				if(isset($result) && $result->num_rows > 0){
					$id = $conn->query($get)->fetch_object()->id;  
					foreach($settings_data as $k => $v) { $settings[] = "$k='$v'";}
				    $sql = "UPDATE {$settings_table} SET ". implode(', ', $settings)." WHERE `id` = {$id}";
					$insert = $conn->query($sql);

				}else{
					$sql = "INSERT INTO `{$settings_table}`($settings_columns) VALUES ('$settings_values')";
					$insert = $conn->query($sql);
				}

				/*----------------------------------------------
				  				User Information
				----------------------------------------------*/

				$userSql = "SELECT * FROM `{$users_table}` WHERE `user_role` = 1"; 
				$userResult = $conn->query($userSql);

				if(isset($userResult) && $userResult->num_rows > 0){
					$id = $conn->query($userSql)->fetch_object()->id;  
					foreach($userData as $k => $v) { $users[] = "$k='$v'";}
				    $sql = "UPDATE {$users_table} SET ". implode(', ', $users)." WHERE `id` = {$id}";
					$insert = $conn->query($sql);

				}else{
					$sql = "INSERT INTO `{$users_table}`($users_columns) VALUES ('$user_values')";
					$insert = $conn->query($sql);

				}

				if($insert){
					$this->createVersion($settings_data['purchase_code'],$settings_data['license_code']);
					$_SESSION['is_install'] = 1;
					$_SESSION['step'] = 0;
					session_unset();     // unset $_SESSION variable for the run-time 
          			session_destroy();
					return ['st'=>1, 'msg'=> 'Successfully Installed'];
				}else{
					return ['st'=>0, 'msg'=> $conn->error];
				}
			endif;
	}

	function createVersion($purchase_code,$license_code){
		error_reporting(0);
		include_once './helper.php';
		include BASEPATH.'/application/config/config.php';
		$dir =  BASEPATH.'/application/config/version.php';
		$version = "<?php \n";
		$version .= "define('VERSION', '". $config['app_version'] ."'); \n";
		$version .= "define('SCRIPT_NAME', 'qmenu'); \n";
		$version .= "define('AUTHOR', 'codetrick'); \n";
		$version .= "define('CODECANYON_LICENSE', '".$purchase_code."'); \n";
		$version .= "define('AUTHOR_LICENSE', '".$license_code."'); \n";
		file_put_contents(BASEPATH."/application/config/version.php", $version);
		
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

}



