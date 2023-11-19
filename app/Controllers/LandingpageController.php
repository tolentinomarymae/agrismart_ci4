<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class LandingpageController extends BaseController
{
    public function index()
    {
        return view ('index');
    }
}
