<?php

namespace App\Http\Controllers;

use App\Domains\DataSources\Jobs\FetchNewsJob;
use App\Domains\DataSources\Managers\NewsApiManager;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index() {
       dispatch(new FetchNewsJob(new NewsApiManager(app('NewsApiDriver'))));
    }
}
