<?php
$controllers = array(
    'pages' => ['home', 'error', 'unauthorized'],
    'posts' => ['index', 'showPost', 'getPage', 'quickSearch', 'sendComment', 'increaseView', 'voteVideo',
                'getVotedTypeVideo', 'categoryList', 'videosByCategory', 'getCategory'],
    'auth' => ['index', 'login', 'register', 'logout', 'verifyRegister', 'verifyLogin','changePassword'],
    'users' => ['index', 'changeProfile', 'getFavourites', 'updateProfile', 'addFavouriteVideo', 'removeFavouriteVideo', 'isFavouriteVideo'],
    'images' => ['uploadAvatar', 'getAvatar', 'getAvatarError', 'uploadThumbnail'],
    'admin' => ['index', 'show', 'upload', 'update', 'delete', 'search', 'getVideoInfo', 'getCategoryInfo', 'test'],
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
