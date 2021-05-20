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
        $posts = Videos::all();
        $data = array('posts' => $posts);
        $this->render('index', $data);
    }

    public function showPost()
    {
        $post = Videos::find($_GET['id']);
        $data = array('post' => $post);
        $this->render('show', $data);
    }
}