<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\{Filtre,FiltreDil,Dil};

class FiltreDilController extends AdminController
{
    public function index($filtre){
        $filtreDil = FiltreDil::where('filtre_id', $filtre)->orderByDesc('created_at')->get();
        $filtre = Filtre::find($filtre);

        return view('admin.filtreDil.index', compact('filtreDil', 'filtre'));
    }

    public function olustur($filtre){
        $data = request()->all();

        $dilKontrol = FiltreDil::where('dil_id', $data['dil_id'])->where('filtre_id', $filtre)->first();
        if(isset($dilKontrol)){
            return back()
            ->with('mesaj', 'Bu dil için zaten bir kayıt var')
            ->with('mesaj_tur', 'danger');
        }

        $filtreDil = FiltreDil::create([
            'ad' => $data['ad'],
            'filtre_id' => $filtre,
            'dil_id' => $data['dil_id'],
        ]);

        return redirect()->route('admin.filtreDil', $filtre)
        ->with('mesaj', 'Filtre dili oluşturuldu')
        ->with('mesaj_tur', 'success');
    }

    public function olusturSayfa($filtre){
        $filtre = Filtre::find($filtre);
        $diller = Dil::orderBy('created_at', 'DESC')->get();

        return view('admin.filtreDil.olustur', compact('filtre', 'diller'));
    }

    public function guncelleSayfa($filtre, $id){
        $filtreDil = FiltreDil::where('id', $id)->firstOrFail();
        $filtre = Filtre::find($filtre);
        $diller = Dil::orderBy('created_at', 'DESC')->get();

        return view('admin.filtreDil.guncelle', compact('filtreDil', 'filtre', 'diller'));
    }

    public function guncelle($filtre, $id){
        $data = request()->all();

        $filtreDil = FiltreDil::find($id)->update([
            'ad' => $data['ad'], 
        ]);

        return redirect()->route('admin.filtreDil', ['filtre' => $filtre, 'id' => $id])
        ->with('mesaj', 'Filtre dili güncellendi')
        ->with('mesaj_tur', 'success');
    }

    public function sil($filtre, $id){
        FiltreDil::destroy($id);

        return back()
        ->with('mesaj', 'Filtre dili silindi.')
        ->with('mesaj_tur', 'success');
    }
}
