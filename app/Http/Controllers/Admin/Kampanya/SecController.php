<?php

namespace App\Http\Controllers\Admin\Kampanya;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\{Ulke, UlkeKod, SepetIndirim, XalYode, Promosyon, Kargo, AktifKampanya, AktifKampanyaDetay}; 
use Carbon;
class SecController extends AdminController
{
    //aciklama.txt

    public function index(){
        $ulkeler = Ulke::join('ulke_kodlari', 'ulke.ulke_kod_id', 'ulke_kodlari.id')->select('ulke_kodlari.*', 'ulke.*')->get();

        return view('admin.kampanya.kampanyaSec.index', compact('ulkeler'));
    }
    public function kampanya($id){ 

        $ulke = Ulke::where('id', $id)->firstOrFail();
        

        $mytime = Carbon\Carbon::now();
        $tarih = $mytime->toDateTimeString();

        $kargolar = Kargo::where('bitis_tarihi', '>=', $tarih)->where('deleted_at', null)->orderBy('created_at', 'asc')->get();
        $sepet = SepetIndirim::where('bitis_tarihi', '>=', $tarih)->where('deleted_at', null)->orderBy('created_at', 'asc')->get();
        $XalYode = XalYode::where('bitis_tarihi', '>=', $tarih)->where('deleted_at', null)->orderBy('created_at', 'asc')->get();
        $promosyon = Promosyon::where('bitis_tarihi', '>=', $tarih)->where('deleted_at', null)->orderBy('created_at', 'asc')->get();

        $aktifKampanya = AktifKampanya::join('aktif_kampanya_detay', 'aktif_kampanya.id', 'aktif_kampanya_detay.aktif_kampanya_id')
        ->where('ulke_id', $id)
        ->where('aktif_kampanya_detay.deleted_at', null)
        ->where('aktif_kampanya.deleted_at', null)
        ->get(); 
        return view('admin.kampanya.kampanyaSec.kampanya', compact('kargolar', 'sepet', 'XalYode', 'promosyon', 'ulke', 'aktifKampanya'));
    }
    public function kampanyaSec($id){

        $data = request()->all();
        $aktifSil = AktifKampanya::where('ulke_id', $id)->get();
        foreach($aktifSil as $sil){
            $a = AktifKampanyaDetay::where('aktif_kampanya_id', $sil->id)->get(); 
            foreach($a as $b){
                AktifKampanyaDetay::destroy($b->id);
            }
        }
        $aktifBul = AktifKampanya::where('ulke_id', $id)->get();
        

        if (isset($data['kargolar'])) {
            foreach($data['kargolar'] as $entry){
                $kargo = AktifKampanya::where('ulke_id', $id)->where('grup', 0)->first();
                AktifKampanyaDetay::create([
                    'aktif_kampanya_id' => $kargo->id,
                    'uygulanan_id' => $entry
                ]);
            }
        }
        if (isset($data['sepet'])) {
            foreach($data['sepet'] as $entry){
                $sepet = AktifKampanya::where('ulke_id', $id)->where('grup', 1)->first();


                AktifKampanyaDetay::create([
                    'aktif_kampanya_id' => $sepet->id,
                    'uygulanan_id' => $entry
                ]);
            }
        }
        if (isset($data['XalYode'])) {
            foreach($data['XalYode'] as $entry){
                $XalYode = AktifKampanya::where('ulke_id', $id)->where('grup', 2)->first();
                AktifKampanyaDetay::create([
                    'aktif_kampanya_id' => $XalYode->id,
                    'uygulanan_id' => $entry
                ]);
            }
        }
        if (isset($data['promosyon'])) {
            foreach($data['promosyon'] as $entry){
                $promosyon = AktifKampanya::where('ulke_id', $id)->where('grup', 3)->first();

                AktifKampanyaDetay::create([
                    'aktif_kampanya_id' => $promosyon->id,
                    'uygulanan_id' => $entry
                ]);
            }
        }




/*
        foreach ($aktifBul as $aktif) {
            $aktifDetay = AktifKampanyaDetay::where('aktif_kampanya_id', $aktif->id)->get();
            foreach($dizi as $di){
                for ($i = 0; $i <= 3 ; $i++) { 
                    if ($aktif->grup == $i) {
                        if (isset($data[$di])) {
                            foreach ($data[$di] as $entry) {
                               if (!isset($aktifDetay)) {
                                AktifKampanyaDetay::create([
                                    'aktif_kampanya_id' => $aktif->id,
                                    'uygulanan_id' => $entry
                                ]);    
                            }else{
                                AktifKampanyaDetay::where('aktif_kampanya_id', $aktif->id)->update([
                                    'aktif_kampanya_id' => $aktif->id,
                                    'uygulanan_id' => $entry
                                ]);   
                            }

                        }
                    }
                }
            }
        }
    }
*/



    return redirect()->route('admin.camp.kampanya', $id)
    ->with('mesaj', 'Kampanyası oluşturuldu')
    ->with('mesaj_tur', 'success');

}

}
