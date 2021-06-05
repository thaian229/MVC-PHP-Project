<?php

require_once 'models/base_model.php';

class Comment extends BaseModel
{
    public $id;
    public $acc_id;
    public $username;
    public $ava_url;
    public $video_id;
    public $content;

    public function __construct()
    {
        $arguments = func_get_args();
        $numberOfArguments = func_num_args();

        if (method_exists($this, $function = '__construct'.$numberOfArguments)) {
            call_user_func_array(array($this, $function), $arguments);
        }
    }

    function __construct6($id, $acc_id, $username, $ava_url = '', $video_id, $content)
    {
        $this->id = $id;
        $this->acc_id = $acc_id;
        $this->username = $username;
        $this->ava_url = $ava_url;
        $this->video_id = $video_id;
        $this->content = $content;
    }

    public static function createFromDB($list)
    {
        $instance = new self(
            $list['id'], $list['acc_id'], $list['username'], $list['ava_url'], 
            $list['video_id'], $list['contents']
        );
        
        return $instance;
    }
}