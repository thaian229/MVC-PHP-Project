<?php
require_once('controllers/base_controller.php');
require_once('dao/accounts.php');
require_once('dao/videos.php');

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
        $res = array();
        $pageSize = 8;

        if (isset($_GET["page"]) && isset($_SESSION['session_user_id'])) {
            $page = strip_tags($_GET["page"]);

            $videosCount  = Videos::countVideosByFavourite($_SESSION['session_user_id']);
            $resultList = Videos::browseFavouriteVideos($_SESSION['session_user_id'], $page);

            // $videosCount = Videos::countVideos();
            // $resultList = Videos::browseVideosWithPagination($page);

            $res["success"] = true;
            $res["body"] = array(
                "videos" => $resultList,
                "totalPage" => ceil($videosCount / $pageSize)
            );
        } else {
            $res["success"] = false;
            $res["body"] = array(
                "errMessage" => "Invalid request"
            );
        }
        echo json_encode($res);
    }

    public function isFavouriteVideo()
    {
        $res = array();
        if (isset($_POST["video_id"]) && isset($_SESSION['session_user_id'])) {
            $videoId = strip_tags($_POST["video_id"]);
            $isFav = Videos::isVideoInFavourite($videoId, $_SESSION['session_user_id']);
            if ($isFav >= 0) {
                $res["success"] = true;
                $res["body"] = array(
                    "isFav" => $isFav,
                );
            } else {
                $res["success"] = false;
                $res["body"] = array(
                    "errMessage" => "Get favourite failed"
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

    public function addFavouriteVideo()
    {
        $res = array();

        if (isset($_POST["video_id"]) && isset($_SESSION['session_user_id'])) {

            $videoId = strip_tags($_POST["video_id"]);

            $addedId = Videos::addVideosToFavourite($videoId, $_SESSION['session_user_id']);

            if ($addedId >= 0) {
                $res["success"] = true;
                $res["body"] = array(
                    "videoId" => $addedId,
                );
            } else {
                $res["success"] = false;
                $res["body"] = array(
                    "errMessage" => "Add failed"
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

    public function removeFavouriteVideo()
    {
        $res = array();

        if (isset($_POST["video_id"]) && isset($_SESSION['session_user_id'])) {

            $videoId = strip_tags($_POST["video_id"]);

            $addedId = Videos::removeVideosFromFavourite($videoId, $_SESSION['session_user_id']);

            if ($addedId >= 0) {
                $res["success"] = true;
                $res["body"] = array(
                    "videoId" => $addedId,
                );
            } else {
                $res["success"] = false;
                $res["body"] = array(
                    "errMessage" => "Remove failed"
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

    public function changeProfile()
    {
        $this->render('change_profile');
    }

    public function updateProfile()
    {
        $res = array();

        $regex_name = "/^[a-zA-Z ]+$/";
        $regex_email = "/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i";
        $regex_phone = "/(84|0[3|5|7|8|9])+([0-9]{8})\b/";

        if (isset($_SESSION['session_user_id'])) {
            if (isset($_POST['ava_url'])) {
                $ava_url = strip_tags($_POST['ava_url']);
            } else {
                $ava_url = $_SESSION['session_user_ava_url'];
            }

            if (isset($_POST['email']) || strcmp($_POST['email'], "") != 0) {
                if (!preg_match($regex_email, $_POST["email"])) {
                    $res["success"] = false;
                    $res["body"] = array(
                        "errMessage" => "Invalid email"
                    );
                    echo json_encode($res);
                    return;
                }
                $email = strip_tags($_POST['email']);
            } else {
                $email = $_SESSION['session_user_email'];
            }

            if (isset($_POST['tel_no']) || strcmp($_POST['tel_no'], "") != 0) {
                if (!preg_match($regex_phone, $_POST["tel_no"])) {
                    $res["success"] = false;
                    $res["body"] = array(
                        "errMessage" => "Invalid phone number"
                    );
                    echo json_encode($res);
                    return;
                }
                $tel_no = strip_tags($_POST['tel_no']);
            } else {
                $tel_no = $_SESSION['session_user_tel_no'];
            }

            if (isset($_POST['fullname']) || strcmp($_POST['fullname'], "") != 0) {
                if (!preg_match($regex_name, $_POST["fullname"])) {
                    $res["success"] = false;
                    $res["body"] = array(
                        "errMessage" => "Invalid name"
                    );
                    echo json_encode($res);
                    return;
                }
                $fullname = $_POST['fullname'];
            } else {
                $fullname = $_SESSION['session_user_fullname'];
            }

            // TODO: thieu password va fullname

            $id = Accounts::updateAccountInfo(
                $_SESSION['session_user_id'],
                $_SESSION['session_username'],
                $fullname,
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
                $_SESSION['session_user_ava_url'] = $ava_url;
                $_SESSION['session_user_email'] = $email;
                $_SESSION['session_user_tel_no'] = $tel_no;
                $_SESSION['session_user_fullname'] = $fullname;
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
