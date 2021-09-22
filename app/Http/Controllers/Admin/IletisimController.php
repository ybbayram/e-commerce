<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\{Iletisim};

class IletisimController extends AdminController
{
    public function index(){
		$iletisim = Iletisim::orderByDesc('created_at')->get();

		return view('admin.iletisim.index', compact('iletisim'));
	}
}
