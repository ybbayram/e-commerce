<?php

namespace App\Http\Controllers\Tanitim;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\FonksiyonlarController;
use Cart;
use Illuminate\Support\Facades\Cookie; 
use App\Models\{Sepet, SepetUrun, Urun, UrunFiyat, Ziyaretci, Dil, Ulke, UlkeKod, CesitDetay, CesitFiyat, KuponKod, Kupon, SepetUygulananIndirim};
use Carbon;

class CartIndirimController extends Controller
{
    public function kuponIndirim(){
        $data = request()->all();
        $kupon = $data['kupon'];
        $total = Cart::total();
        $total = str_replace( array( ',' ), '', $total);
        $totalFiyat = $total;
        $totalFiyat = number_format($totalFiyat, 2); 
        $sepetId =  Sepet::aktif_sepet_id();;
        $mytime = Carbon\Carbon::now();
        $tarih = $mytime->toDateTimeString();
        $kod = KuponKod::where('kod', 'like', "%$kupon%")->first();
        if (isset($kod)) {
            $detay = Kupon::where('id', $kod->kupon_id)->first();
            if (isset($detay)) {
                if ($detay->durum == 1) {
                    if ($detay->bitis_tarihi > $tarih) {
                        if ($totalFiyat >= $detay->min) {
                            if ($kod->kullanim_durumu == 0) {
                                $kontrol = SepetUygulananIndirim::where('sepet_id', $sepetId)->first();

                                if (isset($kontrol)) {
                                    return back()
                                    ->with('mesaj', 'Kupon kullanılmış')
                                    ->with('mesaj_tur', 'danger');
                                }else{
                                    SepetUygulananIndirim::create([
                                        'sepet_id' => $sepetId,
                                        'indirim_id' =>$kod->id,
                                        'indirim_turu' => 4
                                    ]);

                                    return  back()
                                    ->with('mesaj', 'onayandı')
                                    ->with('mesaj_tur', 'success');
                                }

                            }else{
                                return back()
                                ->with('mesaj', 'Kupon kullanılmış')
                                ->with('mesaj_tur', 'danger');
                            }
                        }else{
                            return back()
                            ->with('mesaj', 'Alt limit geçersiz.')
                            ->with('mesaj_tur', 'danger');
                        }
                    }else{
                     return back()
                     ->with('mesaj', 'Kuponun son kullanım tarihi dolmuş.')
                     ->with('mesaj_tur', 'danger');
                 }
             }
         }else{
            return back()
            ->with('mesaj', 'Kupon geçerli değil.')
            ->with('mesaj_tur', 'danger');
        }
    }else{
     return back()
     ->with('mesaj', 'Kupon geçerli değil.')
     ->with('mesaj_tur', 'danger');
 }


}
}
