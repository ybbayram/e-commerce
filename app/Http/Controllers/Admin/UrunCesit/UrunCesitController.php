<?php

namespace App\Http\Controllers\Admin\UrunCesit;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\{Urun, Dil, Cesit, CesitDil, CesitDetay, CesitDetayDil, CesitDesi};

class UrunCesitController extends AdminController
{
    public function index($urun){ 
        $urun = Urun::find($urun);
        $cesit = Cesit::where('urun_id', $urun->id)->where('deleted_at', null)->orderBy('created_at', 'asc')->get();
        
        return view('admin.urun.cesit.index', compact('urun', 'cesit'));
    }

    public function olusturSayfa($urun){
        $urun = Urun::find($urun);
        $diller = Dil::orderBy('created_at', 'DESC')->get();

        return view('admin.urun.cesit.olustur', compact('urun', 'diller'));
    }
    public function olustur($urun){
        $data = request()->all();

        $baslik = Cesit::create([
            'urun_id' => $urun,
            'baslik' => $data['ad']
        ]);
        return redirect()->route('admin.urunCesit', $urun)
        ->with('mesaj', 'Ürün çeşit oluşturuldu')
        ->with('mesaj_tur', 'success');
    }



    public function guncelleSayfa($id){ 
        $diller = Dil::orderBy('created_at', 'DESC')->get();
        $cesit = Cesit::where('id', $id)->where('deleted_at', null)->first();

        return view('admin.urun.cesit.guncelle', compact('diller', 'cesit'));
    }

    public function guncelle($id){
        $data = request()->all();
        $baslik = Cesit::where('id', $id)->update([
            'baslik' => $data['ad']
        ]);
        $cesit = Cesit::where('id', $id)->first();

        return redirect()->route('admin.urunCesit', $cesit->urun_id)
        ->with('mesaj', 'Ürün çeşit oluşturuldu')
        ->with('mesaj_tur', 'success');
    }
    public function sil($id){

        Cesit::destroy($id);
        $cesitler = CesitDetay::where('cesit_id', $id)->get();
        foreach ($cesitler as $cesit) {
            CesitDetay::destroy($cesit->id);
        }

        return back()
        ->with('mesaj', 'Ürün çeşit silindi.')
        ->with('mesaj_tur', 'success');
    }

    public function aktifYap($id)
    {
        $cesit = Cesit::find($id);
        $cesit->durum = 1;
        $cesit->save();

        return back()
        ->with('mesaj', 'Çeşit durumu aktif yapıldı.')
        ->with('mesaj_tur', 'success');
    }

    public function pasifYap($id)
    {
        $cesit = Cesit::find($id);
        $cesit->durum = 0;
        $cesit->save();

        return back()
        ->with('mesaj', 'Çeşit durumu pasif yapıldı.')
        ->with('mesaj_tur', 'success');
    }
}
