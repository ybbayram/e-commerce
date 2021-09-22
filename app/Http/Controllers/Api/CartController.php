<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\GenelFonksiyonlar;
use App\Http\Controllers\FonksiyonlarController;
use Cart;
use Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use App\Models\{Sepet, SepetUrun, Urun, UrunFiyat, Ziyaretci, Dil, Ulke, UlkeKod, CesitDetay, CesitFiyat, SepetUygulananIndirim, KargoFiyat, AktifKampanya, AktifKampanyaDetay, SepetIndirim, Kargo, XalYode, XalYodeDetay, Kategori, Etiket, Marka, UrunEtiket ,Promosyon, PromosyonDetay, SepetOdeme};

class CartController extends ApiController
{
    public function ulkeIdBul(){
        $ipUlke = GenelFonksiyonlar::getIp();
        $ip = $ipUlke['ip'];
        $ulkeKod = $ipUlke['ulkeKod'];
        $ulkeKod = UlkeKod::where('kod', $ulkeKod)->first();
        $ulke = Ulke::where('ulke_kod_id', $ulkeKod->id)->first();

        return $ulke->id;
    }

    public function ekle(Request $request){
        $data = $request->all();
        $giris = $data['giris'];
        $veri = $data['veri'];
        $ulkeId = $this->ulkeIdBul();

        if($giris['guvenlik_bir'] == 153 and $giris['guvenlik_iki'] == 7825810){

            if(!isset($veri['adet'])){
                $veri['adet'] = 1;
            }

            $urun = Urun::whereSlug($veri['slug'])->first();  


            $ziyaretci = Ziyaretci::where('token', $veri['token'])->first();

            $aktif_sepet_id = Sepet::aktif_sepet_id_mobil($veri['token']);

            if(!isset($aktif_sepet_id)){
                $aktif_sepet = Sepet::create([
                    'ziyaretci_id' => $ziyaretci->id,
                    'ulke_id' => $ulkeId
                ]);
                $aktif_sepet_id = $aktif_sepet->id;
            }

            if ($urun->cesit_durum == 1) {
                $fiyati = UrunFiyat::where('urun_id', $urun->id)->where('ulke_id', $ulkeId)->first();

                $sepetUrunKontrol = SepetUrun::where('sepet_id', $aktif_sepet_id)->where('urun_id', $urun->id)->first();
                
                if(isset($sepetUrunKontrol)){
                    $yeniAdet = $sepetUrunKontrol->adet + $veri['adet'];
                    if($yeniAdet > $urun->stok){
                        return response()->json(['response' => 0]);
                    }

                    $sepetUrunKontrol->update([
                        'adet' => $sepetUrunKontrol->adet + $veri['adet'],
                        'fiyati' => $fiyati->fiyat,
                        'promosyonMu' => 0
                    ]);
                }else{
                    if($veri['adet'] > 0){
                        $sepetUrunKontrol = SepetUrun::create([
                            'sepet_id' => $aktif_sepet_id,
                            'urun_id' => $urun->id,
                            'adet' => $veri['adet'],
                            'fiyati' => $fiyati->fiyat,
                            'promosyonMu' => 0
                        ]);
                    }
                }

            }else{
                $fiyati = CesitFiyat::where('cesit_detay_id', $veri['cesit_detay_id'])->where('ulke_id', $ulkeId)->first();
                $cesiti = CesitDetay::where('id', $veri['cesit_detay_id'])->first(); 

                $sepetUrunKontrol = SepetUrun::where('sepet_id', $aktif_sepet_id)->where('cesit_detay_id', $cesiti->id)->first();
                if(isset($sepetUrunKontrol)){
                    $yeniAdet = $sepetUrunKontrol->adet + $veri['adet'];
                    if($yeniAdet > $cesiti->stok){
                        return response()->json(['response' => 0]);
                    }
                    $sepetUrunKontrol->update([
                        'adet' => $sepetUrunKontrol->adet + $veri['adet'],
                        'fiyati' => $fiyati->fiyat,
                        'promosyonMu' => 0
                    ]);
                }else{
                    if($veri['adet'] > 0){
                        $sepetUrunKontrol = SepetUrun::create([
                            'sepet_id' => $aktif_sepet_id,
                            'urun_id' => $urun->id,
                            'cesit_detay_id' => $cesiti->id,
                            'adet' => $veri['adet'],
                            'fiyati' => $fiyati->fiyat,
                            'promosyonMu' => 0
                        ]);
                    }
                }
            }

            return response()->json(['response' => 1, 'adet' => $sepetUrunKontrol->adet]);
        }
    }



    public function kaldir(Request $request)
    {
        $data = $request->all();
        $giris = $data['giris'];
        $veri = $data['veri'];
        $ulkeId = $this->ulkeIdBul();

        if($giris['guvenlik_bir'] == 153 and $giris['guvenlik_iki'] == 7825810){

            $aktif_sepet_id = Sepet::aktif_sepet_id_mobil($veri['token']);

            
            $urun = Urun::whereSlug($veri['slug'])->first(); 
            if ($urun->cesit_durum == 1) {     
                SepetUrun::where('sepet_id', $aktif_sepet_id)->where('urun_id', $urun->id)->delete();

            }else{
                SepetUrun::where('sepet_id', $aktif_sepet_id)->where('cesit_detay_id', $veri['cesit_detay_id'])->delete();
            }

            return '{"response": 1}';
        }
    }


    public function listele(Request $request){
        $data = $request->all();
        $giris = $data['giris'];
        $veri = $data['veri'];
        $ulkeId = $this->ulkeIdBul();

        if($giris['guvenlik_bir'] == 153 and $giris['guvenlik_iki'] == 7825810){
            $ziyaretci = Ziyaretci::where('token', $veri['token'])->first();
            $aktif_sepet_id = Sepet::aktif_sepet_id_mobil($veri['token']);
            $urunler = SepetUrun::join('urun', 'sepet_urun.urun_id', '=', 'urun.id')
            ->join('urun_detay', 'urun.id', '=', 'urun_detay.urun_id')
            ->where('sepet_id', $aktif_sepet_id)
            ->where('sepet_urun.deleted_at', '=', null)
            ->where('urun_detay.dil_id', $ziyaretci->dil_id)
            ->select('urun.id', 'urun.cesit_durum', 'urun.slug', 'sepet_urun.fiyati', 'sepet_urun.cesit_detay_id', 'sepet_urun.adet', 'urun_detay.ad')
            ->get();
            

            $ulkeId = $this->ulkeIdBul();
            $ulke = Ulke::find($ulkeId)->first();
            $paraSimge = $ulke->para_birimi_getir['simge'];

            return response()->json(['urunler' => $urunler, 'paraSimge' => $paraSimge]);

        }
    }

    public function sepetAdet(Request $request){
        $data = $request->all();
        $giris = $data['giris'];
        $veri = $data['veri'];
        $ulkeId = $this->ulkeIdBul();

        if($giris['guvenlik_bir'] == 153 and $giris['guvenlik_iki'] == 7825810){
            $aktif_sepet_id = Sepet::aktif_sepet_id_mobil($veri['token']);
            $sepetUrun = SepetUrun::where('sepet_id', $aktif_sepet_id)->get();
            $sepetUrunAdet = 0;
            foreach($sepetUrun as $entry){
                $sepetUrunAdet += $entry->adet;
            }

            return response()->json(['sepetUrunAdet' => $sepetUrunAdet]);
        }
    }























    public function kargo(){

        $ulkeId = $this->ulkeIdBul(); 

        $mytime = Carbon\Carbon::now();
        $tarih = $mytime->toDateTimeString();

        $aktifKampanya = AktifKampanya::join('aktif_kampanya_detay', 'aktif_kampanya.id', 'aktif_kampanya_detay.aktif_kampanya_id')
        ->where('ulke_id', $ulkeId)
        ->where('aktif_kampanya_detay.deleted_at', null)
        ->where('aktif_kampanya.deleted_at', null)
        ->get();     
        foreach ($aktifKampanya as $kampanya) {
            if ($kampanya->grup == 0) {
                if ($kampanya->uygulanan_id != 0) {
                    $kargo = Kargo::where('baslangic_tarihi', '<=', $tarih)->where('bitis_tarihi', '>=', $tarih)->where('id', $kampanya->uygulanan_id)->first();
                    if (isset($kargo)) {
                        $kargo_indirim_fiyati = $kargo->indirim_oranı;
                        $kargo_kosul = $kargo->min;
                        $kampanya = array();
                        $kampanya['kargo_kosul'] = $kargo_kosul;
                        $kampanya['kargo_indirim_fiyati'] = $kargo_indirim_fiyati;
                        return $kampanya;
                    }
                }

            }
        }

    }

    public function sepetteIndirim(){

        $ulkeId = $this->ulkeIdBul(); 

        $mytime = Carbon\Carbon::now();
        $tarih = $mytime->toDateTimeString();
        $aktifKampanya = AktifKampanya::join('aktif_kampanya_detay', 'aktif_kampanya.id', 'aktif_kampanya_detay.aktif_kampanya_id')
        ->where('ulke_id', $ulkeId)
        ->where('aktif_kampanya_detay.deleted_at', null)
        ->where('aktif_kampanya.deleted_at', null)
        ->get();     
        foreach ($aktifKampanya as $kampanya) {
            if ($kampanya->grup == 1) {
                if ($kampanya->uygulanan_id != 0) {
                    $sepet = SepetIndirim::where('baslangic_tarihi', '<=', $tarih)->where('bitis_tarihi', '>=', $tarih)->where('id', $kampanya->uygulanan_id)->first();
                    if(isset($sepet)){ 
                        $sepet_indirim_fiyati = $sepet->indirim_oranı;
                        $sepet_kosul = $sepet->min;
                        $sepet_tur = $sepet->tur;

                        $kampanya = array();
                        $kampanya['sepet_tur'] = $sepet_tur;
                        $kampanya['sepet_kosul'] = $sepet_kosul;
                        $kampanya['sepet_indirim_fiyati'] = $sepet_indirim_fiyati;
                        return $kampanya;
                    }

                } 

            } 
        }

    }

    public function XalYodeIndirim(){
        $ulkeId = $this->ulkeIdBul(); 

        $mytime = Carbon\Carbon::now();
        $tarih = $mytime->toDateTimeString();
        $aktifKampanya = AktifKampanya::join('aktif_kampanya_detay', 'aktif_kampanya.id', 'aktif_kampanya_detay.aktif_kampanya_id')
        ->where('ulke_id', $ulkeId)
        ->where('aktif_kampanya_detay.deleted_at', null)
        ->where('aktif_kampanya.deleted_at', null)
        ->get();     
        foreach ($aktifKampanya as $kampanya) {
            if ($kampanya->grup == 2) {
                if ($kampanya->uygulanan_id != 0) {
                    $XalYode = XalYode::where('baslangic_tarihi', '<=', $tarih)
                    ->where('bitis_tarihi', '>=', $tarih)
                    ->where('id', $kampanya->uygulanan_id)
                    ->get();
                    foreach($XalYode as $entry){
                        if ($entry->grup == 3) {
                            $xy = XalYode::join('x_al_y_ode_detay', 'x_al_y_ode.id', '=', 'x_al_y_ode_detay.XalYode_id')
                            ->where('x_al_y_ode.id', $kampanya->uygulanan_id)
                            ->get();
                            foreach($xy as $x){
                                $etiketler[] = Etiket::where('id', $x->uygulanan_id)->first();
                            }
                            $xalyode_tur = $entry->tur;
                            $xalyode_grup = $entry->grup;
                            $xalyode_kosul = $entry->min;
                            $xalyode_adet_yuzde = $entry->adet_yuzde; 
                            $kampanya = array(); 
                            $kampanya['etiketler'] = $etiketler;
                            $kampanya['xalyode_tur'] = $xalyode_tur;
                            $kampanya['xalyode_grup'] = $xalyode_grup;
                            $kampanya['xalyode_kosul'] = $xalyode_kosul;
                            $kampanya['xalyode_adet_yuzde'] = $xalyode_adet_yuzde;
                            return $kampanya;

                        }
                        if($entry->grup == 4){
                           $xalyode_tur = $entry->tur;
                           $xalyode_grup = $entry->grup;
                           $xalyode_kosul = $entry->min;
                           $xalyode_adet_yuzde = $entry->adet_yuzde;

                           $kampanya = array();
                           $kampanya['xalyode_tur'] = $xalyode_tur;
                           $kampanya['xalyode_grup'] = $xalyode_grup;
                           $kampanya['xalyode_kosul'] = $xalyode_kosul;
                           $kampanya['xalyode_adet_yuzde'] = $xalyode_adet_yuzde;
                           return $kampanya;
                       }
                   } 
               } 
           } 
       } 
   }


   public function promosyon(){
    $ulkeId = $this->ulkeIdBul(); 

    $mytime = Carbon\Carbon::now();
    $tarih = $mytime->toDateTimeString();
    $aktifKampanya = AktifKampanya::join('aktif_kampanya_detay', 'aktif_kampanya.id', 'aktif_kampanya_detay.aktif_kampanya_id')
    ->where('ulke_id', $ulkeId)
    ->where('aktif_kampanya_detay.deleted_at', null)
    ->where('aktif_kampanya.deleted_at', null)
    ->get();     
    foreach ($aktifKampanya as $kampanya) {
        if ($kampanya->grup == 3) {
            if ($kampanya->uygulanan_id != 0) {
                $promosyon = Promosyon::where('baslangic_tarihi', '<=', $tarih)
                ->where('bitis_tarihi', '>=', $tarih)
                ->where('id', $kampanya->uygulanan_id)
                ->get();
                foreach($promosyon as $entry){
                    if ($entry->grup == 4) {
                        $proDetay = Promosyon::join('promosyon_urun', 'promosyon.id', '=', 'promosyon_urun.promosyon_id')
                        ->where('promosyon.id', $kampanya->uygulanan_id)
                        ->get();
                        foreach($proDetay as $pro){
                            $promosyon_urun = Urun::where('id', $pro->urun_id)->first();
                            $pro_tur = $entry->tur;
                            $pro_grup = $entry->grup;
                            $pro_kosul = $entry->min;
                            $pro_urun = $promosyon_urun->id;

                            $kampanya = array();
                            $kampanya['pro_grup'] = $pro_grup;
                            $kampanya['pro_kosul'] = $pro_kosul;
                            $kampanya['pro_urun'] = $pro_urun;
                            return $kampanya;
                        }
                    }
                    if ($entry->grup == 5) {
                        $proDetay = Promosyon::join('promosyon_detay', 'promosyon.id', '=', 'promosyon_detay.promosyon_id')
                        ->join('promosyon_urun', 'promosyon.id', '=', 'promosyon_urun.promosyon_id')
                        ->where('promosyon.id', $kampanya->uygulanan_id)
                        ->where('promosyon.deleted_at', null)
                        ->where('promosyon_detay.deleted_at', null)
                        ->where('promosyon_urun.deleted_at', null)
                        ->select('promosyon.*', 'promosyon_detay.uygulanan_id', 'promosyon_urun.urun_id')
                        ->get();
                        foreach($proDetay as $pro){ 
                            $promosyon_urun_kosul_id[] = $pro->uygulanan_id;
                            $promosyon_urun_id[] = $pro->urun_id;


                            $pro_tur = $entry->tur;
                            $pro_grup = $entry->grup;
                            $pro_kosul = $entry->min;
                            $pro_urun = $promosyon_urun_id;
                            $pro_urun_kosul = $promosyon_urun_kosul_id;

                            $kampanya = array();
                            $kampanya['pro_grup'] = $pro_grup;
                            $kampanya['pro_kosul'] = $pro_kosul;
                            $kampanya['pro_urun'] = $pro_urun;
                            $kampanya['pro_urun_kosul'] = $pro_urun_kosul;

                            return $kampanya;
                        }
                    }
                }
            }
        }
    }
}



public function index(Request $request)
{
    $data = $request->all();
    $giris = $data['giris'];
    $veri = $data['veri'];

    if($giris['guvenlik_bir']==153 and $giris['guvenlik_iki']==7825810){
        $aktif_sepet_id = Sepet::aktif_sepet_id_mobil($veri['token']);
        $ySepetUrunler = SepetUrun::where('sepet_id', $aktif_sepet_id)->get();
        
        

        $total = 0.00;
        $sepetUrunAdet = 0;
        foreach($ySepetUrunler as $entry){
            $total += ($entry->fiyati * $entry->adet);
            $sepetUrunAdet += $entry->adet;
        }



        $kargoIndirim = $this->kargo();
        $sepetteIndirim = $this->sepetteIndirim();
        $XalYodeIndirim = $this->XalYodeIndirim();
        $promosyon = $this->promosyon();
        $ulkeId = $this->ulkeIdBul(); 
        $total = str_replace( array( ',' ), '', $total);
        $kargo = KargoFiyat::where('ulke_id', $ulkeId)->first();
        $totalFiyat = $total;
        $indirimXalYode = null;
        $SepetindirimTutari = null;
        $indirimTutari = null;
        $kargoFiyat = null;
        $totalFiyat = number_format($totalFiyat, 2);

        $ziyaretci = Ziyaretci::where('token', $veri['token'])->first();

        if(!isset($aktif_sepet_id)){
            $aktif_sepet = Sepet::create([
                'ziyaretci_id' => $ziyaretci->id,
                'ulke_id' => $ulkeId
            ]);

            $aktif_sepet_id = $aktif_sepet->id;
        }


        if (isset($promosyon)){
           $adet = $sepetUrunAdet;
           $cart = $ySepetUrunler;
           if ($promosyon['pro_grup'] == 4) {
            foreach($cart as $urunCartItem){
                $urun = Urun::find($promosyon['pro_urun']);
                $sepet_pro = SepetUrun::where('sepet_id', $aktif_sepet_id)->where('urun_id', $urun->id)->first();
                if ($total >= $promosyon['pro_kosul']) {
                    if (isset($sepet_pro)) {
                        if ($sepet_pro->promosyonMu == null) {
                            if ($urun->cesit_durum == 1) {
                                SepetUrun::where('sepet_id', $aktif_sepet_id)->where('promosyonMu', 1)->updateOrCreate(
                                    ['sepet_id' => $aktif_sepet_id, 'urun_id' => $urun->id],
                                    ['adet' => 1, 'fiyati' => 0, 'promosyonMu' => 1]
                                );
                            }else{
                                foreach ($urun->cesit_bul->cesit_detay_bul as  $cesiti) {

                                    SepetUrun::where('sepet_id', $aktif_sepet_id)->where('promosyonMu', 1)->updateOrCreate(
                                        ['sepet_id' => $aktif_sepet_id,  'cesit_detay_id' => $cesiti->id,],
                                        ['adet' => 1, 'fiyati' => 0, 'urun_id' => $urun->id, 'promosyonMu' => 1]);
                                }
                            }
                        }else{
                            if ($total <= $promosyon['pro_kosul']) {
                                SepetUrun::destroy($sepet_pro->id);
                            }
                        }
                    }else{
                        if ($urun->cesit_durum == 1) {
                            SepetUrun::where('sepet_id', $aktif_sepet_id)->where('promosyonMu', 1)->updateOrCreate(
                                ['sepet_id' => $aktif_sepet_id, 'urun_id' => $urun->id],
                                ['adet' => 1, 'fiyati' => 0, 'promosyonMu' => 1]
                            );
                        }else{
                            foreach ($urun->cesit_bul->cesit_detay_bul as  $cesiti) {

                                SepetUrun::where('sepet_id', $aktif_sepet_id)->where('promosyonMu', 1)->updateOrCreate(
                                    ['sepet_id' => $aktif_sepet_id,  'cesit_detay_id' => $cesiti->id,],
                                    ['adet' => 1, 'fiyati' => 0, 'urun_id' => $urun->id, 'promosyonMu' => 1]);
                            }
                        }

                    }
                }else{
                    if (isset($sepet_pro)) {
                        if ($sepet_pro->urun_id == $urunCartItem->id) {
                            SepetUrun::destroy($sepet_pro->id);
                        }
                    }
                }
            }
        }
        if ($promosyon['pro_grup'] == 5) {
           foreach($cart as $urunCartItem){
            foreach($promosyon['pro_urun_kosul'] as $urun_kosul) {
                $urun = Urun::find($urun_kosul);

                $sepet_pro = SepetUrun::where('sepet_id', $aktif_sepet_id)->where('urun_id', $urun->id)->where('promosyonMu', null)->first();
                if ($total >= $promosyon['pro_kosul']) {
                    if (isset($sepet_pro)) {
                        foreach($promosyon['pro_urun'] as $urun_promosyon){
                            $promosyon_urun = Urun::find($urun_promosyon);

                            $promosyon_sepet_pro = SepetUrun::where('sepet_id', $aktif_sepet_id)->where('urun_id', $promosyon_urun->id)->where('promosyonMu', 1)->first();
                            if (!isset($promosyon_sepet_pro)) {
                                if ($promosyon_urun->cesit_durum == 1) {
                                    SepetUrun::where('sepet_id', $aktif_sepet_id)->where('promosyonMu', 1)->updateOrCreate(
                                        ['sepet_id' => $aktif_sepet_id, 'urun_id' => $promosyon_urun->id],
                                        ['adet' => 1, 'fiyati' => 0, 'promosyonMu' => 1]
                                    );
                                }else{
                                    foreach ($promosyon_urun->cesit_bul->cesit_detay_bul as  $cesiti) {
                                        SepetUrun::where('sepet_id', $aktif_sepet_id)->where('promosyonMu', 1)->updateOrCreate(
                                            ['sepet_id' => $aktif_sepet_id,  'cesit_detay_id' => $cesiti->id,],
                                            ['adet' => 1, 'fiyati' => 0, 'urun_id' => $promosyon_urun->id, 'promosyonMu' => 1]
                                        );
                                    }
                                }

                            }else{
                                if ($total <= $promosyon['pro_kosul']) {
                                    SepetUrun::destroy( $promosyon_urun->id);
                                }
                            }
                        }
                    }
                }else{
                   foreach($promosyon['pro_urun'] as $urun_promosyon){
                    $promosyon_urun = Urun::find($urun_promosyon);
                    $promosyon_sepet_pro = SepetUrun::where('sepet_id', $aktif_sepet_id)->where('urun_id', $promosyon_urun->id)->where('promosyonMu', 1)->first();
                    if (isset($promosyon_sepet_pro)) {
                        if ($promosyon_sepet_pro->urun_id == $urunCartItem->id) {
                            SepetUrun::destroy($promosyon_sepet_pro->id);
                        }
                    } 
                }

            }
        }
    }
}


}



if (isset($XalYodeIndirim)) {

    $ySepetUrunler = SepetUrun::where('sepet_id', $aktif_sepet_id)->get();

    $sepetUrunAdet = 0;
    foreach($ySepetUrunler as $entry){
        $sepetUrunAdet += $entry->adet;
    }

    $adet = $sepetUrunAdet;
    $cart = $ySepetUrunler;
    $toplamAdet = $XalYodeIndirim['xalyode_kosul'] + $XalYodeIndirim['xalyode_adet_yuzde'];
    if ($XalYodeIndirim['xalyode_grup'] == 3){
        if ($XalYodeIndirim['xalyode_tur'] == 1) {
            foreach($cart as $urunCartItem){
                if ($urunCartItem->adet >= $toplamAdet) {
                    $urun = Urun::find($urunCartItem->id);
                    $etiket = UrunEtiket::where('urun_etiket.urun_id', $urun->id)
                    ->join('etiket', 'urun_etiket.etiket_id', '=', 'etiket.id')
                    ->where('urun_etiket.deleted_at', null)
                    ->where('etiket.deleted_at', null)
                    ->where('etiket.durum', 1)
                    ->get();
                    if ($etiket) {
                        $dusucekFiyat = $XalYodeIndirim['xalyode_adet_yuzde'] * $urun->fiyat_bul['fiyat'];
                        $total =  $total - $dusucekFiyat; 
                        $totalFiyat = $total;
                        $indirimXalYode +=  $dusucekFiyat;
                    }
                }
            }
        }else{
            foreach($cart as $urunCartItem){
                if ($urunCartItem->adet >= $XalYodeIndirim['xalyode_kosul'] ) {
                    $urun = Urun::find($urunCartItem->id);
                    $etiket = UrunEtiket::where('urun_etiket.urun_id', $urun->id)
                    ->join('etiket', 'urun_etiket.etiket_id', '=', 'etiket.id')
                    ->where('urun_etiket.deleted_at', null)
                    ->where('etiket.deleted_at', null)
                    ->where('etiket.durum', 1)
                    ->get();
                    if ($etiket) {
                        $dusucekFiyat = ($urunCartItem->subtotal * $XalYodeIndirim['xalyode_adet_yuzde']) / 100;
                        $total =  $total - $dusucekFiyat; 
                        $totalFiyat = $total;
                        $indirimXalYode +=  $dusucekFiyat;
                    }
                }
            }
        }

    }
    if ($XalYodeIndirim['xalyode_grup'] == 4) {
        if ($XalYodeIndirim['xalyode_tur'] == 1) {
            foreach($cart as $urunCartItem){
                if ($urunCartItem->adet >= $toplamAdet) {
                    $urun = Urun::find($urunCartItem->id);
                    if ($urun->cesit_durum == 1 ){

                        $dusucekFiyat = $XalYodeIndirim['xalyode_adet_yuzde'] * $urun->fiyat_bul['fiyat'];
                        $total =  $total - $dusucekFiyat; 
                        $totalFiyat = $total;

                        $indirimXalYode +=  $dusucekFiyat;

                    }else{
                        foreach($urun->cesitler_bul as $cesit){
                            foreach($cesit->cesit_detay_bul as $detay){
                                $dusucekFiyat = $XalYodeIndirim['xalyode_adet_yuzde'] * $detay->cesit_detay_fiyat_bul['fiyat'];
                                $total =  $total - $dusucekFiyat; 
                                $totalFiyat = $total;
                                $indirimXalYode +=  $dusucekFiyat;
                            }

                        }

                    }
                } 
            } 
        }else{

           foreach($cart as $urunCartItem){

            if ($urunCartItem->adet >= $XalYodeIndirim['xalyode_kosul']) {
                $urun = Urun::find($urunCartItem->id);
                if ($urun->cesit_durum == 1 ){

                   $dusucekFiyat = (($urunCartItem->adet * $urunCartItem->fiyati) * $XalYodeIndirim['xalyode_adet_yuzde']) / 100;
                   $total =  $total - $dusucekFiyat; 
                   $totalFiyat = $total;
                   $indirimXalYode +=  $dusucekFiyat;

               }else{
                foreach($urun->cesitler_bul as $cesit){
                    foreach($cesit->cesit_detay_bul as $detay){
                     $dusucekFiyat = (($urunCartItem->adet * $urunCartItem->fiyati) * $XalYodeIndirim['xalyode_adet_yuzde']) / 100;
                     $total =  $total - $dusucekFiyat; 
                     $totalFiyat = $total;
                     $indirimXalYode +=  $dusucekFiyat;
                 }


             }

         }
     } 

 } 

}
}
} 


$indirim = SepetUygulananIndirim::where('sepet_id', $aktif_sepet_id)->where('indirim_turu', 4)->first(); 

if (isset($sepetteIndirim)){
    if($totalFiyat > $sepetteIndirim['sepet_kosul']){
       if(isset($indirim)){
        if ($sepetteIndirim['sepet_tur'] == 0){
            $toplam =  $totalFiyat - ($totalFiyat * $sepetteIndirim['sepet_indirim_fiyati'])/100;
            $SepetindirimTutari = ($totalFiyat * $sepetteIndirim['sepet_indirim_fiyati'])/100;
            if ($toplam > $indirim->kupon_kod_getir->kupon_getir['min'] ) {
                $toplam =  $toplam - $indirim->kupon_kod_getir->kupon_getir['indirim_tutarı'];  
                $indirimTutari += $indirim->kupon_kod_getir->kupon_getir['indirim_tutarı']  ;
            }else{
                $toplam =  $toplam;
            }
        }else{
            $toplam =  $totalFiyat - $sepetteIndirim['sepet_indirim_fiyati'];
            $SepetindirimTutari = $sepetteIndirim['sepet_indirim_fiyati'];
            if ($toplam > $indirim->kupon_kod_getir->kupon_getir['min'] ) {
                $toplam =  $toplam - $indirim->kupon_kod_getir->kupon_getir['indirim_tutarı'];  
                $indirimTutari += $indirim->kupon_kod_getir->kupon_getir['indirim_tutarı']  ;
            }else{
                $toplam =  $toplam;
            }
        }
    }else{
        if ($sepetteIndirim['sepet_tur'] == 0) {
            $toplam =  $totalFiyat - ($totalFiyat * $sepetteIndirim['sepet_indirim_fiyati'])/100;
            $SepetindirimTutari = ($totalFiyat * $sepetteIndirim['sepet_indirim_fiyati'])/100;
        }else{
            $toplam =  $totalFiyat - $sepetteIndirim['sepet_indirim_fiyati'];
            $SepetindirimTutari = $sepetteIndirim['sepet_indirim_fiyati'];
        }
    }
}else{
    $toplam =  $totalFiyat;
    $SepetindirimTutari = null;
}
}else{
    if(isset($indirim)){ 
        $toplam =  $totalFiyat - $indirim->kupon_kod_getir->kupon_getir['indirim_tutarı'];  
        $indirimTutari = $indirim->kupon_kod_getir->kupon_getir['indirim_tutarı']  ;
    } else{
        $toplam =  $totalFiyat;
        $indirimTutari = null;
    }
}
if (!isset($sepetteIndirim['sepet_kosul'])) {
    $sepetteIndirim['sepet_kosul'] = null;
}
if($totalFiyat < $sepetteIndirim['sepet_kosul']){
    if(isset($indirim)){ 
        $toplam =  $totalFiyat - $indirim->kupon_kod_getir->kupon_getir['indirim_tutarı'];  
        $indirimTutari = $indirim->kupon_kod_getir->kupon_getir['indirim_tutarı'];
    } 
} 

$toplam = str_replace( array( ',' ), '', $toplam);

if ($toplam > $kargo->limit) {
   $kargoFiyat = $kargo->limit_üst_fiyat;
   $toplam += $kargoFiyat;
}else{
    if (isset($kargoIndirim)) {
        if ($toplam > $kargoIndirim['kargo_kosul'] ) {
            $kargoFiyat = $kargo->limit_alt_fiyat - ($kargo->limit_alt_fiyat * $kargoIndirim['kargo_indirim_fiyati'])/100;
            $toplam += $kargoFiyat;
        }else{
            $kargoFiyat = $kargo->limit_alt_fiyat;
            $toplam += $kargoFiyat;
        }
    }else{
        $kargoFiyat = $kargo->limit_alt_fiyat;
        $toplam += $kargoFiyat;

    }
} 

$totalFiyat = str_replace( array( ',' ), '', $totalFiyat);
$sepetOdeme = SepetOdeme::where('sepet_id', $aktif_sepet_id)->first();
if (isset($sepetOdeme)) {
    SepetOdeme::destroy($sepetOdeme->id);
    SepetOdeme::Create([
        'sepet_id' => $aktif_sepet_id,
        'indirimTutari' =>$indirimTutari,
        'SepetindirimTutari' =>$SepetindirimTutari,
        'indirimXalYode' =>$indirimXalYode,
        'toplam' =>$toplam,
        'kargoFiyat' => $kargoFiyat
    ]);
}else{
    SepetOdeme::Create([
        'sepet_id' => $aktif_sepet_id,
        'indirimTutari' =>$indirimTutari,
        'SepetindirimTutari' =>$SepetindirimTutari,
        'indirimXalYode' =>$indirimXalYode,
        'toplam' =>$toplam,
        'kargoFiyat' => $kargoFiyat
    ]);
}

$ulkeId = $this->ulkeIdBul();
$ulke = Ulke::find($ulkeId)->first();
$paraSimge = $ulke->para_birimi_getir['simge'];
                
$indirimler = ['indirimTutari' => $indirimTutari, 'SepetindirimTutari' => $SepetindirimTutari, 'indirimXalYode' => $indirimXalYode];

$toplam = (string)$toplam;

return response()->json(['totalFiyat' => $totalFiyat, 'indirim' => $indirim, 'kargoFiyat' => $kargoFiyat, 'toplam' => $toplam, 'indirimler' => $indirimler, 'paraSimge' => $paraSimge]);
}
}
}
