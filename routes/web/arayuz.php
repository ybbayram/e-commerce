<?php

Route::group(['namespace' => 'Tanitim'], function(){
	Route::get('/', 'IndexController@index')->name('index');
	Route::get('/sepet-api', 'IndexController@sepetApi')->name('sepetApi');
	Route::get('about-us', 'IndexController@hakkimizda')->name('hakkimizda');
	Route::get('p', 'IndexController@pYonlendir')->name('p');
	Route::get('login-register', 'LoginController@loginSayfa')->name('loginSayfa'); 
	Route::get('app-privacy-policy', 'IndexController@appGizlilik')->name('appGizlilik');
	Route::get('oturum-kapat', 'LoginController@oturumKapat')->name('cikisYap');
	Route::post('login-post', 'LoginController@login')->name('login');
	Route::post('register-post', 'LoginController@register')->name('register');
	Route::get('forgot-password', 'LoginController@forgotPassword')->name('forgotPassword');
	Route::post('forgot-password-post', 'LoginController@forgotPasswordPost')->name('forgotPasswordPost');
	Route::get('password-reset/{token}', 'LoginController@sifreYenileme')->name('sifreYenileme');
	Route::post('password-reset-post', 'LoginController@sifreYenilemePost')->name('sifreYenilemePost');
	Route::post('search', 'IndexController@search')->name('search');
	Route::get('search', function () {
		return redirect('/');
	});
	Route::get('search/{aranan?}', 'IndexController@searchArama')->name('searchArama');
	//Route::get('kdv', 'ZiyaretciController@kdv')->name('kdv'); 

	Route::group(['prefix' => 'address'], function(){ 
		Route::post('create', 'AdresController@olustur')->name('adres.olustur');
		Route::get('update/{id}', 'AdresController@guncelleSayfa')->name('adres.guncelle.sayfa');
		Route::post('update/{id}', 'AdresController@guncelle')->name('adres.guncelle');
		Route::get('delete/{id}', 'AdresController@sil')->name('adres.sil');
	});
	Route::group(['prefix' => 'cart'], function(){
		Route::get('/', 'CartController@index')->name('sepet');
		Route::get('add/{id}', 'CartController@add')->name('sepete.ekle');
		Route::get('/api/add/{id}', 'CartController@cartApi');
		Route::get('/api/remove/{id}', 'CartController@cartApiKaldir');
		Route::get('update/api/{id}/{deger}', 'CartController@cartApiGuncelle')->name('sepet.api.guncelle');
		Route::get('remove/{rowid}', 'CartController@kaldir')->name('sepet.kaldir');
		Route::get('update/{rowId}', 'CartController@guncelle')->name('sepet.guncelle');

		Route::post('/', 'CartIndirimController@kuponIndirim')->name('kupon.indirim.uygula');
	});
	Route::group(['prefix' => 'favorite'], function(){
		Route::get('/', 'FavoriController@index')->name('favori');
		Route::get('add/{id}', 'FavoriController@olustur')->name('favori.ekle');
		Route::get('remove/{id}', 'FavoriController@sil')->name('favori.sil');
	});
	Route::group(['prefix' => 'contact'], function(){
		Route::get('/', 'IletisimController@index')->name('iletisim');
		Route::post('send', 'IletisimController@olustur')->name('iletisim.mesajGonder');
	});
	Route::group(['prefix' => 'my-account'], function(){
		Route::get('/', 'MyAccountController@index')->name('hesabim');
		Route::get('change-password', 'MyAccountController@sifreDegisSayfa')->name('hesabim.sifreDegis.sayfa');
		Route::post('change-password', 'MyAccountController@sifreDegis')->name('hesabim.sifreDegis');
		Route::get('my-orders', 'MyAccountController@siparislerim')->name('hesabim.siparislerim');
		Route::get('notifications', 'MyAccountController@bildirimSayfa')->name('hesabim.bildirimler.sayfa');
		Route::post('notifications', 'MyAccountController@bildirim')->name('hesabim.bildirimler');
		Route::get('panel', 'MyAccountController@panel')->name('hesabim.panel');
		Route::get('my-address', 'MyAccountController@adreslerim')->name('hesabim.adreslerim');
		Route::get('reviews', 'MyAccountController@degerlendirmeler')->name('hesabim.degerlendirmeler');
		Route::post('reviews/{id}', 'MyAccountController@guncelle')->name('hesabim.degerlendirmeler.guncelle');
		Route::get('reviews/delete/{id}', 'MyAccountController@sil')->name('hesabim.degerlendirmeler.sil');
	});
	Route::group(['prefix' => 'payment'], function(){
		Route::get('/', 'PaymentController@index')->name('odeme');
		Route::get('/login-register', 'PaymentController@loginOdeme')->name('loginOdeme');
		Route::post('post', 'PaymentController@payment')->name('odeme.post');
		Route::get('callback', 'PaymentController@paymentCallback')->name('odeme.callback');
		Route::get('adress/save/{id}', 'PaymentController@adresKayit')->name('odeme.adresKayit');
		Route::get('adress/invoice/save/{id}', 'PaymentController@adresFaturaKayit')->name('odeme.adresFaturaKayit');

		Route::get('adress/invoice/cancel', 'PaymentController@adresFaturaKayitKapat')->name('odeme.adresFaturaKayit.kapat');
	});
	Route::group(['prefix' => 'shop'], function(){
		Route::get('/', 'ShopController@shop')->name('shop');
		Route::get('/{kategori}', 'ShopController@kategori')->name('shop.kategori');
		Route::post('/{kategori}', 'ShopController@kategoriFilter')->name('shop.kategori');
		Route::get('/{kategori}/filtre', 'ShopController@kategoriFilter')->name('shop.kategori.filtre');
		Route::get('/{kategori}/{kategoriAlt}', 'ShopController@kategoriAlt')->name('shop.kategoriAlt');
		Route::post('/{kategori}/{kategoriAlt}', 'ShopController@kategoriAltFilter')->name('shop.kategoriAlt');
		Route::get('/{kategori}/{kategoriAlt}/filtre', 'ShopController@kategoriAltFilter')->name('shop.kategoriAlt.filtre');

	});
	Route::group(['prefix' => 'tag'], function(){
		Route::get('/{etiket}', 'TagController@etiket')->name('shop.etiket');
		Route::post('/{etiket}', 'TagController@etiketFilter')->name('shop.etiket');
		Route::get('/{etiket}/filtre', 'TagController@etiketFilter')->name('shop.etiket.filtre');
		
	});
	Route::group(['prefix' => 'brand'], function(){
		Route::get('/{marka}', 'MarkaController@marka')->name('shop.marka'); 		
	});
	Route::group(['prefix' => 'comments'], function(){
		Route::post('/{user_id}/{urun_id}', 'ShopController@yorum')->name('shop.yorum'); 		
	});
	
	Route::get('/p/{urun}', 'ShopController@urun')->name('urun');
	Route::get('/p/{urun_id}/{user_id}/new', 'ShopController@urunHaberVer')->name('urun.haber');
	Route::get('/comments/{urun}', 'ShopController@yorumlar')->name('yorumlar');
	
	Route::group(['prefix' => 'faq'], function(){
		Route::get('/', 'YardimController@sss')->name('sss');
		Route::get('/{sss}', 'YardimController@sssDetay')->name('sss.detay');
		Route::post('/search', 'YardimController@search')->name('sss.search');
	});
	Route::post('/bulletin', 'IndexController@kayit')->name('bulten');
	Route::get('/contracts/{slug}', 'IndexController@sozlesmeler')->name('sozlesmeler');
	Route::post('/return/{siparis_id}/{user_id}', 'IadeTalepleriController@iadeTalep')->name('iade'); 
	Route::get('/return/cancel/{id}', 'IadeTalepleriController@iptal')->name('iade.iptal');

	Route::get('/about-us', 'MyAccountController@about')->name('tanitim.about');
	Route::get('/tel', 'MyAccountController@tel')->name('tanitim.tel');

});