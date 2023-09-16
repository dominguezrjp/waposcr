<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class User_email_m extends CI_Model {
 public function __construct(){
    // parent::__construct();

}
protected function send_mail($id,$data){
    $settings = $this->common_m->get_user_settings($id);
    $smtp = !empty($settings['smtp_config'])?json_decode(@$settings['smtp_config']):'';

    $mail_type = !empty($settings['email_type'])?$settings['email_type']:1;
    $sendgrid = !empty($settings['sendgrid_api_key'])?$settings['sendgrid_api_key']:'';
    $mail_from = $settings['smtp_mail'];
    
    $shop = $this->admin_m->my_restaurant_info($id);
    $site_name = !empty($shop->name)?$shop->name:$shop->username;
    $mail_to = $data['mail_to'];
     if($mail_type==2):
    //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;  //Enable verbose debug output
            $mail->isSMTP();                         //Send using SMTP
            $mail->Host       = !empty($smtp->smtp_host)?$smtp->smtp_host:'smtp.gmail.com';                      //Set the SMTP server to send through
            $mail->SMTPAuth   = true; //Enable SMTP authentication
            $mail->Username   = $mail_from; //SMTP username
            $mail->Password   = base64_decode($smtp->smtp_password); //SMTP password
            $mail->SMTPSecure =$smtp->smtp_port==465 || $smtp->smtp_port==25?PHPMailer::ENCRYPTION_SMTPS:PHPMailer::ENCRYPTION_STARTTLS; //Enable implicit TLS encryption

            $mail->Port       = !empty($smtp->smtp_port)?$smtp->smtp_port:465;
            //587 //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
      
            //Recipients
            $mail->setFrom($mail_from, $site_name);

            if($data['type']==2):
                foreach (array_unique($mail_to) as $key => $value) {
                    $mail->addAddress($value, $site_name);  
                }
                
            else:
                 $mail->addAddress($mail_to, $site_name);  
            endif;


            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            //Content
            $mail->isHTML(true);                               
            $mail->Subject = $data['subject'];
            $mail->Body    = $data['msg'];
            $mail->AltBody = '';

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }

    elseif($mail_type==3):
        require 'vendor/autoload.php';

        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom($mail_from, $site_name);
        $email->setSubject($data['subject']);

        if($data['type']==2):
            foreach (array_unique($mail_to) as $key => $value) {
                $email->addTo($value, $site_name);
            }
        else:
           $email->addTo($mail_to, $site_name);
        endif;


        
        $email->addContent("text/html", $data['msg']);
        $sendgrid = new \SendGrid($sendgrid);
        
        try {
            $response = $sendgrid->send($email);
            if($response->statusCode()==202){
                return true;
            }else{
                print $response->statusCode() . "\n"."<br/>";
                print_r($response->headers());
                print $response->body() . "\n"."<br/>";
                exit();
                return false;
            }
           
        } catch (Exception $e) {
            echo "<pre>";print_r($e);exit();
        }

    else:
        $this->load->library('email');

        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        $this->email->from($site_name);
        $this->email->reply_to($mail_from);
        if($data['type']==2):
            foreach (array_unique($mail_to) as $key => $value) {
               $this->email->to($value);
           }

        else:
         $this->email->to($mail_to);
        endif;
       
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


public function test_mail($id){
       $settings = $this->admin_m->get_user_settings($id);
       $smtp = !empty($settings['smtp_config'])?json_decode(@$settings['smtp_config']):'';
       $mail_type = !empty($settings['email_type'])?$settings['email_type']:1;
       $sendgrid = !empty($settings['sendgrid_api_key'])?$settings['sendgrid_api_key']:'';
       $mail_from = $settings['smtp_mail'];
       $shop = $this->admin_m->my_restaurant_info($id);
       $site_name = !empty($shop->name)?$shop->name:$shop->username;
       $mail_to = $mail_from;

     if($mail_type==2):
    //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings

            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = !empty($smtp->smtp_host)?$smtp->smtp_host:'smtp.gmail.com';                      //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $mail_from;                     //SMTP username
            $mail->Password   = base64_decode($smtp->smtp_password);                               //SMTP password
            $mail->SMTPSecure =$smtp->smtp_port==465 || $smtp->smtp_port==25?PHPMailer::ENCRYPTION_SMTPS:PHPMailer::ENCRYPTION_STARTTLS; ;            //Enable implicit TLS encryption
            $mail->Port       = !empty($smtp->smtp_port)?$smtp->smtp_port:465;
            //587 //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($mail_from, $site_name);
            $mail->addAddress($mail_to, $site_name);  

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

    elseif($mail_type==3):
        require 'vendor/autoload.php';

        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom($mail_from, $site_name);
        $email->setSubject("Text mail using SendGrid");
        $email->addTo($mail_to, $site_name);
        $email->addContent("text/html", "Text mail using SendGrid welcome to {$site_name} script");
        $sendgrid = new \SendGrid($sendgrid);
        
        try {
            $response = $sendgrid->send($email);
            print $response->statusCode() . "\n"."<br/>";
            print_r($response->headers());
            print $response->body() . "\n"."<br/>";
        } catch (Exception $e) {
            echo "<pre>";print_r($e);exit();
        }
    else:
        $this->load->library('email');

        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        $this->email->from($site_name);
        $this->email->reply_to($mail_from);
        $this->email->to($mail_to);
        $this->email->subject('Mail Test');
        $this->email->message("Mail testing.... Mail working fine for {$site_name}");
                //Send email
        if($this->email->send()){
           return true;
       }else{
           return false;
       }
   endif;
}

public function send_order_mail($order_id,$type=1){
        $order_details = $this->admin_m->single_select_by_uid_row($order_id,'order_user_list');
        $shop_info = $this->common_m->get_restaurant_info_by_id($order_details->shop_id);
        $settings = $this->common_m->get_user_settings($shop_info['user_id']);
        $order_list = $this->common_m->get_order_item($order_details->id,$shop_info['shop_id']);

        $icon = $shop_info['icon'];
        $shop_id = $shop_info['shop_id'];
        $net_price = $order_details->total;

        $mail_config = json_decode(@$settings['order_mail_config']);

        if($shop_info['is_area_delivery']==1):
            $delivery_charge = $order_details->delivery_charge;
        else:
            if($shop_info['delivery_charge_in'] !=0){
                $delivery_charge = $shop_info['delivery_charge_in'];
            }else{
                $delivery_charge = lang('free');
            };
        endif;


        $discount = get_percent($order_details->sub_total,$order_details->discount).' '.$icon;
        $coupon_percent = get_percent($order_details->sub_total,$order_details->coupon_percent).' '.$icon;
        $tax_fee = get_percent($order_details->sub_total,$order_details->tax_fee).' '.$icon;

        $tips = wh_currency_position($order_details->tips,$shop_id);

        $sub_total = number_format($order_details->sub_total,2).' '.$icon;



        $data = '';

        $data .= '
        <style rel="stylesheet">
        body{
            margin: 0 auto;
        }
        ul.itemList {
            padding: 0;
            margin: 0;
            list-style: none;
            border-bottom: 1px dashed;
        }

        ul.itemList li {
            padding: 5px;
            margin-bottom: 2px;
            margin-left:0;
        }

        ul.toatalArea {
            padding: 0;
            list-style: none;
            text-transform: capitalize;
        }

        ul.toatalArea li {
            padding: 3px 5px;
            margin-left:0;
        }
        .gs li{
            margin-left:0;
        }
        </style>

        ';

        $data .= '<ul class="itemList" style="list-style:none;padding:0;margin:0;text-transform: capitalize;">';
        $i=1;
        foreach ($order_list as $key => $row): 
            if($row['is_package']==1):
                $data .= '<li>'.$i.". {$row['package_name']} ------------- {$row['qty']} x ".wh_currency_position($row['item_price'],$shop_id)."</li>";
                
            else: 

                $data .= '<li>'.$i.". {$row['name']} ----------- {$row['qty']} x ".wh_currency_position($row['item_price'],$shop_id)."</li>";

            endif;


            $i++; 
        endforeach;
        $data .='</ul>';

        $data .='<ul class="toatalArea" style="list-style:none;padding:0;text-transform: capitalize;">';

        $data.= "<li>".lang('sub_total')."\t : ".wh_currency_position($sub_total,$shop_id)."</li>";

        if($tax_fee !=0):
            $data.= "<li>".lang('tax')." \t \t: ".wh_currency_position($tax_fee,$shop_id)."</li>";
        endif;

        if($tips !=0):
            $data.= "<li>".lang('tips')."\t : ".wh_currency_position($tips,$shop_id)."</li>";
        endif;

        if($order_details->order_type ==1):
            $data.= "<li>".lang('shipping')."\t : ".wh_currency_position($delivery_charge,$shop_id)."</li>";
        endif;

        if($discount !=0):
            $data.= "<li>".lang('discount')."\t : ".wh_currency_position($discount,$shop_id)."</li>";
        endif;

        if($coupon_percent !=0):
            $data.= "<li>".lang('coupon_discount')."\t : ".wh_currency_position($coupon_percent,$shop_id)."</li>";
        endif;


        $data.= "<li class='grand_total'>";
        $data.= "<strong>".lang('total')." : \t " . "" .wh_currency_position($net_price,$shop_id). " </strong>";
        $data.= "</li>";

        if($order_details->is_payment==1 && !empty($order_details->payment_by)):
            $data.= "<li>".lang('payment_by')." : \t " . "" .$order_details->payment_by. " </li>";
        endif;
        $data .='</ul>';

        if(isset($mail_config->is_customer_mail) && $mail_config->is_customer_mail==1):
            $track_url = base_url('my-orders/'.$shop_info['username'].'?phone='.$order_details->phone.'&orderId='.$order_id);
        else:
            $track_url = '#';
        endif;

        $replace_data = array(
            '{CUSTOMER_NAME}' => $order_details->name,
            '{ORDER_ID}' => $order_id,
            '{ITEM_LIST}' => $data,
            '{SHOP_NAME}' => $shop_info['shop_name'],
            '{SHOP_ADDRESS}' => $shop_info['address'],
            '{TRACK_URL}' => $track_url,
        );

        $accept_message = json_decode(@$mail_config->message);
        $msg = create_msg($replace_data,$accept_message);

        if($type==1):
            if(isset($mail_config->is_owner_mail) && $mail_config->is_owner_mail==1):
                $mail_info = ['msg'=>$msg,'subject'=>@$mail_config->subject,'type'=>1,'mail_to'=>$mail_config->order_receiver_mail];
                $send = $this->send_mail($shop_info['user_id'],$mail_info);
            endif;

            if(isset($mail_config->is_customer_mail) && $mail_config->is_customer_mail==1):
                if(isset($order_details->email) && !empty($order_details->email)):
                    $mail_info = ['msg'=>$msg,'subject'=>@$mail_config->subject,'type'=>3,'mail_to'=>$order_details->email];
                    $send = $this->send_mail($shop_info['user_id'],$mail_info);
                endif;
            endif;
        endif;

        if($type==2):
            if(isset($order_details->order_type) && $order_details->order_type==1){
                 if(isset($mail_config->is_dboy_mail) && $mail_config->is_dboy_mail==1):
                    $getDb = $this->admin_m->get_my_active_all_dboy($shop_info['user_id']);
                    $dbMail = [];
                    foreach ($getDb as $key => $db) {
                       $dbMail[] = $db['email']; 
                    }
                    $mail_info = ['msg'=>$msg,'subject'=>@$mail_config->subject,'type'=>2,'mail_to'=>$dbMail];
                    $send = $this->send_mail($shop_info['user_id'],$mail_info);
                endif;
            }
        endif;

        if(isset($send) && $send==TRUE){
            return true;
        }else{
            return false;
        }

    }

}
?>