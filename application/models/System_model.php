<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
class System_model extends CI_Model {

	public function ip_info($ip = false) {
	    $output = array('country_code' => '');

	    if(!$ip){
	        $ip = $_SERVER['REMOTE_ADDR'];
	    }

	    if (filter_var($ip, FILTER_VALIDATE_IP)) {

	        $curl = curl_init("http://www.geoplugin.net/json.gp?ip=" . $ip);
	        $request = '';
	        curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
	        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	        curl_setopt($curl, CURLOPT_HEADER, false);
	        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

	        $ipdat = json_decode(curl_exec($curl));
	        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
	            $output = array(
	                "ip"             => $ip,
	                "city"           => @$ipdat->geoplugin_city,
	                "state"          => @$ipdat->geoplugin_regionName,
	                "country"        => @$ipdat->geoplugin_countryName,
	                "country_code"   => @$ipdat->geoplugin_countryCode,
	                "continent_code" => @$ipdat->geoplugin_continentCode,
	                "regionCode"     => @$ipdat->geoplugin_regionCode,
	                "regionName"     => @$ipdat->geoplugin_regionName,
	                "countryCode"    => @$ipdat->geoplugin_countryCode,
	                "countryName"    => @$ipdat->geoplugin_countryName,
	                "continentName"  => @$ipdat->geoplugin_continentName,
	                "timezone"       => @$ipdat->geoplugin_timezone,
	                "currencyCode"   => @$ipdat->geoplugin_currencyCode,
	                "currencySymbol" => @$ipdat->geoplugin_currencySymbol,
	            );
	        }
	    }

	    return $output;
	}

	public function get_controller_files($slug){
		if($slug=='qpos'):
			$to = APPPATH.'controllers/admin/Pos.php';
			unlink($to);
			$filePath = FCPATH.'addons/controllers/Pos_controller.php';
			if(file_exists($filePath)){
				try{
					$this->move_file($filePath,$to);
					return true;
				}catch (Exception $e) {
					return $e->getMessage(); 		
				}
			}else{
				return "Sorry Addons folder & files are not found!!";
			}

			
		endif;
	}

	public function get_model_files($slug){
		if($slug=='qpos'):
			$to = APPPATH.'models/Pos_m.php';
			unlink($to);

			$filePath = FCPATH.'addons/models/Pos_model.php';
			if(file_exists($filePath)){
				try{
					$this->move_file($filePath,$to);
					return true;
				}catch (Exception $e) {
					return $e->getMessage(); 		
				}
			}else{
				return "Sorry Addons folder & files are not found!!";
			}
		endif;
	}

	protected function move_file($filePath, $to){
		if (!file_exists($to)) {
			copy($filePath, $to);
			unlink($filePath);
		}
	}



	public function order_push($id,$order_id,$action_type)
	{
		$order_info = $this->admin_m->get_my_order_by_order_id($order_id);
		$settings = $this->common_m->get_user_settings(shop($id)->user_id);
		$notification = isJson($settings['onesignal_config']) ? json_decode($settings['onesignal_config']) : "";

		if(isset($notification->is_active_onsignal) && $notification->is_active_onsignal == 1 && isset($notification->user_id) && !empty($notification->user_id) && isset($notification->is_order_push) && $notification->is_order_push==1) :

			$myUser = [$notification->user_id];

			$appId = $notification->onsignal_app_id;

			$headings = "A new order placed";
			$msg = lang('order_id').": {$order_info->uid}  ".lang('order_type').":  {$order_info->name}";
			$headings      = array(
				"en" => $headings
			);

			$content      = array(
				"en" => $msg
			);


			$fields = array(
				'app_id' => $appId,
				'include_player_ids' => $myUser,

				'data' => array(
					"foo" => "bar"
				),

				'contents' => $content,
				'headings' => $headings,
				'url' => base_url("admin/order-details/{$order_info->uid}"),
			);

			$fields = json_encode($fields);

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json; charset=utf-8',
				'Authorization: Basic ' . $notification->user_auth_key,
			));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

			$response = curl_exec($ch);
			curl_close($ch);
			$result = json_decode($response);
			if ($result->id != '') :
				return true;
			else :
				return false;
			endif;
		else:
			return true;
		endif;
	}

	public function whatsapp_message($status,$order_info){
		$shop = shop($order_info['shop_id']);
		$order_types = $this->admin_m->get_users_order_types_by_shop_id($order_info['shop_id'],1);
		$order_type_name = $this->admin_m->get_order_slug_by_slug($order_info['order_type']);
		$orderType = [];
		if(sizeof($order_types) > 0){
			foreach($order_types as $type){
				$orderType[] = $type['slug'];
			};
		};


		$msg = isJson($shop->whatsapp_message_config)?json_decode($shop->whatsapp_message_config):'';
		if(isset($msg->status) && $msg->status==1 && isset($msg->instance_id) && !empty($msg->instance_id)):
		require 'vendor/autoload.php';

			$track_url = url('my-orders/'.$shop->username.'?phone='.$order_info['phone'].'&orderId='.$order_info['uid']);
			$replace_data = array(
				'{CUSTOMER_NAME}' => !empty($order_info['name'])?$order_info['name']:'',
				'{SHOP_NAME}' => !empty($shop->name)?$shop->name:$shop->username,
				'{ORDER_ID}' => $order_info['uid'],
				'{TRACK_URL}' => $track_url??'',
			);

			if($status==Status::ACCEPT){
				$created_msg = create_msg($replace_data,json_decode($msg->accept_msg));
			}

			if($status==Status::COMPLETE){
				$created_msg = create_msg($replace_data,json_decode($msg->complete_msg));
			}

			if($status==Status::CANCEL){
				$created_msg = create_msg($replace_data,json_decode($msg->cancled_msg));
			}
			
		
			if(isset($msg->msg_id_type) && $msg->msg_id_type=='wasendo'):
				$this->wisdon($msg,$order_info,$order_type_name, $orderType,$created_msg);
			else:
				$this->ultramsg($msg,$order_info,$order_type_name, $orderType,$created_msg);
			endif;

		endif;
		return true;
	}

	private function ultramsg($msg,$order_info,$order_type_name, $orderType,$created_msg){
		$params=array(
			'token' => $msg->token,
			'to' => $order_info['phone'],
			'body' => $created_msg
		);

		$client = new Client();
		$headers = [
			'Content-Type' => 'application/x-www-form-urlencoded'
		];
		$options = ['form_params' =>$params ];
		$request = new Request('POST', "https://api.ultramsg.com/{$msg->instance_id}/messages/chat", $headers);

		if(in_array($order_type_name, $orderType)):
			$res = $client->sendAsync($request, $options)->wait();
			echo $res->getBody();
		endif;
	}

	private function wisdon($msg,$order_info,$order_type_name, $orderType,$created_msg){
		 $apiUrl = "https://wasendo.com/api/send";
	        $params = array(
	            "number" => $order_info['phone'],
	            "type" => "text",
	            "message" => $created_msg,
	            "instance_id" => $msg->instance_id,
	            "access_token" => $msg->token,
	        );
	        $curl = curl_init();
	        curl_setopt_array($curl, array(
	          CURLOPT_URL => $apiUrl,
	          CURLOPT_RETURNTRANSFER => true,
	          CURLOPT_ENCODING => "",
	          CURLOPT_MAXREDIRS => 10,
	          CURLOPT_TIMEOUT => 30,
	          CURLOPT_SSL_VERIFYHOST => 0,
	          CURLOPT_SSL_VERIFYPEER => 0,
	          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	          CURLOPT_CUSTOMREQUEST => "POST",
	          CURLOPT_POSTFIELDS => json_encode($params),
	          CURLOPT_HTTPHEADER => array(
	            "content-type: application/json"
	          ),
	        ));

	        if (curl_errno($curl)) {
	            $error_msg = curl_error($curl);
	            echo "<pre>";
	            print_r($error_msg);
	            exit();
	        }
	        $response = curl_exec($curl);
	        $err = curl_error($curl);
	        $result = json_decode($response);

	        if($result->status=="success"){
	        	return true;
	        }else{
	        	echo "<pre>";print_r($response);exit();
	        }
	}


	public function xs_cleaner($data) {
		$this->load->helper('security');
		$allowed_tags = '<b><i><img><table><td><tr><video><p><strong><th><em><blockquote><code><pre><li><ul><ol><br><a><s><u><i>';
		if (is_array($data)) {
			foreach ($data as $key => $value) {
				$data[$key] = $this->xs_cleaner($value);
			}
		} else if (is_string($data)) {
			$removeData = strip_tags(html_entity_decode($data,ENT_QUOTES, "UTF-8"),$allowed_tags);
			$data = str_replace('[removed]','',$removeData);
		}

		return $data;
	}





	public function avoid_xss($inputP)
	{
		$ci =& get_instance();
		$spaceDelimiter = "#BLANKSPACE#";
		$newLineDelimiter = "#NEWLNE#";

		$inputArray = [];
		$minifiedSanitized = '';
		$unMinifiedSanitized = '';
		$sanitizedInput = [];
		$returnData = [];
		$returnType = "string";

		if($inputP === null) return null;
		if($inputP === false) return false;
		if(is_array($inputP) && sizeof($inputP) <= 0) return [];

		if(is_array($inputP))
		{
			$inputArray = $inputP;
			$returnType = "array";
		}
		else
		{
			$inputArray[] = $inputP;
			$returnType = "string";
		}
		
		foreach($inputArray as $input)
		{
			$minified = str_replace(" ",$spaceDelimiter,$input);
			$minified = str_replace("\n",$newLineDelimiter,$minified);

			        //removing <script> tags
			$minifiedSanitized = preg_replace("/[<][^<]*script.*[>].*[<].*[\/].*script*[>]/i","",$minified);

			$unMinifiedSanitized = str_replace($spaceDelimiter," ",$minifiedSanitized);
			$unMinifiedSanitized = str_replace($newLineDelimiter,"\n",$unMinifiedSanitized);

			        //removing inline js events
			$unMinifiedSanitized = preg_replace("/([ ]on[a-zA-Z0-9_-]{1,}=\".*\")|([ ]on[a-zA-Z0-9_-]{1,}='.*')|([ ]on[a-zA-Z0-9_-]{1,}=.*[.].*)/","",$unMinifiedSanitized);

			        //removing inline js
			$unMinifiedSanitized = preg_replace("/([ ]href.*=\".*javascript:.*\")|([ ]href.*='.*javascript:.*')|([ ]href.*=.*javascript:.*)/i","",$unMinifiedSanitized);


			$sanitizedInput[] = $unMinifiedSanitized;
		}

		if($returnType == "string" && sizeof($sanitizedInput) > 0)
		{
			$returnData = $sanitizedInput[0];
		}
		else
		{
			$returnData = $sanitizedInput;
		}

		return $returnData;
	}

	public function arrayToCsv($array) {
        if (count($array) == 0) {
            return null;
        }

        ob_start();
        $df = fopen("php://output", 'w');

        // Insert the CSV header (column names)
        fputcsv($df, array_keys(reset($array)));

        // Insert the data rows
        foreach ($array as $row) {
            fputcsv($df, $row);
        }

        fclose($df);
        return ob_get_clean();
    }

	

}


/* End of file System_model.php */
/* Location: ./application/models/System_model.php */