<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\{IadeTalepleri, IadeSorular};
use App\User;

class IadeController extends Controller
{
    public function iadeTalep(Request $request){
        $data = $request->all();
        $giris = $data['giris'];
        $veri = $data['veri'];

        if($giris['guvenlik_bir'] == 153 and $giris['guvenlik_iki'] == 7825810){
            $user = User::where('user_token', $veri['user_token'])->first();
            $iade = IadeTalepleri::create([
                'user_id' => $user->id,
                'siparis_id' =>$veri['siparis_id'],
                'iade_sebebi' =>$veri['iade_sebebi'],
                'aciklama' =>$veri['aciklama']
            ]);
            
            if(request()->hasFile('gorsel')){
                $gorsel = request()->gorsel;
                $dosyadi =  $iade['id'] . "1" . "-" . Str::random(6) . "." . $gorsel->extension();
    
                if($gorsel->isValid()){
                    $gorsel->move('uploads/gorseller', $dosyadi);
    
    
                    IadeTalepleri::find($iade->id)->update([
                        'gorsel' => '/uploads/gorseller/'.$dosyadi
                    ]);
                }
            }
            
            if(request()->hasFile('gorsel2')){
                $gorsel = request()->gorsel2;
                $dosyadi = $iade['id'] . "2-" . Str::random(6) . "." . $gorsel->extension();
    
    
                if($gorsel->isValid()){
                    $gorsel->move('uploads/gorseller', $dosyadi);
    
                    IadeTalepleri::find($iade->id)->update([
                        'gorsel2' => '/uploads/gorseller/'.$dosyadi
                    ]);
                }
            }
            return response()->json(['response'=>"1"]);
        }
        
    }

    public function iptal(Request $request)
    {
        $data = $request->all();
        $giris = $data['giris'];
        $veri = $data['veri'];
        
        if($giris['guvenlik_bir'] == 153 and $giris['guvenlik_iki'] == 7825810){
            IadeTalepleri::destroy($veri['id']);
        }

        return back();
    }
    
    public function iadeSebepleri(Request $request)
    {
        $data = $request->all();
        $giris = $data['giris'];
        $veri = $data['veri'];
        
        if($giris['guvenlik_bir'] == 153 and $giris['guvenlik_iki'] == 7825810){
    		$iadeSorular = IadeSorular::where('durum', 1)->get();
    		
    		return response()->json(['iadeSorular'=>$iadeSorular]);
        }
        

   
    }
}
