<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'vendor/autoload.php'; // Load Composer autoload file
require_once 'vendor/ezyang/htmlpurifier/library/HTMLPurifier.php';
// use HTMLPurifier;

class Html_purifier {
    
    public function purify($dirty_html) {
        // Set HTML Purifier configuration options
        $config = HTMLPurifier_Config::createDefault();
        $config->set('Core.Encoding', 'UTF-8');
        $config->set('HTML.Doctype', 'HTML 4.01 Transitional');
        $config->set('Cache.SerializerPath', APPPATH.'cache/htmlpurifier');
        
        // Create HTML Purifier instance and purify the input HTML
        $purifier = new HTMLPurifier($config);
        $clean_html = $purifier->purify($dirty_html);
        
        return $clean_html;
    }
}


// require_once("vendor/ezyang/htmlpurifier/library/HTMLPurifier.php");
// require_once("vendor/ezyang/htmlpurifier/library/HTMLPurifier/Config.php");
// use \HTMLPurifier;
// use \HTMLPurifier_Config;

// class Html_purifier {
//     protected $purifier;

//     public function __construct()
//     {
//         $config = HTMLPurifier_Config::createDefault();
//         $config->set('Core.Encoding', 'UTF-8');
//         $config->set('HTML.Doctype', 'HTML 4.01 Transitional');
//         $config->set('HTML.Allowed', 'p,b,i,a[href]');
//         $this->purifier = new HTMLPurifier($config);
//     }

//     public function purify($html)
//     {
//         return $this->purifier->purify($html);
//     }
// }
