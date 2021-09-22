<?php

namespace App\Http\Controllers\Admin\Site;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\Site\{SiteSosyalMedya};

class SiteSosyalMedyaController extends AdminController
{ 
    public function index(){
        $sosyal = SiteSosyalMedya::first();
        if (!isset($sosyal)) {
            SiteSosyalMedya::create(['instagram' => ""]);
        }
        return view('admin.site.sosyalMedya', compact('sosyal'));
    }
    public function guncelle($id){
        $data = request()->all();

        SiteSosyalMedya::where('id', $id)->update([
            'instagram'=>$data['instagram'],
            'facebook'=>$data['facebook'],
            'youtube'=>$data['youtube'],
            'linkedin'=>$data['linkedin'],
            'pinterest'=>$data['pinterest'],
            'twitter'=>$data['twitter']
        ]);
        return back();
    }   

}
