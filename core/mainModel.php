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
}