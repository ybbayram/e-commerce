@extends('admin.layouts.master')
@section('js')
<script src="/adassets/assets/js/pages/form-advanced.init.js"></script>

<script type="text/javascript">
	function kdv(){
		var cesit = document.getElementById('cesitVarMi'); 

		var stok = document.getElementById('stok'); 
		var kod = document.getElementById('kod'); 
		var barkod = document.getElementById('barkod'); 
		var desi = document.getElementById('desi'); 

		var stok_req = document.getElementById('stok_req'); 
		var kod_req = document.getElementById('kod_req'); 
		var barkod_req = document.getElementById('barkod_req'); 
		var en_req = document.getElementById('en_req');
		var boy_req = document.getElementById('boy_req');
		var yukseklik_req = document.getElementById('yukseklik_req');
		var kilogram_req = document.getElementById('kilogram_req');
		var desi_req = document.getElementById('desi_req');

		if(cesit.value == 0){
			stok.style.display = "none";
			kod.style.display = "none";
			barkod.style.display = "none";
			desi.style.display = "none";


			stok_req.required = false;
			kod_req.required  = false;
			barkod_req.required  = false;
			en_req.required  = false; 
			boy_req.required  = false; 
			yukseklik_req.required  = false; 
			kilogram_req.required  = false; 

			stok_req.value = null;
			kod_req.value  = null;
			barkod_req.value  = null;
			en_req.value  = null; 
			boy_req.value  = null; 
			yukseklik_req.value  = null; 
			kilogram_req.value  = null; 
			desi_req.value  = null; 

			cesit.value = 1;
		}else{
			stok.style.display = "block";
			kod.style.display = "block";
			barkod.style.display = "block";
			desi.style.display = "block";

			stok_req.required = true;
			kod_req.required  = true;
			barkod_req.required  = true;
			en_req.required  = true; 
			boy_req.required  = true; 
			yukseklik_req.required  = true; 
			kilogram_req.required  = true; 


			cesit.value = 0;
		}

	}

	var cesit = document.getElementById('cesitVarMi'); 

	var stok = document.getElementById('stok'); 
	var kod = document.getElementById('kod'); 
	var barkod = document.getElementById('barkod'); 
	var desi = document.getElementById('desi'); 

	var stok_req = document.getElementById('stok_req'); 
	var kod_req = document.getElementById('kod_req'); 
	var barkod_req = document.getElementById('barkod_req'); 
	var en_req = document.getElementById('en_req');
	var boy_req = document.getElementById('boy_req');
	var yukseklik_req = document.getElementById('yukseklik_req');
	var kilogram_req = document.getElementById('kilogram_req');
	var desi_req = document.getElementById('desi_req');
	if(cesit.value == 0){
		stok.style.display = "none";
		kod.style.display = "none";
		barkod.style.display = "none";
		desi.style.display = "none";

		stok_req.required = false;
		kod_req.required  = false;
		barkod_req.required  = false;
		en_req.required  = false; 
		boy_req.required  = false; 
		yukseklik_req.required  = false; 
		kilogram_req.required  = false; 

		stok_req.value = null;
		kod_req.value  = null;
		barkod_req.value  = null;
		en_req.value  = null; 
		boy_req.value  = null; 
		yukseklik_req.value  = null; 
		kilogram_req.value  = null; 
		desi_req.value  = null; 

		cesit.value = 1;
	}else{
		stok.style.display = "block";
		kod.style.display = "block";
		barkod.style.display = "block";
		desi.style.display = "block";

		stok_req.required = true;
		kod_req.required  = true;
		barkod_req.required  = true;
		en_req.required  = true; 
		boy_req.required  = true; 
		yukseklik_req.required  = true; 
		kilogram_req.required  = true; 



		cesit.value = 0;
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
						<h4 class="mb-0 font-size-18">Ürün Güncelle</h4>
					</div>
				</div>
			</div>

			<div class="row">
				@include('admin.layouts.partials.alert')
				@include('admin.layouts.partials.errors')
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<a href="{{ route('admin.urun') }}"><span class="btn btn-purple btn btn-xl inputTwo" style="margin-bottom: 20px"><span class="dripicons-arrow-thin-left"> Önceki Sayfa</span></span></a>
							<h4 class="card-title">Ürün Güncelle</h4>
							<p class="card-title-desc">Ürün güncelleyiniz.</p>

							<div class="row">

								<div class="col-lg-12 col-sm-12 mb-4">
									<form action="{{ route('admin.urun.guncelle', $urun->id) }}" method="post">
										@csrf
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Ad <span style="color: red;">*</span></label>
											<input class="form-control" name="baslik" type="text" id="example-email-input1" placeholder="Kategori adını giriniz" required="true" value="{{ old('baslik', $urun->baslik) }}">
										</div>
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Slug <span style="color: red;">*</span></label>
											<input class="form-control" name="slug" type="text" id="example-email-input1" placeholder="Slug giriniz" required="true" value="{{ old('slug', $urun->slug) }}">
										</div>
										
										<div class="form-group" for="cesitVarMi">
											<label for="cesitVarMi" class="col-form-label pt-0">Çeşit <span style="color: red;">*</span></label><br>
											<input type="checkbox" name="cesitVarMi" id="cesitVarMi" onchange="kdv()"  class="mr-2" 
											@if($urun->cesit_durum == 0)
											checked
											value="0"
											@else
											value="1"
											@endif
											>
											<label for="cesitVarMi" class="col-form-label pt-0">Ürünün çeşiti var mı?</label>
										</div> 
										<div class="form-group " id="kod" style="display: block">
											<label for="example-email-input1" class="col-form-label pt-0">Ürün Stok Kodu <span style="color: red;">*</span></label>
											<input class="form-control" name="kod" type="text" id="kod_req" placeholder="Ürün Kodu" value="{{ old('kod', $urun->kod) }}">
										</div>
										<div class="form-group " id="barkod" style="display: block">
											<label for="example-email-input1" class="col-form-label pt-0">Barkod <span style="color: red;">*</span></label>
											<input class="form-control" name="barkod" type="text" id="barkod_req" placeholder="Barkod" value="{{ old('barkod', $urun->barkod) }}">
										</div>
										<div class="form-group " id="stok" style="display: block">
											<label for="example-email-input1" class="col-form-label pt-0">Stok <span style="color: red;">*</span></label>
											<input class="form-control" name="stok" type="number" id="stok_req" placeholder="Stok giriniz" value="{{ old('stok', $urun->stok) }}">
										</div>
										@if($urun->stok == 0)
										<div class="form-group" >
											<input type="checkbox" name="haberVerilsinMi" id="haberVerilsinMi" value="1" class="mr-2">
											<label class="col-form-label pt-0" for="haberVerilsinMi">Kullanıcılara haber verilsin mi?</label>
										</div> 
										@endif
										<div class="form-group"  id="desi" style="display: block">
											<label class="mt-2 ">Desi <span style="color: red;">*</span></label>
											<div class="row">
												<div class="col-lg-2 col-sm-12 ">
													<label for="example-email-input1" class="col-form-label pt-0">En</label>
													<input class="form-control" name="en" type="number" step="any" id="en_req" placeholder="En giriniz" @if(isset($desi->en)) value="{{ old('en', $desi->en)}}" @endif>
												</div>
												<div  class="col-lg-3 col-sm-12 ">
													<label for="example-email-input1" class="col-form-label pt-0">Boy</label>
													<input class="form-control" name="boy" type="number" step="any" id="boy_req" placeholder="Boy giriniz" @if(isset($desi->boy)) value="{{ old('boy',$desi->boy) }}" @endif>
												</div>
												<div class="col-lg-2 col-sm-12 ">
													<label for="example-email-input1" class="col-form-label pt-0">Yükseklik</label>
													<input class="form-control" name="yukseklik" type="number" step="any" id="yukseklik_req" placeholder="Yükseklik giriniz"  @if(isset($desi->yukseklik)) value="{{ old('yukseklik', $desi->yukseklik) }}" @endif>
												</div>
												<div class="col-lg-3 col-sm-12 ">
													<label for="example-email-input1" class="col-form-label pt-0">Kilogram</label>
													<input class="form-control" name="kilogram" type="number" step="any" id="kilogram_req" placeholder="Kilogram giriniz" @if(isset($desi->kilogram)) value="{{ old('kilogram', $desi->kilogram) }}" @endif>
												</div>
												<div class="col-lg-2 col-sm-12 ">
													<label for="example-email-input1" class="col-form-label pt-0">Desi</label>
													<input class="form-control btn btn-light" name="desi" type="number" step="any" id="desi_req" disabled placeholder="Desi" @if(isset($desi->desi)) value="{{ old('desi', $desi->desi) }}" @endif>
												</div>
											</div>
										</div>
										<label class="mt-2">Marka <span style="color: red;">*</span></label>
										<select class="form-control mb-3" name="marka" style="width: 100%" required="true">
											@foreach($markalar as $entry)
											@if($urun->marka == $entry->id )
											<option value="{{ $entry->id }}" selected>{{ $entry->ad }}</option>
											@else
											<option value="{{ $entry->id }}">{{ $entry->ad }}</option>
											@endif
											@endforeach
										</select> 
										<div class="form-group ">
											<label class="mt-2">Kategoriler <span style="color: red;">*</span></label>
											<select class="select2 mb-3 select2-multiple" name="kategoriler[]" style="width: 100%" multiple="multiple" required="true">
												@foreach($urunKat as $uk)
												@foreach($adminKategoriler as $entry)
												@if($uk->kategori_id == $entry->id )
												<option value="{{ $entry->id }}" selected>{{ $entry->ad }}</option>
												@else
												@endif
												@endforeach
												@endforeach
												@foreach($adminKategoriler as $entry)
												<option value="{{ $entry->id }}">{{ $entry->ad }}</option>
												@endforeach
											</select> 
										</div>
										<div class="form-group ">
											<label class="mt-2">Etiketler</label>
											<select class="select2 mb-3 select2-multiple" name="etiketler[]" style="width: 100%" multiple="multiple">
												@foreach($urunEtiket as $uk)
												@foreach($etiketler as $entry)
												@if($uk->etiket_id == $entry->id )
												<option value="{{ $entry->id }}" selected>{{ $entry->ad }}</option>
												@endif
												@endforeach
												@endforeach
												@foreach($etiketler as $entry)   
												<option value="{{ $entry->id }}">{{ $entry->ad }}</option> 
												@endforeach
											</select> 
										</div>
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