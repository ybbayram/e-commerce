<?php

namespace App\Http\Controllers\Tanitim;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FonksiyonlarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use App\Models\{Siparis, Adres, Yorum, Urun, UrunAnaliz, IadeSorular, IadeTalepleri, OnaylanmisIadeler,ZiyaretciUser};
use App\User;
use Illuminate\Support\Str;

class MyAccountController extends Controller
{
	public function index()
	{

		return view('tanitim.hesabim.index');
	}
	public function sifreDegisSayfa()
	{

		return view('tanitim.hesabim.sifreDegistir');
	}
	public function tel()
	{

		return view('tanitim.shop.telphone');
	}

	public function sifreDegis()
	{
		$data = request()->all();
		$user_id = auth()->id();
		$user = User::findOrFail($user_id);
		
		if (Hash::check($data['password_eski'], $user->password)) {  
			$this->validate(request(), [
				'password' => 'required|confirmed|min:5|max:60'
			]);

			User::where('id', $user_id)->update([
				'password' => Hash::make($data['password']),
			]);

			return back()
			->with('mesaj', 'Şifre güncellendi.')
			->with('mesaj_tur', 'success');
		}else{
			return back()
			->with('mesaj', 'Mevcut şifre yanlış.')
			->with('mesaj_tur', 'danger');
		}
	}

	public function siparislerim()
	{
	    $ziyaretciId = Cookie::get('ziyaretci_id');
		$say = 0 ;
		$iadeSorular = IadeSorular::where('durum', 1)->get();
		$user = ZiyaretciUser::where('ziyaretci_id', $ziyaretciId)->first();
		if (isset($user)) {
			$user_id = $user->user_id;
			$ziyaretciler = ZiyaretciUser::where('user_id', $user_id)->get(); 
			foreach($ziyaretciler as $ziyaretci){
				$siparisim = Siparis::where('ziyaretci_id', $ziyaretci->ziyaretci_id)->where('islem_durum','!=', 0)->orderBy('created_at', 'DESC')->get(); 
				if (isset($siparisim[0])) { 
					$siparislerim[] = $siparisim;
				}
			}    
			if (isset($siparislerim)) {
				$say = count($siparislerim);
			}else{
				$siparislerim = null;
			}
		}else{
			$siparislerim	 = Siparis::where('ziyaretci_id', $ziyaretciId)->where('islem_durum','!=', 0)->orderBy('created_at', 'DESC')->get(); 
		}
		return view('tanitim.hesabim.siparislerim', compact('siparislerim', 'user', 'iadeSorular', 'say'));
	}

	public function panel()
	{
		$ziyaretciId = Cookie::get('ziyaretci_id');
		$userId = auth()->id();
		$siparislerim = Siparis::where('ziyaretci_id', $ziyaretciId)->orderBy('created_at', 'desc')->paginate(10);
		$user = auth()->user();


		return view('tanitim.hesabim.panel', compact('siparislerim', 'user'));
	}

	public function adreslerim(){
		$user_id = auth()->id();
		$ziyaretciId = Cookie::get('ziyaretci_id');
		if (isset($user_id)) {
			$user = ZiyaretciUser::where('ziyaretci_id', $ziyaretciId)->first();

			$user_id = $user->user_id;
			$ziyaretciler = ZiyaretciUser::where('user_id', $user_id)->get();
			foreach($ziyaretciler as $ziyaretci){
				$adresler[] = Adres::where('ziyaretci_id', $ziyaretci->ziyaretci_id)->where('durum', 1)->orderBy('created_at', 'desc')->first();
			}
		}else{
			$adresler = Adres::where('ziyaretci_id', $ziyaretciId)->where('durum', 1)->orderBy('created_at', 'desc')->get();
		}
		return view('tanitim.hesabim.adres.adres', compact('adresler'));
	}
	public function degerlendirmeler()
	{
		$userId = auth()->id();

		$yorumlar = Yorum::where('user_id', $userId)->get();


		return view('tanitim.hesabim.degerlendirmeler', compact('yorumlar'));
	}

	public function guncelle($id)
	{
		$data = request()->all();
		$userId = auth()->id();

		$yorum = Yorum::where('id', $id)->update([
			'oy' => $data['oy'],
			'yorum' => $data['yorum']
		]);

		$urun = Yorum::where('id', $id)->first();
		$urun_id = $urun->urun_id;
		$analiz = UrunAnaliz::where('urun_id', $urun_id)->first();
		$toplam_puan = $analiz->toplam_puan + $data['oy'];
		UrunAnaliz::where('urun_id', $urun_id)->update(['toplam_puan' => $toplam_puan]);

		return back();
	}


	public function sil($id)
	{
		$urun = Yorum::where('id', $id)->first();
		$urun_id = $urun->urun_id;
		$analiz = UrunAnaliz::where('urun_id', $urun_id)->first();
		$toplam_puan = $analiz->toplam_puan - $urun->oy;
		UrunAnaliz::where('urun_id', $urun_id)->update(['toplam_puan' => $toplam_puan]);

		Yorum::destroy($id);


		return back();
	}
	public function about()
	{
		return view('tanitim.hakkimizda');
	}
	public function bildirimSayfa()
	{
		return view('tanitim.hesabim.bildirim');
	}
	public function bildirim()
	{
		$data = request()->all();
		$userId = auth()->id();
		if (!isset($data['kvkk'])) {
			$data['kvkk'] = "0";
		}
		User::where('id', $userId)->update(['kvkk' => $data['kvkk']]);
		return back()
		->with('mesaj', 'Güncelleme başarılı.')
		->with('mesaj_tur', 'success');
	}
}
