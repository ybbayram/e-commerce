<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\{Urun, OneCikanlarUrun};

class OneCikanlarUrunController extends AdminController
{
    public function ekle($id){  
        $data = request()->all();
        $dilimler = explode(",", $data['stok_kodlari']);
        foreach($dilimler as $dilim){
            $urun = Urun::where('kod', $dilim)->first();
            if (isset($urun)) {
                $urunVarMi = OneCikanlarUrun::where('urun_id', $urun->id)->first();
                if (!isset($urunVarMi)) {
                    OneCikanlarUrun::create([
                        'one_cikan_id' => $id,
                        'urun_id' => $urun->id
                    ]);
                }else{
                    return back()
                    ->with('mesaj', 'Ürün zaten kayıtlı')
                    ->with('mesaj_tur', 'danger');
                }
            }else{

                return back()
                ->with('mesaj', 'Yanlış Kod')
                ->with('mesaj_tur', 'danger');
            }
        }

        return back()
        ->with('mesaj', 'Başarılı')
        ->with('mesaj_tur', 'success');
    }
    public function sil($id){
        OneCikanlarUrun::destroy($id);
        return back()
        ->with('mesaj', 'Ürün silindi.')
        ->with('mesaj_tur', 'success');
    }
}
