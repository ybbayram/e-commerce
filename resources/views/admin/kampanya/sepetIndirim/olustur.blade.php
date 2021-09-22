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

<script type="text/javascript">
	function indirimTuru(){
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
							<a href="{{ route('admin.sepetIndirim') }}"><span class="btn btn-purple btn btn-xl inputTwo" style="margin-bottom: 20px"><span class="dripicons-arrow-thin-left"> Önceki Sayfa</span></span></a>
							<h4 class="card-title">Sepet İndirimi Oluştur</h4>
							<p class="card-title-desc">Sepet indirimi oluşturunuz.</p>

							<div class="row">

								<div class="col-lg-12 col-sm-12 mb-4">
									<form action="{{route('admin.sepetIndirim.olustur')}}" method="post">
										@csrf
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Ad</label>
											<input class="form-control" name="ad" type="text" id="example-email-input1" placeholder="Sepet Kampanya adını giriniz" required="true" value="{{ old('ad') }}">
										</div> 
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Minimum Değer</label>
											<input class="form-control" name="min" type="number" step="any" id="example-email-input1" placeholder="Minimum Sepet Tutarı" required="true" value="{{ old('min') }}">
										</div>

										<div class="form-group ">
											<label class="mt-2">İndirim Türü</label>
											<select class="form-control select2 mb-3" id="tur" onchange="indirimTuru()" name="tur" style="width: 100%">
												<option>Tür Seçiniz</option> 
												<option value="0">Yüzde</option> 
												<option value="1">Fiyat	</option> 
											</select> 
										</div>
										<div class="form-group range-wrap" id="yuzde" style="display: none">
											<div class="col-lg-5 col-sm-12 mb-4">
												<label for="example-email-input1" class="col-form-label pt-0">İndirim Oranı</label>
												<input style="padding:0px;" class="form-control range" name="oran" type="range" id="example-email-input1" placeholder="İndirim oranı giriniz"  min="0" max="100"  value="{{ old('oran') }}">
												<output class="bubble"></output>
												
											</div>
										</div>

										<div class="form-group" id="fiyat" style="display: none">
											<label for="example-email-input1" class="col-form-label pt-0">İndirim Tutarı</label>
											<input class="form-control" name="tutar" type="number" step="any" id="example-email-input1" placeholder="İndirim tutarını giriniz"  value="{{ old('tutar') }}">
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