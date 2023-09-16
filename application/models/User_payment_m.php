<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// require FCPATH."/vendor/flutterwavedev/flutterwave-v3/library/Transactions.php";
use Flutterwave\Transactions;
class User_payment_m extends CI_Model {
	public function paytm_init($slug=''){
        $data = [];   
        $settings = settings(); 
        $u_info = $this->admin_m->get_restaurant_info_slug($slug);
        $paytm = json_decode($u_info['paytm_config']);
        $data['order_id'] = 'order_12389'.time();
        $environment = $paytm->is_paytm_live;
        if($environment==0){
            $data['url'] = 'https://securegw-stage.paytm.in';
        }else{
            $data['url'] = 'https://securegw.paytm.in';
        }

   
        $callback_url = base_url('user_payment/paytm_verify?slug='.$u_info['username'].'&key='.$paytm->merchant_key);
        

        $params = array(
            'order_id' => $data['order_id'],
            'mid' => $paytm->merchant_id,
            'mik' => $paytm->merchant_key,
            'is_paytm_live' => $environment,
            'username' => $slug,
            'callback_url' => $callback_url,
            'price' => round(auth('payment')['total']),
        );
        $token = $this->token($params);
        $data['token']=$token['body']['txnToken'];
        return $data;
    }

    public function token($data){

    /*
    * import checksum generation utility
    * You can get this utility from https://developer.paytm.com/docs/checksum/
    */
    require_once("vendor/paytm/paytmchecksum/PaytmChecksum.php");

    $paytmParams = array();

    $paytmParams["body"] = array(
        "requestType"  => "Payment",
        "mid"  => $data['mid'],
        "websiteName"  => "WEBSTAGING",
        "orderId"  => $data['order_id'],
        "callbackUrl"  => $data['callback_url'],
        "txnAmount"   => array(
        "value"   => $data['price'],
        "currency" => "INR",
       ),
        "userInfo"   => array(
            "custId"  => "CUST_001",
        ),
    );


    /*
    * Generate checksum by parameters we have in body
    * Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys
    */
    $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), $data['mik']);

    $paytmParams["head"] = array(
        "signature" => $checksum
    );

    $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);
    if($data['is_paytm_live']==0):
        /* for Staging */
        $url = "https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction?mid={$data['mid']}&orderId={$data['order_id']}";
    else:
        /* for Production */
        $url = "https://securegw.paytm.in/theia/api/v1/initiateTransaction?mid={$data['mid']}&orderId={$data['order_id']}";
    endif;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));

    $response = curl_exec($ch);
    return json_decode($response,true);



}

/*----------------------------------------------
		MERCADOPAGO
----------------------------------------------*/

public function mercado_init($slug){
	$data = [];
	$u_info = $this->admin_m->get_restaurant_info_slug($slug);

	$settings = settings();
	$mercado = !empty($u_info['mercado_config'])?json_decode($u_info['mercado_config']):'';

	MercadoPago\SDK::setAccessToken($mercado->access_token);
	$preference = new MercadoPago\Preference();
    // Create a preference item
	$item = new MercadoPago\Item();
	$item->title = auth('payment')['name'];
	$item->quantity = 1;
	$item->unit_price = auth('payment')['total'];
	$item->currency_id = $u_info['currency_code'];
	$preference->items = array($item);

	$preference->back_urls = array(
		"success" => base_url("user_payment/mercado?slug={$slug}"),
		"failure" => base_url("user_payment/mercado?slug={$slug}"),
		"pending" => base_url("user_payment/mercado?slug={$slug}")
	);
	$preference->auto_return = "approved";

	$preference->save();
	$data['f_id'] = $preference->id;
	$data['init'] = $preference->init_point;
	return $data;
}

/*----------------------------------------------
    FLUTTERWAVE
----------------------------------------------*/
public function flutterwave_init($slug){

    $u_info = $this->admin_m->get_restaurant_info_slug($slug); 
    $flutterwave = json_decode($u_info['flutterwave_config']);
    $data = [];
    $data['sandbox'] = $flutterwave->is_flutterwave_live==1?FALSE:TRUE; //TRUE for Sandbox - FALSE for live environment

    // Flutter Wave API endpoints for Sandbox & Live
    $data['payment_endpoint'] = ($data['sandbox']) ? 'https://ravesandboxapi.flutterwave.com/flwv3-pug/getpaidx/api/v2/hosted/pay' : 'https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/hosted/pay';
    $data['verify_endpoint'] = ($data['sandbox']) ? 'https://ravesandboxapi.flutterwave.com/flwv3-pug/getpaidx/api/v2/verify' : 'https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify';

    /* datauration stars from here */
    // Flutter Wave Credentials 
    $data['PBFPubKey'] = ($data['sandbox']) ? $flutterwave->fw_public_key : $flutterwave->fw_public_key; /* Public Key for Sandbox : Live */
    $data['SECKEY'] = ($data['sandbox']) ? $flutterwave->fw_secret_key : $flutterwave->fw_secret_key; /* Secret Key for Sandbox : Live */
    $data['encryption_key'] = ($data['sandbox']) ? $flutterwave->encryption_key  : $flutterwave->encryption_key; /* Encryption Key for Sandbox : Live */

    // Webhook Secret Hash 
    $data['secret_hash'] = ($data['sandbox']) ? 'TEST_SECRET_HASH' : 'LIVE_SECRET_HASH$'; /* Secret HASH for Sandbox : Live */

    // What is the default currency?
    // $data['currency'] = 'USD';  /* Store Currency Code */
    $data['currency'] = !empty($u_info['currency_code'])?$u_info['currency_code']:'NGN';  /* Store Currency Code */

    // Transaction Prefix if any
    $data['txn_prefix'] = 'TXN_PREFIX';  /* Transaction ID Prefix if any */

    $data['payment_url'] = $data['payment_endpoint'];
    $data['verify_url'] = $data['verify_endpoint'];
    $data['PBFPubKey'] = $data['PBFPubKey'];
    $data['SECKEY'] = $data['SECKEY'];
    $data['currency'] = $data['currency'];
    $data['txn_prefix'] = $data['txn_prefix'];


    return $data;
}



public function verify_flutterwave()
{
    $data = $_GET;

    if(count($data) == 0){
        echo $dev_instructions;
    };
    if (isset($data['transaction_id']) || isset($data['tx_ref']) )
    {
        $transactionId = $data['transaction_id'] ?? null;
        $tx_ref = $data['tx_ref'] ?? null;

        try {

            $history = new Transactions();
            $data = array("id"=>$transactionId);
            $verifyTransaction = $history->verifyTransaction($transactionId);
           return $verifyTransaction;
        }catch (\Exception $e) {

            return $e->getMessage();;
        }
    }

}

public function netseasy_init($slug,$amount){
    $data = [];   
    $settings = settings(); 
    $u_info = $this->admin_m->get_restaurant_info_slug($slug); 
    $netseasy = isJson($u_info['netseasy_config'])?json_decode($u_info['netseasy_config']):'';
    $ref = 'netseasy_124'.time();
    $price = $amount*100;
    $currency = $u_info['currency_code'];
    $checkout = json_encode( [
      'checkout' => [
        "integrationType"=> "EmbeddedCheckout",
        'url' => base_url('payment/netseasy'),
                // 'returnUrl' => 'https://qmenu.thinincode.net/checkout',
            'termsUrl' => base_url("terms-conditions"), // Your terms
        ],
        'order' => [
            'currency' => $currency,
                'reference' => $ref,            // A unique reference for this specific order
                'amount' => $price,              // Total order amount in cents
                'slug' =>$slug,
                'items' => [
                  [
                    'reference' => $ref.date('Y'),        // A unique reference for this specific item
                    'name' => $u_info['username'],
                    'quantity' => 1,
                    'unit' => 'pcs',
                    // 'unitPrice' => 5000,        // Price per unit except tax in cents
                    // 'taxRate' => 25000 ,         // Taxrate (e.g 25.0 in this case),
                    // 'taxAmount' => 2000   ,      // The total tax amount for this item in cents,
                    'grossTotalAmount' => $price, // Total for this item with tax in cents,
                    'netTotalAmount' => $price ,   // Total for this item without tax in cents
                ]
            ],
        ]
    ]);

    $payload = $checkout;
    assert(json_decode($payload) && json_last_error() == JSON_ERROR_NONE);
    $url = netseasyUrl($netseasy->is_netseasy_live)->url;
    $ch = curl_init("{$url}/v1/payments");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                         
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization:'.$netseasy->netseasy_secret_key));                                                

    $result = curl_exec($ch);
    $result = json_decode($result);
    return $result;

}






}

/* End of file Payment_m.php */
/* Location: ./application/models/Payment_m.php */