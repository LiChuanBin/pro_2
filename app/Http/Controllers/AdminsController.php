<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminsController extends Controller
{
    //后台显示页面
    public function indexs()
    {
    	return view('admins.indexs');
    }
}
