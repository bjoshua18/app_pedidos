<?php
require_once './models/viewModel.php';

class viewController extends viewModel {
	public function getTemplate() {
		return require_once 'views/template.php';
	}

	public function getViewController() {
		if(isset($_GET['view'])) {
			$route = explode('/', $_GET['view']);
			$resp = viewModel::getViewModel($route[0]);
		} else {
			$resp = 'welcome';
		}
		return $resp;
	}
}