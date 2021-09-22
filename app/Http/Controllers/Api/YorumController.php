<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\{Urun, Yorum, Ziyaretci};
use App\User;

class YorumController extends ApiController
{
    public function urunYorum(Request $request){
        $data = $request->all();
        $giris = $data['giris'];
        $veri = $data['veri'];

        if($giris['guvenlik_bir'] == 153 and $giris['guvenlik_iki'] == 7825810){
            $urun = Urun::whereSlug($veri['slug'])->first();
            $yorumlar = Yorum::join('users', 'yorum.user_id', '=', 'users.id')
            ->where('urun_id',$urun->id)->where('durum',1)
            ->orderBy('yorum.oy', 'desc')
            ->select('yorum.id', 'yorum.oy', 'yorum.yorum', 'yorum.updated_at', 'users.ad as user_ad')
            ->paginate(16);

            return response()->json(['yorumlar' => $yorumlar]);
        }
    }

    public function yorumYap(Request $request){
        $data = $request->all();
        $giris = $data['giris'];
        $veri = $data['veri'];

        if($giris['guvenlik_bir'] == 153 and $giris['guvenlik_iki'] == 7825810){

            $user = User::where('user_token', $veri['user_token'])->first();
            $urun = Urun::whereSlug($veri['slug'])->first();

            $yorum = Yorum::create([
                'user_id' => $user->id,
                'urun_id' => $urun->id,
                'oy' => $veri['oy'],
                'yorum' => $veri['yorum'],
                'durum' => 1
            ]); 
            return response()->json(['response' => 1]);
        }
    }

    public function yorumGuncelle(Request $request){
        $data = $request->all();
        $giris = $data['giris'];
        $veri = $data['veri'];

        if($giris['guvenlik_bir'] == 153 and $giris['guvenlik_iki'] == 7825810){

           Yorum::find($veri['yorum_id'])->update([
                'oy' => $veri['oy'],
                'yorum' => $veri['yorum'],
                'durum' => 0
            ]); 
            return response()->json(['response' => 1]);
        }
    }

    public function yorumSil(Request $request){
        $data = $request->all();
        $giris = $data['giris'];
        $veri = $data['veri'];

        if($giris['guvenlik_bir'] == 153 and $giris['guvenlik_iki'] == 7825810){

           Yorum::destroy($veri['yorum_id']);

            return response()->json(['response' => 1]);
        }
    }
    
    public function degerlendirmelerim(Request $request){
        $data = $request->all();
        $giris = $data['giris'];
        $veri = $data['veri'];

        if($giris['guvenlik_bir'] == 153 and $giris['guvenlik_iki'] == 7825810){
            $user = User::where('user_token', $veri['user_token'])->first();
            $ziyaretci = Ziyaretci::where('token', $veri['token'])->first();

            $yorumlar = Yorum::join('urun', 'yorum.urun_id', '=', 'urun.id')
            ->join('urun_detay', 'urun.id', '=', 'urun_detay.urun_id')
            ->where('urun.deleted_at', '=', null)
            ->where('urun_detay.deleted_at', '=', null)
            ->where('urun_detay.dil_id', $ziyaretci->dil_id)
            ->where('yorum.user_id', $user->id)
            ->select('yorum.id', 'urun.slug', 'urun_detay.ad', 'yorum.oy', 'yorum.yorum')
            ->paginate(16);

            return response()->json(['yorumlar' => $yorumlar]);
        }
    }
    
    public function urunDetayYorum(Request $request){
        $data = $request->all();
        $giris = $data['giris'];
        $veri = $data['veri'];

        if($giris['guvenlik_bir'] == 153 and $giris['guvenlik_iki'] == 7825810){
            $urun = Urun::whereSlug($veri['slug'])->first();
             $yorumlar = Yorum::join('users', 'yorum.user_id', '=', 'users.id')
                ->where('urun_id',$urun->id)->where('durum',1)
                ->orderBy('yorum.oy', 'desc')
                ->select('yorum.id', 'yorum.oy', 'yorum.yorum', 'yorum.updated_at', 'users.ad as user_ad')
                ->paginate(4);

            return response()->json(['yorumlar' => $yorumlar]);
        }
    }
}
