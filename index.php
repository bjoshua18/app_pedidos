<?php
require_once './core/generalConfig.php';
require_once './controllers/viewController.php';

$template = new viewController();
$template->getTemplate();