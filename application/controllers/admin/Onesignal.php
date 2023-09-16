<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Onesignal extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        is_login();
        $data = array();
        $data['page_title'] = "Onesignal";
        $data['page'] = "Settings";
        $data['settings'] = $this->common_m->get_user_settings(auth('id'));

        $settings = $this->common_m->get_user_settings(auth('id'));
        $notification = !empty($settings['onesignal_config']) ? json_decode($settings['onesignal_config']) : "";
        if(isset($notification) && !empty($notification)):
	        $data['allUsers'] = $this->get_player_id($notification);
		endif;
        $data['main_content'] = $this->load->view('backend/users/onesignal', $data, TRUE);
        $this->load->view('backend/index', $data);
    }

    public function add_notification()
    {
        is_login();
        is_test();
        $this->form_validation->set_rules('onsignal_app_id', 'onsignal_app_id', 'trim|xss_clean');
        $this->form_validation->set_rules('user_auth_key', 'user_auth_key', 'trim|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $is_onsignal_active = $this->input->post('is_active_onsignal', TRUE);
            $is_order_push = $this->input->post('is_order_push', TRUE);
            $onsignal = array(
                'onsignal_app_id' => $this->input->post('onsignal_app_id', TRUE),
                'user_auth_key' => $this->input->post('user_auth_key', TRUE),
                'user_id' => $this->input->post('user_id', TRUE),
                'is_active_onsignal' => isset($is_onsignal_active) ? $is_onsignal_active : 0,
                'is_order_push' => isset($is_order_push) ? 1 : 0,
            );
            $data = array(
                'onesignal_config' => json_encode($onsignal),
            );

            if(check() !=1):
                exit();
            endif;


            $id = $this->input->post('id');
            if ($id == 0) {
                $insert = $this->admin_m->insert($data, 'user_settings');
            } else {
                $insert = $this->admin_m->update($data, $id, 'user_settings');
            }

            if ($insert) {
                $this->session->set_flashdata('success', !empty(lang('success_text')) ? lang('success_text') : 'Save Change Successful');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->session->set_flashdata('error', !empty(lang('error_text')) ? lang('error_text') : 'Somethings Were Wrong!!');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function get_users($user_id, $auth_id)
    {
        $find = $this->common_m->find_subscribers($user_id, $auth_id);
        if ($find == 0) {
            $this->common_m->insert(['user_id' => $user_id, 'auth_id' => $auth_id, 'created_at' => d_time()], 'subscriber_list');
        }
        echo json_encode(['st' => 1, 'userId' => $user_id]);
    }

    public function send_notification()
    {
        is_test();
        $this->form_validation->set_rules('headings', 'Headings', 'trim|required|xss_clean');
        $this->form_validation->set_rules('msg', 'Message', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        } else {

            $settings = $this->common_m->get_user_settings(auth('id'));
            $notification = !empty($settings['onesignal_config']) ? json_decode($settings['onesignal_config']) : "";

            $allUsers = $_POST['user_id'];
            $myUser = [];

            if (count($allUsers)  > 0) :
                 $myUser = $allUsers;
            else :
                $myUser = [];
            endif;
            
            $headings = $this->input->post('headings');
            $msg = $this->input->post('msg', true);
            $appId = $this->input->post('app_id', true);
            $url = $this->input->post('url', true);


            $headings      = array(
                "en" => $headings
            );

            $content      = array(
                "en" => $msg
            );


            $fields = array(
                'app_id' => $appId,
                // 'included_segments' => array(
                    // 'Subscribed Users'
                    // 'Active Users'
                    // '241c2987-7bda-46cb-990a-29687fc5a76f'
                    // 58090269-0d69-4768-8739-2560042c51f3
                // ),
                'include_player_ids' => $myUser,

                'data' => array(
                    "foo" => "bar"
                ),

                'contents' => $content,
                'headings' => $headings,
                'url' => !empty($url) ? $url : base_url(auth('username')),
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

                $this->session->set_flashdata('success', 'notifications_send_successfully');
                redirect($_SERVER['HTTP_REFERER']);
            else :
                 echo "<pre>";
                print_r($result);
                exit();
                $this->session->set_flashdata('error', lang('error_text'));
                redirect($_SERVER['HTTP_REFERER']);
            endif;
        }
    }
    
    public function get_player_id($notification){
        if(check() !=1):
            exit();
        endif;
        require_once('vendor/autoload.php');

            $client = new \GuzzleHttp\Client();
            try{
		        $response = $client->request('GET', "https://onesignal.com/api/v1/players?app_id={$notification->onsignal_app_id}&limit=100&offset=0", [
		              'headers' => [
		                'Accept' => 'text/plain',
		                'Authorization' => 'Basic '.$notification->user_auth_key,
		            ],
	        	]);
	        	$result = json_decode($response->getBody(),TRUE);
		    }catch(Exception $e){

		    }
	          
            $ids = [];
            if(isset($result) && !empty($result)):
	            foreach ($result['players'] as $key => $row) {
	                $ids[] = $row['id'];
	            }
	        endif;
            return !empty($ids)?$ids:[]; 

        }
    
    
    }
