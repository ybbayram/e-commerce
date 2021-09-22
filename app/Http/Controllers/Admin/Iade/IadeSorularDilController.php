<?php

namespace App\Http\Controllers\Admin\Iade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{IadeSorular, IadeSorularDil};
use Illuminate\Support\Str;
use App\Models\{Dil};

class IadeSorularDilController extends Controller
{

    public function index($soru){
        $soruDil = IadeSorularDil::where('iade_soru_id', $soru)->orderByDesc('created_at')->get();
        $soru = IadeSorular::find($soru);

        return view('admin.iade.sorularDil.index', compact('soruDil', 'soru'));
    }

    public function olusturSayfa($soru){
        $soru = IadeSorular::find($soru);
        $diller = Dil::orderBy('created_at', 'DESC')->get();

        return view('admin.iade.sorularDil.olustur', compact('soru', 'diller'));
    }

    public function olustur($soru){
       $data = request()->all();
       $soruBul = IadeSorular::find($soru);
       $dilKontrol = IadeSorularDil::where('dil_id', $data['dil_id'])->where('iade_soru_id', $soru)->first();
       if(isset($dilKontrol)){
        return back()
        ->with('mesaj', 'Bu dil için zaten bir kayıt var')
        ->with('mesaj_tur', 'danger');
    }

    $soruDil = IadeSorularDil::create([
        'dil_id' => $data['dil_id'],
        'iade_soru_id' => $soru,
        'aciklama' => $data['aciklama'] 
    ]);


    return redirect()->route('admin.iade.sorularDil', $soru)
    ->with('mesaj', 'Soru dili oluşturuldu')
    ->with('mesaj_tur', 'success');
}



public function guncelleSayfa($soru, $id){
    $soruDil = IadeSorularDil::where('id', $id)->firstOrFail();
    $soru = IadeSorular::find($soru);
    $diller = Dil::orderBy('created_at', 'DESC')->get();

    return view('admin.iade.sorularDil.guncelle', compact('soruDil', 'soru', 'diller'));
}

public function guncelle($soru, $id){
    $data = request()->all(); 

    $soruDil = IadeSorularDil::find($id)->update([ 
        'aciklama' => $data['aciklama']
        
    ]);
    return redirect()->route('admin.iade.sorularDil', ['soru' => $soru, 'id' => $id])
    ->with('mesaj', 'Soru dili güncellendi')
    ->with('mesaj_tur', 'success');
}

public function sil($soru, $id){
    IadeSorularDil::destroy($id);

    return back()
    ->with('mesaj', 'Soru dili silindi.')
    ->with('mesaj_tur', 'success');
}
}
