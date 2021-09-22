<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\GenelFonksiyonlar;
use App\Models\{Urun, UrunFiyat, UrunDetay, UrunAnaliz, KategoriAnaliz, UrunKategori, UrunKategoriAlt, Ulke,
    UlkeKod, Kategori, KategoriAlt, KategoriDil, KategoriAltDil,
    Ziyaretci, Marka, Etiket, Filtre, FiltreKategori, FiltreKategoriAlt, UrunEtiket, Yorum, Gorsel, CesitFiyat, CesitDetay};

    class ShopController extends ApiController
    {
        public function ulkeIdBul(){
            $ipUlke = GenelFonksiyonlar::getIp();
            $ip = $ipUlke['ip'];
            $ulkeKod = $ipUlke['ulkeKod'];
            $ulkeKod = UlkeKod::where('kod', $ulkeKod)->first();
            $ulke = Ulke::where('ulke_kod_id', $ulkeKod->id)->first();

            return $ulke->id;
        }

        public function kategoriler(Request $request){
            $data = $request->all();
            $giris = $data['giris'];
            $veri = $data['veri'];

            if($giris['guvenlik_bir'] == 153 and $giris['guvenlik_iki'] == 7825810){
                $ziyaretci = Ziyaretci::where('token', $veri['token'])->first();
                $kategoriDilTarih = KategoriDil::orderBy('updated_at', 'DESC')->select('updated_at')->first();
                if($kategoriDilTarih['updated_at'] < $veri['kategori_updated_at']){
                    return "false";
                }else{
                    $kategoriUpdatedAt = $kategoriDilTarih['updated_at'];
                }


                $agac = array();

                $kategoriler = Kategori::join('kategori_dil', 'kategori.id', '=', 'kategori_dil.kategori_id')
                ->where('kategori_dil.dil_id', $ziyaretci->dil_id)
                ->where('durum', 1)->where('ust_id', 0)->orderBy('sira', 'asc')
                ->select('kategori.id', 'kategori.slug', 'kategori.icon', 'kategori_dil.gorsel', 'kategori_dil.ad', 'kategori_dil.aciklama')
                ->get();
                $agac = $kategoriler;
                $count = 0;
                foreach($kategoriler as $kategori){
                    $kategoriAltBir = Kategori::join('kategori_dil', 'kategori.id', '=', 'kategori_dil.kategori_id')
                    ->where('kategori_dil.dil_id', $ziyaretci->dil_id)
                    ->where('durum', 1)->where('ust_id', $kategori->id)->orderBy('sira', 'asc')
                    ->select('kategori.id', 'kategori.slug', 'kategori.icon', 'kategori_dil.gorsel', 'kategori_dil.ad', 'kategori_dil.aciklama')
                    ->get();
                    $agac[$count]['alt'] = $kategoriAltBir;
                    $countTwo = 0;
                    foreach($kategoriAltBir as $kategoriTwo){
                        $kategoriAltİki = Kategori::join('kategori_dil', 'kategori.id', '=', 'kategori_dil.kategori_id')
                        ->where('kategori_dil.dil_id', $ziyaretci->dil_id)
                        ->where('durum', 1)->where('ust_id', $kategoriTwo->id)->orderBy('sira', 'asc')
                        ->select('kategori.id','kategori.updated_at', 'kategori.slug', 'kategori.icon', 'kategori_dil.gorsel', 'kategori_dil.ad', 'kategori_dil.aciklama')
                        ->get();
                        $agac[$count]['alt'][$countTwo]['alt'] = $kategoriAltİki;
                        $countThree = 0;
                        foreach($kategoriAltİki as $kategoriThree){
                            $kategoriAltUc = Kategori::join('kategori_dil', 'kategori.id', '=', 'kategori_dil.kategori_id')
                            ->where('kategori_dil.dil_id', $ziyaretci->dil_id)
                            ->where('durum', 1)->where('ust_id', $kategoriThree->id)->orderBy('sira', 'asc')
                            ->select('kategori.id', 'kategori.slug', 'kategori.icon', 'kategori_dil.gorsel', 'kategori_dil.ad', 'kategori_dil.aciklama')
                            ->get();
                            $agac[$count]['alt'][$countTwo]['alt'][$countThree]['alt'] = $kategoriAltUc;
                            $countThree++;
                        }
                        $countTwo++;
                    }
                    $count++;
                }
                return response()->json(['kategoriler'=>$agac, 'kategor_updated_at'=>$kategoriUpdatedAt]);
            }
        }


        public function kategoriUrun(Request $request){
            $data = $request->all();
            $giris = $data['giris'];
            $veri = $data['veri'];
            $ulkeId = $this->ulkeIdBul();

            if($giris['guvenlik_bir'] == 153 and $giris['guvenlik_iki'] == 7825810){
                $kategoriBul = Kategori::whereSlug($veri['slug'])->first();
                if(!isset($kategoriBul)) return '{"response": 0}';
                $ziyaretci = Ziyaretci::where('token', $veri['token'])->first();

                $urunler = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
                ->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
                ->join('marka', 'urun.marka', '=', 'marka.id')
                ->where('kategori.durum', 1)
                ->where('kategori.deleted_at', '=', null)
                ->where('marka.durum', 1)
                ->where('marka.deleted_at', '=', null)
                ->where('urun_kategori.kategori_id', $kategoriBul->id)
                ->where('urun_kategori.deleted_at', '=', null) 
                ->where('urun.deleted_at', '=', null) 
                ->where('urun.durum', 1)
                ->select('urun.id', 'urun.stok', 'urun.slug', 'urun.cesit_durum')
                ->distinct('urun_kategori.id')
                ->paginate(16); 

           
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

        public function kategoriUrunGorsel(Request $request){
            $data = $request->all();
            $giris = $data['giris'];
            $veri = $data['veri'];

            if($giris['guvenlik_bir'] == 153 and $giris['guvenlik_iki'] == 7825810){
                $urun = Urun::where('slug', $veri['slug'])->first();
                $gorsel = Gorsel::where('urun_id', $urun->id)->orderBy('sira', 'asc')->first();
                return response()->json(['gorsel' => $gorsel->gorsel]);
            }
        }


        public function urun(Request $request){
            $data = $request->all();
            $giris = $data['giris'];
            $veri = $data['veri'];

            if($giris['guvenlik_bir'] == 153 and $giris['guvenlik_iki'] == 7825810){
                $ulkeId = $this->ulkeIdBul();
                $ziyaretci = Ziyaretci::where('token', $veri['token'])->first();

                $urun = Urun::where('urun.slug', $veri['slug'])
                ->join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
                ->join('urun_detay', 'urun.id', '=', 'urun_detay.urun_id')
                ->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
                ->join('marka', 'urun.marka', '=', 'marka.id')
                ->where('kategori.durum', 1)
                ->where('urun_detay.dil_id', $ziyaretci->dil_id)
                ->where('kategori.deleted_at', '=', null) 
                ->where('urun_kategori.deleted_at', '=', null) 
                ->where('urun_detay.deleted_at', '=', null) 
                ->where('marka.durum', 1)
                ->where('marka.deleted_at', '=', null)
                ->where('urun.deleted_at', '=', null)
                ->select('urun.id', 'urun.slug', 'urun.kod', 'urun.stok', 'urun.cesit_durum', 'marka.ad as marka-ad', 'marka.slug as marka-slug', 'urun_detay.ad', 'urun_detay.ad', 'urun_detay.aciklama_bir', 'urun_detay.aciklama_bir_baslik', 'urun_detay.aciklama_iki', 'urun_detay.aciklama_iki_baslik', 'urun_detay.aciklama_uc', 'urun_detay.aciklama_uc_baslik', 'urun_detay.aciklama_dort', 'urun_detay.aciklama_dort_baslik') 
                ->firstOrFail();


                $gorsel = Gorsel::where('urun_id', $urun->id)->orderBy('sira', 'asc')->select('gorsel')->get();

                $urunAnaliz = UrunAnaliz::where('urun_id', $urun->id)
                ->select('oy_sayi', 'ortalama_puan')
                ->first();

                if($urun->cesit_durum == 1){
                    $urunFiyat = UrunFiyat::where('urun_id', $urun->id)
                    ->select('fiyat', 'fiyat_onceki')
                    ->first();
                }else{
                    //$urunFiyat = CesitFiyat::
                }


                $urunKategoriler = UrunKategori::join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
                ->join('kategori_dil', 'kategori.id', '=', 'kategori_dil.kategori_id')
                ->where('kategori.durum', 1)
                ->where('kategori.deleted_at', '=', null)
                ->where('kategori_dil.deleted_at', '=', null)
                ->where('urun_id', $urun->id)
                ->where('kategori_dil.dil_id', $ziyaretci->dil_id)
                ->select('kategori.slug', 'kategori.icon', 'kategori_dil.ad') 
                ->get();

                $yorumlar = Yorum::join('users', 'yorum.user_id', '=', 'users.id')
                ->where('urun_id',$urun->id)->where('durum',1)
                ->orderBy('yorum.oy', 'desc')
                ->select('yorum.id', 'yorum.oy', 'yorum.yorum', 'yorum.updated_at', 'users.ad as user_ad')
                ->paginate(2);

                $yorum = Yorum::where('urun_id',$urun->id)->where('durum',1)->get();
                $oysayi = $yorum->count();
                $analiz = UrunAnaliz::where('urun_id', $urun->id)->first();
                $tiklama = $analiz->mobil_tiklama + 1;

                if($analiz->oy_sayi > 0){
                    $ortalama = $analiz->toplam_puan / $analiz->oy_sayi;
                }

                UrunAnaliz::where('urun_id', $urun->id)->update([
                    'tiklama'=>$tiklama, 
                    'oy_sayi' => $oysayi,
                    'ortalama_puan' => 1
                ]);

                return response()->json(['urun' => $urun, 'gorsel' => $gorsel, 'urunKategoriler' => $urunKategoriler, 'yorumlar' => $yorumlar, 'urunAnaliz' => $urunAnaliz, 'urunFiyat' => $urunFiyat]);
            }
        }
        
        public function urunDetayYorum(Request $request){
            $data = $request->all();
            $giris = $data['giris'];
            $veri = $data['veri'];

            if($giris['guvenlik_bir'] == 153 and $giris['guvenlik_iki'] == 7825810){
                $urun = Urun::whereSlug($veri['slug'])->first();
                $yorumlar = Yorum::join('users', 'yorum.user_id', '=', 'users.id')
                ->where('urun_id',$urun->id)->where('durum',1)
                ->orderBy('yorum.oy', 'desc')
                ->select('yorum.id', 'yorum.oy', 'yorum.yorum', 'yorum.updated_at', 'users.ad as user_ad')
                ->paginate(2);

                $analiz = UrunAnaliz::where('urun_id', $urun->id)->first();
                $tiklama = $analiz->mobil_tiklama + 1;

                UrunAnaliz::where('urun_id', $urun->id)->update([
                    'tiklama' => $tiklama
                ]);
                
                return response()->json(['yorumlar' => $yorumlar]);
            }
            
        }
        
        public function search(Request $request){
            $data = $request->all();
            $giris = $data['giris'];
            $veri = $data['veri'];
            $ulkeId = $this->ulkeIdBul();

            if($giris['guvenlik_bir'] == 153 and $giris['guvenlik_iki'] == 7825810){
                $aranan = $veri['aranan'];
                $ziyaretci = Ziyaretci::where('token', $veri['token'])->first();
                $urunler = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
                ->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
                ->join('marka', 'urun.marka', '=', 'marka.id')
                ->where('kategori.durum', 1)
                ->where('kategori.deleted_at', '=', null) 
                ->where('urun_kategori.deleted_at', '=', null) 
                ->where('marka.durum', 1)
                ->where('urun.durum', 1)
                ->where('urun.baslik', 'like', "%$aranan%")
                ->where('marka.deleted_at', '=', null)
                ->where('urun.deleted_at', '=', null)
                ->select('urun.id', 'urun.stok', 'urun.slug', 'urun.cesit_durum')
                ->distinct('urun_kategori.id')
                ->paginate(16);

           
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
    }