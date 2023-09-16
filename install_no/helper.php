<?php 
    if(!function_exists('is_install')){
        function is_install(){
            $ROOTDIR = str_replace(['install'], [''], __DIR__);
            if(!defined('BASEPATH')){
                define('BASEPATH', $ROOTDIR);
            }
            $dir = $ROOTDIR . '/application/config/database.php';

            if(!file_exists($dir)):
                $content = '';
                $fp = fopen($dir,"wb");
                fwrite($fp,$content);
                fclose($fp);
            endif;

            if(file_exists($dir)):
                include $dir;
                if(isLocalHost()==1):
                    if(isset($db['default']['database']) && !empty($db['default']['database'])){
                        return 1;
                    }else{
                        return 0;
                    }
                else:
                     if(isset($db['default']['database']) && !empty($db['default']['password'])){
                        return 1;
                    }else{
                        return 0;
                    }
                endif;
            endif;
           
        }
    }


    if(!function_exists('check_version')){
        function check_version(){
            error_reporting(0);
            $ROOTDIR = str_replace(['install'], [''], __DIR__);
            if(!defined('BASEPATH')){
                define('BASEPATH', $ROOTDIR);
            }
            $dir = $ROOTDIR .'/application/config/version.php';
            if(!file_exists($dir)):
                include $ROOTDIR.'/application/config/config.php';
                $version = "<?php \n";
                $version .= "define('VERSION', '". $config['app_version'] ."'); \n";
                $version .= "define('SCRIPT_NAME', 'qmenu'); \n";
                $version .= "define('AUTHOR', 'codetrick'); \n";
                file_put_contents($ROOTDIR."/application/config/version.php", $version);
            endif;
            include_once $dir;
        }
    }

check_version();

	if(!function_exists('checkReq')){
    function checkReq(){
        $error = array();

        if (phpversion() < '7.2') {
            $error['php'] = 'Warning: You need to use PHP 7.2 or above for Script to work! | Minimum version 7.2';
        }

        if (!extension_loaded('mysqli')) {
            $error['mysqli'] = 'Warning: A database extension needs to be loaded in the php.ini for Script to work! | <div>Extension <i>mysqli</i></div> ';
        }

        if (!extension_loaded('curl')) {
            $error['curl'] = 'Warning: CURL extension needs to be loaded for Script to work! | Extension <i>php_curl</i>';
        } else{
            $ip = $_SERVER["REMOTE_ADDR"];

            $curl = curl_init("http://www.geoplugin.net/json.gp?ip=" . $ip);
            $request = '';
            curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            
            $ipdat = json_decode(curl_exec($curl),1);
            if(is_array($ipdat) && isset($ipdat['geoplugin_status'])){

            } else{
                $error['ipapi'] = 'Warning: IP Api Not Working | Extension <i>php_curl</i>';
            }
        }

        if (!function_exists('openssl_encrypt')) {
            $error['openssl_encrypt'] = 'Warning: OpenSSL extension needs to be loaded for Script to work! | Extension <i>openssl_encrypt</i>';
        }

        if (! class_exists('ZipArchive') ) {
            $error['ziparchive'] = 'Warning: ZipArchive extension needs to be installed for Script to work! | Extension <i>php_curl</i>';
        }
        

        $ini = phpinfo_array(true);
        if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false) {

        } else{
            $error['gzip'] = 'Warning:Enable Gzip compression for Script to work!';
        }
        
        if (is_array($ini) && isset($ini['Phar']['gzip compression']) && $ini['Phar']['gzip compression'] == 'enabled') {

            unset($error['gzip']);
        }

        if ((is_array($ini) && count($ini) > 0) && (!isset($ini['Core']['allow_url_fopen']) || !$ini['Core']['allow_url_fopen'] == 'On')) {
            $error['allow_url_fopen'] = 'Warning:Enable allow_url_fopen for integration script!';
        }

        $base = str_replace('install', '', __DIR__);
        define('BASE_URL',$base);
        $checkDir = [];
        $loopDir = [];
        $mainDir = 'uploads';
        $rootDir = ['big','files','orders_qr','pwa','qr_image','site_banners','site_images','thumb'];

        $arr = [
            'Config Directory Is Not Writable Set, 777 Permission to: application/config' => ($base . 'application/config'),
            'backup Directory Is Not Writable Set, 777 Permission to: application/backup' => ($base . 'application/backup'),
            'language Directory Is Not Writable Set, 777 Permission to: application/language' => ($base . 'application/language'),
            'cache Directory Is Not Writable Set, 777 Permission to: application/cache' => ($base . 'application/cache')
        ];


        foreach ($rootDir as $key => $dir) {
            $directory = $base.$mainDir.'/'.$dir;
            if (!file_exists($directory)) {
               $create = mkdir($directory, 0777, true);
            } else{
              $msg[] = "{$dir} Is Not Writable, Set 777 Permission to: {$mainDir} / {$dir}";
            }

            $loopDir[] =  ["{$dir} Directory Is Not Writable, Set 777 Permission to: uploads/" => ($base . 'uploads/'.$dir)];


        }

        foreach ($loopDir as $key => $value) {
            $checkDir = array_merge($checkDir,$value);
        }

        $checkDir = array_merge($checkDir,$arr);

        foreach ($checkDir as $key => $value) {
            if(is_file($value)) {
                $permissions = fileperms($value);
                $permissions = substr(sprintf('%o', $permissions), -4);
                if((string)$permissions != '0644') {
                    $error['writable'] = $key;
                }
                 
            } else {

                $test_filename = $value.'/index.html';
                /*if(!is_writable($test_filename)){
                    $error['writable'] = $key;
                }*/
                try {
                    unlink($test_filename);
                    @file_put_contents($test_filename, '');
                    if(!file_exists($test_filename)){
                        $error['writable'] = $key;
                    }
                } catch (Exception $e) {
                    $error['writable'] = $key;
                }
            }
        }
       
        //$error['ssl'] = is_ssl();
        return $error;
    }
}


if(!function_exists('phpinfo_array')){
    function phpinfo_array($return=false){
        ob_start(); 
        phpinfo(-1);

        $pi = preg_replace(
            array('#^.*<body>(.*)</body>.*$#ms', '#<h2>PHP License</h2>.*$#ms',
                '#<h1>Configuration</h1>#',  "#\r?\n#", "#</(h1|h2|h3|tr)>#", '# +<#',
                "#[ \t]+#", '#&nbsp;#', '#  +#', '# class=".*?"#', '%&#039;%',
                '#<tr>(?:.*?)" src="(?:.*?)=(.*?)" alt="PHP Logo" /></a>'
                .'<h1>PHP Version (.*?)</h1>(?:\n+?)</td></tr>#',
                '#<h1><a href="(?:.*?)\?=(.*?)">PHP Credits</a></h1>#',
                '#<tr>(?:.*?)" src="(?:.*?)=(.*?)"(?:.*?)Zend Engine (.*?),(?:.*?)</tr>#',
                "# +#", '#<tr>#', '#</tr>#'),
            array('$1', '', '', '', '</$1>' . "\n", '<', ' ', ' ', ' ', '', ' ',
              '<h2>PHP Configuration</h2>'."\n".'<tr><td>PHP Version</td><td>$2</td></tr>'.
              "\n".'<tr><td>PHP Egg</td><td>$1</td></tr>',
              '<tr><td>PHP Credits Egg</td><td>$1</td></tr>',
              '<tr><td>Zend Engine</td><td>$2</td></tr>' . "\n" .
              '<tr><td>Zend Egg</td><td>$1</td></tr>', ' ', '%S%', '%E%'),
            ob_get_clean());

        $sections = explode('<h2>', strip_tags($pi, '<h2><th><td>'));
        unset($sections[0]);

        $pi = array();
        foreach($sections as $section){
           $n = substr($section, 0, strpos($section, '</h2>'));
           preg_match_all(
               '#%S%(?:<td>(.*?)</td>)?(?:<td>(.*?)</td>)?(?:<td>(.*?)</td>)?%E%#',
               $section, $askapache, PREG_SET_ORDER);
           foreach($askapache as $m)
               $pi[$n][$m[1]]=(!isset($m[3])||$m[2]==$m[3])?$m[2]:array_slice($m,2);
       }

       return ($return === false) ? print_r($pi) : $pi;
   }
}


if(!function_exists('is_ssl')){
    function is_ssl() {
        if ( isset($_SERVER['HTTPS']) ) {
            if ( 'on' == strtolower($_SERVER['HTTPS']) )
                return true;
            if ( '1' == $_SERVER['HTTPS'] )
                return true;
        } elseif ( isset($_SERVER['SERVER_PORT']) && ( '443' == $_SERVER['SERVER_PORT'] ) ) {
            return true;
        }

        return false;
    }
}



if(!function_exists('current_date')){
    function current_date() {
        $dt = new DateTime('now',new DateTimezone('Asia/Dhaka'));
        return $dt->format('Y-m-d H:i:s');
    }
}


if(!function_exists('isLocalHost')){
    function isLocalHost(){
        $localhost = array(
            '127.0.0.1',
            '::1'
        );

        return in_array($_SERVER['REMOTE_ADDR'], $localhost);
    }
}


if(!function_exists('base_path')){
    function base_path($remove = ''){  
        $root=(isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST'];
        $root.= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
        return str_replace($remove, '', trim($root,'/'));
    }
}

if(!function_exists('getBaseUrl')){
    function getBaseUrl($remove = true) { 
        $url = base_path();
        if($remove) $url = str_replace(basename($url),"",$url);
        return trim(str_replace('/install','',$url),"/");
    }
}

if(!function_exists('root_url')){
    function root_url(){
        $root_url = strtok(trim(str_replace('/install', '', $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']),"/"),"?");
        $root_url = str_replace("proccess.php","", $root_url);
        $root_url = trim( $root_url,"/");
        $root_url = trim(str_replace(['https','http',':','//','www.','index.php','helper.php','codecanyon.php'],['','','','','','',''],$root_url),"/");

        return trim($root_url,"/");
    }
}

if(!function_exists('write')){
    function write($lang_name) {

                // Config path
            $name = $lang_name;
            $template_path  = FCPATH . 'application/hooks/lang.php';
            $output_path    = FCPATH . 'application/language/'.$lang_name.'/content_lang.php';

                // Open the file
            $database_file = file_get_contents($template_path);
            $new_data  = str_replace("%my%",$name,$database_file);
                // Write the new database.php file
            $handle = fopen($output_path,'w+');

                // Chmod the file, in case the user forgot
            @chmod($output_path,0777);

                // Verify file permissions
            if(is_writable($output_path)) {

                    // Write the file
                if(fwrite($handle,$new_data)) {
                    return true;
                } else {
                    return false;
                }

            } else {
                return false;
            }
        }
    }








 ?>