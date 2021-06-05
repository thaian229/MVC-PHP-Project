<?php
ob_start();
session_start();

$post_controllers_actions = array(
    'auth' => ['verifyRegister', 'verifyLogin'],
    'users' => ['updateProfile'],
    'images' => ['uploadAvatar', 'uploadThumbnail'],
    'admin' => ['upload', 'update'],
    'posts' => ['quickSearch']
);

$auth_access_controllers = array(
    'users' => ['index', 'changeProfile']
);

$admin_access_controllers = array(
    'admin' => ['show', 'upload', 'delete', 'update', 'search']
);

if ($_SERVER["REQUEST_METHOD"] != "POST"
    && array_key_exists($controller, $post_controllers_actions)
    && in_array($action, $post_controllers_actions[$controller])
) {
    header("Location: index.php?controller=pages&action=error");
}

if (array_key_exists($controller, $auth_access_controllers)
    && in_array($action, $auth_access_controllers[$controller])
    && !isset($_SESSION['session_username'])
) {
    header("Location: index.php?controller=pages&action=unauthorized");
}

if (array_key_exists($controller, $admin_access_controllers)
    && in_array($action, $admin_access_controllers[$controller])
    && !isset($_SESSION['session_username'])
    && !($_SESSION['session_user_type'] == 1)
) {
    header("Location: index.php?controller=pages&action=unauthorized");
}