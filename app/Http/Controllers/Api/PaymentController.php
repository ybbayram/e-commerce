<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\FonksiyonlarController;
use App\GenelFonksiyonlar;
use Illuminate\Http\Request;
use Iyzipay\Model\{Address, BasketItem, BasketItemType, Buyer, CheckoutFormInitialize, Config, Currency, Locale, Payment, PaymentGroup, ThreedsInitialize};
use Iyzipay\Options;
use Iyzipay\Request\{CreateCheckoutFormInitializeRequest, CreatePaymentRequest};
use Illuminate\Support\Facades\Cookie;
use Cart;
use Auth;
use Mail;
use App\Models\{Siparis, Sepet, SepetUrun, Ulke, UlkeKod, Urun, Adres, SepetUygulananIndirim, KargoFiyat, SepetOdeme, Ziyaretci};

class PaymentController extends ApiController
{
    public function ulkeIdBul(){
        $ipUlke = GenelFonksiyonlar::getIp();
        $ip = $ipUlke['ip'];
        $ulkeKod = $ipUlke['ulkeKod'];

        $ulkeKod = UlkeKod::where('kod', $ulkeKod)->first();
        $ulke = Ulke::where('ulke_kod_id', $ulkeKod->id)->first();

        return $ulke;
    }


    public function payment(Request $request){
        $data = $request->all();
        $giris = $data['giris'];
        $veri = $data['veri'];

        if($giris['guvenlik_bir'] == 153 and $giris['guvenlik_iki'] == 7825810){
            $ziyaretci = Ziyaretci::where('token', $veri['token'])->first();
            $aktif_sepet_id = Sepet::aktif_sepet_id_mobil($veri['token']);
           $sepetId = Sepet::aktif_sepet_id_mobil($veri['token']);
            $odeme = SepetOdeme::where('sepet_id', $sepetId)->orderBy('created_at', 'desc')->first();

            $siparis = Siparis::firstOrCreate(
                [
                'sepet_id' => $aktif_sepet_id,
                ],
                [
                'sepet_id' => $aktif_sepet_id,
                'sepet_odeme_id' => $odeme->id,
                'ziyaretci_id' => $ziyaretci->id,
                'adres_id' => $veri['adres_id'],
                'fatura_adres_id' => $veri['fatura_adres_id'],
                'platform' => 20,
                'islem_durum' => 0
            ]);
            
            $toplamTutar = $veri['total'];
            $kullaniciId = $ziyaretci->id;
            $kullaniciAd = $siparis->adres_bul['isim'];
            $kullaniciEmail = "info@pethepsi.com";
            $ip = $_SERVER['REMOTE_ADDR'];

      
            $sepet = Sepet::find($sepetId);
            $ulke = Ulke::find($sepet->ulke_id);


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
		$request->setBasketId($siparis->id);
		$request->setPaymentChannel(\Iyzipay\Model\PaymentChannel::WEB);
		$request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT); 
		//$request->setCallbackUrl("https://pethepsi.com/payment/callback/");

		$paymentCard = new \Iyzipay\Model\PaymentCard();
		$paymentCard->setCardHolderName($veri['kart_ismi']);
		$paymentCard->setCardNumber($veri['pan']);
		$paymentCard->setExpireMonth($veri['Ecom_Payment_Card_ExpDate_Month']);
		$paymentCard->setExpireYear($veri['Ecom_Payment_Card_ExpDate_Year']);
		$paymentCard->setCvc($veri['cv2']);
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
		
		
		
		$buyer->setLastLoginDate("2015-10-05 12:43:35");
		$buyer->setRegistrationDate("2013-04-21 15:12:09");
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
		$firstBasketItem->setCategory2("Accessories");
		$firstBasketItem->setItemType(BasketItemType::PHYSICAL);
		$firstBasketItem->setPrice($toplamTutar);

	
		$basketItems[0] = $firstBasketItem;
		
		$request->setBasketItems($basketItems);

            $payment = Payment::create($request, $options);
            print_r($payment);
      
        }
    }
    
    public function odemeBasarili(Request $request){
        $data = $request->all();
        $giris = $data['giris'];
        $veri = $data['veri'];

        if($giris['guvenlik_bir'] == 153 and $giris['guvenlik_iki'] == 7825810){
            $ziyaretci = Ziyaretci::where('token', $veri['token'])->first();
           $sepetId = Sepet::aktif_sepet_id_mobil($veri['token']);
           $siparis = Siparis::where('sepet_id', $sepetId)->orderBy('created_at', 'desc')->first();
           foreach($siparis->sepet_urun_getir as $urun){
    			$urunBul = Urun::where('id', $urun->urun_id)->first();
    			$sonStok = $urunBul->stok - $urun->adet;
    			$urunBul->stok = $sonStok;
    			$urunBul->save(); 
		    }
           $siparis->islem_durum = 1;
           $siparis->save();
           
           $ulke = $this->ulkeIdBul();
           
           $aktif_sepet = Sepet::create([
                'ziyaretci_id' => $ziyaretci->id,
                'ulke_id' => $ulke->id
            ]);
           
           return response()->json(['response' => 1]);
        }                                  
    }



}
