<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require FCPATH."/vendor/flutterwavedev/flutterwave-v3/library/Transactions.php";
use Flutterwave\Transactions;
class Payment_m extends CI_Model {

	public function paytm_init($slug='',$account_slug='',$type='admin'){
        $data = [];   
        $settings = settings(); 
        $u_info = get_all_user_info_slug($slug);
        $package = $this->admin_m->get_package_info_by_slug($account_slug);  
        $paytm = json_decode($settings['paytm_config']);
        $data['order_id'] = 'order_12389'.time();

        $is_paytm_live = 0;

        $environment = $paytm->is_paytm_live;
        if($environment==0){
            $data['url'] = 'https://securegw-stage.paytm.in';
        }else{
            $data['url'] = 'https://securegw.paytm.in';
        }

        if($type=='admin'){
        	$callback_url = base_url('payment/paytm_verify/?slug='.$u_info['username'].'&account_slug='.$package['slug'].'&key='.$paytm->merchant_key);
        }else{
        	$callback_url = "";
        }

        $params = array(
            'order_id' => $data['order_id'],
            'mid' => $paytm->merchant_id,
            'mik' => $paytm->merchant_key,
            'is_paytm_live' => $environment,
            'username' => $slug,
            'account_slug' => $account_slug,
            'callback_url' => $callback_url,
            'price' => $package['price'],
        );
        $token = $this->token($params);
        $data['token']=isset($token)?$token['body']['txnToken']:'';
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

public function mercado_init($slug,$account_slug){
	$data = [];
	$u_info = get_all_user_info_slug($slug);
	$package = $this->admin_m->get_package_info_by_slug($account_slug);
	$settings = settings();
	$mercado = !empty($settings['mercado_config'])?json_decode($settings['mercado_config']):'';

	MercadoPago\SDK::setAccessToken($mercado->access_token);
	$preference = new MercadoPago\Preference();

    // Create a preference item
	$item = new MercadoPago\Item();
	$item->title = $package['package_name'];
	$item->quantity = 1;
	$item->unit_price = $package['price'];
	$item->currency_id = get_currency('currency_code');
	$preference->items = array($item);
	$preference->back_urls = array(
		"success" => base_url("payment/mercado?slug={$slug}&account_slug={$account_slug}"),
		"failure" => base_url("payment/mercado?slug={$slug}&account_slug={$account_slug}"),
		"pending" => base_url("payment/mercado?slug={$slug}&account_slug={$account_slug}")
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

public function pagadito_verify($env_data)
{
     require_once(APPPATH.'libraries/Pagadito.php');
    if (isset($_GET["token"]) && $_GET["token"] != "") {
        /*
         * Lo primero es crear el objeto Pagadito, al que se le pasa como
         * parámetros el UID y el WSK definidos en config.php
         */
        $Pagadito = new Pagadito($_ENV['UID'], $_ENV['WSK']);
       
        /*
         * Si se está realizando pruebas, necesita conectarse con Pagadito SandBox. Para ello llamamos
         * a la función mode_sandbox_on(). De lo contrario omitir la siguiente linea.
         */
        if ($_ENV['SANDBOX']) {
            $Pagadito->mode_sandbox_on();
        }


        /*
         * Validamos la conexión llamando a la función connect(). Retorna
         * true si la conexión es exitosa. De lo contrario retorna false
         */
        if ($Pagadito->connect()) {
            /*
             * Solicitamos el estado de la transacción llamando a la función
             * get_status(). Le pasamos como parámetro el token recibido vía
             * GET en nuestra URL de retorno.
             */
            if ($Pagadito->get_status($_GET["token"])) {
                /*
                 * Luego validamos el estado de la transacción, consultando el
                 * estado devuelto por la API.
                 */
                switch($Pagadito->get_rs_status())
                {
                   

                    case "COMPLETED":
                        /*
                         * Tratamiento para una transacción exitosa.
                         */ ///////////////////////////////////////////////////////////////////////////////////////////////////////
                        $status = 'success';
                        $msgPrincipal = "Your purchase was successful";
                        $msg = "Paid Approval Number {$Pagadito->get_rs_reference()}";
                        $msgSecundario = '
                        Thank you for shopping with Pagadito.<br />
                        NAP (Paid Approval Number): <label class="respuesta">' . $Pagadito->get_rs_reference() . '</label><br />
                        Fecha Respuesta: <label class="respuesta">' . $Pagadito->get_rs_date_trans() . '</label><br /><br />';
                        return ['status'=>$status,'msg'=>$msg,'details'=>$Pagadito];
                        break;

                        case "REGISTERED":
                        
                        /*
                         * Tratamiento para una transacción aún en
                         * proceso.
                         */ ///////////////////////////////////////////////////////////////////////////////////////////////////////
                        $msgPrincipal = "Attention";
                        $msgSecundario = "The transaction was canceled.<br /><br />";
                        $status = 'cancled';
                        $msg = "The transaction was canceled";
                        return ['status'=>$status,'msg'=>$msg];
                        break;

                        case "VERIFYING":
                        
                        /*
                         * La transacción ha sido procesada en Pagadito, pero ha quedado en verificación.
                         * En este punto el cobro xha quedado en validación administrativa.
                         * Posteriormente, la transacción puede marcarse como válida o denegada;
                         * por lo que se debe monitorear mediante esta función hasta que su estado cambie a COMPLETED o REVOKED.
                         */ ///////////////////////////////////////////////////////////////////////////////////////////////////////
                            $msgPrincipal = "Atenci&oacute;n";
                            $msgSecundario = '
                            Your payment is ready. in validation.<br />
                            NAP (Paid Approval Number): <label class="respuesta">' . $Pagadito->get_rs_reference() . '</label><br />
                            Fecha Respuesta: <label class="respuesta">' . $Pagadito->get_rs_date_trans() . '</label><br /><br />';
                            $status = 'pending';
                            $msg = "Your payment is ready. in validation";
                            return ['status'=>$status,'msg'=>$msg];
                        break;

                        case "REVOKED":
                        
                        /*
                         * La transacción en estado VERIFYING ha sido denegada por Pagadito.
                         * En este punto el cobro ya ha sido cancelado.
                         */ ///////////////////////////////////////////////////////////////////////////////////////////////////////
                        $msgPrincipal = "Atenci&oacute;n";
                        $msgSecundario = "La transacci&oacute;n fue denegada.<br /><br />";
                        return ['status'=>'revoked','msg'=>$msgSecundario];
                        break;

                        case "FAILED":
                        /*
                         * Tratamiento para una transacción fallida.
                         */
                        return ['status'=>'failed','msg'=>'Transaction Failed'];
                        default:
                        
                        /*
                         * Por ser un ejemplo, se muestra un mensaje
                         * de error fijo.
                         */ ///////////////////////////////////////////////////////////////////////////////////////////////////////
                        $msgPrincipal = "Atenci&oacute;n";
                        $msgSecundario = "La transacci&oacute;n no fue realizada.<br /><br />";
                        return ['status'=>'failed','msg'=>'La transacci&oacute;n no fue realizada'];
                        break;
                    }
                } else {
                /*
                 * En caso de fallar la petición, verificamos el error devuelto.
                 * Debido a que la API nos puede devolver diversos mensajes de
                 * respuesta, validamos el tipo de mensaje que nos devuelve.
                 */
                switch($Pagadito->get_rs_code())
                {
                    case "PG2001":
                    /*Incomplete data*/
                    case "PG3002":
                    /*Error*/
                    case "PG3003":
                    /*Unregistered transaction*/
                    default:
                        /*
                         * Por ser un ejemplo, se muestra un mensaje
                         * de error fijo.
                         */ ///////////////////////////////////////////////////////////////////////////////////////////////////////
                        $msgPrincipal = "Error en la transacci&oacute;n";
                        $msgSecundario = "La transacci&oacute;n no fue completada.<br /><br />";
                        break;
                    }
                }
            } else {
            /*
             * En caso de fallar la conexión, verificamos el error devuelto.
             * Debido a que la API nos puede devolver diversos mensajes de
             * respuesta, validamos el tipo de mensaje que nos devuelve.
             */
            switch($Pagadito->get_rs_code())
            {
                case "PG2001":
                /*Incomplete data*/
                case "PG3001":
                /*Problem connection*/
                case "PG3002":
                /*Error*/
                case "PG3003":
                /*Unregistered transaction*/
                case "PG3005":
                /*Disabled connection*/
                case "PG3006":
                /*Exceeded*/
                default:
                    /*
                     * Aqui se muestra el código y mensaje de la respuesta del WSPG
                     */
                    $msgPrincipal = "Respuesta de Pagadito API";
                    $msgSecundario = "
                    COD: " . $Pagadito->get_rs_code() . "<br />
                    MSG: " . $Pagadito->get_rs_message() . "<br /><br />";
                    break;
                }
            }
        } else {
        /*
         * Aqui se muestra el mensaje de error al no haber recibido el token por medio de la URL.
         */
        $msgPrincipal = "Atenci&oacute;n";
        $msgSecundario = "No se recibieron los datos correctamente.<br /> La transacci&oacute;n no fue completada.<br /><br />";
    }
    
}

    public function netseasy_init($slug='',$account_slug='',$type='admin'){
        $data = [];   
        $settings = settings(); 
        $u_info = get_all_user_info_slug($slug);
        $package = $this->admin_m->get_package_info_by_slug($account_slug);  
        $netseasy = isJson($settings['netseasy_config'])?json_decode($settings['netseasy_config']):'';
        $ref = 'netseasy_123'.time();
        $price = $package['price']*100;
        $currency = get_currency('currency_code');
        $checkout = json_encode([
          'checkout' => [
            "integrationType"=> "EmbeddedCheckout",
            'url' => base_url('payment/netseasy'),
            'termsUrl' => base_url("terms-conditions"), // Your terms
            ],
            'order' => [
                'currency' => $currency,
                'reference' => $ref,            // A unique reference for this specific order
                'amount' => $price,     
                'items' => [
                  [
                    'reference' => $ref.date('Y'),        // A unique reference for this specific item
                    'name' => $settings['site_name'],
                    'quantity' => 1,
                    'unit' => 'pcs',
                    'grossTotalAmount' => $price, // Total for this item with tax in cents,
                    'netTotalAmount' => $price ,   // Total for this item without tax in cents
                ]
            ],
        ]
    ]);



        $curl = curl_init();
        $url = netseasyUrl($netseasy->is_netseasy_live)->url;
        curl_setopt_array($curl, [
          CURLOPT_URL => "{$url}/v1/payments",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $checkout,
          CURLOPT_FAILONERROR => true,
          CURLOPT_HTTPHEADER => [
            "Authorization:{$netseasy->netseasy_secret_key}",
            "CommercePlatformTag: testfsdfasdfsfasf54612315656",
            "content-type: application/*+json"
        ],
    ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        if ($err) {
          return $err;
      } else {
          return $response;
      }





       
    }


}

/* End of file Payment_m.php */
/* Location: ./application/models/Payment_m.php */