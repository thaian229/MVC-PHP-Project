<?php
require_once('controllers/base_controller.php');
require_once('dao/accounts.php');
require_once('dao/videos.php');

class AdminController extends BaseController
{
    function __construct()
    {
        $this->folder = 'admin';
    }

    public function show()
    {
        $videos = Videos::all();
        $data = array('videos' => $videos);
        $this->render('index', $data);
    }

    public function search()
    {
        $this->render('index');
    }

    public function index()
    {
        $this->show();
    }

    public function delete()
    {
        if(isset($_GET['id']) && $_SESSION['session_user_type'] == 1)
        {
            $vid = $_GET['id'];
            Videos::removeById($vid);
            $videos = Videos::all();
            $data = array('videos' => $videos);
            $this->render('index', $data);
        }
    }

    public function update()
    {
        $videos = Videos::all();
        $data = array('videos' => $videos);
        $this->render('index', $data);
    }

    public function upload()
    {
        $res = array();

        if (isset($_SESSION['session_user_id'])) {
            if (isset($_POST['thumbnail_url'])) {
                $thumbnail_url = $_POST['thumbnail_url'];
            } else {
                $thumbnail_url = null;
            }

            $id = Videos::uploadVideo(
                $_POST['video_title'],
                $_POST['video_url'],
                $thumbnail_url
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