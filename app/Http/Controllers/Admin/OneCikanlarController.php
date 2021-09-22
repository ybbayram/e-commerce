<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;  
use App\Models\{OneCikanlar, Dil,OneCikanlarUrun};

class OneCikanlarController extends AdminController
{
    public function index(){
        $oneCikanlar = OneCikanlar::orderByDesc('created_at')->get();
        return view('admin.urun.oneCikar.index', compact('oneCikanlar'));
    } 
    public function urun($id){
        $oneCikan = OneCikanlar::where('id', $id)->first();
        $urunler = OneCikanlarUrun::where('one_cikan_id', $id)->get();
        return view('admin.urun.oneCikar.urun', compact('oneCikan', 'id', 'urunler'));
    }
    public function olusturSayfa(){ 
        $diller = Dil::orderBy('created_at', 'DESC')->get();

        return view('admin.urun.oneCikar.olustur', compact('diller'));
    }
    public function olustur(){  
        $data = request()->all();
        $dilKontrol = OneCikanlar::where('dil_id', $data['dil_id'])->first();
        if(isset($dilKontrol)){
            return back()
            ->with('mesaj', 'Bu dil için zaten bir kayıt var')
            ->with('mesaj_tur', 'danger');
        }
        OneCikanlar::create([ 
            'dil_id' => $data['dil_id'],
            'baslik' => $data['baslik'],  
            'baslik_alt' => $data['baslik_alt']
        ]);

        return redirect()->route('admin.oneCikanlar')
        ->with('mesaj', 'Öne Çıkanlar dili oluşturuldu')
        ->with('mesaj_tur', 'success');
    }
    public function guncelleSayfa($id){ 
        $oneCikan = OneCikanlar::where('id', $id)->firstOrFail();  
        return view('admin.urun.oneCikar.guncelle', compact('oneCikan'));
    }
    public function guncelle($id){  
        $data = request()->all();

        OneCikanlar::where('id', $id)->update([ 
            'baslik' => $data['baslik'],  
            'baslik_alt' => $data['baslik_alt']
        ]);

        return redirect()->route('admin.oneCikanlar')
        ->with('mesaj', 'Öne Çıkanlar dili oluşturuldu')
        ->with('mesaj_tur', 'success');
    }
}
