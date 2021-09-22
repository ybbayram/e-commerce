<?php

namespace App\Http\Controllers\Admin\Kampanya;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\{SepetIndirim}; 

class SepetIndirimController extends AdminController
{

    public function index(){
        $sepetIndirim = SepetIndirim::orderBy('created_at', 'asc')->get();
        return view('admin.kampanya.sepetIndirim.index',compact('sepetIndirim'));
    }

    public function olusturSayfa(){ 
        return view('admin.kampanya.sepetIndirim.olustur');
    }
    public function olustur(){ 
        $data = request()->all();  
        $kontrol = SepetIndirim::where('ad', $data['ad'])->first();
        
        if (isset($kontrol)) {
            return back()
            ->with('mesaj', 'Sepette İndirim Kampanyası zaten kayıtlı')
            ->with('mesaj_tur', 'danger');
        } 
        if ($data['tur'] == 0) {
         SepetIndirim::create([
            'ad' => $data['ad'],
            'min' => $data['min'],
            'tur' => $data['tur'],
            'indirim_oranı' => $data['oran'],
            'baslangic_tarihi' => $data['baslangic_tarihi'],
            'bitis_tarihi' => $data['bitis_tarihi']
        ]); 
     }
     if ($data['tur'] == 1) {
        SepetIndirim::create([
            'ad' => $data['ad'],
            'min' => $data['min'],
            'tur' => $data['tur'],
            'indirim_oranı' => $data['tutar'],
            'baslangic_tarihi' => $data['baslangic_tarihi'],
            'bitis_tarihi' => $data['bitis_tarihi']
        ]);

    }

    return redirect()->route('admin.sepetIndirim')
    ->with('mesaj', 'Sepette İndirim Kampanyası oluşturuldu')
    ->with('mesaj_tur', 'success');
}

public function guncelleSayfa($id){ 
    $sepetIndirim = SepetIndirim::where('id', $id)->firstOrFail(); 

    return view('admin.kampanya.sepetIndirim.guncelle', compact('sepetIndirim'));
}
public function guncelle($id)
{
    $data = request()->all(); 
    if ($data['tur'] == 0) {
        $sepetIndirim = SepetIndirim::find($id)->update([
            'ad' => $data['ad'],
            'min' => $data['min'],
            'tur' => $data['tur'],
            'indirim_oranı' => $data['oran'],
            'baslangic_tarihi' => $data['baslangic_tarihi'],
            'bitis_tarihi' => $data['bitis_tarihi'],
        ]);
    }
    if ($data['tur'] == 1) {
        $sepetIndirim = SepetIndirim::find($id)->update([
            'ad' => $data['ad'],
            'min' => $data['min'],
            'tur' => $data['tur'],
            'indirim_oranı' => $data['tutar'],
            'baslangic_tarihi' => $data['baslangic_tarihi'],
            'bitis_tarihi' => $data['bitis_tarihi'],
        ]);
    }
    return redirect()->route('admin.sepetIndirim')
    ->with('mesaj', 'Sepette İndirim Kampanyası güncellendi')
    ->with('mesaj_tur', 'success');
}

public function sil($id)
{
    SepetIndirim::destroy($id);

    return back()
    ->with('mesaj', 'Sepette İndirim Kampanyası Silindi.')
    ->with('mesaj_tur', 'success');
}
}
