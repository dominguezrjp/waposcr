<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vcard extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
	}

public function add_vcard_icon(){
	//check_login_user();
	$this->form_validation->set_rules('label[]', 'Label', 'trim|required|xss_clean');
	$this->form_validation->set_rules('value[]', 'Value', 'trim|required|xss_clean');
	if ($this->form_validation->run() == FALSE) {
		$this->session->set_flashdata('error', validation_errors());
		redirect(base_url('admin/profile/vcard'));
	}else{	
		if(isset($_POST['site_id']) && !empty($_POST['site_id'])):
			$i=1;
			foreach ($_POST['site_id'] as $key => $site) {
				$user_site = $this->admin_m->get_vcard_social_sites($site,auth('id'));
				$data = array(
					'site_id' => $site,
					'orders' => $i,
					'label' => $this->input->post('label',true)[$site],
					'value' => $this->input->post('value',true)[$site],
					'user_id' => auth('id'),
				);
				$i++;
				if($user_site['site_id']==$site){
					$insert = $this->admin_m->update($data,$user_site['id'],'vcard_social_sites');
				}else{
					$insert = $this->admin_m->insert($data,'vcard_social_sites');
				}
			}
		endif;

		if($insert){
			$msg = !empty(lang('success_text'))?lang('success_text'):'Save Change Successful';
			echo json_encode(['st'=>1,'msg'=>$msg]);
		}else{
			$msg = !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!';
			echo json_encode(['st'=>0,'msg'=>$msg]);
		}	
	}
}

public function install_addons()
{

	$data = array(
		'title' => 'Vcard Drag and Drop / Vcf file | Add Ons',
		'slug' => 'drag-vcard-vcf',
		'is_install' => 1,
		'status' => 1,
		'created_at' => d_time(),
	);
	$edit = $this->admin_m->update($data,1,'addons');
	if($edit){
		$this->session->set_flashdata('success', 'Addons  Active Now');
		redirect($_SERVER['HTTP_REFERER']);
	}else{
		$this->session->set_flashdata('error', 'Somthing worng. Error!!');
		redirect($_SERVER['HTTP_REFERER']);
	}

}

	function load_vcard($username)
    {

        $user = get_user_info_by_slug($username);
        $card_data = array();
        $card_data['display_name'] = !empty($user['full_name'])?$user['full_name']:$user['username'];
        $card_data['username'] = !empty($user['username'])?$user['username']:$home['full_name'];
        $card_data['additional_name'] = !empty($user['full_name'])?$user['full_name']:$user['full_name']; //Middle name
        // $card_data['name_prefix'] = "Mr.";  //Mr. Mrs. Dr.
        $card_data['name_suffix'] = ''; //DDS, MD, III, other designations.

        /*
        Contact's company, department, title, profession
        */
        //$card_data['department'] = "";
        $card_data['title'] = !empty($user['designation'])?$user['designation']:'';
        $card_data['role'] = !empty($user['designation'])?$user['designation']:'';

        /*
        Contact's work address
        */
        /*
        Contact's home address
        */
        //$card_data['home_po_box'] = "";
        //$card_data['home_extended_address'] = "";
        $card_data['home_address'] = !empty($user['address'])?$user['address']:'';
        /*
        Contact's telephone numbers.
        */
        $card_data['home_tel'] = !empty($user['phone'])?$user['phone']:'';
        $card_data['office_tel'] = !empty($user['whatsapp'])?$user['whatsapp']:'';

        /*
        Contact's email addresses
        */
        $card_data['email1'] = !empty($user['email'])?$user['email']:'';

        /*
        Contact's website
        */
        $card_data['url'] = !empty($user['website'])?$user['website']:'';
        $card_data['photo'] = !empty($user['thumb'])?$user['thumb']:'';

        /*
        Some other contact data.
        */
        //$card_data['photo'] = "";  //Enter a URL.
        $card_data['birthday'] = !empty($home['dob'])?$home['dob']:'';
        // $card_data['timezone'] = "-05:00";

        /*
        /*
        Now we load up the library.
        */

        $this->load->library('vcard_lib');

        // $data = array(
        //     'total_download' => $user['total_download'] + 1,
        // );
        // $this->common_m->update($data,$user['id'],'users');
        /*
        Load the $card_data array into the library
        */
        $this->vcard_lib->load($card_data,$card_data['username']);
        
        $this->vcard_lib->generate_download($card_data['username']);
       
        
    }

}