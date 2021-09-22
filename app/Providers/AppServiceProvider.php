<?php

namespace App\Providers;

use App\Http\Controllers\Controller;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\{Kategori, UlkeKod, Ulke, Dil, Urun, Yorum};
use App\Models\Site\{SiteIletisim, SiteSosyalMedya,Sozlesmeler};
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        View::composer('*', function($view)
        {
            $kategoriler = Kategori::where('durum', 1)->where('ust_id', 0)->orderBy('sira', 'asc')->get();
            $iletisim = SiteIletisim::first();
            $sosyalMedya = SiteSosyalMedya::first();
            
           /*$ip = $_SERVER['REMOTE_ADDR'];
           $ulkeKod = \Location::get($ip)->countryCode;*/
           $ip = 1111;
           $ulkeKod = "TR";


           $sozlesmeler = Sozlesmeler::orderBy('created_at', 'desc')->get();
           $sozlesmelerCookie = Sozlesmeler::where('cookie_durum', 1)->orderBy('created_at', 'desc')->get();
           $sozlesmelerRegister = Sozlesmeler::where('kayit_durum', 1)->orderBy('created_at', 'desc')->get();
           
           $ulkeKod = UlkeKod::where('kod', $ulkeKod)->first();
           $ulke = Ulke::where('ulke_kod_id', $ulkeKod->id)->first();
           $paraSimge = $ulke->para_birimi_getir['simge'];
           $menuDil = Dil::where('ulke_kod_id', $ulke->ulke_kod_id)->where('deleted_at', null)->where('durum', 1)->get();
           $view
           ->with('kategoriler', $kategoriler) 
           ->with('menuDil', $menuDil) 
           ->with('iletisim', $iletisim)
           ->with('sozlesmeler', $sozlesmeler)
           ->with('sozlesmelerCookie', $sozlesmelerCookie)
           ->with('sozlesmelerRegister', $sozlesmelerRegister)
           ->with('sosyalMedya', $sosyalMedya)
           ->with('paraSimge', $paraSimge);
       });

    }
}
