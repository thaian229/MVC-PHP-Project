<?php
require_once('controllers/base_controller.php');

class LoginController extends BaseController
{
    function __construct()
    {
        $this->folder = 'authentication';
    }

    public function index()
    {
        $this->render('login');
    }

    public function login()
    {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $this->render('');
    }
}