<?php
$ajaxReq ? require_once '../core/mainModel.php' : require_once './core/mainModel.php';

class adminModel extends mainModel
{
	protected function add_admin_model($data)
	{
		$sql = mainModel::connect()->prepare(
			"INSERT INTO 
			admins(AdminDNI, AdminName, AdminLastname, AdminPhone, AdminAddress, AccountCode) 
			VALUES(:DNI, :Name, :Lastname, :Phone, :Address, :Code)"
		);
		$params = [':DNI', ':Name', ':Lastname', ':Phone', ':Address', ':Code'];
		mainModel::bindMultiplesParams($sql, $params, $data);
		$sql->execute();
		return $sql;
	}
}