<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\{Gorsel, Urun};
use Illuminate\Support\Str;

class UrunGorselController extends AdminController
{
	public function index($urun){
		$urunGorsel = Gorsel::where('urun_id', $urun)->orderByDesc('created_at')->get();
		$urun = Urun::find($urun);

		return view('admin.urun.urunGorsel.index', compact('urunGorsel', 'urun'));
	}

	public function olustur($urun){
		$sira = 0;
		$gorselSira = Gorsel::where('urun_id', $urun)->orderBy('sira', 'desc')->first();
		$urunBul = Urun::find($urun);

		if(isset($gorselSira)){
			$sira = $gorselSira->sira + 1;
		}

		if(request()->hasFile('gorsel')){
			$gorsel = request()->gorsel;
			$dosyadi =  Str::slug($urunBul['baslik']) . "-" . "1" . Str::random(5) . "." . $gorsel->extension();

			if($gorsel->isValid()){
				$gorsel->move('uploads/gorseller', $dosyadi);

				Gorsel::create([
					'gorsel' => '/uploads/gorseller/'.$dosyadi,
					'sira' => $sira,
					'urun_id' => $urun
				]);
			}
			$sira = $sira+1;
		}

		if(request()->hasFile('gorsel_iki')){
			$gorsel = request()->gorsel_iki;
			$dosyadi =  Str::slug($urunBul['baslik']) . "-" . "2" . Str::random(5) . "." . $gorsel->extension();

			if($gorsel->isValid()){
				$gorsel->move('uploads/gorseller', $dosyadi);

				Gorsel::create([
					'gorsel' => '/uploads/gorseller/'.$dosyadi,
					'sira' => $sira,
					'urun_id' => $urun
				]);
			}
			$sira = $sira+1;
		}

		if(request()->hasFile('gorsel_uc')){
			$gorsel = request()->gorsel_uc;
			$dosyadi =  Str::slug($urunBul['baslik']) . "-" . "3" . Str::random(5) . "." . $gorsel->extension();

			if($gorsel->isValid()){
				$gorsel->move('uploads/gorseller', $dosyadi);

				Gorsel::create([
					'gorsel' => '/uploads/gorseller/'.$dosyadi,
					'sira' => $sira,
					'urun_id' => $urun
				]);
			}
			$sira = $sira+1;
		}

		if(request()->hasFile('gorsel_dort')){
			$gorsel = request()->gorsel_dort;
			$dosyadi =  Str::slug($urunBul['baslik']) . "-" . "4" . Str::random(5) . "." . $gorsel->extension();

			if($gorsel->isValid()){
				$gorsel->move('uploads/gorseller', $dosyadi);

				Gorsel::create([
					'gorsel' => '/uploads/gorseller/'.$dosyadi,
					'sira' => $sira,
					'urun_id' => $urun
				]);
			}
			$sira = $sira+1;
		}

		if(request()->hasFile('gorsel_bes')){
			$gorsel = request()->gorsel_bes;
			$dosyadi =  Str::slug($urunBul['baslik']) . "-" . "5" . Str::random(5) . "." . $gorsel->extension();

			if($gorsel->isValid()){
				$gorsel->move('uploads/gorseller', $dosyadi);

				Gorsel::create([
					'gorsel' => '/uploads/gorseller/'.$dosyadi,
					'sira' => $sira,
					'urun_id' => $urun
				]);
			}
			$sira = $sira+1;
		}

		if(request()->hasFile('gorsel_alti')){
			$gorsel = request()->gorsel_alti;
			$dosyadi =  Str::slug($urunBul['baslik']) . "-" . "6" . Str::random(5) . "." . $gorsel->extension();

			if($gorsel->isValid()){
				$gorsel->move('uploads/gorseller', $dosyadi);

				Gorsel::create([
					'gorsel' => '/uploads/gorseller/'.$dosyadi,
					'sira' => $sira,
					'urun_id' => $urun
				]);
			}
		}

		return redirect()->route('admin.urunGorsel', $urun)
		->with('mesaj', 'Ürün görseli oluşturuldu')
		->with('mesaj_tur', 'success');
	}

	public function olusturSayfa($urun){
		$urun = Urun::find($urun);

		return view('admin.urun.urunGorsel.olustur', compact('urun'));
	}

	public function sil($id){
		Gorsel::destroy($id);

		return back()
		->with('mesaj', 'Ürün görseli silindi.')
		->with('mesaj_tur', 'success');
	}

	public function siralaSayfa($urun){
		$gorseller = Gorsel::where('urun_id', $urun)->orderBy('sira', 'asc')->get();
		$urun = Urun::find($urun);

		return view('admin.urun.urunGorsel.sirala', compact('gorseller', 'urun'));
	}

	public function sirala($urun){
		$data = request()->all();
		$count = 0;
		$json = $data['json'];

		$rooms = json_decode($json, true);

		foreach($rooms as $entry){
			Gorsel::where('id', $entry['id'])->update([
				'sira' => $count,
			]);
			$count++;
		}

		return redirect()->route('admin.urunGorsel', $urun)
		->with('mesaj', 'Alt kategori sırası güncellendi')
		->with('mesaj_tur', 'success');
	}
}
