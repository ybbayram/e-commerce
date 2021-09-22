<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GirisController extends AdminController
{
	public function index(){
		if(auth()->guard('admin')->check()){
			return redirect()->route('admin.index');
		}

		return view('admin.giris');
	}

	public function oturumac(){
		$data = request()->all();

		if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password'], 'rol' => 1])) {
			return redirect()->route('admin.index');
		}else{
			return back();
		}
	}

	public function kayitol(){
		$data = request()->all();

		$user = User::create([
			'email' => $data['email'],
			'password' => Hash::make($data['password']),
			'rol' => 1,
		]);

		Auth::guard('admin')->login($user);

		return redirect()->route('admin.index');
	}

	public function oturumkapat(){
		Auth::guard('admin')->logout();

		return redirect()->route('index');
	}

	public function kullanicilar(){
		$kullanicilar = User::orderByDesc('created_at')->paginate(20);

		return view('admin.kullanicilar.index', compact('kullanicilar'));
	}
}
