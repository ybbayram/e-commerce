<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\{Ziyaretci};
use App\Models\Site\{SSS, SSSDetay, SSSDil, SSSDetayDil};

class SssController extends ApiController
{
    public function ssSorular(Request $request){
        $data = $request->all();
        $giris = $data['giris'];
        $veri = $data['veri'];

        if($giris['guvenlik_bir'] == 153 and $giris['guvenlik_iki'] == 7825810){
            $ziyaretci = Ziyaretci::where('token', $veri['token'])->first();

            $sss = SSS::join('sss_dil', 'sss.id', '=', 'sss_dil.sss_id')
            ->where('sss_dil.deleted_at', '=', null)
            ->where('sss_dil.dil_id', $ziyaretci->dil_id)
            ->where('sss.durum', 1)
            ->select('sss.slug', 'sss_dil.icon', 'sss_dil.baslik', 'sss_dil.aciklama')
            ->get();

            return response()->json(['sss' => $sss]);
        }
    }

    public function ssSorularTumu(Request $request){
        $data = $request->all();
        $giris = $data['giris'];
        $veri = $data['veri'];

        if($giris['guvenlik_bir'] == 153 and $giris['guvenlik_iki'] == 7825810){
            $ziyaretci = Ziyaretci::where('token', $veri['token'])->first();

            $sssTumu = SSSDetay::join('sss_detay_dil', 'sss_detay.id', '=', 'sss_detay_dil.sss_detay_id')
            ->where('sss_detay_dil.deleted_at', '=', null)
            ->where('sss_detay_dil.dil_id', $ziyaretci->dil_id)
            ->where('sss_detay.durum', 1)
            ->select('sss_detay_dil.baslik', 'sss_detay_dil.aciklama')
            ->paginate(5);

            return response()->json(['sssTumu' => $sssTumu]);
        }
    }



    public function ssSorularGrup(Request $request){
        $data = $request->all();
        $giris = $data['giris'];
        $veri = $data['veri'];

        if($giris['guvenlik_bir'] == 153 and $giris['guvenlik_iki'] == 7825810){
            $ziyaretci = Ziyaretci::where('token', $veri['token'])->first();

            $sss = SSS::whereSlug($veri['slug'])->first();

            $sssGrup = SSSDetay::join('sss_detay_dil', 'sss_detay.id', '=', 'sss_detay_dil.sss_detay_id')
            ->where('sss_detay_dil.deleted_at', '=', null)
            ->where('sss_detay_dil.dil_id', $ziyaretci->dil_id)
            ->where('sss_detay.durum', 1)
            ->where('sss_detay.sss_id', $sss->id)
            ->select('sss_detay_dil.baslik', 'sss_detay_dil.aciklama')
            ->paginate(5);

            return response()->json(['sssGrup' => $sssGrup]);
        }
    }

    public function ssSorularSearch(Request $request){
        $data = $request->all();
        $giris = $data['giris'];
        $veri = $data['veri'];

        if($giris['guvenlik_bir'] == 153 and $giris['guvenlik_iki'] == 7825810){
            $ziyaretci = Ziyaretci::where('token', $veri['token'])->first();
            $aranan = $veri['aranan'];

            $sssSearch = SSSDetay::join('sss_detay_dil', 'sss_detay.id', '=', 'sss_detay_dil.sss_detay_id')
            ->where('sss_detay_dil.deleted_at', '=', null)
            ->where('sss_detay_dil.dil_id', $ziyaretci->dil_id)
            ->where('sss_detay.durum', 1)
            ->where('sss_detay_dil.baslik', 'like', "%$aranan%")
            ->select('sss_detay_dil.baslik', 'sss_detay_dil.aciklama')
            ->paginate(5);

            return response()->json(['sssSearch' => $sssSearch]);
        }
    }
}
