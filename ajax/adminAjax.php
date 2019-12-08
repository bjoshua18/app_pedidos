<?php
$ajaxReq = true;
require_once '../core/generalConfig.php';
if(isset($_POST['dni-reg'])) {
	require_once '../controllers/adminController.php';
	$insAdmin = new adminController();
	if(isset($_POST['name-reg']) && isset($_POST['lastname-reg']) && isset($_POST['address-reg']) && isset($_POST['user-reg']))
		echo $insAdmin->add_admin_controller();
} else {
	session_start();
	session_destroy();
	echo '<script>window.location.href = "'.SERVERURL.'login/"</script>';
}