<?php

namespace App\Http\Controllers\Admin\UrunCesit;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\{Urun, UrunFiyat, Ulke, Cesit, CesitDetay, CesitFiyat};

class UrunCesitFiyatController extends AdminController
{
    public function kdvBul($kdv, $fiyat)
    {
        $fiyatBul = $fiyat + (($fiyat * $kdv) / 100);
        return $fiyatBul;
    }

    public function olustur($urun)
    {
        $data = request()->all();
        if (!isset($data['kdv_yok'])) { 
            $data['kdv_yok'] = 0;
        }else{
            $data['kdv_yok'] = 1;
        } 
        if ($data['kdv_yok'] == 1) {
            if (isset($data['kdv_orani'])) {
                $cesitVarMi = count($data['cesit']['fiyat']);
                $bayiCesitVarMi = count($data['cesit']['fiyat_bir']);
                for ($i = 0; $i < $cesitVarMi; $i++) {
                    $fiyat[] =  $this->kdvBul($data['kdv_orani'], $data['cesit']['fiyat'][$i]);
                }
                for ($i = 0; $i < $bayiCesitVarMi; $i++) {
                    $fiyat_bir[] =  $this->kdvBul($data['kdv_orani'], $data['cesit']['fiyat_bir'][$i]);
                }
                for ($i = 0; $i < $bayiCesitVarMi; $i++) {
                    $fiyat_iki[] =  $this->kdvBul($data['kdv_orani'], $data['cesit']['fiyat_iki'][$i]);
                }
                for ($i = 0; $i < $bayiCesitVarMi; $i++) {
                    $fiyat_uc[] =  $this->kdvBul($data['kdv_orani'], $data['cesit']['fiyat_uc'][$i]);
                }
                for ($i = 0; $i < $bayiCesitVarMi; $i++) {
                    $fiyat_dort[] =  $this->kdvBul($data['kdv_orani'], $data['cesit']['fiyat_dort'][$i]);
                }
            }
        } else {

            $bayiCesitVarMi = count($data['cesit']['fiyat_bir']);
            $cesitVarMi = count($data['cesit']['fiyat']);
            for ($i = 0; $i < $cesitVarMi; $i++) {
                $fiyat[] =  $data['cesit']['fiyat'][$i];
            }
            for ($i = 0; $i < $bayiCesitVarMi; $i++) {
                $fiyat_bir[] =  $data['cesit']['fiyat_bir'][$i];
            }
            for ($i = 0; $i < $bayiCesitVarMi; $i++) {
                $fiyat_iki[] =  $data['cesit']['fiyat_iki'][$i];
            }
            for ($i = 0; $i < $bayiCesitVarMi; $i++) {
                $fiyat_uc[] =  $data['cesit']['fiyat_uc'][$i];
            }
            for ($i = 0; $i < $bayiCesitVarMi; $i++) {
                $fiyat_dort[] =  $data['cesit']['fiyat_dort'][$i];
            }
        }
        $kontrol = CesitFiyat::where('urun_id', $urun)->where('ulke_id', $data['ulke_id'])->first();

        if (isset($kontrol)) {
            return back()
            ->with('mesaj', 'Ülke zaten kayıtlı')
            ->with('mesaj_tur', 'danger');
        }
        $idVarMi = count($data['cesit']['id']);
        for ($i = 0; $i < $idVarMi; $i++) {

            $varMi[] = CesitFiyat::where('urun_id', $urun)->where('cesit_detay_id', $data['cesit']['id'][$i])->where('ulke_id', $data['ulke_id'])->first();
        }

        foreach ($varMi as $var) {
            if (!isset($var)) {
                $cesitVarMi = count($data['cesit']['fiyat']);
                for ($i = 0; $i < $cesitVarMi; $i++) {
                    if (isset($data['fiyat_onceki'])) {
                        if ($data['cesit']['fiyat'][$i] > $data['cesit']['fiyat_onceki'][$i]) {
                            return back()
                            ->with('mesaj', 'Önceki fiyat fiyattan küçük olamaz.')
                            ->with('mesaj_tur', 'danger');
                        }
                    }
                    $urunFiyat = CesitFiyat::create([
                        'urun_id' => $urun,
                        'cesit_detay_id' => $data['cesit']['id'][$i],
                        'ulke_id' => $data['ulke_id'],
                        'kdv_orani' => $data['kdv_orani'],
                        'fiyat_onceki' => $data['cesit']['fiyat_onceki'][$i],
                        'kdvsiz_fiyat' => $data['cesit']['fiyat'][$i],
                        'fiyat_bir_onceki' => $data['cesit']['fiyat_bir_onceki'][$i],
                        'fiyat_bir_kdvsiz' => $data['cesit']['fiyat_bir'][$i],
                        'fiyat_iki_onceki' => $data['cesit']['fiyat_iki_onceki'][$i],
                        'fiyat_iki_kdvsiz' => $data['cesit']['fiyat_iki'][$i],
                        'fiyat_uc_onceki' => $data['cesit']['fiyat_uc_onceki'][$i],
                        'fiyat_uc_kdvsiz' => $data['cesit']['fiyat_uc'][$i],
                        'fiyat_dort_onceki' => $data['cesit']['fiyat_dort_onceki'][$i],
                        'fiyat_dort_kdvsiz' => $data['cesit']['fiyat_dort'][$i]

                    ]);
                    CesitFiyat::where('id', $urunFiyat->id)->where('urun_id', $urunFiyat->urun_id)->where('cesit_detay_id', $urunFiyat->cesit_detay_id)->where('ulke_id', $urunFiyat->ulke_id)->update([
                        'fiyat' => $fiyat[$i]
                    ]);

                    CesitFiyat::where('id', $urunFiyat->id)->where('urun_id', $urunFiyat->urun_id)->where('cesit_detay_id', $urunFiyat->cesit_detay_id)->where('ulke_id', $urunFiyat->ulke_id)->update([
                        'fiyat_bir' => $fiyat_bir[$i]
                    ]);
                    CesitFiyat::where('id', $urunFiyat->id)->where('urun_id', $urunFiyat->urun_id)->where('cesit_detay_id', $urunFiyat->cesit_detay_id)->where('ulke_id', $urunFiyat->ulke_id)->update([
                        'fiyat_iki' => $fiyat_iki[$i]
                    ]);
                    CesitFiyat::where('id', $urunFiyat->id)->where('urun_id', $urunFiyat->urun_id)->where('cesit_detay_id', $urunFiyat->cesit_detay_id)->where('ulke_id', $urunFiyat->ulke_id)->update([
                        'fiyat_uc' => $fiyat_uc[$i]
                    ]);
                    CesitFiyat::where('id', $urunFiyat->id)->where('urun_id', $urunFiyat->urun_id)->where('cesit_detay_id', $urunFiyat->cesit_detay_id)->where('ulke_id', $urunFiyat->ulke_id)->update([
                        'fiyat_dort' => $fiyat_dort[$i]
                    ]);
                }

                return redirect()->route('admin.urunFiyat', $urun)
                ->with('mesaj', 'Ürün fiyatı oluşturuldu')
                ->with('mesaj_tur', 'success');
            } else {
                return redirect()->route('admin.urunFiyat', $urun)
                ->with('mesaj', 'Bu ülke için fiyat girişi zaten yapılmış')
                ->with('mesaj_tur', 'danger');
            }
        }
    }
    public function guncelleSayfa($id)
    {
        $cesitFiyat = CesitFiyat::where('id', $id)->firstOrFail();
        $urun = Urun::find($cesitFiyat->urun_id);
        $ulkeler = Ulke::orderBy('created_at', 'asc')->get();


        return view('admin.urun.urunFiyat.guncelle', compact('cesitFiyat', 'urun', 'ulkeler'));
    }

    public function guncelle($id)
    {
        $data = request()->all();
        if (isset($data['fiyat_onceki'])) {
            if ($data['fiyat'] > $data['fiyat_onceki']) {
                return back()
                ->with('mesaj', 'Önceki fiyat fiyattan küçük olamaz.')
                ->with('mesaj_tur', 'danger');
            }
        }
        if (!isset($data['kdv_yok'])) { 
            $data['kdv_yok'] = 0;
        }else{
            $data['kdv_yok'] = 1;
        } 


        if ($data['kdv_yok'] == 1) {
            if ($data['kdv_orani'] != null) {
                $fiyat =  $this->kdvBul($data['kdv_orani'], $data['fiyat']);
                $fiyat_bir =  $this->kdvBul($data['kdv_orani'], $data['fiyat_bir']);
                $fiyat_iki =  $this->kdvBul($data['kdv_orani'], $data['fiyat_iki']);
                $fiyat_uc =  $this->kdvBul($data['kdv_orani'], $data['fiyat_uc']);
                $fiyat_dort =  $this->kdvBul($data['kdv_orani'], $data['fiyat_dort']);
            } 
        } else {
            $fiyat =  $data['fiyat'];
            $fiyat_bir =  $data['fiyat_bir'];
            $fiyat_iki =  $data['fiyat_iki'];
            $fiyat_uc =  $data['fiyat_uc'];
            $fiyat_dort =  $data['fiyat_dort'];
        }

        $kontrol = CesitFiyat::where('id', $id)->where('ulke_id', $data['ulke_id'])->first();
        if ($kontrol->ulke_id != $data['ulke_id']) {
            if (isset($kontrol)) {
                return back()
                ->with('mesaj', 'Ülke zaten kayıtlı')
                ->with('mesaj_tur', 'danger');
            }
        }

        $urun = CesitFiyat::find($id);
        $urun->update([
            'urun_id' => $urun->urun_id,
            'cesit_detay_id' => $urun->cesit_detay_id,
            'ulke_id' => $data['ulke_id'],
            'kdv_orani' => $data['kdv_orani'],
            'kdv_durum' => $data['kdv_yok'],
            'fiyat' => $fiyat,
            'fiyat_onceki' => $data['fiyat_onceki'],
            'kdvsiz_fiyat' => $data['fiyat'],
            'fiyat_bir' => $fiyat_bir,
            'fiyat_bir_onceki' => $data['fiyat_bir_onceki'],
            'fiyat_bir_kdvsiz' => $data['fiyat_bir'],
            'fiyat_iki' => $fiyat_iki,
            'fiyat_iki_onceki' => $data['fiyat_iki_onceki'],
            'fiyat_iki_kdvsiz' => $data['fiyat_iki'],
            'fiyat_uc' => $fiyat_uc,
            'fiyat_uc_onceki' => $data['fiyat_uc_onceki'],
            'fiyat_uc_kdvsiz' => $data['fiyat_uc'],
            'fiyat_dort' => $fiyat_dort,
            'fiyat_dort_onceki' => $data['fiyat_dort_onceki'],
            'fiyat_dort_kdvsiz' => $data['fiyat_dort']
        ]);

        return redirect()->route('admin.urunFiyat', $urun->urun_id)
        ->with('mesaj', 'Ürün fiyatı güncellendi')
        ->with('mesaj_tur', 'success');
    }
    public function sil($id)
    {
        CesitFiyat::destroy($id);

        return back()
        ->with('mesaj', 'Ürün fiyatı silindi.')
        ->with('mesaj_tur', 'success');
    }
}
