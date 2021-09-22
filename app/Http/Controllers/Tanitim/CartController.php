<?php

namespace App\Http\Controllers\Tanitim;

use App\Http\Controllers\Controller;
use App\GenelFonksiyonlar;
use App\Http\Controllers\FonksiyonlarController;
use Cart;
use Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use App\Models\{Sepet, SepetUrun, Urun, UrunFiyat, Ziyaretci, Dil, Ulke, UlkeKod, CesitDetay, CesitFiyat, SepetUygulananIndirim, KargoFiyat, AktifKampanya, AktifKampanyaDetay, SepetIndirim, Kargo, XalYode, XalYodeDetay, Kategori, Etiket, Marka, UrunEtiket ,Promosyon, PromosyonDetay, SepetOdeme};
class CartController extends Controller
{
   public function ulkeIdBul(){

     $ipUlke = GenelFonksiyonlar::getIp();
     $ip = $ipUlke['ip'];
     $ulkeKod = $ipUlke['ulkeKod'];

     $ulkeKod = UlkeKod::where('kod', $ulkeKod)->first();
     $ulke = Ulke::where('ulke_kod_id', $ulkeKod->id)->first();
     if(isset($ulke->id)){
        return $ulke->id;
    }else{
        return 0;
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




public function index(){

 $kargoIndirim = $this->kargo();
 $sepetteIndirim = $this->sepetteIndirim();
 $XalYodeIndirim = $this->XalYodeIndirim();
 $promosyon = $this->promosyon();
 $ulkeId = $this->ulkeIdBul(); 
 $urunler = Urun::orderByDesc('created_at')->get();
 $total = null;  
 $kargo = KargoFiyat::where('ulke_id', $ulkeId)->first();
 $totalFiyat = $total;
 $indirimXalYode = null;
 $SepetindirimTutari = null;
 $indirimTutari = null;
 $kargoFiyat = null;
 $totalFiyat = number_format($totalFiyat, 2);
 $subtotal = null;

 $ziyaretciId = Cookie::get('ziyaretci_id'); 

 $ziyaretci = Ziyaretci::find($ziyaretciId);

 $aktif_sepet_id = Sepet::aktif_sepet_id(); 

 if(!isset($aktif_sepet_id)){
    $aktif_sepet = Sepet::create([
        'ziyaretci_id' => $ziyaretciId,
        'ulke_id' => $ulkeId
    ]);
    $aktif_sepet_id = $aktif_sepet->id; 
}


if (isset($promosyon)){
    $sepetUrun = SepetUrun::where('sepet_id', $aktif_sepet_id)->get();
    $adet = $sepetUrun->count();
    if ($promosyon['pro_grup'] == 4) {
        foreach($sepetUrun as $urunCartItem){
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
                    if ($sepet_pro->urun_id == $urunCartItem->urun_id) {
                        SepetUrun::destroy($sepet_pro->id); 
                    }
                }
            }
        }
    }
    if ($promosyon['pro_grup'] == 5) {
     foreach($sepetUrun as $urunCartItem){
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
                    if ($promosyon_sepet_pro->urun_id == $urunCartItem->urun_id) {
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
    $sepetUrun = SepetUrun::where('sepet_id', $aktif_sepet_id)->get();
    $adet = $sepetUrun->count();
    $toplamAdet = $XalYodeIndirim['xalyode_kosul'] + $XalYodeIndirim['xalyode_adet_yuzde'];
    if ($XalYodeIndirim['xalyode_grup'] == 3){
        if ($XalYodeIndirim['xalyode_tur'] == 1) {
            foreach($sepetUrun as $urunCartItem){
                if ($urunCartItem->adet >= $toplamAdet) {
                    $urun = Urun::find($urunCartItem->urun_id);
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
            foreach($sepetUrun as $urunCartItem){
                if ($urunCartItem->adet >= $XalYodeIndirim['xalyode_kosul'] ) {
                    $urun = Urun::find($urunCartItem->urun_id);
                    $etiket = UrunEtiket::where('urun_etiket.urun_id', $urun->id)
                    ->join('etiket', 'urun_etiket.etiket_id', '=', 'etiket.id')
                    ->where('urun_etiket.deleted_at', null)
                    ->where('etiket.deleted_at', null)
                    ->where('etiket.durum', 1)
                    ->get();
                    if ($etiket) { 
                        $subtotal = $urunCartItem->fiyat * $urunCartItem->adet;
                        $dusucekFiyat = ($subtotal * $XalYodeIndirim['xalyode_adet_yuzde']) / 100;
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
            foreach($sepetUrun as $urunCartItem){
                if ($urunCartItem->adet >= $toplamAdet) {
                    $urun = Urun::find($urunCartItem->urun_id);
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

         foreach($sepetUrun as $urunCartItem){

            if ($urunCartItem->adet >= $XalYodeIndirim['xalyode_kosul']) {
                $urun = Urun::find($urunCartItem->urun_id);
                if ($urun->cesit_durum == 1 ){
                    $subtotal = $urunCartItem->fiyat * $urunCartItem->adet;
                    $dusucekFiyat = ($subtotal * $XalYodeIndirim['xalyode_adet_yuzde']) / 100;
                    $total =  $total - $dusucekFiyat; 
                    $totalFiyat = $total;
                    $indirimXalYode +=  $dusucekFiyat;

                }else{
                    foreach($urun->cesitler_bul as $cesit){
                        foreach($cesit->cesit_detay_bul as $detay){
                            $subtotal = $urunCartItem->fiyat * $urunCartItem->adet;
                            $dusucekFiyat = ($subtotal * $XalYodeIndirim['xalyode_adet_yuzde']) / 100;
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

$urunAdetToplam = 0;
$urunToplam = 0;
$toplamFiyat = 0;
$sepetNav = Sepet::where('ziyaretci_id', $ziyaretciId)->orderBy('created_at','desc')->first();

$sepetNavUrun = SepetUrun::where('sepet_id', $sepetNav->id)->get();

foreach($sepetNavUrun as $sepetUrun){
    $urunToplam = $sepetUrun->fiyati * $sepetUrun->adet;
    $urunAdetToplam += $sepetUrun->adet;
    $toplamFiyat += $urunToplam;

    $toplamFiyat = number_format($toplamFiyat, 2);
}

$toplamFiyat = str_replace( array( ',' ), '', $toplamFiyat);

$totalFiyat = str_replace( array( ',' ), '', $totalFiyat);

if ($toplamFiyat > $kargo->limit) {
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

$toplam = $toplam + $toplamFiyat;

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
$indirimler = ['indirimTutari' => $indirimTutari, 'SepetindirimTutari' => $SepetindirimTutari, 'indirimXalYode' => $indirimXalYode]; 

return view('tanitim.cart', compact('sepetNavUrun','toplamFiyat', 'urunler', 'totalFiyat', 'indirim', 'kargo', 'kargoFiyat', 'toplam','indirimler'));
}
public function add($id){
    $data = request()->all();

    $ulkeId = $this->ulkeIdBul();
    
    if(!isset($data['adet'])){
        $data['adet'] = 1;
    }
    if ($data['adet'] > 21474) {
        return back()
        ->with('mesaj', 'Başarısız.Sepete bu kadar ürün eklenemez.')
        ->with('mesaj_tur', 'danger');
    }


    $urun = Urun::find($id);  

    $ziyaretciId = Cookie::get('ziyaretci_id'); 
    
    $aktif_sepet_id = Sepet::aktif_sepet_id();
    if(!isset($aktif_sepet_id)){
        $aktif_sepet = Sepet::create([
            'ziyaretci_id' => $ziyaretciId,
            'ulke_id' => $ulkeId
        ]);
        $aktif_sepet_id = $aktif_sepet->id; 
    }

    if ($urun->cesit_durum == 1) {
        $fiyati = UrunFiyat::where('urun_id', $urun->id)->where('ulke_id', $ulkeId)->first();
        $sepetUrunAdet = SepetUrun::where('sepet_id', $aktif_sepet_id)->where('urun_id', $id)->first();

        if (isset($sepetUrunAdet)) {
            $data['adet'] += $sepetUrunAdet['adet'];
        } 
        if ($data['adet'] >  $urun->stok) {
            return back()
            ->with('mesaj', 'Başarısız.Sepete bu kadar ürün eklenemez.')
            ->with('mesaj_tur', 'danger');
        }
        SepetUrun::updateOrCreate(
            ['sepet_id' => $aktif_sepet_id, 'urun_id' => $urun->id],
            ['adet' => $data['adet'], 'fiyati' => $fiyati->fiyat, 'promosyonMu' => 0]
        );
    }else{
        $fiyati = CesitFiyat::where('cesit_detay_id', $data['cesit_detay_id'])->where('ulke_id', $ulkeId)->first();
        $cesiti = CesitDetay::where('id', $data['cesit_detay_id'])->first(); 
        $sepetUrunAdet = SepetUrun::where('sepet_id', $aktif_sepet_id)->where('urun_id', $id)->first();

        if (isset($sepetUrunAdet)) {
            $data['adet'] += $sepetUrunAdet['adet'];
        } 
        if ($data['adet'] >  $cesiti->stok) {
            return back()
            ->with('mesaj', 'Başarısız.Sepete bu kadar ürün eklenemez.')
            ->with('mesaj_tur', 'danger');
        }
        SepetUrun::updateOrCreate(
            ['sepet_id' => $aktif_sepet_id,  'cesit_detay_id' => $cesiti->id,],
            ['adet' => $data['adet'], 'fiyati' => $fiyati->fiyat, 'urun_id' => $urun->id, 'promosyonMu' => 0]
        );
    }
    return back();
}

public function cartApi($id){
    $urun = Urun::find($id); 
    return response()->json([
        'urun' => $urun,
        'urun_gorsel' => $urun->gorsel_bul['gorsel'],
        'urun_ad' => $urun->detay_bul['ad'],
        'urun_adet' => 1,
        'urun_fiyat' => $urun->fiyat_bul['fiyat']
    ]);
}

public function cartApiKaldir($id){
    $aktif_sepet_id = Sepet::aktif_sepet_id();
    $cartItem = SepetUrun::where('sepet_id',$aktif_sepet_id)->where('urun_id',$id)->first();
    $urun = Urun::find($cartItem->urun_id); 

    if ($urun->cesit_durum == 1) {    
        SepetUrun::where('sepet_id', $aktif_sepet_id)->where('urun_id', $cartItem->urun_id)->delete();

    }else{
        SepetUrun::where('sepet_id', $aktif_sepet_id)->where('cesit_detay_id', $cartItem->cesit_detay_id)->delete();
    }

    SepetUrun::destroy($cartItem->id);

    return back()
    ->with('mesaj_tur', 'Başarılı')
    ->with('mesaj', 'Ürün sepetten kaldırıldı.');
}

public function cartApiGuncelle($rowid, $deger){ 

    $aktif_sepet_id = Sepet::aktif_sepet_id();
    $cartItem = SepetUrun::find($rowid);
    if ($cartItem->adet >= 0) { 
        $urun = Urun::find($cartItem->urun_id);  
        $indirim = SepetUygulananIndirim::where('sepet_id', $aktif_sepet_id)->where('indirim_turu', 4)->first();
        if ($deger == "+") {
            $adet = $cartItem->adet + 1;
        } else{

            $adet = $cartItem->adet - 1;
        } 
        if ($adet > 0) {
            if ($urun->cesit_durum == 1) {  
                if ($adet > $urun['stok']) {
                    return back()
                    ->with('mesaj', 'Başarısız. Sepete bu kadar ürün eklenemez.')
                    ->with('mesaj_tur', 'danger');
                }  
                SepetUrun::where('sepet_id', $aktif_sepet_id)->where('urun_id', $cartItem->urun_id)->update(['adet' => $adet]);

            }else{

                $cesit = CesitDetay::where('id', $cartItem->cesit_detay_id)->first();
                if ($adet > $cesit['stok']) {

                    return back()
                    ->with('mesaj', 'Başarısız. Sepete bu kadar ürün eklenemez.')
                    ->with('mesaj_tur', 'danger');
                }
                SepetUrun::where('sepet_id', $aktif_sepet_id)->where('cesit_detay_id', $cartItem->cesit_detay_id)->update(['adet' => $adet]); 

            }

            $total = SepetUrun::where('id',$rowid)->update([ 'adet' => $adet]);
        }

        if (isset($indirim)) {
            if ($total->subtotal < $indirim->kupon_kod_getir->kupon_getir['min']) {
                SepetUygulananIndirim::destroy($indirim->id);
            }else{
                return back();
            }

        }
    }
    return back();
}
public function kaldir($rowid){
    $aktif_sepet_id = Sepet::aktif_sepet_id();
    $cartItem = SepetUrun::find($rowid);
    $urun = Urun::find($cartItem->urun_id); 

    if ($urun->cesit_durum == 1) {    
        SepetUrun::where('sepet_id', $aktif_sepet_id)->where('urun_id', $cartItem->urun_id)->delete();

    }else{
        SepetUrun::where('sepet_id', $aktif_sepet_id)->where('cesit_detay_id', $cartItem->cesit_detay_id)->delete();
    }

    SepetUrun::destroy($rowid);

    return back()
    ->with('mesaj_tur', 'Başarılı')
    ->with('mesaj', 'Ürün sepetten kaldırıldı.');
}

public function guncelle($rowid){

    $data = request()->all();  
    $aktif_sepet_id = Sepet::aktif_sepet_id();
    $cartItem = SepetUrun::find($rowid);
    $urun = Urun::find($cartItem->urun_id);  
    $indirim = SepetUygulananIndirim::where('sepet_id', $aktif_sepet_id)->where('indirim_turu', 4)->first(); 
    $adet =  $data['adet'];
    
    if ($urun->cesit_durum == 1) {    
        if ($adet > $urun['stok']) {
            return back()
            ->with('mesaj', 'Başarısız. Sepete bu kadar ürün eklenemez.')
            ->with('mesaj_tur', 'danger');
        }
        SepetUrun::where('sepet_id', $aktif_sepet_id)->where('urun_id', $cartItem->urun_id)->update(['adet' => $adet]);

    }else{
        $cesit = CesitDetay::where('id', $cartItem->cesit_detay_id)->first();
        if ($adet > $cesit['stok']) {

            return back()
            ->with('mesaj', 'Başarısız. Sepete bu kadar ürün eklenemez.')
            ->with('mesaj_tur', 'danger');
        }
        SepetUrun::where('sepet_id', $aktif_sepet_id)->where('cesit_detay_id', $cartItem->cesit_detay_id)->update(['adet' => $adet]); 

    }
    $total = SepetUrun::where('id',$rowid)->update([ 'adet' => $adet]);

    if (isset($indirim)) {
        if ($total->subtotal < $indirim->kupon_kod_getir->kupon_getir['min']) {
            SepetUygulananIndirim::destroy($indirim->id);
        }else{
            return back();
        }

    }
    return back();
}
}
