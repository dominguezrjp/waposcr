<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $user = $this->admin_m->get_empty_admin();
        if ($user == 1) {
            $this->login();
        } else {
            $this->create();
        }
    }

    public function login()
    {
        $this->redirectUrl('login');
        $data = array();
        $data['page_title'] = "Login";
        $data['page'] = "Login";
        $data['main_content'] = $this->load->view('frontend/login/login', $data, true);
        $this->load->view('frontend/index', $data);
    }



    public function create()
    {
        $data = array();
        $data['page_title'] = "Login";
        $data['page'] = "Login";
        $data['main_content'] = $this->load->view('frontend/login/create_admin', $data, true);
        $this->load->view('frontend/index', $data);
    }

    public function custom_login($id)
    {
        if (auth('user_role')==1) :
            $user =  single_select_by_id($id, 'users');
            $query = $this->admin_m->user_login_info_check($user['username'], $user['password']);

            if ($query) {
                $s_array= array();
                foreach ($query as $row) :
                    $s_array = array(
                        'id' => $row->id,
                        'username' => $row->username,
                        'email' => $row->email,
                        'user_role' => $row->user_role,
                        'is_active' => $row->is_active,
                        'is_verify' => $row->is_verify,
                        'account_type' => $row->account_type,
                        'is_login' => true,
                        'user_login' => true,
                        'login_admin' => true,
                        'is_user' => true,
                        'is_auth' => false,
                        'is_staff' => false,
                        'is_customer' => false,
                        'is_admin_staff' => false,
                        'is_delivery' => false,
                        'admin_staff' => false,
                        'admin_staff' => false,
                    );

                    if ($row->is_active == 1) :
                        $this->session->set_userdata($s_array);
                        $data =array(
                            'last_login' => d_time()
                        );
                        $this->admin_m->update($data, $row->id, 'users');

                        $this->version_changes_m->insert_features($row->id);

                            //add order_types
                        $this->version_changes_m->add_order_types($row->id);

                            //add qr code
                        $this->version_changes_m->qr_code($row->username);



                        redirect(base_url('admin/dashboard'));
                    endif; //con_login_end
                endforeach;
            };
        else :
            redirect($_SERVER['HTTP_REFERER']);
        endif;
    }

    /**
  *** login action
**/
    public function user_login()
    {
        $this->session->unset_userdata(['table_no','temp_data','d_auth','cData']);
        $this->form_validation->set_rules('email', 'Email / Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', lang('password'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $msg = '<div class="alert alert-danger alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong><i class="fas fa-frown"></i> '.lang("sorry").' </strong> '.validation_errors().'
		</div>';
            echo json_encode(array('st' => 0, 'msg'=> $msg,));
        } else {
            $setting = settings();

            if (isset($setting['is_recaptcha']) && $setting['is_recaptcha']==1) :
                if ($this->recaptcha()==false) {
                    $msg = '<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong><i class="fas fa-frown"></i> '.lang("sorry").' </strong> '.lang("robot_verification_failed").'
				</div>';
                    echo json_encode(array('st' => 0, 'msg'=> $msg));
                    exit();
                }
            endif;
            // get settings
        
            $email = strtolower($this->input->post('email', true));
            $password = $this->input->post('password', true);
            $query = $this->admin_m->check_login_info($email, $password); //check email / user name and password
    
            if ($query['result']==1) {
                $msg = '<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong><i class="fas fa-frown"></i> Sorry! </strong> Password is not correct! <i class="fa fa-frown-o" ></i>
				</div>';
                echo json_encode(array('st' => 0, 'msg'=> $msg));
            } elseif ($query['result']==0) {
                $msg = '<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong><i class="fas fa-frown"></i> '.lang('sorry').' </strong> '.lang('login_invalid').' <i class="fa fa-frown-o" ></i>
				</div>';
                echo json_encode(array('st' => 0, 'msg'=> $msg));
            } elseif (is_array($query['result'])) {
                $s_array= array();
                foreach ($query['result'] as $row) :
                    $s_array = array(
                        'id' => $row->id,
                        'username' => $row->username,
                        'email' => $row->email,
                        'phone' => $row->phone,
                        'user_role' => $row->user_role,
                        'is_active' => $row->is_active,
                        'is_verify' => $row->is_verify,
                        'account_type' => $row->account_type,
                        'is_login' => true,
                    );


                    if ($row->is_active == 1) :
                        if ($row->user_role==1 && isset($this->settings['is_custom_domain']) && $this->settings['is_custom_domain']==1) :
                            $current_domain = check_domain($this->url);
                            if ($this->check_domain['is_folder']==0 && ($this->check_domain['site_url'] !== $current_domain['site_url'])) :
                                $msg = '<div class="alert alert-danger alert-dismissible">
									<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
									<strong><i class="fas fa-frown"></i> Sorry! </strong> Invalid URL / Domain <i class="fa fa-frown-o" ></i>
									</div>';
                                    echo json_encode(array('st' => 0, 'msg'=> $msg));
                                    exit();
                            endif;
                        endif;

                        $url = base_url('admin/dashboard');
                        
                        $this->session->set_userdata($s_array);
                        $data =array(
                            'last_login' => d_time()
                        );
                        if ($row->user_role==1) :
                            $this->site_qr();
                            $this->session->set_userdata('is_auth', true);
                        else :
                            //add features
                            $this->version_changes_m->insert_features($row->id);

                            //add order_types
                            $this->version_changes_m->add_order_types($row->id);

                            //add qr code
                            $this->version_changes_m->qr_code($row->username);

                            $this->session->set_userdata('is_user', true);
                        endif;
                        
                        $this->admin_m->update($data, $row->id, 'users');
                        $msg = '<div class="alert alert-success alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong><i class="far fa-smile"></i> '.lang('welcome').' ! </strong> '.lang('login_success').'

						</div>';
                        echo json_encode(array('st' => 1, 'msg'=> $msg, 'url'=> $url));
                        exit();
                    else : //check active
                            $msg = '<div class="alert alert-danger alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong><i class="far fa-smile-wink"></i> Sorry! </strong> Your account is not approved <i class="fa fa-frown-o"></i>
						</div>';
                            echo json_encode(array('st' => 0, 'msg'=> $msg));
                            exit();
                    endif;
                endforeach;
            }
        }
        //end validation
    }



    protected function siteURL()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domainName = $_SERVER['HTTP_HOST'] . '/';
        return $protocol . $domainName;
    }

    public function signup()
    {
    
        $data = array();
        $data['page_title'] = "SignUp";
        $data['page'] = "Login";
        $data['main_content'] = $this->load->view('frontend/login/signup', $data, true);
        $this->load->view('frontend/index', $data);
    }

    public function package_signup($slug)
    {
        $data = array();
        $data['page_title'] = "SignUp";
        $data['page'] = "Login";
        $data['slug'] = $slug;
        $data['all_features'] = $this->common_m->select_with_status('features');
        $data['package'] = $this->common_m->get_package_details_by_slug($slug);
        if (empty($data['package'])) {
            redirect(base_url());
        }
        $data['main_content'] = $this->load->view('frontend/login/signup_with_package', $data, true);
        $this->load->view('frontend/index', $data);
    }

    public function forgot()
    {
        $data = array();
        $data['page_title'] = "Forgot";
        $data['page'] = "Login";
        $data['main_content'] = $this->load->view('frontend/login/forgot', $data, true);
        $this->load->view('frontend/index', $data);
    }



/**
  ** recover password
**/
    public function recovery_password()
    {
        is_test();
        $this->form_validation->set_rules('email', lang("email"), 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $msg = '<div class="alert alert-danger alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong><i class="fas fa-frown"></i> Sorry! </strong> '.validation_errors().'
		</div>';
            echo json_encode(array('st' => 0, 'msg'=> $msg,));
            exit();
        } else {
            $check_email = $this->admin_m->check_valid_email(strtolower(trim($this->input->post('email', true))));
            if (!$check_email) {
                $msg = '<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong><i class="fas fa-frown"></i> '.lang("sorry").' </strong>Your email is not Correct!
			</div>';
                echo json_encode(array('st' => 0, 'msg'=> $msg,));
                exit();
            }

            if ($check_email) {
                $data = array();
                $random_number = random_string('numeric', 4);
                $data['username'] = $check_email['username'];
                $data['email'] = $check_email['email'];
                $data['password'] = $random_number;

                if (isset($this->settings['is_dynamic_mail']) && $this->settings['is_dynamic_mail']==1) :
                    $mailData =  [
                        'site_name' => $this->settings['site_name'],
                        'password' => $random_number,
                        'username' => $check_email['username'],
                    ];
                    $send = $this->email_m->send_global_mail($mailData, $check_email['email'], 'recovery_mail');
                else :
                        $send = $this->email_m->send_recovery_mail($data); // call mail function
                endif;


                if ($send==true) :
                    $users = array('password' => md5($random_number));
                    $this->admin_m->update($users, $check_email['id'], 'users');

                    $msg = '<div class="alert alert-success alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong><i class="fas fa-check"></i> '.lang("success").' </strong> '.lang("success_text").'  
				</div>';
                    echo json_encode(array('st' => 1, 'msg'=> $msg,'url'=>base_url('login')));
                else :
                        $msg = '<div class="alert alert-danger alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>'.lang("sorry").' </strong> '.lang("error_text").'
					</div>';
                        echo json_encode(array('st' => 0, 'msg'=> $msg,));
                endif;
            }
        }
    }
/**
   ***
**/



    public function user_registration($slug = '')
    {
        $this->form_validation->set_rules('name', lang('name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('username', lang('username'), 'trim|required|xss_clean|callback_english_check');
        $this->form_validation->set_rules('email', lang('email'), 'trim|required|xss_clean|valid_email|is_unique[users.email]', array('is_unique'=>'The email is already Exists'));
        
        $this->form_validation->set_rules('password', lang("password"), 'trim|required|xss_clean|min_length[3]');
        $this->form_validation->set_rules('cpassword', lang("confirm_password"), 'trim|required|xss_clean|matches[password]');
        $this->form_validation->set_rules('terms', lang('terms_condition'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('phone', lang("phone"), 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $msg = '<div class="alert alert-danger alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong><i class="fas fa-frown"></i> '.lang("sorry").' </strong> '.validation_errors().'
		</div>';
            echo json_encode(array('st' => 0, 'msg'=> $msg,));
        } else {
            $trial_package = $this->admin_m->get_trail_package_id(0);
            if (isset($slug) && !empty($slug)) :
                $package = get_info_by_package_slug($slug);
                if (!empty($package)) {
                    $account_type = $package['id'];
                    $type = $package['package_type'];
                    $package_info = $package;
                } else {
                    $msg = '<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong><i class="fas fa-frown"></i> Sorry ! </strong> Package is not valid. Try again!!
				</div>';
                    echo json_encode(array('st' => 0, 'msg'=> $msg,));
                }//end check valid package
            elseif (isset($trial_package) && !empty($trial_package['package_type'])) :
                $account_type = $trial_package['id'];
                $type = $trial_package['package_type'];
                $package = $trial_package;
                $package_info = $trial_package;
            else :
                $account_type = 0;
                $type = 'trial';
                $package = ['package_name' =>'Trial'];
            endif;
            /*----------------------------------------------
                        End checking trial package
            ----------------------------------------------*/
            $check_staff_email = $this->common_m->check_staff_mail($_POST['email']);


            if ($check_staff_email==1) :
                $msg = '<div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong><i class="fas fa-frown"></i> Sorry ! </strong> This Email <b>'.$_POST['email'].'</b> already exists for staff!!
			</div>';
                echo json_encode(array('st' => 0, 'msg'=> $msg,));
                exit();
            endif;

            /*----------------------------------------------
                        Check Valid Username
            ----------------------------------------------*/
            $username_check = $this->admin_m->check_username(str_slug($this->input->post('username', true)));

            if ($username_check==1) {
                $msg = '<div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong><i class="fas fa-frown"></i> '.lang("sorry").' ! </strong>  <b>'.str_slug($this->input->post('username', true)).'</b>'.lang("username_already_exists").'
			</div>';
                echo json_encode(array('st' => 0, 'msg'=> $msg,));
                exit();
            } else { //check user's username else
                /*----------------------------------------------
                            CHECK RECAPTCHA
                ----------------------------------------------*/

                if (isset($this->settings['is_recaptcha']) && $this->settings['is_recaptcha']==1) :
                    if ($this->recaptcha()==false) {
                        $msg = '<div class="alert alert-danger alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong><i class="fas fa-frown"></i> '.lang("sorry").' </strong> '.lang("robot_verification_failed").'
					</div>';
                        echo json_encode(array('st' => 0, 'msg'=> $msg));
                        exit();
                    }
                endif;

                /*----------------------------------------------
                            END CHECK RECAPTCHA
                ----------------------------------------------*/

                $this->settings['auto_approval']==1?$approve = 1:$approve=0;
                $this->settings['is_email_verification']==1?$verify=0:$verify=1;
                $is_payment =0;

                $username = str_slug($this->input->post('username', true));
                $country_code = $this->input->post('country_code', true);
                $country_info = $this->admin_m->get_country_info($country_code);


                if (is_demo() == 1) :
                    $data = array(
                    'account_type' => $account_type,
                    'username' =>$username,
                    'name' =>$this->input->post('name', true),
                    'email' => $this->input->post('email', true),
                    'phone' => $this->input->post('phone', true),
                    'dial_code' => $this->input->post('dial_code', true),
                    'password' => md5($this->input->post('password', true)),
                    'country' => !empty($country_info)?$country_info->id:0,
                    'is_active' => 1,
                    'is_verify' => 1,
                    'is_payment' => 1,
                    'created_at' => d_time(),
                    'end_date' => add_year('fifteen'),
                    );
                    $insert = $this->admin_m->insert($data, 'users');

                    if ($insert) :
                        $shop_data = array(
                        'user_id' => $insert,
                        'shop_id' => random_string('alnum', 6),
                        'username' => $username,
                        'created_at' => d_time(),
                        );
                        $this->admin_m->insert($shop_data, 'restaurant_list');
                        $this->insert_features($insert);
                    endif;

                    $msg = '<div class="alert alert-success alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<p><strong><i class="far fa-smile"></i> '.lang("congratulations").'! </strong> '.lang("account_create_successfully").'</p>
						<p>'.lang("please_login_to_continue").'. </p>
						</div>';
                    echo json_encode(array('st' => 1, 'msg'=> $msg,'url'=> base_url('login')));
                    exit();
                else :
                    $data = array(
                    'account_type' => $account_type,
                    'username' =>$username,
                    'name' =>$this->input->post('name', true),
                    'email' => $this->input->post('email', true),
                    'phone' => $this->input->post('phone', true),
                    'dial_code' => $this->input->post('dial_code', true),
                    'password' => md5($this->input->post('password', true)),
                    'country' => !empty($country_info)?$country_info->id:0,
                    'is_active' => $approve,
                    'is_verify' => $verify,
                    'is_payment' => $is_payment,
                    'created_at' => d_time(),
                    );
                endif;

                $insert = $this->admin_m->insert($data, 'users');

                if ($insert) :
                    /*----------------------------------------------
                                CREATE RESTAURANT
                    ----------------------------------------------*/
                    $shop_data = array(
                    'user_id' => $insert,
                    'shop_id' => $insert.random_string('alnum', 6),
                    'username' => $username,
                    'created_at' => d_time(),
                    );
                    $this->admin_m->insert($shop_data, 'restaurant_list');
                    /*----------------------------------------------
                                END CREATE RESTAURANT
                    ----------------------------------------------*/

                    /*----------------------------------------------
                                Create Settings
                    ----------------------------------------------*/

                    $this->admin_m->insert(['user_id' => $insert], 'user_settings');

                    /*----------------------------------------------
                                TRIAL PACKAGE
                    ----------------------------------------------*/
                
                    $trial_options = ['trial','weekly','fifteen'];
                    if (in_array($type, $trial_options)) :
                        if ($this->settings['is_auto_verified']==1) : //auto approver trail user
                            $trial_active = array(
                            'is_payment'=>1,
                            'is_verify'=>$verify,
                            'is_active'=>1,
                            'start_date'=>d_time(),
                            'verify_time'=>d_time(),
                            'end_date'=>add_year($type, $package_info['duration'], $package_info['duration_period']),
                            );
                        else :
                            $trial_active = array(
                            'is_payment'=>1,
                            'is_verify'=>$verify,
                            'is_active'=>0,
                            'start_date'=>d_time(),
                            'verify_time'=>d_time(),
                            'end_date'=>add_year($type, $package_info['duration'], $package_info['duration_period']),
                            );
                        endif;
                        $this->admin_m->update($trial_active, $insert, 'users');
                    endif; //in_array($type, $trial_options)


                    /*----------------------------------------------
                                TYPE == FREE
                    ----------------------------------------------*/

                    if ($type=='free') :
                        if ($this->settings['is_email_verify_free']==0) :
                            $trial_active = array(
                            'is_payment'=>1,
                            'is_verify'=>1,
                            'is_active'=>1,
                            'start_date'=>d_time(),
                            'verify_time'=>d_time(),
                            'end_date'=>add_year($type, $package_info['duration'], $package_info['duration_period']),
                            );
                        else :
                            $trial_active = array(
                            'is_payment'=>1,
                            'is_verify'=>0,
                            'is_active'=>1,
                            'start_date'=>d_time(),
                            'verify_time'=>d_time(),
                            'end_date'=>add_year($type, $package_info['duration'], $package_info['duration_period']),
                            );
                        endif;
                        $this->admin_m->update($trial_active, $insert, 'users');
                    endif;

                    /*----------------------------------------------
                                END TYPE == FREE
                    ----------------------------------------------*/



                    /*----------------------------------------------
                                IF Payment ==1
                    ----------------------------------------------*/

                    if ($data['is_payment']==1 || (isset($trial_active['is_payment']) &&  $trial_active['is_payment']==1)) :
                        $this->default_m->add_payment(['user_id'=>$insert], $package_info, 0);
                    endif;


                    // is_auto_verified == auto approved trial
                    //is_email_verify_free ==  free user verify
                    //is_email_verification ==  email_verify
                    $congratulations = lang('congratulations');
                    $account_create_successfully = lang('account_created_successfully'); //Account Created Successfully
                    $account_confirmation_link_msg = lang('account_confirmation_link_msg'); //The account confirmation link has been emailed to you, follow the link in the email to continue.
                    $please_login_to_continue = lang('please_login_to_continue'); //Please Login to continue.

                    if ($type=='free') :
                        if ($this->settings['is_email_verify_free']==1) :
                            $msg = "<div class='alert alert-success alert-dismissible'>
						<a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<p><strong><i class='far fa-smile'></i>{$congratulations}  </strong>{$account_create_successfully}</p>
						<p>{$account_confirmation_link_msg}</p>
						</div>";
                            $this->email_verification($data, $this->input->post('password', true), $package);
                        else :
                            $msg = "<div class='alert alert-success alert-dismissible'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<p><strong><i class='far fa-smile'></i> {$congratulations} </strong>{$account_create_successfully}</p>
						<p>{$please_login_to_continue} </p>
						</div>";
                        endif;
                    else :
                        if ($this->settings['is_email_verification']==1) :
                            $msg = "<div class='alert alert-success alert-dismissible'>
						<a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<p><strong><i class='far fa-smile'></i>{$congratulations}  </strong>{$account_create_successfully}</p>
						<p>{$account_confirmation_link_msg}</p>
						</div>";
                            $this->email_verification($data, $this->input->post('password', true), $package);
                        else :
                            $msg = "<div class='alert alert-success alert-dismissible'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<p><strong><i class='far fa-smile'></i> {$congratulations} </strong>{$account_create_successfully}</p>
						<p>{$please_login_to_continue} </p>
						</div>";
                        endif;
                    endif;


                


                    $u_info = get_all_user_info_slug($data['username']);
                    $this->insert_features($insert);


                    if (isset($this->settings['user_invoice']) && $this->settings['user_invoice'] ==1) :
                        if ($type !='monthly' && $type !='yearly') :
                        else :
                            $this->send_invoice_mail($u_info);
                        endif;
                    endif;

                    if (isset($this->settings['new_user_mail']) && $this->settings['new_user_mail'] ==1) :
                        $this->new_user_mail($data, $package); //send a email to admin
                    endif;

                    echo json_encode(array('st' => 1, 'msg'=> $msg,'url'=> base_url('login')));
                else :
                    $msg = '<div class="alert alert-danger alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong><i class="fas fa-frown"></i> '.lang('sorry').' </strong> '.lang("error_text").'
					</div>';
                    echo json_encode(array('st' => 0, 'msg'=> $msg,));
                endif; //if insert
            } //check user's username
        }// end form validation
    } //end class

    public function text_email_verification()
    {
        $data = [
        'username' => 'phplime',
        'email' => 'phplime.envato@gmail.com',
        'package_name'=> 'basic',
        'price'=>'50'
        ];
        $package = ['package_name'=>'basic'];
        $password = '1234';
        // $send = $this->email_verification($data,$password,$package);
        // $send = $this->send_invoice_mail($data);
        $send = $this->new_user_mail($data, $package);
        echo "<pre>";
        print_r($send);
        exit();
    }

    protected function new_user_mail($u_info, $package)
    {
        if (isset($this->settings['is_dynamic_mail']) && $this->settings['is_dynamic_mail']==1) :
            $mailData =  [
            'site_name' => $this->settings['site_name'],
            'username' => $u_info['username']??'',
            'package_name' => $u_info['package_name']??'',
            'email' => $u_info['email']??'',
            ];
            $send = $this->email_m->send_global_mail($mailData, $this->settings['smtp_mail'], 'new_user_mail');
        else :
            $send = $this->email_m->account_create_invoice(new_user_mail($u_info, $package)); //send invoice mial
        endif;
    }

    protected function send_invoice_mail($u_info)
    {
        if (isset($this->settings['is_dynamic_mail']) && $this->settings['is_dynamic_mail']==1) :
            $mailData =  [
            'site_name' => $this->settings['site_name'],
            'username' => $u_info['username']??'',
            'package_name' => $u_info['package_name']??'',
            'price' => $u_info['price']??'',
            'email' => $u_info['email']??'',
            ];
            $send = $this->email_m->send_global_mail($mailData, $mailData['email'], 'account_create_invoice');
        else :
            $send = $this->email_m->account_create_invoice($u_info['username']); //send invoice mial
        endif;
    }

    protected function email_verification($data, $password, $package)
    {
        if (isset($this->settings['is_dynamic_mail']) && $this->settings['is_dynamic_mail']==1) :
            $mailData =  [
            'site_name' => $this->settings['site_name'],
            'username' => $data['username']??'',
            'email' => $data['email']??'',
            'package_name' => $package['package_name']??'',
            'password' => $password??'',
            'verify_link' => '<a href='.base_url("login/verify/{$data['username']}").'>'.base_url("login/verify/{$data['username']}").'</a>',
            ];
            $send = $this->email_m->send_global_mail($mailData, $mailData['email'], 'email_verification_mail');
        else :
            $send = $this->email_m->email_verification_mail($data, $this->input->post('password', true), $package);
        endif;
    }

//check english string for username
    public function english_check($string)
    {
        if (preg_match('/[^A-Za-z0-9 ]/', $string)) {
            //string contains only letters from the English alphabet
            $this->form_validation->set_message('english_check', 'The {field} field contains only letters from the English alphabet.');
            return false;
        } else {
            return true;
        }
    }

//check recaptcha
    public function recaptcha()
    {
        $settings =  settings();
        $recaptchaResponse = trim($this->input->post('g-recaptcha-response'));
        $userIp=$this->input->ip_address();
        $secret = $this->settings['recaptcha']->secret_key;

        $url="https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$recaptchaResponse."&remoteip=".$userIp;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
     
        $status= json_decode($output, true);
        if ($status['success']) {
            return true;
        } else {
            return false;
        }
    }


// check username when registration
    public function check_username($username)
    {
        header('Content-type: text/html; charset=utf-8');
        $username = str_slug($username);
        $check = $this->admin_m->check_username(urldecode($username));
        if ($check==1) {
            $msg = '<i class="fas fa-frown"></i> '.lang('sorry').'!'.lang('username_already_exists');
            $st =0;
        } else {
            $msg = '<i class="fas fa-check"></i> '.lang('username_is_available');
            $st =1;
        }

        $response = ['st'=>$st,'msg'=>$msg];
        echo json_encode($response);
    }

/*----------------------------------------------
Features for all user
----------------------------------------------*/
    public function insert_features($user_id)
    {
        $fetaures = $this->admin_m->select('features');
        $check_feature = $this->admin_m->select_all_by_user_id($user_id, 'users_active_features');

        if (count($check_feature) == 0) {
            foreach ($fetaures as $key => $row) {
                $data =  array(
                'feature_id' => $row['id'],
                'user_id' => $user_id,
                'status' => 1
                );
                $this->admin_m->insert($data, 'users_active_features');
            }
        } elseif (count($check_feature) == count($fetaures)) {
            return true;
        } elseif (count($check_feature) < count($fetaures)) {
            foreach ($fetaures as $key => $row) {
                $feature_id = $this->admin_m->get_users_active_features($row['id'], $user_id);
            
                if ($feature_id['feature_id']!=$row['id']) {
                    $data =  array(
                    'feature_id' => $row['id'],
                    'user_id' => $user_id,
                    'status' => 1
                    );
                    $this->admin_m->insert($data, 'users_active_features');
                }
            }
        }
    
        return true;
    }


/*----------------------------------------------
    Order Types for all users
----------------------------------------------*/

    public function add_order_types($user_id)
    {
        $fetaures = $this->admin_m->select_with_status('order_types');
        $check_feature = $this->admin_m->select_all_by_user_id($user_id, 'users_active_order_types');
        $shop_id = isset(restaurant($user_id)->id)?restaurant($user_id)->id:0;
        if (count($check_feature) == 0) {
            foreach ($fetaures as $key => $row) {
                $data =  array(
                'type_id' => $row['id'],
                'user_id' => $user_id,
                'shop_id' => $shop_id,
                'status' => 1,
                'created_at' => d_time(),

                );
                $this->admin_m->insert($data, 'users_active_order_types');
            }
        } elseif (count($check_feature) == count($fetaures)) {
            return true;
        } elseif (count($check_feature) < count($fetaures)) {
            foreach ($fetaures as $key => $row) {
                $feature_id = $this->admin_m->get_users_active_order_types($row['id'], $user_id);
            
                if ($feature_id['type_id']!=$row['id']) {
                    $data =  array(
                    'type_id' => $row['id'],
                    'user_id' => $user_id,
                    'status' => 1,
                    'shop_id' => $shop_id,
                    'created_at' => d_time(),
                    );
                    $this->admin_m->insert($data, 'users_active_order_types');
                }
            }
        }
    
        return true;
    }



    /**
      ** Account verify by user from email link
    **/

    public function verify($username)
    {
        $u_info = get_all_user_info_slug($username);
        if ($u_info['is_verify']==1) :
            $this->session->set_flashdata('verify', 'Your account already verified');
            if (auth('is_login')==true) :
                redirect(base_url('admin/dashboard'));
            else :
                redirect(base_url('login'));
            endif;
        else :
            $trial_options = ['trial','weekly','fifteen','free'];

            if (in_array($u_info['package_type'], $trial_options)  || $u_info['account_type'] == 0) :
                isset($u_info['account_type']) && $u_info['account_type']==0?$end_date = add_year('monthly'): $end_date = add_year($u_info['package_type']);

                $data = array('is_verify'=>1,'is_payment'=>1,'is_active'=>1,'verify_time'=>d_time(),'start_date'=>d_time(),'end_date'=>$end_date);
                $this->admin_m->update_by_username($data, $username, 'users');
            
                $this->session->set_flashdata('verify', lang('account_verified_successfully'));
                if (auth('is_login')==true) :
                    redirect(base_url('admin/dashboard'));
                else :
                    redirect(base_url('login'));
                endif;
            else :
                $data = array('is_verify'=>1, 'is_payment'=>0, 'verify_time'=>d_time(),'start_date'=>d_time());
                $this->admin_m->update_by_username($data, $username, 'users');
                $this->session->set_flashdata('verify', lang('account_verified_successfully'));

                // after verify by mail redirect to payment method
                if (auth('is_login')==true) :
                    redirect(base_url('payment-method/'.$username.'/'.$u_info['slug']));
                else :
                    redirect(base_url('login'));
                endif;
            endif;
        endif;
    }





    public function qr_code($username)
    {

        $check = get_user_info_by_slug($username);
        if (empty($check['qr_link']) || !file_exists($check['qr_link'])) :
            $this->load->library('ciqrcode');
            $qr_image=$username.'_'.rand().'.png';
            $params['data'] = base_url($username);
            $params['level'] = 'H';
            $params['size'] = 8;
            $params['savename'] =FCPATH."uploads/qr_image/".$qr_image;
            if ($this->ciqrcode->generate($params)) {
                $data = array(
                'qr_link' =>'uploads/qr_image/'.$qr_image,
                );
                $update = $this->admin_m->update_by_username($data, $username, 'users');
                return true;
            }
        endif;
        return true;
    }




    public function site_qr()
    {

        $check = settings();
        if (empty($check['site_qr_link']) || !file_exists($check['site_qr_link'])) :
            $this->load->library('ciqrcode');
            $qr_image='site_qr_'.rand().'.png';
            $params['data'] = base_url('sign-up');
            $params['level'] = 'H';
            $params['size'] = 8;
            $params['savename'] =FCPATH."uploads/qr_image/".$qr_image;
            if ($this->ciqrcode->generate($params)) {
                $data = array(
                'site_qr_link' =>'uploads/qr_image/'.$qr_image,
                );
                $update = $this->admin_m->update($data, $check['id'], 'settings');
                return true;
            }
        endif;
        return true;
    }




    public function create_admin()
    {
        is_test();
        $this->form_validation->set_rules('code', 'Purchases Code', 'trim|required|xss_clean');
        $this->form_validation->set_rules('site_id', 'Site Id Code', 'trim|required|xss_clean');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|is_unique[users.username]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email|is_unique[users.email]', array('is_unique'=>'The email is already Exists'));
        $this->form_validation->set_rules('password', 'password', 'trim|required|xss_clean|min_length[3]');

        $this->form_validation->set_rules('cpassword', 'Confirm password', 'trim|required|xss_clean|matches[password]');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', validation_errors());
            redirect(base_url('login'));
        } else {
            $email = $this->input->post('email', true);
            $password = md5($this->input->post('password', true));
            $code = $this->input->post('code', true);
            $site_id = $this->input->post('site_id', true);


            $check_valid = $this->check_vaild($code, $site_id);
            if ($check_valid->st ==1) :
                $data = array(
                    'supported_until' => $check_valid->supported_until,
                    'active_code' => $check_valid->active_code,
                    'purchase_code' =>$code,
                    'site_info' =>$check_valid->li,
                    'site_url' => SITE_LINK,
                    'license_name' => $check_valid->license_name,
                    'active_key' => $check_valid->active_key,
                    'purchase_date' => $check_valid->sold_at,
                    'license_code' => $check_valid->li_code,
                    'smtp_mail' => $email,
                    'created_at' =>d_time(),
                );
                $insert = $this->admin_m->update_setting($data, $site_id, 'settings');
            else :
                $this->session->set_flashdata('error', 'Invalid Purchases Code / PUrchase code already used');
                redirect(base_url('login'));
            endif;

            if ($insert) :
                $data = array(
                    'username' => str_slug($this->input->post('username', true)),
                    'email' => strtolower($email),
                    'password' => $password,
                    'user_role' =>1,
                    'is_verify' =>1,
                    'is_active' =>1,
                    'is_payment' =>1,
                    'created_at' => d_time(),
                );
                $create_admin = $this->admin_m->insert($data, 'users');
            endif;

            if ($create_admin) {
                $query = $this->admin_m->check_login_info($email, $password);
                foreach ($query['result'] as $key => $row) {
                    $s_array = array(
                        'id' => $row->id,
                        'username' => $row->username,
                        'email' => $row->email,
                        'user_role' => $row->user_role,
                        'is_active' => 1,
                        'is_verify' =>1,
                        'is_login' => true,
                        'active_code' => 'NM98-MOK95-8567M',
                    );
                    $this->session->set_userdata($s_array);
                    redirect(base_url('dashboard'), 'refresh');
                };
                
                $this->site_qr();
                $this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Please login');
                redirect(base_url('dashboard'));
            } else {
                $this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
                redirect(base_url('login'));
            }
        }
    }


    public function check_vaild($code, $site_id)
    {
        // check_valid_purchases
        $form_data = array(
            'code'  => $code,
            'site_id'  => $site_id,
            'site_link'  => SITE_LINK,
        );

        $form_data = json_encode($form_data);
        $ch = curl_init(URL."check_code_valid");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $form_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result = json_decode($result);
    }

/**
  ***  Logout
**/

    public function logout()
    {
        $data = array('is_login','is_auth','is_user');
        $this->session->unset_userdata($data);
        $this->session->sess_destroy();
        $this->session->set_flashdata('verify', '<i class="fas fa-check"></i> You are Successfully logout');
        redirect('login', 'refresh');
    }
}
