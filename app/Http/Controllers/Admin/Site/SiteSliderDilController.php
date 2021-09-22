<?php

namespace App\Http\Controllers\Admin\Site;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\Site\{SiteSlider, SiteSliderDil};
use App\Models\{Dil};
use Illuminate\Support\Str;

class SiteSliderDilController extends AdminController
{
    public function index($slider){
        $sliderDil = SiteSliderDil::where('slider_id', $slider)->orderByDesc('created_at')->get();
        $slider = SiteSlider::find($slider);

        return view('admin.site.sliderDil.index', compact('sliderDil', 'slider'));
    }

    public function olustur($slider){
     $data = request()->all();
     $sliderBul = SiteSlider::find($slider);
     $dilKontrol = SiteSliderDil::where('dil_id', $data['dil_id'])->where('slider_id', $slider)->first();
     if(isset($dilKontrol)){
        return back()
        ->with('mesaj', 'Bu dil için zaten bir kayıt var')
        ->with('mesaj_tur', 'danger');
    }

    $sliderDil = SiteSliderDil::create([
        'slider_id' => $slider,
        'dil_id' => $data['dil_id'],
        'baslik' => $data['baslik'],
        'detay' => $data['detay'],
        'buton_baslik' => $data['buton_baslik'],
        'buton_link' => $data['buton_link']
    ]);

    if(request()->hasFile('gorsel')){
        $gorsel = request()->gorsel;
        $dosyadi =  Str::slug($sliderBul['ad']) . $sliderDil['id'] . "-" . Str::random(5) . "." . $gorsel->extension();

        if($gorsel->isValid()){
            $gorsel->move('uploads/gorseller', $dosyadi);

            SiteSliderDil::find($sliderDil->id)->update([
                'gorsel' => '/uploads/gorseller/'.$dosyadi
            ]);
        }
    }

    if(request()->hasFile('gorsel_mobil')){
        $gorsel = request()->gorsel_mobil;
        $dosyadi =  'mobil'. Str::slug($sliderBul['ad']) . $sliderDil['id'] . "-" . Str::random(5) . "." . $gorsel->extension();

        if($gorsel->isValid()){
            $gorsel->move('uploads/gorseller', $dosyadi);

            SiteSliderDil::find($sliderDil->id)->update([
                'gorsel_mobil' => '/uploads/gorseller/'.$dosyadi
            ]);
        }
    }

    if(request()->hasFile('gorsel_3')){
        $gorsel = request()->gorsel_3;
        $dosyadi =  'mobil'. Str::slug($sliderBul['ad']) . $sliderDil['id'] . "-" . Str::random(5) . "." . $gorsel->extension();

        if($gorsel->isValid()){
            $gorsel->move('uploads/gorseller', $dosyadi);

            SiteSliderDil::find($sliderDil->id)->update([
                'gorsel_3' => '/uploads/gorseller/'.$dosyadi
            ]);
        }
    }

    return redirect()->route('admin.site.sliderDil', $slider)
    ->with('mesaj', 'Marka dili oluşturuldu')
    ->with('mesaj_tur', 'success');
}

public function olusturSayfa($slider){
    $slider = SiteSlider::find($slider);
    $diller = Dil::orderBy('created_at', 'DESC')->get();

    return view('admin.site.sliderDil.olustur', compact('slider', 'diller'));
}

public function guncelleSayfa($slider, $id){
    $sliderDil = SiteSliderDil::where('id', $id)->firstOrFail();
    $slider = SiteSlider::find($slider);
    $diller = Dil::orderBy('created_at', 'DESC')->get();

    return view('admin.site.sliderDil.guncelle', compact('sliderDil', 'slider', 'diller'));
}

public function guncelle($slider, $id){
    $data = request()->all();

    $sliderBul = SiteSlider::find($slider);

    $sliderDil = SiteSliderDil::find($id)->update([ 
        'baslik' => $data['baslik'],
        'detay' => $data['detay'],
        'buton_baslik' => $data['buton_baslik'],
        'buton_link' => $data['buton_link']
        
    ]);
    if(request()->hasFile('gorsel')){
        $gorsel = request()->gorsel;
        $dosyadi =   Str::slug($data['baslik']) .'.'. $sliderDil . "-"  . Str::random(5) . "." . $gorsel->extension();
        if($gorsel->isValid()){
            $gorsel->move('uploads/gorseller', $dosyadi);
            SiteSliderDil::find($id)->update([
                'gorsel' => '/uploads/gorseller/'.$dosyadi
            ]);
        }
    }

    if(request()->hasFile('gorsel_mobil')){
        $gorsel = request()->gorsel_mobil;
        
        $dosyadi =  Str::slug($data['baslik']) . $sliderDil . "-" . Str::random(5) . "." . $gorsel->extension();

        if($gorsel->isValid()){
            $gorsel->move('uploads/gorseller', $dosyadi);

            SiteSliderDil::find($id)->update([
                'gorsel_mobil' => '/uploads/gorseller/'.$dosyadi
            ]);
        }
    }

    if(request()->hasFile('gorsel_3')){
        $gorsel = request()->gorsel_3;
        
        $dosyadi =  Str::slug($data['baslik']) . $sliderDil . "-" . Str::random(5) . "." . $gorsel->extension();

        if($gorsel->isValid()){
            $gorsel->move('uploads/gorseller', $dosyadi);

            SiteSliderDil::find($id)->update([
                'gorsel_3' => '/uploads/gorseller/'.$dosyadi
            ]);
        }
    }
    return redirect()->route('admin.site.sliderDil', ['slider' => $slider, 'id' => $id])
    ->with('mesaj', 'Slider dili güncellendi')
    ->with('mesaj_tur', 'success');
}

public function sil($slider, $id){
    SiteSliderDil::destroy($id);

    return back()
    ->with('mesaj', 'Slider dili silindi.')
    ->with('mesaj_tur', 'success');
}

}
