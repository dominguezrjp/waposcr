<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_m extends CI_Model {
	public function __construct(){
		// parent::__construct();
		$this->db->query("SET sql_mode = ''");
	}

	public function upload($size='250')
	{
		ini_set('memory_limit', '-1');
	    $data = array();
	    if (!empty($_FILES['file']['name'])) {
	        $filesCount = count($_FILES['file']['name']);
	        for ($i = 0; $i < $filesCount; $i++) {
	              $_FILES['uploadFile']['name'] = str_replace(",","_",$_FILES['file']['name'][$i]);
	              $_FILES['uploadFile']['type'] = $_FILES['file']['type'][$i];
	              $_FILES['uploadFile']['tmp_name'] = $_FILES['file']['tmp_name'][$i];
	              $_FILES['uploadFile']['error'] = $_FILES['file']['error'][$i];
	              $_FILES['uploadFile']['size'] = $_FILES['file']['size'][$i];

	              //Directory where files will be uploaded
	              $uploadPath = 'uploads/';


	              $config['upload_path'] = $uploadPath.'big/';
	              // Specifying the file formats that are supported.
	              $config['allowed_types'] = '*';
	              $config['overwrite'] = TRUE;
				  $config['encrypt_name'] = TRUE;
	              $this->load->library('upload', $config);
	              $this->upload->initialize($config);
	              // resize library
	              $this->load->library('image_lib');

	              if ($this->upload->do_upload('uploadFile')) {
	                  $fileData = $this->upload->data();
	                  $uploadData[$i]['file_name'] = $fileData['file_name'];
	                  // resize
			            $config = array(
						    'source_image'      => $fileData['full_path'], 
						    'new_image'         => $uploadPath.'/thumb', //path to
						    'maintain_ratio'    => true,
						    'width'             => $size,
						    'height'            => $size
						);
					    $this->image_lib->initialize($config);
					    $this->image_lib->resize();
						// resize
						    
	              }else{
	              	$error = array('error' => $this->upload->display_errors());
                    foreach ($error as $key => $value) {
                    	$msg[$key] = $value;
                    }
                    return ['st'=>0,'data'=>$msg];
                    exit();
	              }

	        }
	          
	        if (!empty($uploadData)) {
	          $list=array();
	          	foreach ($uploadData as $key => $value) {
		          	$data[$key] = array(
		          		'image' => $uploadPath.'big/'.$value['file_name'],
		          		'thumb' => $uploadPath.'thumb/'.$value['file_name'],
		          	);
		          	
	          	}	
	          	return ['st'=>1,'data'=>$data];
	    		
		  	}else{
		    	return ['st'=>0,'data'=>'Please select an image'];
		    }

	    }else{
	    	return ['st'=>0,'data'=>'Please select an image'];
	    }
	}



	public function upload_banner($dir='site_banners')
	{
		ini_set('memory_limit', '-1');
	    $data = array();
	    if (!empty($_FILES['file']['name'])) {
	        $filesCount = count($_FILES['file']['name']);
	        for ($i = 0; $i < $filesCount; $i++) {
	              $_FILES['uploadFile']['name'] = str_replace(",","_",$_FILES['file']['name'][$i]);
	              $_FILES['uploadFile']['type'] = $_FILES['file']['type'][$i];
	              $_FILES['uploadFile']['tmp_name'] = $_FILES['file']['tmp_name'][$i];
	              $_FILES['uploadFile']['error'] = $_FILES['file']['error'][$i];
	              $_FILES['uploadFile']['size'] = $_FILES['file']['size'][$i];

	              //Directory where files will be uploaded
	              $uploadPath = 'uploads/'.$dir.'/';


	              $config['upload_path'] = $uploadPath;
	              // Specifying the file formats that are supported.
	              $config['allowed_types'] = 'jpg|jpeg|png|pdf|svg';
	              $config['overwrite'] = TRUE;
				  $config['encrypt_name'] = TRUE;
	              $this->load->library('upload', $config);
	              $this->upload->initialize($config);
	              // resize library
	              $this->load->library('image_lib');

	              if ($this->upload->do_upload('uploadFile')) {
	                  $fileData = $this->upload->data();
	                  $uploadData[$i]['file_name'] = $fileData['file_name'];
						    
	              }else{
	              	$error = array('error' => $this->upload->display_errors());
                    foreach ($error as $key => $value) {
                    	$msg[$key] = $value;
                    }
                    return ['st'=>0,'data'=>$msg];
                    exit();
	              }

	        }
	          
	        if (!empty($uploadData)) {
	          $list=array();
	          	foreach ($uploadData as $key => $value) {
		          	$data[$key] = array(
		          		'image' => $uploadPath.$value['file_name'],
		          	);
		          	
	          	}	
	          	return ['st'=>1,'data'=>$data];
	    		
		  	}else{
		    	return ['st'=>0,'data'=>'Please select an image'];
		    }

	    }else{
	    	return ['st'=>0,'data'=>'Please select an image'];
	    }
	}


	/**===== Upload images dashboard ====**/
	public function upload_img($id,$table){
		if (!empty($_FILES['file']['name'])) {
	 		$up_load = $this->upload(400);
		 	if($up_load['st']==1):
			 	foreach ($up_load['data'] as $key => $value) {
			 		$data = array(
			 			'images' => $value['image'],
			 			'thumb' => $value['thumb'],
			 		);
			 		$this->admin_m->update($data,$id,$table);
			 	}
			 	return true;
			 else:
			 	$this->session->set_flashdata('success', $up_load['data']['error']);
			 endif;
		 	
		}
	}




	public function order_qr($phone,$orderId,$shopId){
			$shop = $this->common_m->get_restaurant_info_by_id($shopId);
			$this->load->library('ciqrcode');
			$qr_image= $shop['username'].'_'.rand().'.png';
			$params['data'] = url('my-orders/'.$shop['username'].'?phone='.$phone.'&orderId='.$orderId);
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


	public function menu_qr($menuId,$shopId){
			$shop = $this->common_m->get_restaurant_info_by_id($shopId);
			$this->load->library('ciqrcode');
			$qr_image= $shop['username'].'_menu_'.rand().'.png';
			$params['data'] = url('qr-menu/'.$shop['username'].'/'.md5($menuId));
			$params['level'] = 'H';
			$params['size'] = 12;
			$params['savename'] =FCPATH."uploads/orders_qr/".$qr_image;
			if($this->ciqrcode->generate($params))
			{
				$data = array(
					'qr_link' =>'uploads/orders_qr/'.$qr_image,
				);
				$update = $this->admin_m->update_menu_qr($data,$menuId,$shopId);
			}
	
		return $data['qr_link'];
	}


	public function verify($purchase_code){
		$form_data = [
			'purchase_code' => $purchase_code,
			'site_url' => SITE_URL,
			'author' => AUTHOR,
			'is_localhost' => isLocalHost(),
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
			return 1;
		else:
			return 0;
		endif;
	}
	

}

