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
						<h4 class="mb-0 font-size-18">{{ $kategori['ad'] }} Kategorisinin {{ $kategoriDil['ad'] }} Kategori Dilini Güncelle</h4>
					</div>
				</div>
			</div>

			<div class="row">
				@include('admin.layouts.partials.alert')
				@include('admin.layouts.partials.errors')
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<a href="{{ route('admin.kategoriDil', $kategori['id']) }}"><span class="btn btn-purple btn btn-xl inputTwo" style="margin-bottom: 20px"><span class="dripicons-arrow-thin-left"> Önceki Sayfa</span></span></a>
							<h4 class="card-title">{{ $kategoriDil['ad'] }} Kategorisinin
								{{$kategoriDil->dil_bul['ad']}}
							Dilini Güncelle</h4>
							<p class="card-title-desc">Kategori Dili güncelleyiniz.</p>

							<div class="row">

								<div class="col-lg-12 col-sm-12 mb-4">
									<form action="{{ route('admin.kategoriDil.guncelle', ['kategori' => $kategori->id, 'id' => $kategoriDil->id]) }}" method="post" enctype="multipart/form-data">
										@csrf
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Ad <span style="color: red;">*</span></label>
											<input class="form-control" name="ad" type="text" id="example-email-input1" placeholder="Kategori dili adını giriniz" value="{{ old('ad', $kategoriDil->ad) }}">
										</div>
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Kapak Fotoğrafı <span style="color: red;">*</span></label>
											<div class="col-lg-3">
												<input id="input-file-now" class="dropify" name="gorsel" type="file" id="example-email-input1"  " data-default-file="{{ $kategoriDil->gorsel }}">
											</div>
										</div>
										<div class="form-group" id="example-email-input1">
											<label for="example-email-input1" class="col-form-label pt-0">Açıklama</label>
											<textarea id="elm1" name="aciklama">{{$kategoriDil->aciklama}}</textarea>
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