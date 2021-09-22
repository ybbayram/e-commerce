<?php

namespace App\Http\Controllers\Admin\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Site\{SiteBanner2};
use App\Models\{Dil};
use Illuminate\Support\Str;

class SiteBanner2Controller extends Controller
{
    public function index(){
        $banner = SiteBanner2::orderByDesc('created_at')->get();

        return view('admin.site.banner2.index', compact( 'banner'));
    }

    public function olustur(){
        $data = request()->all();
        $dilKontrol = SiteBanner2::where('dil_id', $data['dil_id'])->first();
        if(isset($dilKontrol)){
            return back()
            ->with('mesaj', 'Bu dil için zaten bir kayıt var')
            ->with('mesaj_tur', 'danger');
        }

        $bannerDil = SiteBanner2::create([ 
            'dil_id' => $data['dil_id'],
            'baslik' => $data['baslik'],  
            'baslik_alt' => $data['baslik_alt'],  
            'detay' => $data['detay'],  
            'buton_isim' => $data['buton_isim'],
            'buton_link' => $data['buton_link']
        ]);

        if(request()->hasFile('gorsel')){
            $gorsel = request()->gorsel;
            $dosyadi =  Str::slug($bannerDil['baslik']) . $bannerDil['id'] . "-" . Str::random(5) . "." . $gorsel->extension();

            if($gorsel->isValid()){
                $gorsel->move('uploads/gorseller', $dosyadi);

                SiteBanner2::find($bannerDil->id)->update([
                    'gorsel' => '/uploads/gorseller/'.$dosyadi
                ]);
            }
        }

        if(request()->hasFile('gorsel2')){
            $gorsel = request()->gorsel2;
            $dosyadi =  Str::slug($bannerDil['baslik_alt']) . $bannerDil['id'] . "-" . Str::random(5) . "." . $gorsel->extension();

            if($gorsel->isValid()){
                $gorsel->move('uploads/gorseller', $dosyadi);

                SiteBanner2::find($bannerDil->id)->update([
                    'gorsel2' => '/uploads/gorseller/'.$dosyadi
                ]);
            }
        }

        return redirect()->route('admin.site.banner2')
        ->with('mesaj', 'Banner dili oluşturuldu')
        ->with('mesaj_tur', 'success');
    }

    public function olusturSayfa(){ 
        $diller = Dil::orderBy('created_at', 'DESC')->get();

        return view('admin.site.banner2.olustur', compact('diller'));
    }

    public function guncelleSayfa($id){
        $banner = SiteBanner2::where('id', $id)->firstOrFail();
        $diller = Dil::orderBy('created_at', 'DESC')->get();
        return view('admin.site.banner2.guncelle', compact('banner','diller'));
    }

    public function guncelle($id){
        $data = request()->all(); 

        $bannerDil = SiteBanner2::find($id)->update([ 
            'baslik' => $data['baslik'], 
            'baslik_alt' => $data['baslik_alt'], 
            'detay' => $data['detay'], 
            'baslik' => $data['baslik'], 
            'buton_isim' => $data['buton_isim'],
            'buton_link' => $data['buton_link']

        ]);
        if(request()->hasFile('gorsel')){
            $gorsel = request()->gorsel;
            $dosyadi =  $bannerDil .'.'. $bannerDil . "-"  . Str::random(5) . "." . $gorsel->extension();
            if($gorsel->isValid()){
                $gorsel->move('uploads/gorseller', $dosyadi);
                SiteBanner2::find($id)->update([
                    'gorsel' => '/uploads/gorseller/'.$dosyadi
                ]);
            }
        }

        if(request()->hasFile('gorsel2')){
            $gorsel = request()->gorsel2;
            $dosyadi =  $bannerDil .'.'. $id . "-"  . Str::random(5) . "." . $gorsel->extension();
            if($gorsel->isValid()){
                $gorsel->move('uploads/gorseller', $dosyadi);
                SiteBanner2::find($id)->update([
                    'gorsel2' => '/uploads/gorseller/'.$dosyadi
                ]);
            }
        }

        return redirect()->route('admin.site.banner2')
        ->with('mesaj', 'Banner dili güncellendi')
        ->with('mesaj_tur', 'success');
    }

    public function sil($banner, $id){
        SiteBanner2::destroy($id);

        return back()
        ->with('mesaj', 'Banner dili silindi.')
        ->with('mesaj_tur', 'success');
    }

}
