<?php
$ajaxReq ? require_once '../models/adminModel.php' : require_once './models/adminModel.php';

class adminController extends adminModel
{
	public function add_admin_controller()
	{
		// Comprobamos que los datos no esten vacios
		if(mainModel::is_data_empty($_POST)) {
			$alert = [
				'Alert' => 'simple',
				'Title' => 'Ocurrió un error inesperador',
				'Text' => 'Alguno de los datos están vacíos. Por favor, introduce todos los datos obligatorios',
				'Type' => 'error'
			];
		}
		else {
			// Limpiamos los datos
			$dni = mainModel::clean_string($_POST['dni-reg']);
			$name = mainModel::clean_string($_POST['name-reg']);
			$lastname = mainModel::clean_string($_POST['lastname-reg']);
			$phone = mainModel::clean_string($_POST['phone-reg']);
			$address = mainModel::clean_string($_POST['address-reg']);

			$user = mainModel::clean_string($_POST['user-reg']);
			$password1 = mainModel::clean_string($_POST['password1-reg']);
			$password2 = mainModel::clean_string($_POST['password2-reg']);
			$email = mainModel::clean_string($_POST['email-reg']);
			$gender = mainModel::clean_string($_POST['optionsGender']);
			$lvl = mainModel::clean_string($_POST['optionsLvl']);

			$image = $gender === 'Masculino' ? 'Male3Avatar.png' : 'Female3Avatar.png';

			// Comprobamos que los passwords coincidan
			if ($password1 != $password2) {
				$alert = [
					'Alert' => 'simple',
					'Title' => 'Ocurrió un error inesperador',
					'Text' => 'Las contraseñas que acabas de ingresar no coinciden. Por favor, intenta nuevamente',
					'Type' => 'error'
				];
			}
			else {
				$query1 = mainModel::execute_simple_query("SELECT AdminDNI FROM admins WHERE AdminDNI='$dni'");
				// Comprobamos si el DNI existe en la db
				if ($query1->rowCount() >= 1) {
					$alert = [
						'Alert' => 'simple',
						'Title' => 'Ocurrió un error inesperador',
						'Text' => 'El DNI que acaba de ingresar ya se encuentra registrado',
						'Type' => 'error'
					];
				}
				else {
					$query2 = mainModel::execute_simple_query("SELECT AccountEmail FROM accounts WHERE AccountEmail='$email'");
					// Comprobamos si el email existe en la db
					if ($query2->rowCount() >= 1) {
						$alert = [
							'Alert' => 'simple',
							'Title' => 'Ocurrió un error inesperador',
							'Text' => 'El EMAIL que acaba de ingresar ya se encuentra registrado',
							'Type' => 'error'
						];
					}
					else {
						$query3 = mainModel::execute_simple_query("SELECT AccountUser FROM accounts WHERE AccountUser='$user'");
						// Comprobamos si el usuario existe en la db
						if ($query3->rowCount() >= 1) {
							$alert = [
								'Alert' => 'simple',
								'Title' => 'Ocurrió un error inesperador',
								'Text' => 'El USUARIO que acaba de ingresar, ya se encuentra registrado',
								'Type' => 'error'
							];
						}
						else {
							// Generamos el codigo de la cuenta
							$query4 = mainModel::execute_simple_query("SELECT id FROM accounts");
							$number = ($query4->rowCount()) + 1;
							$code = mainModel::generate_rand_code('AC',7, $number);
							// Encriptamos la clave
							$enc_password = mainModel::encryption($password1);
							// Almacenamos los datos de la cuenta para enviar al adminModel
							$dataAccount = [
								'Code' => $code,
								'Lvl' => $lvl,
								'User' => $user,
								'Password' => $enc_password,
								'Email' => $email,
								'State' => 'Active',
								'Type' => 'Admin',
								'Gender' => $gender,
								'Image' => $image
							];
							$saveAccount = mainModel::add_account($dataAccount);
							// Comprobamos si se creo la cuenta en la db
							if($saveAccount->rowCount() >= 1) {
								$dataAdmin = [
									'DNI' => $dni,
									'Name' => $name,
									'Lastname' => $lastname,
									'Phone' => $phone,
									'Address' => $address,
									'Code' => $code
								];
								$saveAdmin = adminModel::add_admin_model($dataAdmin);
								// Comprobamos si se creo el admin en la db
								if($saveAdmin->rowCount() >= 1) {
									$alert = [
										'Alert' => 'clean',
										'Title' => 'Administrador registrado',
										'Text' => 'El administrador se registró con éxito en el sistema.',
										'Type' => 'success'
									];
								}
								else {
									mainModel::delete_account($code);
									$alert = [
										'Alert' => 'simple',
										'Title' => 'Ocurrió un error inesperador',
										'Text' => 'No se ha podido registrar la cuenta del administrador.',
										'Type' => 'error'
									];
								}
							}
							else {
								$alert = [
									'Alert' => 'simple',
									'Title' => 'Ocurrió un error inesperador',
									'Text' => 'No se ha podido registrar la cuenta del administrador.',
									'Type' => 'error'
								];
							}
						}
					}
				}
			}
		}
		return mainModel::sweet_alert($alert);
	}
}