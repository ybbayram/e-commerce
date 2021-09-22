<?php

namespace App\Http\Controllers\Admin\Site;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Site\{Sozlesmeler};


class SozlesmelerController extends AdminController
{
  public function index(){
    $sozlesmeler = Sozlesmeler::orderByDesc('created_at')->get();
    return view('admin.site.sozlesmeler.index', compact('sozlesmeler'));
}

public function olusturSayfa(){ 
    return view('admin.site.sozlesmeler.olustur');
}

public function olustur()
{
    $data = request()->all();
    if (!isset($data['goster'])) {
        $data['goster'] = "0";
    }
    if (!isset($data['kayit_goster'])) {
        $data['kayit_goster'] = "0";
    }
    if (!isset($data['cookie_goster'])) {
        $data['cookie_goster'] = "0";
    }
    $kontrol = Sozlesmeler::where('baslik', $data['baslik'])->first();
    if (isset($kontrol)) {
        return back()
        ->with('mesaj', 'Sözleşme zaten kayıtlı')
        ->with('mesaj_tur', 'danger');
    }

    $sozlesme = Sozlesmeler::create([
        'baslik' => $data['baslik'],
        'odeme_durum' => $data['goster'],
        'kayit_durum' => $data['kayit_goster'],
        'cookie_durum' => $data['cookie_goster'],
        'slug' => Str::slug($data['baslik'])
    ]);

    return redirect()->route('admin.sozlesme')
    ->with('mesaj', 'Sözleşme oluşturuldu')
    ->with('mesaj_tur', 'success');
}

public function guncelleSayfa($id)
{  
    $sozlesme = Sozlesmeler::where('id', $id)->firstOrFail(); 

    return view('admin.site.sozlesmeler.guncelle', compact('sozlesme'));
}


public function guncelle($id){
    $data = request()->all();
    if (!isset($data['goster'])) {
        $data['goster'] = "0";
    }
    if (!isset($data['kayit_goster'])) {
        $data['kayit_goster'] = "0";
    }
    if (!isset($data['cookie_goster'])) {
        $data['cookie_goster'] = "0";
    }
    
    $sozlesme = Sozlesmeler::find($id)->update([ 
        'baslik' => $data['baslik'], 
        'odeme_durum' => $data['goster'],
        'kayit_durum' => $data['kayit_goster'],
        'cookie_durum' => $data['cookie_goster'],
        'slug' => Str::slug($data['baslik'])

    ]);


    return redirect()->route('admin.sozlesme')
    ->with('mesaj', 'Söleşme güncellendi')
    ->with('mesaj_tur', 'success');
}

public function sil($id)
{
    Sozlesmeler::destroy($id);

    return back()
    ->with('mesaj', 'Sözleşme silindi.')
    ->with('mesaj_tur', 'success');
}

}