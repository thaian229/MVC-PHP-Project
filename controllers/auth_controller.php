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
        if (isset($_SESSION['username'])) {
            header("location: index.php");
        } else {
            $this->login();
        }
    }

    public function login()
    {
        if (isset($_SESSION['username'])) {
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
        unset($_SESSION["username"]);
        unset($_SESSION["password"]);
        header('Refresh: 0');
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

                $_SESSION['valid'] = true;
                $_SESSION['timeout'] = time();
                $_SESSION['username'] = $account->username;
                $_SESSION['user_id'] = $account->id;

                $res["success"] = true;
                $res["body"] = array(
                    "user_id" => $account->id,
                    "username" => $account->username
                );
//                header("location: " . BASE_PATH . "index.php");
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