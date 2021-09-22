<?php

namespace App\Http\Controllers\Tanitim;

use App\Http\Controllers\Controller;
use App\GenelFonksiyonlar;
use App\Http\Controllers\FonksiyonlarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie; 
use App\Models\{Urun, Ulke, UlkeKod, Marka, Bulten, Kategori, KategoriAnaliz, OneCikanlar, OneCikanlarUrun, Sepet, SepetUrun};
use App\Models\Site\{SiteSlider, SiteBanner, SiteBanner2, Sozlesmeler};

class IndexController extends Controller
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

public function index(){
    $ulkeId = $this->ulkeIdBul(); 
    $ziyaretciId = Cookie::get('ziyaretci_id'); 
    $kategorilerAltBar = KategoriAnaliz::join('kategori', 'kategori_analiz.kategori_id', '=', 'kategori.id')
    ->where('kategori.durum', 1)
    ->where('kategori.ust_id', 0)
    ->orderBy('kategori_analiz.tiklama', 'desc')
    ->select('kategori_analiz.*')
    ->take(6)
    ->get();   
    foreach($kategorilerAltBar as $kategori){ 
        foreach($kategori->kategori_getir->kategori_urun_getir as $entry){
            $urunBul = Urun::find($entry->urun_id);
            if (isset($urunBul)) {
                $urunGetir[] = $urunBul;
            }

        }
    }

    $random = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
    ->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
    ->join('marka', 'urun.marka', '=', 'marka.id')
    ->where('kategori.durum', 1)
    ->where('kategori.deleted_at', '=', null) 
    ->where('urun_kategori.deleted_at', '=', null) 
    ->where('marka.durum', 1)
    ->where('marka.deleted_at', '=', null) 
    ->where('urun.deleted_at', '=', null) 
    ->where('urun.durum', 1)
    ->select('urun.id', 'urun.slug', 'urun.stok', 'urun.cesit_durum')
    ->distinct('urun_kategori')
    ->inRandomOrder()
    ->take(16)
    ->get();

    $oneCikanUrun = null;
    $oneCikar = OneCikanlar::orderBy('created_at', 'asc')->first();
    if (isset($oneCikar)) {
        $oneCikanUrun = OneCikanlarUrun::where('one_cikan_id', $oneCikar->id)->get();
    }

    $yeni = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
    ->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
    ->join('marka', 'urun.marka', '=', 'marka.id')
    ->where('kategori.durum', 1)
    ->where('kategori.deleted_at', '=', null) 
    ->where('urun_kategori.deleted_at', '=', null) 
    ->where('urun.durum', 1)
    ->where('marka.durum', 1)
    ->where('marka.deleted_at', '=', null) 
    ->where('urun.deleted_at', '=', null) 
    ->orderBy('urun.created_at', 'asc')
    ->select('urun.id', 'urun.slug', 'urun.stok', 'urun.cesit_durum', 'urun.created_at')
    ->distinct('urun_kategori')
    ->take(16)
    ->get();
    

    $slider = SiteSlider::where('durum', 1)->orderBy('sira', 'asc')->get();

    $banner = SiteBanner::where('durum', 1)->orderBy('sira', 'asc')->paginate(6);

    $banner2 = SiteBanner2::orderBy('created_at', 'asc')->first(); 

    $markalar = Marka::join('marka_dil', 'marka.id', '=', 'marka_dil.marka_id')
    ->where('marka.deleted_at', null)
    ->where('marka_dil.deleted_at', null)
    ->where('marka.durum', 1)
    ->get();


    return view('tanitim.index', compact('random', 'yeni', 'markalar', 'slider', 'banner', 'banner2', 'kategorilerAltBar', 'oneCikar', 'oneCikanUrun'));
}

public function sepetApi(){
    $ulkeId = $this->ulkeIdBul(); 
    $ziyaretciId = Cookie::get('ziyaretci_id');

    $urunAdetToplam = null;
    $urunToplam = null;
    $toplamFiyat = null;
    $sepetNav = Sepet::where('ziyaretci_id', $ziyaretciId)->orderBy('created_at','desc')->first();

    $sepetUrunNav = SepetUrun::where('sepet_id', $sepetNav['id'])->get();

    foreach($sepetUrunNav as $sepetUrun){
        $urun = $sepetUrun->sepeturun_urun_getir;
        $urun->detay_bul;
        $urun->gorsel_bul;
        if($urun->cesit_detay_id != null){
            $urun->cesit_detay_bul;
        }
        $urunToplam = $sepetUrun->fiyati * $sepetUrun->adet;
        $urunAdetToplam += $sepetUrun->adet;
        $toplamFiyat += $urunToplam;

        $toplamFiyat = number_format($toplamFiyat, 2);
    }
    return response()->json(['sepetUrunNav' => $sepetUrunNav, 'urunAdetToplam' => $urunAdetToplam, 'toplamFiyat' =>$toplamFiyat]);
}

public function hakkimizda(){

    return view('tanitim.hakkimizda');
}

public function pYonlendir(){

    return redirect()->route('shop');
}

public function search(){
   $aranan = request()->input('aranan');

   return redirect()->route('searchArama', $aranan);
}

public function searchArama($aranan){

    $ulkeId = $this->ulkeIdBul(); 

    $data = request()->all(); 
    if(isset($data['filterPrice'])){
        $filtreFiyat = $data['filterPrice'];
    }else{
        $filtreFiyat = "";
    } 

    if($filtreFiyat == ""){
        $urunler = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
        ->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
        ->join('marka', 'urun.marka', '=', 'marka.id')
        ->where('kategori.durum', 1)
        ->where('kategori.deleted_at', '=', null)
        ->where('urun_kategori.deleted_at', '=', null)
        ->where('marka.durum', 1)
        ->where('marka.deleted_at', '=', null) 
        ->where('urun.durum', 1)
        ->where('urun.baslik', 'like', "%$aranan%")
        ->distinct('urun.id')
        ->select('urun.id', 'urun.slug', 'urun.stok', 'urun.cesit_durum')
        ->paginate(16);
    }

    if($filtreFiyat == "priceDesc"){ 
        $urunler = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
        ->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
        ->join('marka', 'urun.marka', '=', 'marka.id')
        ->join('urun_fiyat', 'urun.id' ,'=', 'urun_fiyat.urun_id')
        ->where('kategori.durum', 1)
        ->where('kategori.deleted_at', '=', null)
        ->where('urun_kategori.deleted_at', '=', null)
        ->where('marka.durum', 1)
        ->where('marka.deleted_at', '=', null) 
        ->where('urun.durum', 1)
        ->where('urun.baslik', 'like', "%$aranan%")
        ->where('urun_fiyat.deleted_at', '=', null)
        ->where('urun_fiyat.ulke_id', $ulkeId)
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
     ->where('urun_kategori.deleted_at', '=', null)
     ->where('marka.durum', 1)
     ->where('marka.deleted_at', '=', null) 
     ->where('urun.durum', 1)
     ->where('urun.baslik', 'like', "%$aranan%")
     ->where('urun_fiyat.deleted_at', '=', null)
     ->where('urun_fiyat.ulke_id', $ulkeId)
     ->orderBy('urun_fiyat.fiyat', 'asc')
     ->distinct('urun.id')
     ->select('urun.id', 'urun.slug', 'urun.stok', 'urun.cesit_durum', 'urun.created_at', 'urun_fiyat.fiyat')
     ->paginate(16);
 }


 return view('tanitim.search', compact('urunler', 'aranan', 'filtreFiyat'));
}
public function kayit()
{
    $data = request()->all();
    $ziyaretciId = Cookie::get('ziyaretci_id'); 
    if (isset($data['mail'])) {
        Bulten::create([
            'ziyaretci_id' => $ziyaretciId, 
            'mail' => $data['mail'] 
        ]);
    }
    return back();
}  


public function sozlesmeler($slug)
{
    $sozlesme = Sozlesmeler::whereSlug($slug)->first();
    return view('tanitim.sozlesmeler', compact('sozlesme'));

}  

public function appGizlilik(){
    return view('tanitim.appGizlilik');
}

}
