<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\{Urun, UrunKategori, UrunAnaliz, UrunKategoriAlt, Kategori, KategoriAlt, Marka ,Etiket, UrunEtiket, SepetUrun, Desi, Tedarikci, UrunHaberVer};
use Cart;

class UrunController extends AdminController
{
	public function index(){
		$urun = Urun::orderByDesc('created_at')->get();

		return view('admin.urun.urun.index', compact('urun'));
	}

	public function olustur(){
		$data = request()->all();
		$desi = ( $data['en'] * $data['boy'] * $data['yukseklik']) / 3000;
		if(!isset($data['cesitVarMi'])){
			$data['cesitVarMi'] = 1;
		}
		if($data['cesitVarMi'] == 0){
			$urun = Urun::create([
				'baslik' => $data['baslik'], 
				'slug' => Str::slug($data['baslik'])."-".Str::random(3),
				'marka' => $data['marka'],
				'durum' => 0,
				'cesit_durum' => $data['cesitVarMi'],
			]);
		}

		if($data['cesitVarMi'] == 1){
			$urun = Urun::create([
				'baslik' => $data['baslik'], 
				'slug' => Str::slug($data['baslik'])."-".Str::random(3),
				'kod' => $data['kod'],
				'barkod' => $data['barkod'], 
				'stok' => $data['stok'], 
				'marka' => $data['marka'],
				'durum' => 0,
				'cesit_durum' => $data['cesitVarMi'],
			]);

			Desi::create([
				'urun_id' => $urun->id,
				'en' => $data['en'],
				'boy' => $data['boy'],
				'yukseklik' => $data['yukseklik'],
				'kilogram' => $data['kilogram'],
				'desi' => $desi
			]);
		}
		

		foreach ($data['kategoriler'] as $kategori) {
			$kategoriVarMi = UrunKategori::where('kategori_id', $kategori)->where('urun_id', $urun->id)->first();
			if(!isset($kategoriVarMi)){
				UrunKategori::create([
					'kategori_id' => $kategori,
					'urun_id' => $urun->id,
				]);
			}
		}

		if(isset($data['etiketler'])){
			foreach ($data['etiketler'] as $etiket) {
				$etiketVarMi = UrunEtiket::where('etiket_id', $etiket)->where('urun_id', $urun->id)->first();
				if(!isset($etiketVarMi)){
					UrunEtiket::create([
						'etiket_id' => $etiket,
						'urun_id' => $urun->id,
					]);
				}
			}
		}
		UrunAnaliz::create([
			'urun_id' => $urun->id
		]);
		return redirect()->route('admin.urun')
		->with('mesaj', 'Ürün oluşturuldu')
		->with('mesaj_tur', 'success');
	}

	public function olusturSayfa(){
		$adminKategoriler = Kategori::where('durum', 1)->orderBy('ad', 'asc')->get();
		$markalar = Marka::where('durum', 1)->orderBy('created_at', 'DESC')->get();
		$etiketler = Etiket::where('durum', 1)->orderBy('created_at','asc')->get();


		return view('admin.urun.urun.olustur', compact('adminKategoriler', 'markalar', 'etiketler'));
	}

	public function guncelleSayfa($id){
		$urun = Urun::where('id', $id)->firstOrFail();
		$adminKategoriler = Kategori::where('durum', 1)->orderBy('sira', 'DESC')->get();
		$urunKat = UrunKategori::where('urun_id', $urun->id)->get();
		$markalar = Marka::where('durum', 1)->orderBy('created_at', 'DESC')->get();
		$etiketler = Etiket::where('durum', 1)->orderBy('created_at','asc')->get();
		$urunEtiket = UrunEtiket::where('urun_id', $urun->id)->get();
		$desi = Desi::where('urun_id', $urun->id)->first();
		
		
		return view('admin.urun.urun.guncelle', compact('urun', 'adminKategoriler', 'urunKat', 'markalar', 'etiketler', 'urunEtiket', 'desi'));
	}

	public function guncelle($id){
		$data = request()->all();
		if (isset($data['cesitVarMi'])) {
			if ($data['cesitVarMi'] == 1) {
				$data['cesitVarMi'] = 0 ;
			}else{
				$data['cesitVarMi'] = 1;
			}
		} else{
			$data['cesitVarMi'] = 1;
		}
		
		$urun = Urun::find($id);
		if($data['cesitVarMi'] == 1){
			$urun->update([
				'baslik' => $data['baslik'],
				'slug' => $data['slug'],
				'barkod' => $data['barkod'],
				'kod' => $data['kod'],
				'stok' => $data['stok'],
				'marka' => $data['marka'],
				'cesit_durum' => $data['cesitVarMi']
			]);
		}

		if($data['cesitVarMi'] == 0){
			$urun->update([
				'baslik' => $data['baslik'],
				'slug' => $data['slug'],
				'marka' => $data['marka'],
				'cesit_durum' => $data['cesitVarMi']
			]);
		}

		if (isset($data['en']) && isset($data['boy']) && isset($data['yukseklik']) ) {
			$desi = ( $data['en'] * $data['boy'] * $data['yukseklik']) / 3000; 
			Desi::where('urun_id', $urun->id)->update([
				'urun_id' => $urun->id,
				'en' => $data['en'],
				'boy' => $data['boy'],
				'yukseklik' => $data['yukseklik'],
				'kilogram' => $data['kilogram'],
				'desi' => $desi
			]);
		}

		$kategoriEski = UrunKategori::where('urun_id', $urun->id)->get();
		$etiketlerEski = UrunEtiket::where('urun_id', $urun->id)->get();

		foreach($kategoriEski as $entry){
			UrunKategori::destroy($entry->id);
		}
		foreach($etiketlerEski as $entry){
			UrunEtiket::destroy($entry->id);
		}

		foreach ($data['kategoriler'] as $kategori) {
			UrunKategori::firstOrCreate([
				'kategori_id' => $kategori,
				'urun_id' => $id,
			]);
		}

		if(isset($data['etiketler'])){
			foreach ($data['etiketler'] as $etiket) {
				UrunEtiket::firstOrCreate([
					'etiket_id' => $etiket,
					'urun_id' => $urun->id,
				]);
			}
		}
		/*
		if (isset($data['haberVerilsinMi'])) {
			if ($data['haberVerilsinMi'] == 1) {
				if ($data['stok'] > 0) { 
					$haberVer =	UrunHaberVer::where('urun_id', $id)->get();
					foreach($haberVer as $entry){
						return $entry->kullanici_bul['email'];
					} 
				}
			}
		}*/
		return redirect()->route('admin.urun')
		->with('mesaj', 'Ürün güncellendi')
		->with('mesaj_tur', 'success');
	}

	public function sil($id){
		Urun::destroy($id);

		$urunler = SepetUrun::where('urun_id', $id)->get();
		foreach($urunler as $sil){
			$kontrol = $sil->sepeturun_siparis_getir;
			if(!isset($kontrol)){
				SepetUrun::destroy($sil->id);
			}
		}

		return back()
		->with('mesaj', 'Ürün silindi.')
		->with('mesaj_tur', 'success');
	}

	public function aktifYap($id){
		$urun = Urun::find($id);
		$urun->durum = 1;
		$urun->save();

		return back()
		->with('mesaj', 'Ürün durumu aktif yapıldı.')
		->with('mesaj_tur', 'success');
	}

	public function pasifYap($id){
		$urun = Urun::find($id);
		$urun->durum = 0;
		$urun->save();

		$urunler = SepetUrun::where('urun_id', $id)->get();
		foreach($urunler as $sil){
			$kontrol = $sil->sepeturun_siparis_getir;
			if(!isset($kontrol)){
				SepetUrun::destroy($sil->id);
			}
		}

		return back()
		->with('mesaj', 'Ürün durumu pasif yapıldı.')
		->with('mesaj_tur', 'success');
	} 
	
	public function hepsiniAc(){
		$ilk = Urun::orderBy('created_at','asc')->first();
		$son = Urun::orderBy('created_at','desc')->first();
		
		Urun::where('durum', 0)->where('id', '>=', $ilk->id)->where('id', '<=', $son->id)->update(['durum' => 1]);

		return back()
		->with('mesaj', 'Tüm ürünler aktif yapıldı.')
		->with('mesaj_tur', 'success');
	}

	public function hepsiniKapat(){
		$ilk = Urun::orderBy('created_at','asc')->first();
		$son = Urun::orderBy('created_at','desc')->first();

		Urun::where('durum', 1)->where('id', '>=', $ilk->id)->where('id', '<=', $son->id)->update(['durum' => 0]);
		$urunlerGetir = Urun::where('durum', 1)->where('id', '>=', $ilk->id)->where('id', '<=', $son->id)->get();

		foreach($urunlerGetir as $urun){
			$urunler = SepetUrun::where('urun_id', $urun->id)->get();
			foreach($urunler as $sil){
				$kontrol = $sil->sepeturun_siparis_getir;
				if(!isset($kontrol)){
					SepetUrun::destroy($sil->id);
				}
			}
		}

		return back()
		->with('mesaj', 'Tüm ürünler	 pasif yapıldı.')
		->with('mesaj_tur', 'success');
	}
}

