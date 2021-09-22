<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\{Etiket};
use Illuminate\Support\Str;

class EtiketController extends AdminController
{
    public function index()
    {
        $etiketler = Etiket::orderByDesc('created_at')->get();

        return view('admin.etiket.index', compact('etiketler'));
    }

    public function olustur()
    {
        $data = request()->all();

        $kontrol = Etiket::where('ad', $data['ad'])->first();
        if (isset($kontrol)) {
            return back()
            ->with('mesaj', 'Etiket zaten kayıtlı')
            ->with('mesaj_tur', 'danger');
        }

        $sira = 0;

        $etiketSira = Etiket::orderBy('sira', 'desc')->first();

        if (isset($etiketSira)) {
            $sira = $etiketSira->sira + 1;
        }
        $etiket = Etiket::create([
            'ad' => $data['ad'],
            'slug' => Str::slug($data['ad']). "-". Str::random(3),
            'sira' => $sira,
        ]);
        return redirect()->route('admin.etiket')
        ->with('mesaj', 'Etiket oluşturuldu')
        ->with('mesaj_tur', 'success');
    }

    public function olusturSayfa()
    {
        return view('admin.etiket.olustur' );
    }

    public function guncelleSayfa($id)
    {  
        $etiket = Etiket::where('id', $id)->firstOrFail(); 

        return view('admin.etiket.guncelle', compact('etiket'));
    }

    public function guncelle($id)
    {
        $data = request()->all(); 

        $etiket = Etiket::find($id)->update([
         'ad' => $data['ad'],
         'slug' => Str::slug($data['ad']). "-". Str::random(3)
     ]);
        return redirect()->route('admin.etiket')
        ->with('mesaj', 'Etiket güncellendi')
        ->with('mesaj_tur', 'success');
    }

    public function sil($id)
    {
        Etiket::destroy($id);

        return back()
        ->with('mesaj', 'Etiket silindi.')
        ->with('mesaj_tur', 'success');
    }

    public function siralaSayfa()
    {
        $etiket = Etiket::orderBy('sira', 'ASC')->get();

        return view('admin.etiket.sirala', compact('etiket'));
    }

    public function sirala()
    {
        $data = request()->all();
        $count = 0;
        $json = $data['json'];

        $rooms = json_decode($json, true);


        foreach ($rooms as $entry) {
            Etiket::where('id', $entry['id'])->update([
                'sira' => $count,
            ]);
            $count++;
        }

        return redirect()->route('admin.etiket')
        ->with('mesaj', 'Etiket sırası güncellendi')
        ->with('mesaj_tur', 'success');
    }
    public function aktifYap($id)
    {
        $etiket = Etiket::find($id);
        $etiket->durum = 1;
        $etiket->save();

        return back()
        ->with('mesaj', 'Etiket durumu aktif yapıldı.')
        ->with('mesaj_tur', 'success');
    }

    public function pasifYap($id)
    {
        $etiket = Etiket::find($id);
        $etiket->durum = 0;
        $etiket->save();

        return back()
        ->with('mesaj', 'Etiket durumu pasif yapıldı.')
        ->with('mesaj_tur', 'success');
    }

    public function hepsiniAc(){
     $ilk = Etiket::orderBy('created_at','asc')->first();
     $son = Etiket::orderBy('created_at','desc')->first();

     Etiket::where('durum', 0)->where('id', '>=', $ilk->id)->where('id', '<=', $son->id)->update(['durum' => 1]);

     return back()
     ->with('mesaj', 'Tüm etiketler aktif yapıldı.')
     ->with('mesaj_tur', 'success');
 }

 public function hepsiniKapat(){
    $ilk = Etiket::orderBy('created_at','asc')->first();
    $son = Etiket::orderBy('created_at','desc')->first();

    Etiket::where('durum', 1)->where('id', '>=', $ilk->id)->where('id', '<=', $son->id)->update(['durum' => 0]);


    return back()
    ->with('mesaj', 'Tüm etiketler pasif yapıldı.')
    ->with('mesaj_tur', 'success');
}
}
