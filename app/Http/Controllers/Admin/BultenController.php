<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\{Bulten};
class BultenController extends AdminController
{
    public function index(){
        $bulten = Bulten::orderBy('created_at', 'asc')->get();
       return view('admin.etkilesim.bulten', compact('bulten'));
   }
}

