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
        $_SESSION['session_valid'] = false;
        unset($_SESSION['session_username']);
        unset($_SESSION['session_user_ava_url']);
        unset($_SESSION['session_user_id']);
        unset($_SESSION['session_user_email']);
        unset($_SESSION['session_user_tel_no']);
        unset($_SESSION['session_user_type']);
        unset($_SESSION['session_user_fullname']);

        header('Refresh: 1; url=index.php?controller=posts');
    }

    public function verifyLogin()
    {
        $res = array();

        if (
            isset($_POST["username"])
            && isset($_POST["password"])
        ) {
            $username = $_POST["username"];
            $password = $_POST["password"];

            $account = Accounts::findAccountByUserName($username);

            if ($account != null) {
                if (password_verify($password, $account->password)) {
                    $this->success = true;
                    $this->errorMessage = "";

                    $_SESSION['session_valid'] = true;
                    $_SESSION['session_timeout'] = time();
                    $_SESSION['session_username'] = $account->username;
                    $_SESSION['session_user_id'] = $account->id;
                    $_SESSION['session_user_ava_url'] = $account->avaUrl;
                    $_SESSION['session_user_email'] = $account->email;
                    $_SESSION['session_user_tel_no'] = $account->tel_no;
                    $_SESSION['session_user_type'] = $account->type;
                    $_SESSION['session_user_fullname'] = $account->fullname;

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
        } else {
            $res["success"] = false;
            $res["body"] = array(
                "errMessage" => "Invalid request"
            );
        }

        echo json_encode($res);
    }

    public function verifyRegister()
    {
        $res = array();

        $regex_password = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,50}$/";
        $regex_name = "/^[a-zA-Z ]+$/";
        $regex_email = "/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i";
        $regex_phone = "/(84|0[3|5|7|8|9])+([0-9]{8})\b/";

        if (
            isset($_POST["username"])
            && isset($_POST["password"])
            && isset($_POST["email"])
            && isset($_POST["phone_number"])
            && isset($_POST["full_name"])
        ) {
            if (!preg_match($regex_password, $_POST["password"])) {
                $res["success"] = false;
                $res["body"] = array(
                    "errMessage" => "Invalid password"
                );
                echo json_encode($res);
                return;
            }
            if (!preg_match($regex_name, $_POST["full_name"])) {
                $res["success"] = false;
                $res["body"] = array(
                    "errMessage" => "Invalid name"
                );
                echo json_encode($res);
                return;
            }
            if (!preg_match($regex_email, $_POST["email"])) {
                $res["success"] = false;
                $res["body"] = array(
                    "errMessage" => "Invalid email"
                );
                echo json_encode($res);
                return;
            }
            if (!preg_match($regex_phone, $_POST["phone_number"])) {
                $res["success"] = false;
                $res["body"] = array(
                    "errMessage" => "Invalid phone number"
                );
                echo json_encode($res);
                return;
            }

            $username = $_POST["username"];
            $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $email = $_POST["email"];
            $phoneNumber = $_POST["phone_number"];
            $fullname = $_POST["full_name"];

            $account = Accounts::addNewAccount($username, $password, $fullname, email: $email, tel_no: $phoneNumber);

            if ($account != null && $password != null) {
                $res["success"] = true;
                $res["body"] = array(
                    "user_id" => $account->id,
                    "username" => $account->username,
                );
            } else {
                $res["success"] = false;
                $res["body"] = array(
                    "errMessage" => "Account existed"
                );
            }
        } else {
            $res["success"] = false;
            $res["body"] = array(
                "errMessage" => "Invalid request"
            );
        }

        echo json_encode($res);
    }


    public function changePassword()
    {
        $res = array();

        $regex_password = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,50}$/";

        if (
            isset($_POST["old_password"])
            && isset($_POST["new_password"])
            && isset($_SESSION['session_user_id'])
        ) {
            if (!preg_match($regex_password, $_POST["new_password"])) {
                $res["success"] = false;
                $res["body"] = array(
                    "errMessage" => "Invalid new password"
                );
                echo json_encode($res);
                return;
            }
            // compare old_password
            $id = $_SESSION['session_user_id'];
            $acc = Accounts::find($id);
            if (password_verify($_POST["old_password"], $acc->password)) {
                // correct old password
                $password = password_hash($_POST["new_password"], PASSWORD_DEFAULT);
                if (Accounts::updateAccountPassword($id, $password) > 0) {
                    // Success
                    $res["success"] = true;
                } else {
                    $res["success"] = false;
                    $res["body"] = array(
                        "errMessage" => "Failed to update in DB"
                    );
                }
            }
            else {
                $res["success"] = false;
                $res["body"] = array(
                    "errMessage" => "Incorrect old password"
                );
            }
        } else {
            $res["success"] = false;
            $res["body"] = array(
                "errMessage" => "Invalid request"
            );
        }

        echo json_encode($res);
    }
}
