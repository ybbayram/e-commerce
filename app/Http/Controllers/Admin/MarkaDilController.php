<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\{Marka, MarkaDil, Dil};
use Illuminate\Support\Str;

class MarkaDilController extends AdminController
{

    public function index($marka){
        $markaDil = MarkaDil::where('marka_id', $marka)->orderByDesc('created_at')->get();
        $marka = Marka::find($marka);


        return view('admin.markaDil.index', compact('markaDil', 'marka'));
    }

    public function olustur($marka){
        $data = request()->all();
        $markaBul = Marka::find($marka);
        $dilKontrol = MarkaDil::where('dil_id', $data['dil_id'])->where('marka_id', $marka)->first();
        if(isset($dilKontrol)){
            return back()
            ->with('mesaj', 'Bu dil için zaten bir kayıt var')
            ->with('mesaj_tur', 'danger');
        }

        $markaDil = MarkaDil::create([
            'marka_id' => $marka,
            'aciklama' => $data['aciklama'],
            'dil_id' => $data['dil_id'],
        ]);

        if(request()->hasFile('gorsel')){
            $gorsel = request()->gorsel;
            $dosyadi =  Str::slug($markaBul['ad']) . $markaDil['id'] . "-" . Str::random(5) . "." . $gorsel->extension();

            if($gorsel->isValid()){
                $gorsel->move('uploads/gorseller', $dosyadi);

                MarkaDil::find($markaDil->id)->update([
                    'gorsel' => '/uploads/gorseller/'.$dosyadi
                ]);
            }
        }

        if(request()->hasFile('logo')){
            $logo = request()->logo;
            $dosyadi =  Str::slug($markaBul['ad']) . $markaDil['id'] . "-" . Str::random(5) . "." . $logo->extension();

            if($logo->isValid()){
                $logo->move('uploads/logo', $dosyadi);

                MarkaDil::find($markaDil->id)->update([
                    'logo' => '/uploads/logo/'.$dosyadi
                ]);
            }
        }

        return redirect()->route('admin.markaDil', $marka)
        ->with('mesaj', 'Marka dili oluşturuldu')
        ->with('mesaj_tur', 'success');
    }

    public function olusturSayfa($marka){
        $marka = Marka::find($marka);
        $diller = Dil::orderBy('created_at', 'DESC')->get();

        return view('admin.markaDil.olustur', compact('marka', 'diller'));
    }

    public function guncelleSayfa($marka, $id){
        $markaDil = MarkaDil::where('id', $id)->firstOrFail();
        $marka = Marka::find($marka);
        $diller = Dil::orderBy('created_at', 'DESC')->get();

        return view('admin.markaDil.guncelle', compact('markaDil', 'marka', 'diller'));
    }

    public function guncelle($marka, $id){
        $data = request()->all();
        $markaBul = Marka::find($marka);

        $markaDil = MarkaDil::find($id)->update([
            'aciklama' => $data['aciklama'], 
        ]);

        if(request()->hasFile('gorsel')){
            $gorsel = request()->gorsel;
            
            $dosyadi =  $markaBul['slug'] .'.'. $markaDil . "-"  . Str::random(5) . "." . $gorsel->extension();
            if($gorsel->isValid()){
                $gorsel->move('uploads/gorseller', $dosyadi);

                MarkaDil::find($id)->update([
                    'gorsel' => '/uploads/gorseller/'.$dosyadi
                ]);
            }
        }

        if(request()->hasFile('logo')){
            $logo = request()->logo;
            
            $dosyadi =  $markaBul['slug'] .'.'. $markaDil . "-"  . Str::random(5) . "." . $logo->extension();
            if($logo->isValid()){
                $logo->move('uploads/logo', $dosyadi);

                MarkaDil::find($id)->update([
                    'logo' => '/uploads/logo/'.$dosyadi
                ]);
            }
        }
        return redirect()->route('admin.markaDil', ['marka' => $marka, 'id' => $id])
        ->with('mesaj', 'Marka dili güncellendi')
        ->with('mesaj_tur', 'success');
    }

    public function sil($id, $marka){
        MarkaDil::destroy($id);

        return back()
        ->with('mesaj', 'Marka dili silindi.')
        ->with('mesaj_tur', 'success');
    }
}
