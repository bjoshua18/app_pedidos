<?php
$ajaxReq ? require_once '../models/adminModel.php' : require_once './models/adminModel.php';

class adminController extends adminModel
{
	public function add_admin_controller() {
		$dni = mainModel::clean_string($_POST['dni-reg']);
		$name = mainModel::clean_string($_POST['nombre-reg']);
		$lastname = mainModel::clean_string($_POST['apellido-reg']);
		$phone = mainModel::clean_string($_POST['phone-reg']);
		$address = mainModel::clean_string($_POST['address-reg']);

		$user = mainModel::clean_string($_POST['user-reg']);
		$password1 = mainModel::clean_string($_POST['password1-reg']);
		$password2 = mainModel::clean_string($_POST['password2-reg']);
		$email = mainModel::clean_string($_POST['email-reg']);
		$gender = mainModel::clean_string($_POST['optionsGender']);
		$lvl = mainModel::clean_string($_POST['lvl-reg']);

		$foto = $gender === 'Maculino' ? 'Male3Avatar.png' : 'Female3Avatar.png';

		if($password1 != $password2) {
			$alert = [
				'Alert' => 'simple',
				'Title' => 'Ocurrió un error inesperador',
				'Text' => 'Las contraseñas que acabas de ingresar no coinciden. Por favor, intenta nuevamente',
				'Type' => 'error'
			];
		} else {
			$query1 = mainModel::execute_simple_query("SELECT AdminDNI FROM admins WHERE AdminDNI='$dni'");
			if($query1->rowCount() >= 1) {
				$alert = [
					'Alert' => 'simple',
					'Title' => 'Ocurrió un error inesperador',
					'Text' => 'El DNI que acaba de ingresar, ya se encuentra registrado',
					'Type' => 'error'
				];
			} else {
				if($email !== '') {
					$query2 = mainModel::execute_simple_query("SELECT Account Email FROM accounts WHERE Account Email='$email'");
					$ec = $query2->rowCount();
				} else {
					$ec = 0;
					if($ec>=1) {
						$alert = [
							'Alert' => 'simple',
							'Title' => 'Ocurrió un error inesperador',
							'Text' => 'El EMAIL que acaba de ingresar, ya se encuentra registrado',
							'Type' => 'error'
						];
					} else {
						$query3 = mainModel::execute_simple_query("SELECT AccountUser FROM account WHERE Accountuser='$user'");
						if ($query3->rowCount() >= 1) {
							$alert = [
								'Alert' => 'simple',
								'Title' => 'Ocurrió un error inesperador',
								'Text' => 'El USUARIO que acaba de ingresar, ya se encuentra registrado',
								'Type' => 'error'
							];
						} else {

						}
					}
				}
			}
		}
		return mainModel::sweet_alert($alert);
	}
}