<?php

namespace App\Http\Controllers\Admin\Kampanya;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Kupon, KuponKod}; 
use Illuminate\Support\Str;

class KuponController extends Controller
{
    public function index(){ 
        $kuponlar = Kupon::orderBy('created_at', 'asc')->get(); 
        return view('admin.kampanya.kupon.index', compact('kuponlar'));
    }

    public function olusturSayfa(){ 
        return view('admin.kampanya.kupon.olustur');
    }

    public function olustur(){ 
        $data = request()->all();
        $kod = $data['adet'];
        $kontrol = Kupon::where('ad', $data['ad'])->first();
        if (isset($kontrol)) {
            return back()
            ->with('mesaj', 'Kupon zaten kayıtlı')
            ->with('mesaj_tur', 'danger');
        }
        if ($data['min'] < $data['indirim_tutarı']) {
           return back()
           ->with('mesaj', 'Minimum değer indirim tutarından küçük olamaz')
           ->with('mesaj_tur', 'danger');
       }

       $kuponlar = Kupon::create([
        'ad' => $data['ad'],
        'adet' => $data['adet'],
        'min' => $data['min'],
        'indirim_tutarı' => $data['indirim_tutarı'],
        'baslangic_tarihi' => $data['baslangic_tarihi'],
        'bitis_tarihi' => $data['bitis_tarihi'],
    ]);

       for ($i=0; $i < $kod; $i++) {
        $kodlar = 'PH' . $i . Str::random(3) . rand(1,10) . Str::random(3); 
        KuponKod::create([
            'kupon_id' => $kuponlar->id,
            'kod' => $kodlar
        ]);          
    }

    return redirect()->route('admin.kupon')
    ->with('mesaj', 'Kargo Kampanyası oluşturuldu')
    ->with('mesaj_tur', 'success');
}

public function gosterSayfa($id){
    $kupon = Kupon::where('id', $id)->firstOrFail();
    $kodlar = KuponKod::where('kupon_id', $id)
    ->orderBy('created_at', 'asc')
    ->get();
    return view('admin.kampanya.kupon.kod', compact('kodlar', 'kupon'));
}

public function sil($id)
{
    Kupon::destroy($id);

    return back()
    ->with('mesaj', 'Kupon Silindi.')
    ->with('mesaj_tur', 'success');
}

public function aktifYap($id){
    $kupon = Kupon::find($id);
    $kupon->durum = 1;
    $kupon->save();

    return back()
    ->with('mesaj', 'Kupon durumu aktif yapıldı.')
    ->with('mesaj_tur', 'success');
}

public function pasifYap($id){
    $kupon = Kupon::find($id);
    $kupon->durum = 0;
    $kupon->save();

    return back()
    ->with('mesaj', 'Kupon durumu pasif yapıldı.')
    ->with('mesaj_tur', 'success');
}

public function hepsiniAc($id){
   KuponKod::where('kupon_id', $id)->update(['kullanim_durumu' => 0]);

   return back()
   ->with('mesaj', 'Kupon kullanım durumu aktif yapıldı.')
   ->with('mesaj_tur', 'success');
}

public function hepsiniKapat($id){
    KuponKod::where('kupon_id', $id)->update(['kullanim_durumu' => 1]);

    return back()
    ->with('mesaj', 'Kupon kullanım durumu pasif yapıldı.')
    ->with('mesaj_tur', 'success');
}

public function kullanimAktifYap($id){
    $kod = KuponKod::find($id);
    $kod->kullanim_durumu = 1;
    $kod->save();

    return back()
    ->with('mesaj', 'Kupon kullanım durumu aktif yapıldı.')
    ->with('mesaj_tur', 'success');
} 
public function kullanimPasifYap($id){
    $kod = KuponKod::find($id);
    $kod->kullanim_durumu = 0;
    $kod->save();

    return back()
    ->with('mesaj', 'Kupon kullanım durumu pasif yapıldı.')
    ->with('mesaj_tur', 'success');
}
}
