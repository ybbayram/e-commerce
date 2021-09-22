<?php

namespace App\Http\Controllers\Admin\Site;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Site\{SSS};

class SSSController extends AdminController
{
    public function index(){
        $sss = SSS::orderByDesc('created_at')->get();
        return view('admin.site.sss.index', compact('sss'));
    }

    public function olusturSayfa(){ 
        return view('admin.site.sss.olustur');

    }

    public function olustur()
    {
        $data = request()->all();
        $sira = 0;
        $sssSira = SSS::orderBy('sira', 'desc')->first();
        if (isset($sssSira)) {
            $sira = $sssSira->sira + 1;
        }
        
        $kontrol = SSS::where('baslik', $data['baslik'])->first();
        if (isset($kontrol)) {
            return back()
            ->with('mesaj', 'SSS zaten kayıtlı')
            ->with('mesaj_tur', 'danger');
        }


        $sss = SSS::create([
            'baslik' => $data['baslik'],
            'slug' => Str::slug($data['baslik']), 
            'sira' => $sira
        ]);

        return redirect()->route('admin.sss')
        ->with('mesaj', 'SSS oluşturuldu')
        ->with('mesaj_tur', 'success');
    }

    public function guncelleSayfa($id)
    {  
        $sss = SSS::where('id', $id)->firstOrFail(); 

        return view('admin.site.sss.guncelle', compact('sss'));
    }


    public function guncelle($id){
        $data = request()->all();

        $sss = SSS::find($id)->update([ 
            'baslik' => $data['baslik'], 
            'slug' => Str::slug($data['baslik'])

        ]);


        return redirect()->route('admin.sss')
        ->with('mesaj', 'SSS güncellendi')
        ->with('mesaj_tur', 'success');
    }

    public function sil($id)
    {
        SSS::destroy($id);

        return back()
        ->with('mesaj', 'SSS silindi.')
        ->with('mesaj_tur', 'success');
    }

    public function siralaSayfa()
    {
        $sss = SSS::orderBy('sira', 'ASC')->get();

        return view('admin.site.sss.sirala', compact('sss'));
    }

    public function sirala()
    {
        $data = request()->all();
        $count = 0;
        $json = $data['json'];

        $rooms = json_decode($json, true);


        foreach ($rooms as $entry) {
            SSS::where('id', $entry['id'])->update([
                'sira' => $count,
            ]);
            $count++;
        }

        return redirect()->route('admin.sss')
        ->with('mesaj', 'SSS sırası güncellendi')
        ->with('mesaj_tur', 'success');
    }
    public function aktifYap($id)
    {
        $sss = SSS::find($id);
        $sss->durum = 1;
        $sss->save();

        return back()
        ->with('mesaj', 'SSS durumu aktif yapıldı.')
        ->with('mesaj_tur', 'success');
    }

    public function pasifYap($id)
    {
        $sss = SSS::find($id);
        $sss->durum = 0;
        $sss->save();

        return back()
        ->with('mesaj', 'SSS durumu pasif yapıldı.')
        ->with('mesaj_tur', 'success');
    }
}
