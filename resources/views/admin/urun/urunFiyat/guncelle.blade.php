@extends('admin.layouts.master')
@section('js')
<script src="/adassets/assets/js/pages/form-advanced.init.js"></script>

<script type="text/javascript">

	function kdv(){
		var tur = document.getElementById('tur');
		var kdv_orani = document.getElementById('kdv_orani'); 
		var kdv_req = document.getElementById('kdv_req'); 
		if(tur.value == 1){ 
			kdv_req.required = true; 
			tur.value = 0;	

		}else{ 
			kdv_req.required = false;  
			tur.value = 1;

		}
	}
	var tur = document.getElementById('tur');
	var kdv_orani = document.getElementById('kdv_orani'); 
	var kdv_req = document.getElementById('kdv_req'); 

	if(tur.value == 1){ 
		kdv_req.required = "true"; 
		tur.value = 0;

	}else{ 
		kdv_req.required = "false"; 

		tur.value = 1;
	}

</script>
@endsection
@section('content')
@include('admin.layouts.partials.navbar')
<div class="main-content">

	<div class="page-content">
		<div class="container-fluid">

			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-flex align-items-center justify-content-between">
						<h4 class="mb-0 font-size-18"><b>{{ $urun['baslik'] }}</b> Ürün Fiyatını Güncelle</h4>
					</div>
				</div>
			</div>

			<div class="row">
				@include('admin.layouts.partials.alert')
				@include('admin.layouts.partials.errors')
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<a href="{{ route('admin.urunFiyat', $urun['id']) }}"><span class="btn btn-purple btn btn-xl inputTwo" style="margin-bottom: 20px"><span class="dripicons-arrow-thin-left"> Önceki Sayfa</span></span></a>
							<h4 class="card-title">Fiyat Güncelle</h4>
							<p class="card-title-desc">Fiyatı güncelleyiniz.</p>
							@if($urun->cesit_durum == 1)
							<div class="row">
								<div class="col-lg-12 col-sm-12 mb-4">
									<form action="{{ route('admin.urunFiyat.guncelle', $urunFiyat->id) }}" method="post">
										@csrf
										<div class="form-group" id="example-email-input1">
											<label for="example-email-input1" class="col-form-label pt-0">Ülke <span style="color: red;">*</span></label>
											<select class="form-control" name="ulke_id">
												@foreach($ulkeler as $entry)
												@if($entry->id == $urunFiyat->ulke_id)
												<option value="{{ $entry->id }}" checked="true">{{ $entry->ulke_kod_getir['ad'] }}</option>
												@endif
												@endforeach
												@foreach($ulkeler as $entry)
												@if($entry->id != $urunFiyat->ulke_id)
												<option value="{{ $entry->id }}">{{ $entry->ulke_kod_getir['ad'] }}</option>
												@endif
												@endforeach
											</select>
										</div>

										<div class="form-group">
											<input class="form-check-input"  type="checkbox" @if($urunFiyat->kdv_durum == 1) checked value="1" @else value="0" @endif id="tur" onchange="kdv()" name="kdv_yok"    style="margin-left: 10px;" >
											<label for="tur" class="col-form-label pt-0" style="margin-left: 30px; margin-top: 4px;">KDV dahil değil </label>
										</div>
										<div class="form-group">
											<label for="example-email-input1" class="col-form-label pt-0">KDV Oranı</label>
											<input class="form-control" name="kdv_orani" type="number" min="0" step="any" id="kdv_req" placeholder="Kdv tutarını giriniz" value="{{$urunFiyat->kdv_orani}}">
										</div>
										<div class="row mb-4">

											<div  class="col-lg-3 col-sm-12 ">
												<label for="example-email-input1" class="col-form-label pt-0">Fiyat <span style="color: red;">*</span></label>
												<input class="form-control" name="fiyat" type="number" step="any"  id="example-email-input1" placeholder="Ürün fiyatı giriniz (xx.xx)" required="true" value="{{ old('ad', $urunFiyat->kdvsiz_fiyat) }}">
											</div>  
											<div  class="col-lg-3 col-sm-12 ">
												<label for="example-email-input1" class="col-form-label pt-0">Önceki Fiyat</label>
												<input class="form-control" name="fiyat_onceki" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('kdv_orani', $urunFiyat->fiyat_onceki) }}">
											</div> 
											@if($urunFiyat->kdv_durum == 1)
											<div class="col-lg-3 col-sm-12 ">
												<label for="example-email-input1" class="col-form-label pt-0">KDV'li Fiyat</label>
												<input class="form-control" name="fiyat_bir" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_bir', $urunFiyat->fiyat) }}" disabled>
											</div>
											@endif
										</div>

										<div class="form-group ">
											<p>
												<a class="btn btn-light" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
													Bayi Fiyatı Ekle
												</a>
											</p>
											<div class="collapse" id="collapseExample">
												<div class="form-group ml-2" > 
													<div class="row mb-4">

														<div  class="col-lg-3 col-sm-12 ">
															<label for="example-email-input1" class="col-form-label pt-0">Fiyat Bir</label>
															<input class="form-control" name="fiyat_bir" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_iki_onceki', $urunFiyat->fiyat_bir_kdvsiz) }}" >
														</div>
														<div  class="col-lg-3 col-sm-12 ">
															<label for="example-email-input1" class="col-form-label pt-0">Önceki Fiyat</label>
															<input class="form-control" name="fiyat_bir_onceki" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_bir_onceki', $urunFiyat->fiyat_bir_onceki) }}" >
														</div>

														<div class="col-lg-3 col-sm-12 ">
															<label for="example-email-input1" class="col-form-label pt-0">KDV'li Fiyat</label>
															<input class="form-control" name="fiyat_bir_kdv" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_bir', $urunFiyat->fiyat_bir) }}" disabled>
														</div>
													</div>
													<div class="row mb-4">

														<div  class="col-lg-3 col-sm-12 ">
															<label for="example-email-input1" class="col-form-label pt-0">Fiyat İki</label>
															<input class="form-control" name="fiyat_iki" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_iki_onceki', $urunFiyat->fiyat_iki_kdvsiz) }}" >
														</div>
														<div  class="col-lg-3 col-sm-12 ">
															<label for="example-email-input1" class="col-form-label pt-0">Önceki Fiyat</label>
															<input class="form-control" name="fiyat_iki_onceki" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_iki_onceki', $urunFiyat->fiyat_iki_onceki) }}" >
														</div>

														<div class="col-lg-3 col-sm-12 ">
															<label for="example-email-input1" class="col-form-label pt-0">KDV'li Fiyat</label>
															<input class="form-control" name="fiyat_iki_kdv" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_iki', $urunFiyat->fiyat_iki) }}" disabled>
														</div>
													</div>
													<div class="row mb-4">
														<div  class="col-lg-3 col-sm-12 ">
															<label for="example-email-input1" class="col-form-label pt-0">Fiyat Üç</label>
															<input class="form-control" name="fiyat_uc" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_iki_onceki', $urunFiyat->fiyat_uc_kdvsiz) }}" >
														</div>
														<div  class="col-lg-3 col-sm-12 ">
															<label for="example-email-input1" class="col-form-label pt-0">Önceki Fiyat</label>
															<input class="form-control" name="fiyat_uc_onceki" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_uc_onceki', $urunFiyat->fiyat_uc_onceki) }}">
														</div>
														<div class="col-lg-3 col-sm-12 ">
															<label for="example-email-input1" class="col-form-label pt-0">KDV'li Fiyat</label>
															<input class="form-control" name="fiyat_uc_kdv" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_uc', $urunFiyat->fiyat_uc) }}" disabled >
														</div>

													</div>
													<div class="row mb-4">
														<div  class="col-lg-3 col-sm-12 ">
															<label for="example-email-input1" class="col-form-label pt-0">Fiyat Dört</label>
															<input class="form-control" name="fiyat_dort" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_iki_onceki', $urunFiyat->fiyat_dort_kdvsiz) }}" >
														</div>
														<div  class="col-lg-3 col-sm-12 ">
															<label for="example-email-input1" class="col-form-label pt-0">Önceki Fiyat</label>
															<input class="form-control" name="fiyat_dort_onceki" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_dort_onceki', $urunFiyat->fiyat_dort_onceki) }}" >
														</div>
														<div class="col-lg-3 col-sm-12 ">
															<label for="example-email-input1" class="col-form-label pt-0">KDV'li Fiyat</label>
															<input class="form-control" name="fiyat_dort_kdv" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz" disabled value="{{ old('fiyat_dort', $urunFiyat->fiyat_dort) }}">
														</div>
													</div>
												</div>
											</div>
										</div>
										<button type="submit" class="btn btn-primary w-lg">Gönder</button>
									</form>
								</div>

							</div>
							@else
							<div class="row">

								<div class="col-lg-12 col-sm-12 mb-4">
									<form action="{{ route('admin.urunFiyat.cesit.guncelle', $cesitFiyat->id) }}" method="post">
										@csrf
										<div class="form-group" id="example-email-input1">
											<label for="example-email-input1" class="col-form-label pt-0">Ülke <span style="color: red;">*</span></label>
											<select class="form-control" name="ulke_id">
												@foreach($ulkeler as $entry)
												@if($entry->id == $cesitFiyat->ulke_id)
												<option value="{{ $entry->id }}" checked="true">{{ $entry->ulke_kod_getir['ad'] }}</option>
												@endif
												@endforeach
												@foreach($ulkeler as $entry)
												@if($entry->id != $cesitFiyat->ulke_id)
												<option value="{{ $entry->id }}">{{ $entry->ulke_kod_getir['ad'] }}</option>
												@endif
												@endforeach
											</select>
										</div>

										<div class="form-group">
											<input class="form-check-input"  type="checkbox" @if($cesitFiyat->kdv_durum == 1) checked value="1" @else value="0" @endif id="tur" onchange="kdv()" name="kdv_yok" style="margin-left: 10px;" >
											<label for="tur" class="col-form-label pt-0" style="margin-left: 30px; margin-top: 4px;">KDV dahil değil </label>
										</div>

										<div class="form-group">
											<label for="example-email-input1" class="col-form-label pt-0">KDV Oranı</label>
											<input class="form-control" name="kdv_orani" type="number"  min="0" step="any" id="kdv_req" placeholder="Kdv tutarını giriniz" value="{{ old('kdv_orani', $cesitFiyat->kdv_orani) }}">

										</div>

										
										<div class="row mb-4">

											<div  class="col-lg-3 col-sm-12 ">
												<label for="example-email-input1" class="col-form-label pt-0">Fiyat <span style="color: red;">*</span></label>
												<input class="form-control" name="fiyat" type="number" step="any"  id="example-email-input1" placeholder="Ürün fiyatı giriniz (xx.xx)" required="true" value="{{ old('ad', $cesitFiyat->kdvsiz_fiyat) }}">
											</div>  
											<div  class="col-lg-3 col-sm-12 ">
												<label for="example-email-input1" class="col-form-label pt-0">Önceki Fiyat</label>
												<input class="form-control" name="fiyat_onceki" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('kdv_orani', $cesitFiyat->fiyat_onceki) }}">
											</div> 
											@if($cesitFiyat->kdv_durum)
											<div class="col-lg-3 col-sm-12 ">
												<label for="example-email-input1" class="col-form-label pt-0">KDV'li Fiyat</label>
												<input class="form-control" name="fiyat_bir" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_bir', $cesitFiyat->fiyat) }}" disabled>
											</div>
											@endif
										</div>

										<div class="form-group ">
											<p>
												<a class="btn btn-light" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
													Bayi Fiyatı Ekle
												</a>
											</p>
											<div class="collapse" id="collapseExample">
												<div class="form-group ml-2" > 
													<div class="row mb-4">

														<div  class="col-lg-3 col-sm-12 ">
															<label for="example-email-input1" class="col-form-label pt-0">Fiyat Bir</label>
															<input class="form-control" name="fiyat_bir" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_iki_onceki', $cesitFiyat->fiyat_bir_kdvsiz) }}" >
														</div>
														<div  class="col-lg-3 col-sm-12 ">
															<label for="example-email-input1" class="col-form-label pt-0">Önceki Fiyat</label>
															<input class="form-control" name="fiyat_bir_onceki" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_bir_onceki', $cesitFiyat->fiyat_bir_onceki) }}" >
														</div>

														<div class="col-lg-3 col-sm-12 ">
															<label for="example-email-input1" class="col-form-label pt-0">KDV'li Fiyat</label>
															<input class="form-control" name="fiyat_bir_kdv" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_bir', $cesitFiyat->fiyat_bir) }}" disabled>
														</div>
													</div>
													<div class="row mb-4">

														<div  class="col-lg-3 col-sm-12 ">
															<label for="example-email-input1" class="col-form-label pt-0">Fiyat İki</label>
															<input class="form-control" name="fiyat_iki" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_iki_onceki', $cesitFiyat->fiyat_iki_kdvsiz) }}" >
														</div>
														<div  class="col-lg-3 col-sm-12 ">
															<label for="example-email-input1" class="col-form-label pt-0">Önceki Fiyat</label>
															<input class="form-control" name="fiyat_iki_onceki" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_iki_onceki', $cesitFiyat->fiyat_iki_onceki) }}" >
														</div>

														<div class="col-lg-3 col-sm-12 ">
															<label for="example-email-input1" class="col-form-label pt-0">KDV'li Fiyat</label>
															<input class="form-control" name="fiyat_iki_kdv" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_iki', $cesitFiyat->fiyat_iki) }}" disabled>
														</div>
													</div>
													<div class="row mb-4">
														<div  class="col-lg-3 col-sm-12 ">
															<label for="example-email-input1" class="col-form-label pt-0">Fiyat Üç</label>
															<input class="form-control" name="fiyat_uc" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_iki_onceki', $cesitFiyat->fiyat_uc_kdvsiz) }}" >
														</div>
														<div  class="col-lg-3 col-sm-12 ">
															<label for="example-email-input1" class="col-form-label pt-0">Önceki Fiyat</label>
															<input class="form-control" name="fiyat_uc_onceki" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_uc_onceki', $cesitFiyat->fiyat_uc_onceki) }}">
														</div>
														<div class="col-lg-3 col-sm-12 ">
															<label for="example-email-input1" class="col-form-label pt-0">KDV'li Fiyat</label>
															<input class="form-control" name="fiyat_uc_kdv" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_uc', $cesitFiyat->fiyat_uc) }}" disabled >
														</div>

													</div>
													<div class="row mb-4">
														<div  class="col-lg-3 col-sm-12 ">
															<label for="example-email-input1" class="col-form-label pt-0">Fiyat Dört</label>
															<input class="form-control" name="fiyat_dort" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_iki_onceki', $cesitFiyat->fiyat_dort_kdvsiz) }}" >
														</div>
														<div  class="col-lg-3 col-sm-12 ">
															<label for="example-email-input1" class="col-form-label pt-0">Önceki Fiyat</label>
															<input class="form-control" name="fiyat_dort_onceki" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_dort_onceki', $cesitFiyat->fiyat_dort_onceki) }}" >
														</div>
														<div class="col-lg-3 col-sm-12 ">
															<label for="example-email-input1" class="col-form-label pt-0">KDV'li Fiyat</label>
															<input class="form-control" name="fiyat_dort_kdv" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz" disabled value="{{ old('fiyat_dort', $cesitFiyat->fiyat_dort) }}">
														</div>
													</div>
												</div>
											</div>
										</div>
										<button type="submit" class="btn btn-primary w-lg">Gönder</button>
									</form>
								</div>

							</div>
							@endif
						</div>
					</div>
				</div>
			</div>


		</div> <!-- container-fluid -->
	</div>
	<!-- End Page-content -->

</div>
<!-- end main content-->

</div>

@endsection