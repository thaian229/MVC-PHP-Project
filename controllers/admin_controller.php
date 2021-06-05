<?php
require_once('controllers/base_controller.php');
require_once('dao/accounts.php');
require_once('dao/videos.php');
require_once('dao/categories.php');

class AdminController extends BaseController
{
    function __construct()
    {
        $this->folder = 'admin';
    }

    public function show()
    {
        $videos = Videos::all();
        $categories = Categories::all();
        $data = array(
            'videos' => $videos,
            'categories' => $categories
        );
        $this->render('index', $data);
    }

    public function search()
    {
        if(isset($_POST['search']))
        {
            $key = $_POST['search'];
            $videos = Videos::searchVideosByTitleNoPagination($key);
            $categories = Categories::all();
            $data = array(
                'videos' => $videos,
                'categories' => $categories
            );
            $this->render('index', $data);
        }
        else
        {
            $this->show();
        }
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
            $this->show();
        }
    }

    public function update()
    {
        $res = array();

        if (isset($_SESSION['session_user_id'])) {
            if (isset($_POST['thumbnail_url'])) {
                $thumbnail_url = $_POST['thumbnail_url'];
            } else {
                $thumbnail_url = null;
            }

            $id = Videos::updateVideo(
                $_POST['video_id'],
                $_POST['video_title'],
                $_POST['video_url'],
                $thumbnail_url
            );

            if ($id < 0) {
                $res = array(
                    "success" => false,
                    "body" => array(
                        "errMessage" => "Error in updating video info!"
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
                    "errMessage" => "No logged in admin!"
                )
            );
        }

        echo json_encode($res);
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
                        "errMessage" => "Error in uploading video!"
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
                    "errMessage" => "No logged in admin!"
                )
            );
        }

        echo json_encode($res);
    }

    public function getVideoInfo()
    {
        $res = array();

        if (isset($_POST['video_id']))
        {
            $video_id = $_POST['video_id'];
            $v = Videos::find($video_id);
            if (!$v) {
                $res = array(
                    "success" => false,
                    "body" => array(
                        "errMessage" => "Failed to retrieve video info!"
                    )
                );
            } else {
                $res = array(
                    "success" => true,
                    "body" => array(
                        "video_title" => $v->title,
                        "video_thumbnailUrl" => $v->thumbnailUrl,
                        "video_url" => $v->videoUrl
                    )
                );
            }
        } else {
            $res = array(
                "success" => false,
                "body" => array(
                    "errMessage" => "Unknown Error"
                )
            );
        }

        echo json_encode($res);
    }

    public function getCategoryInfo()
    {
        $res = array();

        if (isset($_SESSION['session_user_id']))
        {
            $c = Categories::all();
            if (!$c) {
                $res = array(
                    "success" => false,
                    "body" => array(
                        "errMessage" => "Failed to retrieve video info!"
                    )
                );
            } else {
                $res = array(
                    "success" => true,
                    "body" => $c
                );
            }
        } else {
            $res = array(
                "success" => false,
                "body" => array(
                    "errMessage" => "Unknown Error"
                )
            );
        }

        echo json_encode($res);
    }
}