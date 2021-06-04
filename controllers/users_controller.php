<?php
require_once('controllers/base_controller.php');
require_once('dao/accounts.php');

class UsersController extends BaseController
{
    function __construct()
    {
        $this->folder = 'user';
    }

    public function index()
    {
        $this->render('index');
    }

    public function getFavourites()
    {
    }

    public function changeProfile()
    {
        $this->render('change_profile');
    }

    public function updateProfile()
    {
        $res = array();

        if (isset($_SESSION['session_user_id'])) {
            if (isset($_POST['ava_url'])) {
                $ava_url = $_POST['ava_url'];
            } else {
                $ava_url = $_SESSION['session_user_ava_url'];
            }

            if (isset($_POST['email']) || strcmp($_POST['email'], "") != 0) {
                $email = $_POST['email'];
            } else {
                $email = $_SESSION['session_user_email'];
            }

            if (isset($_POST['tel_no']) || strcmp($_POST['tel_no'], "") != 0) {
                $tel_no = $_POST['tel_no'];
            } else {
                $tel_no = $_SESSION['session_user_tel_no'];
            }

            $id = Accounts::updateAccountInfo(
                $_SESSION['session_user_id'],
                $_SESSION['session_username'],
                $ava_url,
                $_SESSION['session_user_type'],
                $tel_no,
                $email,
            );

            if ($id < 0) {
                $res = array(
                    "success" => false,
                    "body" => array(
                        "errMessage" => "Error in updating user profile!"
                    )
                );
            } else {
                $_SESSION['session_user_ava_url'] =  $ava_url;
                $_SESSION['session_user_email'] =  $email;
                $_SESSION['session_user_tel_no'] =  $tel_no;
                $res = array(
                    "success" => true,
                    "body" => array(
                        "updated_id" => $id
                    )
                );
            }
        } else {
            $res = array(
                "success" => false,
                "body" => array(
                    "errMessage" => "No logged in user!"
                )
            );
        }

        echo json_encode($res);
    }
}
