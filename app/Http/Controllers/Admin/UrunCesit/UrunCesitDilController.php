<?php

namespace App\Http\Controllers\Admin\UrunCesit;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\{Urun, Dil, Cesit, CesitDil, CesitDetay, CesitDetayDil, CesitDesi};


class UrunCesitDilController extends AdminController
{
    public function index($cesit){
        $cesit = Cesit::find($cesit);
        $cesitDil = CesitDil::where('cesit_id', $cesit->id)->orderByDesc('created_at')->get(); 
        return view('admin.urun.cesit.cesitDil.index', compact('cesit','cesitDil' ));
    }

    public function olustur($cesit){
        $data = request()->all(); 

        $cesitBul = Cesit::find($cesit);

        $dilKontrol = CesitDil::where('dil_id', $data['dil_id'])->where('cesit_id', $cesit)->first();
        if(isset($dilKontrol)){
            return back()
            ->with('mesaj', 'Bu dil için zaten bir kayıt var')
            ->with('mesaj_tur', 'danger');
        }
        CesitDil::create([
            'dil_id' => $data['dil_id'],
            'cesit_id' => $cesit,
            'ad' => $data['ad']
        ]);

        return redirect()->route('admin.urunCesitDil', $cesit)
        ->with('mesaj', 'Çeşit dili oluşturuldu')
        ->with('mesaj_tur', 'success');
    }

    public function olusturSayfa($cesit){
        $cesit = Cesit::find($cesit);
        $diller = Dil::orderBy('created_at', 'DESC')->get();

        return view('admin.urun.cesit.cesitDil.olustur', compact('cesit','diller' ));
    }

    public function guncelleSayfa($cesit, $id){
        $cesitDil = CesitDil::where('id', $id)->firstOrFail(); 

        $cesit = Cesit::find($cesit); 

        $diller = Dil::orderBy('created_at', 'DESC')->get();

        return view('admin.urun.cesit.cesitDil.guncelle', compact('cesitDil', 'cesit', 'diller'));
    }

    public function guncelle($cesit, $id){
        $data = request()->all();
        $cesit = Cesit::find($cesit); 


        $cesitDil = CesitDil::find($id)->update([
            'ad' => $data['ad'], 
        ]);


        return redirect()->route('admin.urunCesitDil', ['cesit' => $cesit, 'id' => $id])
        ->with('mesaj', 'Çeşit dili güncellendi')
        ->with('mesaj_tur', 'success');
    }

    public function sil($id, $cesit){
        CesitDil::destroy($id);

        return back()
        ->with('mesaj', 'Çeşit dili silindi.')
        ->with('mesaj_tur', 'success');
    }
}
