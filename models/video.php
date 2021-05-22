<?php

require_once 'models/base_model.php';

class Video extends BaseModel
{
    public $id;
    public $title;
    public $videoUrl;
    public $thumbnailUrl;
    public $views;
    public $upvotes;
    public $downvotes;

    public function __construct()
    {
        $arguments = func_get_args();
        $numberOfArguments = func_num_args();

        if (method_exists($this, $function = '__construct'.$numberOfArguments)) {
            call_user_func_array(array($this, $function), $arguments);
        }
    }

    function __construct3($id, $title, $videoUrl)
    {
        $this->id = $id;
        $this->title = $title;
        $this->videoUrl = $videoUrl;
        $this->thumbnailUrl = '';
        $this->views = 0;
        $this->upvotes = 0;
        $this->downvotes = 0;
    }

    function __construct7($id, $title, $videoUrl, $thumbnailUrl, $views, $upvotes, $downvotes)
    {
        $this->id = $id;
        $this->title = $title;
        $this->videoUrl = $videoUrl;
        $this->thumbnailUrl = $thumbnailUrl;
        $this->views = $views;
        $this->upvotes = $upvotes;
        $this->downvotes = $downvotes;
    }

    public static function createFromDB($list)
    {
        $instance = new self($list['id'], $list['title'], $list['video_url'], $list['thumbnail_url'], $list['views'], $list['upvotes'], $list['downvotes']);
        return $instance;
    }
}