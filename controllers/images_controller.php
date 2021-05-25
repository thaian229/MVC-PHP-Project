<?php

?>

<?php
require_once('controllers/base_controller.php');

class ImagesController extends BaseController
{
    function __construct()
    {
        $this->folder = '';
    }

    public function updateAvatar()
    {
        if (isset($_FILES["image"]) && isset($_SESSION['session_user_id'])) {
            $target_dir = "uploads/avatars/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                $target = $target_dir . 'ava_' . $_SESSION['session_user_id'] . '.' . $imageFileType;
                
                move_uploaded_file($_FILES['image']['tmp_name'], $target);

                $res = array(
                    "success" => true,
                    "body" => array(
                        "ava_url" => $target
                    )
                );
            } else {
                $res = array(
                    "success" => false,
                    "body" => array(
                        "errMessage" => $imageFileType . " files not allowed!"
                    )
                );
            }
        } else {
            $res = array(
                "success" => false,
                "body" => array(
                    "errMessage" => "INVALID REQUEST"
                )
            );
        }

        echo json_encode($res);
    }
}
