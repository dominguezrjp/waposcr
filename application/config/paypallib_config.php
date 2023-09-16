<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------
// Paypal IPN Class
// ------------------------------------------------------------------------
$settings = settings();
$paypal = json_decode($settings['paypal_config'],TRUE);
// Use PayPal on Sandbox or Live
$config['sandbox'] = isset($paypal['is_paypal_live']) && $paypal['is_paypal_live']==1?FALSE:TRUE;; // FALSE for live environment
// https://www.sandbox.paypal.com/businessmanage/preferences/website#
// PayPal Business Email ID


$config['business'] = !empty($paypal['paypal_email'])?$paypal['paypal_email']:'';
// If (and where) to log ipn to file
$config['paypal_lib_ipn_log_file'] = BASEPATH . 'logs/paypal_ipn.log';
$config['paypal_lib_ipn_log'] = TRUE;

// Where are the buttons located at 
$config['paypal_lib_button_path'] = 'buttons';

// What is the default currency?
$config['paypal_lib_currency_code'] = !empty($settings['currency_code'])?strtoupper($settings['currency_code']):'USD';

?>
