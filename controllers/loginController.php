<?php
$ajaxReq ? require_once '../models/loginModel.php' : require_once './models/loginModel.php';

class loginController extends loginModel
{
	public function login_controller() {
		// Almacenamos los datos del form
		$user = mainModel::clean_string($_POST['user']);
		$password = mainModel::encryption(mainModel::clean_string($_POST['password']));

		$dataLogin = [
			'User' => $user,
			'Password' => $password
		];
		// Enviamos los datos al model
		$dataAccount = loginModel::login_model($dataLogin);
		// Comprobamos si la cuenta existe
		if($dataAccount->rowCount() == 1) {
			// Guardamos los datos de la cuenta
			$account = $dataAccount->fetch();
			// Creamos la session de la cuenta
			session_start(['name' => 'AP']);
			$_SESSION['user'] = $account['AccountUser'];
			$_SESSION['type'] = $account['AccountType'];
			$_SESSION['lvl'] = $account['AccountLvl'];
			$_SESSION['image'] = $account['AccountImage'];
			$_SESSION['token'] = md5(uniqid(mt_rand(), true));
			$_SESSION['account_code'] = $account['AccountCode'];
			// Creamos la url donde será redireccionado segun el tipo de cuenta
			$url = SERVERURL.($account['AccountType'] == 'Admin' ? 'home/' : 'catalog/');
			return "<script>window.location = '$url'</script>";
		}
		else {
			$alert = [
				'Alert' => 'simple',
				'Title' => 'Ocurrió un error inesperador',
				'Text' => 'El nombre de usuario o contraseña son erróneos. Su cuenta puede estar deshabilitada',
				'Type' => 'error'
			];
			return mainModel::sweet_alert($alert);
		}
	}
}