<?php
require_once('controllers/base_controller.php');
require_once('dao/accounts.php');

class AuthController extends BaseController
{
    function __construct()
    {
        $this->folder = 'auth';
    }

    public function index()
    {
        if (isset($_SESSION['session_username'])) {
            header("location: index.php");
        } else {
            $this->login();
        }
    }

    public function login()
    {
        if (isset($_SESSION['session_username'])) {
            header("location: index.php");
        } else {
            $this->render('login');
        }
    }

    public function register()
    {
        if (isset($_SESSION['username'])) {
            header("location: index.php");
        } else {
            $this->render('register');
        }
    }

    public function logout()
    {

       unset($_SESSION['session_username']);
       unset($_SESSION['session_ava_url']);
       unset($_SESSION['session_user_id']);
       unset($_SESSION['session_user_type']);

        header('Refresh: 1; url=index.php?controller=posts');
    }

    public function verifyLogin()
    {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $res = array();

        $account = Accounts::findAccountByUserName($username);

        if ($account != null) {
            if (strcmp($password, $account->password) == 0) {
                $this->success = true;
                $this->errorMessage = "";

                $_SESSION['session_valid'] = true;
                $_SESSION['session_timeout'] = time();
                $_SESSION['session_username'] = $account->username;
                $_SESSION['session_user_id'] = $account->id;
                $_SESSION['session_ava_url'] = $account->avaUrl;
                $_SESSION['session_user_type'] = $account->type;

                $res["success"] = true;
                $res["body"] = array(
                    "user_id" => $account->id,
                    "username" => $account->username
                );

            } else {
                $res["success"] = false;
                $res["body"] = array(
                    "errMessage" => "Wrong password"
                );
            }
        } else {
            $res["success"] = false;
            $res["body"] = array(
                "errMessage" => "Account not exists"
            );
        }

        echo json_encode($res);
    }

    public function verifyRegister()
    {
        $res = array();
        
        $username = $_POST["username"];
        $password = $_POST["password"];


        $account = Accounts::addNewAccount($username, $password);

        if ($account != null && $password != null) {
            $res["success"] = true;
            $res["body"] = array(
                "user_id" => $account->id,
                "username" => $account->username
            );

        } else {
            $res["success"] = false;
            $res["body"] = array(
                "errMessage" => "Account existed"
            );
        }

        echo json_encode($res);
    }
}