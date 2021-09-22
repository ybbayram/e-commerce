<?php

namespace App\Http\Controllers\Admin\Site;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\Site\{SiteBanner, SiteBannerDil};
use App\Models\{Dil};
use Illuminate\Support\Str;

class SiteBannerDilController extends AdminController
{

    public function index($banner){
        $bannerDil = SiteBannerDil::where('banner_id', $banner)->orderByDesc('created_at')->get();
        $banner = SiteBanner::find($banner);

        return view('admin.site.bannerDil.index', compact('bannerDil', 'banner'));
    }

    public function olustur($banner){
       $data = request()->all();
       $bannerBul = SiteBanner::find($banner);
       $dilKontrol = SiteBannerDil::where('dil_id', $data['dil_id'])->where('banner_id', $banner)->first();
       if(isset($dilKontrol)){
        return back()
        ->with('mesaj', 'Bu dil için zaten bir kayıt var')
        ->with('mesaj_tur', 'danger');
    }

    $bannerDil = SiteBannerDil::create([
        'banner_id' => $banner,
        'dil_id' => $data['dil_id'],
        'baslik' => $data['baslik'],  
        'buton_link' => $data['buton_link']
    ]);

    if(request()->hasFile('gorsel')){
        $gorsel = request()->gorsel;
        $dosyadi =  Str::slug($bannerBul['ad']) . $bannerDil['id'] . "-" . Str::random(5) . "." . $gorsel->extension();

        if($gorsel->isValid()){
            $gorsel->move('uploads/gorseller', $dosyadi);

            SiteBannerDil::find($bannerDil->id)->update([
                'gorsel' => '/uploads/gorseller/'.$dosyadi
            ]);
        }
    }

    return redirect()->route('admin.site.bannerDil', $banner)
    ->with('mesaj', 'Banner dili oluşturuldu')
    ->with('mesaj_tur', 'success');
}

public function olusturSayfa($banner){
    $banner = SiteBanner::find($banner);
    $diller = Dil::orderBy('created_at', 'DESC')->get();

    return view('admin.site.bannerDil.olustur', compact('banner', 'diller'));
}

public function guncelleSayfa($banner, $id){
    $bannerDil = SiteBannerDil::where('id', $id)->firstOrFail();
    $banner = SiteBanner::find($banner);
    $diller = Dil::orderBy('created_at', 'DESC')->get();

    return view('admin.site.bannerDil.guncelle', compact('bannerDil', 'banner', 'diller'));
}

public function guncelle($banner, $id){
    $data = request()->all();
    $sliderBul = SiteBanner::find($banner);

    $bannerDil = SiteBannerDil::find($id)->update([ 
        'baslik' => $data['baslik'], 
        'buton_link' => $data['buton_link']
        
    ]);
    if(request()->hasFile('gorsel')){
        $gorsel = request()->gorsel;
        $dosyadi =  $sliderBul['ad'] .'.'. $bannerDil . "-"  . Str::random(5) . "." . $gorsel->extension();
        if($gorsel->isValid()){
            $gorsel->move('uploads/gorseller', $dosyadi);
            SiteBannerDil::find($id)->update([
                'gorsel' => '/uploads/gorseller/'.$dosyadi
            ]);
        }
    }

    return redirect()->route('admin.site.bannerDil', ['banner' => $banner, 'id' => $id])
    ->with('mesaj', 'Slider dili güncellendi')
    ->with('mesaj_tur', 'success');
}

public function sil($banner, $id){
    SiteBannerDil::destroy($id);

    return back()
    ->with('mesaj', 'Slider dili silindi.')
    ->with('mesaj_tur', 'success');
}

}
