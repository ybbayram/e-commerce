<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\{Urun, UrunDetay, Dil};

class UrunDetayController extends AdminController
{
	public function index($urun){
		$urunDetay = UrunDetay::where('urun_id', $urun)->orderByDesc('created_at')->get();
		$urun = Urun::find($urun);


		return view('admin.urun.urunDetay.index', compact('urunDetay', 'urun'));
	}

	public function olustur($urun){
		$data = request()->all();

		$kontrol = UrunDetay::where('urun_id', $urun)->where('dil_id', $data['dil_id'])->first();	
		if(isset($kontrol)){
			return back()
			->with('mesaj', 'Dil zaten kayıtlı')
			->with('mesaj_tur', 'danger');
		}

		UrunDetay::create([
			'urun_id' => $urun,
			'dil_id' => $data['dil_id'],
			'ad' => $data['ad'],
			'aciklama_bir' => $data['aciklama_bir'],
			'aciklama_bir_baslik' => $data['aciklama_bir_baslik'],
			'aciklama_iki' => $data['aciklama_iki'],
			'aciklama_iki_baslik' => $data['aciklama_iki_baslik'],
			'aciklama_uc' => $data['aciklama_uc'],
			'aciklama_uc_baslik' => $data['aciklama_uc_baslik'],
			'aciklama_dort' => $data['aciklama_dort'],
			'aciklama_dort_baslik' => $data['aciklama_dort_baslik'],
			'title' => $data['title'],
			'description' => $data['description'],
		]);

		return redirect()->route('admin.urunDetay', $urun)
		->with('mesaj', 'Ürün detayı oluşturuldu')
		->with('mesaj_tur', 'success');
	}

	public function olusturSayfa($urun){
		$urun = Urun::find($urun);
		$diller = Dil::orderBy('created_at', 'DESC')->get();

		return view('admin.urun.urunDetay.olustur', compact('urun', 'diller'));
	}

	public function guncelleSayfa($id){
		$urunDetay = UrunDetay::where('id', $id)->firstOrFail();
		$diller = Dil::orderBy('created_at', 'DESC')->get();

		return view('admin.urun.urunDetay.guncelle', compact('urunDetay', 'diller'));
	}

	public function guncelle($id){
		$data = request()->all();

		$kontrol = UrunDetay::where('id', $id)->where('dil_id', $data['dil_id'])->first();
		if($kontrol->dil_id != $data['dil_id']){
			if(isset($kontrol)){
				return back()
				->with('mesaj', 'Dil zaten kayıtlı')
				->with('mesaj_tur', 'danger');
			}
		}	

		$urunDetay = UrunDetay::find($id);
		$urunDetay->update([
			'dil_id' => $data['dil_id'],
			'ad' => $data['ad'],
			'aciklama_bir' => $data['aciklama_bir'],
			'aciklama_bir_baslik' => $data['aciklama_bir_baslik'],
			'aciklama_iki' => $data['aciklama_iki'],
			'aciklama_iki_baslik' => $data['aciklama_iki_baslik'],
			'aciklama_uc' => $data['aciklama_uc'],
			'aciklama_uc_baslik' => $data['aciklama_uc_baslik'],
			'aciklama_dort' => $data['aciklama_dort'],
			'aciklama_dort_baslik' => $data['aciklama_dort_baslik'],
			'title' => $data['title'],
			'description' => $data['description'],
		]);

		return redirect()->route('admin.urunDetay', $urunDetay->urun_id)
		->with('mesaj', 'Ürün detayı güncellendi')
		->with('mesaj_tur', 'success');
	}

	public function sil($id){
		UrunDetay::destroy($id);

		return back()
		->with('mesaj', 'Ürün detayı silindi.')
		->with('mesaj_tur', 'success');
	}
}
