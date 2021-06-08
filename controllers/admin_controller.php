<?php
require_once('controllers/base_controller.php');
require_once('dao/accounts.php');
require_once('dao/videos.php');
require_once('dao/categories.php');
require_once('dao/votes.php');

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
            $key = strip_tags($_POST['search']);
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
            $vid = strip_tags($_GET['id']);
            Videos::removeById($vid);
            $this->show();
        }
    }

    public function update()
    {
        $res = array();

        $regex_url = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";

        if (isset($_SESSION['session_user_id']) && $_SESSION['session_user_type'] == 1) {
            if (isset($_POST['video_url'])) {
                if (!preg_match($regex_url, $_POST['video_url'])) {
                    $res["success"] = false;
                    $res["body"] = array(
                        "errMessage" => "Invalid url"
                    );
                    echo json_encode($res);
                    return;
                }
            }

            if (isset($_POST['thumbnail_url'])) {
                $thumbnail_url = $_POST['thumbnail_url'];
            } else {
                $v = Videos::find($_POST['video_id']);
                if ($v) {
                    $thumbnail_url = $v->thumbnailUrl;
                } else {
                    $thumbnail_url = null;
                }
            }
            
            $id = Videos::updateVideo(
                strip_tags($_POST['video_id']),
                strip_tags($_POST['video_title']),
                strip_tags($_POST['video_url']),
                $thumbnail_url
            );

            if (isset($_POST['video_category']))
            {
                $cat_list_string = strip_tags($_POST['video_category']);
                $tokens = explode(",", $cat_list_string);
                $cat_list = [];
                foreach ($tokens as $t)
                {
                    $cat_list[] = (int) $t;
                }
                
                if (is_countable($cat_list))
                {
                    Categories::removeAllCategoriesOfVideo($id);
                    foreach ($cat_list as $c)
                    {
                        Categories::addCategoryToVideo($id, $c);
                    }
                }
            }

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

        $regex_url = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";

        if (isset($_SESSION['session_user_id']) && $_SESSION['session_user_type'] == 1) {
            if (isset($_POST['video_url'])) {
                if (!preg_match($regex_url, $_POST['video_url'])) {
                    $res["success"] = false;
                    $res["body"] = array(
                        "errMessage" => "Invalid url"
                    );
                    echo json_encode($res);
                    return;
                }
            }

            if (isset($_POST['thumbnail_url'])) {
                $thumbnail_url = $_POST['thumbnail_url'];
            } else {
                $thumbnail_url = 'assets/images/video-default.jpeg';
            }

            $id = Videos::uploadVideo(
                strip_tags($_POST['video_title']),
                strip_tags($_POST['video_url']),
                $thumbnail_url
            );

            if (isset($_POST['video_category']))
            {
                $cat_list_string = strip_tags($_POST['video_category']);
                $tokens = explode(",", $cat_list_string);
                $cat_list = [];
                foreach ($tokens as $t)
                {
                    $cat_list[] = (int) $t;
                }
                
                if (is_countable($cat_list))
                {
                    Categories::removeAllCategoriesOfVideo($id);
                    foreach ($cat_list as $c)
                    {
                        Categories::addCategoryToVideo($id, $c);
                    }
                }
            }

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
            $video_id = strip_tags($_POST['video_id']);
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

    public function test()
    {
        // Votes::syncVote();

        // $vote_type = Votes::getVotedTypeVideo(4, 9);
        // $video = Videos::find(9);
        // echo ('current vote types: ' . '<br>');
        // echo ('vote: ' . $vote_type . ' up: ' . $video->upvotes . ' down: ' . $video->downvotes . '<br><br>');

        // Votes::voteVideo(4, 9, 1);
        // $vote_type = Votes::getVotedTypeVideo(4, 9);
        // $video = Videos::find(9);
        // echo ('Hit upvote: ' . '<br>');
        // echo ('vote: ' . $vote_type . ' up: ' . $video->upvotes . ' down: ' . $video->downvotes . '<br><br>');

        // Votes::voteVideo(4, 9, 0);
        // $vote_type = Votes::getVotedTypeVideo(4, 9);
        // $video = Videos::find(9);
        // echo ('Hit downvote: ' . '<br>');
        // echo ('vote: ' . $vote_type . ' up: ' . $video->upvotes . ' down: ' . $video->downvotes . '<br><br>');

        // Votes::voteVideo(4, 9, 1);
        // $vote_type = Votes::getVotedTypeVideo(4, 9);
        // $video = Videos::find(9);
        // echo ('Hit upvote: ' . '<br>');
        // echo ('vote: ' . $vote_type . ' up: ' . $video->upvotes . ' down: ' . $video->downvotes . '<br><br>');

        // Votes::voteVideo(4, 9, 1);
        // $vote_type = Votes::getVotedTypeVideo(4, 9);
        // $video = Videos::find(9);
        // echo ('Hit upvote again to unvote: ' . '<br>');
        // echo ('vote: ' . $vote_type . ' up: ' . $video->upvotes . ' down: ' . $video->downvotes . '<br><br>');

        // Votes::voteVideo(4, 9, 0);
        // $vote_type = Votes::getVotedTypeVideo(4, 9);
        // $video = Videos::find(9);
        // echo ('Hit downvote: ' . '<br>');
        // echo ('vote: ' . $vote_type . ' up: ' . $video->upvotes . ' down: ' . $video->downvotes . '<br><br>');

        // Votes::voteVideo(4, 9, 0);
        // $vote_type = Votes::getVotedTypeVideo(4, 9);
        // $video = Videos::find(9);
        // echo ('Hit downvote again to unvote: ' . '<br>');
        // echo ('vote: ' . $vote_type . ' up: ' . $video->upvotes . ' down: ' . $video->downvotes . '<br><br>');

        // Votes::removeVoteVideo(4, 9);
        // $vote_type = Votes::getVotedTypeVideo(4, 9);
        // $video = Videos::find(9);
        // echo ('Remove vote: ' . '<br>');
        // echo ('vote: ' . $vote_type . ' up: ' . $video->upvotes . ' down: ' . $video->downvotes . '<br><br>');

        $count = Videos::countVideosByCategory('food');
        echo ('food: ' . $count . '<br><br>');

        $count = Videos::countVideosByCategory('tech');
        echo ('tech: ' . $count . '<br><br>');

        $count = Videos::countVideosByCategory('sport');
        echo ('sport: ' . $count . '<br><br>');

        $cnt = Videos::countVideosByFavourite(8);
        echo ('8 fav: ' . $cnt . '<br><br>');
    }
}