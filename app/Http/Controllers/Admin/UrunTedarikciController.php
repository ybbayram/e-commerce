<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\{Urun, UrunDetay, Dil, Tedarikci, UrunTedarikci, CesitDetay, Cesit};

class UrunTedarikciController extends AdminController
{
    public function index($urun){
        $cesitDetay = [];
        $urunDetay = Urun::find($urun);
        if ($urunDetay->cesit_durum == 0) {
            $cesit = Cesit::where('urun_id', $urun)->first();
            if (isset($cesit)) {
                $cesitDetay = CesitDetay::where('cesit_id', $cesit->id)->orderBy('created_at', 'asc')->get();
            }
            $tedarikciler = Tedarikci::orderByDesc('created_at')->get();
            $urunTedarikcileri = UrunTedarikci::where('urun_id', $urun)->where('cesit_detay_id', '>', '0')->orderByDesc('created_at')->get();
        }else{
            $cesit = Cesit::where('urun_id', $urun)->first();
            if (isset($cesit)) {
                $cesitDetay = CesitDetay::where('cesit_id', $cesit->id)->orderBy('created_at', 'asc')->get();
            }
            $tedarikciler = Tedarikci::orderByDesc('created_at')->get();
            $urunTedarikcileri = UrunTedarikci::where('urun_id', $urun)->where('cesit_detay_id', null)->orderByDesc('created_at')->get();
        }
        
        return view('admin.urun.tedarikci.index', compact('tedarikciler', 'urun', 'urunTedarikcileri', 'cesitDetay', 'urunDetay'));
    }
    public function olustur($urun){
        $data = request()->all();
        if (!isset($data['cesit_detay_id'])) {
            $data['cesit_detay_id'] = null;
        }
        $kontrol = UrunTedarikci::where('urun_id', $urun)->where('tedarikci_id', $data['tedarikci'])->where('cesit_detay_id', $data['cesit_detay_id'])->first();
        if (isset($kontrol)) {
            return back()
            ->with('mesaj', 'Tedarikci zaten kayıtlı')
            ->with('mesaj_tur', 'danger');
        }

        $tedarikci = UrunTedarikci::create([
            'urun_id' => $urun,
            'tedarikci_id' => $data['tedarikci'],  
            'cesit_detay_id' => $data['cesit_detay_id'],  
            'stok_kodu' => $data['stok_kodu']
        ]);

        return redirect()->route('admin.urunTedarikci', $urun)
        ->with('mesaj', 'Kategori oluşturuldu')
        ->with('mesaj_tur', 'success');
    }

    public function guncelleSayfa($id){
        $cesitDetay = [];
        $tedarikciler = Tedarikci::orderByDesc('created_at')->get();

        $tedarikci = UrunTedarikci::where('id', $id)->orderByDesc('created_at')->first();
        $urunDetay = Urun::find($tedarikci->urun_id);

        $cesit = Cesit::where('urun_id', $tedarikci->urun_id)->first(); 
        if (isset($cesit)) {
            $cesitDetay = CesitDetay::where('cesit_id', $cesit->id)->orderBy('created_at', 'asc')->get();
        }
        $cesit = CesitDetay::where('id', $tedarikci->cesit_detay_id)->orderBy('created_at', 'asc')->first();
        return view('admin.urun.tedarikci.guncelle', compact('tedarikciler', 'tedarikci', 'cesit', 'cesitDetay', 'urunDetay'));
    }
    
    public function guncelle($id){
        $data = request()->all();
        if (!isset($data['cesit_detay_id'])) {
            $data['cesit_detay_id'] = null;
        }
        $urun = UrunTedarikci::where('id', $id)->orderByDesc('created_at')->first();

        $kontrol = UrunTedarikci::where('urun_id', $urun->id)->where('tedarikci_id', $data['tedarikci'])->where('cesit_detay_id', $data['cesit_detay_id'])->first();
        if (isset($kontrol)) {
            return back()
            ->with('mesaj', 'Tedarikci zaten kayıtlı')
            ->with('mesaj_tur', 'danger');
        }
        $tedarikci = UrunTedarikci::where('id', $id)->update([
            'cesit_detay_id' => $data['cesit_detay_id'],
            'stok_kodu' => $data['stok_kodu']
        ]);

        return redirect()->route('admin.urunTedarikci', $urun->urun_id)
        ->with('mesaj', 'Tedarikçi Güncelleştirildi')
        ->with('mesaj_tur', 'success');
    }
    public function aktifYap($urun){
        $tedarikci = UrunTedarikci::find($urun);
        $tedarikci->durum = 1;
        $tedarikci->save();

        return back()
        ->with('mesaj', 'Ürün Tedarikçi durumu aktif yapıldı.')
        ->with('mesaj_tur', 'success');
    }

    public function pasifYap($urun){
        $tedarikci = UrunTedarikci::find($urun);
        $tedarikci->durum = 0;
        $tedarikci->save();

        return back()
        ->with('mesaj', 'Ürün Tedarikçi durumu pasif yapıldı.')
        ->with('mesaj_tur', 'success');
    } 
    public function sil($urun){
        UrunTedarikci::destroy($urun);

        return back()
        ->with('mesaj', 'Ürün Tedarikçi silindi.')
        ->with('mesaj_tur', 'success');
    }


}
