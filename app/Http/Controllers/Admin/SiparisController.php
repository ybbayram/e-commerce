<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\{Siparis, SiparisDurumlari};

class SiparisController extends AdminController
{
	public function index(){ 
		$durumlar = SiparisDurumlari::orderBy('durum_id', 'asc')->get();
		$siparisler = Siparis::where('islem_durum','!=',0)->orderByDesc('created_at')->get();

		return view('admin.siparis.index', compact('siparisler', 'durumlar'));
	}

	public function detay($id){

		$siparis = Siparis::where('id', $id)->first();
		$odeme = $siparis->siparis_sepet_getir->sepet_odeme_getir;
		return view('admin.siparis.detay', compact('siparis', 'odeme'));
	}
	public function islemDurum($id){   
		$data = request()->all();
		$siparis = Siparis::where('id', $id)->update(['islem_durum'=>$data['islem'], 'kargo_kod' => $data['kargo_kod']]);

		return back()
		->with('mesaj', 'Durum Güncellendi')
		->with('mesaj_tur', 'success');
	}
}
