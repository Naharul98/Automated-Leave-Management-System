<?php

namespace App\Http\Controllers\Home_Area;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;


/*
|--------------------------------------------------------------------------
| Home Page Controller
|--------------------------------------------------------------------------
|
| This controller is responsible for handling views in the HomePage of the
| website
*/
class HomePageController extends Controller
{
    /**
     * returns view for the homepage of the website
     *
     * @return view
     */
    public function index()
    {
    	return view('home_area.index');
    }

}
