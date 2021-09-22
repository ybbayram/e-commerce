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
							<h4 class="card-title">Güncelle</h4>
							<p class="card-title-desc">Sözleşme başlığını güncelleyiniz.</p>

							<div class="row">

								<div class="col-lg-12 col-sm-12 mb-4">
									<form action="{{ route('admin.sozlesme.guncelle', $sozlesme->id) }}" method="post">
										@csrf
										<div class="form-group"> 
											<input type="checkbox" name="goster" @if($sozlesme->odeme_durum == 1) checked @endif id="varMi" class="mr-2" value="1">
											<label for="varMi" class="col-form-label pt-0">Sözleşme ödeme sayfasında gösterilsin mi?</label>
										</div>
										<div class="form-group"> 
											<input type="checkbox" name="kayit_goster" @if($sozlesme->kayit_durum == 1) checked @endif id="kvarMi" class="mr-2" value="1">
											<label for="kvarMi" class="col-form-label pt-0">Kayıt sayfasında gösterilsin mi?</label>
										</div>
										<div class="form-group"> 
											<input type="checkbox" name="cookie_goster" @if($sozlesme->cookie_durum == 1) checked @endif id="cookieMi" class="mr-2" value="1">
											<label for="cookieMi" class="col-form-label pt-0">Cookie alanında gösterilsin mi?</label>
										</div>
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Başlık <span style="color: red;">*</span></label>
											<input class="form-control" name="baslik" type="text" id="example-email-input1" placeholder="Başlık Giriniz" required="true" value="{{ old('baslik', $sozlesme->baslik) }}">
										</div>
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Slug</label>
											<input class="form-control" name="slug" type="text" id="example-email-input1" placeholder="Detay Giriniz" required="true" disabled value="{{ old('slug', $sozlesme->slug) }}">
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