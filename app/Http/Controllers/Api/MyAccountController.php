<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\GenelFonksiyonlar;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Models\{Siparis, Ziyaretci, SepetUrun, Ulke, UlkeKod};

class MyAccountController extends ApiController
{
    public function ulkeIdBul(){
            $ipUlke = GenelFonksiyonlar::getIp();
            $ip = $ipUlke['ip'];
            $ulkeKod = $ipUlke['ulkeKod'];
            $ulkeKod = UlkeKod::where('kod', $ulkeKod)->first();
            $ulke = Ulke::where('ulke_kod_id', $ulkeKod->id)->first();

            return $ulke->id;
        }
        
    public function hesapDetay(Request $request){
        $data = $request->all();
        $giris = $data['giris'];
        $veri = $data['veri'];

        if($giris['guvenlik_bir'] == 153 and $giris['guvenlik_iki'] == 7825810){
            $user = User::where('user_token', $veri['user_token'])->select('email', 'ad', 'rol', 'created_at')->first();
            return $user;
        }
    }
    
    public function sifreDegistir(Request $request){
        $data = $request->all();
        $giris = $data['giris'];
        $veri = $data['veri'];

        if($giris['guvenlik_bir'] == 153 and $giris['guvenlik_iki'] == 7825810){
            $user = User::where('user_token', $veri['user_token'])->first();

            if (Hash::check($veri['password_eski'], $user->password)) { 
                User::where('id', $user->id)->update([
                    'password' => Hash::make($veri['password']),
                ]);

                return '{"response": 1}';
            }else{
                return '{"response": 0}';
            }
        }
    }
    
    public function siparislerim(Request $request){
        $data = $request->all();
        $giris = $data['giris'];
        $veri = $data['veri'];

        if($giris['guvenlik_bir'] == 153 and $giris['guvenlik_iki'] == 7825810){
        $ziyaretci = Ziyaretci::where('token', $veri['token'])->first();
		$siparislerim = Siparis::where('ziyaretci_id', $ziyaretci->id)->orderBy('created_at', 'desc')->paginate(10);
		
		foreach($siparislerim as $entry){
		    $sepetUrun = $entry->sepet_urun_getir;
		    $entry->odeme_getir;
		    $entry->siparis_sepet_getir->para_simge_getir->para_birimi_getir;
		    foreach($sepetUrun as $entryTwo){
		        $entryTwo->urun_slug;
		        $entryTwo->detay_bul;
		        $entryTwo->gorsel_bul;
		        $entryTwo->cesit_detay_siparis_bul;
		    }
		}
		
		
		return response()->json(['siparislerim'=>$siparislerim]);
        }
	}
}
