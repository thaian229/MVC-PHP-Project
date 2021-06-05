<?php

class BaseController
{
    protected $folder;

    function render($file, $data = array())
    {
        $view_file = 'views/' . $this->folder . '/' . $file . '.php';
        if (is_file($view_file)) {
            extract($data);
            require_once('views/layouts/application.php');
        } else {
            header('Location: index.php?controller=pages&action=error');
        }
    }

    function invalidRequest()  {
        $res = array(
            "success"=> false,
            "body" => array(
                "errMessage" => "Request not found."
            )
        );

        echo json_encode($res);
    }
}