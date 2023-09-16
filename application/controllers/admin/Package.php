<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Package extends MY_Controller {
	public function __construct(){
		parent::__construct();
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
	}

	public function index()
	{
		$data = array();
		$data['page_title'] = "Packages";
        $data['page'] = "Packages";
        $data['data'] = FALSE;
        $data['type_data'] = FALSE;
        $data['package_list']=$this->default_m->select_row('package_list');
		$data['main_content'] = $this->load->view('backend/packages/planList', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function create()
	{
		$data = array();
		$data['page_title'] = "Create Packages";
        $data['page'] = "Packages";
        $data['data'] = FALSE;
        $data['package_list']=$this->default_m->select('package_list');
        $data['feature_list']=$this->default_m->select_row('feature_list');
		$data['main_content'] = $this->load->view('backend/packages/createPlan', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	/**
	  ** edit features type
	**/
	public function edit_package($id)
	{
		$data = array();
		$data['page_title'] = "Packages";
        $data['page'] = "Packages";
        $data['data'] = $this->default_m->single_select_by_row_id($id,'package_list');
        $data['package_list']=$this->default_m->select('package_list');
        $data['feature_list']=$this->default_m->select_row('feature_list');
		$data['main_content'] = $this->load->view('backend/packages/createPlan', $data, TRUE);
		$this->load->view('backend/index',$data);
	}


	/**
	  *** add add_packages
	**/ 
		public function add_packages(){
			$id = $this->input->post('id',TRUE);
			$this->form_validation->set_rules('package_name', 'Package Name', 'required|trim|xss_clean|max_length[15]');
			$this->form_validation->set_rules('slug', 'Slug','required|trim|xss_clean|max_length[15]|callback_english_check');
			$this->form_validation->set_rules('package_type', 'Package Types', 'trim|xss_clean|required');
			$this->form_validation->set_rules('feature_id[]', 'Features', 'trim|xss_clean|required');
			$this->form_validation->set_rules('price', 'Price', 'required|xss_clean|trim|callback_number_check');
				$price = $this->input->post('price',TRUE);
			// if($type=='free' || $type=='trial' || $type=='weekly' || $type=='fifteen'){
			// 	$this->form_validation->set_rules('price', 'Price', 'trim|xss_clean');
			// 	$price = 0;
			// }else{
				
			// }
			
		if ($this->form_validation->run() == FALSE) {
				$msg = validation_errors();
				$url = base_url('admin/package');
				$response = ['st' => 0, 'msg'=> $msg, 'url'=>$url];
			}else{	
				

				$data = array(
					'package_name' => $this->input->post('package_name',TRUE),
					'slug' => str_slug($this->input->post('slug',TRUE)),
					'price' => $price,
					'package_type' => $this->input->post('package_type',TRUE),
					// 'order_limit' => isset($order_limit) && !empty($order_limit)?$order_limit:0,
					// 'item_limit' => isset($item_limit) && !empty($item_limit)?$item_limit:0,
					'created_at' => d_time(),
				);
				
				if($id != 0):
					$insert = $this->default_m->update($data,$id,'package_list');
				else:
					$insert = $this->default_m->insert($data,'package_list');
				endif;
		
				if($insert){
					$feature_id = $this->input->post('feature_id',TRUE);
					
					if(isset($feature_id)){
						if($this->input->post('id')!=0){
							$this->admin_m->delete_pricing($this->input->post('id'),'active_package_features');
						}
						foreach ($feature_id as $value):
							$active_features[] = array(
								'package_id' => $insert,
								'feature_id' => $value,
							);
							
						endforeach;
						$add_features_id = $this->default_m->insert_all($active_features,'active_package_features');
					}

					$msg = "Save changes successfully";
					$url = base_url('admin/package');
					$response = ['st' => 1, 'msg'=> $msg, 'url'=>$url];
				}else{
					$msg = "somethings were wrong!";
					$url = base_url('admin/package');
					$response = ['st' => 0, 'msg'=> $msg, 'url'=>$url];
				}	
		}

		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($response));
		;
	}


	public function number_check($val)
    {
        if (!preg_match('/^[0-9]+(\\.[0-9]+)?$/', $val)) {
            $this->form_validation->set_message('number_check', 'The {field} field must be a number or decimal.');
            return FALSE;
        } else {
            return TRUE;
        }
    }



	//check english string for username
    public function english_check($string){
    	if (preg_match('/[^A-Za-z0-9 ]/', $string))  {
		    //string contains only letters from the English alphabet
    		$this->form_validation->set_message('english_check', 'The {field} field contains only letters from the English alphabet.');
    		return FALSE;
    	}else{
    		return true;
    	}
    }


	/*----------------------------------------------
	  		Features		
	----------------------------------------------*/
	public function features()
	{
		$data = array();
		$data['page_title'] = "Features";
        $data['page'] = "Features";
        $data['data'] = FALSE;
        $data['feature_list']=$this->default_m->select('feature_list');
		$data['main_content'] = $this->load->view('backend/packages/feature_list', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function create_feature()
	{
		$data = array();
		$data['page_title'] = "Create Features";
        $data['page'] = "Features";
        $data['data'] = FALSE;
        $data['feature_list']=$this->default_m->select('feature_list');
		$data['main_content'] = $this->load->view('backend/packages/create_feature', $data, TRUE);
		$this->load->view('backend/index',$data);
	}


	/**
	  ** Edit features
	**/
	public function edit_features($id)
	{
		$data = array();
		$data['page_title'] = "Features";
        $data['page'] = "Features";
        $data['data'] = $this->default_m->single_select_by_row_id($id,'feature_list');
        $data['feature_list']=$this->default_m->select('feature_list');
		$data['main_content'] = $this->load->view('backend/packages/create_feature', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	/**
	  *** add features
	**/ 
	public function add_features(){
		is_test();


		// $formdata = json_decode(file_get_contents('php://input'), true);
		//  // echo "<pre>";print_r($formdata);exit();

		// if (empty($formdata)) {
		// 	$msg = 'Field must not be empty!!';
		// 	$response = ['st' => 0, 'msg'=> $msg,];
		// else{
		// 	$formdata
		// }



		$this->form_validation->set_rules('name', 'Feature name', 'required|trim|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			// $this->session->set_flashdata('error', validation_errors());
			// redirect(base_url('admin/package/features'));
			$msg = validation_errors();
			$url = base_url('admin/package/create_feature');
			$response = ['st' => 0, 'msg'=> $msg, 'url'=>$url];
			}else{	
				$data = array(
					'name' => $this->input->post('name',TRUE),
					'slug' => str_slug($this->input->post('name',TRUE)),
				);
				$id = $this->input->post('id',TRUE);
				if($id != 0):
					$insert = $this->default_m->update($data,$id,'feature_list');
				else:
					$insert = $this->default_m->insert($data,'feature_list');
					// $this->session->set_flashdata('error', 'You can only Update features name');
					// redirect(base_url('admin/dashboard/features'));
					$msg = 'Success';
					$response = ['st' => 0, 'msg'=> $msg,];
				endif;

				if($insert){
					$msg = 'Success';
					$url = base_url('admin/package/features');
					$response = ['st' => 1, 'msg'=> $msg, 'url'=>$url];
				}else{
					$msg = 'Success';
					$url = base_url('admin/package/features');
					$response = ['st' => 0, 'msg'=> $msg, 'url'=>$url];
				}	
		}

		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($response));
		;
	}


}

