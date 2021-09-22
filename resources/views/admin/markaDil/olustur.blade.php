@extends('admin.layouts.master')
@section('content')
@include('admin.layouts.partials.navbar')
<div class="main-content">

	<div class="page-content">
		<div class="container-fluid">

			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-flex align-items-center justify-content-between">
						<h4 class="mb-0 font-size-18">{{ $marka['ad'] }} Kategorisi Dili Oluştur</h4>
					</div>
				</div>
			</div>

			<div class="row">
				@include('admin.layouts.partials.alert')
				@include('admin.layouts.partials.errors')
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<a href="{{ route('admin.markaDil', $marka['id']) }}"><span class="btn btn-purple btn btn-xl inputTwo" style="margin-bottom: 20px"><span class="dripicons-arrow-thin-left"> Önceki Sayfa</span></span></a>
							<h4 class="card-title">Marka Dili Oluştur</h4>
							<p class="card-title-desc">Marka dili oluşturunuz.</p>

							<div class="row">

								<div class="col-lg-12 col-sm-12 mb-4">
									<form action="{{ route('admin.markaDil.olustur', $marka['id']) }}" method="post" enctype="multipart/form-data">
										@csrf
										<div class="form-group" id="example-email-input1">
											<label for="example-email-input1" class="col-form-label pt-0">Dil <span style="color: red;">*</span></label>
											<select class="form-control" name="dil_id">
												@foreach($diller as $entry)
												<option value="{{ $entry->id }}">{{ $entry->ad }}</option>
												@endforeach
											</select>
										</div>
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Fotoğraf</label>
											<input class="form-control" name="gorsel" type="file" id="example-email-input1" placeholder="Fotoğraf giriniz"  value="{{ old('gorsel') }}">
										</div>

										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Logo</label>
											<input class="form-control" name="logo" type="file" id="example-email-input1" placeholder="Fotoğraf giriniz"  value="{{ old('logo') }}">
										</div>
										<div class="form-group" id="example-email-input1">
											<label for="example-email-input1" class="col-form-label pt-0">Açıklama</label>
											<textarea id="elm1" name="aciklama"></textarea>
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