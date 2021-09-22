<?php

namespace App\Http\Controllers\Tanitim;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FonksiyonlarController;
use Illuminate\Http\Request;
use App\Models\{Favori, ZiyaretciUser};
use Cookie;

class FavoriController extends Controller
{
	public function index(){
		$ziyaretciId = Cookie::get('ziyaretci_id'); 
		$user_id = auth()->id();
		if (isset($user_id)) {  
			$user = ZiyaretciUser::where('ziyaretci_id', $ziyaretciId)->first();
			$user_id = $user->user_id;
			$ziyaretciler = ZiyaretciUser::where('user_id', $user_id)->get(); 
			foreach($ziyaretciler as $ziyaretci){
				$ziyaretci_id[] = $ziyaretci->ziyaretci_id;

			}
		}else{
			$ziyaretci_id[] = $ziyaretciId;
		}
		$favoriler = Favori::join('urun', 'favori.urun_id', '=', 'urun.id')
		->join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
		->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
		->join('marka', 'urun.marka', '=', 'marka.id')
		->whereIn('favori.ziyaretci_id', $ziyaretci_id)
		->where('urun.durum', 1)
		->where('urun.deleted_at', '=', null)
		->where('urun_kategori.deleted_at', '=', null)
		->where('marka.durum', 1)
		->where('marka.deleted_at', '=', null) 
		->where('kategori.durum', 1)
		->where('kategori.deleted_at', '=', null)   
		->where('favori.deleted_at', '=', null)
		->select('favori.*', 'urun.*', 'favori.id')
		->orderByDesc('favori.created_at')
		->distinct('urun_kategori.id')
		->get();   

		return view('tanitim.favori', compact('favoriler'));
	}

	public function olustur($id){
		$ziyaretciId = Cookie::get('ziyaretci_id');
		$favKontrol = Favori::where('urun_id', $id)->where('ziyaretci_id', $ziyaretciId)->first();

		if(isset($favKontrol)){
			return back()
			->with('mesaj', 'Bu ürün favorilerde zaten kayıtlı')
			->with('mesaj_tur', 'danger');
		}
		Favori::create([
			'ziyaretci_id' => $ziyaretciId,
			'urun_id' => $id,
		]);

		return back()
		->with('mesaj', 'Favorilere eklendi')
		->with('mesaj_tur', 'success');
	}

	public function sil($id){  

		Favori::destroy($id);

		return back()
		->with('mesaj', 'Favorilere silindi.')
		->with('mesaj_tur', 'success');
	}
}
