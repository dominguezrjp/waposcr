<?php 
	class HtmlCleaner {

        protected $CI;

        public function __construct() {
            $this->CI =& get_instance();
            $this->CI->load->library('security');
        }

        public function clean($data) {
        if (is_array($data)) {
            foreach ($data as &$value) {
                $value = $this->clean($value);
            }
        } else {
            $data = $this->CI->security->xss_clean($data, TRUE);

            $allowed_tags = '<img>';
            $data = strip_tags($data, $allowed_tags);
        }

        return $data;
    }
}


 ?>