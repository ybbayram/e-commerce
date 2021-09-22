<?php

namespace App\Http\Controllers\Tanitim;

use App\Http\Controllers\Controller;
use App\GenelFonksiyonlar;
use App\Http\Controllers\FonksiyonlarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\User;
use App\Models\{Sepet, SepetUrun,Favori ,ZiyaretciUser, Urun, UrunFiyat, Ziyaretci, Dil, Ulke, UlkeKod, CesitDetay, CesitFiyat, ForgotPassword};
use App\Models\Site\{Sozlesmeler};
use Cart;
use Cookie;
use Auth;
use Mail;

class LoginController extends Controller
{
	public function ulkeIdBul()
	{

		$ipUlke = GenelFonksiyonlar::getIp();
		$ip = $ipUlke['ip'];
		$ulkeKod = $ipUlke['ulkeKod'];

		$ulkeKod = UlkeKod::where('kod', $ulkeKod)->first();
		$ulke = Ulke::where('ulke_kod_id', $ulkeKod->id)->first();

		if (isset($ulke->id)) {
			return $ulke->id;
		} else {
			return 0;
		}
	}

	public function loginSayfa()
	{
		if (Auth::check()) {
			return redirect('/');
		} 

		return view('tanitim.login');
	}
	public function register()
	{
		$data = request()->all();
		if (!isset($data['kvkk'])) {
			$data['kvkk'] = "0";
		}
		$this->validate(request(), [
			'email' => 'required|email|unique:users',
			'password' => 'required|confirmed|min:5|max:60'
		]);
		$ziyaretciId = Cookie::get('ziyaretci_id');

		$user = User::create([
			'email' => $data['email'],
			'password' => Hash::make($data['password']),
			'ad' => $data['ad'],
			'kvkk' => $data['kvkk'],
			'user_token' => time() . Str::random(60)
		]);

		$ziyaretci_user = ZiyaretciUser::create([
			'user_id' => $user->id,
			'ziyaretci_id' => $ziyaretciId
		]);
		auth()->login($user);
		return redirect()->intended('/');
	}
	

	public function login()
	{
		$data = request()->all();
		$ulkeId = $this->ulkeIdBul();
		$ipUlke = GenelFonksiyonlar::getIp();
		$ip = $ipUlke['ip'];

		$this->validate(request(), [
			'email' => 'required',
			'password' => 'required'
		]);

		$ziyaretciId = Cookie::get('ziyaretci_id');
		$ziyaretci = Ziyaretci::find($ziyaretciId);
		$yeniToken = $ziyaretci->token;
		if (auth()->attempt(['email' => $data['email'], 'password' => $data['password']])) {
			request()->session()->regenerate();

			$eskiZiyaretci = ZiyaretciUser::where('user_id', Auth::id())->orderBy('created_at','desc')->first();
			$eskiId = Ziyaretci::find($eskiZiyaretci->ziyaretci_id);
			$sepetEski = Sepet::where('ziyaretci_id',$eskiId->id)->orderBy('created_at','desc')->first();
			$yeniSepet =Sepet::where('ziyaretci_id', $ziyaretciId)->orderBy('created_at','desc')->first();
			if (!isset($yeniSepet)) { 
				$yeniSepet = Sepet::updateOrCreate(['ziyaretci_id' => $ziyaretciId, 'ulke_id' => $ulkeId]);
			}  
			if (isset($sepetEski)) {
				$urunler = SepetUrun::where('sepet_id', $sepetEski->id)->get();
				if (isset($urunler)) {
					SepetUrun::where('sepet_id', $sepetEski->id)->update(['sepet_id' => $yeniSepet->id]);
				}  
			}

			$aktif_sepet_id = Sepet::aktif_sepet_id();

			if (is_null($aktif_sepet_id)) {
				$aktif_sepet = Sepet::create(['ziyaretci_id' => $ziyaretciId, 'ulke_id' => $ulkeId]);
				$aktif_sepet_id = $aktif_sepet->id;
			} 

			/*
			if (Cart::count() > 0) {
				foreach (Cart::content() as $cartItem) {
					SepetUrun::updateOrCreate(
						['sepet_id' => $aktif_sepet_id, 'urun_id' => $cartItem->id],
						['adet' => $cartItem->qty, 'fiyati' => $cartItem->price]
					);
				}
			}*/

			$ziyaretci_user_id = ZiyaretciUser::where('user_id', Auth::id())->orderBy('created_at', 'desc')->first();
			if (isset($ziyaretci_user_id)) {
				if ($ziyaretci_user_id->ziyaretci_id != $ziyaretciId) {
					ZiyaretciUser::create([
						'user_id' => Auth::id(),
						'ziyaretci_id' => $ziyaretciId
					]);
				}
			}else{
				ZiyaretciUser::create([
					'user_id' => Auth::id(),
					'ziyaretci_id' => $ziyaretciId
				]);
			}
			return redirect()->intended('/');
		} else {
			$mesaj = 'Giriş hatalı. Lütfen bilgilerinizi kontrol edip tekrar deneyin!';
			$sozlesme = Sozlesmeler::where('kayit_durum', 1)->get();

			return view('tanitim.login', compact('mesaj', 'sozlesme'));
		}
	}

	public function oturumKapat()
	{
		Auth::logout();
		request()->session()->flush();
		request()->session()->regenerate();

		$ipUlke = GenelFonksiyonlar::getIp();
		$ip = $ipUlke['ip'];
		$ulkeKod = $ipUlke['ulkeKod'];

		$ulkeKod = UlkeKod::where('kod', $ulkeKod)->first();
		$ulke = Ulke::where('ulke_kod_id', $ulkeKod->id)->first();

		$ziyaretci = Ziyaretci::create([
			'ip' => $ip,
			'ulke_id' => $ulke->id,
			'dil_id' => $ulke->dil_id,
			'token' => time() . Str::random(60)
		]);
		Cookie::queue('ziyaretci_id', $ziyaretci->id);

		return redirect()->route('index');
	}
	
	public function forgotPassword(){

		return view('tanitim.forgotPassword');
	}
	
	public function forgotPasswordPost(){
		$data = request()->all();

		$user = User::where('email', $data['email'])->first();
		if(!isset($user)){
			return back()
			->with('mesaj', 'Kullanıcı bulunamadı.')
			->with('mesaj_tur', 'danger');
		}

		$token = time() . Str::random(20);

		$forgot = ForgotPassword::create([
			'user_id' => $user->id,
			'token' => $token
		]);


		Mail::raw('Şifrenizi yenilemek için lütfen linke tıklayınız. https://pethepsi.com/password-reset/'.$token, function($message){
			$message->from('no-reply@pethepsi.com');
			$message->to(request('email'));
			$message->subject('Şifre Yenileme');
		});

		return back()
		->with('mesaj', 'E-mail gönderildi. Lütfen gelen kutunuzu kontrol ediniz.')
		->with('mesaj_tur', 'success');
	}
	
	public function sifreYenileme($token){
		$forgot = ForgotPassword::where('token', $token)->first();
		if($forgot['durum'] == 1){
			abort(404);
		}
		$token = $token;
		return view('tanitim.sifreYenileme', compact('token'));
	}
	
	public function sifreYenilemePost(){
		$data = request()->all();
		$this->validate(request(), [
			'password' => 'required|confirmed|min:5|max:60'
		]);
		
		$forgot = ForgotPassword::where('token', $data['token'])->first();

		$user = $forgot->user_getir;
		$user->update([
			'password' => Hash::make($data['password']),
		]);

		$forgot['durum'] = 1;
		$forgot->save();

		return redirect()->route('hesabim.panel')
		->with('mesaj', 'Şifreniz başarıyla güncellendi.')
		->with('mesaj_tur', 'success');
	}
	
}