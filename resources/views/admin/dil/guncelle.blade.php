@extends('admin.layouts.master')
@section('content')
@include('admin.layouts.partials.navbar')
<div class="main-content">

	<div class="page-content">
		<div class="container-fluid">

			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-flex align-items-center justify-content-between">
						<h4 class="mb-0 font-size-18">Dil Güncelle</h4>
					</div>
				</div>
			</div>

			<div class="row">
				@include('admin.layouts.partials.alert')
				@include('admin.layouts.partials.errors')
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<a href="{{ route('admin.dil') }}"><span class="btn btn-purple btn btn-xl inputTwo" style="margin-bottom: 20px"><span class="dripicons-arrow-thin-left"> Önceki Sayfa</span></span></a>
							<span class="float-right text-muted font-size-13"></span>
							<h4 class="card-title">Dil Güncelle</h4>
							<p class="card-title-desc">Dil güncelleyiniz.</p>

							<div class="row">

								<div class="col-lg-12 col-sm-12 mb-4">
									<form action="{{ route('admin.dil.guncelle', $dil->id) }}" method="post">
										@csrf
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Ad <span style="color: red;">*</span></label>
											<input class="form-control" name="ad" type="text" id="example-email-input1" placeholder="Dil adını giriniz" required="true" value="{{ old('ad', $dil->ad) }}">
										</div>
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Görünür Ad <span style="color: red;">*</span></label>
											<input class="form-control" name="gorunurAd" type="text" id="example-email-input1" placeholder="Dilin görünür adını giriniz" required="true" value="{{ old('gorunurAd', $dil->gorunur_ad) }}">
										</div>
										<div class="form-group" id="example-email-input1">
											<label for="example-email-input1" class="col-form-label pt-0">Dil Kodu <span style="color: red;">*</span></label>
											<select class="form-control" name="ulke_kod_id">
												@foreach($ulkeKodlari as $entry)
												@if($entry->id == $dil->ulke_kod_id)
												<option value="{{ $entry->id }}" checked="true">{{ $entry->ad }}</option>
												@endif
												@endforeach
												@foreach($ulkeKodlari as $entry)
												@if($entry->id != $dil->ulke_kod_id)
												<option value="{{ $entry->id }}" >{{ $entry->ad }}</option>
												@endif
												@endforeach
											</select>
										</div>
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Json Verisi <span style="color: red;">*</span></label>
											<textarea name="json" rows="6" class="form-control">{{ old('json', $dil->json) }}</textarea>
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
