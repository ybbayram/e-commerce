@extends('admin.layouts.master')
@section('content')
@include('admin.layouts.partials.navbar')
<div class="main-content">

	<div class="page-content">
		<div class="container-fluid">

			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-flex align-items-center justify-content-between">
						<h4 class="mb-0 font-size-18"><b>{{ $cesit['ad'] }}</b> Ürün Çeşitini Güncelle</h4>
					</div>
				</div>
			</div>

			<div class="row">
				@include('admin.layouts.partials.alert')
				@include('admin.layouts.partials.errors')
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<a href="{{ route('admin.urunCesit', $cesit['urun_id']) }}"><span class="btn btn-purple btn btn-xl inputTwo" style="margin-bottom: 20px"><span class="dripicons-arrow-thin-left"> Önceki Sayfa</span></span></a>
							<h4 class="card-title">Çeşiti Güncelle</h4>
							<p class="card-title-desc">Çeşiti güncelleyiniz.</p>

							<div class="row">

								<div class="col-lg-12 col-sm-12 mb-4">
									<form action="{{ route('admin.urunCesit.guncelle', $cesit->id) }}" method="post">
										@csrf
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Başlık <span style="color: red;">*</span></label>
											<input class="form-control" name="ad" type="text" id="example-email-input1" placeholder="Çeşit adını giriniz" required="true" value="{{ old('ad', $cesit->baslik) }}">

											<input class="form-control" name="cesit_id" type="hidden" id="example-email-input1" required="true" value="{{ old('cesit_id', $cesit->id) }}">
										</div>

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