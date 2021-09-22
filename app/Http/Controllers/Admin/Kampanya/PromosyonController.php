<?php

namespace App\Http\Controllers\Admin\Kampanya;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\{Urun, UrunKategori, UrunKategoriAlt, Kategori, KategoriAlt, Marka ,Etiket, UrunEtiket, SepetUrun, Promosyon, PromosyonDetay, PromosyonUrun};

// aciklama.txt   
class PromosyonController extends AdminController
{
 public function index(){ 
    $promosyon = Promosyon::orderBy('created_at' , 'asc')->get();
    return view('admin.kampanya.promosyon.index', compact('promosyon'));
}
public function olusturSayfa(){ 

 $kategoriler = Kategori::orderBy('sira', 'DESC')->get();
 $markalar = Marka::orderBy('created_at', 'DESC')->get();
 $etiketler = Etiket::orderBy('created_at','asc')->get();
 $urunler= Urun::orderBy('created_at', 'asc')->get();

 return view('admin.kampanya.promosyon.olustur', compact('kategoriler', 'markalar', 'etiketler', 'urunler'));
}
public function olustur(){
    $data = request()->all();     
    $kontrol = Promosyon::where('deleted_at', null)->where('ad', $data['ad'])->first();

    if (isset($kontrol)) {
      return back()
      ->with('mesaj', 'Promosyon Kampanyası zaten kayıtlı')
      ->with('mesaj_tur', 'danger');
  } 

  $promosyon = Promosyon::create([
    'ad' => $data['ad'],
    'min' => $data['min'],
    'grup' => $data['uyg_tur'],
    'baslangic_tarihi' => $data['baslangic_tarihi'],
    'bitis_tarihi' => $data['bitis_tarihi']
]); 
  foreach($data['pro_urunler'] as $urun ){
    PromosyonUrun::create([
        'promosyon_id' => $promosyon->id,
        'urun_id' => $urun
    ]);  
}

$dizi = ['kategoriler', 'kategorilerAlt', 'markalar', 'etiketler' , '','urunler'];
$i = 0;
foreach($dizi as $di){
    if ($data['uyg_tur'] == $i) {
       if ($i == 4) {
        break;
    }
    foreach ($data[$di] as $entry) {

        PromosyonDetay::create([
            'promosyon_id' => $promosyon->id,
            'uygulanan_id' => $entry
        ]);  
    }
}
$i++;
}


return redirect()->route('admin.promosyon')
->with('mesaj', 'Promosyon Kampanyası oluşturuldu')
->with('mesaj_tur', 'success');
}

public function guncelleSayfa($id){ 
    $promosyon = Promosyon::where('deleted_at', null)->where('id', $id)->firstOrFail(); 
    $kategoriler = Kategori::orderBy('sira', 'DESC')->get();
    $markalar = Marka::orderBy('created_at', 'DESC')->get();
    $etiketler = Etiket::orderBy('created_at','asc')->get();
    $urunler= Urun::orderBy('created_at', 'asc')->get();
    $promosyonDetay = Promosyon::join('promosyon_detay', 'promosyon.id', '=', 'promosyon_detay.promosyon_id')
    ->where('promosyon.id', $id)
    ->where('promosyon.deleted_at', null)
    ->where('promosyon_detay.deleted_at', null)
    ->get(); 
    $promosyonUrun = Promosyon::join('promosyon_urun', 'promosyon.id', '=', 'promosyon_urun.promosyon_id')
    ->where('promosyon.id', $id)
    ->where('promosyon.deleted_at', null)
    ->where('promosyon_urun.deleted_at', null) 
    ->get(); 

    return view('admin.kampanya.promosyon.guncelle', compact('kategoriler', 'markalar', 'etiketler', 'urunler', 'promosyon', 'promosyonDetay', 'promosyonUrun'));
}

public function guncelle($id){  
    $data = request()->all();  

    $promosyonBul = Promosyon::where('id', $id)->firstOrFail(); 
    $urunEski = PromosyonUrun::where('promosyon_id', $id)->get();
    $detayEski = PromosyonDetay::where('promosyon_id', $id)->get();

    $a = $promosyonBul->grup;

    foreach($urunEski as $entry){
        PromosyonUrun::destroy($entry->id);
    }
    foreach($detayEski as $entry){
        PromosyonDetay::destroy($entry->id);
    }
    $promosyon = Promosyon::find($id)->update([
        'ad' => $data['ad'],
        'min' => $data['min'],
        'grup' => $a,
        'baslangic_tarihi' => $data['baslangic_tarihi'],
        'bitis_tarihi' => $data['bitis_tarihi']
    ]); 
    foreach($data['pro_urunler'] as $urun){
        PromosyonUrun::firstOrCreate([ 
            'promosyon_id' => $id,
            'urun_id' => $urun
        ]);  
    }
    $dizi = ['kategoriler', 'kategorilerAlt', 'markalar', 'etiketler' , ' ','urunler'];
    $i = 0;
    foreach($dizi as $di){
        if ($a == $i) {
            if ($i == 4) {
                break;
            }
            foreach ($data[$di] as $entry) {
                PromosyonDetay::firstOrCreate([ 
                    'promosyon_id' => $id,
                    'uygulanan_id' => $entry
                ]);  
            }
        }
        $i++;
    }

    return redirect()->route('admin.promosyon')
    ->with('mesaj', 'Promosyon Kampanyası güncellendi')
    ->with('mesaj_tur', 'success');
}
public function sil($id)
{
    Promosyon::destroy($id); 

    return back()
    ->with('mesaj', 'Promosyon Kampanyası Silindi.')
    ->with('mesaj_tur', 'success');
}

}
