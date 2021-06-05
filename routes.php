<?php
$controllers = array(
    'pages' => ['home', 'error', 'unauthorized'],
    'posts' => ['index', 'showPost', 'getPage', 'quickSearch'],
    'auth' => ['index', 'login', 'register', 'logout', 'verifyRegister', 'verifyLogin'],
    'users' => ['index', 'changeProfile', 'getFavourites', 'updateProfile', 'addFavouriteVideo', 'removeFavouriteVideo'],
    'images' => ['uploadAvatar', 'getAvatar', 'getAvatarError', 'uploadThumbnail'],
    'admin' => ['index','show', 'upload', 'update', 'delete', 'search'],
    'base' => ['invalidRequest']
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