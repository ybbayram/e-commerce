<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\User;

class UsersController extends AdminController
{
	public function index(){

		$user = User::orderByDesc('created_at')->get();

		return view('admin.kullanici.index', compact('user'));
	}

	public function bayiDegis($id){		
		$data = request()->all();

		$user = User::find($id);
		
		$user->update(['rol'=> $data['bayi']]);

		return back()
		->with('mesaj', 'Başarılı')
		->with('mesaj_tur', 'success');
	}

}
