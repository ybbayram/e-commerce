<?php

namespace App\Http\Controllers\Tanitim;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GenelFonksiyonlar;
use App\Http\Controllers\FonksiyonlarController;
use Cookie;
use App\Models\{
    Urun,
    UrunFiyat,
    UrunKategori,
    UrunKategoriAlt,
    Ulke,
    UlkeKod,
    Kategori,
    KategoriAlt,
    KategoriDil,
    KategoriAltDil,
    Ziyaretci,
    Marka,
    Etiket,
    Filtre,
    FiltreKategori,
    FiltreKategoriAlt,
    UrunEtiket
};

class MarkaController extends Controller
{
    public function ulkeIdBul()
    {

        $ipUlke = GenelFonksiyonlar::getIp();
        $ip = $ipUlke['ip'];
        $ulkeKod = $ipUlke['ulkeKod'];

        $ulkeKod = UlkeKod::where('kod', $ulkeKod)->first();
        $ulke = Ulke::where('ulke_kod_id', $ulkeKod->id)->first();

        if (isset($ulke->id)) {
            return $ulke->id;
        } else {
            return 0;
        }
    }

    public function ziyaretciDilBul()
    {
        $ziyaretciId = Cookie::get('ziyaretci_id');
        $ziyaretci = Ziyaretci::find($ziyaretciId);

        return $ziyaretci->dil_id;
    }

    public function marka($marka)
    {
        $ulkeId = $this->ulkeIdBul();

        $data = request()->all(); 
        if(isset($data['filterPrice'])){
            $filtreFiyat = $data['filterPrice'];
        }else{
            $filtreFiyat ="";
        } 

        $markaBul = Marka::whereSlug($marka)->firstOrFail();

        $markalar = Marka::where('durum', 1)
        ->where('deleted_at', '=', null)
        ->orderBy('ad', 'asc')
        ->get();

        $random = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
        ->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
        ->join('marka', 'urun.marka', '=', 'marka.id')
        ->select('urun.*', 'kategori.durum', 'kategori.deleted_at', 'urun_kategori.deleted_at', 'marka.durum', 'marka.deleted_at')
        ->where('kategori.durum', 1)
        ->where('kategori.deleted_at', '=', null)
        ->where('marka.durum', 1)
        ->where('marka.deleted_at', '=', null)
        ->where('urun_kategori.deleted_at', '=', null)
        ->where('urun.durum', 1)
        ->distinct('urun_kategori')
        ->inRandomOrder()
        ->take(16)
        ->get();

        if($filtreFiyat == ""){
           $urunler = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
           ->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
           ->join('marka', 'urun.marka', '=', 'marka.id')
           ->where('urun.marka', $markaBul->id)
           ->where('urun_kategori.deleted_at', '=', null) 
           ->where('kategori.deleted_at', '=', null)
           ->where('kategori.durum', 1)  
           ->where('urun.durum', 1)
           ->where('urun.deleted_at', '=', null)
           ->where('marka.durum', 1)
           ->where('marka.deleted_at', '=', null)
           ->select('urun.id', 'urun.slug', 'urun.stok', 'urun.cesit_durum', 'urun.created_at')
           ->distinct('urun.id')
           ->paginate(16); 
       }

       if($filtreFiyat == "priceDesc"){ 
        $urunler = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
        ->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
        ->join('marka', 'urun.marka', '=', 'marka.id')
        ->join('urun_fiyat', 'urun.id' ,'=', 'urun_fiyat.urun_id')
        ->where('kategori.durum', 1)
        ->where('kategori.deleted_at', '=', null)
        ->where('marka.durum', 1)
        ->where('marka.deleted_at', '=', null) 
        ->where('urun.marka', $markaBul->id)
        ->where('urun_fiyat.deleted_at', '=', null)
        ->where('urun_fiyat.ulke_id', $ulkeId)
        ->where('urun_kategori.deleted_at', '=', null) 
        ->where('urun.deleted_at', '=', null) 
        ->where('urun.durum', 1)
        ->orderBy('urun_fiyat.fiyat', 'desc')
        ->distinct('urun.id')
        ->select('urun.id', 'urun.slug', 'urun.stok', 'urun.cesit_durum', 'urun.created_at', 'urun_fiyat.fiyat')
        ->paginate(16);
    }

    if($filtreFiyat == "priceAsc"){
        $urunler = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
        ->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
        ->join('marka', 'urun.marka', '=', 'marka.id')
        ->join('urun_fiyat', 'urun.id' ,'=', 'urun_fiyat.urun_id')
        ->where('kategori.durum', 1)
        ->where('kategori.deleted_at', '=', null)
        ->where('marka.durum', 1)
        ->where('marka.deleted_at', '=', null)
        ->where('urun.marka', $markaBul->id)
        ->where('urun_fiyat.deleted_at', '=', null)
        ->where('urun_fiyat.ulke_id', $ulkeId)
        ->where('urun_kategori.deleted_at', '=', null) 
        ->where('urun.deleted_at', '=', null) 
        ->where('urun.durum', 1)
        ->orderBy('urun_fiyat.fiyat', 'asc')
        ->distinct('urun.id')
        ->select('urun.id', 'urun.slug', 'urun.stok', 'urun.cesit_durum', 'urun.created_at', 'urun_fiyat.fiyat')
        ->paginate(16);
    }


    $marka = $markaBul;
    return view('tanitim.marka.marka', compact('urunler', 'random', 'marka', 'markalar', 'filtreFiyat'));
}
}
