<?php

namespace App\Http\Controllers\Tanitim;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\{Bulten};
class BultenController extends Controller
{
    public function index(){
       $bulten = Bulten::orderBy('created_at', 'asc')->get()
       return view('admin.etkilesim.bulten', compact('bulten'));
   }
}
