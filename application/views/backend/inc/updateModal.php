<?php if(isset($page_title) && in_array($page_title, ['Dashboard','Total User','Packages']) || $uri = $this->uri->segment(2)=="dashboard"): ?>
<?php if(defined('IS_UPDATE') && IS_UPDATE==1 && USER_ROLE==1): ?>
      <?php include APPPATH."views/backend/dashboard/system_update/updateModal.php"; ?>
<?php endif; ?>
<?php endif ?>