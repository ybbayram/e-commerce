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

		if(cesit.value == 1){
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

			cesit.value = 0;
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

			cesit.value = 1;
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

	stok_req.required = true;
	kod_req.required  = true;
	barkod_req.required  = true;
	en_req.required  = true; 
	boy_req.required  = true; 
	yukseklik_req.required  = true; 
	kilogram_req.required  = true; 
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
						<h4 class="mb-0 font-size-18">Ürün Oluştur</h4>
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
							<h4 class="card-title">Ürün Oluştur</h4>
							<p class="card-title-desc">Ürün oluşturunuz.</p>

							<div class="row">

								<div class="col-lg-12 col-sm-12 mb-4">
									<form action="{{ route('admin.urun.olustur') }}" method="post">
										@csrf
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Başlık <span style="color: red;">*</span></label>
											<input class="form-control" name="baslik" type="text" id="example-email-input1" placeholder="Kategori başlığını giriniz" required="true" value="{{ old('baslik') }}">
										</div>
										<div class="form-group">
											<label class="col-form-label pt-0">Çeşit <span style="color: red;">*</span></label><br>
											<input type="checkbox" name="cesitVarMi" id="cesitVarMi" onchange="kdv()"  class="mr-2" value="1"><label for="cesitVarMi" class="col-form-label pt-0">Ürünün çeşiti var mı?</label>
										</div>
										<div class="form-group " id="kod" style="display: block">
											<label for="example-email-input1" class="col-form-label pt-0">Ürün Stok Kodu <span style="color: red;">*</span></label>
											<input class="form-control" name="kod" type="text" id="kod_req" placeholder="Ürün Kodu" value="{{ old('kod') }}">
										</div>
										<div class="form-group " id="barkod" style="display: block">
											<label for="example-email-input1" class="col-form-label pt-0">Barkod <span style="color: red;">*</span></label>
											<input class="form-control" name="barkod" type="text" id="barkod_req" placeholder="Barkod" value="{{ old('barkod') }}">
										</div>
										<div class="form-group " id="stok" style="display: block">
											<label for="example-email-input1" class="col-form-label pt-0">Stok <span style="color: red;">*</span></label>
											<input class="form-control" name="stok" type="number" id="stok_req" placeholder="Stok giriniz" value="{{ old('stok') }}">
										</div>
										
										<div class="form-group"  id="desi" style="display: block">
											<label class="mt-2 ">Desi <span style="color: red;">*</span></label>
											<div class="row">
												<div class="col-lg-3 col-sm-12 ">
													<label for="example-email-input1" class="col-form-label pt-0">En</label>
													<input class="form-control" name="en" type="number" step="any" id="en_req" placeholder="En giriniz"  value="{{ old('en') }}" >
												</div>
												<div  class="col-lg-3 col-sm-12 ">
													<label for="example-email-input1" class="col-form-label pt-0">Boy</label>
													<input class="form-control" name="boy" type="number" step="any" id="boy_req" placeholder="Boy giriniz"  value="{{ old('boy') }}">
												</div>
												<div class="col-lg-3 col-sm-12 ">
													<label for="example-email-input1" class="col-form-label pt-0">Yükseklik</label>
													<input class="form-control" name="yukseklik" type="number" step="any" id="yukseklik_req" placeholder="Yükseklik giriniz"  value="{{ old('yukseklik') }}" >
												</div>
												<div class="col-lg-3 col-sm-12 ">
													<label for="example-email-input1" class="col-form-label pt-0">Kilogram</label>
													<input class="form-control" name="kilogram" type="number" step="any" id="kilogram_req" placeholder="Kilogram giriniz"  value="{{ old('kilogram') }}" >
												</div>
											</div>
										</div>
										<label class="mt-2">Marka <span style="color: red;">*</span></label>
										<select class="form-control mb-3" name="marka" style="width: 100%" required="true">
											@foreach($markalar as $entry)
											<option value="{{ $entry->id }}">{{ $entry->ad }}</option>
											@endforeach
										</select> 
										<label class="mt-2">Kategoriler <span style="color: red;">*</span></label>
										<select class="select2 mb-3 select2-multiple" name="kategoriler[]" style="width: 100%" multiple="multiple" required="true">
											@foreach($adminKategoriler as $entry)
											<option value="{{ $entry->id }}">{{ $entry->ad }}</option>
											@endforeach
										</select>
										<div class="form-group ">
											<label class="mt-2">Etiketler</label> 
											<select class="select2 mb-3 select2-multiple" name="etiketler[]" style="width: 100%" multiple="multiple">
												@foreach($etiketler as $etiket)
												<option value="{{ $etiket->id }}">{{ $etiket->ad }}</option>
												@endforeach
											</select> 
										</div>
										<button type="submit" class="btn btn-primary w-lg">Gönder</button>
									</div>
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