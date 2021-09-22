<?php
namespace App\Http\Controllers\Admin\Kampanya;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Urun, UrunKategori, UrunKategoriAlt, Kategori, KategoriAlt, Marka ,Etiket, UrunEtiket, SepetUrun, XalYode, XalYodeDetay};

// aciklama.txt   
class XalYodeController extends Controller
{
 public function index(){ 

  $XalYode = XalYode::where('deleted_at', null)->orderBy('created_at', 'asc')->get();

  return view('admin.kampanya.XalYode.index', compact('XalYode'));
}

public function olusturSayfa(){ 
 $kategoriler = Kategori::orderBy('sira', 'DESC')->get();
 $markalar = Marka::orderBy('created_at', 'DESC')->get();
 $etiketler = Etiket::orderBy('created_at','asc')->get();

 return view('admin.kampanya.XalYode.olustur', compact('kategoriler', 'markalar', 'etiketler'));
}

public function olustur(){  
 $data = request()->all();    

 $kontrol = XalYode::where('deleted_at', null)->where('ad', $data['ad'])->first();

 if (isset($kontrol)) {
  return back()
  ->with('mesaj', 'X al Y öde İndirim Kampanyası zaten kayıtlı')
  ->with('mesaj_tur', 'danger');
} 

if ($data['tur'] == 0) {
  $XalYode = XalYode::create([
    'ad' => $data['ad'],
    'tur' => $data['tur'],
    'min' => $data['min'],
    'adet_yuzde' => $data['oran'],
    'grup' => $data['uyg_tur'],
    'baslangic_tarihi' => $data['baslangic_tarihi'],
    'bitis_tarihi' => $data['bitis_tarihi']
  ]); 

  $dizi = ['kategoriler', 'kategorilerAlt', 'markalar', 'etiketler'];
  $i = 0;
  foreach($dizi as $di){
    if ($data['uyg_tur'] == $i) {
      foreach ($data[$di] as $entry) {
        XalYodeDetay::create([
          'XalYode_id' => $XalYode->id,
          'uygulanan_id' => $entry
        ]);  
      }
    }
    $i++;
  }

}
if ($data['tur'] == 1) {
  $XalYode =  XalYode::create([
    'ad' => $data['ad'],
    'min' => $data['min'],
    'tur' => $data['tur'],
    'adet_yuzde' => $data['adet'],
    'grup' => $data['uyg_tur'],
    'baslangic_tarihi' => $data['baslangic_tarihi'],
    'bitis_tarihi' => $data['bitis_tarihi']
  ]);

  $dizi = ['kategoriler', 'kategorilerAlt', 'markalar', 'etiketler'];
  $i = 0;
  foreach($dizi as $di){
    if ($data['uyg_tur'] == $i) {
      foreach ($data[$di] as $entry) {
        XalYodeDetay::create([
          'XalYode_id' => $XalYode->id,
          'uygulanan_id' => $entry
        ]);  
      }
    }
    $i++;
  }
}

return redirect()->route('admin.xAlyOde')
->with('mesaj', 'X al Y öde Kampanyası oluşturuldu')
->with('mesaj_tur', 'success');
}

public function guncelleSayfa($id){ 
  $XalYode = XalYode::where('deleted_at', null)->where('id', $id)->firstOrFail(); 
  $kategoriler = Kategori::orderBy('sira', 'DESC')->get();
  $markalar = Marka::orderBy('created_at', 'DESC')->get();
  $etiketler = Etiket::orderBy('created_at','asc')->get();

  $XalYodeDetay = XalYode::join('x_al_y_ode_detay', 'x_al_y_ode.id', '=', 'x_al_y_ode_detay.XalYode_id')
  ->where('x_al_y_ode.id', $id)
  ->get(); 

  return view('admin.kampanya.XalYode.guncelle', compact('kategoriler', 'markalar', 'etiketler', 'XalYode', 'XalYodeDetay'));
}

public function guncelle($id){  
 $data = request()->all();  

 $XalYodenBul = XalYode::where('id', $id)->firstOrFail(); 
 $a = $XalYodenBul->grup;
 $detayEski = XalYodeDetay::where('XalYode_id', $id)->get();
 foreach($detayEski as $entry){
  XalYodeDetay::destroy($entry->id);
}

if ($data['tur'] == 0) {
  $XalYode = XalYode::find($id)->update([
    'ad' => $data['ad'],
    'tur' => $data['tur'],
    'min' => $data['min'],
    'adet_yuzde' => $data['oran'],
    'grup' => $a,
    'baslangic_tarihi' => $data['baslangic_tarihi'],
    'bitis_tarihi' => $data['bitis_tarihi']
  ]); 

  $dizi = ['kategoriler', 'kategorilerAlt', 'markalar', 'etiketler'];
  $i = 0;
  foreach($dizi as $di){
    if ($a == $i) {
      foreach ($data[$di] as $entry) {
        XalYodeDetay::firstOrCreate([ 
          'XalYode_id' => $id,
          'uygulanan_id' => $entry
        ]);  
      }
    }
    $i++;
  }

}
if ($data['tur'] == 1) {
  $XalYode =  XalYode::find($id)->update([
    'ad' => $data['ad'],
    'min' => $data['min'],
    'tur' => $data['tur'],
    'adet_yuzde' => $data['adet'],
    'grup' => $a,
    'baslangic_tarihi' => $data['baslangic_tarihi'],
    'bitis_tarihi' => $data['bitis_tarihi']
  ]);

  $dizi = ['kategoriler', 'kategorilerAlt', 'markalar', 'etiketler'];
  $i = 0;
  foreach($dizi as $di){
    if ($a == $i) {
      foreach ($data[$di] as $entry) {
        XalYodeDetay::firstOrCreate([ 
          'XalYode_id' => $id,
          'uygulanan_id' => $entry
        ]);  
      }
    }
    $i++;
  }
}

return redirect()->route('admin.xAlyOde')
->with('mesaj', 'X al Y öde Kampanyası güncellendi')
->with('mesaj_tur', 'success');
}

public function sil($id)
{
  XalYode::destroy($id); 

  return back()
  ->with('mesaj', 'X al Y öde Kampanyası Silindi.')
  ->with('mesaj_tur', 'success');
}

}
