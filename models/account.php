<?php

require_once 'models/base_model.php';

class Account extends BaseModel
{
    public $id;
    public $username;
    public $password;
    public $avaUrl;
    public $type;
    public $tel_no;
    public $email;

    public function __construct()
    {
        $arguments = func_get_args();
        $numberOfArguments = func_num_args();

        if (method_exists($this, $function = '__construct'.$numberOfArguments)) {
            call_user_func_array(array($this, $function), $arguments);
        }
    }

    function __construct3($id, $username, $password = "")
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }

    function __construct7(
        $id, $username, $password = "", $avaUrl = "",
        $type, $tel_no = "", $email = "")
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->avaUrl = $avaUrl;
        $this->type = $type;
        $this->tel_no = $tel_no;
        $this->email = $email;
    }

    public static function createFromDB($list)
    {
        $instance = new self(
            $list['id'], $list['username'], $list['password'], $list['ava_url'],
            $list['acc_type'], $list['tel_no'], $list['email']
        );
        
        return $instance;
    }
}