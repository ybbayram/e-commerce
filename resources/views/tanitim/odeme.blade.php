@extends('tanitim.layouts.master') 
@section('css') 
<link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/pages/odeme.css') }}"> 
@endsection
@section('js')
<script type="text/javascript" src="{{ asset('/assets/js/ek-js/odeme.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/imask/3.4.0/imask.min.js"></script>

@endsection
@section('content')
@include('admin.layouts.partials.alert')
@include('admin.layouts.partials.errors')
<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-lg-9">
			<div class="card px-0 pt-4 pb-0 mt-3 mb-3">
				<div id="msform">
					<!-- progressbar -->
					<ul id="progressbar">
						<li class="active" id="personal" ><strong>Adres</strong></li>
						<li id="payment" ><strong>Ödeme</strong></li>
						<li id="confirm"><strong>Onay</strong></li>
					</ul> 
					<fieldset>
						<div class="form-card">
							<div class="row">
								<div class="col-lg-3"  >
									<input type="checkbox" name="" @if(isset($siparis->fatura_adres_id )) checked @endif value="1" id="fatura" onchange="fatura_adresi()" style="float: left; width: 50px;">  
									<label for="fatura" style="float: left; margin-top: -3px;">Fatura adresim farklı</label>
								</div>
								<h3>Teslimat Adresi</h3>
								<div class="col-lg-2 mb-3" style="border:solid #ebedea; margin-left: 5px; height: 50px;" type="button"  data-bs-toggle="modal" data-bs-target="#exampleModall">
									<p class="mt-3" style="margin-left:35px;">+ Adres Ekle</p>
								</div>
								<div class="row">
									@foreach($adresler as $adres)
									@if(isset($adres))
									<div class="col-lg-3" style="margin: 5px">
										<div class="dashboard-right">
											<div class="row">
												<div class="card-body" style="background: #efefef;">
													<div class="row">
														<div class="col-12" style="margin-bottom: -30px;">
															<label for="adres_input{{$adres->id}}" style="float: right;margin-top: -3px;">Adres Seç</label>
															@if(isset($adres->id))
															<input type="radio" id="adres_input{{$adres->id}}" onchange="adres_id_deger({{$adres->id}})" name="adres_id" style="float: right; width: 10%;" @if(isset($siparis->adres_id))@if($siparis->adres_id == $adres->id) checked @endif @endif>
															@endif
														</div>
														<div class="col-12">
															<h3>{{$adres->baslik}}</h3>
															<p>{{$adres->isim}}</p>
															<p>{{$adres->ulke}},{{$adres->il}},{{$adres->ilce}},{{$adres->mahalle}},</p>
															<p>{{$adres->adres}}</p>
														</div>
													</div>
												</div>
											</div> <!-- end row -->

										</div>
									</div>
									@endif
									@endforeach
								</div>
								<div id="fatura_var" style="display: none;">
									<h3 class="mt-3">Fatura Adresi</h3>
									
									<div class="row">
										@foreach($adresler as $adres)
										@if(isset($adres))
										<div class="col-lg-3" style="margin: 5px">
											<div class="dashboard-right">
												<div class="row">
													<div class="card-body" style="background: #efefef;">
														<div class="row">
															<div class="col-12" style="margin-bottom: -30px;">
																<label for="fatura_input{{$adres->id}}" style="float: right;margin-top: -3px;">Adres Seç</label>
																<input type="radio" id="fatura_input{{$adres->id}}" name="fatura_id" onchange="adres_fatura_id_deger({{$adres->id}})" style="float: right; width: 10%;" @if(isset($siparis->fatura_adres_id))@if($siparis->fatura_adres_id == $adres->id) checked @endif @endif>
															</div>
															<div class="col-12">
																<h3>{{$adres->baslik}}</h3>
																<p>{{$adres->isim}}</p>
																<p>{{$adres->ulke}},{{$adres->il}},{{$adres->ilce}},{{$adres->mahalle}},</p>
																<p>{{$adres->adres}}</p>
															</div>
														</div>
													</div>
												</div> <!-- end row -->
											</div>
										</div>

										@endif
										@endforeach
									</div>
								</div>

							</div> 
						</div> 
						@if($adresSay > 0) 
						<input @if(!isset($siparis->adres_id)) type="hidden" @else type="button" @endif  name="next" class="next action-button" value="Devam Et" id="adres_kontrol"/> 
						@endif 
					</fieldset>
					<fieldset>
						<div class="form-card">
							<div class="row">
								<div class="col-lg-6"> 
									<div class="container-two preload">
										<div class="creditcard">
											<div class="front">
												<div id="ccsingle"></div>
												<svg version="1.1" id="cardfront" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
												x="0px" y="0px" viewBox="0 0 750 471" style="enable-background:new 0 0 750 471;" xml:space="preserve">
												<g id="Front">
													<g id="CardBackground">
														<g id="Page-1_1_">
															<g id="amex_1_">
																<path id="Rectangle-1_1_" class="lightcolor grey" d="M40,0h670c22.1,0,40,17.9,40,40v391c0,22.1-17.9,40-40,40H40c-22.1,0-40-17.9-40-40V40
																C0,17.9,17.9,0,40,0z" />
															</g>
														</g>
														<path class="darkcolor greydark" d="M750,431V193.2c-217.6-57.5-556.4-13.5-750,24.9V431c0,22.1,17.9,40,40,40h670C732.1,471,750,453.1,750,431z" />
													</g>
													<text transform="matrix(1 0 0 1 60.106 295.0121)" id="svgnumber" class="st2 st3 st4">0123 4567 8910 1112</text>
													<text transform="matrix(1 0 0 1 54.1064 428.1723)" id="svgname" class="st2 st5 st6">Muahmmed Enes Aslan</text>
													<text transform="matrix(1 0 0 1 54.1074 389.8793)" class="st7 st5 st8">Adınız Soyadınız</text>
													<text transform="matrix(1 0 0 1 479.7754 388.8793)" class="st7 st5 st8">S.K.T.</text>
													<text transform="matrix(1 0 0 1 65.1054 241.5)" class="st7 st5 st8">Kart Numaranız</text>
													<g>
														<text transform="matrix(1 0 0 1 574.4219 433.8095)" id="svgexpire" class="st2 st5 st9">12/25</text>
														<text transform="matrix(1 0 0 1 479.3848 417.0097)" class="st2 st10 st11">VALID</text>
														<text transform="matrix(1 0 0 1 479.3848 435.6762)" class="st2 st10 st11">THRU</text>
														<polygon class="st2" points="554.5,421 540.4,414.2 540.4,427.9 		" />
													</g>
													<g id="cchip">
														<g>
															<path class="st2" d="M168.1,143.6H82.9c-10.2,0-18.5-8.3-18.5-18.5V74.9c0-10.2,8.3-18.5,18.5-18.5h85.3
															c10.2,0,18.5,8.3,18.5,18.5v50.2C186.6,135.3,178.3,143.6,168.1,143.6z" />
														</g>
														<g>
															<g>
																<rect x="82" y="70" class="st12" width="1.5" height="60" />
															</g>
															<g>
																<rect x="167.4" y="70" class="st12" width="1.5" height="60" />
															</g>
															<g>
																<path class="st12" d="M125.5,130.8c-10.2,0-18.5-8.3-18.5-18.5c0-4.6,1.7-8.9,4.7-12.3c-3-3.4-4.7-7.7-4.7-12.3
																c0-10.2,8.3-18.5,18.5-18.5s18.5,8.3,18.5,18.5c0,4.6-1.7,8.9-4.7,12.3c3,3.4,4.7,7.7,4.7,12.3
																C143.9,122.5,135.7,130.8,125.5,130.8z M125.5,70.8c-9.3,0-16.9,7.6-16.9,16.9c0,4.4,1.7,8.6,4.8,11.8l0.5,0.5l-0.5,0.5
																c-3.1,3.2-4.8,7.4-4.8,11.8c0,9.3,7.6,16.9,16.9,16.9s16.9-7.6,16.9-16.9c0-4.4-1.7-8.6-4.8-11.8l-0.5-0.5l0.5-0.5
																c3.1-3.2,4.8-7.4,4.8-11.8C142.4,78.4,134.8,70.8,125.5,70.8z" />
															</g>
															<g>
																<rect x="82.8" y="82.1" class="st12" width="25.8" height="1.5" />
															</g>
															<g>
																<rect x="82.8" y="117.9" class="st12" width="26.1" height="1.5" />
															</g>
															<g>
																<rect x="142.4" y="82.1" class="st12" width="25.8" height="1.5" />
															</g>
															<g>
																<rect x="142" y="117.9" class="st12" width="26.2" height="1.5" />
															</g>
														</g>
													</g>
												</g>
												<g id="Back">
												</g>
											</svg>
										</div>
										<div class="back">
											<svg version="1.1" id="cardback" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
											x="0px" y="0px" viewBox="0 0 750 471" style="enable-background:new 0 0 750 471;" xml:space="preserve">
											<g id="Front">
												<line class="st0" x1="35.3" y1="10.4" x2="36.7" y2="11" />
											</g>
											<g id="Back">
												<g id="Page-1_2_">
													<g id="amex_2_">
														<path id="Rectangle-1_2_" class="darkcolor greydark" d="M40,0h670c22.1,0,40,17.9,40,40v391c0,22.1-17.9,40-40,40H40c-22.1,0-40-17.9-40-40V40
														C0,17.9,17.9,0,40,0z" />
													</g>
												</g>
												<rect y="61.6" class="st2" width="750" height="78" />
												<g>
													<path class="st3" d="M701.1,249.1H48.9c-3.3,0-6-2.7-6-6v-52.5c0-3.3,2.7-6,6-6h652.1c3.3,0,6,2.7,6,6v52.5
													C707.1,246.4,704.4,249.1,701.1,249.1z" />
													<rect x="42.9" y="198.6" class="st4" width="664.1" height="10.5" />
													<rect x="42.9" y="224.5" class="st4" width="664.1" height="10.5" />
													<path class="st5" d="M701.1,184.6H618h-8h-10v64.5h10h8h83.1c3.3,0,6-2.7,6-6v-52.5C707.1,187.3,704.4,184.6,701.1,184.6z" />
												</g>
												<text transform="matrix(1 0 0 1 621.999 227.2734)" id="svgsecurity" class="st6 st7">985</text>
												<g class="st8">
													<text transform="matrix(1 0 0 1 518.083 280.0879)" class="st9 st6 st10">Güvenlik Kodu</text>
												</g>
												<rect x="58.1" y="378.6" class="st11" width="375.5" height="13.5" />
												<rect x="58.1" y="405.6" class="st11" width="421.7" height="13.5" />
												<text transform="matrix(1 0 0 1 59.5073 228.6099)" id="svgnameback" class="st12 st13">Muhammed Enes Aslan</text>
											</g>
										</svg>
									</div>
								</div>
							</div>
							<form action="{{route('odeme.post')}}" method="post">
								@csrf
								<div class="form-container">
									<div class="field-container">
										<label for="name">Kart Üzerindeki İsim</label>
										<input id="name" name="kart_ismi" maxlength="40" required  type="text" >
									</div>
									<div class="field-container" >
										<label for="cardnumber">Kart Numaranız</label><span style="display: none;" id="generatecard">generate random</span>
										<input id="cardnumber" type="text" name="pan"  required inputmode="numeric">
										<svg id="ccicon" class="ccicon" width="750" height="471" viewBox="0 0 750 471" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
										</svg>
									</div>
									<div class="field-container">
										<label for="expirationdate">S.K. Tarihi (mm/yy)</label>
										<input id="expirationdate" type="text"  required name="ay_yil"  inputmode="numeric">
									</div>
									<div class="field-container">
										<label for="securitycode">Güvenlik kodu</label>
										<input id="securitycode" type="text"  required name="cv2"  inputmode="numeric">
									</div>

								</div>
								<div class="row">
									<div class="col-1 mt-1">
										<input type="checkbox" required name="kabul" value="1" id="adda" style="float: left; width: 50px;">  
									</div>
									<div class="col-8">
										<label for="adda" style="margin-left: 10px;">
											@foreach($sozlesme as $entry)
											<a target="_blank" href="{{route('sozlesmeler', $entry->slug)}}">
												{{$entry->sozlesme_dil_getir['baslik']}}@if($sozlesme->last() !== $entry), @endif
											</a>
										@endforeach okudum ve kabul ediyorum.</label>
									</div>
								</div> 

							</div>

							<div class="col-lg-6">
								<div class="col-lg-12 col-sm-12 col-xs-12">
									<div class="checkout-details">
										<div class="order-box">
											<div class="title-box">
												<div>Ürün <span>Toplam</span></div>
											</div>
											<ul class="qty">
												@foreach($sepetNavUrun as $urunCartItem)
												@php
												$urun = App\Models\Urun::find($urunCartItem->urun_id);
												@endphp
												<div class="row d-flex justify-content-center m-auto">
													<div class="col-7 mb-3">
														{{ $urun->urun_detay_bul['ad'] }} 
														@if($urun->cesit_durum == 0)
														@php
														$cesitDetay = App\Models\CesitDetay::find($urunCartItem-> cesit_detay_id);
														@endphp
														({{$cesitDetay->cesit_detay_dil_getir['ad']}}) 
														@endif X {{ $urunCartItem->adet }}
													</div>
													<div class="col-4"><span style="margin-left:10px;font-family: Nunito; font-weight: 900">{{ number_format($urunCartItem->fiyati, 2) }} {{ $paraSimge }}</span></div>
												</div>						
												@endforeach
											</ul> 

											<ul class="sub-total">
												<li>Kargo <span class="count">@if($sepetNavUrun->count() > 0){{$kargoFiyat}}{{ $paraSimge }}@else 0.00 {{ $paraSimge }} @endif</span></li>
												@if(isset($indirim))
												<li>İndirim <span class="count">{{$indirimTutari}} {{ $paraSimge }}</span></li>
												@endif
												@if(isset($SepetindirimTutari))
												<li>İndirim <span class="count">{{$SepetindirimTutari}} {{ $paraSimge }}</span></li>
												@endif
												@if(isset($indirimXalYode))
												<li>İndirim <span class="count">{{$indirimXalYode}} {{ $paraSimge }}</span></li>
												@endif
												<li>Ücret <span class="count">{{ $toplamFiyat }} {{ $paraSimge }}</span></li>
											</ul>
											<ul class="total"> 
												<li>Toplam <span class="count"><b>@if($sepetNavUrun->count() > 0) {{$toplam}}{{ $paraSimge }} @else 0.00 {{ $paraSimge }}  @endif  </b></span></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<input type="submit" class="action-button-previous" value="Onayla"/>
					<input type="button" name="previous" class="previous action-button-previous" value="Geri Dön"/>
				</form>
			</fieldset>
			<fieldset>
				<div class="form-card">

					<h2 class="purple-text text-center"><strong>BAŞARILI !</strong></h2> <br>

					<div class="row justify-content-center">
						<div class="col-7 text-center">
							<h5 class="purple-text text-center">Siparişiniz alınmıştır. Bizi seçtiğiniz için teşekkürler!</h5>
						</div>
					</div>
				</div>
			</fieldset>
		</div>
	</div>
</div>
</div>
</div>
<div class="modal fade" id="exampleModall" tabindex="-1" aria-labelledby="exampleModalLabell" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Adres Oluşturunuz</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<form class="theme-form" action="{{ route('adres.olustur')}}" method="post">
				@csrf
				<div class="modal-body">
					<div class="form-row row">  
						<div class="col-md-6 mb-3">
							<label for="name">Adres Başlığı<span style="color: red;">*</span></label>
							<input type="text" maxlength="50" class="form-control" name="baslik" id="address-two" placeholder="Adres Başlığı"
							required="">
						</div>
						<div class="col-md-6">
							<label for="name">Ad Soyad<span style="color: red;">*</span></label>
							<input type="text" maxlength="50" class="form-control" name="ad"  id="home-ploat" placeholder="Ad Soyad"
							required="">
						</div>
						<div class="col-md-6 mb-3">
							<label for="email">Telefon Numaranız<span style="color: red;">*</span></label>
							<input type="number"  maxlength="30"class="form-control" name="telefon" id="zip-code" placeholder="Telefon Numaranız"
							required="">
						</div>
						<div class="col-md-6">
							<label for="email">Mail<span style="color: red;">*</span></label>
							<input type="email"  maxlength="100" class="form-control" name="mail" id="zip-code" placeholder="Mailiniz"
							required>
						</div>
						<div class="col-md-6 ">
							<label for="review">Ülke<span style="color: red;">*</span></label>
							<input type="text" disabled value="Türkiye" maxlength="50" class="form-control" name="ulke" id="zip-code" placeholder="Ülke">
						</div>
						<div class="col-md-6 mb-3 ">
							<label for="review">İl<span style="color: red;">*</span></label>
							<input type="text" maxlength="50" class="form-control" name="il"  id="home-ploat" placeholder="İl"
							required="">
						</div>
						<div class="col-md-6 ">
							<label for="review">İlçe<span style="color: red;">*</span></label>
							<input type="text" maxlength="50" class="form-control" name="ilce"  id="home-ploat" placeholder="İlçe"
							required="">
						</div>
						<div class="col-md-6  mb-3">
							<label for="review">Mahalle<span style="color: red;">*</span></label>
							<input type="text" maxlength="50" class="form-control" name="mahalle"  id="home-ploat" placeholder="Mahalle"
							required="">
						</div>

						<div class="col-md-6 mb-3">
							<label for="email">Kimlik No</label>
							<input type="text" maxlength="50" minlength="6"  class="form-control" name="kimlik_no" min="6" id="zip-code" placeholder="Kimlik No">
						</div>
						<div class="col-md-6">
							<label for="email">Posta Kodu</label>
							<input type="text" maxlength="30" class="form-control" name="postakodu" id="zip-code" placeholder="Posta Kodu"
							>
						</div>
						<div class="col-md-12">
							<label for="email">Adres<span style="color: red;">*</span></label>
							<textarea class="form-control" maxlength="500"  name="adres" id="zip-code" placeholder="Tam Adres"
							required=""></textarea>
						</div>
						<div  id="kurumsal_var" style="display: none;">
							<hr>
							<div class="col-md-12">
								<label for="firmaAd">Firma Adı<span style="color: red;">*</span></label>
								<input id="firmaAd" required  class="form-control" name="firma_adi" type="text">
							</div>   
							<div class="col-md-12">
								<label for="vergiNo">Vergi Numarası<span style="color: red;">*</span></label>
								<input id="vergiNo"  required class="form-control" name="vergi_numarasi" type="text">
							</div>   
							<div class="col-md-12 mb-4">
								<label for="vergiDaire">Vergi Dairesi<span style="color: red;">*</span></label>
								<input id="vergiDaire"  required class="form-control" name="vergi_dairesi" type="text">
							</div>
							<div class="row">
								<div class="col-1 mt-1">
									<input type="checkbox" value="1"  name="eFatura" id="efatura" style="float: left; width: 50px; margin-left: -25px;">  
								</div>
								<div class="col-8">
									<label for="efatura" style="margin-left: -10px;">E-fatura mükellefiyim</label>
								</div>
							</div>
							<div class="col-md-12">
								<label><b>*Firma adresiniz yukardaki adres olarak olacaktır</b></label>
							</div>
						</div> 
					</div>
				</div>
				<div class="modal-footer"> 
					<div class="row">
						<div class="col-12 mt-1">
							<input type="checkbox" id="kurumsal" value="1" onchange="kurumsalMusteri()" name="" style="width: 50px;">  

							<label for="kurumsal"> Kurumsal Müşteriyim</label>
						</div>
					</div>
					<button type="button" class="btn btn-secondary  btn-sm btn-solid" data-bs-dismiss="modal">Kapat</button>
					<button class="btn btn-sm btn-solid" type="submit">Kaydet</button>
				</div>

			</form> 
		</div>
	</div>
</div>
@endsection