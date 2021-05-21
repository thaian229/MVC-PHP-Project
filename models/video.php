<?php

require_once 'models/base_model.php';

class Video extends BaseModel
{
    public $id;
    public $title;
    public $videoUrl;

    function __construct($id, $title, $videoUrl)
    {
        $this->id = $id;
        $this->title = $title;
        $this->videoUrl = $videoUrl;
    }

    public static function createFromDB($list)
    {
        $instance = new self($list['id'], $list['title'], $list['video_url']);
        return $instance;
    }
}