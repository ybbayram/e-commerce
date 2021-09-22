<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{RequestCount, Siparis};

class RequestCountController extends Controller
{
    public function siparislerMuhasebe(Request $request){
        $data = $request->all();

        if($data['guvenlik_bir']==153 and $data['guvenlik_iki']==46022386){
            $istek = RequestCount::where('numara', 1)->first();

            $siparis = Siparis::where('created_at', ">", $istek['updated_at'])->where('deleted_at', '=', null)->get();
        
            $response = array();
            $count = 0;
            foreach($siparis as $entry){
                if($entry->islem_durum == 5){
                    $response[$count]['siparis_no'] = $entry['id'];
                    if($entry->adres_bul['kurumsal_mi'] == 1){
                        $response[$count]['cari_ad_soyad'] = $entry->adres_bul['isim'];
                        $response[$count]['cari_unvan'] = $entry->adres_bul->adres_kurumsal_getir['firma_adi'];
                        $response[$count]['vergi_dairesi'] = $entry->adres_bul->adres_kurumsal_getir['vergi_dairesi'];
                        $response[$count]['vergi_no'] = $entry->adres_bul->adres_kurumsal_getir['vergi_numarasi'];
                    }else{
                        $response[$count]['cari_ad_soyad'] = $entry->adres_bul['isim'];
                        $response[$count]['cari_unvan'] = null;
                        $response[$count]['vergi_dairesi'] = null;
                        $response[$count]['vergi_no'] = null;
                    }

                    if($entry->fatura_adres_id != null){
                        $response[$count]['adres'] = $entry->fatura_adres_bul['adres'];
                        $response[$count]['ilce'] = $entry->fatura_adres_bul['ilce'];
                        $response[$count]['sehir'] = $entry->fatura_adres_bul['il'];
                        $response[$count]['ulke'] = $entry->fatura_adres_bul->ulke_getir->ulke_kod_getir['ad'];
                    }else{
                        $response[$count]['adres'] = $entry->adres_bul['adres'];
                        $response[$count]['ilce'] = $entry->adres_bul['ilce'];
                        $response[$count]['sehir'] = $entry->adres_bul['il'];
                        $response[$count]['ulke'] = $entry->adres_bul->ulke_getir->ulke_kod_getir['ad'];
                    }

                    $response[$count]['siparis_adres'] = $entry->adres_bul['adres'];
                    $response[$count]['siparis_ilce'] = $entry->adres_bul['ilce'];
                    $response[$count]['siparis_sehir'] = $entry->adres_bul['il'];
                    $response[$count]['siparis_ulke'] = $entry->adres_bul->ulke_getir->ulke_kod_getir['ad'];
                    $response[$count]['siparis_tarihi'] = $entry['created_at'];

                    $response[$count]['email'] = $entry->adres_bul['mail'];
                    $response[$count]['telefon'] = $entry->adres_bul['telefon'];

                    $countTwo = 0;
                    foreach($entry->siparis_sepet_getir->sepet_urun_getir as $sepetUrun){
                        if($sepetUrun->sepeturun_urun_getir['cesit_durum'] == 1){
                            $response[$count]['urun'][$countTwo]['urun_kodu'] = $sepetUrun->sepeturun_urun_getir['kod'];
                        }
                        if($sepetUrun->sepeturun_urun_getir['cesit_durum'] == 0){
                            $response[$count]['urun'][$countTwo]['urun_kodu'] = $sepetUrun->sepeturun_urun_getir->cesit_bul['kod'];
                        }
                        $response[$count]['urun'][$countTwo]['urun_adi'] = $sepetUrun->sepeturun_urun_getir->detay_bul['ad'];
                        $response[$count]['urun'][$countTwo]['birim_fiyat'] = $sepetUrun->fiyati;
                        if($sepetUrun->sepeturun_urun_getir['cesit_durum'] == 1){
                            $response[$count]['urun'][$countTwo]['kdv_orani'] = $sepetUrun->sepeturun_urun_getir->fiyat_bul['kdv_orani'];
                        }
                        if($sepetUrun->sepeturun_urun_getir['cesit_durum'] == 0){
                            $response[$count]['urun'][$countTwo]['kdv_orani'] = $sepetUrun->sepeturun_urun_getir->cesit_bul->cesit_fiyat_bul['kdv_orani'];
                        }
                        $response[$count]['urun'][$countTwo]['miktar'] = $sepetUrun->adet;

                        $countTwo++;
                    }
                    
                $count++;
                }

            }
            
            $istek->touch();

            return $response;
        }
    }
    
    public function restore(Request $request){
        $data = $request->all();

        if($data['guvenlik_bir']==153 and $data['guvenlik_iki']==46022386){
            $istek = RequestCount::where('numara', 1)->first();
            $istek->updated_at = "2021-08-04 15:18:27";
            $istek->save();
            
            return "1";
            
        }
    }
}
