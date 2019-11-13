<?php
$ajaxReq ? require_once '../core/appConfig.php' : require_once './core/appConfig.php';

class mainModel
{
	// DB Functions
	protected function connect() {
		return new PDO(DSN, DBUSER, DBPASS);
	}

	protected function execute_simple_query($query) {
		$resp = self::connect()->prepare($query);
		$resp->execute();
		return $resp;
	}
}