<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\{KargoFiyat, Ulke, UlkeKod };

class KargoFiyatController extends AdminController
{
    public function index(){

       $ulkeler = Ulke::join('ulke_kodlari', 'ulke.ulke_kod_id', 'ulke_kodlari.id')
       ->select('ulke_kodlari.*', 'ulke.*')->get();

       return view('admin.kargo.index', compact('ulkeler'));
   }

   public function kargo_sayfa($id){

    $ulke = Ulke::where('id', $id)->firstOrFail();
    $kargo = KargoFiyat::where('ulke_id', $ulke->id)->first(); 
    $kargo->create([
        'ulke_id' => $id
    ]);
    return view('admin.kargo.kargoFiyat', compact('kargo','ulke'));
}

public function kargo($id){ 
    $data = request()->all();

    $kargo = KargoFiyat::where('ulke_id', $data['ulke_id'])->update([
        'ulke_id' => $data['ulke_id'],
        'limit_alt_fiyat' => $data['limit_alt_fiyat'],
        'limit_üst_fiyat' => $data['limit_üst_fiyat'],
        'limit' => $data['limit']
    ]);
    return back()
    ->with('mesaj', 'Güncellendi')
    ->with('mesaj_tur', 'success');
}


}
