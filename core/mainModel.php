<?php
$ajaxReq ? require_once '../core/appConfig.php' : require_once './core/appConfig.php';

class mainModel
{
	// DB FUNCTIONS
	protected function connect() {
		return new PDO(DSN, DBUSER, DBPASS);
	}

	protected function execute_simple_query($query) {
		$resp = self::connect()->prepare($query);
		$resp->execute();
		return $resp;
	}

	protected function add_account($data) {
		$sql = self::connect()->prepare(
			'INSERT INTO 
			accounts(AccountCode, AccountLvl, AccountUser, AccountPassword, AccountEmail, AccountState, AccountType, AccountGender, AccountImage) 
			VALUES(:Code, :Lvl, :User, :Password, :Email, :State, :Type, :Gender, :Image)'
		);
		$params = [':Code', ':Lvl', ':User', ':Password', ':Email', ':State', ':Type', ':Gender', ':Image'];
		$this->bindMultiplesParams($sql, $params, $data);
		$sql->execute();
		return $sql;
	}

	protected function delete_account($code) {
		$sql = self::connect()->prepare('DELETE FROM accounts WHERE AccountCode=:Code');
		$sql->bindParam(':Code',$code);
		$sql->execute();
		return $sql;
	}

	// AUX FUNCTIONS
	public function encryption($string) {
		$output = false;
		$key = hash('sha256', SECRET_KEY);
		$iv = substr(hash('sha256', SECRET_IV), 0, 16);
		$output = openssl_encrypt($string, METHOD, $key, 0, $iv);
		$output = base64_encode($output);
		return $output;
	}

	protected function decryption($string) {
		$key = hash('sha256', SECRET_KEY);
		$iv = substr(hash('sha256', SECRET_IV), 0, 16);
		$output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
		return $output;
	}

	protected function generate_rand_code($char, $length, $num) {
		for($i = 1; $i < $length; $i++)
			$char .= rand(0,9);
		return $char . $num;
	}

	protected function clean_string($string) {
		$string = trim($string);
		$string = stripslashes($string);
		$string = str_ireplace('<script>', '', $string);
		$string = str_ireplace('</script>', '', $string);
		$string = str_ireplace('<script src', '', $string);
		$string = str_ireplace('<script type=', '', $string);
		$string = str_ireplace('SELECT * FROM', '', $string);
		$string = str_ireplace('DELETE FROM', '', $string);
		$string = str_ireplace('INSERT INTO', '', $string);
		$string = str_ireplace('--', '', $string);
		$string = str_ireplace('^', '', $string);
		$string = str_ireplace('[', '', $string);
		$string = str_ireplace(']', '', $string);
		$string = str_ireplace('==', '', $string);
		$string = str_ireplace(';', '', $string);

		return $string;
	}

	protected function sweet_alert($data) {
		$alert = '';
		if($data['Alert'] == 'simple') {
			$alert = "
				<script>
					swal(
						'{$data["Title"]}',
						'{$data["Text"]}',
						'{$data["Type"]}'
					)
				</script>
			";
		} elseif ($data['Alert'] == 'refresh') {
			$alert = "
				<script>
					swal({
						title: '{$data["Title"]}',
						text: '{$data["Text"]}',
						type: '{$data["Type"]}',
						confirmButtonText: 'Aceptar'
					}).then(() => location.reload())
				</script>
			";
		} elseif ($data['Alert'] == 'clean') {
			$alert = "
				<script>
					swal({
						title: '{$data["Title"]}',
						text: '{$data["Text"]}',
						type: '{$data["Type"]}',
						confirmButtonText: 'Aceptar'
					}).then((result) => $('.FormularioAjax')[0].reset())
				</script>
			";
		}
		return $alert;
	}

	protected function bindMultiplesParams(&$sql, $params, $vars) {
		$i = 0;
		foreach ($vars as $key => $var)
			$sql->bindParam($params[$i++], $vars[$key]);
	}

	protected function is_data_empty($data) {
		foreach ($data as $datum)
			if(empty($datum))
				return true;
		return false;
	}
}