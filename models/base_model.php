<?php

class BaseModel
{
    public $id;

    public static function createFromDB($list)
    {
        $instance = new self();
        $instance->id = $list['id'];

        return $instance;
    }
}