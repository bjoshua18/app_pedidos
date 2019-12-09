<div class="full-box login-container cover">
	<form action="" method="POST" autocomplete="off" class="logInForm">
		<p class="text-center text-muted"><i class="zmdi zmdi-account-circle zmdi-hc-5x"></i></p>
		<p class="text-center text-muted text-uppercase">Iniciar sesión</p>
		<div class="form-group label-floating">
			<label class="control-label" for="UserName">Usuario</label>
			<input class="form-control" id="UserName" name="user" type="text" required>
			<p class="help-block">Escribe tu nombre de usuario</p>
		</div>
		<div class="form-group label-floating">
			<label class="control-label" for="UserPass">Contraseña</label>
			<input class="form-control" id="UserPass" name="password" type="password" required>
			<p class="help-block">Escribe tu contraseña</p>
		</div>
		<div class="form-group text-center">
			<input type="submit" value="Iniciar sesión" class="btn btn-info" style="color: #FFF;">
		</div>
	</form>
</div>
<?php
	if(isset($_POST['user']) && isset($_POST['password'])) {
		require_once './controllers/loginController.php';
		$login = new loginController();
		echo $login->login_controller();
	}
?>