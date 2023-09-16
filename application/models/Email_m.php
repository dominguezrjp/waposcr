<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email_m extends CI_Model {

public function send_mail($mail_from,$mail_to,$subject,$msg){
     if($this->settings['email_type']==2):
    //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
        
        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;  //Enable verbose debug output
            $mail->isSMTP();                         //Send using SMTP
            $mail->Host       = !empty($this->settings['smtp']->smtp_host)?$this->settings['smtp']->smtp_host:'smtp.gmail.com';                      //Set the SMTP server to send through
            $mail->SMTPAuth   = true; //Enable SMTP authentication
            $mail->Username   = $this->settings['smtp_mail']; //SMTP username
            $mail->Password   = base64_decode($this->settings['smtp']->smtp_password); //SMTP password
            $mail->SMTPSecure =$this->settings['smtp']->smtp_port==465 || $this->settings['smtp']->smtp_port==25?PHPMailer::ENCRYPTION_SMTPS:PHPMailer::ENCRYPTION_STARTTLS; //Enable implicit TLS encryption

            $mail->Port       = !empty($this->settings['smtp']->smtp_port)?$this->settings['smtp']->smtp_port:465;
            //587 //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
           
            //Recipients
            $mail->setFrom($this->settings['smtp_mail'], $this->settings['site_name']);
            $mail->addAddress($mail_to, $this->settings['site_name']);  


            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            //Content
            $mail->isHTML(true);                                  
            $mail->Subject = $subject;
            $mail->Body    = $msg;
            $mail->AltBody = '';

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }

    elseif($this->settings['email_type']==3):
        require 'vendor/autoload.php';

        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom($this->settings['smtp_mail'], $this->settings['site_name']);
        $email->setSubject($subject);
        $email->addTo($mail_to, $this->settings['site_name']);
        $email->addContent("text/html", $msg);
        $sendgrid = new \SendGrid($this->settings['sendgrid_api_key']);
        
        try {
            $response = $sendgrid->send($email);
            if($response->statusCode()==202){
                return true;
            }else{
                print $response->statusCode() . "\n"."<br/>";
                print_r($response->headers());
                print $response->body() . "\n"."<br/>";
                return false;
            }
           
        } catch (Exception $e) {
            echo "<pre>";print_r($e);exit();
        }

    else:
        $this->load->library('email');

        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        $this->email->from($this->settings['site_name']);
        $this->email->reply_to($this->settings['smtp_mail']);
        $this->email->to($mail_to);
        $this->email->subject($subject);
        $this->email->message($msg);
                //Send email
        if($this->email->send()){
           return true;
       }else{
           return false;
       }
   endif;
}


public function test_mail(){
     if($this->settings['email_type']==2):
    //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings

            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = !empty($this->settings['smtp']->smtp_host)?$this->settings['smtp']->smtp_host:'smtp.gmail.com';                      //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $this->settings['smtp_mail'];                     //SMTP username
            $mail->Password   = base64_decode($this->settings['smtp']->smtp_password);                               //SMTP password
            $mail->SMTPSecure =$this->settings['smtp']->smtp_port==465 || $this->settings['smtp']->smtp_port==25?PHPMailer::ENCRYPTION_SMTPS:PHPMailer::ENCRYPTION_STARTTLS; ;            //Enable implicit TLS encryption
            $mail->Port       = !empty($this->settings['smtp']->smtp_port)?$this->settings['smtp']->smtp_port:465;
            //587 //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($this->settings['smtp_mail'], $this->settings['site_name']);
            $mail->addAddress($this->settings['smtp_mail'], $this->settings['site_name']);  

            //Add a recipient
            // $mail->addAddress('ellen@example.com');               //Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            //Content
            $mail->isHTML(true);                                  
            $mail->Subject = 'Test Mail';
            $mail->Body    = 'Mail testing.... Mail working fine';
            $mail->AltBody = '';

            $mail->send();
                   echo '<h4 style="margin-top:20px; color:green;">Message has been sent & working fine</h4>';
            } catch (Exception $e) {
                echo "<h4 style='margin-top:20px; color:red;'>Message could not be sent. Mailer Error: {$mail->ErrorInfo} </h4>";
            }

    elseif($this->settings['email_type']==3):
        require 'vendor/autoload.php';

        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom($this->settings['smtp_mail'], $this->settings['site_name']);
        $email->setSubject("Text mail using SendGrid");
        $email->addTo($this->settings['smtp_mail'], $this->settings['site_name']);
        $email->addContent("text/html", "Text mail using SendGrid welcome to {$this->settings['site_name']} script");
        $sendgrid = new \SendGrid($this->settings['sendgrid_api_key']);
        
        try {
            $response = $sendgrid->send($email);
            print $response->statusCode() . "\n"."<br/>";
            print_r($response->headers());
            print $response->body() . "\n"."<br/>";
        } catch (Exception $e) {
  
        }
    else:
        $this->load->library('email');

        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        $this->email->from($this->settings['site_name']);
        $this->email->reply_to($this->settings['smtp_mail']);
        $this->email->to($this->settings['smtp_mail']);
        $this->email->subject($subject);
        $this->email->message($msg);
                //Send email
        if($this->email->send()){
           return true;
       }else{
           return false;
       }
   endif;
}

	
public function send_global_mail($data=[],$mail_to='',$type=''){
    $data = xs_clean($data);
    $mailContent = isJson($this->settings['email_template_config'])?json_decode($this->settings['email_template_config']):'';

    $getMsg = isset($mailContent->$type)?$mailContent->$type:'';
    $getData = mail_type($type);


    $getDataKeys = array_keys(array_change_key_case($data,CASE_UPPER));
    $getDataValues = array_values($data);
    $data = array_combine($getDataKeys,$getDataValues);

    $getDbValues = array_values($getData); // comes from Database


    $getMatchedData = [];
    foreach($getDbValues as $key=>$arr){
        $getMatchedData[$arr] = $data[$arr]; 
    }


    $message = $getMsg->message;
    $msg = create_email_msg($getMatchedData,$message);
    $subject = $getMsg->subject;

    $mail_to_type = ['contact_mail'];
    if(in_array($type,$mail_to_type)){
        $send_to = $this->settings['smtp_mail'];
    }else{
        $send_to = $mail_to;
    }
    
    $send = $this->send_mail($mail_from=$this->settings['smtp_mail'],$mail_to,$subject,$msg);
    return $send;

}

//send reset code to user email/ password recovery mail 
  public function send_recovery_mail($user)
  {
   
      $msg = '<h4>Password Recovery Mail from '.$this->settings['site_name'].'</h4>
      Hello '.$user['username'].'<br> Use this <b> <u style="background: #ddd;padding: 10px 30px;font-size: 25px;font-weight: bold;letter-spacing: 15px;margin: 10px;display: inline-block;">'.$user['password'].'</u> </b> password to login '.$this->settings['site_name'].'<p>Don\'t share this password anyone</p>';
     
      $subject = !empty($this->settings['email_subjects']->recovery)?$this->settings['email_subjects']->recovery:'Password Recovery';
      $send = $this->send_mail($this->settings['smtp_mail'],$user['email'],$subject,$msg);//from,to,sub,msg.
      if($send):
        return true;
      else:
        return false;
      endif;
  }
 



  /* Offline payment request from user to admin
    ================================================== */
     public function home_contact_mail($data){
        $mail_body = '<div class="container">
                    <div class="row mail_content" style="border:1px solid #d6d6d6; background-color:#f3f3f3; padding:10px;">
                        <div class="col-md-12">
                         <div class="mail_header" style="background: #4CAF50;padding:10px; color:#fff;width: 59%">
                            <h5 style="padding: 0; margin: 0;">'.$data['subject'].'</h5>
                            <h3 style="padding: 0; margin: 0;">'.$this->settings['site_name'].'</h3>
                        </div>
                            <div class="mail_template">
                                <table>
                                    <tr>
                                        <td><em>Contact Mail form </em> <b>'.$data['name'].'<b></td>
                                    </tr>
                                    <tr>
                                        <td>Name: </td>
                                        <td> <b>'.$data['name'].'</b></td>
                                    </tr>
                                     <tr>
                                        <td>Email: </td>
                                        <td> <b>'.$data['email'].'</b></td>
                                    </tr>

                                    <tr>
                                        <td>Message: </td>
                                        <td> <b>'.$data['message'].'</b></td>
                                    </tr>
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>';
       

        $subject = 'Contact Mail';
       $send =  $this->send_mail($data['email'],$this->settings['smtp_mail'],$subject,$mail_body);//from,to,sub,msg.
        if($send){
            return true;
        }else {
            return false;
        }
        
    }

  /* //Resend verification email
  ================================================== */

     public function resend_verify_mail($username)
    {
        
        $u_info = get_all_user_info_slug($username);
        $msg = '<h4> Account Verification Mail from - '.$this->settings['site_name'].'</h4>
        <h4>Hello '.$u_info['username'].'</h4>
        <p> Click  verifiy button to verify your account.</p>
         <a href="'.base_url('login/verify/'.$u_info['username']).'" style="padding: 10px 20px;background: #82b440;color: #fff;display: inline-block;">Verify</a>';
        
        $subject = 'Resend Account Verification Mail';
        $send = $this->send_mail($this->settings['smtp_mail'],$u_info['email'],$subject,$msg);//from,to,sub,msg.
        if($send){
          return true;
        }else{
           return false;
        }
    }


  /* Email Verification Mail
  ================================================== */
  public function email_verification_mail($data,$password,$package){
      $mail_body = '<div class="container">
            <div class="row mail_content" style="border:1px solid #d6d6d6; background-color:#f3f3f3; padding:10px;">
                <div class="col-md-12">
                    <div class="mail_template">
                        <div class="mail_header" style="background: #4CAF50;padding:10px; color:#fff; margin-bottom: 10px;">
                            <h5 style="padding: 0; margin: 0;">Account Verification Mail</h5>
                            <h3 style="padding: 0; margin: 0;">'.$this->settings['site_name'].'</h3>
                        </div>
                        <table>
                            <tr>
                                <td><em>Congratulations </em> <b>'.$data['username'].'<b></td>
                            </tr>
                            <tr>
                                <td>Name: </td>
                                <td> <b>'.$data['username'].'</b></td>
                            </tr>
                             <tr>
                                <td>Email: </td>
                                <td> <b>'.$data['email'].'</b></td>
                            </tr>

                            <tr>
                                <td>Package: </td>
                                <td> <b>'.$package['package_name'].'</b></td>
                            </tr>
                            <tr>
                                <td>Password: </td>
                                <td> <b>'.$password.'</b></td>
                            </tr>
                            <tr>
                                <td> 
                                <h4>Click Verify button to verify your account or copy the link</h4>
                                <p><a href="'.base_url('login/verify/'.$data['username']).'" style="padding: 10px 20px;background: #4CAF50;color: #fff;display: inline-block;"> <b>Verify </b></a></p>
                                <p></p>
                                <p>'.base_url('login/verify/'.$data['username']).'</p>
                                 </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>';
      $subject = !empty($this->settings['email_subjects']->registration)?$this->settings['email_subjects']->registration:'Registration verification Mail';
      $send = $this->send_mail($this->settings['smtp_mail'],$data['email'],$subject,$mail_body);//from,to,sub,msg.

      if($send){
        return true;
      }else{
        return false;
      }
      
  }
/*  Account Create Invoice
================================================== */
  public function account_create_invoice($username){
    $user_info = get_all_user_info_slug($username);

        $mail_body = '<div class="container">
              <div class="col-md-8 col-xs-12">
                  <div class="mail_header" style="background: #4CAF50;padding:10px; color:#fff;width: 59%">
                      <h5 style="padding: 0; margin: 0;">Account Create Invoice</h5>
                      <h3 style="padding: 0; margin: 0;">'.$this->settings['site_name'].'</h3>
                  </div>
                  <table class="table" style="width: 60%; max-width: 100%; margin-bottom: 20px;border-spacing: 0;border-collapse:collapse;">
                      <thead>
                          <tr style="border:1px solid #ddd;">
                              <th style="border:1px solid #ddd;padding: 10px;" class="">Sl</th>
                              <th style="border:1px solid #ddd;padding:10px;" class="">Description</th>
                              <th style="border:1px solid #ddd;padding:10px;" class="">Package name</th>
                              <th style="border:1px solid #ddd;padding:10px;" class="">Qty</th>
                              <th style="border:1px solid #ddd;padding:10px;" class="">Price</th>
                              <th style="border:1px solid #ddd;padding:10px;" class="">Total</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr style="border:1px solid #ddd; height: 200px;">
                              <td style="border:1px solid #ddd;padding: 10px;vertical-align: text-top;">#1</td>
                              <td style="border:1px solid #ddd;padding: 10px;vertical-align: text-top;">
                                  <p>Thank you <b> '.$user_info['username'].'</b> for registration on <b>'.$this->settings['site_name'].'</b> </p>
                                  <p>Please payment to continue your account live.</p>
                              </td>
                              <td style="border:1px solid #ddd;padding: 10px;vertical-align: text-top;">'.$user_info['package_name'].'</td>
                              <td style="border:1px solid #ddd;padding: 10px;vertical-align: text-top;">1</td>
                              <td style="border:1px solid #ddd;padding: 10px;vertical-align: text-top;">'.$user_info['price'].'</td>
                              <td style="border:1px solid #ddd;padding: 10px;vertical-align: text-top;">'.get_currency('icon').$user_info['price'].'</td>
                          </tr>
                          <tr>
                            <td style="border:1px solid #ddd;padding: 10px;" colspan="4"></td>
                            <td style="border:1px solid #ddd;padding: 10px;">Total</td>
                            <td style="border:1px solid #ddd;padding: 10px;">'.get_currency('icon').$user_info['price'].' /-</td>
                        </tr>

                    </tbody>
                </table>
            </div>
          </div>';

        $subject = 'Account Create Invoice';
        $this->send_mail($this->settings['smtp_mail'],$user_info['email'],$subject,$mail_body);//from,to,sub,msg.

  }

/* new account mail to auth
================================================== */
  public function new_user_mail($user,$package)
  {
    
      $msg = '<b>New User</b> <br> User name: <b>'.$user['username'].'</b><br> Email:'.$user['email'].'<br> Package Name: <b>'.$package['package_name'].'</b>';
       $subject = 'New created account';
          $this->send_mail($user['email'],$this->settings['smtp_mail'],$subject,$msg);//from,to,sub,msg.       
  }


/* Offline payment request from user to admin
    ================================================== */
     public function offline_payment_request_mail($slug,$account_slug,$txn_id){
        $u_info = get_all_user_info_slug($slug);
        $package_info = get_package_info_by_slug($account_slug);

        $mail_body = '<div class="container">
                    <div class="row mail_content" style="border:1px solid #d6d6d6; background-color:#f3f3f3; padding:10px;">
                        <div class="col-md-12">
                         <div class="mail_header" style="background: #4CAF50;padding:10px; color:#fff;width: 59%">
                            <h5 style="padding: 0; margin: 0;">Payment Request</h5>
                            <h3 style="padding: 0; margin: 0;">'.$this->settings['site_name'].'</h3>
                        </div>
                            <div class="mail_template">
                                <table>
                                    <tr>
                                        <td><em>An Offline payment request from </em> <b>'.$u_info['username'].'<b></td>
                                    </tr>
                                    <tr>
                                        <td>Name: </td>
                                        <td> <b>'.$u_info['username'].'</b></td>
                                    </tr>
                                     <tr>
                                        <td>Email: </td>
                                        <td> <b>'.$u_info['email'].'</b></td>
                                    </tr>

                                    <tr>
                                        <td>Account Type: </td>
                                        <td> <b>'.$package_info['package_name'].'</b></td>
                                    </tr>
                                    <tr>
                                        <td>Price: </td>
                                        <td> <b>'.get_currency('icon').$package_info['price'].'</b></td>
                                    </tr>

                                     <tr>
                                        <td>Request ID: </td>
                                        <td> <b>'.$txn_id.'</b></td>
                                    </tr>
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>';
       

        $subject = 'Offline payment request';
       $send =  $this->send_mail($u_info['email'],$this->settings['smtp_mail'],$subject,$mail_body);//from,to,sub,msg.
  
        if($send){
            return true;
        }else {
            return false;
        }
        
    }


     /* Send a mail with password after create new accout by author
    ================================================== */
  
    public function new_user_create_mail_by_author($data,$package,$password){
        $mail_body = '<div class="container">
                    <div class="row mail_content" style="border:1px solid #d6d6d6; background-color:#f3f3f3; padding:10px;">
                        <div class="col-md-12">
                            <div class="mail_template">
                                <table>
                                    <tr>
                                        <td><em>Congratulations </em> <b>'.$data['username'].'<b> </td>
                                    </tr>
                                    <tr>
                                        <td>Name: </td>
                                        <td> <b>'.$data['username'].'</b></td>
                                    </tr>
                                     <tr>
                                        <td>Email: </td>
                                        <td> <b>'.$data['email'].'</b></td>
                                    </tr>

                                    <tr>
                                        <td>Account Type: </td>
                                        <td> <b>'.$package['package_name'].'</b></td>
                                    </tr>
                                    <tr>
                                        <td>Password: </td>
                                        <td> <b style="font-size:25px;">'.$password.'</b></td>
                                    </tr>
                                    <tr>
                                        <td> 
                                            <h4>Account created by author</h4>
                                         </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>';
            $subject = 'Create account by Author';
            $this->send_mail($this->settings['smtp_mail'],$data['email'],$subject,$mail_body);//from,to,sub,msg.
        
    }

    /*  sena an email after change package by author or others payment method
    ================================================== */
    public function send_payment_verified_email($data,$payment_via){
        $user_info = get_all_user_info_id($data['user_id']);
        if(isset($this->settings['is_dynamic_mail']) && $this->settings['is_dynamic_mail']==1):
            $mailData =  [
                'site_name' => $this->settings['site_name'],
                'username' => $user_info['username']??'',
                'package_name' => $user_info['package_name']??'',
                'email' => $user_info['email']??'',
                'txnid' => $data['txn_id']??'',
                'price' => $data['price'].$data['currency_code']??'',
                'payment_method' => $payment_via??'',
                'payment_date' => full_time(d_time())??'',
                'expire_date' => $user_info['end_date']??'',
            ];
            $send = $this->send_global_mail($mailData,$mailData['email'],'send_payment_verified_email');
        else:


        $mail_body = '<div class="invoice">
                <div class="mail_header" style="background: #4CAF50;padding:10px; color:#fff; margin-bottom:20px; width:90%;">
                    <h5 style="padding: 0; margin: 0;">Payment Invoice</h5>
                    <h3 style="padding: 0; margin: 0;">'.$this->settings['site_name'].'</h3>
                </div>
                <div class="" style="margin-bottom: 10px; overflow:hidden;">
                        <table class="table" style="width: 45%;float: left;">
                            <tbody>
                                <tr><td><strong style="width: 150px; display: inline-block;">Name:</strong> '.$user_info['username'].'</td></tr>
                                <tr><td><strong style="width: 150px; display: inline-block;">Email:</strong>'.$user_info['email'].'</td></tr>
                                <tr><td><strong style="width: 150px; display: inline-block;">paid via:</strong>'.$payment_via.'</td></tr>
                            </tbody>
                        </table>
                        <table class="table" style="width: 55%;float: left;">
                            <tbody>
                                <tr><td><strong style="width: 150px; display: inline-block;">Date:</strong> '.full_time(d_time()).'</td></tr>
                                <tr><td><strong style="width: 150px; display: inline-block;">Transaction ID:</strong> '.$data['txn_id'].'</td></tr>
                                <tr><td><strong style="width: 150px; display: inline-block;">From:</strong>'.$this->settings['site_name'].'</td></tr>
                            </tbody>
                        </table>
                </div>
                
                <table class="table" style="width: 90%; max-width: 100%; margin-bottom: 20px; margin-top: 30px; border-spacing: 0;border-collapse:collapse;">
                    <thead>
                        <tr style="background: #ddd;">
                            <th style="padding: 10px;border:1px solid #ddd;">Sl</th>
                            <th style="padding: 10px;border:1px solid #ddd; width: 65%">Description</th>
                            <th style="padding: 10px;border:1px solid #ddd;">Package</th>
                            <th style="padding: 10px;border:1px solid #ddd;">Qty</th>
                            <th style="padding: 10px;border:1px solid #ddd;">Price</th>
                            <th style="padding: 10px;border:1px solid #ddd;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style=" height: 200px;">
                            <td style="padding: 10px;vertical-align: text-top;border:1px solid #ddd;">#1</td>
                            <td style="padding: 10px;vertical-align: text-top;border:1px solid #ddd;">
                                <p>Thank you <b> '.$user_info['username'].'</b>. </p>
                                <p>Your payment has been completed successfully.</p>
                                 <p>Your account will expired on <b>'.$user_info['end_date'].'</b></p>
                            </td>
                            <td style="padding: 10px;vertical-align: text-top;border:1px solid #ddd;">'.$user_info['package_name'].'</td>
                            <td style="padding: 10px;vertical-align: text-top;border:1px solid #ddd;">1</td>
                            <td style="padding: 10px;vertical-align: text-top;border:1px solid #ddd;">'.get_currency('icon').$data['price'].'</td>
                            <td style="padding: 10px;vertical-align: text-top;border:1px solid #ddd;">'.get_currency('icon').$data['price'].'</td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #ddd;padding: 10px;" colspan="4"></td>
                            <td style="border:1px solid #ddd;padding: 10px;">Total</td>
                            <td style="border:1px solid #ddd;padding: 10px;">'.get_currency('icon').$data['price'].' /-  <em><b>Paid</b></em></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            ';
       
       
            $subject ='Payment Confirmation';
            $this->send_mail($this->settings['smtp_mail'],$user_info['email'],$subject,$mail_body);//from,to,sub,msg.
        endif;
    }


 /*  Account expire reminder mail to user
    ================================================== */
    public function expire_reminder_mail($username,$day_left)
    {

        $setting = settings();
        $u_info = get_all_user_info_slug($username);

        if(isset($this->settings['is_dynamic_mail']) && $this->settings['is_dynamic_mail']==1):
            $mailData =  [
                'site_name' => $this->settings['site_name'],
                'username' => $u_info['username']??'',
                'email' => $u_info['email']??'',
                'expire_date' => $u_info['end_date']??'',
                'remaining_days' => $day_left??'',
            ];
            $send = $this->send_global_mail($mailData,$mailData['email'],'expire_reminder_mail');
        else:


        $mail_body = '<div class="container">
                    <div class="row mail_content" style="border:1px solid #d6d6d6; background-color:#f3f3f3; padding:10px;">
                        <div class="col-md-12">
                            <div class="mail_template">
                                <table>
                                    <tr>
                                        <td><em>Account Expire reminder from </em> <b>'.$setting['site_name'].'<b></td>
                                    </tr>
                                    <tr>
                                        <td>Name: </td>
                                        <td> <b>'.$u_info['username'].'</b></td>
                                    </tr>
                                     <tr>
                                        <td>Email: </td>
                                        <td> <b>'.$u_info['email'].'</b></td>
                                    </tr>
                                    
                                    <tr>
                                        <td>End Date: </td>
                                        <td> <b>'.full_time($u_info['end_date']).'</b></td>
                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td> <b>'.$day_left.'</b></td>
                                    </tr>
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>';
        
        $subject = 'Account Expire reminder mail';
        $this->send_mail($setting['smtp_mail'],$u_info['email'],$subject,$mail_body);//from,to,sub,msg.
    endif;
    }

    public function account_expire_mail($username,$day_left)
    {
        $setting = settings();
        $u_info = get_all_user_info_slug($username);
        if(isset($this->settings['is_dynamic_mail']) && $this->settings['is_dynamic_mail']==1):
            $mailData =  [
                'site_name' => $this->settings['site_name'],
                'username' => $u_info['username']??'',
                'email' => $u_info['email']??'',
                'expire_date' => $u_info['end_date']??'',
            ];
            $send = $this->send_global_mail($mailData,$mailData['email'],'account_expire_mail');
        else:
            $mail_body = '<div class="container">
                        <div class="row mail_content" style="border:1px solid #d6d6d6; background-color:#f3f3f3; padding:10px;">
                            <div class="col-md-12">
                                <div class="mail_template">
                                    <table>
                                        <tr>
                                            <td><em>Account Expire reminder from </em> <b>'.$setting['site_name'].'<b></td>
                                        </tr>
                                        <tr>
                                            <td>Name: </td>
                                            <td> <b>'.$u_info['username'].'</b></td>
                                        </tr>
                                         <tr>
                                            <td>Email: </td>
                                            <td> <b>'.$u_info['email'].'</b></td>
                                        </tr>
                                        
                                        <tr>
                                            <td>End Date: </td>
                                            <td> <b>'.full_time($u_info['end_date']).'</b></td>
                                        </tr>

                                        <tr>
                                            <td></td>
                                            <td> <b> Your account is already expired</b></td>
                                        </tr>
                                        
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>';
            $subject = 'Expire reminder mail';
            $this->send_mail($setting['smtp_mail'],$u_info['email'],$subject,$mail_body);//from,to,sub,msg.
        endif;
    }



    public function order_mail($msg)
    {
        $setting = settings();
        $this->send_mail($setting['smtp_mail'],'phplime.envato@gmail.com',$subject='order_mail',$msg);//from,to,sub,msg.
        
    }


}