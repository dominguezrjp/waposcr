<?php 
session_start();
	if (!isset($_SESSION["purchase_code"])) {
        $_SESSION["error"] = "Invalid purchase code!";
        header("Location: index.php");
        exit();
    }

$db_config_path = 'application/config/database.php';

if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST) {
    
	require_once('includes/taskCoreClass.php');
	require_once('includes/databaseLibrary.php');

	$core = new Core();
	$database = new Database();


	if($core->checkEmpty($_POST) == TRUE)
	{
			$checkDB = $database->check_database($_POST);
		
            if($checkDB['st'] == 0)
            {
                    $message = $checkDB['msg'];
                    echo json_encode(array('st'=>0,'msg'=> $message));
            }
            else if ($core->checkFile() == 0)
            {
                    $message = "File application/config/database.php is Empty";
                    echo json_encode(array('st'=>0,'msg'=> $message));
            }
            else if ($core->write_db_config($_POST) == FALSE)
            {
                    $message = "The database configuration file could not be written, please chmod application/config/database.php file to 777";
                    echo json_encode(array('st'=>0,'msg'=> $message));
            }
            else if ($database->install($_POST)['st'] == 0)
            {
                    $message = $database->install($_POST)['msg'];
                    echo json_encode(array('st'=>0,'msg'=> $message));
            }
            else
            {
                 echo json_encode(array('st'=>1));  
            }   

           
	}
	else {
		$message ='The host, username, password, database name, and others informations are required.';
        echo json_encode(array('st'=>0,'msg'=> $message));
	}
	
	
}



 ?>