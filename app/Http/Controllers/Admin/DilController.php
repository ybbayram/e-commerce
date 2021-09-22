<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\{Dil, UlkeKod};

class DilController extends AdminController
{
    public function index()
    {
        $diller = Dil::orderByDesc('created_at')->get();

        return view('admin.dil.index', compact('diller'));
    }

    public function olustur()
    {
        $data = request()->all();

        $kontrol = Dil::where('ulke_kod_id', $data['ulke_kod_id'])->first();
        if (isset($kontrol)) {
            return back()
                ->with('mesaj', 'Ülke zaten kayıtlı')
                ->with('mesaj_tur', 'danger');
        }

        $this->validate(request(), [
            'json' => 'json'
        ]);

        $dil = Dil::create([
            'ad' => $data['ad'],
            'gorunur_ad' => $data['gorunurAd'],
            'ulke_kod_id' => $data['ulke_kod_id'],
            'json' => $data['json'],
        ]);

        return redirect()->route('admin.dil')
            ->with('mesaj', 'Dil oluşturuldu')
            ->with('mesaj_tur', 'success');
    }

    public function olusturSayfa()
    {
        $ulkeKodlari = UlkeKod::orderBy('created_at', 'ASC')->get();

        return view('admin.dil.olustur', compact('ulkeKodlari'));
    }

    public function guncelleSayfa($id)
    {
        $ulkeKodlari = UlkeKod::orderBy('created_at', 'ASC')->get();
        $dil = Dil::where('id', $id)->firstOrFail();

        return view('admin.dil.guncelle', compact('dil', 'ulkeKodlari'));
    }

    public function guncelle($id)
    {
        $data = request()->all();

        $this->validate(request(), [
            'json' => 'json'
        ]);

        $dil = Dil::find($id)->update([
            'ad' => $data['ad'],
            'gorunur_ad' => $data['gorunurAd'],
            'ulke_kod_id' => $data['ulke_kod_id'],
        ]);

        return redirect()->route('admin.dil')
            ->with('mesaj', 'Dil güncellendi')
            ->with('mesaj_tur', 'success');
    }

    public function sil($id)
    {
        Dil::destroy($id);

        return back()
            ->with('mesaj', 'Dil silindi.')
            ->with('mesaj_tur', 'success');
    }

    public function aktifYap($id)
    {
        $dil = Dil::find($id);
        $dil->durum = 1;
        $dil->save();

        return back()
            ->with('mesaj', 'Dil durumu aktif yapıldı.')
            ->with('mesaj_tur', 'success');
    }

    public function pasifYap($id)
    {
        $dil = Dil::find($id);
        $dil->durum = 0;
        $dil->save();

        return back()
            ->with('mesaj', 'Dil durumu pasif yapıldı.')
            ->with('mesaj_tur', 'success');
    }
}
