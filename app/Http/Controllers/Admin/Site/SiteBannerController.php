<?php

namespace App\Http\Controllers\Admin\Site;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\Site\{SiteBanner};

class SiteBannerController extends AdminController
{

  public function index(){
   $banner = SiteBanner::orderByDesc('created_at')->get();
   return view('admin.site.banner.index', compact('banner'));
}
public function olusturSayfa(){ 
    return view('admin.site.banner.olustur');

}
public function olustur()
{
    $data = request()->all();
    $sira = 0;
    $bannerSira = SiteBanner::orderBy('sira', 'desc')->first();

    if (isset($bannerSira)) {
        $sira = $bannerSira->sira + 1;
    }
    $banner = SiteBanner::create([
        'ad' => $data['ad'], 
        'sira' => $sira 
    ]);
    return redirect()->route('admin.site.banner')
    ->with('mesaj', 'Banner oluşturuldu')
    ->with('mesaj_tur', 'success');
}
public function guncelleSayfa($id)
{  
    $banner = SiteBanner::where('id', $id)->firstOrFail(); 

    return view('admin.site.banner.guncelle', compact('banner'));
}

public function guncelle($id)
{
    $data = request()->all(); 

    $banner = SiteBanner::find($id)->update([
        'ad' => $data['ad']
    ]);
    return redirect()->route('admin.site.banner')
    ->with('mesaj', 'Banner güncellendi')
    ->with('mesaj_tur', 'success');
}

public function sil($id)
{
    SiteBanner::destroy($id);

    return back()
    ->with('mesaj', 'Banner silindi.')
    ->with('mesaj_tur', 'success');
}

public function siralaSayfa()
{
    $banner = SiteBanner::orderBy('sira', 'ASC')->get();

    return view('admin.site.banner.sirala', compact('banner'));
}

public function sirala()
{
    $data = request()->all();
    $count = 0;
    $json = $data['json'];

    $rooms = json_decode($json, true);


    foreach ($rooms as $entry) {
        SiteBanner::where('id', $entry['id'])->update([
            'sira' => $count,
        ]);
        $count++;
    }

    return redirect()->route('admin.site.banner')
    ->with('mesaj', 'Banner sırası güncellendi')
    ->with('mesaj_tur', 'success');
}
public function aktifYap($id)
{
    $banner = SiteBanner::find($id);
    $banner->durum = 1;
    $banner->save();

    return back()
    ->with('mesaj', 'Banner durumu aktif yapıldı.')
    ->with('mesaj_tur', 'success');
}

public function pasifYap($id)
{
    $banner = SiteBanner::find($id);
    $banner->durum = 0;
    $banner->save();

    return back()
    ->with('mesaj', 'Banner durumu pasif yapıldı.')
    ->with('mesaj_tur', 'success');
}


}
