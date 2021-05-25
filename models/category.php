<?php

require_once 'models/base_model.php';

class Category extends BaseModel
{
    public $id;
    public $catName;

    public function __construct()
    {
        $arguments = func_get_args();
        $numberOfArguments = func_num_args();

        if (method_exists($this, $function = '__construct'.$numberOfArguments)) {
            call_user_func_array(array($this, $function), $arguments);
        }
    }

    function __construct2($id, $catName)
    {
        $this->id = $id;
        $this->catName = $catName;
    }

    public static function createFromDB($list)
    {
        $instance = new self($list['id'], $list['name']);
        
        return $instance;
    }
}