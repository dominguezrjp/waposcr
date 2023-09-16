<?php  if( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
* CodeIgniter vCard  library
* Extended by Jeremy Gimbel [jeremy@jgimbel.com]
* Based upon vCard library for Codeigniter by Carlos Alcala [carlos.alcala@upandrunningsoftware.com]
* and class_vcard from Troy Wolf [troy@troywolf.com]
*
* March 3, 2010
*
* Usage within Codeigniter:
*
* Place the Vcard.php file in your system/application/libraries directory.
* Load the library using $this->load->library('vcard');
* Create an associative array for the card data using keys for each field that match those below
* Generate a vCard file using one of the generate methods (generate_string, generate_file, 
* generate_download)
*
* See sample app.php controller file for an example.
*
* Information at: http://dreadfullyposh.com/
*/

class vcard_lib
{
    // private CI instance
    private $ci;
    
    // private array for data from caller
    private $data;
    
    // private string for storing the text of the finished card
    private $card_string;
    
    
    public function __construct()
    {
        $this->ci =& get_instance();

    }
    
    
    /** 
     * Vcard class constructor 
     * 
     * Initializes the data array, either to blank values to values
     * provided in the parameters. An optional filename or directory
     * can be  specified to generate the vCard in one step
     * 
     * @access public 
     * @param array $data
     * @param string $filename
     *  
     */ 
    public function Vcard($data = false, $filename = false)
    {
        // initialize the array
        $this->data = array(
            'display_name' => null,
            'first_name' => null,
            'last_name' => null,
            'additional_name' => null,
            'name_prefix' => null,
            'name_suffix' => null,
            'nickname' => null,
            'username' => null,
            'title' => null,
            'role' => null,
            'department' => null,
            'company' => null,
            'work_po_box' => null,
            'work_extended_address' => null,
            'work_address' => null,
            'work_city' => null,
            'work_state' => null,
            'work_postal_code' => null,
            'work_country' => null,
            'home_po_box' => null,
            'home_extended_address' => null,
            'home_address' => null,
            'home_city' => null,
            'home_state' => null,
            'home_postal_code' => null,
            'home_country' => null,
            'office_tel' => null,
            'home_tel' => null,
            'cell_tel' => null,
            'fax_tel' => null,
            'pager_tel' => null,
            'email1' => null,
            'email2' => null,
            'url' => null,
            'photo' => null,
            'birthday' => null,
            'timezone' => null,
            'sort_string' => null,
            'note' => null,
            'revision_date' => null,
            'class' => null
        );
        
        // check if an array of data was provided
        // if so, add values from the array to the 
        // class data array
        if(is_array($data))
        {
            foreach($data as $item => $value)
            {
                $this->data[$item] = $value;
            }
        }
    
        // check if a filename was provided
        // if so, load the generate_file&#40;&#41; method
        if(is_string($filename))
        {
            
           $this->generate_file($filename); ;
    
        }
    
    }
    
    
    /** 
     * Load 
     * 
     * Initializes the data array, to values provided in 
     * the parameters. 
     * 
     * @access public 
     * @param array $data
     *  
     */ 
    public function load($data)
    {
        // initialize the array
        $this->data = array(
            'display_name' => null,
            'first_name' => null,
            'last_name' => null,
            'additional_name' => null,
            'name_prefix' => null,
            'name_suffix' => null,
            'nickname' => null,
            'username' => null,
            'title' => null,
            'role' => null,
            'department' => null,
            'company' => null,
            'work_po_box' => null,
            'work_extended_address' => null,
            'work_address' => null,
            'work_city' => null,
            'work_state' => null,
            'work_postal_code' => null,
            'work_country' => null,
            'home_po_box' => null,
            'home_extended_address' => null,
            'home_address' => null,
            'home_city' => null,
            'home_state' => null,
            'home_postal_code' => null,
            'home_country' => null,
            'office_tel' => null,
            'home_tel' => null,
            'cell_tel' => null,
            'fax_tel' => null,
            'pager_tel' => null,
            'email1' => null,
            'email2' => null,
            'url' => null,
            'photo' => null,
            'birthday' => null,
            'timezone' => null,
            'sort_string' => null,
            'note' => null,
            'revision_date' => null,
            'class' => null
        );
        
        // make sure data array was provided
        // if so, load the values into the class
        // data array
        if(is_array($data))
        {
            foreach($data as $item => $value)
            {
                $this->data[$item] = $value;
            }
        }
    
    }
    
    
    /** 
     * generate_file 
     * 
     * Generates a vcf file on the server. Accepts either 
     * a filename or directory. If a filename is provided
     * the method generates the vcf file with that name. If
     * a directory is provided, the filename is built from
     * the display name and the file is placed in the specified
     * directory.
     * 
     * @access public 
     * @param string $filename
     * @return string path and filename 
     */ 
    public function generate_file($filename)
    {
        $this->_build();
        
        if(is_dir($filename))
            $filename .= $this->_build_filename();
        
        $fh = fopen($filename, 'w');
        
        if(!$fh)
            return false;
        
        fwrite($fh, $this->card_string);
        fclose($fh);

        return $filename;
    }
    
    
    /** 
     * generate_string 
     * 
     * Generates a vcf formatted string. 
     * 
     * @access public 
     * @return string vcf formatted data 
     */ 
    public function generate_string()
    {
    
        $this->_build();
        return $this->card_string;
    
    }
    
    
    /** 
     * generate_download 
     * 
     * Generates a vcf file and forces a download to the
     * browser. Accepts a filename If a filename is not 
     * provided, the filename is built from the display 
     * name.
     * 
     * @access public 
     * @param string $filename
     */ 
    public function generate_download($filename = null)
    {
        $this->_build();
        
        if($filename == null)
        {
            $filename = $this->_build_filename();
        
        }
        $this->ci->load->helper('download');
        
        force_download($filename.'.vcf', $this->card_string);     
    
    
    }
    
    
    /** 
     * _build 
     * 
     * Generates a vcf formatted string from the data array 
     * and stores it in the private class variable
     * 
     * @access private 
     */ 
    private function _build()
    {
        /*
        For many of the values, if they are not passed in, we set defaults or
        build them based on other values.
        */

        if(!$this->data['class']) { $this->data['class'] = "PUBLIC"; }
        if(!$this->data['display_name']) 
        {
              $this->data['display_name'] = trim($this->data['first_name']." ".$this->data['last_name']);
        }
        if(!$this->data['sort_string']) { $this->data['sort_string'] = $this->data['last_name']; }
        if(!$this->data['sort_string']) { $this->data['sort_string'] = $this->data['company']; }
        if(!$this->data['timezone']) { $this->data['timezone'] = date("O"); }
        if(!$this->data['revision_date']) { $this->data['revision_date'] = date('Y-m-d H:i:s'); }

          $this->card_string = "BEGIN:VCARD\r\n";
        $this->card_string .= "VERSION:3.0\r\n";
        $this->card_string .= "CLASS:".$this->data['class']."\r\n";
        $this->card_string .= "PRODID:-//Phplime//EN\r\n";
        $this->card_string .= "REV:".$this->data['revision_date']."\r\n";
          $this->card_string .= "FN:".$this->data['display_name']."\r\n";
        $this->card_string .= "N:"
          .$this->data['last_name'].";"
          .$this->data['first_name'].";"
          .$this->data['additional_name'].";"
          .$this->data['name_prefix'].";"
          .$this->data['name_suffix']."\r\n";

        if($this->data['nickname']) { $this->card_string .= "NICKNAME:".$this->data['nickname']."\r\n"; }
        if($this->data['username']) { $this->card_string .= "USERNAME:".$this->data['username']."\r\n"; }
          if($this->data['title']) { $this->card_string .= "TITLE:".$this->data['title']."\r\n"; }
          if($this->data['company']) { $this->card_string .= "ORG:".$this->data['company']; }
          if($this->data['department']) { $this->card_string .= ";".$this->data['department']; }
          $this->card_string .= "\r\n";
      
          if($this->data['work_po_box']
        || $this->data['work_extended_address']
        || $this->data['work_address']
        || $this->data['work_city']
        || $this->data['work_state']
        || $this->data['work_postal_code']
        || $this->data['work_country']) 
        {
              $this->card_string .= "ADR;TYPE=work:"
            .$this->data['work_po_box'].";"
            .$this->data['work_extended_address'].";"
            .$this->data['work_address'].";"
            .$this->data['work_city'].";"
            .$this->data['work_state'].";"
            .$this->data['work_postal_code'].";"
            .$this->data['work_country']."\r\n";
        }
      
          if($this->data['home_po_box']
        || $this->data['home_extended_address']
        || $this->data['home_address']
        || $this->data['home_city']
        || $this->data['home_state']
        || $this->data['home_postal_code']
        || $this->data['home_country']) 
        {
              $this->card_string .= "ADR;TYPE=home:"
            .$this->data['home_po_box'].";"
            .$this->data['home_extended_address'].";"
            .$this->data['home_address'].";"
            .$this->data['home_city'].";"
            .$this->data['home_state'].";"
            .$this->data['home_postal_code'].";"
            .$this->data['home_country']."\r\n";
        }
    
        if($this->data['email1']) { $this->card_string .= "EMAIL;TYPE=internet,pref:".$this->data['email1']."\r\n"; }
        if($this->data['email2']) { $this->card_string .= "EMAIL;TYPE=internet:".$this->data['email2']."\r\n"; }
        if($this->data['office_tel']) { $this->card_string .= "TEL;TYPE=work,voice:".$this->data['office_tel']."\r\n"; }
        if($this->data['home_tel']) { $this->card_string .= "TEL;TYPE=home,voice:".$this->data['home_tel']."\r\n"; }
        if($this->data['cell_tel']) { $this->card_string .= "TEL;TYPE=cell,voice:".$this->data['cell_tel']."\r\n"; }
        if($this->data['fax_tel']) { $this->card_string .= "TEL;TYPE=work,fax:".$this->data['fax_tel']."\r\n"; }
        if($this->data['pager_tel']) { $this->card_string .= "TEL;TYPE=work,pager:".$this->data['pager_tel']."\r\n"; }
        if($this->data['url']) { $this->card_string .= "URL;TYPE=work:".$this->data['url']."\r\n"; }
          if($this->data['birthday']) { $this->card_string .= "BDAY:".$this->data['birthday']."\r\n"; }
          if($this->data['role']) { $this->card_string .= "ROLE:".$this->data['role']."\r\n"; }
          if($this->data['note']) { $this->card_string .= "NOTE:".$this->data['note']."\r\n"; }
          $this->card_string .= "TZ:".$this->data['timezone']."\r\n";
        $this->card_string .= "END:VCARD\r\n";
    
    }
    
    /** 
     * _build_filename 
     * 
     * Generates a filename from the display name
     * in the card data
     * 
     * @access private 
     * @return string filename 
     */ 
    private function _build_filename()
    {
        $filename = trim($this->data['display_name']);
        $filename = str_replace(" ", "_", $filename);
        $filename .= '.vcf';
        
        return $filename;
    
    }

}