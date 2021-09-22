<?php

namespace App\Http\Controllers\Tanitim;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FonksiyonlarController; 
use Cookie;
use App\Models\Site\{SSS, SSSDetay, SSSDil, SSSDetayDil};

class YardimController extends Controller
{
    public function sss(){
        $sssler = SSS::where('durum', 1)->orderBy('sira', 'asc')->get();

        return view('tanitim.sss.sss', compact('sssler'));

    }

    public function SSSDetay($sss){
        $sss = SSS::where('slug', $sss)->where('durum', 1)->first();
        return view('tanitim.sss.detay', compact('sss'));

    }
    public function search(){

        $aranan = request()->input('soru_aranan');
        $sssler = SSS::where('baslik', 'like', "%$aranan%")->where('durum', 1)->get();
        return view('tanitim.sss.search', compact('sssler'));

    }

}
