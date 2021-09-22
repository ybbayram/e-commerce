<?php

namespace App\Http\Controllers\Tanitim;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FonksiyonlarController;
use Illuminate\Http\Request;
use Cookie;
use App\Models\{Ziyaretci, Ulke, UlkeKod, ParaBirimi, Dil, KargoFiyat, KargoFirma, SiparisDurumlari, UrunFiyat, CesitFiyat};

class ZiyaretciController extends Controller
{
    public function olustur(){ 

    }

   // /*
    public function deneme(){
    	$oku = fopen('./okunacak.txt', 'r');

        while (!feof($oku)) {
            $satir = fgets($oku);
            $dilimler = explode(".", $satir);
            $kod = $dilimler[0];
            $ad = $dilimler[1];

            UlkeKod::create([
                'kod' => $kod,
                'ad' => $ad,
            ]);

        }
        $oku = fopen('./SiparisDurumlari.txt', 'r');

        while (!feof($oku)) {
            $satir = fgets($oku);
            $dilimler = explode(".", $satir);
            $id = $dilimler[0];
            $durum = $dilimler[1];

            SiparisDurumlari::create([
                'durum_id' => $id,
                'durum' => $durum,
            ]);

        }

        $paralar = [['Türk Lirası', '₺'], ['Euro', '€'], ['Amerikan Doları', '$'], ['İngiliz Sterlini', '£']];

        foreach($paralar as $entry){
            ParaBirimi::create([
                'ad' => $entry[0],
                'simge' => $entry[1]
            ]);
        }

        Dil::create([
            'ad' => 'Türkçe',
            'gorunur_ad' => 'Türkçe',
            'ulke_kod_id' => 1,
            'json' => '{}',
            'durum' => 1
        ]);

        $ulke = Ulke::create([
            'ulke_kod_id' => 1,
            'dil_id' => 1,
            'para_birimi_id' => 1
        ]);
        KargoFiyat::create([
            'ulke_id' => $ulke->id
        ]);
        
        KargoFirma::create([
            'ad' => 'mng'
        ]);
        


        fclose($oku);

        return true;
    }
   // */
   
   public function kdv(){
        $urunFiyatlar = UrunFiyat::all();

        foreach($urunFiyatlar as $entry){
            $entry->kdv_orani = 18.00;
            $entry->kdvsiz_fiyat = ($entry->kdvsiz_fiyat * 100) / 118;
            $entry->save();
        }

        $urunCesitFiyatlar = CesitFiyat::all();

        foreach($urunCesitFiyatlar as $entry){
            $entry->kdv_orani = 18.00;
            $entry->kdvsiz_fiyat = ($entry->kdvsiz_fiyat * 100) / 118;
            $entry->save();
        }

        return "1";
    }
}
