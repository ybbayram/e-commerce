@extends('admin.layouts.master')
@section('content')
@include('admin.layouts.partials.navbar')
<div class="main-content">

	<div class="page-content">
		<div class="container-fluid">

			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-flex align-items-center justify-content-between">
						<h4 class="mb-0 font-size-18">Tedarikçi</h4>
					</div>
				</div>
			</div>

			<div class="row">
				@include('admin.layouts.partials.alert')
				@include('admin.layouts.partials.errors')
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<a href="{{ route('admin.tedarikci') }}"><span class="btn btn-purple btn btn-xl inputTwo" style="margin-bottom: 20px"><span class="dripicons-arrow-thin-left"> Önceki Sayfa</span></span></a>
							<span class="float-right text-muted font-size-13"></span>
							<h4 class="card-title">Tedarikçi Oluştur</h4>
							<p class="card-title-desc">Tedarikçi oluşturunuz.</p>

							<div class="row">

								<div class="col-lg-12 col-sm-12 mb-4">
									<form action="{{ route('admin.tedarikci.olustur') }}" method="post">
										@csrf
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Ad <span style="color: red;">*</span></label>
											<input class="form-control" name="ad" type="text" placeholder="Tedarikçinin adını giriniz" required="true" value="{{ old('ad') }}">
										</div>
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Yetkili Ad <span style="color: red;">*</span></label>
											<input class="form-control" name="yetkiliAd" type="text" placeholder="Tedarikçi yetkilisinin adını giriniz" required="true" value="{{ old('yetkiliAd') }}">
										</div>
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Eposta <span style="color: red;">*</span></label>
											<input class="form-control" name="email" type="email" id="example-email-input1" placeholder="Tedarikçi epostasını giriniz" required="true" value="{{ old('email') }}">
										</div>
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Telefon <span style="color: red;">*</span></label>
											<input class="form-control" name="telefon" type="phone" placeholder="Tedarikçi telefon numarasını giriniz" required="true" value="{{ old('telefon') }}">
										</div>
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Vergi Dairesi <span style="color: red;">*</span></label>
											<input class="form-control" name="vergiDaire" type="text" id="example-email-input1" placeholder="Tedarikçi vergi dairesini giriniz" required="true" value="{{ old('vergiDaire') }}">
										</div>
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Vergi No<span style="color: red;">*</span></label>
											<input class="form-control" name="vergiNo" type="text" id="example-email-input1" placeholder="Tedarikçi vergi numarasını giriniz" required="true" value="{{ old('vergiNo') }}">
										</div>
										<div class="form-group" id="example-email-input1">
											<label for="example-email-input1" class="col-form-label pt-0">Ülke <span style="color: red;">*</span></label>
											<select class="form-control" name="ulke">
												@foreach($ulkeKodlari as $entry)
												<option value="{{ $entry->ad }}">{{ $entry->ad }}</option>
												@endforeach
											</select>
										</div>
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">İl <span style="color: red;">*</span></label>
											<input class="form-control" name="il" type="text" id="example-email-input1" placeholder="Tedarikçi yetkilisinin giriniz" required="true" value="{{ old('il') }}">
										</div>
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">İlçe <span style="color: red;">*</span></label>
											<input class="form-control" name="ilce" type="text" id="example-email-input1" placeholder="Tedarikçi ilçesini giriniz" required="true" value="{{ old('ilce') }}">
										</div>
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Adres <span style="color: red;">*</span></label>
											<input class="form-control" name="adres" type="text" id="example-email-input1" placeholder="Tedarikçi adresini giriniz" required="true" value="{{ old('adres') }}">
										</div>
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Not <span style="color: red;">*</span></label>
											<textarea name="not" rows="6" class="form-control">{{ old('not') }}</textarea>
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