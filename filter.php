<?php
ob_start();
session_start();

$post_controllers_actions = array(
    'auth' => ['verifyRegister', 'verifyLogin'],
    'users' => ['getFavourites', 'updateProfile']
);

$auth_access_controllers = array(
    'users' => ['index', 'changeProfile']
);

if ($_SERVER["REQUEST_METHOD"] != "POST"
    && array_key_exists($controller, $post_controllers_actions)
    && in_array($action, $post_controllers_actions[$controller])
) {
    header("Location: index.php?controller=pages&action=error");
}

if (array_key_exists($controller, $auth_access_controllers)
    && in_array($action, $auth_access_controllers[$controller])
    && !isset($_SESSION['username'])
) {
    header("Location: index.php?controller=pages&action=unauthorized");

}