<?php
require_once('controllers/base_controller.php');
require_once('dao/videos.php');
require_once('dao/comments.php');
require_once('dao/votes.php');
require_once('dao/categories.php');

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
        $videosCount = Videos::countVideos();
        $data = array('posts' => $posts, 'videosCount' => $videosCount);
        $this->render('page', $data);
    }

    public function showPost()
    {
        $post = Videos::find($_GET['id']);
        $comments = Comments::getCommentsInVideo($_GET['id']);
        $data = array('post' => $post, 'comments' => $comments);
        Videos::increaseView($post->id);
        $this->render('show', $data);
    }

    public function getVotedTypeVideo()
    {
        $res = array();

        if (isset($_POST["video_id"]) && isset($_SESSION['session_user_id'])) {

            $videoId = $_POST["video_id"];

            $vote = Votes::getVotedTypeVideo($_SESSION['session_user_id'], $videoId);

            if ($vote != null) {
                $res["success"] = true;
                $res["body"] = array(
                    "vote_type" => $vote,
                );
            } else {
                $res["success"] = false;
                $res["body"] = array(
                    "errMessage" => "Get vote failed"
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

    public function voteVideo()
    {
        $res = array();
        if (isset($_POST["video_id"]) && isset($_SESSION['session_user_id'])) {
            $videoId = $_POST["video_id"];
            $vote_type = $_POST["vote_type"];
            $vote = Votes::voteVideo($_SESSION['session_user_id'], $videoId, $vote_type);
            if ($vote != null) {
                $res["success"] = true;
            } else {
                $res["success"] = false;
                $res["body"] = array(
                    "errMessage" => "Get vote failed"
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

    public function categoryList()
    {
        $categories = Categories::all();
        $data = array('categories' => $categories);
        $this->render('category_list', $data);
    }

    public function videosByCategory()
    {
        $res = array();
        if (isset($_POST["page"]) && isset($_POST["category"])) {
            $category = $_POST["category"];
            $page = $_POST["page"];
            $videos = Videos::browseVideosByCategory($category, $page);
            $count = Videos::countVideosByCategory($category);
            if ($videos != null) {
                $res["success"] = true;
                $res["body"] = array(
                    "videos" => $videos,
                    "category" => $category,
                    "count" => $count,
                );
            } else {
                $res["success"] = false;
                $res["body"] = array(
                    "errMessage" => "Get videos failed"
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