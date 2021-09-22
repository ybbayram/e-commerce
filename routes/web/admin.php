<?php

Route::group(['prefix' => 'digi-admin', 'namespace' => 'Admin'], function () {
    Route::get('/', 'GirisController@index')->name('admin.giris');
    Route::post('oturum-ac', 'GirisController@oturumac')->name('admin.oturumac');
    Route::post('kayit-ol', 'GirisController@kayitol')->name('admin.kayitol');
    Route::group(['prefix' => 'panel', 'middleware' => 'admin'], function () {
        Route::get('/', 'IndexController@index')->name('admin.index');
        Route::get('oturum-kapat', 'GirisController@oturumkapat')->name('admin.oturumkapat');
        Route::group(['prefix' => 'dil'], function () {
            Route::get('/', 'DilController@index')->name('admin.dil');
            Route::post('olustur', 'DilController@olustur')->name('admin.dil.olustur');
            Route::get('olustur-sayfa', 'DilController@olusturSayfa')->name('admin.dil.olustur.sayfa');
            Route::get('guncelle-sayfa/{id}', 'DilController@guncelleSayfa')->name('admin.dil.guncelle.sayfa');
            Route::post('guncelle/{id}', 'DilController@guncelle')->name('admin.dil.guncelle');
            Route::get('sil/{id}', 'DilController@sil')->name('admin.dil.sil');
            Route::get('aktif-yap/{id}', 'DilController@aktifYap')->name('admin.dil.aktifYap');
            Route::get('pasif-yap/{id}', 'DilController@pasifYap')->name('admin.dil.pasifYap');
        });
        Route::group(['prefix' => 'ulke'], function () {
            Route::get('/', 'UlkeController@index')->name('admin.ulke');
            Route::post('olustur', 'UlkeController@olustur')->name('admin.ulke.olustur');
            Route::get('olustur-sayfa', 'UlkeController@olusturSayfa')->name('admin.ulke.olustur.sayfa');
            Route::get('guncelle-sayfa/{id}', 'UlkeController@guncelleSayfa')->name('admin.ulke.guncelle.sayfa');
            Route::post('guncelle/{id}', 'UlkeController@guncelle')->name('admin.ulke.guncelle');
            Route::get('sil/{id}', 'UlkeController@sil')->name('admin.ulke.sil');
        });
        Route::group(['prefix' => 'marka'], function () {
            Route::get('/', 'MarkaController@index')->name('admin.marka');
            Route::post('olustur', 'MarkaController@olustur')->name('admin.marka.olustur');
            Route::get('olustur-sayfa', 'MarkaController@olusturSayfa')->name('admin.marka.olustur.sayfa');
            Route::get('guncelle-sayfa/{id}', 'MarkaController@guncelleSayfa')->name('admin.marka.guncelle.sayfa');
            Route::post('guncelle/{id}', 'MarkaController@guncelle')->name('admin.marka.guncelle');
            Route::get('sil/{id}', 'MarkaController@sil')->name('admin.marka.sil');

            Route::get('pasif-yap/{id}', 'MarkaController@pasifYap')->name('admin.marka.pasifYap');
            Route::get('aktif-yap/{id}', 'MarkaController@aktifYap')->name('admin.marka.aktifYap');
            
            Route::get('ac', 'MarkaController@hepsiniAc')->name('admin.marka.hepsiniAc');
            Route::get('kapat', 'MarkaController@hepsiniKapat')->name('admin.marka.hepsiniKapat');
        });

        Route::group(['prefix' => 'marka-dil/{marka}'], function () {
            Route::get('/', 'MarkaDilController@index')->name('admin.markaDil');
            Route::post('olustur', 'MarkaDilController@olustur')->name('admin.markaDil.olustur');
            Route::get('olustur-sayfa', 'MarkaDilController@olusturSayfa')->name('admin.markaDil.olustur.sayfa');
            Route::get('guncelle-sayfa/{id}', 'MarkaDilController@guncelleSayfa')->name('admin.markaDil.guncelle.sayfa');
            Route::post('guncelle/{id}', 'MarkaDilController@guncelle')->name('admin.markaDil.guncelle');
            Route::get('sil/{id}', 'MarkaDilController@sil')->name('admin.markaDil.sil');
        });
        Route::group(['prefix' => 'kategori'], function () {
            Route::get('/', 'KategoriController@index')->name('admin.kategori');
            Route::post('olustur', 'KategoriController@olustur')->name('admin.kategori.olustur');
            Route::get('olustur-sayfa', 'KategoriController@olusturSayfa')->name('admin.kategori.olustur.sayfa');
            Route::get('guncelle-sayfa/{id}', 'KategoriController@guncelleSayfa')->name('admin.kategori.guncelle.sayfa');
            Route::post('guncelle/{id}', 'KategoriController@guncelle')->name('admin.kategori.guncelle');
            Route::get('sil/{id}', 'KategoriController@sil')->name('admin.kategori.sil');

            Route::get('pasif-yap/{id}', 'KategoriController@pasifYap')->name('admin.kategori.pasifYap');
            Route::get('aktif-yap/{id}', 'KategoriController@aktifYap')->name('admin.kategori.aktifYap');

            Route::get('sirala-sayfa', 'KategoriController@siralaSayfa')->name('admin.kategori.sirala.sayfa');
            Route::post('sirala-guncelle', 'KategoriController@sirala')->name('admin.kategori.sirala');

            Route::get('ac', 'KategoriController@hepsiniAc')->name('admin.kategori.hepsiniAc');
            Route::get('kapat', 'KategoriController@hepsiniKapat')->name('admin.kategori.hepsiniKapat');
            
        });
        Route::group(['prefix' => 'kategori-dil/{kategori}'], function () {
            Route::get('/', 'KategoriDilController@index')->name('admin.kategoriDil');
            Route::post('olustur', 'KategoriDilController@olustur')->name('admin.kategoriDil.olustur');
            Route::get('olustur-sayfa', 'KategoriDilController@olusturSayfa')->name('admin.kategoriDil.olustur.sayfa');
            Route::get('guncelle-sayfa/{id}', 'KategoriDilController@guncelleSayfa')->name('admin.kategoriDil.guncelle.sayfa');
            Route::post('guncelle/{id}', 'KategoriDilController@guncelle')->name('admin.kategoriDil.guncelle');
            Route::get('sil/{id}', 'KategoriDilController@sil')->name('admin.kategoriDil.sil');
        });
        Route::group(['prefix' => 'urun'], function () {
            Route::get('/', 'UrunController@index')->name('admin.urun');
            Route::post('olustur', 'UrunController@olustur')->name('admin.urun.olustur');
            Route::get('olustur-sayfa', 'UrunController@olusturSayfa')->name('admin.urun.olustur.sayfa');
            Route::get('guncelle-sayfa/{id}', 'UrunController@guncelleSayfa')->name('admin.urun.guncelle.sayfa');
            Route::post('guncelle/{id}', 'UrunController@guncelle')->name('admin.urun.guncelle');
            Route::get('sil/{id}', 'UrunController@sil')->name('admin.urun.sil');
            Route::get('pasif-yap/{id}', 'UrunController@pasifYap')->name('admin.urun.pasifYap');
            Route::get('aktif-yap/{id}', 'UrunController@aktifYap')->name('admin.urun.aktifYap');
            Route::get('cesit-ac/{id}', 'UrunController@cesitKapat')->name('admin.urun.cesitKapat');

            Route::get('aktif-yap/{id}', 'UrunController@aktifYap')->name('admin.urun.aktifYap');
            Route::get('ac', 'UrunController@hepsiniAc')->name('admin.urun.hepsiniAc');
            Route::get('kapat', 'UrunController@hepsiniKapat')->name('admin.urun.hepsiniKapat');
        });
        Route::group(['prefix' => 'urun-detay'], function () {
            Route::get('/{urun}', 'UrunDetayController@index')->name('admin.urunDetay');
            Route::post('olustur/{urun}', 'UrunDetayController@olustur')->name('admin.urunDetay.olustur');
            Route::get('olustur-sayfa/{urun}', 'UrunDetayController@olusturSayfa')->name('admin.urunDetay.olustur.sayfa');
            Route::get('guncelle-sayfa/{id}', 'UrunDetayController@guncelleSayfa')->name('admin.urunDetay.guncelle.sayfa');
            Route::post('guncelle/{id}', 'UrunDetayController@guncelle')->name('admin.urunDetay.guncelle');
            Route::get('sil/{id}', 'UrunDetayController@sil')->name('admin.urunDetay.sil');
        });

        Route::group(['prefix' => 'urun-tedarikci/'], function(){
            Route::get('/{urun}', 'UrunTedarikciController@index')->name('admin.urunTedarikci');    
            Route::post('olustur/{urun}', 'UrunTedarikciController@olustur')->name('admin.urunTedarikci.olustur');

            Route::get('guncelle/{id}', 'UrunTedarikciController@guncelleSayfa')->name('admin.urunTedarikci.guncelle.sayfa');
            Route::post('guncelle/{urun}', 'UrunTedarikciController@guncelle')->name('admin.urunTedarikci.guncelle');
            Route::get('sil/{urun}', 'UrunTedarikciController@sil')->name('admin.urunTedarikci.sil');
            Route::get('pasif-yap/{urun}', 'UrunTedarikciController@pasifYap')->name('admin.urunTedarikci.pasifYap');
            Route::get('aktif-yap/{urun}', 'UrunTedarikciController@aktifYap')->name('admin.urunTedarikci.aktifYap');


        });
        Route::group(['namespace' => 'UrunCesit'], function(){
            Route::group(['prefix' => 'urun-cesit'], function () {
                Route::get('/{urun}', 'UrunCesitController@index')->name('admin.urunCesit');
                Route::post('olustur/{urun}', 'UrunCesitController@olustur')->name('admin.urunCesit.olustur');
                Route::get('olustur-sayfa/{urun}', 'UrunCesitController@olusturSayfa')->name('admin.urunCesit.olustur.sayfa'); 
                Route::get('guncelle-sayfa/{id}', 'UrunCesitController@guncelleSayfa')->name('admin.urunCesit.guncelle.sayfa');
                Route::post('guncelle/{id}', 'UrunCesitController@guncelle')->name('admin.urunCesit.guncelle');
                Route::get('sil/{id}', 'UrunCesitController@sil')->name('admin.urunCesit.sil');
                Route::get('cesit-sil/{id}', 'UrunCesitController@cesitSil')->name('admin.urunCesit.cesitSil');
                Route::get('pasif-yap/{id}', 'UrunCesitController@pasifYap')->name('admin.urunCesit.pasifYap');
                Route::get('aktif-yap/{id}', 'UrunCesitController@aktifYap')->name('admin.urunCesit.aktifYap');
            });

            Route::group(['prefix' => 'urun-cesit-dil/{cesit}'], function () {
                Route::get('/', 'UrunCesitDilController@index')->name('admin.urunCesitDil');
                Route::post('olustur', 'UrunCesitDilController@olustur')->name('admin.urunCesitDil.olustur');
                Route::get('olustur-sayfa', 'UrunCesitDilController@olusturSayfa')->name('admin.urunCesitDil.olustur.sayfa');
                Route::get('guncelle-sayfa/{id}', 'UrunCesitDilController@guncelleSayfa')->name('admin.urunCesitDil.guncelle.sayfa');
                Route::post('guncelle/{id}', 'UrunCesitDilController@guncelle')->name('admin.urunCesitDil.guncelle');
                Route::get('sil/{id}', 'UrunCesitDilController@sil')->name('admin.urunCesitDil.sil');
            });

            Route::group(['prefix' => 'urun-cesit-detay'], function () {
                Route::get('/{cesit}', 'UrunCesitDetayController@index')->name('admin.urunCesitDetay');
                Route::post('olustur/{cesit}', 'UrunCesitDetayController@olustur')->name('admin.urunCesitDetay.olustur');  
                Route::get('guncelle-sayfa/{id}', 'UrunCesitDetayController@guncelleSayfa')->name('admin.urunCesitDetay.guncelle.sayfa');
                Route::post('guncelle/{id}', 'UrunCesitDetayController@guncelle')->name('admin.urunCesitDetay.guncelle');
                Route::get('sil/{id}', 'UrunCesitDetayController@sil')->name('admin.urunCesitDetay.sil'); 
                Route::get('pasif-yap/{id}', 'UrunCesitDetayController@pasifYap')->name('admin.urunCesitDetay.pasifYap');
                Route::get('aktif-yap/{id}', 'UrunCesitDetayController@aktifYap')->name('admin.urunCesitDetay.aktifYap');
            });
            Route::group(['prefix' => 'urun-cesit-detay-dil/{cesitDetay}'], function () {
                Route::get('/', 'UrunCesitDetayDilController@index')->name('admin.urunCesitDetayDil');
                Route::post('olustur', 'UrunCesitDetayDilController@olustur')->name('admin.urunCesitDetayDil.olustur');
                Route::get('olustur-sayfa', 'UrunCesitDetayDilController@olusturSayfa')->name('admin.urunCesitDetayDil.olustur.sayfa');
                Route::get('guncelle-sayfa/{id}', 'UrunCesitDetayDilController@guncelleSayfa')->name('admin.urunCesitDetayDil.guncelle.sayfa');
                Route::post('guncelle/{id}', 'UrunCesitDetayDilController@guncelle')->name('admin.urunCesitDetayDil.guncelle');
                Route::get('sil/{id}', 'UrunCesitDetayDilController@sil')->name('admin.urunCesitDetayDil.sil');
            });
            
        });
        Route::group(['prefix' => 'urun-fiyat'], function () {
            Route::get('/{urun}', 'UrunFiyatController@index')->name('admin.urunFiyat');
            Route::post('olustur/{urun}', 'UrunFiyatController@olustur')->name('admin.urunFiyat.olustur');
            Route::get('olustur-sayfa/{urun}', 'UrunFiyatController@olusturSayfa')->name('admin.urunFiyat.olustur.sayfa');
            Route::get('guncelle-sayfa/{id}', 'UrunFiyatController@guncelleSayfa')->name('admin.urunFiyat.guncelle.sayfa');
            Route::post('guncelle/{id}', 'UrunFiyatController@guncelle')->name('admin.urunFiyat.guncelle');

            Route::post('olustur-cesit/{urun}', 'UrunCesit\UrunCesitFiyatController@olustur')->name('admin.urunFiyat.cesit.olustur');
            
            Route::get('guncelle-cesit-sayfa/{id}', 'UrunCesit\UrunCesitFiyatController@guncelleSayfa')->name('admin.urunFiyat.cesit.guncelle.sayfa');
            Route::post('guncelle-cesit/{id}', 'UrunCesit\UrunCesitFiyatController@guncelle')->name('admin.urunFiyat.cesit.guncelle');

            Route::get('sil/2/{id}', 'UrunFiyatController@sil')->name('admin.urunFiyat.sil');
            Route::get('sil/{id}', 'UrunCesit\UrunCesitFiyatController@sil')->name('admin.urunFiyat.cesit.sil');
            Route::get('onizle/{id}', 'UrunController@onizle')->name('admin.urun.onizle');
        });
        Route::group(['prefix' => 'one-cikanlar'], function () {
            Route::get('/', 'OneCikanlarController@index')->name('admin.oneCikanlar');
            Route::get('/urun/{id}', 'OneCikanlarController@urun')->name('admin.oneCikanlar.urun');

            Route::get('/olustur', 'OneCikanlarController@olusturSayfa')->name('admin.oneCikanlar.olustur.sayfa');
            Route::post('olustur', 'OneCikanlarController@olustur')->name('admin.oneCikanlar.olustur');
            Route::get('/guncelle-sayfa/{id}', 'OneCikanlarController@guncelleSayfa')->name('admin.oneCikanlar.guncelle.sayfa');
            Route::post('/guncelle/{id}', 'OneCikanlarController@guncelle')->name('admin.oneCikanlar.guncelle');
            Route::group(['prefix' => 'urun'], function () {
                Route::post('/ekle/{id}', 'OneCikanlarUrunController@ekle')->name('admin.oneCikanlar.urun.ekle');
                Route::get('/sil/{id}', 'OneCikanlarUrunController@sil')->name('admin.oneCikanlar.urun.sil');
            });
        });
        Route::group(['prefix' => 'urun-gorsel'], function () {
            Route::get('/{urun}', 'UrunGorselController@index')->name('admin.urunGorsel');
            Route::post('olustur/{urun}', 'UrunGorselController@olustur')->name('admin.urunGorsel.olustur');
            Route::get('olustur-sayfa/{urun}', 'UrunGorselController@olusturSayfa')->name('admin.urunGorsel.olustur.sayfa');
            Route::get('sil/{id}', 'UrunGorselController@sil')->name('admin.urunGorsel.sil');

            Route::get('sirala-sayfa/{urun}', 'UrunGorselController@siralaSayfa')->name('admin.urunGorsel.sirala.sayfa');
            Route::post('sirala-guncelle/{urun}', 'UrunGorselController@sirala')->name('admin.urunGorsel.sirala');
        });
        Route::group(['prefix' => 'kullanicilar'], function () {
         Route::get('/', 'UsersController@index')->name('admin.user');
         Route::post('/bayi-degis/{id}', 'UsersController@bayiDegis')->name('admin.user.bayi');
     });
        Route::group(['prefix' => 'toplu-urun-ekleme'], function () {
            Route::get('/', 'TopluUrunController@index')->name('admin.topluUrun');
            Route::get('urun-ekle', 'TopluUrunController@urunEkleSayfa')->name('admin.topluUrun.urunEkle.sayfa');
            Route::get('gorsel-ekle', 'TopluUrunController@gorselEkleSayfa')->name('admin.topluUrun.gorselEkle.sayfa');
            Route::post('urun-ekle', 'TopluUrunController@urunEkle')->name('admin.topluUrun.urunEkle');
            Route::post('gorsel-ekle', 'TopluUrunController@gorselEkle')->name('admin.topluUrun.gorselEkle');
            Route::get('toplu-sil/{id}', 'TopluUrunController@sil')->name('admin.topluUrun.sil');
            Route::get('toplu-onayla/{id}', 'TopluUrunController@onayla')->name('admin.topluUrun.onayla');
        });
        Route::group(['prefix' => 'siparis'], function () { 
            Route::get('/', 'SiparisController@index')->name('admin.siparis');
            Route::get('/{id}', 'SiparisController@detay')->name('admin.siparis.detay');
            Route::post('/{id}', 'SiparisController@islemDurum')->name('admin.siparis.islem');
        });
        Route::group(['prefix' => 'rapor'], function () {
            Route::get('/', 'RaporController@index')->name('admin.rapor');
        });
        Route::group(['prefix' => 'iletisim'], function () {
            Route::get('/', 'IletisimController@index')->name('admin.iletisim');
        });
        Route::group(['prefix' => 'yorum'], function () {
            Route::get('/', 'YorumController@index')->name('admin.yorum');
            Route::get('/onayla/{yorum}', 'YorumController@onayla')->name('admin.yorum.onayla');
            Route::get('/kapat/{yorum}', 'YorumController@kapat')->name('admin.yorum.kapat');
            Route::post('/sil/{yorum}', 'YorumController@sil')->name('admin.yorum.sil');
        });
        Route::group(['prefix' => 'filtre'], function () {
            Route::get('/', 'FiltreController@index')->name('admin.filtre');
            Route::get('olustur-sayfa', 'FiltreController@olusturSayfa')->name('admin.filtre.olustur.sayfa');
            Route::post('olustur', 'FiltreController@olustur')->name('admin.filtre.olustur');
            Route::get('guncelle-sayfa/{id}', 'FiltreController@guncelleSayfa')->name('admin.filtre.guncelle.sayfa');
            Route::post('guncelle/{id}', 'FiltreController@guncelle')->name('admin.filtre.guncelle');
            Route::get('sil/{id}', 'FiltreController@sil')->name('admin.filtre.sil');
            Route::get('pasif-yap/{id}', 'FiltreController@pasifYap')->name('admin.filtre.pasifYap');
            Route::get('aktif-yap/{id}', 'FiltreController@aktifYap')->name('admin.filtre.aktifYap');

            Route::get('sirala-sayfa', 'FiltreController@siralaSayfa')->name('admin.filtre.sirala.sayfa');
            Route::post('sirala-guncelle', 'FiltreController@sirala')->name('admin.filtre.sirala');
        });
        Route::group(['prefix' => 'filtre-dil/{filtre}'], function () {
            Route::get('/', 'FiltreDilController@index')->name('admin.filtreDil');
            Route::post('olustur', 'FiltreDilController@olustur')->name('admin.filtreDil.olustur');
            Route::get('olustur-sayfa', 'FiltreDilController@olusturSayfa')->name('admin.filtreDil.olustur.sayfa');
            Route::get('guncelle-sayfa/{id}', 'FiltreDilController@guncelleSayfa')->name('admin.filtreDil.guncelle.sayfa');
            Route::post('guncelle/{id}', 'FiltreDilController@guncelle')->name('admin.filtreDil.guncelle');
            Route::get('sil/{id}', 'FiltreDilController@sil')->name('admin.filtreDil.sil');
        });
        Route::group(['prefix' => 'etiket'], function () {
            Route::get('/', 'EtiketController@index')->name('admin.etiket');
            Route::get('olustur-sayfa', 'EtiketController@olusturSayfa')->name('admin.etiket.olustur.sayfa');
            Route::post('olustur', 'EtiketController@olustur')->name('admin.etiket.olustur');
            Route::get('guncelle-sayfa/{id}', 'EtiketController@guncelleSayfa')->name('admin.etiket.guncelle.sayfa');
            Route::post('guncelle/{id}', 'EtiketController@guncelle')->name('admin.etiket.guncelle');
            Route::get('sil/{id}', 'EtiketController@sil')->name('admin.etiket.sil');
            Route::get('pasif-yap/{id}', 'EtiketController@pasifYap')->name('admin.etiket.pasifYap');
            Route::get('aktif-yap/{id}', 'EtiketController@aktifYap')->name('admin.etiket.aktifYap');

            Route::get('sirala-sayfa', 'EtiketController@siralaSayfa')->name('admin.etiket.sirala.sayfa');
            Route::post('sirala-guncelle', 'EtiketController@sirala')->name('admin.etiket.sirala');

            Route::get('ac', 'EtiketController@hepsiniAc')->name('admin.etiket.hepsiniAc');
            Route::get('kapat', 'EtiketController@hepsiniKapat')->name('admin.etiket.hepsiniKapat');
        });
        Route::group(['prefix' => 'etiket-dil/{etiket}'], function () {
            Route::get('/', 'EtiketDilController@index')->name('admin.etiketDil');
            Route::post('olustur', 'EtiketDilController@olustur')->name('admin.etiketDil.olustur');
            Route::get('olustur-sayfa', 'EtiketDilController@olusturSayfa')->name('admin.etiketDil.olustur.sayfa');
            Route::get('guncelle-sayfa/{id}', 'EtiketDilController@guncelleSayfa')->name('admin.etiketDil.guncelle.sayfa');
            Route::post('guncelle/{id}', 'EtiketDilController@guncelle')->name('admin.etiketDil.guncelle');
            Route::get('sil/{id}', 'EtiketDilController@sil')->name('admin.etiketDil.sil');
        });

        Route::group(['namespace' => 'Kampanya'], function(){
            Route::group(['prefix' => 'camp'], function(){
                Route::group(['prefix' => 'kampanya-sec'], function(){
                    Route::get('/', 'SecController@index')->name('admin.camp.index');
                    Route::get('/{id}', 'SecController@kampanya')->name('admin.camp.kampanya');
                    Route::post('/sec/{id}', 'SecController@kampanyaSec')->name('admin.camp.kampanyaSec');
                });
                Route::group(['prefix' => 'kargo'], function(){
                    Route::get('/', 'KargoController@index')->name('admin.kargo');
                    Route::get('olustur', 'KargoController@olusturSayfa')->name('admin.kargo.olustur.sayfa');
                    Route::post('olustur', 'KargoController@olustur')->name('admin.kargo.olustur');
                    Route::get('guncelle/{id}', 'KargoController@guncelleSayfa')->name('admin.kargo.guncelle.sayfa');
                    Route::post('guncelle/{id}', 'KargoController@guncelle')->name('admin.kargo.guncelle');
                    Route::get('sil/{id}', 'KargoController@sil')->name('admin.kargo.sil');
                });
                Route::group(['prefix' => 'kupon'], function(){
                    Route::get('/', 'KuponController@index')->name('admin.kupon');
                    Route::get('olustur', 'KuponController@olusturSayfa')->name('admin.kupon.olustur.sayfa');
                    Route::post('olustur', 'KuponController@olustur')->name('admin.kupon.olustur');
                    Route::get('goster/{id}', 'KuponController@gosterSayfa')->name('admin.kupon.goster.sayfa');
                    Route::get('sil/{id}', 'KuponController@sil')->name('admin.kupon.sil');

                    Route::get('pasif-yap/{id}', 'KuponController@pasifYap')->name('admin.kupon.pasifYap');
                    Route::get('aktif-yap/{id}', 'KuponController@aktifYap')->name('admin.kupon.aktifYap');

                    Route::get('kullanim-pasif-yap/{id}', 'KuponController@kullanimPasifYap')->name('admin.kupon.kullanimPasifYap');
                    Route::get('kullanim-aktif-yap/{id}', 'KuponController@kullanimAktifYap')->name('admin.kupon.kullanimAktifYap');

                    Route::get('ac/{id}', 'KuponController@hepsiniAc')->name('admin.kupon.hepsiniAc'); 
                    Route::get('kapat/{id}', 'KuponController@hepsiniKapat')->name('admin.kupon.hepsiniKapat');
                });
                Route::group(['prefix' => 'sepet-indirim'], function(){
                    Route::get('/', 'SepetIndirimController@index')->name('admin.sepetIndirim');
                    Route::get('olustur', 'SepetIndirimController@olusturSayfa')->name('admin.sepetIndirim.olustur.sayfa');
                    Route::post('olustur', 'SepetIndirimController@olustur')->name('admin.sepetIndirim.olustur');
                    Route::get('guncelle/{id}', 'SepetIndirimController@guncelleSayfa')->name('admin.sepetIndirim.guncelle.sayfa');
                    Route::post('guncelle/{id}', 'SepetIndirimController@guncelle')->name('admin.sepetIndirim.guncelle');
                    Route::get('sil/{id}', 'SepetIndirimController@sil')->name('admin.sepetIndirim.sil');
                });
                Route::group(['prefix' => 'x-al-y-ode'], function(){
                    Route::get('/', 'XalYodeController@index')->name('admin.xAlyOde');
                    Route::get('olustur', 'XalYodeController@olusturSayfa')->name('admin.xAlyOde.olustur.sayfa');
                    Route::post('olustur', 'XalYodeController@olustur')->name('admin.xAlyOde.olustur');
                    Route::get('guncelle/{id}', 'XalYodeController@guncelleSayfa')->name('admin.xAlyOde.guncelle.sayfa');
                    Route::post('guncelle/{id}', 'XalYodeController@guncelle')->name('admin.xAlyOde.guncelle');
                    Route::get('/sil/{id}', 'XalYodeController@sil')->name('admin.xAlyOde.sil');
                });
                Route::group(['prefix' => 'promosyon'], function(){
                    Route::get('/', 'PromosyonController@index')->name('admin.promosyon');
                    Route::get('olustur', 'PromosyonController@olusturSayfa')->name('admin.promosyon.olustur.sayfa');
                    Route::post('olustur', 'PromosyonController@olustur')->name('admin.promosyon.olustur');
                    Route::get('guncelle/{id}', 'PromosyonController@guncelleSayfa')->name('admin.promosyon.guncelle.sayfa');
                    Route::post('guncelle/{id}', 'PromosyonController@guncelle')->name('admin.promosyon.guncelle');
                    Route::get('/sil/{id}', 'PromosyonController@sil')->name('admin.promosyon.sil');
                });

            });

});

Route::group(['namespace' => 'MailYonetimi'], function(){
    Route::group(['prefix' => 'mail-yonetimi'], function(){
        Route::group(['prefix' => 'mail-gruplari'], function(){
            Route::get('/', 'MailGruplariController@index')->name('admin.mailGruplari');
            Route::get('olustur', 'MailGruplariController@olusturSayfa')->name('admin.mailGruplari.olustur.sayfa');
            Route::post('olustur', 'MailGruplariController@olustur')->name('admin.mailGruplari.olustur');
            Route::get('guncelle/{id}', 'MailGruplariController@guncelleSayfa')->name('admin.mailGruplari.guncelle.sayfa');
            Route::post('guncelle/{id}', 'MailGruplariController@guncelle')->name('admin.mailGruplari.guncelle');
            Route::get('sil/{id}', 'MailGruplariController@sil')->name('admin.mailGruplari.sil');
        });
        Route::group(['prefix' => 'mail-planla'], function(){
            Route::get('/', 'MailPlanlaController@index')->name('admin.mailPlanla');
            Route::get('olustur', 'MailPlanlaController@olusturSayfa')->name('admin.mailPlanla.olustur.sayfa');
            Route::post('olustur', 'MailPlanlaController@olustur')->name('admin.mailPlanla.olustur');
            Route::get('guncelle/{id}', 'MailPlanlaController@guncelleSayfa')->name('admin.mailPlanla.guncelle.sayfa');
            Route::post('guncelle/{id}', 'MailPlanlaController@guncelle')->name('admin.mailPlanla.guncelle');
            Route::get('sil/{id}', 'MailPlanlaController@sil')->name('admin.mailPlanla.sil');
            Route::get('ac', 'MailPlanlaController@hepsiniAc')->name('admin.mailPlanla.hepsiniAc');
            Route::get('kapat', 'MailPlanlaController@hepsiniKapat')->name('admin.mailPlanla.hepsiniKapat');
        });
        Route::group(['prefix' => 'mail-gonder'], function(){
            Route::get('/', 'MailGonderController@index')->name('admin.mailGonder');
            Route::get('olustur', 'MailGonderController@olusturSayfa')->name('admin.mailGonder.olustur.sayfa');
            Route::post('olustur', 'MailGonderController@olustur')->name('admin.mailGonder.olustur');
        });
    });
});

Route::group(['prefix' => 'tedarikci'], function () {
    Route::get('/', 'TedarikciController@index')->name('admin.tedarikci');
    Route::post('olustur', 'TedarikciController@olustur')->name('admin.tedarikci.olustur');
    Route::get('olustur-sayfa', 'TedarikciController@olusturSayfa')->name('admin.tedarikci.olustur.sayfa');
    Route::get('guncelle-sayfa/{id}', 'TedarikciController@guncelleSayfa')->name('admin.tedarikci.guncelle.sayfa');
    Route::post('guncelle/{id}', 'TedarikciController@guncelle')->name('admin.tedarikci.guncelle');
    Route::get('sil/{id}', 'TedarikciController@sil')->name('admin.tedarikci.sil');
});
Route::group(['prefix' => 'kargo'], function(){
    Route::get('/', 'KargoFiyatController@index')->name('admin.kargolar');
    Route::get('/{id}', 'KargoFiyatController@kargo_sayfa')->name('admin.kargo.fiyat.sayfa');
    Route::post('/kayit/{id}', 'KargoFiyatController@kargo')->name('admin.kargo.fiyat');
});

Route::group(['namespace' => 'Site'], function(){
    Route::group(['prefix' => 'site'], function(){
        Route::group(['prefix' => 'iletisim'], function(){
            Route::get('/', 'SiteIletisimController@index')->name('admin.site.iletisim');
            Route::post('/guncelle/{id}', 'SiteIletisimController@guncelle')->name('admin.site.iletisim.guncelle');
        });
        Route::group(['prefix' => 'medya'], function(){
            Route::get('/', 'SiteSosyalMedyaController@index')->name('admin.site.medya');
            Route::post('/guncelle/{id}', 'SiteSosyalMedyaController@guncelle')->name('admin.site.medya.guncelle');
        });
        Route::group(['prefix' => 'slider'], function(){
            Route::get('/', 'SiteSliderController@index')->name('admin.site.slider');
            Route::get('olustur-sayfa', 'SiteSliderController@olusturSayfa')->name('admin.site.slider.olustur.sayfa');
            Route::post('olustur', 'SiteSliderController@olustur')->name('admin.site.slider.olustur');
            Route::get('guncelle-sayfa/{id}', 'SiteSliderController@guncelleSayfa')->name('admin.site.slider.guncelle.sayfa');
            Route::post('guncelle/{id}', 'SiteSliderController@guncelle')->name('admin.site.slider.guncelle');
            Route::get('sil/{id}', 'SiteSliderController@sil')->name('admin.site.slider.sil');

            Route::get('pasif-yap/{id}', 'SiteSliderController@pasifYap')->name('admin.site.slider.pasifYap');
            Route::get('aktif-yap/{id}', 'SiteSliderController@aktifYap')->name('admin.site.slider.aktifYap');

            Route::get('sirala-sayfa', 'SiteSliderController@siralaSayfa')->name('admin.site.slider.sirala.sayfa');
            Route::post('sirala-guncelle', 'SiteSliderController@sirala')->name('admin.site.slider.sirala');
        });  
        Route::group(['prefix' => 'slider-dil/{slider}'], function () {
            Route::get('/', 'SiteSliderDilController@index')->name('admin.site.sliderDil');
            Route::post('olustur', 'SiteSliderDilController@olustur')->name('admin.site.sliderDil.olustur');
            Route::get('olustur-sayfa', 'SiteSliderDilController@olusturSayfa')->name('admin.site.sliderDil.olustur.sayfa');
            Route::get('guncelle-sayfa/{id}', 'SiteSliderDilController@guncelleSayfa')->name('admin.site.sliderDil.guncelle.sayfa');
            Route::post('guncelle/{id}', 'SiteSliderDilController@guncelle')->name('admin.site.sliderDil.guncelle');
            Route::get('sil/{id}', 'SiteSliderDilController@sil')->name('admin.site.sliderDil.sil');
        });
        Route::group(['prefix' => 'banner'], function(){
            Route::get('/', 'SiteBannerController@index')->name('admin.site.banner');
            Route::get('olustur-sayfa', 'SiteBannerController@olusturSayfa')->name('admin.site.banner.olustur.sayfa');
            Route::post('olustur', 'SiteBannerController@olustur')->name('admin.site.banner.olustur');
            Route::get('guncelle-sayfa/{id}', 'SiteBannerController@guncelleSayfa')->name('admin.site.banner.guncelle.sayfa');
            Route::post('guncelle/{id}', 'SiteBannerController@guncelle')->name('admin.site.banner.guncelle');
            Route::get('sil/{id}', 'SiteBannerController@sil')->name('admin.site.banner.sil');
            
            Route::get('pasif-yap/{id}', 'SiteBannerController@pasifYap')->name('admin.site.banner.pasifYap');
            Route::get('aktif-yap/{id}', 'SiteBannerController@aktifYap')->name('admin.site.banner.aktifYap');

            Route::get('sirala-sayfa', 'SiteBannerController@siralaSayfa')->name('admin.site.banner.sirala.sayfa');
            Route::post('sirala-guncelle', 'SiteBannerController@sirala')->name('admin.site.banner.sirala');
        });  
        Route::group(['prefix' => 'banner-dil/{banner}'], function () {
            Route::get('/', 'SiteBannerDilController@index')->name('admin.site.bannerDil');
            Route::post('olustur', 'SiteBannerDilController@olustur')->name('admin.site.bannerDil.olustur');
            Route::get('olustur-sayfa', 'SiteBannerDilController@olusturSayfa')->name('admin.site.bannerDil.olustur.sayfa');
            Route::get('guncelle-sayfa/{id}', 'SiteBannerDilController@guncelleSayfa')->name('admin.site.bannerDil.guncelle.sayfa');
            Route::post('guncelle/{id}', 'SiteBannerDilController@guncelle')->name('admin.site.bannerDil.guncelle');
            Route::get('sil/{id}', 'SiteBannerDilController@sil')->name('admin.site.bannerDil.sil');
        });
        Route::group(['prefix' => 'banner2'], function () {
            Route::get('/', 'SiteBanner2Controller@index')->name('admin.site.banner2');
            Route::post('olustur', 'SiteBanner2Controller@olustur')->name('admin.site.banner2.olustur');
            Route::get('olustur-sayfa', 'SiteBanner2Controller@olusturSayfa')->name('admin.site.banner2.olustur.sayfa');
            Route::get('guncelle-sayfa/{id}', 'SiteBanner2Controller@guncelleSayfa')->name('admin.site.banner2.guncelle.sayfa');
            Route::post('guncelle/{id}', 'SiteBanner2Controller@guncelle')->name('admin.site.banner2.guncelle');
            Route::get('sil/{id}', 'SiteBanner2Controller@sil')->name('admin.site.banner2.sil');
        });
        Route::group(['prefix' => 'sss'], function () {
            Route::get('/', 'SSSController@index')->name('admin.sss');
            Route::post('olustur', 'SSSController@olustur')->name('admin.sss.olustur');
            Route::get('olustur-sayfa', 'SSSController@olusturSayfa')->name('admin.sss.olustur.sayfa');
            Route::get('guncelle-sayfa/{id}', 'SSSController@guncelleSayfa')->name('admin.sss.guncelle.sayfa');
            Route::post('guncelle/{id}', 'SSSController@guncelle')->name('admin.sss.guncelle');
            Route::get('sil/{id}', 'SSSController@sil')->name('admin.sss.sil');

            Route::get('pasif-yap/{id}', 'SSSController@pasifYap')->name('admin.sss.pasifYap');
            Route::get('aktif-yap/{id}', 'SSSController@aktifYap')->name('admin.sss.aktifYap');

            Route::get('sirala-sayfa', 'SSSController@siralaSayfa')->name('admin.sss.sirala.sayfa');
            Route::post('sirala-guncelle', 'SSSController@sirala')->name('admin.sss.sirala');
        });

        Route::group(['prefix' => 'sss-dil/{sss}'], function () {
            Route::get('/', 'SSSDilController@index')->name('admin.sssDil');
            Route::post('olustur', 'SSSDilController@olustur')->name('admin.sssDil.olustur');
            Route::get('olustur-sayfa', 'SSSDilController@olusturSayfa')->name('admin.sssDil.olustur.sayfa');
            Route::get('guncelle-sayfa/{id}', 'SSSDilController@guncelleSayfa')->name('admin.sssDil.guncelle.sayfa');
            Route::post('guncelle/{id}', 'SSSDilController@guncelle')->name('admin.sssDil.guncelle');
            Route::get('sil/{id}', 'SSSDilController@sil')->name('admin.sssDil.sil');
        });

        Route::group(['prefix' => 'sss-detay'], function () {
            Route::get('/{sss}', 'SSSDetayController@index')->name('admin.sss.detay');
            Route::post('olustur/{sss}', 'SSSDetayController@olustur')->name('admin.sss.detay.olustur');
            Route::get('guncelle-sayfa/{id}', 'SSSDetayController@guncelleSayfa')->name('admin.sss.detay.guncelle.sayfa');
            Route::post('guncelle/{id}', 'SSSDetayController@guncelle')->name('admin.sss.detay.guncelle');
            Route::get('sil/{id}', 'SSSDetayController@sil')->name('admin.sss.detay.sil');

            Route::get('pasif-yap/{id}', 'SSSDetayController@pasifYap')->name('admin.sss.detay.pasifYap');
            Route::get('aktif-yap/{id}', 'SSSDetayController@aktifYap')->name('admin.sss.detay.aktifYap');

            Route::get('sirala/sayfa/{id}', 'SSSDetayController@siralaSayfa')->name('admin.sss.detay.sirala.sayfa');
            Route::post('sirala/guncelle/{id}', 'SSSDetayController@sirala')->name('admin.sss.detay.sirala');
        });
        Route::group(['prefix' => 'sss-detay-dil/{detay_id}'], function () {
            Route::get('/', 'SSSDetayDilController@index')->name('admin.sssDetayDil');
            Route::post('olustur', 'SSSDetayDilController@olustur')->name('admin.sssDetayDil.olustur');
            Route::get('olustur-sayfa', 'SSSDetayDilController@olusturSayfa')->name('admin.sssDetayDil.olustur.sayfa');
            Route::get('guncelle-sayfa/{id}', 'SSSDetayDilController@guncelleSayfa')->name('admin.sssDetayDil.guncelle.sayfa');
            Route::post('guncelle/{id}', 'SSSDetayDilController@guncelle')->name('admin.sssDetayDil.guncelle');
            Route::get('sil/{id}', 'SSSDetayDilController@sil')->name('admin.sssDetayDil.sil');
        });
        Route::group(['prefix' => 'sozlesme'], function () {
            Route::get('/', 'SozlesmelerController@index')->name('admin.sozlesme');
            Route::post('olustur', 'SozlesmelerController@olustur')->name('admin.sozlesme.olustur');
            Route::get('olustur-sayfa', 'SozlesmelerController@olusturSayfa')->name('admin.sozlesme.olustur.sayfa');
            Route::get('guncelle-sayfa/{id}', 'SozlesmelerController@guncelleSayfa')->name('admin.sozlesme.guncelle.sayfa');
            Route::post('guncelle/{id}', 'SozlesmelerController@guncelle')->name('admin.sozlesme.guncelle');
            Route::get('sil/{id}', 'SozlesmelerController@sil')->name('admin.sozlesme.sil');
        });

        Route::group(['prefix' => 'sozlesme-dil/{sozlesme}'], function () {
            Route::get('/', 'SozlesmelerDilController@index')->name('admin.sozlesmeDil');
            Route::get('olustur-sayfa', 'SozlesmelerDilController@olusturSayfa')->name('admin.sozlesmeDil.olustur.sayfa');
            Route::post('olustur', 'SozlesmelerDilController@olustur')->name('admin.sozlesmeDil.olustur');
            Route::get('guncelle-sayfa/{id}', 'SozlesmelerDilController@guncelleSayfa')->name('admin.sozlesmeDil.guncelle.sayfa');
            Route::post('guncelle/{id}', 'SozlesmelerDilController@guncelle')->name('admin.sozlesmeDil.guncelle');
            Route::get('sil/{id}', 'SozlesmelerDilController@sil')->name('admin.sozlesmeDil.sil');
        });
    });
});

Route::group(['prefix' => 'etkilisim'], function(){
    Route::get('/', 'BultenController@index')->name('admin.bulten');
    Route::get('/{id}', 'KargoFiyatController@kargo_sayfa')->name('admin.kargo.fiyat.sayfa');
    Route::post('/kayit/{id}', 'KargoFiyatController@kargo')->name('admin.kargo.fiyat');
});

Route::group(['namespace' => 'Iade'], function(){
    Route::group(['prefix' => 'iade'], function(){
        Route::group(['prefix' => 'sorular'], function () {
            Route::get('/', 'IadeSorularController@index')->name('admin.iade.sorular');
            Route::post('olustur', 'IadeSorularController@olustur')->name('admin.iade.sorular.olustur');
            Route::get('olustur-sayfa', 'IadeSorularController@olusturSayfa')->name('admin.iade.sorular.olustur.sayfa');
            Route::get('guncelle-sayfa/{id}', 'IadeSorularController@guncelleSayfa')->name('admin.iade.sorular.guncelle.sayfa');
            Route::post('guncelle/{id}', 'IadeSorularController@guncelle')->name('admin.iade.sorular.guncelle');
            Route::get('sil/{id}', 'IadeSorularController@sil')->name('admin.iade.sorular.sil');

            Route::get('pasif-yap/{id}', 'IadeSorularController@pasifYap')->name('admin.iade.sorular.pasifYap');
            Route::get('aktif-yap/{id}', 'IadeSorularController@aktifYap')->name('admin.iade.sorular.aktifYap');
        });
        Route::group(['prefix' => 'sorular-dil/{soru}'], function () {
            Route::get('/', 'IadeSorularDilController@index')->name('admin.iade.sorularDil');
            Route::post('olustur', 'IadeSorularDilController@olustur')->name('admin.iade.sorularDil.olustur');
            Route::get('olustur-sayfa', 'IadeSorularDilController@olusturSayfa')->name('admin.iade.sorularDil.olustur.sayfa');
            Route::get('guncelle-sayfa/{id}', 'IadeSorularDilController@guncelleSayfa')->name('admin.iade.sorularDil.guncelle.sayfa');
            Route::post('guncelle/{id}', 'IadeSorularDilController@guncelle')->name('admin.iade.sorularDil.guncelle');
            Route::get('sil/{id}', 'IadeSorularDilController@sil')->name('admin.iade.sorularDil.sil');
        });
        Route::group(['prefix' => 'onay'], function () {
            Route::get('/', 'IadelerController@index')->name('admin.iade.iadeler');
            Route::post('detay/{id}', 'IadelerController@detay')->name('admin.iade.iadeler.detay');
            Route::get('onayla/{id}', 'IadelerController@onayla')->name('admin.iade.iadeler.onayla');
            Route::get('red/{id}', 'IadelerController@red')->name('admin.iade.iadeler.red'); 
        });
        Route::group(['prefix' => 'onaylanmis-iadeler'], function () {
            Route::get('/', 'OnaylanmisIadelerController@index')->name('admin.iade.onaylanmis.iadeler');
            Route::post('detay/{id}', 'OnaylanmisIadelerController@detay')->name('admin.iade.onaylanmis.iadeler.detay');
            Route::get('onayla/{id}', 'OnaylanmisIadelerController@ode')->name('admin.iade.onaylanmis.iadeler.ode');
            Route::get('red/{id}', 'OnaylanmisIadelerController@geri')->name('admin.iade.onaylanmis.iadeler.geri'); 
        });
    });
});


});
});


