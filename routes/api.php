<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['namespace' => 'Api'], function(){
    Route::group(['prefix' => 'hesabim'], function(){
        Route::post('ziyaretci-id', 'LoginController@ziyaretciId');
        Route::post('kayit-ol', 'LoginController@register');
        Route::post('giris-yap', 'LoginController@login');
        Route::post('sifremi-unuttum', 'LoginController@forgotPassword');

        Route::post('hesap-detay', 'MyAccountController@hesapDetay');
        Route::post('sifre-degistir', 'MyAccountController@sifreDegistir');
        
        Route::post('siparislerim', 'MyAccountController@siparislerim');
    });

    Route::group(['prefix' => 'anasayfa'], function(){
        Route::post('anasayfa-slider', 'IndexController@anasayfaSlider');
        Route::post('one-cikanlar', 'IndexController@oneCikanlar');
    });

    Route::group(['prefix' => 'bilgiler'], function(){
        Route::post('sepet-adet', 'CartController@sepetAdet');
    });

    Route::group(['prefix' => 'shop'], function(){
        Route::post('kategoriler', 'ShopController@kategoriler');
        Route::post('kategori-urunler', 'ShopController@kategoriUrun');
        Route::post('kategori-urun-gorsel', 'ShopController@kategoriUrunGorsel');

        Route::post('urun', 'ShopController@urun');
        Route::post('urun-detay-yorum', 'ShopController@urunDetayYorum');

        Route::post('search', 'ShopController@search');
    });

    Route::group(['prefix' => 'yorum'], function(){
        Route::post('urun-yorum', 'YorumController@urunYorum');
        Route::post('yorum-yap', 'YorumController@yorumYap');
        Route::post('yorum-guncelle', 'YorumController@yorumGuncelle');
        Route::post('degerlendirmelerim', 'YorumController@degerlendirmelerim');
        Route::post('sil', 'YorumController@yorumSil');
        Route::post('urun-detay-yorum', 'YorumController@urunDetayYorum');
    });

    Route::group(['prefix' => 'favori'], function(){
        Route::post('ekle', 'FavoriController@ekle');
        Route::post('kaldir', 'FavoriController@kaldir');
        Route::post('listele', 'FavoriController@listele');
    });
    
    Route::group(['prefix' => 'cart'], function(){
        Route::post('ekle', 'CartController@ekle');
        Route::post('kaldir', 'CartController@kaldir');
        Route::post('listele', 'CartController@listele');
        Route::post('total', 'CartController@index');
    });
    
    Route::group(['prefix' => 'payment'], function(){
        Route::post('post', 'PaymentController@payment');
        Route::post('odeme-basarili', 'PaymentController@odemeBasarili');
    });
    
    Route::group(['prefix' => 'yardim'], function(){
        Route::post('ss-sorular', 'SssController@ssSorular');
        Route::post('ss-sorular-tumu', 'SssController@ssSorularTumu');
        Route::post('ss-sorular-grup', 'SssController@ssSorularGrup');
        Route::post('ss-sorular-search', 'SssController@ssSorularSearch');
    });
    
    Route::group(['prefix' => 'adres'], function(){
        Route::post('ulke-gonder', 'AdresController@ulkeGonder');
        Route::post('kaydet', 'AdresController@adresKaydet');
        Route::post('guncelle', 'AdresController@adresGuncelle');
        Route::post('listele', 'AdresController@listele');
        Route::post('sil', 'AdresController@adresSil');
    });
    
    Route::group(['prefix' => 'iade'], function(){
        Route::post('iade-talep', 'IadeController@iadeTalep');
        Route::post('iptal', 'IadeController@iptal');
        Route::post('iade-sebepleri', 'IadeController@iadeSebepleri');
    });
    
    Route::group(['prefix' => 'muhasebe'], function(){
        Route::post('siparisler', 'RequestCountController@siparislerMuhasebe');
        Route::post('restore', 'RequestCountController@restore');
    });
});