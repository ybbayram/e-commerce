<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\GenelFonksiyonlar;
use App\Models\{Urun, Ulke, UlkeKod, Marka, Ziyaretci, KategoriAnaliz};
use App\Models\Site\{SiteSlider, SiteBanner, SiteBanner2, SiteSliderDil};

class IndexController extends ApiController
{
    public function ulkeIdBul(){
        $ipUlke = GenelFonksiyonlar::getIp();
        $ip = $ipUlke['ip'];
        $ulkeKod = $ipUlke['ulkeKod'];
        $ulkeKod = UlkeKod::where('kod', $ulkeKod)->first();
        $ulke = Ulke::where('ulke_kod_id', $ulkeKod->id)->first();

        return $ulke->id;
    }

    public function anasayfaSlider(Request $request){
        $data = $request->all();
        $giris = $data['giris'];
        $veri = $data['veri'];

        if($giris['guvenlik_bir']==153 and $giris['guvenlik_iki']==7825810){
            $ziyaretci = Ziyaretci::where('token', $veri['token'])->first();

            $slider = SiteSlider::join('site_slider_dil', 'site_slider.id', '=', 'site_slider_dil.slider_id')
            ->where('site_slider_dil.dil_id', $ziyaretci->dil_id)
            ->where('site_slider_dil.deleted_at', '=', null)
            ->where('durum', 1)
            ->orderBy('sira', 'asc')
            ->select('site_slider_dil.id','site_slider_dil.dil_id','site_slider_dil.gorsel','site_slider_dil.slider_id','site_slider_dil.gorsel','site_slider_dil.gorsel_mobil', 'site_slider_dil.baslik', 'site_slider_dil.detay','site_slider_dil.buton_baslik', 'site_slider_dil.buton_link')
            ->get();

            return response()->json(['anasayfaSlider'=>$slider]);
        }else{
            return "false";
        }
    }

    public function oneCikanlar(Request $request){
        $data = $request->all();
        $giris = $data['giris'];
        $veri = $data['veri'];
        $ulkeId = $this->ulkeIdBul();

        if($giris['guvenlik_bir']==153 and $giris['guvenlik_iki']==7825810){
            $populerKat = KategoriAnaliz::join('kategori', 'kategori_analiz.kategori_id', '=', 'kategori.id')
            ->where('kategori.durum', 1)
            ->where('kategori.deleted_at', '=', null)
            ->orderBy('tiklama', 'desc')->take(4)->get();

            $ziyaretci = Ziyaretci::where('token', $veri['token'])->first();

            $onecikanBir = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
            ->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
            ->join('marka', 'urun.marka', '=', 'marka.id')
            ->where('kategori.durum', 1)
            ->where('kategori.deleted_at', '=', null)
            ->where('marka.durum', 1)
            ->where('marka.deleted_at', '=', null)
            ->where('urun_kategori.kategori_id', $populerKat[0]->kategori_id)
            ->where('urun_kategori.deleted_at', '=', null) 
            ->where('urun.deleted_at', '=', null) 
            ->where('urun.durum', 1)
            ->select('urun.id', 'urun.stok', 'urun.slug', 'urun.cesit_durum')
            ->distinct('urun_kategori.id')
            ->take(80)
            ->get(); 
            
                $count = 0;
                foreach($onecikanBir as $entry){
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

            $onecikanIki = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
            ->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
            ->join('marka', 'urun.marka', '=', 'marka.id')
            ->where('kategori.durum', 1)
            ->where('kategori.deleted_at', '=', null)
            ->where('marka.durum', 1)
            ->where('marka.deleted_at', '=', null)
            ->where('urun_kategori.kategori_id', $populerKat[1]->kategori_id)
            ->where('urun_kategori.deleted_at', '=', null) 
            ->where('urun.deleted_at', '=', null) 
            ->where('urun.durum', 1)
            ->select('urun.id', 'urun.stok', 'urun.slug','urun.cesit_durum')
            ->distinct('urun_kategori.id')
            ->take(8)
            ->get(); 
            
            $count = 0;
                foreach($onecikanIki as $entry){
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

            $onecikanUc = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
            ->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
            ->join('marka', 'urun.marka', '=', 'marka.id')
            ->where('kategori.durum', 1)
            ->where('kategori.deleted_at', '=', null)
            ->where('marka.durum', 1)
            ->where('marka.deleted_at', '=', null)
            ->where('urun_kategori.kategori_id', $populerKat[2]->kategori_id)
            ->where('urun_kategori.deleted_at', '=', null) 
            ->where('urun.deleted_at', '=', null) 
            ->where('urun.durum', 1)
            ->select('urun.id', 'urun.stok', 'urun.slug','urun.cesit_durum')
            ->distinct('urun_kategori.id')
            ->take(8)
            ->get(); 
            
            $count = 0;
                foreach($onecikanUc as $entry){
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

            $ulke = Ulke::find($ulkeId)->first();
            $paraSimge = $ulke->para_birimi_getir['simge'];

            return response()->json(['onecikanBir' => $onecikanBir, 'onecikanIki' => $onecikanIki, 'onecikanUc' => $onecikanUc, 'paraSimge' => $paraSimge]);
        }
    }
}
