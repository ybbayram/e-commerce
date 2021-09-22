<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\{Yorum, UrunAnaliz};

class YorumController extends AdminController
{
    public function index(){
        $yorum = Yorum::orderBy('created_at', 'DESC')->get();
        return view('admin.yorum.index', compact('yorum'));
    }

    public function onayla($yorum){
      Yorum::find($yorum)->update(['durum' => 1]);
      $yorumBul = Yorum::find($yorum); 
      $analiz = UrunAnaliz::where('urun_id', $yorumBul->urun_id)->first();
      $oysayi = $analiz->oy_sayi + 1;
      $toplam_puan = $analiz->toplam_puan + $yorumBul->oy;

      $ortalama = $toplam_puan / $oysayi;
      
      UrunAnaliz::where('urun_id', $yorumBul->urun_id)->update([
        'toplam_puan'=>$toplam_puan,  
        'oy_sayi' => $oysayi,
        'ortalama_puan' => $ortalama
    ]);
      return back()
      ->with('mesaj', 'Yorum onaylandı')
      ->with('mesaj_tur', 'success');
  }

  public function kapat($yorum){
     $urun = Yorum::where('id', $yorum)->first();
     $urun_id = $urun->urun_id;
     $analiz = UrunAnaliz::where('urun_id', $urun_id)->first();
     $toplam_puan = $analiz->toplam_puan - $urun->oy;
     $oy_sayi = $analiz->oy_sayi - 1;
     $ortalama = 0;

     if ($oy_sayi > 0) {
        $ortalama = $analiz->toplam_puan / $oy_sayi;
    }

    UrunAnaliz::where('urun_id', $urun_id)->update(['toplam_puan'=>$toplam_puan, 'oy_sayi' => $oy_sayi, 'ortalama_puan' => $ortalama]);

    Yorum::find($yorum)->update(['durum' => 0]);

    return back()
    ->with('mesaj', 'Yorum kapatıldı')
    ->with('mesaj_tur', 'success');
}
public function sil($yorum){
    $urun = Yorum::where('id', $yorum)->first();
    $urun_id = $urun->urun_id;
    if ($urun->durum == 1) {
        $analiz = UrunAnaliz::where('urun_id', $urun_id)->first();
        $toplam_puan = $urun->oy;
        $oy_sayi = $analiz->oy_sayi - 1;
        $ortalama = 0;
        if ($oy_sayi > 0) {
            $ortalama = $analiz->toplam_puan / $oy_sayi;
        }

        UrunAnaliz::where('urun_id', $urun_id)->update(['toplam_puan'=>$toplam_puan, 'oy_sayi' => $oy_sayi, 'ortalama_puan' => $ortalama]);
    }
    $yorum = Yorum::destroy($yorum);

    return back()
    ->with('mesaj', 'Yorum silindi')
    ->with('mesaj_tur', 'success');
}
}
