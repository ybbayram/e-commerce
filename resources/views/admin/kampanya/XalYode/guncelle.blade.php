@extends('admin.layouts.master')
@section('css')
<style type="text/css">
.range-wrap {
	position: relative;
	margin: 0 auto 3rem;
}
.range {
	width: 100%;
}
.bubble {
	background: #0075FF;
	color: white;
	padding: 4px 12px;
	position: absolute;
	border-radius: 4px;
	left: 50%;
	transform: translateX(-50%);
}
.bubble::after {
	content: "";
	position: absolute;
	width: 2px;
	height: 2px;
	background: #0075FF;
	top: -1px;
	left: 50%;
}


</style>
@endsection
@section('js')
<script>
	const allRanges = document.querySelectorAll(".range-wrap");
	allRanges.forEach(wrap => {
		const range = wrap.querySelector(".range");
		const bubble = wrap.querySelector(".bubble");

		range.addEventListener("input", () => {
			setBubble(range, bubble);
		});
		setBubble(range, bubble);
	});

	function setBubble(range, bubble) {
		const val = range.value;
		const min = range.min ? range.min : 0;
		const max = range.max ? range.max : 100;
		const newVal = Number(((val - min) * 100) / (max - min));
		bubble.innerHTML = '% '+val;

  // Sorta magic numbers based on size of the native UI thumb
  bubble.style.left = `calc(${newVal}% + (${8 - newVal * 0.15}px))`;
}
</script>

<script src="/adassets/assets/js/pages/form-advanced.init.js"></script>

<script type="text/javascript">
	

	function xAlyOde(){
		var tur = document.getElementById('tur');
		var yuzde = document.getElementById('yuzde');
		var fiyat = document.getElementById('fiyat');
		
		if(tur.value == 0){
			yuzde.style.display = "block";
			fiyat.style.display = "none";
		}

		if(tur.value == 1){
			fiyat.style.display = "block";
			yuzde.style.display = "none";
		}
	}
	var tur = document.getElementById('tur');
	var yuzde = document.getElementById('yuzde');
	var fiyat = document.getElementById('fiyat');
	if(tur.value == 0){
		yuzde.style.display = "block";
		fiyat.style.display = "none";
	}

	if(tur.value == 1){
		fiyat.style.display = "block";
		yuzde.style.display = "none";
	}
</script>
<script type="text/javascript">

	var tur = document.getElementById('uyg_tur');
	var kategori = document.getElementById('kategori');
	var kategoriAlt = document.getElementById('kategoriAlt');
	var marka = document.getElementById('marka');
	var etiket = document.getElementById('etiket');
	var urunler = document.getElementById('urunler');
	function uygulamaTuru(){
		if(tur.value == 0){
			kategori.style.display = "block"; 
			kategoriAlt.style.display = "none"; 
			marka.style.display = "none"; 
			etiket.style.display = "none"; 
			urunler.style.display = "none"; 
		}
		if(tur.value == 1){
			kategori.style.display = "none"; 
			kategoriAlt.style.display = "block"; 
			marka.style.display = "none"; 
			etiket.style.display = "none"; 
			urunler.style.display = "none"; 
		}
		if(tur.value == 2){
			kategori.style.display = "none"; 
			kategoriAlt.style.display = "none"; 
			marka.style.display = "block"; 
			etiket.style.display = "none"; 
			urunler.style.display = "none"; 
		}
		if(tur.value == 3){
			kategori.style.display = "none"; 
			kategoriAlt.style.display = "none"; 
			marka.style.display = "none"; 
			etiket.style.display = "block"; 
			urunler.style.display = "none"; 
		}
		if(tur.value == 4){
			kategori.style.display = "none"; 
			kategoriAlt.style.display = "none"; 
			marka.style.display = "none"; 
			etiket.style.display = "none"; 
			urunler.style.display = "block"; 
		}
	}
	if(tur.value == 0){
		kategori.style.display = "block"; 
		kategoriAlt.style.display = "none"; 
		marka.style.display = "none"; 
		etiket.style.display = "none"; 
		urunler.style.display = "none"; 
	}
	if(tur.value == 1){
		kategori.style.display = "none"; 
		kategoriAlt.style.display = "block"; 
		marka.style.display = "none"; 
		etiket.style.display = "none"; 
		urunler.style.display = "none"; 
	}
	if(tur.value == 2){
		kategori.style.display = "none"; 
		kategoriAlt.style.display = "none"; 
		marka.style.display = "block"; 
		etiket.style.display = "none"; 
		urunler.style.display = "none"; 
	}
	if(tur.value == 3){
		kategori.style.display = "none"; 
		kategoriAlt.style.display = "none"; 
		marka.style.display = "none"; 
		etiket.style.display = "block"; 
		urunler.style.display = "none"; 
	}
	if(tur.value == 4){
		kategori.style.display = "none"; 
		kategoriAlt.style.display = "none"; 
		marka.style.display = "none"; 
		etiket.style.display = "none"; 
		urunler.style.display = "none"; 
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
						<h4 class="mb-0 font-size-18">Kampanyalar</h4>
					</div>
				</div>
			</div>

			<div class="row">
				@include('admin.layouts.partials.alert')
				@include('admin.layouts.partials.errors')
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<a href="{{ route('admin.xAlyOde') }}"><span class="btn btn-purple btn btn-xl inputTwo" style="margin-bottom: 20px"><span class="dripicons-arrow-thin-left"> Önceki Sayfa</span></span></a>
							<h4 class="card-title">Kampanya Güncelle</h4>
							<p class="card-title-desc">Kampanya Güncelle.</p>

							<div class="row">

								<div class="col-lg-12 col-sm-12 mb-4">
									<form action="{{route('admin.xAlyOde.guncelle', $XalYode->id)}}" method="post">
										@csrf
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Ad</label>
											<input class="form-control" name="ad" type="text" id="example-email-input1" placeholder="Kampanya adının giriniz." required="true" value="{{ old('min', $XalYode->ad) }}">
										</div>
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Adet Miktarı</label>
											<input class="form-control" name="min" type="number" step="any" id="example-email-input1" placeholder="Kaç adet ürüne indirim" required="true" value="{{ old('min', $XalYode->min) }}">
										</div>

										<div class="form-group " >
											<label class="mt-2">Uygulanacak İndirim Türü</label>
											<select class="form-control mb-3" id="tur" onchange="xAlyOde()" name="tur" style="width: 100%; ">
												<option>Tür Seçiniz</option> 
												<option value="0" @if($XalYode->tur == 0) selected @endif>Yüzde</option> 
												<option value="1" @if($XalYode->tur == 1) selected @endif>Adet</option> 
											</select> 
										</div>
										<div class="form-group range-wrap" id="yuzde" style="display: none">
											<div class="col-lg-5 col-sm-12 mb-4">
												<label for="example-email-input1" class="col-form-label pt-0">İndirim Oranı</label>
												<input style="padding:0px;" class="form-control range" name="oran" type="range" id="example-email-input1" placeholder="İndirim oranı giriniz"  min="0" max="100"  value="{{ old('oran', $XalYode->adet_yuzde) }}">
												<output class="bubble"></output>
											</div>
										</div>

										<div class="form-group" id="fiyat" style="display: none">
											<label for="example-email-input1" class="col-form-label pt-0">İndirim Adedi</label>
											<input class="form-control" name="adet" type="number" step="any" id="example-email-input1" placeholder="İndirim tutarını giriniz"  value="{{ old('adet', $XalYode->adet_yuzde) }}">
										</div>

										<div class="form-group">
											<label class="mt-2">Uygulanacak Alanlar</label>
											<select class="form-control mb-3" id="uyg_tur" onchange="uygulamaTuru()" disabled name="uyg_tur" style="width: 100%">
												<option>Tür Seçiniz</option> 
												<option value="0" @if($XalYode->grup == 0) selected @endif>Kategori</option> 
												<option value="1" @if($XalYode->grup == 1) selected @endif>Alt Kategori</option> 
												<option value="2" @if($XalYode->grup == 2) selected @endif>Marka</option> 
												<option value="3" @if($XalYode->grup == 3) selected @endif>Etiket</option> 
												<option value="4" @if($XalYode->grup == 4) selected @endif>Tüm Ürünler</option> 
											</select> 
										</div> 

										<div class="form-group"  id="kategori" style="display: none;">
											<label class="mt-2">Kategoriler</label>
											<select class="select2 mb-3 select2-multiple" name="kategoriler[]" style="width: 100%" multiple="multiple" >
												@foreach($kategoriler as $entry)
												<option value="{{ $entry->id }}" 
													@foreach($XalYodeDetay as $detay)
													@if($detay->uygulanan_id == $entry->id) selected @endif
													@endforeach
													>{{ $entry->ad }}</option>
													@endforeach
												</select> 
											</div>
											<div class="form-group"  id="kategoriAlt" style="display: none;">
												<label class="mt-2">Alt Kategoriler</label> 
												<select class="select2 mb-3 select2-multiple" name="kategorilerAlt[]" style="width: 100%" multiple="multiple">
													@foreach($kategoriler as $kategori)
													<optgroup label="{{ $kategori['ad'] }}">
														@foreach($kategori->kategori_alt_getir as $entry)	@foreach($XalYodeDetay as $detay)
														@if($detay->uygulanan_id == $entry->id) selected @endif
														@endforeach
														>{{ $entry->ad }}</option>
														@endforeach
													</optgroup>
													@endforeach
												</select> 
											</div>
											<div class="form-group"  id="marka" style="display: none;">
												<label class="mt-2">Marka</label>
												<select class="select2 mb-3 select2-multiple" name="markalar[]" style="width: 100%" multiple="multiple" >
													@foreach($markalar as $entry)
													<option value="{{ $entry->id }}"
														@foreach($XalYodeDetay as $detay)
														@if($detay->uygulanan_id == $entry->id) selected @endif
														@endforeach
														>{{ $entry->ad }}</option>
														@endforeach
													</select> 
												</div>
												<div class="form-group " id="etiket" style="display: none;" >
													<label class="mt-2">Etiketler</label> 
													<select class="select2 mb-3 select2-multiple" name="etiketler[]" style="width: 100%" multiple="multiple">
														@foreach($etiketler as $entry)
														<option value="{{ $entry->id }}"
															@foreach($XalYodeDetay as $detay)
															@if($detay->uygulanan_id == $entry->id) selected @endif
															@endforeach
															>{{ $entry->ad }}</option>
															@endforeach
														</select> 
													</div>
													<div class="form-group " id="urunler" style="display: none;" >
														<label class="mt-2">Tüm Ürünler</label> 
														<select class="select2 mb-3 select2-multiple" name="urunler[]" style="width: 100%" multiple="multiple" >
															<option value="4" selected>Tüm Ürünler</option>
														</select> 
													</div>


													<div class="form-group">
														<div class="col-lg-5 col-sm-12 mb-4" style=" padding: 0px;">
															<label for="example-datetime-local-input" class="ccol-form-label pt-0">Başlangıç Tarihi</label> 
															<input  class="form-control" name="baslangic_tarihi" type="datetime-local" value="{{ old('baslangic_tarihi') }}" id="example-datetime-local-input">

														</div>
													</div>
													<div class="form-group">
														<div class="col-lg-5 col-sm-12 mb-4" style=" padding: 0px;">
															<label for="example-datetime-local-input" class="ccol-form-label pt-0">Bitiş Tarihi</label> 
															<input class="form-control" name="bitis_tarihi" type="datetime-local" value="{{ old('bitis_tarihi') }}" id="example-datetime-local-input">

														</div>
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