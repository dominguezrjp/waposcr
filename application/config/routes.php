<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/


$check_domain = check_site_domain($_SERVER['HTTP_HOST']);

require_once(BASEPATH .'database/DB.php');
$db =& DB();
$table = 'custom_domain_list';
if($db->table_exists($table) && ($check_domain['is_domain']==1 || $check_domain['is_subdomain']==1)) {
$query = $db->get_where($table, array('request_name' => $check_domain['url']),1);
$result = $query->num_rows();
if($result > 0):
	try{
		$result = $query->row();
	}catch(Exception $e){
		echo $e->getMessage();
	}
	
	if(($result->is_subdomain==1 || $result->is_domain==1) && $result->status==2 && $result->is_ready==1):


		$route['default_controller'] = 'profile/index';
		$route['menu'] = 'profile/menu/';
		$route['checkout'] = 'profile/checkout';
		$route['order-success/(:any)'] = 'profile/order_success/$1';
		$route['packages'] = 'profile/packages/';
		$route['specialities'] = 'profile/specialities';
		$route['shop-contacts'] = 'profile/contacts';
		$route['about-us'] = 'profile/about';
		$route['reservation'] = 'profile/reservation';
		$route['track-order'] = 'profile/track_order';
		$route['my-orders'] = 'profile/all_orders';
		$route['qr-menu/(:any)'] = 'profile/qr_menu/$1';
		$route['item-types/(:any)'] = 'profile/single/$1';
		$route['pagadito-success'] = 'user_payment/pagadito_success';
		// new
		$route['shop-reviews'] = 'profile/review';
		$route['terms-condition'] = 'profile/terms';
	else:
		$route['default_controller'] = 'home/index';
	endif;
else:
	$route['default_controller'] = 'home/index';
endif;

}else{
    $route['default_controller'] = 'home/index';
}


$route['404_override'] = 'home/error_404';
$route['translate_uri_dashes'] = FALSE;
$route['index'] = 'home/index';


$route['login'] = 'login/index';
$route['admin'] = 'login/index';
$route['sign-up'] = 'login/signup';
$route['logout'] = 'login/logout';
$route['dashboard'] = 'admin/dashboard';
$route['stripe-payment-post'] = 'payment/payment';

$route['error-404'] = 'home/error_404';
$route['error-404'] = 'profile/error_404';
$route['error-404'] = 'admin/error_404';
$route['error-404'] = 'error_404';

$route['pricing'] = 'home/pricing';
$route['reviews'] = 'home/reviews';
$route['users'] = 'home/users';
$route['terms-conditions'] = 'home/terms';
$route['cookies-privacy'] = 'home/privacy';
$route['contacts'] = 'home/contacts';

$route['user-stripe-payment'] = 'user_payment/stripe_payment';
$route['user-razorpay-payment'] = 'user_payment/razorpay_payment';
$route['signup-(:any)'] = 'login/package_signup/$1';

$route['vcard/(:any)'] = 'payment/vcard_load/$1';


$route['menu/(:any)'] = 'profile/menu/$1';
$route['checkout/(:any)'] = 'profile/checkout/$1';
$route['order-success/(:any)/(:any)'] = 'profile/order_success/$1/$2';
$route['packages/(:any)'] = 'profile/packages/$1';
$route['specialities/(:any)'] = 'profile/specialities/$1';

$route['shop-contacts/(:any)'] = 'profile/contacts/$1';
$route['about-us/(:any)'] = 'profile/about/$1';
$route['reservation/(:any)'] = 'profile/reservation/$1';



$route['track-order/(:any)'] = 'profile/track_order/$1';
$route['my-orders/(:any)'] = 'profile/all_orders/$1';
$route['qr-menu/(:any)/(:any)'] = 'profile/qr_menu/$1/$2';
$route['item-types/(:any)/(:any)'] = 'profile/single/$1/$2';



$route['staff-login/(:any)'] = 'staff/login/$1';
$route['invoice/(:any)/(:any)'] = 'staff/my_invoice/$1/$2';





$route['pages/(:any)'] = 'home/pages/$1';

/* user payment method
================================================== */
$route['payment-method/(:any)/(:any)'] = 'payment/index/$1/$2';


/* Payment method paypal
================================================== */

$route['paypal-payment/(:any)/(:any)'] = 'payment/paypal_payment/$1/$2';;
$route['paypal-success/(:any)/(:any)'] = 'payment/success/$1/$2';



/* Payment method Stripe
================================================== */

$route['stripe-payment/(:any)/(:any)'] = 'payment/stripe_payment/$1/$2';

$route['stripe-payment-success/(:any)'] = 'payment/stripe_success/$1';




/* user Payment method Stripe
================================================== */



/* Offline payment
================================================== */
$route['offline-payment/(:any)/(:any)'] = 'payment/offline_payment/$1/$2';


$route['delete-item/(:any)/(:any)'] = 'admin/auth/item_delete/$1/$2';

$route['delete-single-item/(:any)/(:any)'] = 'admin/restaurant/delete_single_item/$1/$2';


$route['pos-success/(:any)'] = 'admin/pos/order_success/$1';
$route['admin/order-details/(:any)'] = 'admin/restaurant/get_item_list_by_order_id/$1';
$route['pos'] = 'admin/pos';


$route['pos'] = 'admin/pos';

//New


$route['terms-condition/(:any)'] = 'profile/terms/$1';
$route['shop-reviews/(:any)'] = 'profile/review/$1';
$route['pagadito-success'] = 'user_payment/pagadito_success';
$route['subscription-invoice/(:any)'] = 'customer/subscription_invoice/$1';


$route['(:any)'] = 'profile/index/$1';










function check_site_domain($url){
	$newUrl = 'https://'.$url;
    $newUrl = rtrim($newUrl, '/');
	$host = parse_url($newUrl, PHP_URL_HOST);
	$path = parse_url($newUrl, PHP_URL_PATH);

	if (substr_count($host, '.') > 1) {
		$subdomain_arr = explode('.', $url, 2); 
		$subdomain_name = $subdomain_arr[0];
		return ['is_subdomain'=>1,'is_domain'=>0,'is_folder'=>0,'url'=>$subdomain_name];
	} else if (empty($path)) {
		return ['is_subdomain'=>0,'is_domain'=>1,'is_folder'=>0,'url'=>$host];
	} else {
		return ['is_subdomain'=>0,'is_domain'=>0,'is_folder'=>1,'url'=>$path];
	}


}