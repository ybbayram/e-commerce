@extends('admin.layouts.master')
@section('js')
<script src="/adassets/assets/libs/dropzone/min/dropzone.min.js"></script>
<script src="/adassets/assets/libs/dropify/js/dropify.min.js"></script>
<script src="/adassets/assets/js/pages/form-fileuploads.init.js"></script>
@endsection
@section('css')
<link href="/adassets/assets/libs/dropzone/min/dropzone.min.css" rel="stylesheet" type="text/css" />
<link href="/adassets/assets/libs/dropify/css/dropify.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@include('admin.layouts.partials.navbar')
<div class="main-content">

	<div class="page-content">
		<div class="container-fluid">

			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-flex align-items-center justify-content-between">
						<h4 class="mb-0 font-size-18"><b>{{ $urun['baslik'] }}</b> Ürünü İçin Görsel Oluştur</h4>
					</div>
				</div>
			</div>

			<div class="row">
				@include('admin.layouts.partials.alert')
				@include('admin.layouts.partials.errors')
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<a href="{{ route('admin.urunGorsel', $urun['id']) }}"><span class="btn btn-purple btn btn-xl inputTwo" style="margin-bottom: 20px"><span class="dripicons-arrow-thin-left"> Önceki Sayfa</span></span></a>
							<h4 class="card-title">Ürün Görseli Oluştur</h4>
							<p class="card-title-desc">Ürün görseli oluşturunuz.</p>

							<div class="row">

								<div class="col-lg-12 col-sm-12 mb-4">
									<form action="{{ route('admin.urunGorsel.olustur', $urun['id']) }}" method="post" enctype="multipart/form-data">
										@csrf
										<div class="form-group ">

											<button type="submit" class="btn btn-primary w-lg">Gönder <span style="color: red;">*</span></button><br><br> 
											<div class="row mb-4">
												<div class=" col-lg-6 mb-2">
													<input  id="input-file-now" class="dropify" name="gorsel" type="file" id="example-email-input1">
												</div>
												<div class=" col-lg-6 mb-2">
													<input  id="input-file-now" class="dropify" name="gorsel_iki" type="file" id="example-email-input1">
												</div>
												<div class=" col-lg-6 mb-2">
													<input  id="input-file-now" class="dropify" name="gorsel_uc" type="file" id="example-email-input1">
												</div>
												<div class=" col-lg-6 mb-2">
													<input  id="input-file-now" class="dropify" name="gorsel_dort" type="file" id="example-email-input1">
												</div>
												<div class=" col-lg-6 mb-2">
													<input  id="input-file-now" class="dropify" name="gorsel_bes" type="file" id="example-email-input1">
												</div>
												<div class=" col-lg-6 mb-2">
													<input  id="input-file-now" class="dropify" name="gorsel_alti" type="file" id="example-email-input1">
												</div>
												<div class=" col-lg-6 mb-2">
												</div>
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