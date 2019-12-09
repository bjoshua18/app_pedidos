<!DOCTYPE html>
<html lang="es">
<head>
	<title>Inicio</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="<?= SERVERURL ?>views/css/main.css">
	<!--====== Scripts -->
	<?php include 'views/modules/scripts.php' ?>
</head>
<body>
	<?php
		$ajaxReq = false;
		require_once './controllers/viewController.php';
		$vc = new viewController();
		$view = $vc->getViewController();

		if($view == 'welcome' || $view == 'login' || $view == 'register' || $view == '404'):
			require_once "./views/pages/$view-view.php";
		else:
			session_start(['name' => 'AP']);
	?>
<!-- SideBar -->
<?php include 'views/modules/sidebar.php' ?>

<!-- Content page-->
<section class="full-box dashboard-contentPage">
	<!-- NavBar -->
	<?php include 'views/modules/navbar.php' ?>

	<!-- Content page -->
	<?php require_once $view ?>
</section>
<?php endif ?>
</body>
</html>