<?php

namespace App\Http\Controllers\Admin\Kampanya;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\{ Kargo}; 

class KargoController extends AdminController
{
    public function index(){
        $kargolar = Kargo::orderBy('created_at', 'asc')->get();
        return view('admin.kampanya.kargo.index',compact('kargolar'));
    }

    public function olusturSayfa(){ 
        return view('admin.kampanya.kargo.olustur');
    }
    public function olustur(){ 
        $data = request()->all();

        $kontrol = Kargo::where('ad', $data['ad'])->first();
        if (isset($kontrol)) {
            return back()
            ->with('mesaj', 'Kargo Kampanyası zaten kayıtlı')
            ->with('mesaj_tur', 'danger');
        }

        $kargolar = Kargo::create([
            'ad' => $data['ad'],
            'min' => $data['min'],
            'indirim_oranı' => $data['oran'],
            'baslangic_tarihi' => $data['baslangic_tarihi'],
            'bitis_tarihi' => $data['bitis_tarihi'],
        ]);
        return redirect()->route('admin.kargo')
        ->with('mesaj', 'Kargo Kampanyası oluşturuldu')
        ->with('mesaj_tur', 'success');
    }

    public function guncelleSayfa($id){ 
        $kargo = Kargo::where('id', $id)->firstOrFail(); 
        
        return view('admin.kampanya.kargo.guncelle', compact('kargo'));
    }
    public function guncelle($id)
    {
        $data = request()->all(); 

        $kargo = Kargo::find($id)->update([
            'ad' => $data['ad'],
            'min' => $data['min'],
            'indirim_oranı' => $data['oran'],
            'baslangic_tarihi' => $data['baslangic_tarihi'],
            'bitis_tarihi' => $data['bitis_tarihi'],
        ]);
        return redirect()->route('admin.kargo')
        ->with('mesaj', 'Kargo Kampanyası güncellendi')
        ->with('mesaj_tur', 'success');
    }

    public function sil($id)
    {
        Kargo::destroy($id);

        return back()
        ->with('mesaj', 'Kargo Kampanyası Silindi.')
        ->with('mesaj_tur', 'success');
    }
}
