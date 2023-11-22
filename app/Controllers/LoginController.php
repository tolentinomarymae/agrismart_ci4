<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class LoginController extends BaseController
{
    public function register()
    {
        return view ('register');
    }
    public function login()
    {
        return view ('login/index');
    }
    public function dashboards()
    {
        return view ('userfolder/dashboard');
    }
}
