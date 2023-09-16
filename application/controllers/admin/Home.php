<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
	public function __construct(){
		parent::__construct();
		is_login();
		check_valid_auth();
	}
	public function languages()
	{
		$data = array();
		$data['page_title'] = "Language";
		$data['page'] = "Languages";
		$data['data']=FALSE;
		$data['languages']=$this->admin_m->select('languages');
		$data['main_content'] = $this->load->view('backend/language/home', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function edit_languages($id)
	{
		$data = array();
		$data['page_title'] = "Language";
	    $data['page'] = "Languages";
	    $data['data']=$this->admin_m->single_select_by_id($id,'languages');
	    $data['languages']=$this->admin_m->select('languages');
		$data['main_content'] = $this->load->view('backend/language/home', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function fontend_languages()
	{
		$data = array();
		$data['page_title'] = "Fontend Language";
	    $data['page'] = "Languages";
	    $data['data']=FALSE;
	    $data['fontend_languages']=$this->admin_m->get_language_data('home',$status='*');
	    $data['label_languages']=$this->admin_m->get_language_data('label',$status=1);
		$data['main_content'] = $this->load->view('backend/language/fontend_language', $data, TRUE);
		$this->load->view('backend/index',$data);
	}


	public function dashboard_languages()
	{

		//pagination
	    $config = [];
	    $this->load->library('pagination');
	    $per_page = isset($_GET['limit'])?$_GET['limit']:30;

		$page = $this->input->get('page');
	    if (empty($page)) {
	        $page = 0;
	    }

	    if ($page != 0) {
	        $page = $page-1;
	    }
	    $offset = ceil($page * $per_page);

	    $total = $this->admin_m->get_all_language_data(0,0,$is_total=1);
	    $config['base_url'] = base_url('admin/home/dashboard_languages');
	    $config['total_rows'] = $total;
	    $config['per_page'] =  $per_page;
	    $this->pagination->initialize($config);




		$data = array();
		$data['page_title'] = "Dashboard Language";
	    $data['page'] = "Languages";
	    $data['data']=FALSE;
	    $data['admin_languages']=$this->admin_m->get_all_language_data($per_page,$offset,0);
	    $data['languages']=$this->admin_m->get_language($status=1);
		$data['main_content'] = $this->load->view('backend/language/dashboard_language', $data, TRUE);
		$this->load->view('backend/index',$data);
	}


	public function add_languages(){
		is_test();
		$id = $this->input->post('id');
		$this->form_validation->set_rules('direction', 'Text Direction', 'required|trim|xss_clean');
		if($id==0):
			$this->form_validation->set_rules('lang_name', 'Language Name', 'required|trim|xss_clean|is_unique[languages.lang_name]',array('is_unique'=>'Sorry This language is already exits'));

			$this->form_validation->set_rules('slug', 'Language Slug', 'required|trim|alpha|xss_clean|is_unique[languages.slug]',array('is_unique'=>'Sorry This language slug already exits!'));
		else:
			$this->form_validation->set_rules('lang_name', 'Language Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('slug', 'Language Slug', 'required|trim|xss_clean');
		endif;

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/home/languages'));
			}else{	
				$slug = str_slug($this->input->post('slug',TRUE));
				$data = array(
					'lang_name' => $this->input->post('lang_name',TRUE),
					'slug' => $slug,
					'direction' => $this->input->post('direction',TRUE),
					'created_at' => d_time(),
				);
				$id = $this->input->post('id');
				if($id==0){
					$this->create_folder($slug);
					$insert = $this->admin_m->insert($data,'languages');
				}else{
					$insert = $this->admin_m->update($data,$id,'languages');
				}

				if($insert){
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/home/languages'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/home/languages'));
				}	
		}
	}

	public function create_folder($lang_name){
		$data = array();
		$directory = FCPATH . 'application/language/';

		if (!file_exists($directory.'/'.$lang_name)) {

			$st_1 = $this->db->query('ALTER TABLE language_data ADD ('.$lang_name.' TEXT NULL)') or print json_encode(array('st'=>0,'msg'=>$this->db->error()));
			if($st_1){
				$create =  mkdir($directory . '/' . $lang_name, 0777);

				if($create){
					$write =	$this->write($lang_name);

					if($write==TRUE){
						return true;
					}else{
						return false;
					}

				}
			}


		} else {
			if (!$this->db->field_exists($row['slug'], 'language_data'))
			{
			    $st_1 = $this->db->query('ALTER TABLE language_data ADD ('.$lang_name.' TEXT NULL)') or print json_encode(array('st'=>0,'msg'=>$this->db->error()));
			}

			$this->session->set_flashdata('success', 'The folder ' . $lang_name . ' already Exists');
			return false;
		}

	}

	function write($lang_name) {

			// Config path
		$name = $lang_name;
		$template_path 	= FCPATH . 'application/hooks/lang.php';
		$output_path 	= FCPATH . 'application/language/'.$lang_name.'/content_lang.php';

			// Open the file
		$database_file = file_get_contents($template_path);
		$new_data  = str_replace("%my%",$name,$database_file);
			// Write the new database.php file
		$handle = fopen($output_path,'w+');

			// Chmod the file, in case the user forgot
		@chmod($output_path,0777);

			// Verify file permissions
		if(is_writable($output_path)) {

				// Write the file
			if(fwrite($handle,$new_data)) {
				return true;
			} else {
				return false;
			}

		} else {
			return false;
		}
	}


	public function add_languages_value($lang_name){
		is_test();
	$this->form_validation->set_rules('lang_name', 'Name', 'trim|xss_clean');
	if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}else{	
			$i=0;
			$keyword = $this->input->post('keyword',TRUE);
			foreach ($_POST[$lang_name] as $key => $value) {
				if($keyword[$i] !='hindi'):
					$data = array(
						$lang_name => trim($value),
						'details' => ucfirst($_POST['details'][$i]),
					);
				else:
					$data = array(
						$lang_name => trim($value),
						'details' => ucfirst($_POST['details'][$i]),
					);
				endif;
				  $insert = $this->admin_m->update_language($data,$keyword[$i],'language_data');
				$i++;
			}
		
			if($insert){
				$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
				redirect($_SERVER['HTTP_REFERER']);
			}	
	}
}

public function add_keyword(){
	$this->form_validation->set_rules('keyword', 'Keyword', 'required|trim|xss_clean|is_unique[language_data.keyword]');
	$this->form_validation->set_rules('value', 'Value', 'required|trim|xss_clean');
	$this->form_validation->set_rules('types', 'Types', 'required|trim|xss_clean');


	if ($this->form_validation->run() == FALSE) {
		$this->session->set_flashdata('error', validation_errors());
		redirect($_SERVER['HTTP_REFERER']);
	}else{	

		ini_set('memory_limit', '-1');
		
		$data = array(
			'keyword' => $this->input->post('keyword',TRUE),
			'english' => $this->input->post('value',TRUE),
			'details' => $this->input->post('value',TRUE),
			'type' => $this->input->post('types',TRUE),
		);
		$insert = $this->admin_m->insert($data,'language_data');

		if($insert){
			$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
			redirect($_SERVER['HTTP_REFERER']);
		}	
	}
}

public function ln($type=1){
// admin/home/ln/1
		$data = [];
		if($type==1):
			$lan = $this->common_m->select_desc('language_data');
			foreach ($lan as $key => $value) {
			 echo  "'".$value['id']."' =>" , '"'.$value['english'].'",'.'<br>';
			   // echo  "('{$value['keyword']}','admin','{$value['details']}','{$value['english']}'),"."<br>";
			    
			}
			 exit();
		else:
			$data = array(
				'1209' => "عربة التسوق الجديدة",
'1208' => "هل ترغب في مسح سلة التسوق؟",
'1207' => "تحتوي سلة التسوق الخاصة بك بالفعل على عناصر من" ,
'1206' => "بدء عربة تسوق جديدة؟",
			);
			foreach ($data as $key => $value) {
				// es,ar,ru,cn,fr,pt,hindi
				$d = array(
					'ar' => trim($value),
				);
			  $this->common_m->update($d,$key,'language_data');
			}
			echo 'done'."=====".array_keys($d)[0];
		exit();
	endif;
}

/**
  ** site services
**/
	public function services()
	{
		check_valid_auth();
		$data = array();
		$data['page_title'] = "Services";
        $data['page'] = "Home";
        $data['data'] = false;
        $data['services'] = $this->admin_m->select('site_services');
		$data['main_content'] = $this->load->view('backend/admin_activities/services', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	/**
	  ** edit site services
	**/

	public function edit_services($id)
	{
		check_valid_auth();
		$data = array();
		$data['page_title'] = "Services";
        $data['page'] = "Home";
        $data['data'] =$this->admin_m->single_select_by_id($id,'site_services');
        $data['services'] = $this->admin_m->select('site_services');
		$data['main_content'] = $this->load->view('backend/admin_activities/services', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	/**
	  *** site add_services
	**/ 
	public function add_services(){
		is_test();
		$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
		$this->form_validation->set_rules('details', 'Details', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/home/services'));
			}else{	
				$data = array(
					'title' => $this->input->post('title',true),
					'details' => $this->input->post('details'),
					'created_at' => d_time(),
				);
				$id = $this->input->post('id');
				if($id==0){
					$insert = $this->admin_m->insert($data,'site_services');
				}else{
					$insert = $this->admin_m->update($data,$id,'site_services');
				}

				if($insert){
					$this->upload_img($insert,$table = 'site_services');
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/home/services'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/home/services'));
				}	
		}
	}


	

	/**
  *** FAQS
**/  	
	public function faq()
	{
		$data = array();
		$data['page_title'] = "FAQ";
		$data['page'] = "Home";
		$data['data'] = false;
        $data['faq']=$this->admin_m->select('faq');
		$data['main_content'] = $this->load->view('backend/admin_activities/faq', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function edit_faq($id)
	{
		$data = array();
		$data['page_title'] = "FAQ";
		$data['page'] = "Home";
		$data['data'] = $this->admin_m->single_select_by_id($id,'faq');
        $data['faq']=$this->admin_m->select('faq');
		$data['main_content'] = $this->load->view('backend/admin_activities/faq', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	/**
	  *** add faq
	**/ 
	public function add_faq(){
		is_test();
		$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
		$this->form_validation->set_rules('details', 'Details', 'required|trim|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/home/faq'));
			}else{	
				$data = array(
					'title' => $this->input->post('title',TRUE),
					'details' => $this->input->post('details',TRUE),
					'created_at' => d_time(),
				);
				$id = $this->input->post('id');
				if($id==0){
					$insert = $this->admin_m->insert($data,'faq');
				}else{
					$insert = $this->admin_m->update($data,$id,'faq');
				}

				if($insert){
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/home/faq'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/home/faq'));
				}	
		}
	}


	/**
	  ** Home page Team
	**/

	public function team()
	{
		$data = array();
		$data['page_title'] = "Team Members";
        $data['page'] = "Home";
        $data['data'] = false;
        $data['team'] = $this->admin_m->select('site_team');
		$data['main_content'] = $this->load->view('backend/admin_activities/meet_team', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function edit_team($id)
	{
		$data = array();
		$data['page_title'] = "Reviews";
        $data['page'] = "Home";
        $data['data'] =$this->admin_m->single_select_by_id($id,'site_team');
        $data['team'] = $this->admin_m->select('site_team');
		$data['main_content'] = $this->load->view('backend/admin_activities/meet_team', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	/**
	  *** add_reviews
	**/ 
	public function add_team(){
		is_test();
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('designation', 'Designation', 'trim|required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/home/team'));
		}else{	
			$data = array(
				'name' => $this->input->post('name',true),
				'user_id' => auth('id'),
				'designation' => $this->input->post('designation',true),
				'created_at' => d_time(),
			);
			$id = $this->input->post('id');
			if($id==0){
				$insert = $this->admin_m->insert($data,'site_team');
			}else{
				$insert = $this->admin_m->update($data,$id,'site_team');
			}

			if($insert){
				$this->upload_img($insert,$table='site_team');
				$this->session->set_flashdata('success', 'Save change Successfull');
				redirect(base_url('admin/home/team'));
			}else{
				$this->session->set_flashdata('error', 'Somethings were wrong');
				redirect(base_url('admin/home/team'));
			}	
		}
	}

	/**
	  ** Home page Team
	**/

	public function site_features()
	{
		$data = array();
		$data['page_title'] = "Site Features";
        $data['page'] = "Home";
        $data['data'] = false;
        $data['banner'] = $this->admin_m->single_select_by_section_name('features');
        $data['left_features'] = $this->admin_m->select_home_features_by_type('left');
        $data['right_features'] = $this->admin_m->select_home_features_by_type('right');
        $data['all_features'] = $this->admin_m->select('site_features');
		$data['main_content'] = $this->load->view('backend/admin_activities/site_features', $data, TRUE);
		$this->load->view('backend/index',$data);
	}


	/**
	  *** Add Site features
	**/ 
	public function add_site_features(){
		is_test();
		$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean|max_length[80]');
		$this->form_validation->set_rules('details', 'Details', 'required|xss_clean|max_length[120]');
		$this->form_validation->set_rules('dir', 'Direction', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/home/site_features'));
			}else{	
				$icon = $this->input->post('icon');
				$data = array(
					'title' => $this->input->post('title',true),
					'user_id' => auth('id'),
					'icon' => $icon,
					'details' => $this->input->post('details'),
					'dir' => $this->input->post('dir'),
					'status' => 1,
					'created_at' => d_time(),
				);
				$id = $this->input->post('id');
				if($id==0){
					$insert = $this->admin_m->insert($data,'site_features');
				}else{
					$insert = $this->admin_m->update($data,$id,'site_features');
					if(isset($icon) && !empty($icon)):
						$up_data = array(
							'images' => '',
							'thumb' => ''
						);
					else:
						if(!empty($_FILES['file']['name'])):
							$up_data =array(
								'icon' =>'',
							);
						endif;
					endif;
					 $this->admin_m->update($up_data,$id,'site_features');
				}

				if($insert){
					$this->upload_img($insert,$table='site_features');
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/home/site_features'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/home/site_features'));
				}	
		}
	}

 	
 	public function add_features_banner()
 	{
 		is_test();
 		$id = $this->input->post('id',TRUE);
 		if (!empty($_FILES['file']['name'])) {
	 		$up_load = $this->upload_m->upload(400);
		 	if($up_load['st']==1):
			 	foreach ($up_load['data'] as $key => $value) {
			 		$data = array(
			 			'section_name' => 'features',
			 			'images' => $value['image'],
			 		);
			 		if($id !=0):
			 			$this->admin_m->update($data,$id,'section_banners');
			 		else:
			 			$this->admin_m->insert($data,'section_banners');
			 		endif;
			 		
			 	}
			 	$this->session->set_flashdata('success',"Uploaded Successfully");
			 	redirect($_SERVER['HTTP_REFERER']);
			 else:
			 	$this->session->set_flashdata('error', $up_load['data']['error']);
			 	redirect($_SERVER['HTTP_REFERER']);
			 endif;
		 	
		}
 	}

 	public function item_delete($id,$table)
	{
		is_test();
		$del=$this->admin_m->delete($id,$table);
		if($del){
			$this->session->set_flashdata('success', 'Item Deleted');
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			$this->session->set_flashdata('error', 'Somthing worng. Error!!');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	/**===== Upload images dashboard ====**/
	public function upload_img($id,$table){
		is_test();
		if (!empty($_FILES['file']['name'])) {
	 		$up_load = $this->upload_m->upload(400);
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

	/**
	  ** Home page Team
	**/

	public function how_it_works()
	{
		$data = array();
		$data['page_title'] = "How It Works";
        $data['page'] = "Home";
        $data['data'] = false;
        $data['works'] = $this->admin_m->select('how_it_works');
		$data['main_content'] = $this->load->view('backend/admin_activities/how_it_works', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function edit_how_it_works($id)
	{
		$data = array();
		$data['page_title'] = "How It Works";
        $data['page'] = "Home";
        $data['data'] =$this->admin_m->single_select_by_id($id,'how_it_works');
        $data['works'] = $this->admin_m->select('how_it_works');
		$data['main_content'] = $this->load->view('backend/admin_activities/how_it_works', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	/**
	  *** add_reviews
	**/ 
	public function add_how_it_works(){
		is_test();
		$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
		$this->form_validation->set_rules('details', 'Details', 'trim|required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/home/how_it_works'));
		}else{	
			$data = array(
				'title' => $this->input->post('title',true),
				'details' => $this->input->post('details',true),
				'created_at' => d_time(),
			);
			$id = $this->input->post('id');
			if($id==0){
				$insert = $this->admin_m->insert($data,'how_it_works');
			}else{
				$insert = $this->admin_m->update($data,$id,'how_it_works');
			}

			if($insert){
				$this->upload_img($insert,$table='how_it_works');
				$this->session->set_flashdata('success', 'Save change Successfull');
				redirect(base_url('admin/home/how_it_works'));
			}else{
				$this->session->set_flashdata('error', 'Somethings were wrong');
				redirect(base_url('admin/home/how_it_works'));
			}	
		}
	}

	public function delete_img($id,$table)
	{
		is_test();
		$img = single_select_by_id($id,$table);
		$data = [
			'thumb' =>'',
			'images' => '',
		];
		$del= $this->admin_m->update($data,$id,$table);
		if($del):
			delete_image_from_server($img['thumb']);
			delete_image_from_server($img['images']);
			$msg = 'Successfully Deleted';
			echo json_encode(array('st' => 1, 'msg'=> $msg));
		endif;
	}


	public function delete_banner_img($id,$table)
	{
		is_test();
		$img = single_select_by_id($id,$table);
		$data = [
			'home_banner' =>'',
			'home_banner_thumb' => '',
		];
		$del= $this->admin_m->update($data,$id,$table);
		if($del):
			delete_image_from_server($img['home_banner']);
			delete_image_from_server($img['home_banner_thumb']);
			$msg = 'Successfully Deleted';
			echo json_encode(array('st' => 1, 'msg'=> $msg));
		endif;
	}

	public function delete_lang($id)
	{
		$this->load->dbforge();
		is_test();
		$row = single_select_by_id($id,'languages');
		
		
		if(!empty($row['slug'])){
			if ($this->db->field_exists($row['slug'], 'language_data'))
			{
			    $this->dbforge->drop_column('language_data', $row['slug']);
			}
			$del = $this->admin_m->delete($id,'languages');
			
		}
		$this->session->set_flashdata('success', lang('delete_success'));
		redirect($_SERVER['HTTP_REFERER']);
	}

		public function questions()
	{
		
		$data = array();
		$data['page_title'] = "Questions";
    $data['page'] = "Home";
    $data['data'] = false;
    $data['settings'] = $this->admin_m->get_user_settings();
    $data['question_list'] = $this->admin_m->select('question_list');
		$data['main_content'] = $this->load->view('backend/admin_activities/questions', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function edit_question($id)
	{
		
		$data = array();
		$data['page_title'] = "Questions";
    $data['page'] = "Home";
    $data['data'] = $this->admin_m->single_select_by_id($id,'question_list');
    $data['settings'] = $this->admin_m->get_user_settings();
    $data['question_list'] = $this->admin_m->select('question_list');
		$data['main_content'] = $this->load->view('backend/admin_activities/questions', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function add_questions(){

		$id = $this->input->post('id');
		$this->form_validation->set_rules('title', 'Title', 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/home/questions'));
		}else{	
			$data = [
				'title' => $this->input->post('title'),
				'user_id' => auth('id'),
			];

			if($id==0){
				$insert = $this->admin_m->insert($data,'question_list');
			}else{
				$insert = $this->admin_m->update($data,$id,'question_list');
			}

			if($insert){
				$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
				redirect(base_url('admin/home/questions'));
			}else{
				$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
				redirect(base_url('admin/home/questions'));
			}	
		}
	}

}

