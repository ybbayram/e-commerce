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
<script src="/adassets/assets/js/pages/form-advanced.init.js"></script>
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
<script type="text/javascript">
	function uygulamaTuru(){
		var tur = document.getElementById('uyg_tur');
		var kategori = document.getElementById('kategori');
		var kategoriAlt = document.getElementById('kategoriAlt');
		var marka = document.getElementById('marka');
		var etiket = document.getElementById('etiket');
		var urunler = document.getElementById('urunler');

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
		if(tur.value == 5){
			kategori.style.display = "none"; 
			kategoriAlt.style.display = "none"; 
			marka.style.display = "none"; 
			etiket.style.display = "none"; 
			urunler.style.display = "block"; 
		}
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
							<a href="{{ route('admin.promosyon') }}"><span class="btn btn-purple btn btn-xl inputTwo" style="margin-bottom: 20px"><span class="dripicons-arrow-thin-left"> Önceki Sayfa</span></span></a>
							<h4 class="card-title"> Promosyon Oluştur</h4>
							<p class="card-title-desc"> Promosyon oluşturunuz.</p>

							<div class="row">

								<div class="col-lg-12 col-sm-12 mb-4">
									<form action="{{route('admin.promosyon.olustur')}}" method="post">
										@csrf
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Ad</label>
											<input class="form-control" name="ad" type="text" id="example-email-input1" placeholder="Promosyon adının giriniz." required="true" value="{{ old('min') }}">
										</div>
										
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Sepet Minimum Tutar</label>
											<input class="form-control" name="min" type="number" step="any" id="example-email-input1" placeholder="Sepet Minimum Tutar" required="true" value="{{ old('min') }}">
										</div>

										<div class="form-group">
											<label class="mt-2">İndirim Türü</label>
											<select class="form-control mb-3" id="uyg_tur" onchange="uygulamaTuru()" name="uyg_tur" style="width: 100%">
												<option>Tür Seçiniz</option> 
												<option value="4">Tüm Ürünler</option> 
												<option value="5">Ürünler</option> 
												<option value="0">Kategori</option> 
												<option value="1">Alt Kategori</option> 
												<option value="2">Marka</option> 
												<option value="3">Etiket</option> 
											</select> 
										</div> 

										<div class="form-group"  id="kategori" style="display: none;">
											<label class="mt-2">Kategoriler</label>
											<select class="select2 mb-3 select2-multiple" name="kategoriler[]" style="width: 100%" multiple="multiple" >
												@foreach($kategoriler as $entry)
												<option value="{{ $entry->id }}">{{ $entry->ad }}</option>
												@endforeach
											</select> 
										</div>
										<div class="form-group"  id="kategoriAlt" style="display: none;">
											<label class="mt-2">Alt Kategoriler</label> 
											<select class="select2 mb-3 select2-multiple" name="kategorilerAlt[]" style="width: 100%" multiple="multiple">
												@foreach($kategoriler as $kategori)
												<optgroup label="{{ $kategori['ad'] }}">
													@foreach($kategori->kategori_alt_getir as $entry)
													<option value="{{ $entry->id }}">{{ $entry->ad }}</option>
													@endforeach
												</optgroup>
												@endforeach
											</select> 
										</div>
										<div class="form-group"  id="marka" style="display: none;">
											<label class="mt-2">Marka</label>
											<select class="select2 mb-3 select2-multiple" name="markalar[]" style="width: 100%" multiple="multiple" >
												@foreach($markalar as $entry)
												<option value="{{ $entry->id }}">{{ $entry->ad }}</option>
												@endforeach
											</select> 
										</div>
										<div class="form-group " id="etiket" style="display: none;" >
											<label class="mt-2">Etiketler</label> 
											<select class="select2 mb-3 select2-multiple" name="etiketler[]" style="width: 100%" multiple="multiple">
												@foreach($etiketler as $entry)
												<option value="{{ $entry->id }}">{{ $entry->ad }}</option>
												@endforeach
											</select> 
										</div>
										<div class="form-group " id="urunler" style="display: none;" >
											<label class="mt-2">Ürünler</label> 
											<select class="select2 mb-3 select2-multiple" name="urunler[]" style="width: 100%" multiple="multiple" >
												@foreach($urunler as $entry)
												<option value="{{ $entry->id }}">{{ $entry->baslik }}</option>
												@endforeach
											</select> 
										</div>
										<div class="form-group " >
											<label class="mt-2">Promosyon Verilecek Ürünler</label> 
											<select class="select2 mb-3 select2-multiple" name="pro_urunler[]" style="width: 100%" multiple="multiple" >
												@foreach($urunler as $entry)
												<option value="{{ $entry->id }}">{{ $entry->baslik }}</option>
												@endforeach
											</select> 
										</div>

										<div class="form-group">
											<div class="col-lg-5 col-sm-12 mb-4" style=" padding: 0px;">
												<label for="example-datetime-local-input" class="ccol-form-label pt-0">Başlangıç Tarihi</label> 
												<input  class="form-control" name="baslangic_tarihi" type="datetime-local" value="{{ old('baslangic_tarihi') }}" id="example-datetime-local-input" required="true">

											</div>
										</div>
										<div class="form-group">
											<div class="col-lg-5 col-sm-12 mb-4" style=" padding: 0px;">
												<label for="example-datetime-local-input" class="ccol-form-label pt-0">Bitiş Tarihi</label> 
												<input class="form-control" name="bitis_tarihi" type="datetime-local" value="{{ old('bitis_tarihi') }}" id="example-datetime-local-input" required="true">

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