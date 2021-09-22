@extends('admin.layouts.master')
@section('content')
@include('admin.layouts.partials.navbar')
<div class="main-content">

	<div class="page-content">
		<div class="container-fluid">

			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-flex align-items-center justify-content-between">
						<h4 class="mb-0 font-size-18">{{ $banner['ad'] }} bannerının {{ $bannerDil['ad'] }} banner Dilini Güncelle</h4>
					</div>
				</div>
			</div>

			<div class="row">
				@include('admin.layouts.partials.alert')
				@include('admin.layouts.partials.errors')
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<a href="{{ route('admin.site.bannerDil', $banner['id']) }}"><span class="btn btn-purple btn btn-xl inputTwo" style="margin-bottom: 20px"><span class="dripicons-arrow-thin-left"> Önceki Sayfa</span></span></a>
							<h4 class="markaDil-title">{{ $bannerDil['ad'] }} Bannerının
								{{$bannerDil->dil_bul['ad']}}
							Dilini Güncelle</h4>
							<p class="card-title-desc">Banner Dili güncelleyiniz.</p>

							<div class="row">

								<div class="col-lg-12 col-sm-12 mb-4">
									<form action="{{ route('admin.site.bannerDil.guncelle', ['banner' => $banner->id, 'id' => $bannerDil->id]) }}" method="post" enctype="multipart/form-data">
										@csrf 
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Kapak Fotoğraf</label>
											<p class="card-title-desc">
												<img src="{{ $bannerDil->gorsel }}" height="80" >
											</p>
											<input class="form-control" name="gorsel" type="file" id="example-email-input1" placeholder="Fotoğraf Yükleyin"   >
										</div>
										<div class="form-group" id="example-email-input1">
											<label for="example-email-input1" class="col-form-label pt-0">Başlık</label>
											<input class="form-control" name="baslik" type="text" id="example-email-input1" placeholder="Banner başlığını giriniz" required="true" value="{{ old('baslik', $bannerDil->baslik) }}">
										</div> 
										<div class="form-group" id="example-email-input1">
											<label for="example-email-input1" class="col-form-label pt-0">Buton Link</label>
											<input class="form-control" name="buton_link" type="text" id="example-email-input1" placeholder="Banner buton linkini giriniz" required="true" value="{{ old('buton_link', $bannerDil->buton_link) }}">
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