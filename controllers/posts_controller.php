<?php
require_once('controllers/base_controller.php');
require_once('dao/videos.php');

class PostsController extends BaseController
{
    function __construct()
    {
        $this->folder = 'posts';
    }

    public function index()
    {
        header("Location: index.php?controller=posts&action=getPage&page=1");
    }

    public function getPage()
    {
        $posts = Videos::browseVideosWithPagination($_GET['page']);
        $data = array('posts' => $posts);
        $this->render('page', $data);
    }

    public function showPost()
    {
        $post = Videos::find($_GET['id']);
        $data = array('post' => $post);
        $this->render('show', $data);
    }

    public function quickSearch()
    {
        $res = array();

        if (isset($_POST["keyword"])) {
            $keyword = $_POST["keyword"];

            $resultList = Videos::searchVideosByTitle($keyword, 1);

            $res["success"] = true;
            $res["body"] = array(
                "videos" => $resultList
            );

        } else {
            $res["success"] = false;
            $res["body"] = array(
                "errMessage" => "Invalid request"
            );
        }
        echo json_encode($res);
    }
}