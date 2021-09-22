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
						<h4 class="mb-0 font-size-18">Sözleşmeler</h4>
					</div>
				</div>
			</div>

			<div class="row">
				@include('admin.layouts.partials.alert')
				@include('admin.layouts.partials.errors')
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<a href="{{ route('admin.sozlesme') }}"><span class="btn btn-purple btn btn-xl inputTwo" style="margin-bottom: 20px"><span class="dripicons-arrow-thin-left"> Önceki Sayfa</span></span></a>
							<h4 class="card-title"> Oluştur</h4>
							<p class="card-title-desc">Sözleşme oluşturunuz.</p>

							<div class="row">

								<div class="col-lg-12 col-sm-12 mb-4">
									<form action="{{ route('admin.sozlesme.olustur') }}" method="post">
										@csrf
										<div class="form-group"> 
											<input type="checkbox" name="goster" id="varMi" class="mr-2" value="1">
											<label for="varMi" class="col-form-label pt-0">Sözleşme <b style="color:darkblue;">ödeme sayfasında</b> gösterilsin mi?</label>
										</div>
										<div class="form-group"> 
											<input type="checkbox" name="kayit_goster" id="KvarMi" class="mr-2" value="1">
											<label for="KvarMi" class="col-form-label pt-0">Sözleşme <b style="color:darkblue;">kayıt sayfasında</b> gösterilsin mi?</label>
										</div>
										<div class="form-group"> 
											<input type="checkbox" name="cookie_goster" id="cookieMi" class="mr-2" value="1">
											<label for="cookieMi" class="col-form-label pt-0">Sözleşme <b style="color:darkblue;">cookie alanında </b> gösterilsin mi?</label>
										</div>
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Başlık <span style="color: red;">*</span></label>
											<input class="form-control" name="baslik" type="text" id="example-email-input1" placeholder="Başlık Giriniz" required="true" value="{{ old('baslik') }}">
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