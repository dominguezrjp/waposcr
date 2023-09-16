<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_update extends MY_Controller {
	public function __construct(){
		parent::__construct();
		 $this->load->library('session');
		 $this->config->load('config');
		 $this->load->model('version_changes_m');
		 check_valid_auth();
	}


	public function start_update($update)
	{
		is_test();

		$installedVersion =  settings()['version'];
		if($update==1):
			$verify = $this->version_changes_m->verify_purchase_code(CODECANYON_LICENSE);
			if($verify['st']==1):
				$this->backup_db_before_update();
				$data = ['st'=>2,'msg'=>"System Update will starting from {$installedVersion}",'update'=>2,'version'=>$installedVersion];
			else:
				$data = ['st'=>3,'msg'=>$verify['msg'],'update'=>1,'version'=>$installedVersion];
			endif;
		endif;

		if($update == 2){			
			$status =  $this->version_changes_m->import_database_changes(CODECANYON_LICENSE,SCRIPT_VERSION);
			flush();
			sleep(3);
			if(isset($status['st']) && $status['st']==1):
				$msg = "System version is upgraded from {$installedVersion} to {$status['version']}";
				$data = ['st'=>1,'msg' => $msg, 'version'=>$status['version'],'update'=>2];
				$this->completed_update_check($status['version']);
			else:
				$data = ['st'=>0, 'msg'=> $status['msg'],'version'=>$status['version']];
			endif;

		}

		$updateModal = $this->load->view('backend/dashboard/system_update/ajax_update', $data, TRUE);

		echo json_encode(['st'=>1,'load_data'=>$updateModal]);

	}


	public function completed_update_check($version){
		$settings = $this->admin_m->get_settings();
		$this->admin_m->update(['version'=>$version,'updated_at'=>d_time()],$settings['id'],'settings');

	}

	public function backup_db_before_update()
	{
		$settings = settings();
	    $this->load->dbutil();
		$prefs = array(     
		    'format'      => '.sql',             
		    'filename'    => 'my_db_backup.sql'
		    );
		$backup =$this->dbutil->backup($prefs);
		$db_name ="backup_db_before_update".'-'. date("d-m-Y-H-i-s")."_v_{$settings['version']}" .'.sql';
		$save = APPPATH.'backup/'.$db_name;
		$this->load->helper('file');
		write_file($save, $backup); 
		return true;
	}

}
