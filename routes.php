<?php
$controllers = array(
    'pages' => ['home', 'error', 'unauthorized'],
    'posts' => ['index', 'showPost'],
    'auth' => ['index', 'login', 'register', 'logout', 'verifyRegister', 'verifyLogin'],
    'users' => ['index', 'changeProfile', 'getFavourites', 'updateProfile']
);

if (!array_key_exists($controller, $controllers) || !in_array($action, $controllers[$controller])) {
    $controller = 'pages';
    $action = 'error';
}

include_once('controllers/' . $controller . '_controller.php');

$klass = str_replace('_', '', ucwords($controller, '_')) . 'Controller';

$controller = new $klass;
$controller->$action();
?>