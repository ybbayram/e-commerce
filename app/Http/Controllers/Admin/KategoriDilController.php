<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\{Kategori, KategoriDil, Dil};
use Illuminate\Support\Str;

class KategoriDilController extends AdminController
{
	public function index($kategori){
		$kategoriDil = KategoriDil::where('kategori_id', $kategori)->orderByDesc('created_at')->get();
		$kategori = Kategori::find($kategori);

		return view('admin.kategoriDil.index', compact('kategoriDil', 'kategori'));
	}

	public function olustur($kategori){
		$data = request()->all();

		$dilKontrol = KategoriDil::where('dil_id', $data['dil_id'])->where('kategori_id', $kategori)->first();
		if(isset($dilKontrol)){
			return back()
			->with('mesaj', 'Bu dil için zaten bir kayıt var')
			->with('mesaj_tur', 'danger');
		}

		$kategoriDil = KategoriDil::create([
			'ad' => $data['ad'],
			'kategori_id' => $kategori,
			'aciklama' => $data['aciklama'],
			'dil_id' => $data['dil_id'],
		]);

		if(request()->hasFile('gorsel')){
			$gorsel = request()->gorsel;
			$dosyadi =  Str::slug($data['ad']) . "-" . Str::random(5) . "." . $gorsel->extension();

			if($gorsel->isValid()){
				$gorsel->move('uploads/gorseller', $dosyadi);

				KategoriDil::find($kategoriDil->id)->update([
					'gorsel' => '/uploads/gorseller/'.$dosyadi
				]);
			}
		}

		return redirect()->route('admin.kategoriDil', $kategori)
		->with('mesaj', 'Kategori dili oluşturuldu')
		->with('mesaj_tur', 'success');
	}

	public function olusturSayfa($kategori){
		$kategori = Kategori::find($kategori);
		$diller = Dil::orderBy('created_at', 'DESC')->get();

		return view('admin.kategoriDil.olustur', compact('kategori', 'diller'));
	}

	public function guncelleSayfa($kategori, $id){
		$kategoriDil = KategoriDil::where('id', $id)->firstOrFail();
		$kategori = Kategori::find($kategori);
		$diller = Dil::orderBy('created_at', 'DESC')->get();

		return view('admin.kategoriDil.guncelle', compact('kategoriDil', 'kategori', 'diller'));
	}

	public function guncelle($kategori, $id){
		$data = request()->all();

		$kategoriDil = KategoriDil::find($id)->update([
			'ad' => $data['ad'],
			'aciklama' => $data['aciklama'], 
		]);
		
		if(request()->hasFile('gorsel')){
			$gorsel = request()->gorsel;
			$dosyadi =  Str::slug($data['ad']) . "-" . Str::random(5) . "." . $gorsel->extension();

			if($gorsel->isValid()){
				$gorsel->move('uploads/gorseller', $dosyadi);

				KategoriDil::find($id)->update([
					'gorsel' => '/uploads/gorseller/'.$dosyadi
				]);
			}
		}

		return redirect()->route('admin.kategoriDil', ['kategori' => $kategori, 'id' => $id])
		->with('mesaj', 'Kategori dili güncellendi')
		->with('mesaj_tur', 'success');
	}

	public function sil($kategori, $id){
		KategoriDil::destroy($id);

		return back()
		->with('mesaj', 'Kategori dili silindi.')
		->with('mesaj_tur', 'success');
	}
}
