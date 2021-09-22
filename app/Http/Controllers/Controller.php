<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\GenelFonksiyonlar;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Cookie;
use Auth;
use App\Models\{Ulke, UlkeKod, Ziyaretci, ZiyaretciUser, Sepet};
use Illuminate\Support\Str;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function __construct(){
    $ziyaretciId = Cookie::get('ziyaretci_id');

    if(!isset($ziyaretciId)){

        $ipUlke = GenelFonksiyonlar::getIp();
        $ip = $ipUlke['ip'];
        $ulkeKod = $ipUlke['ulkeKod'];

        $ulkeKod = UlkeKod::where('kod', $ulkeKod)->first();
        $ulke = Ulke::where('ulke_kod_id', $ulkeKod->id)->first();

        if(isset($ulke)){
            $ziyaretci = Ziyaretci::create([
                'ip' => $ip,
                'ulke_id' => $ulke->id,
                'dil_id' => $ulke->dil_id,
                'token' => time() . Str::random(60)
            ]);

        }else{
            $dil = Dil::where('kod', 'TR')->first();
            $ziyaretci = Ziyaretci::create([
                'ip' => $ip,
                'dil_id' => $dil->id,
                'token' => time() . Str::random(60)
                
            ]);
        }
        $sepet = Sepet::where('ziyaretci_id', $ziyaretci->id)->orderBy('created_at','desc')->first();
        if (!isset($sepet)) {
            Sepet::create([
                'ziyaretci_id' => $ziyaretci->id,
                'ulke_id' => $ulke->id 
            ]);
        }

        Cookie::queue('ziyaretci_id', $ziyaretci->id);


        if (Auth::check()) {
            ZiyaretciUser::create([
                'user_id' => Auth::check()->id,
                'ziyaretci_id' => $ziyaretci->id
            ]);
        }
    }

}

public function ziyaretciDili(){
    $ziyaretciId = Cookie::get('ziyaretci_id');
    $ziyaretci = Ziyaretci::where('id', $ziyaretciId)->first();
    $dil = $ziyaretci->dil_id;
    return $dil;
}

}
