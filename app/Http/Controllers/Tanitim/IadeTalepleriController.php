<?php

namespace App\Http\Controllers\Tanitim;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\{IadeTalepleri};

class IadeTalepleriController extends Controller
{
    public function iadeTalep($siparis_id, $user_id){
        $data = request()->all();
        $iade = IadeTalepleri::create([
            'user_id' =>$user_id,
            'siparis_id' =>$siparis_id,
            'iade_sebebi' =>$data['talep'],
            'aciklama' =>$data['aciklama']
        ]);
        if(request()->hasFile('gorsel')){
            $gorsel = request()->gorsel;
            $dosyadi =  $data['talep'] . "-" . Str::random(5) . "." . $gorsel->extension();

            if($gorsel->isValid()){
                $gorsel->move('uploads/gorseller', $dosyadi);


                IadeTalepleri::find($iade->id)->update([
                    'gorsel' => '/uploads/gorseller/'.$dosyadi
                ]);
            }
        }
        if(request()->hasFile('gorsel2')){
            $gorsel = request()->gorsel2;
            $dosyadi =  $data['talep'] . "-2-" . Str::random(5) . "." . $gorsel->extension();


            if($gorsel->isValid()){
                $gorsel->move('uploads/gorseller', $dosyadi);

                IadeTalepleri::find($iade->id)->update([
                    'gorsel2' => '/uploads/gorseller/'.$dosyadi
                ]);
            }
        }
        return back();
    }

    public function iptal($id)
    {
        IadeTalepleri::destroy($id);
        

        return back();
    }
}
