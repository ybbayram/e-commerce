<?php

namespace App\Http\Controllers\Admin\UrunCesit;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\{Urun, Dil, Cesit, CesitDil, CesitDetay, CesitDetayDil, CesitDesi};


class UrunCesitDetayDilController extends AdminController
{
    public function index($cesitDetay){
        $cesitDetay = CesitDetay::find($cesitDetay);
        $cesitDetayDil = CesitDetayDil::where('cesit_detay_id', $cesitDetay->id)->orderByDesc('created_at')->get(); 
        
        return view('admin.urun.cesit.cesitDetayDil.index', compact('cesitDetay','cesitDetayDil' ));
    }

    public function olustur($cesitDetay){
        $data = request()->all(); 

        $cesitDetayBul = CesitDetay::find($cesitDetay);

        $dilKontrol = CesitDetayDil::where('dil_id', $data['dil_id'])->where('cesit_detay_id', $cesitDetay)->first();
        if(isset($dilKontrol)){
            return back()
            ->with('mesaj', 'Bu dil için zaten bir kayıt var')
            ->with('mesaj_tur', 'danger');
        }
        CesitDetayDil::create([
            'dil_id' => $data['dil_id'],
            'cesit_detay_id' => $cesitDetay,
            'ad' => $data['ad']
        ]);

        return redirect()->route('admin.urunCesitDetayDil', $cesitDetay)
        ->with('mesaj', 'Çeşit dili oluşturuldu')
        ->with('mesaj_tur', 'success');
    }

    public function olusturSayfa($cesitDetay){
        $cesitDetay = CesitDetay::find($cesitDetay);
        $diller = Dil::orderBy('created_at', 'DESC')->get();

        return view('admin.urun.cesit.cesitDetayDil.olustur', compact('cesitDetay','diller' ));
    }

    public function guncelleSayfa($cesitDetay, $id){
        $cesitDetayDil = CesitDetayDil::where('id', $id)->firstOrFail(); 

        $cesitDetay = CesitDetay::find($cesitDetay); 

        $diller = Dil::orderBy('created_at', 'DESC')->get();

        return view('admin.urun.cesit.cesitDetayDil.guncelle', compact('cesitDetayDil', 'cesitDetay', 'diller'));
    }

    public function guncelle($cesitDetay, $id){
        $data = request()->all();
        $cesitDetay = CesitDetay::find($cesitDetay); 


        $cesitDetayDil = CesitDetayDil::find($id)->update([
            'ad' => $data['ad'], 
        ]);


        return redirect()->route('admin.urunCesitDetayDil', ['cesitDetay' => $cesitDetay, 'id' => $id])
        ->with('mesaj', 'Çeşit dili güncellendi')
        ->with('mesaj_tur', 'success');
    }

    public function sil($id, $cesitDetay){
        CesitDetayDil::destroy($id);

        return back()
        ->with('mesaj', 'Çeşit dili silindi.')
        ->with('mesaj_tur', 'success');
    }
}
