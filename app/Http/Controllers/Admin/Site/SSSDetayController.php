<?php

namespace App\Http\Controllers\Admin\Site;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Site\{SSSDetay, SSS};


class SSSDetayController extends AdminController
{
    public function index($sss){ 
        $sssDetay = SSSDetay::where('sss_id', $sss)->orderBy('sira', 'asc')->get(); 
        $sss = SSS::find($sss);

        return view('admin.site.sssDetay.index', compact('sssDetay', 'sss'));
    }

    public function olustur($sss){ 
        $data = request()->all();
        $sira = 0;
        $soruSira = SSSDetay::orderBy('sira', 'desc')->first();

        if (isset($sliderSira)) {
            $sira = $soruSira->sira + 1;
        }

        $sssBul = SSS::find($sss);

        $soruKontrol = SSSDetay::where('baslik', $data['baslik'])->first();
        if(isset($soruKontrol)){
            return back()
            ->with('mesaj', 'Bu soru için zaten bir kayıt var')
            ->with('mesaj_tur', 'danger');
        }

        SSSDetay::create([ 
            'sss_id' =>$sss,
            'baslik' => $data['baslik'],
            'sira' => $sira 
        ]); 

        return redirect()->route('admin.sss.detay', $sss)
        ->with('mesaj', 'SSS Soru oluşturuldu')
        ->with('mesaj_tur', 'success');
    }

    public function guncelleSayfa($id)
    {  

        $sssDetay = SSSDetay::where('id', $id)->first(); 

        return view('admin.site.sssDetay.guncelle', compact('sssDetay'));
    }

    public function guncelle($id){
        $data = request()->all();

        $sss = SSSDetay::find($id)->update([ 
            'baslik' => $data['baslik'] 

        ]);
        $sssDetay = SSSDetay::where('id', $sss)->first(); 

        return redirect()->route('admin.sss.detay', $sssDetay->sss_id)
        ->with('mesaj', 'SSS detay güncellendi')
        ->with('mesaj_tur', 'success');
    }

    public function siralaSayfa($id)
    {
        $sssDetay = SSSDetay::orderBy('sira', 'ASC')->get();
        $sss = SSS::find($id);

        return view('admin.site.sssDetay.sirala', compact('sssDetay', 'sss'));
    }

    public function sirala($id)
    {
        $data = request()->all();
        $count = 0;
        $json = $data['json'];

        $rooms = json_decode($json, true);


        foreach ($rooms as $entry) {
            sssDetay::where('id', $entry['id'])->update([
                'sira' => $count,
            ]);
            $count++;
        } 
        return redirect()->route('admin.sss.detay', $id)
        ->with('mesaj', 'SSS sırası güncellendi')
        ->with('mesaj_tur', 'success');
    }
    public function aktifYap($id)
    {
        $sss = SSSDetay::find($id);
        $sss->durum = 1;
        $sss->save();

        return back()
        ->with('mesaj', 'SSS durumu aktif yapıldı.')
        ->with('mesaj_tur', 'success');
    }

    public function pasifYap($id)
    {
        $sss = SSSDetay::find($id);
        $sss->durum = 0;
        $sss->save();

        return back()
        ->with('mesaj', 'SSS durumu pasif yapıldı.')
        ->with('mesaj_tur', 'success');
    }
    
    public function sil( $id){
        SSSDetay::destroy($id);

        return back()
        ->with('mesaj', 'SSS silindi.')
        ->with('mesaj_tur', 'success');
    }


}
