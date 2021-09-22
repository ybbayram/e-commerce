<?php

namespace App\Http\Controllers\Admin\Iade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{IadeTalepleri, IadeKod, OnaylanmisIadeler, Siparis};
use Illuminate\Support\Str;

class IadelerController extends Controller
{
 public function index(){
    $iadeler = IadeTalepleri::orderByDesc('created_at')->get();

    return view('admin.iade.iadeler.index', compact( 'iadeler' ));
}
public function detaySayfa($id){
    $iade = IadeTalepleri::where('id', $id)->first();

    return view('admin.iade.iadeler.detay', compact( 'iade' ));
}
public function onayla($id)
{
    $kargo = 'PH-' . 'k-' . Str::random(3) . rand(1,10) . Str::random(3); 
    $iade = IadeTalepleri::find($id);
    $iade->durum = 1;
    $iade->save();
    IadeKod::create([
        'iade_id' => $iade->id,
        'kargo_firma_id' => "1", 
        'kargo_kod' => $kargo
    ]);
    OnaylanmisIadeler::create([
        'iade_id'=> $iade->id
    ]);
    
    $siparis = Siparis::where('id', $iade->siparis_id)->first();
    $siparis->update(['islem_durum' => 9]);
    
    return back()
    ->with('mesaj', 'İade onaylandı.')
    ->with('mesaj_tur', 'success');
}

public function red($id)
{
    $iade = IadeTalepleri::find($id);
    $iade->durum = 2;
    $iade->save();

    return back()
    ->with('mesaj', 'İade reddedildi.')
    ->with('mesaj_tur', 'success');
}
}
