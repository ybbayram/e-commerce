<?php

namespace App\Http\Controllers\Admin\UrunCesit;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\{Urun, Dil, Cesit, CesitDil, CesitDetay, CesitDetayDil, CesitDesi};

class UrunCesitDetayController extends AdminController
{
    public function index($cesit){ 

        $cesitler = Cesit::where('id', $cesit)->first();
        $urun = Urun::find($cesitler->urun_id);
        $cesitDetay = CesitDetay::where('cesit_id', $cesit)->where('deleted_at', null)->get();
        $diller = Dil::orderBy('created_at', 'DESC')->get();

        return view('admin.urun.cesit.cesitDetay.index', compact('cesitler', 'diller', 'urun', 'cesitDetay'));

    }

    public function olustur($cesit){
        $data = request()->all();

        $desi = ( $data['en'] * $data['boy'] * $data['yukseklik']) / 3000; 

        $cesit_detay = CesitDetay::create([
            'cesit_id' => $cesit,
            'ad' => $data['cesit'],
            'kod' => $data['kod'],
            'barkod' => $data['barkod'],
            'stok' => $data['stok'],
        ]);  

        CesitDesi::create([
            'cesit_detay_id' => $cesit_detay->id,
            'en' => $data['en'],
            'boy' => $data['boy'],
            'yukseklik' => $data['yukseklik'],
            'kilogram' => $data['kilogram'],
            'desi' => $desi
        ]);

        return redirect()->route('admin.urunCesitDetay', $cesit)
        ->with('mesaj', 'Ürün çeşit oluşturuldu')
        ->with('mesaj_tur', 'success');
    }


    public function guncelleSayfa($id){ 
        $cesitDetay = CesitDetay::where('id', $id)->where('deleted_at', null)->first();
        $desi = CesitDesi::where('cesit_detay_id', $cesitDetay->id)->first();
        return view('admin.urun.cesit.cesitDetay.guncelle', compact('cesitDetay', 'desi'));
    }

    public function guncelle($id){
        $data = request()->all();
        $desi = ( $data['en'] * $data['boy'] * $data['yukseklik']) / 3000; 

        $cesit = CesitDetay::where('id', $data['cesit_detay_id'])->update([ 
            'cesit_id' => $id,
            'ad' => $data['cesit'],
            'kod' => $data['kod'],
            'barkod' => $data['barkod'],
            'stok' => $data['stok']
        ]); 
        CesitDesi::where('cesit_detay_id', $data['cesit_detay_id'])->update([
            'cesit_detay_id' => $data['cesit_detay_id'],
            'en' => $data['en'],
            'boy' => $data['boy'],
            'yukseklik' => $data['yukseklik'],
            'kilogram' => $data['kilogram'],
            'desi' => $desi
        ]);
        return redirect()->route('admin.urunCesitDetay', $id)
        ->with('mesaj', 'Ürün çeşit güncellendi')
        ->with('mesaj_tur', 'success');
    }


    public function sil($id){
        CesitDetay::destroy($id);

        return back()
        ->with('mesaj', 'Ürün çeşit silindi.')
        ->with('mesaj_tur', 'success');
    }
    
    public function aktifYap($id)
    {
        $cesitDetay = CesitDetay::find($id);
        $cesitDetay->durum = 1;
        $cesitDetay->save();

        return back()
        ->with('mesaj', 'Çeşit durumu aktif yapıldı.')
        ->with('mesaj_tur', 'success');
    }

    public function pasifYap($id)
    {
        $cesitDetay = CesitDetay::find($id);
        $cesitDetay->durum = 0;
        $cesitDetay->save();

        return back()
        ->with('mesaj', 'Çeşit durumu pasif yapıldı.')
        ->with('mesaj_tur', 'success');
    }


}
