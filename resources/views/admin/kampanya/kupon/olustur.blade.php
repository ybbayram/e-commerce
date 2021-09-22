@extends('admin.layouts.master')
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
							<a href="{{ route('admin.kupon') }}"><span class="btn btn-purple btn btn-xl inputTwo" style="margin-bottom: 20px"><span class="dripicons-arrow-thin-left"> Önceki Sayfa</span></span></a>
							<h4 class="card-title">Kupon Oluştur</h4>
							<p class="card-title-desc">Kupon oluşturunuz.</p>

							<div class="row">

								<div class="col-lg-12 col-sm-12 mb-4">
									<form action="{{route('admin.kupon.olustur')}}" method="post">
										@csrf
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Ad</label>
											<input class="form-control" name="ad" type="text" id="example-email-input1" placeholder="Kupon adını giriniz" required="true" value="{{ old('ad') }}">
										</div>
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Adet</label>
											<input class="form-control" name="adet" type="number"  id="example-email-input1" placeholder="Kupon adedini giriniz" required="true" value="{{ old('adet') }}">
										</div>
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Minimum Tutar</label>
											<input class="form-control" name="min" type="number" step="any" id="example-email-input1" placeholder="Minimum tutar giriniz" required="true" value="{{ old('min') }}">
										</div>
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">İndirim Tutarı</label>
											<input class="form-control" name="indirim_tutarı" type="number" step="any" id="example-email-input1" placeholder="İndirim tutarını giriniz" required="true" value="{{ old('indirim_tutarı') }}">
										</div>
										<div class="form-group">
											<label for="example-datetime-local-input" class="ccol-form-label pt-0">Başlangıç Tarihi</label> 
											<input class="form-control" name="baslangic_tarihi" type="datetime-local" value="{{ old('baslangic_tarihi') }}" id="example-datetime-local-input">
											
										</div>
										<div class="form-group">
											<label for="example-datetime-local-input" class="ccol-form-label pt-0">Bitiş Tarihi</label> 
											<input class="form-control" name="bitis_tarihi" type="datetime-local" value="{{ old('bitis_tarihi') }}" id="example-datetime-local-input">
											
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