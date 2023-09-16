<?php 
$CI =& get_instance(); 
foreach($CI->db->get('language_data')->result() as $language):
    $lang[$language->keyword] = $language->ru;
endforeach;