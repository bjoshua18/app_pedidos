<?php

class viewModel {
	protected function getViewModel($view)
	{
		$acceptedViews = ['account', 'adminlist', 'category', 'categorylist', 'clientlist', 'data', 'home', 'newcategory',
		'newproduct', 'product', 'shoppingcart'];
		if (in_array($view, $acceptedViews)) {
			if (is_file("./views/pages/$view-view.php"))
				$route = "./views/pages/$view-view.php";
			else
				$route = 'welcome';
		} else if($view === 'login' || $view === 'register') {
			$route = $view;
		} else {
			$route = 'welcome';
		}
		return $route;
	}
}