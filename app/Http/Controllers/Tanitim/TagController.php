<?php
namespace App\Http\Controllers\Tanitim;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GenelFonksiyonlar;
use App\Http\Controllers\FonksiyonlarController; 
use Cookie;
use App\Models\{Urun, UrunFiyat, UrunKategori, UrunKategoriAlt, Ulke,
    UlkeKod, Kategori, KategoriAlt, KategoriDil, KategoriAltDil,
    Ziyaretci, Marka, Etiket, Filtre, FiltreKategori, FiltreKategoriAlt, UrunEtiket};

    class TagController extends Controller
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

    public function ziyaretciDilBul(){
        $ziyaretciId = Cookie::get('ziyaretci_id');
        $ziyaretci = Ziyaretci::find($ziyaretciId);

        return $ziyaretci->dil_id;
    }

    public function etiket($etiket){

        $ulkeId = $this->ulkeIdBul();
        $gelenMarka = [];

        $data = request()->all(); 
        if(isset($data['filterPrice'])){
            $filtreFiyat = $data['filterPrice'];
        }else{
            $filtreFiyat = "";
        } 

        $etiketBul = Etiket::whereSlug($etiket)->firstOrFail();

        $kategori = Kategori::where('deleted_at', '=', null)
        ->where('durum', 1)
        ->where('ust_id', 0)
        ->orderBy('sira', 'asc')
        ->get();

        $random = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
        ->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
        ->join('marka', 'urun.marka', '=', 'marka.id')
        ->select('urun.*','kategori.durum', 'kategori.deleted_at','urun_kategori.deleted_at', 'marka.durum', 'marka.deleted_at') 
        ->where('kategori.durum', 1)
        ->where('kategori.deleted_at', '=', null)
        ->where('marka.durum', 1)
        ->where('marka.deleted_at', '=', null)
        ->where('urun_kategori.deleted_at', '=', null)
        ->where('urun.durum', 1)
        ->inRandomOrder()
        ->paginate(8);


        if($filtreFiyat == ""){
          $urunler = Urun::join('urun_etiket', 'urun.id', '=', 'urun_etiket.urun_id')
          ->join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
          ->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id') 
          ->join('etiket', 'urun_etiket.etiket_id', '=', 'etiket.id')
          ->join('marka', 'urun.marka', '=', 'marka.id')
          ->select('urun.*', 'kategori.durum', 'kategori.deleted_at', 'urun_kategori.deleted_at', 'etiket.durum', 'etiket.deleted_at', 'marka.durum', 'marka.deleted_at') 
          ->where('kategori.durum', 1)
          ->where('kategori.deleted_at', '=', null)
          ->where('etiket.durum', 1)
          ->where('etiket.deleted_at', '=', null)
          ->where('marka.durum', 1)
          ->where('marka.deleted_at', '=', null)
          ->where('urun_kategori.deleted_at', '=', null) 
          ->where('urun_etiket.etiket_id', $etiketBul->id)
          ->where('urun_etiket.deleted_at', '=', null)
          ->where('urun.durum', 1)
          ->distinct('urun.id')
          ->select('urun.id', 'urun.slug', 'urun.stok', 'urun.cesit_durum', 'urun.created_at')
          ->paginate(16);    

      }

      if($filtreFiyat == "priceDesc"){ 
        $urunler = Urun::join('urun_etiket', 'urun.id', '=', 'urun_etiket.urun_id')
        ->join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
        ->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id') 
        ->join('etiket', 'urun_etiket.etiket_id', '=', 'etiket.id')
        ->join('marka', 'urun.marka', '=', 'marka.id')
        ->join('urun_fiyat', 'urun.id' ,'=', 'urun_fiyat.urun_id')
        ->where('kategori.durum', 1)
        ->where('kategori.deleted_at', '=', null)
        ->where('etiket.durum', 1)
        ->where('etiket.deleted_at', '=', null)
        ->where('marka.durum', 1)
        ->where('marka.deleted_at', '=', null)
        ->where('urun_kategori.deleted_at', '=', null) 
        ->where('urun_etiket.etiket_id', $etiketBul->id)
        ->where('urun_etiket.deleted_at', '=', null)
        ->where('urun.durum', 1)
        ->where('urun_fiyat.deleted_at', '=', null)
        ->where('urun_fiyat.ulke_id', $ulkeId)
        ->orderBy('urun_fiyat.fiyat', 'desc')
        ->distinct('urun.id')
        ->select('urun.id', 'urun.slug', 'urun.stok', 'urun.cesit_durum', 'urun.created_at', 'urun_fiyat.fiyat')
        ->paginate(16);
    }

    if($filtreFiyat == "priceAsc"){
        $urunler = Urun::join('urun_etiket', 'urun.id', '=', 'urun_etiket.urun_id')
        ->join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
        ->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id') 
        ->join('etiket', 'urun_etiket.etiket_id', '=', 'etiket.id')
        ->join('marka', 'urun.marka', '=', 'marka.id')
        ->join('urun_fiyat', 'urun.id' ,'=', 'urun_fiyat.urun_id')
        ->where('kategori.durum', 1)
        ->where('kategori.deleted_at', '=', null)
        ->where('etiket.durum', 1)
        ->where('etiket.deleted_at', '=', null)
        ->where('marka.durum', 1)
        ->where('marka.deleted_at', '=', null)
        ->where('urun_kategori.deleted_at', '=', null) 
        ->where('urun_etiket.etiket_id', $etiketBul->id)
        ->where('urun_etiket.deleted_at', '=', null)
        ->where('urun.durum', 1)
        ->where('urun_fiyat.deleted_at', '=', null)
        ->where('urun_fiyat.ulke_id', $ulkeId)
        ->orderBy('urun_fiyat.fiyat', 'asc')
        ->distinct('urun.id')
        ->select('urun.id', 'urun.slug', 'urun.stok', 'urun.cesit_durum', 'urun.created_at', 'urun_fiyat.fiyat')
        ->paginate(16);
    }

    $markalar = UrunEtiket::where('etiket_id', $etiketBul->id)
    ->join('urun', 'urun_etiket.urun_id', '=','urun.id')
    ->join('marka', 'urun.marka', '=', 'marka.id')
    ->where('marka.durum',1)
    ->where('marka.deleted_at', null) 
    ->where('urun.deleted_at', null) 
    ->where('urun.durum',1)
    ->where('urun_etiket.deleted_at',null)
    ->select('marka.*',) 
    ->distinct("urun.marka")
    ->orderBy('marka.ad', 'asc')
    ->get(); 


    $fiyat =  Urun::join('urun_etiket', 'urun.id', '=', 'urun_etiket.urun_id')
    ->join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
    ->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id') 
    ->join('etiket', 'urun_etiket.etiket_id', '=', 'etiket.id')
    ->join('marka', 'urun.marka', '=', 'marka.id')
    ->join('urun_fiyat', 'urun.id' ,'=', 'urun_fiyat.urun_id')
    ->where('kategori.durum', 1)
    ->where('kategori.deleted_at', '=', null)
    ->where('etiket.durum', 1)
    ->where('etiket.deleted_at', '=', null)
    ->where('marka.durum', 1)
    ->where('marka.deleted_at', '=', null)
    ->where('urun_kategori.deleted_at', '=', null) 
    ->where('urun_etiket.etiket_id', $etiketBul->id)
    ->where('urun_etiket.deleted_at', '=', null)
    ->where('urun.durum', 1)
    ->where('urun_fiyat.deleted_at', '=', null)
    ->where('urun_fiyat.ulke_id', $ulkeId)
    ->orderBy('urun_fiyat.fiyat', 'asc')
    ->distinct('urun.id')
    ->select('urun_fiyat.fiyat')
    ->get();    
    $gelenBaslangicFiyat = null;
    $gelenBitisFiyat = $fiyat->max('fiyat'); 

    $etiket = $etiketBul;  

    return view('tanitim.etiketler.etiketler', compact('urunler', 'gelenMarka', 'kategori', 'random', 'markalar','etiket', 'filtreFiyat', 'gelenBitisFiyat', 'gelenBaslangicFiyat'));
}

public function etiketFilter($etiket){
    $ulkeId = $this->ulkeIdBul();
    $data = request()->all();
    $gelenMarka = [];
    $gelenBaslangicFiyat = "0";
    $gelenBitisFiyat = "100000";
    if (isset($data['price_start'])) {
        $gelenBaslangicFiyat = $data['price_start']; 
    } 
    if (isset($data['price_finish'])) { 
        $gelenBitisFiyat = $data['price_finish']; 
    } 
    $filtreFiyat = "";

    $etiketBul = Etiket::whereSlug($etiket)->firstOrFail();
    $kategori = Kategori::where('deleted_at', '=', null)
    ->where('durum', 1)
    ->where('ust_id', 0)
    ->orderBy('sira', 'asc')
    ->get();

    $random = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
    ->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
    ->join('marka', 'urun.marka', '=', 'marka.id')
    ->select('urun.*','kategori.durum', 'kategori.deleted_at','urun_kategori.deleted_at', 'marka.durum', 'marka.deleted_at') 
    ->where('kategori.durum', 1)
    ->where('kategori.deleted_at', '=', null)
    ->where('marka.durum', 1)
    ->where('marka.deleted_at', '=', null)
    ->where('urun_kategori.deleted_at', '=', null)
    ->where('urun.durum', 1)
    ->inRandomOrder()
    ->paginate(8);

    if(isset($data['markalar'])){ 
        $urunler = Urun::join('urun_etiket', 'urun.id', '=', 'urun_etiket.urun_id')
        ->join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
        ->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id') 
        ->join('etiket', 'urun_etiket.etiket_id', '=', 'etiket.id')
        ->join('marka', 'urun.marka', '=', 'marka.id')
        ->join('urun_fiyat', 'urun.id' ,'=', 'urun_fiyat.urun_id')
        ->select('urun.*', 'kategori.durum', 'kategori.deleted_at', 'urun_kategori.deleted_at', 'etiket.durum', 'etiket.deleted_at', 'marka.durum', 'marka.deleted_at', 'urun_fiyat.fiyat') 
        ->WhereIn('marka', $data['markalar']) 
        ->where('kategori.durum', 1)
        ->where('kategori.deleted_at', '=', null)
        ->where('etiket.durum', 1)
        ->where('etiket.deleted_at', '=', null)
        ->where('marka.durum', 1)
        ->where('marka.deleted_at', '=', null)
        ->where('urun_kategori.deleted_at', '=', null) 
        ->where('urun_etiket.etiket_id', $etiketBul->id)
        ->where('urun_etiket.deleted_at', '=', null)
        ->where('urun_fiyat.deleted_at', '=', null)
        ->where('urun_fiyat.ulke_id', $ulkeId)
        ->where('urun.deleted_at', '=', null) 
        ->where('urun.durum', 1)
        ->where('urun_fiyat.fiyat', '>=', $gelenBaslangicFiyat)
        ->where('urun_fiyat.fiyat', '<=', $gelenBitisFiyat)
        ->orderBy('urun_fiyat.fiyat','asc')
        ->distinct('urun.id')
        ->paginate(16);    
        $gelenMarka = $data['markalar'];
    }
    if(!isset($data['markalar'])){
        $urunler = Urun::join('urun_etiket', 'urun.id', '=', 'urun_etiket.urun_id')
        ->join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
        ->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id') 
        ->join('etiket', 'urun_etiket.etiket_id', '=', 'etiket.id')
        ->join('marka', 'urun.marka', '=', 'marka.id')
        ->join('urun_fiyat', 'urun.id' ,'=', 'urun_fiyat.urun_id')
        ->select('urun.*', 'kategori.durum', 'kategori.deleted_at', 'urun_kategori.deleted_at', 'etiket.durum', 'etiket.deleted_at', 'marka.durum', 'marka.deleted_at', 'urun_fiyat.fiyat') 
        ->where('kategori.durum', 1)
        ->where('kategori.deleted_at', '=', null)
        ->where('etiket.durum', 1)
        ->where('etiket.deleted_at', '=', null)
        ->where('marka.durum', 1)
        ->where('marka.deleted_at', '=', null)
        ->where('urun_kategori.deleted_at', '=', null) 
        ->where('urun_etiket.etiket_id', $etiketBul->id)
        ->where('urun_etiket.deleted_at', '=', null)
        ->where('urun_fiyat.deleted_at', '=', null)
        ->where('urun_fiyat.ulke_id', $ulkeId)
        ->where('urun.deleted_at', '=', null) 
        ->where('urun.durum', 1)
        ->where('urun_fiyat.fiyat', '>=', $gelenBaslangicFiyat)
        ->where('urun_fiyat.fiyat', '<=', $gelenBitisFiyat)
        ->orderBy('urun_fiyat.fiyat','asc')
        ->distinct('urun.id')
        ->paginate(16);   
    }

    $markalar = UrunEtiket::where('etiket_id', $etiketBul->id)
    ->join('urun', 'urun_etiket.urun_id', '=','urun.id')
    ->join('marka', 'urun.marka', '=', 'marka.id')
    ->where('marka.durum',1)
    ->where('marka.deleted_at', null) 
    ->where('urun.deleted_at', null) 
    ->where('urun.durum',1)
    ->where('urun_etiket.deleted_at',null)
    ->select('marka.*',) 
    ->distinct("urun.marka")
    ->orderBy('marka.ad', 'asc')
    ->get(); 
    $etiket = $etiketBul;  

    return view('tanitim.etiketler.etiketler', compact('urunler', 'gelenMarka', 'kategori', 'random', 'markalar','etiket', 'gelenBaslangicFiyat', 'gelenBitisFiyat' ,'filtreFiyat'));
}
}
