<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\{Filtre, FiltreKategori, Kategori,  Etiket, FiltreEtiket};
use Illuminate\Support\Str;

class FiltreController extends AdminController
{
    public function index()
    {
        $filtreler = Filtre::orderByDesc('created_at')->get();

        return view('admin.filtre.index', compact('filtreler'));
    }

    public function olustur()
    {
        $data = request()->all(); 
        $kontrol = Filtre::where('ad', $data['ad'])->first();
        if (isset($kontrol)) {
            return back()
            ->with('mesaj', 'Filtre zaten kayıtlı')
            ->with('mesaj_tur', 'danger');
        }

        $sira = 0;

        $filtreSira = Filtre::orderBy('sira', 'desc')->first();

        if (isset($filtreSira)) {
            $sira = $filtreSira->sira + 1;
        }
        $filtre = Filtre::create([
            'ad' => $data['ad'],
            'sira' => $sira,
        ]);

        foreach ($data['kategoriler'] as $kategori) {
            FiltreKategori::create([
                'kategori_id' => $kategori,
                'filtre_id' => $filtre->id,
            ]); 
        }

        if(isset($data['etiketler'])){
            foreach ($data['etiketler'] as $etiket) {

                FiltreEtiket::create([
                    'etiket_id' => $etiket,
                    'filtre_id' => $filtre->id,
                ]); 
            }
        }

        return redirect()->route('admin.filtre')
        ->with('mesaj', 'Filtre oluşturuldu')
        ->with('mesaj_tur', 'success');
    }


    public function olusturSayfa()
    {
        $adminKategoriler = Kategori::where('durum', 1)->orderBy('ad', 'asc')->get();
        $etiketler = Etiket::orderBy('sira','DESC')->get();
        return view('admin.filtre.olustur', compact('adminKategoriler', 'etiketler'));
    }

    public function guncelleSayfa($id)
    {  
        $filtre = Filtre::where('id', $id)->firstOrFail();
        $filtreKat = FiltreKategori::where('filtre_id', $filtre->id)->get();
        
        $adminKategoriler = Kategori::orderBy('sira', 'DESC')->get(); 
        $etiketler = Etiket::orderBy('sira','DESC')->get();
        $filtre_etiket = FiltreEtiket::where('filtre_id',$id)->get();

        return view('admin.filtre.guncelle', compact('filtre','filtreKat','adminKategoriler', 'filtre_etiket','etiketler'));
    }

    public function guncelle($id)
    {
        $data = request()->all(); 
        

        $filtre = Filtre::find($id)->update([
         'ad' => $data['ad'],
     ]);
        $kategoriEski = FiltreKategori::where('filtre_id', $id)->get();
        $etiketeEski = FiltreEtiket::where('filtre_id',$id)->get();
        foreach($kategoriEski as $entry){
            FiltreKategori::destroy($entry->id);
        }
        
        foreach($etiketeEski as $entry){
            FiltreEtiket::destroy($entry->id);
        }

        foreach ($data['kategoriler'] as $kategori) {
            FiltreKategori::firstOrCreate([
                'kategori_id' => $kategori,
                'filtre_id' => $id,
            ]);
        }
        
        foreach ($data['etiketler'] as $etiket) {
            FiltreEtiket::firstOrCreate([
                'etiket_id' => $etiket,
                'filtre_id' => $id,
            ]);
        }

        return redirect()->route('admin.filtre')
        ->with('mesaj', 'Filtre güncellendi')
        ->with('mesaj_tur', 'success');
    }

    public function sil($id)
    {
        Filtre::destroy($id);

        return back()
        ->with('mesaj', 'Filtre silindi.')
        ->with('mesaj_tur', 'success');
    }

    public function siralaSayfa()
    {
        $filtre = Filtre::orderBy('sira', 'ASC')->get();

        return view('admin.filtre.sirala', compact('filtre'));
    }

    public function sirala()
    {
        $data = request()->all();
        $count = 0;
        $json = $data['json'];

        $rooms = json_decode($json, true);


        foreach ($rooms as $entry) {
            Filtre::where('id', $entry['id'])->update([
                'sira' => $count,
            ]);
            $count++;
        }

        return redirect()->route('admin.filtre')
        ->with('mesaj', 'Filtre sırası güncellendi')
        ->with('mesaj_tur', 'success');
    }
    public function aktifYap($id)
    {
        $filtre = Filtre::find($id);
        $filtre->durum = 1;
        $filtre->save();

        return back()
        ->with('mesaj', 'Filtre durumu aktif yapıldı.')
        ->with('mesaj_tur', 'success');
    }

    public function pasifYap($id)
    {
        $filtre = Filtre::find($id);
        $filtre->durum = 0;
        $filtre->save();

        return back()
        ->with('mesaj', 'Filtre durumu pasif yapıldı.')
        ->with('mesaj_tur', 'success');
    }
}
