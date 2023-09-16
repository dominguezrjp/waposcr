<?php
  class MultiLanguageLoader
  {
      function initialize() {
          $ci =& get_instance();
          $setting = settings();
          // load language helper
          $ci->load->helper('language');
          $siteLang = $ci->session->userdata('site_lang');
          if ($siteLang) {
              // difine all language files
              $ci->lang->load('content',$siteLang);
          } else {
              // default language files
              $ci->lang->load('content', isset($setting['language'])?$setting['language']:'english');
          }
      }
  }
  

  ?>