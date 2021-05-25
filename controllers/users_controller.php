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
                $ava_url = $_SESSION['session_ava_url'];
            }

            $id = Accounts::updateAccountInfo(
                $_SESSION['session_user_id'],
                $_POST['username'],
                $ava_url,
                $_SESSION['session_user_type']
            );

            if ($id < 0) {
                $res = array(
                    "success" => false,
                    "body" => array(
                        "errMessage" => "Error in updating user profile!"
                    )
                );
            } else {
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
