@extends('admin.layouts.master')
@section('js')
<script src="/adassets/assets/js/pages/form-advanced.init.js"></script>
@endsection
@section('content')
@include('admin.layouts.partials.navbar')
<div class="main-content">

	<div class="page-content">
		<div class="container-fluid">

			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-flex align-items-center justify-content-between">
						<h4 class="mb-0 font-size-18"><b>{{ $urun['baslik'] }}</b> Ürünü İçin Fiyat Oluştur</h4>
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
							<h4 class="card-title">Ürün Fiyatı Oluştur</h4>
							<p class="card-title-desc">Ürün fiyatı oluşturunuz.</p>

							<div class="row">

								<div class="col-lg-12 col-sm-12 mb-4">
									<form action="
									@if($urun->cesit_durum == 1) {{ route('admin.urunFiyat.olustur', $urun['id']) }} 
									@else  {{ route('admin.urunFiyat.cesit.olustur', $urun['id']) }} 
									@endif" 
									method="post" >
									@csrf
									<div class="form-group" id="example-email-input1">
										<label for="example-email-input1" class="col-form-label pt-0">Ülke <span style="color: red;">*</span></label>
										<select class="form-control" name="ulke_id">
											@foreach($ulkeler as $entry)
											<option value="{{ $entry->id }}">{{ $entry->ulke_kod_getir['ad'] }}</option>
											@endforeach
										</select>
									</div>
									<div class="form-group">
										<input class="form-check-input" name="kdv_yok" type="checkbox" id="tur" style="margin-left: 2px;" value="1" >
										<label class="col-form-label pt-0 " for="tur" style="margin-left: 20px; margin-top: 2px;" >KDV dahil değil</label>
									</div> 
									@if($urun->cesit_durum == 1)
									<div class="form-group"  >
										<label for="example-email-input1" class="col-form-label pt-0">KDV Oranı</label>
										<input class="form-control" name="kdv_orani" type="number" step="any" id="example-email-input1" placeholder="KDV oranını giriniz"  value=18>
									</div>
									<div class="row mb-4">
										<div  class="col-lg-3 col-sm-12 ">
											<label for="example-email-input1" class="col-form-label pt-0">Fiyat <span style="color: red;">*</span></label>
											<input class="form-control" name="fiyat" type="number" step="any"  id="example-email-input1" placeholder="Ürün fiyatı giriniz (xx.xx)" required="true" value="{{ old('ad') }}">
										</div>  
										<div  class="col-lg-3 col-sm-12 ">
											<label for="example-email-input1" class="col-form-label pt-0">Önceki Fiyat</label>
											<input class="form-control" name="fiyat_onceki" type="number" step="any" id="example-email-input1" placeholder="İndirim tutarını giriniz"   value="{{ old('kdv_orani') }}">
										</div> 
									</div>
									<div class="form-group ">
										<p>
											<a class="btn btn-light" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
												Bayi Fiyatı Ekle
											</a>
										</p>
										<div class="collapse" id="collapseExample">
											<div class="form-group ml-2" >
												<label class="mt-2 ">Bayiler</label>
												<div class="row mb-4">
													<div class="col-lg-3 col-sm-12 ">
														<label for="example-email-input1" class="col-form-label pt-0">Fiyat Bir</label>
														<input class="form-control" name="fiyat_bir" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_bir') }}" >
													</div>
													<div  class="col-lg-3 col-sm-12 ">
														<label for="example-email-input1" class="col-form-label pt-0">Önceki fiyat</label>
														<input class="form-control" name="fiyat_bir_onceki" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_bir_onceki') }}" >
													</div>
												</div>
												<div class="row mb-4">
													<div class="col-lg-3 col-sm-12 ">
														<label for="example-email-input1" class="col-form-label pt-0">Fiyat İki</label>
														<input class="form-control" name="fiyat_iki" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_iki') }}" >
													</div>
													<div  class="col-lg-3 col-sm-12 ">
														<label for="example-email-input1" class="col-form-label pt-0">Önceki fiyat</label>
														<input class="form-control" name="fiyat_iki_onceki" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_iki_onceki') }}" >
													</div>
												</div>
												<div class="row mb-4">
													<div class="col-lg-3 col-sm-12 ">
														<label for="example-email-input1" class="col-form-label pt-0">Fiyat Üç</label>
														<input class="form-control" name="fiyat_uc" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_uc') }}" >
													</div>
													<div  class="col-lg-3 col-sm-12 ">
														<label for="example-email-input1" class="col-form-label pt-0">Önceki fiyat</label>
														<input class="form-control" name="fiyat_uc_onceki" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_uc_onceki') }}">
													</div>
												</div>
												<div class="row mb-4">
													<div class="col-lg-3 col-sm-12 ">
														<label for="example-email-input1" class="col-form-label pt-0">Fiyat Dört</label>
														<input class="form-control" name="fiyat_dort" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_dort') }}">
													</div>
													<div  class="col-lg-3 col-sm-12 ">
														<label for="example-email-input1" class="col-form-label pt-0">Önceki fiyat</label>
														<input class="form-control" name="fiyat_dort_onceki" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_dort_onceki') }}" >
													</div>
												</div>
											</div>
										</div>
									</div>
									@else
									@foreach($cesitler as $cesit)
									<div class="form-group"> 
										<label for="example-email-input1" class="col-form-label pt-0">KDV Oranı</label>
										<input class="form-control" name="kdv_orani" type="number" step="any" id="example-email-input1" placeholder="KDV oranını giriniz"  value="18">
									</div>
									<div class="row mb-2">
										<label for="example-email-input1" class="col-form-label pt-0" style="margin-right: 800px; margin-left: 10px;
										"> -> {{$cesit->baslik}} </label> 
										@foreach($cesit->cesit_detay_bul as $detay)
										<div class="row">
											<div  class="col-lg-3 col-sm-12 ">
												<label for="example-email-input1" class="col-form-label pt-0">Ad <span style="color: red;">*</span></label>
												<input class="form-control mb-4  btn btn-light" type="text" step="any"  id="example-email-input1" required="true" value="{{ $detay->ad}}" disabled>
											</div>  
											<input type="hidden" name="cesit[id][]" value="{{$detay->id}}">
											<div  class="col-lg-3 col-sm-12 ">
												<label for="example-email-input1" class="col-form-label pt-0">Fiyat <span style="color: red;">*</span></label>
												<input class="form-control mb-4" name="cesit[fiyat][]" type="number" step="any"  id="example-email-input1" placeholder="Ürün fiyatı giriniz (xx.xx)" required="true" value="{{ old('ad') }}">
											</div>  
											<div  class="col-lg-3 col-sm-12 ">
												<label for="example-email-input1" class="col-form-label pt-0">Önceki Fiyat</label>
												<input class="form-control mb-4" name="cesit[fiyat_onceki][]" type="number" step="any" id="example-email-input1" placeholder="İndirim tutarını giriniz"   value="{{ old('kdv_orani') }}">
											</div> 
										</div>
										
										<div  class="col-lg-12 col-sm-12 ">

											<div class="form-group ">
												<p>
													<a class="btn btn-light" data-toggle="collapse" href="#collapseExample{{$detay->id}}" role="button" aria-expanded="false" aria-controls="collapseExample{{$detay->id}}">
														Bayi Fiyatı Ekle
													</a>
												</p>
												<div class="collapse" id="collapseExample{{$detay->id}}">
													<div class="form-group ml-2" >
														<label class="mt-2 ">Bayiler</label>
														<div class="row mb-4">
															<div class="col-lg-6 col-sm-12 ">
																<label for="example-email-input1" class="col-form-label pt-0">Fiyat Bir</label>
																<input class="form-control" name="cesit[fiyat_bir][]" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_bir') }}" >
															</div>
															<div  class="col-lg-6 col-sm-12 ">
																<label for="example-email-input1" class="col-form-label pt-0">Önceki fiyat</label>
																<input class="form-control" name="cesit[fiyat_bir_onceki][]" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_bir_onceki') }}" >
															</div>
														</div>
														<div class="row mb-4">
															<div class="col-lg-6 col-sm-12 ">
																<label for="example-email-input1" class="col-form-label pt-0">Fiyat İki</label>
																<input class="form-control" name="cesit[fiyat_iki][]" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_iki') }}" >
															</div>
															<div  class="col-lg-6 col-sm-12 ">
																<label for="example-email-input1" class="col-form-label pt-0">Önceki fiyat</label>
																<input class="form-control" name="cesit[fiyat_iki_onceki][]" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_iki_onceki') }}" >
															</div>
														</div>
														<div class="row mb-4">
															<div class="col-lg-6 col-sm-12 ">
																<label for="example-email-input1" class="col-form-label pt-0">Fiyat Üç</label>
																<input class="form-control" name="cesit[fiyat_uc][]" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_uc') }}" >
															</div>
															<div  class="col-lg-6 col-sm-12 ">
																<label for="example-email-input1" class="col-form-label pt-0">Önceki fiyat</label>
																<input class="form-control" name="cesit[fiyat_uc_onceki][]" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_uc_onceki') }}">
															</div>
														</div>
														<div class="row mb-4">
															<div class="col-lg-6 col-sm-12 ">
																<label for="example-email-input1" class="col-form-label pt-0">Fiyat Dört</label>
																<input class="form-control" name="cesit[fiyat_dort][]" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_dort') }}">
															</div>
															<div  class="col-lg-6 col-sm-12 ">
																<label for="example-email-input1" class="col-form-label pt-0">Önceki fiyat</label>
																<input class="form-control" name="cesit[fiyat_dort_onceki][]" type="number" step="any" id="example-email-input1" placeholder="Fiyat giriniz"  value="{{ old('fiyat_dort_onceki') }}" >
															</div>
														</div>
													</div>
												</div>
											</div>
											<hr>
										</div>
										@endforeach 

									</div>

									@endforeach 
									
									@endif
									<button type="submit" class="btn btn-primary w-lg">Gönder</button>
								</form>
							</div>

						</div>
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