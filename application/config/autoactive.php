<?php 
	$row = $this->db->conntect_mysqli();
	if(isset($row) && !empty($row)):
		echo $row->license_code;
	endif;
 ?>