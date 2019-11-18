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
		$sql->bindParam(':DNI', $data['DNI']);
		$sql->bindParam(':Name', $data['Name']);
		$sql->bindParam(':Lastname', $data['Lastname']);
		$sql->bindParam(':Phone', $data['Phone']);
		$sql->bindParam(':Address', $data['Address']);
		$sql->bindParam(':Code', $data['Code']);
		$sql->execute();
		return $sql;
	}
}