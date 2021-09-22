<?php

namespace App\Http\Controllers\Tanitim;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FonksiyonlarController;
use Illuminate\Http\Request;
use App\Models\{Adres,AdresKurumsal};
use Cookie;


class AdresController extends Controller
{
	public function olustur(){
		$data = request()->all();  
		$ziyaretciId = Cookie::get('ziyaretci_id');
		$data['ulke'] = "1";


		$adres = Adres::create([
			'ziyaretci_id' => $ziyaretciId,
			'baslik' => $data['baslik'],
			'isim' => $data['ad'],
			'mail' => $data['mail'],
			'ulke' => $data['ulke'],
			'il' => $data['il'],
			'ilce' => $data['ilce'],
			'mahalle' => $data['mahalle'],
			'adres' => $data['adres'],
			'postakodu' => $data['postakodu'],
			'telefon' => $data['telefon'],
			'kimlik_no' => $data['kimlik_no'],
		]);

		
		if (isset($data['firma_adi'])) {
			if(!isset($data['eFatura'])){
				$data['eFatura'] = "0";
			}
			AdresKurumsal::create([
				'adres_id' => $adres->id,
				'firma_adi' => $data['firma_adi'],
				'vergi_numarasi' => $data['vergi_numarasi'],
				'vergi_dairesi' => $data['vergi_dairesi'],
				'eFatura' => $data['eFatura']
			]); 
			$adres->update(['kurumsal_mi' => 1]);
		}
		
		return back();
	}
	public function guncelleSayfa($id)
	{  
		$adres = Adres::where('id', $id)->firstOrFail(); 

		return view('tanitim.hesabim.adres.guncelle', compact('adres'));
	}

	public function guncelle($id){
		$data = request()->all();
		Adres::find($id)->update([ 
			'baslik' => $data['baslik'],
			'isim' => $data['ad'],
			'mail' => $data['mail'],
			'ulke' => $data['ulke'],
			'il' => $data['il'],
			'ilce' => $data['ilce'],
			'mahalle' => $data['mahalle'],
			'adres' => $data['adres'],
			'postakodu' => $data['postakodu'],
			'telefon' => $data['telefon'],
			'kimlik_no' => $data['kimlik_no'],
		]);
		$adres = Adres::where('id', $id)->firstOrFail(); 

		if (isset($data['firma_adi'])) {

			if(!isset($data['eFatura'])){
				$data['eFatura'] = "0";
			}
			
			AdresKurumsal::where('adres_id',$id)->update([
				'firma_adi' => $data['firma_adi'],
				'vergi_numarasi' => $data['vergi_numarasi'],
				'vergi_dairesi' => $data['vergi_dairesi'],
				'eFatura' => $data['eFatura']
			]); 

		} 
		return back()
		->with('mesaj', 'Adres g«äncellendi')
		->with('mesaj_tur', 'success');
	}

	public function sil($id){
		Adres::where('id',$id)->update(['durum' => 0]);

		return back()
		->with('mesaj', 'Adres silindi.')
		->with('mesaj_tur', 'success');
	}
}
