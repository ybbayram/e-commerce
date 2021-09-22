<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\{Tedarikci, UlkeKod};

class TedarikciController extends AdminController
{
    public function index()
    {
        $tedarikciler = Tedarikci::orderByDesc('created_at')->get();

        return view('admin.tedarikci.index', compact('tedarikciler'));
    }

    public function olustur()
    {
        $data = request()->all();

        $kontrol = Tedarikci::where('ad', $data['ad'])->first();
        if (isset($kontrol)) {
            return back()
                ->with('mesaj', 'Tedarikci zaten kayıtlı')
                ->with('mesaj_tur', 'danger');
        }

        $tedarikci = Tedarikci::create([
            'ad' => $data['ad'],
            'yetkili_ad' => $data['yetkiliAd'],
            'email' => $data['email'],
            'telefon' => $data['telefon'],
            'ulke' => $data['ulke'],
            'il' => $data['il'],
            'ilce' => $data['ilce'],
            'adres' => $data['adres'],
            'vergi_no' => $data['vergiNo'],
            'vergi_daire' => $data['vergiDaire'],
            'not' => $data['not'],
        ]);

        return redirect()->route('admin.tedarikci')
            ->with('mesaj', 'Tedarikci oluşturuldu')
            ->with('mesaj_tur', 'success');
    }

    public function olusturSayfa()
    {
        
        $ulkeKodlari = UlkeKod::orderBy('created_at', 'ASC')->get();

        return view('admin.tedarikci.olustur', compact('ulkeKodlari'));
    }

    public function guncelleSayfa($id)
    {
        $ulkeKodlari = UlkeKod::orderBy('created_at', 'ASC')->get();
        $tedarikci = Tedarikci::where('id', $id)->firstOrFail();

        return view('admin.tedarikci.guncelle', compact('tedarikci', 'ulkeKodlari'));
    }

    public function guncelle($id)
    {
        $data = request()->all();

        $tedarikci = Tedarikci::find($id)->update([
            'ad' => $data['ad'],
            'yetkili_ad' => $data['yetkiliAd'],
            'email' => $data['email'],
            'telefon' => $data['telefon'],
            'ulke' => $data['ulke'],
            'il' => $data['il'],
            'ilce' => $data['ilce'],
            'adres' => $data['adres'],
            'vergi_no' => $data['vergiNo'],
            'vergi_daire' => $data['vergiDaire'],
            'not' => $data['not'],
        ]);


        return redirect()->route('admin.tedarikci')
            ->with('mesaj', 'Tedarikci güncellendi')
            ->with('mesaj_tur', 'success');
    }

    public function sil($id)
    {
        Tedarikci::destroy($id);

        return back()
            ->with('mesaj', 'Tedarikci silindi.')
            ->with('mesaj_tur', 'success');
    }
}
