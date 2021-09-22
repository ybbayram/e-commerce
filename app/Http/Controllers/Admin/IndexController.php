<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\{Yorum};


class IndexController extends AdminController
{
    public function index(){

        $yorum = Yorum::where('durum', 0)->orderBy('created_at', 'DESC')->get();
        return view('admin.anasayfa.index', compact('yorum'));
    }
}
