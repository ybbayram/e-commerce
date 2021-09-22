<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\{Kategori, KategoriAnaliz};
use Illuminate\Support\Str;

class KategoriController extends AdminController
{
    protected function siraDongu($json, $ust = 0){
        $sira = 0;
        foreach ($json as $entry) {
            $ust = 0;
            if(isset($entry['id'])){
                Kategori::where('id', $entry['id'])->update([
                    'ust_id' => $ust,
                    'sira' => $sira
                ]);
                $sira++;
                if(isset($entry['children'])){
                    foreach($entry['children'] as $entryTwo){
                        $ust = $entry['id'];
                        Kategori::where('id', $entryTwo['id'])->update([
                            'ust_id' => $ust,
                            'sira' => $sira
                        ]);
                        $sira++;
                        if(isset($entryTwo['children'])){
                            foreach($entryTwo['children'] as $entryThree){
                                $ust = $entryTwo['id'];
                                Kategori::where('id', $entryThree['id'])->update([
                                    'ust_id' => $ust,
                                    'sira' => $sira
                                ]);
                                $sira++;
                                if(isset($entryThree['children'])){
                                    foreach($entryThree['children'] as $entryFour){
                                         $ust = $entryThree['id'];
                                        Kategori::where('id', $entryFour['id'])->update([
                                            'ust_id' => $ust,
                                            'sira' => $sira
                                        ]);
                                        $sira++;
                                        if(isset($entryFour['children'])){
                                            foreach($entryFour['children'] as $entryFive){
                                                $ust = $entryFour['id'];
                                                Kategori::where('id', $entryFive['id'])->update([
                                                    'ust_id' => $ust,
                                                    'sira' => $sira
                                                ]);
                                                $sira++;
                                                if(isset($entryFive['children'])){
                                                    foreach($entryFive['children'] as $entrySix){
                                                          $ust = $entryFive['id'];
                                                        Kategori::where('id', $entrySix['id'])->update([
                                                            'ust_id' => $ust,
                                                            'sira' => $sira
                                                        ]);
                                                        $sira++;
                                                        if(isset($entrySix['children'])){
                                                            return "Dal sınırını aştınız.";
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            
        }
    }

    protected function pasifDongu($id){
        $kategori = Kategori::find($id);
        $kategori->update(['ust_id' => 0, 'durum' => 0]);

        foreach($kategori->kategori_alt_getir as $entry){
            $kategoriTwo = Kategori::find($entry->id);
            $kategoriTwo->update(['ust_id' => 0, 'durum' => 0]);
            foreach($kategoriTwo->kategori_alt_getir as $entryTwo){
                $kategoriThree = Kategori::find($entryTwo->id);
                $kategoriThree->update(['ust_id' => 0, 'durum' => 0]);
                foreach($kategoriThree->kategori_alt_getir as $entryThree){
                    $kategoriFour = Kategori::find($entryThree->id);
                    $kategoriFour->update(['ust_id' => 0, 'durum' => 0]);
                    foreach($kategoriFour->kategori_alt_getir as $entryFour){
                        Kategori::find($entryFour->id)->update(['ust_id' => 0, 'durum' => 0]);
                    }
                }
            }
        }
    }

    public function index()
    {
        $adminKategoriler = Kategori::orderByDesc('created_at')->get();

        return view('admin.kategori.index', compact('adminKategoriler'));
    }

    public function olustur(Request $request)
    {
        $data = request()->all();

        $ustId = 0;

        $kontrol = Kategori::where('slug', Str::slug($data['ad']))->first();
        if (isset($kontrol)) {
           $kategori = Kategori::create([
            'ad' => $data['ad'],
            'slug' => Str::slug($data['ad']) . "-". Str::random(3),  
            'ust_id' => $ustId,
            ]);
        }else{
            $kategori = Kategori::create([
            'ad' => $data['ad'],
            'slug' => Str::slug($data['ad']),  
            'ust_id' => $ustId,
            ]);
        }




       if(request()->hasFile('gorsel')){
        $gorsel = request()->gorsel;
        $dosyadi =  Str::slug($kategori['ad']) . "-" . Str::random(5) . "." . $gorsel->extension();

        if($gorsel->isValid()){
            $gorsel->move('uploads/icon', $dosyadi);

            $kategori->update([
                'icon' => '/uploads/icon/'.$dosyadi,
            ]);
        }
    }

    KategoriAnaliz::create([
        'Kategori_id' => $kategori->id
    ]);

    return redirect()->route('admin.kategori')
    ->with('mesaj', 'Kategori oluşturuldu')
    ->with('mesaj_tur', 'success');
}

public function olusturSayfa()
{

    return view('admin.kategori.olustur');
}

public function guncelleSayfa($id)
{
    $kategori = Kategori::where('id', $id)->firstOrFail();

    return view('admin.kategori.guncelle', compact('kategori'));
}

public function guncelle($id)
{
    $data = request()->all();

    $kategori = Kategori::find($id);
    $kontrol = Kategori::where('slug', $data['slug'])->first();
    if(isset($kontrol)){
        if($kategori->id != $kontrol->id){
            return back()
    ->with('mesaj', 'Bu slug zaten kullanılıyor')
    ->with('mesaj_tur', 'danger');
        }
    }

    $kategori->update([
        'ad' => $data['ad'],
        'slug' => $data['slug'], 
    ]);

    if(request()->hasFile('gorsel')){
        $gorsel = request()->gorsel;
        $dosyadi =  Str::slug($kategori['ad']) . "-" . Str::random(5) . "." . $gorsel->extension();

        if($gorsel->isValid()){
            $gorsel->move('uploads/icon', $dosyadi);

            $kategori->update([
                'icon' => '/uploads/icon/'.$dosyadi,
            ]);
        }
    }

    return redirect()->route('admin.kategori')
    ->with('mesaj', 'Kategori güncellendi')
    ->with('mesaj_tur', 'success');
}

public function sil($id)
{
    $this->pasifDongu($id);

    Kategori::destroy($id);


    return back()
    ->with('mesaj', 'Kategori silindi.')
    ->with('mesaj_tur', 'success');
}

public function siralaSayfa()
{
    $adminKategoriler = Kategori::where('ust_id', 0)->where('durum', 1)->orderBy('sira', 'asc')->get();

    return view('admin.kategori.sirala', compact('adminKategoriler'));
}

public function sirala()
{
    $data = request()->all();
    $count = 0;
    $json = $data['json'];

    $rooms = json_decode($json, true);

    $this->siraDongu($rooms);

    return redirect()->route('admin.kategori')
    ->with('mesaj', 'Kategori sırası güncellendi')
    ->with('mesaj_tur', 'success');
}
public function aktifYap($id)
{
    $kategori = Kategori::find($id);
    $kategori->durum = 1;
    $kategori->save();

    return back()
    ->with('mesaj', 'Kategori durumu aktif yapıldı.')
    ->with('mesaj_tur', 'success');
}

public function pasifYap($id)
{
    $this->pasifDongu($id);

    return back()
    ->with('mesaj', 'Kategori durumu pasif yapıldı.')
    ->with('mesaj_tur', 'success');
}

public function hepsiniAc(){
 $ilk = Kategori::orderBy('created_at','asc')->first();
 $son = Kategori::orderBy('created_at','desc')->first();

 Kategori::where('durum', 0)->where('id', '>=', $ilk->id)->where('id', '<=', $son->id)->update(['durum' => 1]);

 return back()
 ->with('mesaj', 'Tüm kategoriler aktif yapıldı.')
 ->with('mesaj_tur', 'success');
}

public function hepsiniKapat(){
    $ilk = Kategori::orderBy('created_at','asc')->first();
    $son = Kategori::orderBy('created_at','desc')->first();

    Kategori::where('durum', 1)->where('id', '>=', $ilk->id)->where('id', '<=', $son->id)->update(['durum' => 0, 'ust_id' => 0]);


    return back()
    ->with('mesaj', 'Tüm kategoriler pasif yapıldı.')
    ->with('mesaj_tur', 'success');
}

}
