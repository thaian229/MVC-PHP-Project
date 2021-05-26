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

            require_once($view_file);

        } else {
            header('Location: index.php?controller=pages&action=error');
        }
    }
}