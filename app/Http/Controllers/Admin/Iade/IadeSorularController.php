<?php

namespace App\Http\Controllers\Admin\Iade;

use App\Http\Controllers\AdminController;
use App\Models\{IadeSorular};
use Illuminate\Support\Str;

class IadeSorularController extends AdminController
{
    public function index(){
        $sorular = IadeSorular::orderByDesc('created_at')->get();
        return view('admin.iade.sorular.index', compact( 'sorular'));
    }
    public function olusturSayfa(){ 
        return view('admin.iade.sorular.olustur');

    }

    public function olustur()
    {
        $data = request()->all();

        $soru = IadeSorular::create([
            'ad' => $data['ad']
        ]);
        return redirect()->route('admin.iade.sorular')
        ->with('mesaj', 'Soru oluşturuldu')
        ->with('mesaj_tur', 'success');
    }

    public function guncelleSayfa($id)
    {  
        $soru = IadeSorular::where('id', $id)->firstOrFail(); 

        return view('admin.iade.sorular.guncelle', compact('soru'));
    }

    public function guncelle($id)
    {
        $data = request()->all(); 

        $soru = IadeSorular::find($id)->update([
            'ad' => $data['ad']
        ]);
        return redirect()->route('admin.iade.sorular')
        ->with('mesaj', 'Soru güncellendi')
        ->with('mesaj_tur', 'success');
    }

    public function sil($id)
    {
        IadeSorular::destroy($id);

        return back()
        ->with('mesaj', 'Soru silindi.')
        ->with('mesaj_tur', 'success');
    }
    public function aktifYap($id)
    {
        $soru = IadeSorular::find($id);
        $soru->durum = 1;
        $soru->save();

        return back()
        ->with('mesaj', 'İade Soru durumu aktif yapıldı.')
        ->with('mesaj_tur', 'success');
    }

    public function pasifYap($id)
    {
        $soru = IadeSorular::find($id);
        $soru->durum = 0;
        $soru->save();

        return back()
        ->with('mesaj', 'İade Soru durumu pasif yapıldı.')
        ->with('mesaj_tur', 'success');
    }

}
