@extends('admin.layouts.master')
@section('content')
@include('admin.layouts.partials.navbar')
<div class="main-content">

	<div class="page-content">
		<div class="container-fluid">

			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-flex align-items-center justify-content-between">
						<h4 class="mb-0 font-size-18">{{ $cesit['baslik'] }} Çeşitinin {{ $cesitDil['ad'] }} Çeşit Dilini Güncelle</h4>
					</div>
				</div>
			</div>

			<div class="row">
				@include('admin.layouts.partials.alert')
				@include('admin.layouts.partials.errors')
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<a href="{{ route('admin.urunCesitDil', $cesit['id']) }}"><span class="btn btn-purple btn btn-xl inputTwo" style="margin-bottom: 20px"><span class="dripicons-arrow-thin-left"> Önceki Sayfa</span></span></a>
							<h4 class="markaDil-title">{{ $cesitDil['ad'] }} Çeşitinin
								{{$cesitDil->dil_bul['ad']}}
							Dilini Güncelle</h4>
							<p class="card-title-desc">Çeşit Dili güncelleyiniz.</p>

							<div class="row">

								<div class="col-lg-12 col-sm-12 mb-4">
									<form action="{{ route('admin.urunCesitDil.guncelle', ['cesit' => $cesit->id, 'id' => $cesitDil->id]) }}" method="post" enctype="multipart/form-data">
										@csrf 

										<div class="form-group" id="example-email-input1">
											<label for="example-email-input1" class="col-form-label pt-0">Ad</label>
											<input type="text" name="ad" class="form-control" value="{{old('ad', $cesitDil->ad)}}">
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