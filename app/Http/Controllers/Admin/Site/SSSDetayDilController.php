<?php

namespace App\Http\Controllers\Admin\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Site\{SSSDetay, SSSDetayDil};
use App\Models\{Dil};
use Illuminate\Support\Str;

class SSSDetayDilController extends Controller
{
    public function index($detay_id){
        $detayDil = SSSDetayDil::where('sss_detay_id', $detay_id)->orderByDesc('created_at')->get();
        $detay = SSSDetay::find($detay_id);

        return view('admin.site.sssDetayDil.index', compact('detayDil', 'detay'));
    }

    public function olusturSayfa($detay_id){
        $detay = SSSDetay::find($detay_id);
        $diller = Dil::orderBy('created_at', 'DESC')->get();

        return view('admin.site.sssDetayDil.olustur', compact('detay', 'diller'));
    }

    public function olustur($detay_id){
       $data = request()->all();
       $sssBul = SSSDetay::find($detay_id);
       $dilKontrol = SSSDetayDil::where('dil_id', $data['dil_id'])->where('sss_detay_id', $detay_id)->first();
       if(isset($dilKontrol)){
        return back()
        ->with('mesaj', 'Bu dil için zaten bir kayıt var')
        ->with('mesaj_tur', 'danger');
    }

    $sssDil = SSSDetayDil::create([
        'sss_detay_id' => $detay_id,
        'dil_id' => $data['dil_id'],
        'baslik' => $data['baslik'],
        'aciklama' => $data['aciklama']
    ]);

    return redirect()->route('admin.sssDetayDil', $detay_id)
    ->with('mesaj', 'SSS dili oluşturuldu')
    ->with('mesaj_tur', 'success');
}

public function guncelleSayfa($detay_id, $id){
    $detayDil = SSSDetayDil::where('id', $id)->firstOrFail();
    $detay = SSSDetay::find($detay_id);
    $diller = Dil::orderBy('created_at', 'DESC')->get();

    return view('admin.site.sssDetayDil.guncelle', compact('detayDil', 'detay', 'diller'));
}

public function guncelle($detay_id, $id){
    $data = request()->all();

    $sssBul = SSSDetay::find($detay_id);

    $sssDil = SSSDetayDil::find($id)->update([ 
        'baslik' => $data['baslik'],
        'aciklama' => $data['aciklama']
        
    ]); 

    return redirect()->route('admin.sssDetayDil', ['detay_id' => $detay_id, 'id' => $id])
    ->with('mesaj', 'SSS dili güncellendi')
    ->with('mesaj_tur', 'success');
}

public function sil($detay_id, $id){
    SSSDetayDil::destroy($id);

    return back()
    ->with('mesaj', 'SSS dili silindi.')
    ->with('mesaj_tur', 'success');
}

}
