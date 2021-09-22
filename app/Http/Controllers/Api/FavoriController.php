<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\GenelFonksiyonlar;
use App\Models\{Ziyaretci, Urun, Favori, UlkeKod, Ulke};

class FavoriController extends ApiController
{
    public function ulkeIdBul(){
            $ipUlke = GenelFonksiyonlar::getIp();
            $ip = $ipUlke['ip'];
            $ulkeKod = $ipUlke['ulkeKod'];
            $ulkeKod = UlkeKod::where('kod', $ulkeKod)->first();
            $ulke = Ulke::where('ulke_kod_id', $ulkeKod->id)->first();

            return $ulke->id;
        }
        
    public function listele(Request $request){
        $data = $request->all();
        $giris = $data['giris'];
        $veri = $data['veri'];
        $ulkeId = $this->ulkeIdBul();

        if($giris['guvenlik_bir'] == 153 and $giris['guvenlik_iki'] == 7825810){
            $ziyaretci = Ziyaretci::where('token', $veri['token'])->first();
            $favori = Favori::where('ziyaretci_id', $ziyaretci->id)->first();
            $urunler = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
                ->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
                ->join('marka', 'urun.marka', '=', 'marka.id')
                ->join('favori', 'urun.id', '=', 'favori.urun_id')
                ->where('kategori.durum', 1)
                ->where('kategori.deleted_at', '=', null)
                ->where('marka.durum', 1)
                ->where('marka.deleted_at', '=', null)
                ->where('favori.deleted_at', '=', null)
                ->where('favori.ziyaretci_id', $ziyaretci->id)
                ->where('urun_kategori.deleted_at', '=', null) 
                ->where('urun.deleted_at', '=', null) 
                ->select('urun.id', 'urun.stok', 'urun.slug','urun.cesit_durum')
                ->distinct('urun_kategori.id')
                ->paginate(8); 
                
            $fiyatlar = array();
                $count = 0;
                foreach($urunler as $entry){
                    if($entry->cesit_durum == 1){
                        $entry->fiyat_bul;
                        $entry->detay_bul;
                        $entry->gorseller_bul;
                        $entry->urun_analiz_bul;
                    }else{
                        $entry->detay_bul;
                        $entry->gorseller_bul;
                        $entry->urun_analiz_bul;
                        foreach($entry->cesitler_bul as $cesit){
                            $cesit->cesit_dil_getir;
                            foreach($cesit->cesit_detay_bul as $detay){
                                $detay->cesit_detay_dil_getir;
                                $detay->cesit_detay_fiyat_bul;
                            }
                        }
                    }
                    $count++;
                }

                $ulkeId = $this->ulkeIdBul();
                $ulke = Ulke::find($ulkeId)->first();
                $paraSimge = $ulke->para_birimi_getir['simge'];

                return response()->json(['urunler' => $urunler, 'paraSimge' => $paraSimge]);
        }
    }
    
    public function ekle(Request $request){
     $data = $request->all();
     $giris = $data['giris'];
     $veri = $data['veri'];

     if($giris['guvenlik_bir'] == 153 and $giris['guvenlik_iki'] == 7825810){
        $ziyaretci = Ziyaretci::where('token', $veri['token'])->firstOrFail();
        $urun = Urun::whereSlug($veri['slug'])->firstOrFail();
        
        $favKontrol = Favori::where('urun_id', $urun->id)->where('ziyaretci_id', $ziyaretci->id)->first();
        
      

        if(isset($favKontrol)){
            //ürün favorilerdde zaten var
            return '{"response": 0}';
        }
        Favori::create([
            'ziyaretci_id' => $ziyaretci->id,
            'urun_id' => $urun->id,
        ]);

        return '{"response": 1}';
    }
}

public function kaldir(Request $request){
    $data = $request->all();
    $giris = $data['giris'];
    $veri = $data['veri'];

    if($giris['guvenlik_bir'] == 153 and $giris['guvenlik_iki'] == 7825810){
        $ziyaretci = Ziyaretci::where('token', $veri['token'])->first();
        $urun = Urun::whereSlug($veri['slug'])->firstOrFail();
        $favori = Favori::where('ziyaretci_id', $ziyaretci->id)->where('urun_id', $urun->id)->first();
        Favori::destroy($favori->id);

        return '{"response": 1}';
    }
}
}
