<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\{Etiket, EtiketDil, Dil};

class EtiketDilController extends AdminController
{
 public function index($etiket){
    $etiketDil = EtiketDil::where('etiket_id', $etiket)->orderByDesc('created_at')->get();
    $etiket = Etiket::find($etiket);

    return view('admin.etiketDil.index', compact('etiketDil', 'etiket'));
}

public function olustur($etiket){
    $data = request()->all();

    $dilKontrol = EtiketDil::where('dil_id', $data['dil_id'])->where('etiket_id', $etiket)->first();
    if(isset($dilKontrol)){
        return back()
        ->with('mesaj', 'Bu dil için zaten bir kayıt var')
        ->with('mesaj_tur', 'danger');
    }

    $etiketDil = EtiketDil::create([
        'ad' => $data['ad'],
        'etiket_id' => $etiket,
        'dil_id' => $data['dil_id'],
    ]);

    return redirect()->route('admin.etiketDil', $etiket)
    ->with('mesaj', 'Etiket dili oluşturuldu')
    ->with('mesaj_tur', 'success');
}

public function olusturSayfa($etiket){
    $etiket = Etiket::find($etiket);
    $diller = Dil::orderBy('created_at', 'DESC')->get();

    return view('admin.etiketDil.olustur', compact('etiket', 'diller'));
}

public function guncelleSayfa($etiket, $id){
    $etiketDil = EtiketDil::where('id', $id)->firstOrFail();
    $etiket = Etiket::find($etiket);
    $diller = Dil::orderBy('created_at', 'DESC')->get();

    return view('admin.etiketDil.guncelle', compact('etiketDil', 'etiket', 'diller'));
}

public function guncelle($etiket, $id){
    $data = request()->all();

    $etiketDil = EtiketDil::find($id)->update([
        'ad' => $data['ad'], 
    ]);

    return redirect()->route('admin.etiketDil', ['etiket' => $etiket, 'id' => $id])
    ->with('mesaj', 'Etiket dili güncellendi')
    ->with('mesaj_tur', 'success');
}

public function sil($etiket, $id){
    EtiketDil::destroy($id);

    return back()
    ->with('mesaj', 'Etiket dili silindi.')
    ->with('mesaj_tur', 'success');
}
}
