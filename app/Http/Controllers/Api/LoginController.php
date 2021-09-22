<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\GenelFonksiyonlar;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\User;
use App\Models\{Sepet, SepetUrun, ZiyaretciUser, Urun, UrunFiyat, Ziyaretci, Dil, Ulke, UlkeKod, CesitDetay, CesitFiyat};
use Auth;
use Cart;
use Cookie;

class LoginController extends ApiController
{
    public function ziyaretciId(Request $request){
        $data = $request->all();
        $giris = $data['giris'];

        if($giris['guvenlik_bir']==153 and $giris['guvenlik_iki']==7825810){
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

        return response()->json(['token'=>$ziyaretci->token]);
    }else{
        return "false";
    }
    return "false";
}

public function register(Request $request){
    $data = $request->all();
    $giris = $data['giris'];
    $veri = $data['veri'];

    if($giris['guvenlik_bir']==153 and $giris['guvenlik_iki']==7825810){

        $validate = User::where('email', $veri['email'])->first();

        if(isset($validate)){
            return '{"error": 0}';
        }
       

        $ziyaretci = Ziyaretci::where('token', $veri['token'])->first();
        $ziyaretciId = $ziyaretci->id;


        $user = User::create([
            'email' => $veri['email'],
            'password' => Hash::make($veri['password']),
            'ad' => $veri['ad'],
            'user_token' => time() . Str::random(60)
        ]);

        $ziyaretci_user = ZiyaretciUser::create([
            'user_id' => $user->id,
            'ziyaretci_id' => $ziyaretciId,
        ]);
        return response()->json(['user_token'=>$user->user_token]);

    }else{
        return "false";
    }
}

public function login(Request $request){
    $data = $request->all();
    $giris = $data['giris'];
    $veri = $data['veri'];

    if($giris['guvenlik_bir']==153 and $giris['guvenlik_iki']==7825810){

        if(auth()->attempt(['email' => $veri['email'], 'password' => $veri['password']])){
            $userId = auth()->id();
            $user = User::find($userId);

            return response()->json(['user_token'=>$user->user_token]);
        }else{
            return '{"error": 0}';
        }

    }else{
        return "false";
    }
}

public function forgotPassword(Request $request){
    $data = $request->all();
    $giris = $data['giris'];
    $veri = $data['veri'];

    if($giris['guvenlik_bir']==153 and $giris['guvenlik_iki']==7825810){


        return "true";

    }else{
        return "false";
    }
}
}
