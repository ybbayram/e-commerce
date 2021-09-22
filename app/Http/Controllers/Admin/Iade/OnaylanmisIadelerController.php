<?php

namespace App\Http\Controllers\Admin\Iade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{IadeTalepleri, IadeKod,OnaylanmisIadeler};

class OnaylanmisIadelerController extends Controller
{
    public function index(){
        $iadeler = OnaylanmisIadeler::orderByDesc('created_at')->get();

        return view('admin.iade.onaylanmisIadeler.index', compact( 'iadeler' ));
    }

    public function ode($id)
    {
        $iade = OnaylanmisIadeler::find($id);
        $iade->durum = 1;
        $iade->save();

        return back()
        ->with('mesaj', 'İade parası ödendi.')
        ->with('mesaj_tur', 'success');
    }

    public function geri($id)
    {
        $iade = OnaylanmisIadeler::find($id);
        $iade->durum = 0;
        $iade->save();

        return back()
        ->with('mesaj', 'İade parası geri çekildi.')
        ->with('mesaj_tur', 'success');
    }

}
