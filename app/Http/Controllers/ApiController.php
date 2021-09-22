<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Cookie;
use Auth;
use App\Models\{Ulke, UlkeKod, Ziyaretci, ZiyaretciUser};

class ApiController extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

 
}
