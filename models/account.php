<?php

require_once 'models/base_model.php';

class Account extends BaseModel
{
    public $id;
    public $userName;
    public $password;
    public $avaUrl;
    public $type;

    function __construct($id, $userName, $password = "")
    {
        $this->id = $id;
        $this->userName = $userName;
        $this->password = $password;
    }

    public static function createFromDB($list)
    {
        $instance = new self($list['id'], $list['username'], $list['password'], $list['ava_url']);
        $instance->avaUrl = $list['ava_url'];
        $instance->type = $list['type'];
        return $instance;
    }
}