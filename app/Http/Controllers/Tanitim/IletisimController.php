<?php

namespace App\Http\Controllers\Tanitim;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FonksiyonlarController;
use Illuminate\Http\Request;
use App\Models\{Iletisim};

class IletisimController extends Controller
{
	public function index(){

		return view('tanitim.iletisim');
	}

    public function olustur(){
    	$data = request()->all();
    	$dil = Iletisim::create([
			'adsoyad' => $data['adsoyad'],
			'email' => $data['email'],
			'aciklama' => $data['aciklama']
		]);

		return back()
		->with('mesaj', 'Mesaj gönderildi.')
		->with('mesaj_tur', 'success');
    }
}
