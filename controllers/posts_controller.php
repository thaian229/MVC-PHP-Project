<?php
require_once('controllers/base_controller.php');
require_once('dao/videos.php');
require_once('dao/comments.php');

class PostsController extends BaseController
{
    function __construct()
    {
        $this->folder = 'posts';
    }

    public function index()
    {
        $posts = Videos::all();
        $data = array('posts' => $posts);
        $this->render('index', $data);
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
        $comments = Comments::getCommentsInVideo($_GET['id']);
        $data = array('post' => $post, 'comments' => $comments);
        $this->render('show', $data);

    }

    public function sendComment()
    {
        $res = array();
        $acc_id = $_SESSION['session_user_id'];
        $video_id = $_POST["video_id"];
        $content = $_POST["content"];
        $comments = Comments::addCommentToVideo($acc_id, $video_id, $content);

        if ($comments != null) {
            $res["success"] = true;
        }
        else {
            $res["success"] = false;
        }
        echo json_encode($res);
    }
}