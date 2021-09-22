<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\{Urun, UrunFiyat, Ulke, Cesit, CesitDetay, CesitFiyat};

class UrunFiyatController extends AdminController
{
	public function index($urun){
		$urunFiyat = UrunFiyat::where('urun_id', $urun)->orderByDesc('created_at')->get();
		$cesitFiyat = CesitFiyat::where('urun_id', $urun)->orderByDesc('created_at')->get();
		$urun = Urun::find($urun);

		return view('admin.urun.urunFiyat.index', compact('urunFiyat','cesitFiyat', 'urun'));
	}
	public function kdvBul($kdv, $fiyat)
	{
		$fiyatBul = $fiyat + (($fiyat * $kdv) / 100) ;
		return $fiyatBul;
	}

	public function olustur($urun){
		$data = request()->all(); 
		if (isset($data['fiyat_onceki'])) {
			if($data['fiyat'] > $data['fiyat_onceki']){
				return back()
				->with('mesaj', 'Önceki fiyat fiyattan küçük olamaz.')
				->with('mesaj_tur', 'danger');
			}
		}
		if (!isset($data['kdv_yok'])) { 
			$data['kdv_yok'] = 0;
		}else{
			$data['kdv_yok'] = 1;
		} 

		if ($data['kdv_yok'] == 1) {
			if(isset($data['kdv_orani'])){
				$fiyat =  $this->kdvBul($data['kdv_orani'], $data['fiyat']);
				$fiyat_bir =  $this->kdvBul($data['kdv_orani'], $data['fiyat_bir']);
				$fiyat_iki =  $this->kdvBul($data['kdv_orani'], $data['fiyat_iki']);
				$fiyat_uc =  $this->kdvBul($data['kdv_orani'], $data['fiyat_uc']);
				$fiyat_dort =  $this->kdvBul($data['kdv_orani'], $data['fiyat_dort']);
			}
		}else{
			$fiyat =  $data['fiyat'];
			$fiyat_bir =  $data['fiyat_bir'];
			$fiyat_iki =  $data['fiyat_iki'];
			$fiyat_uc =  $data['fiyat_uc'];
			$fiyat_dort =  $data['fiyat_dort'];
		}
		
		$kontrol = UrunFiyat::where('urun_id', $urun)->where('ulke_id', $data['ulke_id'])->first();	

		if(isset($kontrol)){
			return back()
			->with('mesaj', 'Ülke zaten kayıtlı')
			->with('mesaj_tur', 'danger');
		}

		$varMi = UrunFiyat::where('urun_id', $urun)->where('ulke_id', $data['ulke_id'])->first();

		if(!isset($varMi)){
			$urunFiyat = UrunFiyat::create([
				'urun_id' => $urun,
				'ulke_id' => $data['ulke_id'],
				'fiyat' => $fiyat,
				'fiyat_onceki' => $data['fiyat_onceki'],
				'kdv_orani' => $data['kdv_orani'],
				'kdvsiz_fiyat' => $data['fiyat'],
				'fiyat_bir' => $fiyat_bir,
				'fiyat_bir_onceki' => $data['fiyat_bir_onceki'],
				'fiyat_bir_kdvsiz' => $data['fiyat_bir'],
				'fiyat_iki' => $fiyat_iki,
				'fiyat_iki_onceki' => $data['fiyat_iki_onceki'],
				'fiyat_iki_kdvsiz' => $data['fiyat_iki'],
				'fiyat_uc' => $fiyat_uc,
				'fiyat_uc_onceki' => $data['fiyat_uc_onceki'],
				'fiyat_uc_kdvsiz' => $data['fiyat_uc'],
				'fiyat_dort' => $fiyat_dort,
				'fiyat_dort_onceki' => $data['fiyat_dort_onceki'],
				'fiyat_dort_kdvsiz' => $data['fiyat_dort']

			]);

			return redirect()->route('admin.urunFiyat', $urun)
			->with('mesaj', 'Ürün fiyatı oluşturuldu')
			->with('mesaj_tur', 'success');
		}else{
			return redirect()->route('admin.urunFiyat', $urun)
			->with('mesaj', 'Bu ülke için fiyat girişi zaten yapılmış')
			->with('mesaj_tur', 'danger');
		}

	}

	public function olusturSayfa($urun){
		$urun = Urun::find($urun);
		$ulkeler = Ulke::orderBy('created_at', 'asc')->get();
		$cesitler = Cesit::where('urun_id', $urun->id)
		->where('deleted_at', null)
		->where('durum', 1)
		->get(); 
		return view('admin.urun.urunFiyat.olustur', compact('urun', 'ulkeler', 'cesitler'));
	}

	public function guncelleSayfa($id){
		$urunFiyat = UrunFiyat::where('id', $id)->firstOrFail();
		$urun = Urun::find($urunFiyat->urun_id);
		$ulkeler = Ulke::orderBy('created_at', 'asc')->get();


		return view('admin.urun.urunFiyat.guncelle', compact('urunFiyat', 'urun', 'ulkeler'));
	}

	public function guncelle($id){
		$data = request()->all();
		if (isset($data['fiyat_onceki'])) {  
			if($data['fiyat'] > $data['fiyat_onceki']){
				return back()
				->with('mesaj', 'Önceki fiyat fiyattan küçük olamaz.')
				->with('mesaj_tur', 'danger');
			}
		}
		if (!isset($data['kdv_yok'])) { 
			$data['kdv_yok'] = 0;
		}else{
			$data['kdv_yok'] = 1;
		} 

		if ($data['kdv_yok'] == 1) {
			if($data['kdv_orani'] != null){
				$fiyat =  $this->kdvBul($data['kdv_orani'], $data['fiyat']);
				$fiyat_bir =  $this->kdvBul($data['kdv_orani'], $data['fiyat_bir']);
				$fiyat_iki =  $this->kdvBul($data['kdv_orani'], $data['fiyat_iki']);
				$fiyat_uc =  $this->kdvBul($data['kdv_orani'], $data['fiyat_uc']);
				$fiyat_dort =  $this->kdvBul($data['kdv_orani'], $data['fiyat_dort']);
			}
		}else{
			$fiyat =  $data['fiyat'];
			$fiyat_bir =  $data['fiyat_bir'];
			$fiyat_iki =  $data['fiyat_iki'];
			$fiyat_uc =  $data['fiyat_uc'];
			$fiyat_dort =  $data['fiyat_dort'];
		} 
		$kontrol = UrunFiyat::where('id', $id)->where('ulke_id', $data['ulke_id'])->first();
		if($kontrol->ulke_id != $data['ulke_id']){	
			if(isset($kontrol)){
				return back()
				->with('mesaj', 'Ülke zaten kayıtlı')
				->with('mesaj_tur', 'danger');
			}
		} 

		$urun = UrunFiyat::find($id);
		$urun->update([
			'urun_id' => $urun->urun_id,
			'ulke_id' => $data['ulke_id'],
			'kdv_orani' => $data['kdv_orani'],
			'kdv_durum' => $data['kdv_yok'],
			'fiyat' => $fiyat,
			'fiyat_onceki' => $data['fiyat_onceki'],
			'kdvsiz_fiyat' => $data['fiyat'],
			'fiyat_bir' => $fiyat_bir,
			'fiyat_bir_onceki' => $data['fiyat_bir_onceki'],
			'fiyat_bir_kdvsiz' => $data['fiyat_bir'],
			'fiyat_iki' => $fiyat_iki,
			'fiyat_iki_onceki' => $data['fiyat_iki_onceki'],
			'fiyat_iki_kdvsiz' => $data['fiyat_iki'],
			'fiyat_uc' => $fiyat_uc,
			'fiyat_uc_onceki' => $data['fiyat_uc_onceki'],
			'fiyat_uc_kdvsiz' => $data['fiyat_uc'],
			'fiyat_dort' => $fiyat_dort,
			'fiyat_dort_onceki' => $data['fiyat_dort_onceki'],
			'fiyat_dort_kdvsiz' => $data['fiyat_dort']
		]);

		return redirect()->route('admin.urunFiyat', $urun->urun_id)
		->with('mesaj', 'Ürün fiyatı güncellendi')
		->with('mesaj_tur', 'success');
	}

	public function sil($id){
		UrunFiyat::destroy($id);

		return back()
		->with('mesaj', 'Ürün fiyatı silindi.')
		->with('mesaj_tur', 'success');
	}
}
