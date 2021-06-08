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
//        $categories = Categories::all();
//        $data = array('categories' => $categories);
//        $this->render('index', $data);
        header("Location: index.php?controller=posts&action=getPage&page=1");
    }

    public function categoryList()
    {
        $categories = Categories::all();
        $data = array('categories' => $categories);
        $this->render('index', $data);
    }

    public function getPage()
    {
        if (!isset($_GET['page'])) {
            header("Location: index.php?controller=posts&action=getPage&page=1");
        }
        $posts = Videos::browseVideosWithPagination($_GET['page']);
        $videosCount = Videos::countVideos();
        $data = array('posts' => $posts, 'videosCount' => $videosCount);
        $this->render('page', $data);
    }

    public function showPost()
    {
        $post = Videos::find($_GET['id']);
        $comments = Comments::getCommentsInVideo($_GET['id']);
        $posts = Videos::browseVideosWithPagination(1);
        $category = Categories::getCategoriesOfVideo($_GET['id']);
        if($category != null) {
            $same_posts = Videos::browseVideosByCategory($category[0]->catName, 1);
            $data = array('post' => $post, 'comments' => $comments, 'same_posts' => $same_posts, 'posts' => $posts);
        }
        else
        $data = array('post' => $post, 'comments' => $comments, 'posts' => $posts);
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
        $acc_name = $_SESSION['session_username'];
        $avatar_url = $_SESSION['session_user_ava_url'];
        $acc_id = $_SESSION['session_user_id'];
        $video_id = $_POST["video_id"];
        $content = $_POST["content"];
        $comments = Comments::addCommentToVideo($acc_id, $video_id, $content);

        if ($comments != null) {
            $res["success"] = true;
            $res["body"] = array(
                "acc_name" => $acc_name,
                "avatar_url" => $avatar_url
            );
        } else {
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

    public function videosByCategory()
    {
        $res = array();
        if (isset($_POST["page"]) && isset($_POST["category"])) {
            $category = $_POST["category"];
            $page = $_POST["page"];
            $videos = Videos::browseVideosByCategory($category, $page);
            if ($videos != null) {
                $res["success"] = true;
                $res["body"] = array(
                    "videos" => $videos,
                    "category" => $category,
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

    public function categoriesBar()
    {
        $categories = Categories::all();
        if ($categories != null) {
            $res["success"] = true;
            $res["body"] = array(
                "categories" => $categories,
            );
        } else {
            $res["success"] = false;
            $res["body"] = array(
                "errMessage" => "Invalid request"
            );
        }
        echo json_encode($res);
    }

        public
        function getCategory()
        {
            $category = $_GET["category"];
            $posts = Videos::browseVideosByCategory($category, $_GET['page']);
            $videosCount = Videos::countVideosByCategory($category);
            $data = array('posts' => $posts, 'videosCount' => $videosCount, 'category' => $category);
            $this->render('page', $data);
        }

        public
        function searchVideos()
        {
            $key = $_GET["key"];
            $posts = Videos::searchVideosByTitle($key, $_GET['page']);
            $videosCount = count(Videos::searchVideosByTitleNoPagination($key));
            $data = array('posts' => $posts, 'videosCount' => $videosCount, 'key' => $key);
            $this->render('page', $data);
        }
    }