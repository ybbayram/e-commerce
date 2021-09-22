<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\{Marka};
use Illuminate\Support\Str;

class MarkaController extends AdminController
{
    public function index(){
        $markalar = Marka::orderByDesc('created_at')->get();

        return view('admin.marka.index', compact('markalar'));
    }

    public function olustur(){
        $data = request()->all();

        $kontrol = Marka::where('ad', $data['ad'])->first();
        if(isset($kontrol)){
            return back()
            ->with('mesaj', 'Marka zaten kayıtlı')
            ->with('mesaj_tur', 'danger');
        }

        Marka::create([
            'ad' => $data['ad'],
            'slug' => Str::slug($data['ad']),
        ]);

        return redirect()->route('admin.marka')
        ->with('mesaj', 'Marka oluşturuldu')
        ->with('mesaj_tur', 'success');
    }

    public function olusturSayfa(){

        return view('admin.marka.olustur');
    }

    public function guncelleSayfa($id){
        $marka = Marka::where('id', $id)->firstOrFail();

        return view('admin.marka.guncelle', compact('marka'));
    }

    public function guncelle($id){
        $data = request()->all();


        Marka::find($id)->update([
            'ad' => $data['ad'],
            'slug' => Str::slug($data['ad']),
        ]);

        return redirect()->route('admin.marka')
        ->with('mesaj', 'Marka güncellendi')
        ->with('mesaj_tur', 'success');
    }

    public function sil($id){
       $marka = Marka::find($id);
        $marka->slug = $marka->slug . Str::random(5);
        $marka->save();
        Marka::destroy($id);
        return back()
        ->with('mesaj', 'Marka silindi.')
        ->with('mesaj_tur', 'success');
    }
    public function aktifYap($id)
    {
        $marka = Marka::find($id);
        $marka->durum = 1;
        $marka->save();

        return back()
        ->with('mesaj', 'Marka durumu aktif yapıldı.')
        ->with('mesaj_tur', 'success');
    }

    public function pasifYap($id)
    {
        $marka = Marka::find($id);
        $marka->durum = 0;
        $marka->save();

        return back()
        ->with('mesaj', 'Marka durumu pasif yapıldı.')
        ->with('mesaj_tur', 'success');
    }

    public function hepsiniAc(){
       $ilk = Marka::orderBy('created_at','asc')->first();
       $son = Marka::orderBy('created_at','desc')->first();

       Marka::where('durum', 0)->where('id', '>=', $ilk->id)->where('id', '<=', $son->id)->update(['durum' => 1]);

       return back()
       ->with('mesaj', 'Tüm markalar aktif yapıldı.')
       ->with('mesaj_tur', 'success');
   }

   public function hepsiniKapat(){
    $ilk = Marka::orderBy('created_at','asc')->first();
    $son = Marka::orderBy('created_at','desc')->first();

    Marka::where('durum', 1)->where('id', '>=', $ilk->id)->where('id', '<=', $son->id)->update(['durum' => 0]);


    return back()
    ->with('mesaj', 'Tüm markalar pasif yapıldı.')
    ->with('mesaj_tur', 'success');
}
}
