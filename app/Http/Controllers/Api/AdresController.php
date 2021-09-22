<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\GenelFonksiyonlar;
use App\Models\{Ulke, UlkeKod, Adres, AdresKurumsal, Ziyaretci};

class AdresController extends ApiController
{
    public function ulkeIdBul(){
        $ipUlke = GenelFonksiyonlar::getIp();
        $ip = $ipUlke['ip'];
        $ulkeKod = $ipUlke['ulkeKod'];
        $ulkeKod = UlkeKod::where('kod', $ulkeKod)->first();
        $ulke = Ulke::where('ulke_kod_id', $ulkeKod->id)->first();

        return $ulke->id;
    }

    public function ulkeGonder(Request $request){
        $data = $request->all();
        $giris = $data['giris'];
        $veri = $data['veri'];

        if($giris['guvenlik_bir']==153 and $giris['guvenlik_iki']==7825810){
            $ulkeId = $this->ulkeIdBul();

            $ulke = Ulke::join('ulke_kodlari', 'ulke.ulke_kod_id', '=', 'ulke_kodlari.id')
            ->where('ulke.id', $ulkeId)
            ->where('ulke_kodlari.deleted_at', '=', null)
            ->select('ulke.id', 'ulke_kodlari.ad')
            ->get();

            return response()->json(['ulke'=>$ulke]);
        }
    }

    public function adresKaydet(Request $request){
        $data = $request->all();
        $giris = $data['giris'];
        $veri = $data['veri'];

        if($giris['guvenlik_bir']==153 and $giris['guvenlik_iki']==7825810){
            $ziyaretci = Ziyaretci::where('token', $veri['token'])->first();

            $adres = Adres::create([
                'ziyaretci_id' => $ziyaretci->id,
                'baslik' => $veri['baslik'],
                'isim' => $veri['ad'],
                'ulke' => $veri['ulke'],
                'il' => $veri['il'],
                'ilce' => $veri['ilce'],
                'mahalle' => $veri['mahalle'],
                'adres' => $veri['adres'],
                'postakodu' => $veri['postakodu'],
                'telefon' => $veri['telefon'],
                'mail' => $veri['mail'],
                'kimlik_no' => $veri['kimlik_no'],
            ]);

            if ($veri['firma_adi'] != null) {
                if($veri['eFatura'] == null){
                    $veri['eFatura'] = "0";
                }
                AdresKurumsal::create([
                    'adres_id' => $adres->id,
                    'firma_adi' => $veri['firma_adi'],
                    'vergi_numarasi' => $veri['vergi_numarasi'],
                    'vergi_dairesi' => $veri['vergi_dairesi'],
                    'eFatura' => $veri['eFatura']
                ]); 
                $adres->update(['kurumsal_mi' => 1]);
            }

            return '{"response": 1}';
        }
    }

    public function adresGuncelle(Request $request){
        $data = $request->all();
        $giris = $data['giris'];
        $veri = $data['veri'];

        if($giris['guvenlik_bir']==153 and $giris['guvenlik_iki']==7825810){
            $ziyaretci = Ziyaretci::where('token', $veri['token'])->first();

            if($veri['firma_adi'] == null){
                $veri['varMi'] = "0";
            }else{
                $veri['varMi'] = "1";
            }
            Adres::find($veri['adres_id'])->update([ 
                'baslik' => $veri['baslik'],
                'isim' => $veri['ad'],
                'ulke' => $veri['ulke'],
                'il' => $veri['il'],
                'ilce' => $veri['ilce'],
                'mahalle' => $veri['mahalle'],
                'adres' => $veri['adres'],
                'postakodu' => $veri['postakodu'],
                'telefon' => $veri['telefon'],
                'mail' => $veri['mail'],
                'kimlik_no' => $veri['kimlik_no'],
                'kurumsal_mi' => $veri['varMi']
            ]);
            $adres = Adres::find($veri['adres_id']); 

            if ($veri['firma_adi'] != null) {
                if($veri['eFatura'] == null){
                    $veri['eFatura'] = "0";
                }
                AdresKurumsal::where('adres_id',$veri['adres_id'])->update([
                    'firma_adi' => $veri['firma_adi'],
                    'vergi_numarasi' => $veri['vergi_numarasi'],
                    'vergi_dairesi' => $veri['vergi_dairesi'],
                    'eFatura' => $veri['eFatura']
                ]); 

            } 

            return '{"response": 1}';
        }
    }
    
    public function listele(Request $request){
        $data = $request->all();
        $giris = $data['giris'];
        $veri = $data['veri'];

        if($giris['guvenlik_bir']==153 and $giris['guvenlik_iki']==7825810){
            $ziyaretci = Ziyaretci::where('token', $veri['token'])->first();

            $adresler = Adres::where('ziyaretci_id', $ziyaretci->id)
            ->where('durum', 1)
            ->select('id', 'baslik', 'isim', 'telefon', 'mail', 'kimlik_no', 'ulke', 'il', 'ilce', 'adres.mahalle', 'adres.adres', 'postakodu', 'kurumsal_mi')
            ->get();
            
            foreach($adresler as $adres){
                if($adres->kurumsal_mi){
                    $adres->adres_kurumsal_getir;
                }
            }

            return response()->json(['adresler'=>$adresler]);
        }
    }

    public function kurumsalMi(Request $request){
        $data = $request->all();
        $giris = $data['giris'];
        $veri = $data['veri'];

        if($giris['guvenlik_bir']==153 and $giris['guvenlik_iki']==7825810){

            $kurumsal = AdresKurumsal::where('adres_id', $veri['adres_id'])
            ->select('id', 'firma_adi', 'vergi_numarasi', 'vergi_dairesi', 'eFatura')
            ->first();

            if(!isset($kurumsal)){
                return '{"response": 0}';
            }

            return response()->json(['kurumsal'=>$kurumsal]);
        }
    }

    public function adresSil(Request $request){
        $data = $request->all();
        $giris = $data['giris'];
        $veri = $data['veri'];

        if($giris['guvenlik_bir']==153 and $giris['guvenlik_iki']==7825810){

            Adres::find($veri['adres_id'])->update([
                'durum' => 0
            ]);

            return '{"response": 1}';
        }
    }
}
