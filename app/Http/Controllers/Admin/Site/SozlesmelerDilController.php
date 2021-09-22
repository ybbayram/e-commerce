<?php

namespace App\Http\Controllers\Admin\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Dil};
use Illuminate\Support\Str;
use App\Models\Site\{Sozlesmeler, SozlesmelerDil};


class SozlesmelerDilController extends Controller
{
   public function index($sozlesme){
    $sozlesmeDil = SozlesmelerDil::where('sozlesme_id', $sozlesme)->orderByDesc('created_at')->get();
    $sozlesme = Sozlesmeler::find($sozlesme);

    return view('admin.site.sozlesmelerDil.index', compact('sozlesmeDil', 'sozlesme'));
}

public function olusturSayfa($sozlesme){
    $sozlesme = Sozlesmeler::find($sozlesme);
    $diller = Dil::orderBy('created_at', 'DESC')->get();

    return view('admin.site.sozlesmelerDil.olustur', compact('sozlesme', 'diller'));
}

public function olustur($sozlesme){
   $data = request()->all();
   $sozlesmeBul = Sozlesmeler::find($sozlesme);
   $dilKontrol = SozlesmelerDil::where('dil_id', $data['dil_id'])->where('sozlesme_id', $sozlesme)->first();
   if(isset($dilKontrol)){
    return back()
    ->with('mesaj', 'Bu dil için zaten bir kayıt var')
    ->with('mesaj_tur', 'danger');
}

$sozlesmeDil = SozlesmelerDil::create([
    'sozlesme_id' => $sozlesme,
    'dil_id' => $data['dil_id'],
    'baslik' => $data['baslik'],
    'aciklama' => $data['aciklama']
]);

return redirect()->route('admin.sozlesmeDil', $sozlesme)
->with('mesaj', 'Sözleşme dili oluşturuldu')
->with('mesaj_tur', 'success');
}

public function guncelleSayfa($sozlesme, $id){
    $sozlesmeDil = SozlesmelerDil::where('id', $id)->firstOrFail();
    $sozlesme = Sozlesmeler::find($sozlesme);
    $diller = Dil::orderBy('created_at', 'DESC')->get();

    return view('admin.site.sozlesmelerDil.guncelle', compact('sozlesmeDil', 'sozlesme', 'diller'));
}

public function guncelle($sozlesme, $id){
    $data = request()->all();

    $sozlesmeBul = Sozlesmeler::find($sozlesme);

    $sozlesmeDil = SozlesmelerDil::find($id)->update([ 
        'baslik' => $data['baslik'],
        'aciklama' => $data['aciklama']
        
    ]); 

    return redirect()->route('admin.sozlesmeDil', ['sozlesme' => $sozlesme, 'id' => $id])
    ->with('mesaj', 'Sözleşme dili güncellendi')
    ->with('mesaj_tur', 'success');
}

public function sil($sozlesme, $id){
    SozlesmelerDil::destroy($id);

    return back()
    ->with('mesaj', 'Sözleşme dili silindi.')
    ->with('mesaj_tur', 'success');
}

}
