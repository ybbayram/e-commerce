@extends('admin.layouts.master')
@section('content')
@include('admin.layouts.partials.navbar')
<div class="main-content">

	<div class="page-content">
		<div class="container-fluid">

			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-flex align-items-center justify-content-between">
						<h4 class="mb-0 font-size-18">{{ $banner['baslik'] }} slider Dilini Güncelle</h4>
					</div>
				</div>
			</div>

			<div class="row">
				@include('admin.layouts.partials.alert')
				@include('admin.layouts.partials.errors')
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<a href="{{ route('admin.site.banner2') }}"><span class="btn btn-purple btn btn-xl inputTwo" style="margin-bottom: 20px"><span class="dripicons-arrow-thin-left"> Önceki Sayfa</span></span></a>
							<p class="card-title-desc">Banner 2 Dili güncelleyiniz.</p>

							<div class="row">

								<div class="col-lg-12 col-sm-12 mb-4">
									<form action="{{ route('admin.site.banner2.guncelle', $banner->id) }}" method="post" enctype="multipart/form-data">
										@csrf 
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Fotoğraf</label>
											<p class="card-title-desc">
												<img src="{{ $banner->gorsel }}" height="80" >
											</p>
											<input class="form-control" name="gorsel" type="file" id="example-email-input1" placeholder="Fotoğraf Yükleyin"   >
										</div>
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Fotoğraf 2</label>
											<p class="card-title-desc">
												<img src="{{ $banner->gorsel2 }}" height="80" >
											</p>
											<input class="form-control" name="gorsel2" type="file" id="example-email-input1" placeholder="Fotoğraf Yükleyin"  >
										</div>
										<div class="form-group" id="example-email-input1">
											<label for="example-email-input1" class="col-form-label pt-0">Başlık</label>
											<input class="form-control" name="baslik" type="text" id="example-email-input1" placeholder="Slider başlığını giriniz"  value="{{ old('baslik', $banner->baslik) }}">
										</div> 

										<div class="form-group" id="example-email-input1">
											<label for="example-email-input1" class="col-form-label pt-0">Alt Başlık</label>
											<input class="form-control" name="baslik_alt" type="text" id="example-email-input1" placeholder="Slider başlığını giriniz"   value="{{ old('baslik', $banner->baslik_alt) }}">
										</div> 
										<div class="form-group" id="example-email-input1">
											<label for="example-email-input1" class="col-form-label pt-0">Detay</label>
											<input class="form-control" name="detay" type="text" id="example-email-input1" placeholder="Slider başlığını giriniz"   value="{{ old('baslik', $banner->detay) }}">
										</div> 
										<div class="form-group" id="example-email-input1">
											<label for="example-email-input1" class="col-form-label pt-0">Buton İsmi</label>
											<input class="form-control" name="buton_isim" type="text" id="example-email-input1" placeholder="Slider buton linkini giriniz"   value="{{ old('buton_link', $banner->buton_isim) }}">
										</div>
										<div class="form-group" id="example-email-input1">
											<label for="example-email-input1" class="col-form-label pt-0">Buton Link</label>
											<input class="form-control" name="buton_link" type="text" id="example-email-input1" placeholder="Slider buton linkini giriniz"  value="{{ old('buton_link', $banner->buton_link) }}">
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