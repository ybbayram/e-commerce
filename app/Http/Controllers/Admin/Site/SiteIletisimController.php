<?php

namespace App\Http\Controllers\Admin\Site;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\Site\{SiteIletisim};


class SiteIletisimController extends AdminController
{

    public function index(){
        $iletisim = SiteIletisim::first();
        if (!isset($iletisim)) {
            SiteIletisim::create(['telefon' => 0]);
        }
        return view('admin.site.iletisim', compact('iletisim'));
    }  

    public function guncelle($id){
        $data = request()->all();

        SiteIletisim::where('id', $id)->update([
            'telefon'=>$data['telefon'],
            'mail'=>$data['mail'],
            'adres'=>$data['adres']
        ]);
        return back();

    }   

}
