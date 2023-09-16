<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$settings = settings();
$stripe = json_decode($settings['stripe_config'],TRUE);
$config['public_key'] = !empty($stripe['public_key'])?$stripe['public_key']:'';
$config['secret_key'] = !empty($stripe['secret_key'])?$stripe['secret_key']:'';
$config['currency_code'] = get_currency('currency_code');