<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\{TopluUrun, TopluUrunGrup, Urun, UrunDetay, UrunFiyat, Gorsel};

class TopluUrunController extends AdminController
{
	public function index(){
		$topluUrun = TopluUrun::orderByDesc('created_at')->get();

		return view('admin.topluUrun.index', compact('topluUrun'));
	}

	public function urunEkle(){
		$data = request()->all();
		$giris = $data['giris'];
		$grup = TopluUrunGrup::create();

		if($giris['id']==1 and $giris['guvenlik_kodu']==1601991375){

			foreach ($giris['urunler']['urun'] as $urun) {
				$sira = 0;
				Urun::create([
					'baslik' => $urun['baslik'],
					'kod' => $urun['kod'],
					'durum' => $urun['durum'],
				]);
				foreach ($urun['detaylar'] as $detay) {
					UrunDetay::create([
						'urun_id' => $urun->id,
						'dil' => $detay['dil'],
						'aciklama_bir' => $detay['aciklama_bir'],
						'aciklama_iki' => $detay['aciklama_iki'],
					]);
				}
				foreach ($urun['gorseller'] as $gorsel) {
					Gorsel::where('eski_ad', $gorsel['gorsel'])->orderBy('created_at', 'DESC')->first()->update([
						'urun_id' => $urun->id,
						'sira' => $sira,
					]);
					$sira++;
				}
				foreach ($urun['fiyatlar'] as $fiyat) {
					UrunFiyat::create([
						'urun_id' => $fiyat['urun_id'],
						'ulke_id' => $fiyat['ulke_id'],
					]);
				}

				TopluUrun::create([
					'urun_id' => $urun->id,
					'grup' => $grup->id,
				]);
			}

			return redirect()->route('admin.topluUrun')
			->with('mesaj', 'Toplu ürün oluşturuldu')
			->with('mesaj_tur', 'success');
		}else{
			return "Hatalı giriş";
		}
	}

	public function urunEkleSayfa(){

		return view('admin.topluUrun.olustur');
	}

	public function gorselEkle(){

		if(request()->hasFile('dosyalar')){
			foreach(request()->file('dosyalar') as $dosya){
				$dosyadi =  time() . Str::random(5) . "." . $dosya->extension();

				if($dosya->isValid()){
					$dosya->move('uploads/gorseller', $dosyadi);

					Gorsel::create([
						'dosya' => '/uploads/gorseller/'.$dosyadi,
						'eski_ad' => $dosya->getClientOriginalName(),
					]);
				}
			}
		}


		return redirect()->route('admin.topluUrun')
		->with('mesaj', 'Toplu ürün görselleri oluşturuldu')
		->with('mesaj_tur', 'success');
	}

	public function gorselEkleSayfa(){

		return view('admin.topluUrun.olustur');
	}

	public function sil($id){
		$topluUrun = TopluUrun::where('grup', $id)->get();

		foreach($topluUrun as $entry){
			Urun::destroy($entry->urun_id);
		}

		return back()
		->with('mesaj', 'Toplu ürün silindi.')
		->with('mesaj_tur', 'success');
	}

	public function onayla($id){
		$topluUrun = TopluUrun::where('grup', $id)->get();

		foreach($topluUrun as $entry){
			Urun::where('id', $entry->urun_id)->update([
				'durum' => 1,
			]);
		}

		return back()
		->with('mesaj', 'Toplu ürün onaylandı.')
		->with('mesaj_tur', 'success');
	}
}
