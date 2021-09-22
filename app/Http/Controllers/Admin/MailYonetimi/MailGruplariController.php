<?php

namespace App\Http\Controllers\Admin\MailYonetimi;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\{MailGrup}; 

class MailGruplariController extends AdminController
{
    public function index(){
        $mailGruplari = MailGrup::orderBy('created_at', 'asc')->get();

        return view('admin.mailYonetimi.mailGruplari.index',compact('mailGruplari'));
    }

    public function olusturSayfa(){

        return view('admin.mailYonetimi.mailGruplari.olustur');
    }

    public function olustur(){ 
        $data = request()->all();

        $kontrol = MailGrup::where('ad', $data['ad'])->first();
        if(isset($kontrol)) {
            return back()
            ->with('mesaj', 'Bu isimde bir mail grubu zaten kayıtlı')
            ->with('mesaj_tur', 'danger');
        }

        if($data['grup'] == -1) {
            return back()
            ->with('mesaj', 'Tür seçiniz.')
            ->with('mesaj_tur', 'danger');
        }

        if($data['baslangic_tarihi'] > $data['bitis_tarihi']) {
            return back()
            ->with('mesaj', 'Başlangıç tarihi bitiş tarihinden sonra olamaz.')
            ->with('mesaj_tur', 'danger');
        }

        MailGrup::create([
            'ad' => $data['ad'],
            'grup' => $data['grup'],
            'baslangic_tarihi' => $data['baslangic_tarihi'],
            'bitis_tarihi' => $data['bitis_tarihi'],
        ]);
        
        return redirect()->route('admin.mailGruplari')
        ->with('mesaj', 'Mail grubu oluşturuldu')
        ->with('mesaj_tur', 'success');
    }

    public function guncelleSayfa($id){ 
        $mailGrup = MailGrup::where('id', $id)->firstOrFail(); 
        
        return view('admin.mailYonetimi.mailGruplari.guncelle', compact('mailGrup'));
    }

    public function guncelle($id){
        $data = request()->all(); 

        MailGrup::find($id)->update([
            'ad' => $data['ad'],
        ]);

        return redirect()->route('admin.mailGruplari')
        ->with('mesaj', 'Mail grubu güncellendi')
        ->with('mesaj_tur', 'success');
    }

    public function sil($id){
        MailGrup::destroy($id);

        return back()
        ->with('mesaj', 'Mail grubu silindi.')
        ->with('mesaj_tur', 'success');
    }
}
