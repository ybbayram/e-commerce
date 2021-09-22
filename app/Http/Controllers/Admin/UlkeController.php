<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\{Ulke, Dil, UlkeKod, ParaBirimi, AktifKampanya, KargoFiyat};

class UlkeController extends AdminController
{
	public function index(){
		$ulkeler = Ulke::where('deleted_at', null)->orderByDesc('created_at')->get();

		return view('admin.ulke.index', compact('ulkeler'));
	}

	public function olustur(){
		$data = request()->all();

		$kontrol = Ulke::where('ulke_kod_id', $data['ulke_kod_id'])->first();
		if(isset($kontrol)){
			return back()
			->with('mesaj', 'Ülke zaten kayıtlı')
			->with('mesaj_tur', 'danger');
		}

		$ulke = Ulke::create([
			'ulke_kod_id' => $data['ulke_kod_id'],
			'dil_id' => $data['dil_id'],
			'para_birimi_id' => $data['para_birimi_id'],
		]);
		$dizi = ['kargolar', 'sepet', 'XalYode', 'promosyon'];
		$i = 0;
		foreach($dizi as $di){  
			$aktif = AktifKampanya::create([
				'ulke_id' => $ulke->id,
				'grup' => $i
			]);

			$i++;
		}

		KargoFiyat::create([
			'ulke_id' => $ulke->id
		]);

		return redirect()->route('admin.ulke')
		->with('mesaj', 'Ülke oluşturuldu')
		->with('mesaj_tur', 'success');
	}

	public function olusturSayfa(){
		$diller = Dil::orderBy('created_at', 'DESC')->get();
		$ulkeKodlari = UlkeKod::orderBy('created_at', 'ASC')->get();
		$paraBirimleri = ParaBirimi::orderBy('created_at', 'ASC')->get();

		return view('admin.ulke.olustur', compact('ulkeKodlari', 'diller', 'paraBirimleri'));
	}

	public function guncelleSayfa($id){
		$diller = Dil::orderBy('created_at', 'DESC')->get();
		$ulkeKodlari = UlkeKod::orderBy('created_at', 'ASC')->get();
		$ulke = Ulke::where('id', $id)->firstOrFail();
		$paraBirimleri = ParaBirimi::orderBy('created_at', 'ASC')->get();

		return view('admin.ulke.guncelle', compact('ulke', 'ulkeKodlari', 'diller', 'paraBirimleri'));
	}

	public function guncelle($id){
		$data = request()->all();


		$kontrol = Ulke::where('ulke_kod_id', $data['ulke_kod_id'])->first();	
		if(isset($kontrol)){
			return back()
			->with('mesaj', 'Ülke zaten kayıtlı')
			->with('mesaj_tur', 'danger');
		}

		Ulke::find($id)->update([
			'ulke_kod_id' => $data['ulke_kod_id'],
			'dil_id' => $data['dil_id'],
			'para_birimi_id' => $data['para_birimi_id'],
		]);


		return redirect()->route('admin.ulke')
		->with('mesaj', 'Ülke güncellendi')
		->with('mesaj_tur', 'success');
	}

	public function sil($id){
		Ulke::destroy($id);

		return back()
		->with('mesaj', 'Ülke silindi.')
		->with('mesaj_tur', 'success');
	}
}
