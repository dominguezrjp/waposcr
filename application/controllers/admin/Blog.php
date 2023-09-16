<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {

	public function __construct(){
		parent::__construct();
		check_login_user();
		check_valid_user();
		is_valid();
	}


	public function index()
	{
		$data = array();
        $data['page_title'] = "Posts";
        $data['page'] = "Blog";
        $data['blogs'] = $this->blog_m->get_all_post();
        $data['main_content'] = $this->load->view('admin/dashboard/blog/post', $data, TRUE);
        $this->load->view('admin/index', $data);
	}


	public function add_post()
	{
		$data = array();
        $data['page_title'] = "Posts";
        $data['page'] = "Blog";
        $data['s_post'] = FALSE;
        $data['categories']= $this->admin_m->active_select('categories');
        $data['tags']= $this->admin_m->active_select('tags');
        $data['main_content'] = $this->load->view('admin/dashboard/blog/add_post', $data, TRUE);
        $this->load->view('admin/index', $data);
	}

	public function edit($id)
	{
		$data = array();
        $data['page_title'] = "Posts";
        $data['page'] = "Blog";
        $data['s_post'] = $this->admin_m->single_select_by_id($id,'post');
        $data['post_tags'] = $this->blog_m->get_post_tags($id);
        $data['categories'] = $this->admin_m->active_select('categories');
        $data['tags']= $this->admin_m->active_select('tags');
         valid_user($data['s_post']['user_id']);
        $data['main_content'] = $this->load->view('admin/dashboard/blog/add_post', $data, TRUE);
        $this->load->view('admin/index', $data);
	}

	public function add(){
		is_test();
		$id = $_POST['id'];
		$this->form_validation->set_rules('title', 'Title', 'trim|xss_clean|required',array('required'=>'Please Enter Title Name'));
		if(isset($id) && $id !=0){
			$this->form_validation->set_rules('slug', 'Slug', 'trim|xss_clean|required');
		}else{
			$this->form_validation->set_rules('slug', 'Slug', 'trim|xss_clean|required|is_unique[post.slug]',array('is_unique'=>'The slug must be unique'));
		}
		$this->form_validation->set_rules('details', 'Details', 'trim|required');
		$this->form_validation->set_rules('is_video', 'video / image', 'trim|required');
		$this->form_validation->set_rules('overview', 'Overview', 'trim|xss_clean|required');
		$this->form_validation->set_rules('cat_id', 'Category', 'trim|xss_clean|required');
		$this->form_validation->set_rules('tag_name', 'Tags', 'trim|xss_clean');

		

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('warning', validation_errors());
			$this->add_post();
		}else {

			

			

			if($id==0){
				$date = 'created_at';
			}else{
				$date = 'edited_at';
			}
			$is_video = $this->input->post('is_video');
			if(isset($is_video) && $is_video==1){
				$video_link = get_embeded($this->input->post('video_link'));
			}else{
				$video_link= $this->input->post('post_image',TRUE);
			}
			
			$data = array(
				'title' => $this->input->post('title',TRUE),
				'slug' => str_slug(trim($this->input->post('slug',TRUE))),	
				'details' => $this->input->post('details'),	
				'overview' => strip_tags($this->input->post('overview',TRUE)),	
				'cat_id' => $this->input->post('cat_id',TRUE),		
				'status' => $this->input->post('status',TRUE),	
				'post_type' => $this->input->post('post_type',TRUE),	
				'is_schedule' => 0,		
				'is_features' => 0,
				'image' => $video_link,	
				'thumb' => $video_link,	
				'is_video' => $is_video,	
				'user_id' => auth('id'),	
				$date => d_time(),	
			);

			
			if($id==0){
				$l_id = $this->blog_m->insert($data,'post');
			}else{

				if(isset($_POST['tag_name'])){
					$this->blog_m->tag_delete($id,"post_tags");
				}

				$l_id = $this->blog_m->update($data,$id,'post');
			}
			
			if($l_id){
			
				$this->upload_image($l_id);

				$tag_name=$this->input->post('tag_name[]');
				if(isset($_POST['tag_name'])):
					foreach($tag_name as $tag):
						$datas = array(
							'post_id' =>$l_id,
							'tag_id' =>$tag,
						);
					
					 	$this->blog_m->insert($datas,'post_tags');
					endforeach;
				endif;
			$this->session->set_flashdata("success", !empty(lang("success_text"))?lang("success_text"):"Save Change Successful");
			redirect(base_url('admin/post'));
			}else{
			$this->session->set_flashdata("error", !empty(lang("error_text"))?lang("error_text"):'Somethings Were Wrong!!');
			redirect(base_url('admin/post-add'));
			}
		}
		
	}


	



/**
  *** image upload script
**/
public function upload_image($id)
{
	is_test();
	    $data = array();
	    if (!empty($_FILES['file']['name'])) {
	        $filesCount = count($_FILES['file']['name']);
	        for ($i = 0; $i < $filesCount; $i++) {
	              $_FILES['file']['name'] = str_replace(",","_",$_FILES['file']['name'][$i]);
	              $_FILES['file']['type'] = $_FILES['file']['type'][$i];
	              $_FILES['file']['tmp_name'] = $_FILES['file']['tmp_name'][$i];
	              $_FILES['file']['error'] = $_FILES['file']['error'][$i];
	              $_FILES['file']['size'] = $_FILES['file']['size'][$i];
	              //Directory where files will be uploaded
	              $uploadPath = 'uploads/';
	              $config['upload_path'] = $uploadPath;
	              // Specifying the file formats that are supported.
	              $config['allowed_types'] = 'jpg|jpeg|png';
	              $config['overwrite'] = TRUE;
				  $config['encrypt_name'] = TRUE;
	              $this->load->library('upload', $config);
	              $this->upload->initialize($config);
	              // resize library
	              $this->load->library('image_lib');

	              if ($this->upload->do_upload('file')) {
	                  $fileData = $this->upload->data();
	                  $uploadData[$i]['file_name'] = $fileData['file_name'];
	                  // resize
			            $config = array(
						    'source_image'      => $fileData['full_path'],
						    'new_image'         => $uploadPath.'/thumb', //path to
						    'maintain_ratio'    => true,
						    'width'             => 600,
						    'height'            => 600
						);
						    $this->image_lib->initialize($config);
						    $this->image_lib->resize();
						// resize

	              }

	        }

	        if (!empty($uploadData)) {
	          $list=array();
	          foreach ($uploadData as $value) {
	          	$data = array(
	          		'image' => 'uploads/'.$value['file_name'],
	          		'thumb' => 'uploads/thumb/'.$value['file_name'],
	          	);
	          	$this->blog_m->update($data,$id,'post');

	          }
	    		
	  		}else{
	    	echo $msg = 'Please insert an image';
	    	
	    }

	}
}



public function post_delete($id){
	is_test();
	$del=$this->admin_m->delete($id,"post");
	if($del){
		$this->session->set_flashdata('success', 'Post Deleted');
		redirect(base_url('admin/blog'));
	}else{
		$this->session->set_flashdata('error', !empty(lang("error_text"))?lang("error_text"):"somethings were wrong");
		redirect(base_url('admin/blog'));
	}
}
	



	/*  Categories
	================================================== */
	public function categories()
	{
		$data = array();
		$data['page_title'] = "Blog Categories";
        $data['page'] = "Blog";
        $data['s_cat'] = FALSE;
        $data['categories'] = $this->admin_m->select_by_user('categories');
		$data['main_content'] = $this->load->view('admin/dashboard/blog/category', $data, TRUE);
		$this->load->view('admin/index',$data);
	}

	public function edit_category($id)
	{
		$data = array();
        $data['page_title'] = "Blog Categories";
        $data['page'] = "Blog";
        $data['s_cat'] = $this->admin_m->single_select_by_id($id,'categories');
        $data['categories'] = $this->admin_m->select_by_user('categories');
        valid_user($data['s_cat']['user_id']);
        $data['main_content'] = $this->load->view('admin/dashboard/blog/category', $data, TRUE);
        $this->load->view('admin/index', $data);
	}

	



	public function add_category(){
		is_test();
		$this->form_validation->set_rules('cat_name', 'Category', 'trim|xss_clean|required',array('required'=>'Please Enter Category Name'));
		$this->form_validation->set_rules('slug', 'Category', 'trim|xss_clean|required',array('required'=>'Please Enter Slug Name'));
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('warning', validation_errors());
			redirect(base_url('admin/categories'));
			 
		}else {
			$data = array(
			'cat_name' => $this->input->post('cat_name'),
			'slug' => str_slug(trim($_POST["slug"])),	
			'status' => $this->input->post('status'),	
			'user_id' => auth('id'),	
			'post_time' => d_time(),	
			);
			$id = $_POST['id'];
			if($id==0){
				$l_id = $this->admin_m->insert($data,'categories');
			}else{
				$l_id = $this->admin_m->update($data,$id,'categories');
			}
			
			if($l_id){
				$this->session->set_flashdata('success', !empty(lang("success_text"))?lang("success_text"):"Save Change Successful");
				redirect(base_url('admin/categories'));
			}else{
				$this->session->set_flashdata('error', !empty(lang("error_text"))?lang("error_text"):"somethings were wrong");
				redirect(base_url('admin/categories'));
			}
		}
		
	}
	public function delete_category($d_id){
		is_test();
		$this->admin_m->delete($d_id,"categories");
		$this->session->set_flashdata('error', 'Data deleted !!');
		redirect(base_url('admin/categories'));
	}


	/*  tags
	================================================== */

	public function tags()
	{
		$data = array();
        $data['page_title'] = "Tags";
        $data['page'] = "Blog";
        $data['s_cat'] = FALSE;
        $data['tags'] = $this->admin_m->select_by_user('tags');
        $data['main_content'] = $this->load->view('admin/dashboard/blog/tags', $data, TRUE);
        $this->load->view('admin/index', $data);
	}

	public function tag_edit($id)
	{
		$data = array();
        $data['page_title'] = "Tags";
        $data['page'] = "Blog";
        $data['s_cat'] = $this->admin_m->single_select_by_id($id,'tags');
        $data['tags'] = $this->admin_m->select_by_user('tags');
        valid_user($data['s_cat']['user_id']);
        
        $data['main_content'] = $this->load->view('admin/dashboard/blog/tags', $data, TRUE);
        $this->load->view('admin/index', $data);
	}

	public function tag_add(){
		is_test();
		$this->form_validation->set_rules('tag_name', 'Tags', 'trim|xss_clean|required',array('required'=>'Please Enter Tag Name'));
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('warning', validation_errors());
			redirect(base_url('admin/tags'));
			 
		}else {
			$data = array(
			'tag_name' => $this->input->post('tag_name'),	
			'slug' => str_slug(trim($this->input->post('tag_name'))),	
			'status' => $this->input->post('status'),
			'user_id' => auth('id'),
			'post_time' => d_time(),		
			);
			$id = $_POST['id'];
			if($id==0){
				$l_id = $this->admin_m->insert($data,'tags');
			}else{
				$l_id = $this->admin_m->update($data,$id,'tags');
			}
			
			if($l_id){
				$this->session->set_flashdata('success', !empty(lang("success_text"))?lang("success_text"):"Save Change Successful");
				redirect(base_url('admin/tags'));
			}else{
				$this->session->set_flashdata('error', !empty(lang("error_text"))?lang("error_text"):'Somethings Were Wrong!!');
				redirect(base_url('admin/tags'));
			}
		}
		
	}
	public function tag_delete($id){
		is_test();
		$this->admin_m->delete($id,"tags");
		$this->session->set_flashdata('error', 'Data deleted !!');
		redirect(base_url('admin/tags'));
	}

	public function change_status($id,$status,$table){
		is_test();
		$data =  array(
			'status' => $status,
		);
		$l_id = $this->admin_m->update($data,$id,$table);
		if($l_id){
				$this->session->set_flashdata('success', !empty(lang("success_text"))?lang("success_text"):"Save Change Successful");
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error', !empty(lang("error_text"))?lang("error_text"):"somethings were wrong");
				redirect($_SERVER['HTTP_REFERER']);
			}
	}














}
