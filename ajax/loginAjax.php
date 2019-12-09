<?php
$ajaxReq = true;
require_once '../core/generalConfig.php';
if(isset($_GET['Token'])) {
	require_once '../controllers/loginController.php';
	$logout = new loginController();
	echo $logout->logout_controller();
} else {
	session_start(['name' => 'AP']);
	session_destroy();
	echo '<script>window.location.href = "'.SERVERURL.'login/"</script>';
}