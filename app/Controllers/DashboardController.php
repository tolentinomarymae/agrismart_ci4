<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function farmerdashboard()
    {
        return view ('userFolder/dashboard');
    }
}
