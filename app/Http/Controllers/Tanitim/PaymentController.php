<?php

namespace App\Http\Controllers\Tanitim;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FonksiyonlarController;
use App\GenelFonksiyonlar;
use Illuminate\Http\Request;
use Iyzipay\Model\{Address, BasketItem, BasketItemType, Buyer, CheckoutFormInitialize, Currency, Locale, Payment, PaymentGroup, ThreedsInitialize};
use Iyzipay\Options;
use Iyzipay\Request\{CreateCheckoutFormInitializeRequest, CreatePaymentRequest};
use Illuminate\Support\Facades\Cookie;
use Cart;
use Auth;
use Mail;
use App\Models\{Siparis, Sepet, Ulke, UlkeKod, Urun, Adres, SepetUygulananIndirim, KargoFiyat, SepetOdeme,SepetUrun, SiparisKurumsal, Ziyaretci, ZiyaretciUser};
use App\Http\Middlware\VerifyCsrfToken;
use App\Models\Site\{Sozlesmeler};

class PaymentController extends Controller
{
	public function ulkeIdBul(){
		$ipUlke = GenelFonksiyonlar::getIp();
		$ip = $ipUlke['ip'];
		$ulkeKod = $ipUlke['ulkeKod'];

		$ulkeKod = UlkeKod::where('kod', $ulkeKod)->first();
		$ulke = Ulke::where('ulke_kod_id', $ulkeKod->id)->first();

		return $ulke;
	}
	
	public function loginOdeme(){
		return view('tanitim.loginOdeme');
	}

	public function index(){
		$ulkeDetay = $this->ulkeIdBul();
		$ziyaretciId = Cookie::get('ziyaretci_id');
		$sepetId = Sepet::aktif_sepet_id(); 
		$sepetVarMi = Sepet::find($sepetId);
		if(!isset($sepetVarMi)){
			return redirect()->route('sepet');
		}
		$siparisVarMi = Siparis::where('sepet_id', $sepetVarMi->id)->first();
		$sepetUrun = SepetUrun::where('sepet_id', $sepetId)->first();
		if(!isset($sepetUrun)){
			return redirect()->route('sepet');
		}
		$odeme = SepetOdeme::where('sepet_id', $sepetId)->first();
		$sozlesme = Sozlesmeler::where('odeme_durum', 1)->get();
		$toplam = null;
		$indirimTutari = null;
		$SepetindirimTutari = null;
		$indirimXalYode = null;
		$kargoFiyat = null;

		if (isset($sepetVarMi)) {
			if (!isset($siparisVarMi)) {
				$siparis = new Siparis;
				$siparis->sepet_id = $sepetId;
				$siparis->sepet_odeme_id = $odeme->id;
				$siparis->ziyaretci_id = $ziyaretciId;
				$siparis->save();
			}	

		}

		$urunler = Urun::orderByDesc('created_at')->get();

		$indirim = SepetUygulananIndirim::where('sepet_id', $sepetId)->where('indirim_turu', 4)->first(); 
		$kargo = KargoFiyat::where('ulke_id', $ulkeDetay->id)->first();
		if (isset($odeme)) {
			$toplam = $odeme->toplam;
			$indirimTutari = $odeme->indirimTutari;
			$SepetindirimTutari = $odeme->SepetindirimTutari;
			$indirimXalYode = $odeme->indirimXalYode;
			$kargoFiyat = $odeme->kargoFiyat;
		}else{
			return redirect()->route('sepet');
		}
		if ($sepetUrun->created_at > $odeme->created_at) {
			return redirect()->route('sepet');

		}

		$urunAdetToplam = null;
		$urunToplam = null;
		$toplamFiyat = null;
		$sepetNav = Sepet::where('ziyaretci_id', $ziyaretciId)->orderBy('created_at','desc')->first();

		$sepetNavUrun = SepetUrun::where('sepet_id', $sepetNav->id)->get();

		foreach($sepetNavUrun as $sepetUrun){
			$urunToplam = $sepetUrun->fiyati * $sepetUrun->adet;
			$urunAdetToplam += $sepetUrun->adet;
			$toplamFiyat += $urunToplam;

			$toplamFiyat = number_format($toplamFiyat, 2);
		}
		if (Auth::check()) {
			$user = ZiyaretciUser::where('ziyaretci_id', $ziyaretciId)->first();

			$user_id = $user->user_id;
			$ziyaretciler = ZiyaretciUser::where('user_id', $user_id)->get();
			foreach($ziyaretciler as $ziyaretci){
				$adresler[] = Adres::where('ziyaretci_id', $ziyaretci->ziyaretci_id)->where('durum', 1)->orderBy('created_at', 'desc')->first();
			}
		}else{
			$adresler = Adres::where('ziyaretci_id', $ziyaretciId)->where('durum', 1)->orderBy('created_at', 'desc')->get();
		}
		$adresSay = 0;
		foreach($adresler as $adres){
			if ($adres != null) {
				$adresSay ++;
			}		

		} 

		$siparis = $siparisVarMi;
		return view('tanitim.odeme', compact('ulkeDetay','sepetNavUrun','toplamFiyat','adresler','siparis','indirim', 'toplam','kargoFiyat', 'indirimTutari', 'SepetindirimTutari', 'indirimXalYode', 'sozlesme','adresSay'));
	}

	public function payment(){
		$data = request()->all();
		$tarih = explode("/", $data['ay_yil']);
		$data['Ecom_Payment_Card_ExpDate_Month'] = $tarih[0];
		$data['Ecom_Payment_Card_ExpDate_Year'] = $tarih[1];
		$sepetId = Sepet::aktif_sepet_id(); 
		$siparis = Siparis::where('sepet_id', $sepetId)->first(); 
		$odeme = SepetOdeme::where('sepet_id', $sepetId)->first();
		$sepet = Sepet::find($sepetId);
		$ulke = Ulke::find($sepet->ulke_id);
		$data['pan'] = str_replace(' ','',$data['pan']);
		$ziyaretciId = Cookie::get('ziyaretci_id'); 
		$ziyaretci = Ziyaretci::find($ziyaretciId);

		$toplamTutar = $odeme->toplam;
		$kullaniciId = $ziyaretciId;
		$kullaniciAd = $siparis->adres_bul['isim'];
		$kullaniciEmail = "info@pethepsi.com";
		$ip = $_SERVER['REMOTE_ADDR'];

		$kargo = $odeme->kargoFiyat; 
		$paraBirimi = $ulke->para_birimi_getir['ad'];
		$ulkeAd = $ulke->ulke_kod_getir['ad'];


		$options = new \Iyzipay\Options();
		$options->setApiKey('aL0Mv30bYVRPDtl4JLIyH35AlcswY1yF');
		$options->setSecretKey('yHZTwHTXwnVp8X2FF5fPsRoZIloEG2Sv');
		$options->setBaseUrl('https://api.iyzipay.com');

		$request = new CreatePaymentRequest();
		$request->setLocale(Locale::TR);
		$request->setConversationId(rand(1,10000));
		$request->setPrice($toplamTutar);
		$request->setPaidPrice($toplamTutar);
		if($paraBirimi == 'Türk Lirası'){
			$request->setCurrency(Currency::TL);
		}elseif($paraBirimi == 'Amerikan Doları'){
			$request->setCurrency(Currency::USD);
		}elseif($paraBirimi == 'Euro'){
			$request->setCurrency(Currency::EUR);
		}elseif($paraBirimi == 'İngiliz Sterlini'){
			$request->setCurrency(Currency::GBP);
		}
		$request->setInstallment(1);
		//$request->setBasketId("B67832");
		$request->setPaymentChannel(\Iyzipay\Model\PaymentChannel::WEB);
		$request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT); 
		$request->setCallbackUrl("https://pethepsi.com/payment/callback/");

		$paymentCard = new \Iyzipay\Model\PaymentCard();
		$paymentCard->setCardHolderName($data['kart_ismi']);
		$paymentCard->setCardNumber($data['pan']);
		$paymentCard->setExpireMonth($data['Ecom_Payment_Card_ExpDate_Month']);
		$paymentCard->setExpireYear($data['Ecom_Payment_Card_ExpDate_Year']);
		$paymentCard->setCvc($data['cv2']);
		$paymentCard->setRegisterCard(0);
		$request->setPaymentCard($paymentCard);

		$buyer = new Buyer();
		$buyer->setId($kullaniciId);
		$buyer->setName($kullaniciAd);
		$buyer->setSurname($kullaniciAd);
		$buyer->setGsmNumber($siparis->adres_bul['isim']);
		$buyer->setEmail($kullaniciEmail);
		if(isset($siparis->adres_bul['kimlik_no'])){
			$buyer->setIdentityNumber($siparis->adres_bul['kimlik_no']);
		}else{
			$buyer->setIdentityNumber("11111111111");
		}
		//$buyer->setLastLoginDate("2015-10-05 12:43:35");
		//$buyer->setRegistrationDate("2013-04-21 15:12:09");
		$buyer->setRegistrationAddress($siparis->adres_bul['adres']);
		$buyer->setIp($ip);
		$buyer->setCity($siparis->adres_bul['il']);
		$buyer->setCountry($ulkeAd);
		if(isset($siparis->adres_bul['postakodu'])){
			$buyer->setZipCode($siparis->adres_bul['postakodu']);
		}else{
			$buyer->setZipCode('34000');
		}
		$request->setBuyer($buyer);

		$billingAddress = new Address();
		$billingAddress->setContactName($kullaniciAd);
		$billingAddress->setCity($siparis->adres_bul['il']);
		$billingAddress->setCountry($ulkeAd);
		$billingAddress->setAddress($siparis->adres_bul['adres']);
		if(isset($siparis->adres_bul['postakodu'])){
			$billingAddress->setZipCode($siparis->adres_bul['postakodu']);
		}else{
			$billingAddress->setZipCode('34000');
		};
		$request->setBillingAddress($billingAddress);

		$shippingAddress = new Address();
		$shippingAddress->setContactName($kullaniciAd);
		$shippingAddress->setCity($siparis->adres_bul['il']);
		$shippingAddress->setCountry($ulkeAd);
		$shippingAddress->setAddress($siparis->adres_bul['adres']);
		if(isset($siparis->adres_bul['postakodu'])){
			$shippingAddress->setZipCode($siparis->adres_bul['postakodu']);
		}else{
			$shippingAddress->setZipCode('34000');
		}; 
		$request->setShippingAddress($shippingAddress);
		$basketItems = array();

		$firstBasketItem = new BasketItem();
		$firstBasketItem->setId(1);
		$firstBasketItem->setName("pey");
		$firstBasketItem->setCategory1('pet');
			//$firstBasketItem->setCategory2("Accessories");
		$firstBasketItem->setItemType(BasketItemType::PHYSICAL);
		$firstBasketItem->setPrice($toplamTutar);

		$basketItems[0] = $firstBasketItem;
		
		$request->setBasketItems($basketItems);

		$payment = ThreedsInitialize::create($request, $options);

		print_r($payment->getHtmlContent());

		return back()
		->with('mesaj_tur', 'danger')
		->with('mesaj', 'İşlem Başarısız.');

	}
	public function paymentCallback(){
	$ziyaretciId = Cookie::get('ziyaretci_id'); 
		$ulkeDetay = $this->ulkeIdBul();  
		$siparis = Siparis::where('ziyaretci_id', $ziyaretciId)->orderBy('created_at', 'desc')->first();
		foreach($siparis->sepet_urun_getir as $urun){
			$urunBul = Urun::where('id', $urun->urun_id)->first();
			$sonStok = $urunBul->stok - $urun->adet;
			$urunBul->stok = $sonStok;
			$urunBul->save(); 

		}
		$siparis->islem_durum = 1;
		$siparis->save();
		Sepet::create(['ziyaretci_id'=>$ziyaretciId, 'ulke_id' => $ulkeDetay->id]);

		/*
		if($siparis->id){
			Mail::raw('Yeni bir sipariş var. Sipariş detayları için yönetici paneline gidebilirsiniz. https://xxxx.com/admin', function($message){
				$message->from('shop@xxxx.com');
				$message->to('shop@xxxx.com');
				$message->subject('Yeni Sipariş');
			});
		}else{
			return redirect()->route('/');
		}
		*/ 
		return redirect()->route('hesabim.siparislerim')
		->with('mesaj_tur', 'success')
		->with('mesaj', 'Sipariş başarılı.');
	}

	public function adresKayit($id){
		$ziyaretciId = Cookie::get('ziyaretci_id');
		$sepetVarMi = Sepet::where('ziyaretci_id',$ziyaretciId)->orderBy('created_at', 'desc')->first();
		$siparis = Siparis::where('sepet_id', $sepetVarMi->id)->first();

		$siparis->update([
			'adres_id' => $id
		]);
		return true;
	}

	public function adresFaturaKayit($id){
		$ziyaretciId = Cookie::get('ziyaretci_id');
		$sepetVarMi = Sepet::where('ziyaretci_id',$ziyaretciId)->orderBy('created_at', 'desc')->first();
		$siparis = Siparis::where('sepet_id', $sepetVarMi->id)->first();

		$siparis->update([
			'fatura_adres_id' => $id
		]);
		return true;
	}

	public function adresFaturaKayitKapat(){
		$ziyaretciId = Cookie::get('ziyaretci_id');
		$sepetVarMi = Sepet::where('ziyaretci_id',$ziyaretciId)->orderBy('created_at', 'desc')->first();
		$siparis = Siparis::where('sepet_id', $sepetVarMi->id)->first();
		$siparis->update([
			'fatura_adres_id' => null
		]);
		return true;
	}



}
