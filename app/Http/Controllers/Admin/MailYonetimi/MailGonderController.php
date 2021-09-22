<?php

namespace App\Http\Controllers\Admin\MailYonetimi;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\{MailGonder, MailGrup}; 

class MailGonderController extends AdminController
{
    public function index(){
        $mailGonder = MailGonder::orderBy('created_at', 'asc')->get();

        return view('admin.mailYonetimi.MailGonder.index', compact('mailGonder'));
    }

    public function olusturSayfa(){
        $mailGruplari = MailGrup::orderBy('created_at', 'asc')->get();

        return view('admin.mailYonetimi.MailGonder.olustur', compact('mailGruplari'));
    }

    public function olustur(){ 
        $data = request()->all();

        MailGonder::create([
            'konu' => $data['konu'],
            'mesaj' => $data['mesaj'],
            'mail_gruplari_id' => $data['mailGruplariId'],
        ]);
        
        return redirect()->route('admin.mailGonder')
        ->with('mesaj', 'Mail gönderildi')
        ->with('mesaj_tur', 'success');
    }

}
