<?php

namespace App\Http\Controllers\Admin\MailYonetimi;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\{MailPlanla, MailPlanlaEmail}; 

class MailPlanlaController extends AdminController
{
    public function index(){
        $mailPlanla = MailPlanla::orderBy('created_at', 'asc')->get();

        return view('admin.mailYonetimi.mailPlanla.index',compact('mailPlanla'));
    }

    public function olusturSayfa(){

        return view('admin.mailYonetimi.mailPlanla.olustur');
    }

    public function olustur(){
        $data = request()->all();

        $kontrol = MailPlanla::where('ad', $data['ad'])->first();
        if (isset($kontrol)) {
            return back()
            ->with('mesaj', 'Bu isimde bir mail planı zaten kayıtlı')
            ->with('mesaj_tur', 'danger');
        }
        $gun = array("pazartesi" => 0, "sali" => 0, "carsamba" => 0, "persembe" => 0, "cuma" => 0, "cumartesi" => 0, "pazar" => 0);

        if(isset($data['pazartesi'])){
            $gun["pazartesi"] = 1;
        }
        if(isset($data['sali'])){
            $gun["sali"] = 1;
        }
        if(isset($data['çarsamba'])){
            $gun["carsamba"] = 1;
        }
        if(isset($data['persembe'])){
            $gun["persembe"] = 1;
        }
        if(isset($data['cuma'])){
            $gun["cuma"] = 1;
        }
        if(isset($data['cumartesi'])){
            $gun["cumartesi"] = 1;
        }
        if(isset($data['pazar'])){
            $gun["pazar"] = 1;
        }

        if($gun == ["pazartesi" => 0, "sali" => 0, "carsamba" => 0, "persembe" => 0, "cuma" => 0, "cumartesi" => 0, "pazar" => 0]){
            return back()
            ->with('mesaj', 'Gün seçiniz')
            ->with('mesaj_tur', 'danger');
        }

        if(!isset($data['liste'][0]['email'])){
            return back()
            ->with('mesaj', 'Email giriniz')
            ->with('mesaj_tur', 'danger');
        }

        $plan = MailPlanla::create([
            'ad' => $data['ad'],
            'gunler' => json_encode($gun),
            'saat' => $data['saat'],
            'mail_turu' => $data['mailTuru'],
        ]);

        foreach($data['liste'] as $entry){
            MailPlanlaEmail::create([
                'mail_planla' => $plan->id,
                'email' => $entry['email'],
            ]);
        }
        
        return redirect()->route('admin.mailPlanla')
        ->with('mesaj', 'Mail planı oluşturuldu')
        ->with('mesaj_tur', 'success');
    }

    public function guncelleSayfa($id){
        $mailPlan = MailPlanla::where('id', $id)->firstOrFail(); 
        
        return view('admin.mailYonetimi.mailPlanla.guncelle', compact('mailPlan'));
    }

    public function guncelle($id){
        $data = request()->all(); 

        $gun = array("pazartesi" => 0, "sali" => 0, "carsamba" => 0, "persembe" => 0, "cuma" => 0, "cumartesi" => 0, "pazar" => 0);

        if(isset($data['pazartesi'])){
            $gun["pazartesi"] = 1;
        }
        if(isset($data['sali'])){
            $gun["sali"] = 1;
        }
        if(isset($data['çarsamba'])){
            $gun["carsamba"] = 1;
        }
        if(isset($data['persembe'])){
            $gun["persembe"] = 1;
        }
        if(isset($data['cuma'])){
            $gun["cuma"] = 1;
        }
        if(isset($data['cumartesi'])){
            $gun["cumartesi"] = 1;
        }
        if(isset($data['pazar'])){
            $gun["pazar"] = 1;
        }

        if($gun == ["pazartesi" => 0, "sali" => 0, "carsamba" => 0, "persembe" => 0, "cuma" => 0, "cumartesi" => 0, "pazar" => 0]){
            return back()
            ->with('mesaj', 'Gün seçiniz')
            ->with('mesaj_tur', 'danger');
        }

        if(!isset($data['liste'][0]['email'])){
            return back()
            ->with('mesaj', 'Email giriniz')
            ->with('mesaj_tur', 'danger');
        }

        $plan = MailPlanla::find($id);

        $plan->update([
            'ad' => $data['ad'],
            'gunler' => json_encode($gun),
            'saat' => $data['saat'],
            'mail_turu' => $data['mailTuru'],
        ]);

        $emailler = MailPlanlaEmail::where('mail_planla', $plan->id)->get();

        foreach($emailler as $entry){
            MailPlanlaEmail::destroy($entry->id);
        }

        foreach($data['liste'] as $entry){
            MailPlanlaEmail::create([
                'mail_planla' => $plan->id,
                'email' => $entry['email'],
            ]);
        }

        return redirect()->route('admin.mailPlanla')
        ->with('mesaj', 'Mail planlaması güncellendi')
        ->with('mesaj_tur', 'success');
    }

    public function sil($id){
        MailPlanla::destroy($id);

        return back()
        ->with('mesaj', 'Mail Planlaması Silindi.')
        ->with('mesaj_tur', 'success');
    }

    public function aktifYap($id){
        $urun = MailPlanla::find($id);
        $urun->durum = 1;
        $urun->save();

        return back()
        ->with('mesaj', 'Mail planı durumu aktif yapıldı.')
        ->with('mesaj_tur', 'success');
    }

    public function pasifYap($id){
        $urun = MailPlanla::find($id);
        $urun->durum = 0;
        $urun->save();

        return back()
        ->with('mesaj', 'Mail planı durumu pasif yapıldı.')
        ->with('mesaj_tur', 'success');
    }

    public function hepsiniAc(){
        $ilk = MailPlanla::orderBy('created_at','asc')->first();
        $son = MailPlanla::orderBy('created_at','desc')->first();
        
        MailPlanla::where('durum', 0)->where('id', '>=', $ilk->id)->where('id', '<=', $son->id)->update(['durum' => 1]);

        return back()
        ->with('mesaj', 'Tüm mail planları aktif yapıldı.')
        ->with('mesaj_tur', 'success');
    }

    public function hepsiniKapat(){
        $ilk = MailPlanla::orderBy('created_at','asc')->first();
        $son = MailPlanla::orderBy('created_at','desc')->first();

        MailPlanla::where('durum', 1)->where('id', '>=', $ilk->id)->where('id', '<=', $son->id)->update(['durum' => 0]);

        return back()
        ->with('mesaj', 'Tüm mail planları pasif yapıldı.')
        ->with('mesaj_tur', 'success');
    }
}
