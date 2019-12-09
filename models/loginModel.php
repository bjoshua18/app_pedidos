<?php
$ajaxReq ? require_once '../core/mainModel.php' : require_once './core/mainModel.php';

class loginModel extends mainModel
{
	protected function login_model($data) {
		$query = 'SELECT * FROM accounts WHERE AccountUser=:User AND AccountPassword=:Password AND AccountState="Active"';
		$sql = mainModel::connect()->prepare($query);
		$params = [':User', ':Password'];
		mainModel::bindMultiplesParams($sql, $params, $data);
		$sql->execute();
		return $sql;
	}
}