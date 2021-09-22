@extends('admin.layouts.master')
@section('content')
@include('admin.layouts.partials.navbar')
<div class="main-content">

	<div class="page-content">
		<div class="container-fluid">

			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-flex align-items-center justify-content-between">
						<h4 class="mb-0 font-size-18">{{ $slider['ad'] }} Sliderının {{ $sliderDil['ad'] }} slider Dilini Güncelle</h4>
					</div>
				</div>
			</div>

			<div class="row">
				@include('admin.layouts.partials.alert')
				@include('admin.layouts.partials.errors')
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<a href="{{ route('admin.site.sliderDil', $slider['id']) }}"><span class="btn btn-purple btn btn-xl inputTwo" style="margin-bottom: 20px"><span class="dripicons-arrow-thin-left"> Önceki Sayfa</span></span></a>
							<h4 class="markaDil-title">{{ $sliderDil['ad'] }} Markasının
								{{$sliderDil->dil_bul['ad']}}
							Dilini Güncelle</h4>
							<p class="card-title-desc">Slider Dili güncelleyiniz.</p>

							<div class="row">

								<div class="col-lg-12 col-sm-12 mb-4">
									<form action="{{ route('admin.site.sliderDil.guncelle', ['slider' => $slider->id, 'id' => $sliderDil->id]) }}" method="post" enctype="multipart/form-data">
										@csrf 
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Kapak Fotoğraf</label>
											<p class="card-title-desc">
												<img src="{{ $sliderDil->gorsel }}" height="80" >
											</p>
											<input class="form-control" name="gorsel" type="file" id="example-email-input1" placeholder="Fotoğraf Yükleyin"   >
										</div>
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Mobil Kapak Fotoğraf</label>
											<p class="card-title-desc">
												<img src="{{ $sliderDil->gorsel_mobil }}" height="80" >
											</p>
											<input class="form-control" name="gorsel_mobil" type="file" id="example-email-input1" placeholder="Mobil için fotoğraf Yükleyin"   >
										</div>
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Mobil Kapak Fotoğraf</label>
											<p class="card-title-desc">
												<img src="{{ $sliderDil->gorsel_3 }}" height="80" >
											</p>
											<input class="form-control" name="gorsel_3" type="file" id="example-email-input1" placeholder="3. boyut için fotoğraf Yükleyin"   >
										</div>
										<div class="form-group" id="example-email-input1">
											<label for="example-email-input1" class="col-form-label pt-0">Başlık</label>
											<input class="form-control" name="baslik" type="text" id="example-email-input1" placeholder="Slider başlığını giriniz" required="true" value="{{ old('baslik', $sliderDil->baslik) }}">
										</div>
										<div class="form-group" id="example-email-input1">
											<label for="example-email-input1" class="col-form-label pt-0">Detay</label>
											<input class="form-control" name="detay" type="text" id="example-email-input1" placeholder="Slider detayını giriniz" required="true" value="{{ old('detay', $sliderDil->detay) }}">
										</div>
										<div class="form-group" id="example-email-input1">
											<label for="example-email-input1" class="col-form-label pt-0">Buton Yazısı</label>
											<input class="form-control" name="buton_baslik" type="text" id="example-email-input1" placeholder="Slider buton başlığını giriniz" required="true" value="{{ old('buton_baslik', $sliderDil->buton_baslik) }}">
										</div>

										<div class="form-group" id="example-email-input1">
											<label for="example-email-input1" class="col-form-label pt-0">Buton Link</label>
											<input class="form-control" name="buton_link" type="text" id="example-email-input1" placeholder="Slider buton linkini giriniz" required="true" value="{{ old('buton_link', $sliderDil->buton_link) }}">
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