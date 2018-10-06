<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Services\CronService;
use Illuminate\Support\Facades\Auth;

class CronController extends Controller
{

    public function syncReportsForOldestUser()
    {
        CronService::syncReportsForOldestUser();
    }

    public function syncOldestReports() {
	    CronService::syncOldestReports();
    }

}
