<?php
require_once('controllers/base_controller.php');
require_once('dao/accounts.php');

class UsersController extends BaseController
{
    function __construct()
    {
        $this->folder = 'user';
    }

    public function index()
    {
        $this->render('index');
    }

    public function getFavourites()
    {

    }

    public function changeProfile()
    {
        $this->render('change_profile');
    }

    public function updateProfile()
    {

    }

}