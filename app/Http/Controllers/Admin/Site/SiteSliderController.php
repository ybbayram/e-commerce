<?php

namespace App\Http\Controllers\Admin\Site;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\Site\{SiteSlider};

class SiteSliderController extends AdminController
{
  public function index(){
     $slider = SiteSlider::orderByDesc('created_at')->get();
     return view('admin.site.slider.index', compact('slider'));
 }
 public function olusturSayfa(){ 
    return view('admin.site.slider.olustur');

}
public function olustur()
{
    $data = request()->all();
    $sira = 0;
    $sliderSira = SiteSlider::orderBy('sira', 'desc')->first();

    if (isset($sliderSira)) {
        $sira = $sliderSira->sira + 1;
    }
    $slider = SiteSlider::create([
        'ad' => $data['ad'], 
        'sira' => $sira 
    ]);
    return redirect()->route('admin.site.slider')
    ->with('mesaj', 'Slider oluşturuldu')
    ->with('mesaj_tur', 'success');
}
public function guncelleSayfa($id)
{  
    $slider = SiteSlider::where('id', $id)->firstOrFail(); 

    return view('admin.site.slider.guncelle', compact('slider'));
}

public function guncelle($id)
{
    $data = request()->all(); 

    $slider = SiteSlider::find($id)->update([
        'ad' => $data['ad']
    ]);
    return redirect()->route('admin.site.slider')
    ->with('mesaj', 'Slider güncellendi')
    ->with('mesaj_tur', 'success');
}

public function sil($id)
{
    SiteSlider::destroy($id);

    return back()
    ->with('mesaj', 'Slider silindi.')
    ->with('mesaj_tur', 'success');
}

public function siralaSayfa()
{
    $slider = SiteSlider::orderBy('sira', 'ASC')->get();

    return view('admin.site.slider.sirala', compact('slider'));
}

public function sirala()
{
    $data = request()->all();
    $count = 0;
    $json = $data['json'];

    $rooms = json_decode($json, true);


    foreach ($rooms as $entry) {
        SiteSlider::where('id', $entry['id'])->update([
            'sira' => $count,
        ]);
        $count++;
    }

    return redirect()->route('admin.site.slider')
    ->with('mesaj', 'Slider sırası güncellendi')
    ->with('mesaj_tur', 'success');
}
public function aktifYap($id)
{
    $slider = SiteSlider::find($id);
    $slider->durum = 1;
    $slider->save();

    return back()
    ->with('mesaj', 'slider durumu aktif yapıldı.')
    ->with('mesaj_tur', 'success');
}

public function pasifYap($id)
{
    $slider = SiteSlider::find($id);
    $slider->durum = 0;
    $slider->save();

    return back()
    ->with('mesaj', 'slider durumu pasif yapıldı.')
    ->with('mesaj_tur', 'success');
}


}
