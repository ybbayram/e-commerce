<?php

namespace App\Http\Controllers\Admin\Site;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\{Dil};
use Illuminate\Support\Str;
use App\Models\Site\{SSS, SSSDil};

class SSSDilController extends AdminController
{
    public function index($sss){
        $sssDil = SSSDil::where('sss_id', $sss)->orderByDesc('created_at')->get();
        $sss = SSS::find($sss);

        return view('admin.site.sssDil.index', compact('sssDil', 'sss'));
    }

    public function olusturSayfa($sss){
        $sss = SSS::find($sss);
        $diller = Dil::orderBy('created_at', 'DESC')->get();

        return view('admin.site.sssDil.olustur', compact('sss', 'diller'));
    }

    public function olustur($sss){
       $data = request()->all();
       $sssBul = SSS::find($sss);
       $dilKontrol = SSSDil::where('dil_id', $data['dil_id'])->where('sss_id', $sss)->first();
       if(isset($dilKontrol)){
        return back()
        ->with('mesaj', 'Bu dil için zaten bir kayıt var')
        ->with('mesaj_tur', 'danger');
    }

    $sssDil = SSSDil::create([
        'sss_id' => $sss,
        'dil_id' => $data['dil_id'],
        'baslik' => $data['baslik'],
        'aciklama' => $data['aciklama']
    ]);

    if(request()->hasFile('icon')){
        $icon = request()->icon;
        $dosyadi =  Str::slug($sssBul['baslik']) . $sss. "-" . Str::random(5) . "." . $icon->extension();

        if($icon->isValid()){
            $icon->move('uploads/gorseller', $dosyadi);

            SSSDil::find($sssDil->id)->update([
                'icon' => '/uploads/gorseller/'.$dosyadi
            ]);
        }
    }

    return redirect()->route('admin.sssDil', $sss)
    ->with('mesaj', 'SSS dili oluşturuldu')
    ->with('mesaj_tur', 'success');
}

public function guncelleSayfa($sss, $id){
    $sssDil = SSSDil::where('id', $id)->firstOrFail();
    $sss = SSS::find($sss);
    $diller = Dil::orderBy('created_at', 'DESC')->get();

    return view('admin.site.sssDil.guncelle', compact('sssDil', 'sss', 'diller'));
}

public function guncelle($sss, $id){
    $data = request()->all();

    $sssBul = SSS::find($sss);

    $sssDil = SSSDil::find($id)->update([ 
        'baslik' => $data['baslik'],
        'aciklama' => $data['aciklama']
        
    ]);
    if(request()->hasFile('icon')){
        $icon = request()->icon;
        $dosyadi =  $sssBul['baslik'] .'.'. $sssDil . "-"  . Str::random(5) . "." . $icon->extension();
        if($icon->isValid()){
            $icon->move('uploads/gorseller', $dosyadi);
            SSSDil::find($id)->update([
                'icon' => '/uploads/gorseller/'.$dosyadi
            ]);
        }
    }

    return redirect()->route('admin.sssDil', ['sss' => $sss, 'id' => $id])
    ->with('mesaj', 'SSS dili güncellendi')
    ->with('mesaj_tur', 'success');
}

public function sil($sss, $id){
    SSSDil::destroy($id);

    return back()
    ->with('mesaj', 'SSS dili silindi.')
    ->with('mesaj_tur', 'success');
}

}
