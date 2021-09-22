@extends('admin.layouts.master')
@section('content')
@include('admin.layouts.partials.navbar')
<div class="main-content">

	<div class="page-content">
		<div class="container-fluid">

			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-flex align-items-center justify-content-between">
						<h4 class="mb-0 font-size-18"><b>{{ $cesitDetay['ad'] }}</b> Ürün Çeşitini Güncelle</h4>
					</div>
				</div>
			</div>

			<div class="row">
				@include('admin.layouts.partials.alert')
				@include('admin.layouts.partials.errors')
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<a href="{{ route('admin.urunCesitDetay', $cesitDetay['cesit_id']) }}"><span class="btn btn-purple btn btn-xl inputTwo" style="margin-bottom: 20px"><span class="dripicons-arrow-thin-left"> Önceki Sayfa</span></span></a>
							<h4 class="card-title">Çeşiti Güncelle</h4>
							<p class="card-title-desc">Çeşiti güncelleyiniz.</p>

							<div class="row">

								<div class="col-lg-12 col-sm-12 mb-4">
									<form action="{{ route('admin.urunCesitDetay.guncelle', $cesitDetay->cesit_id) }}" method="post">
										@csrf
										<div class="row"> 
											<div class="col-lg-12 col-sm-12 mb-4 ">
												<label for="example-email-input1" class="col-form-label pt-0">Adı<span style="color: red;">*</span></label>
												<input type="text" name="cesit" class="form-control" placeholder="Çeşit Adını Giriniz" required="true" value="{{old('cesit',$cesitDetay->ad)}}">
											</div>

											<input type="hidden" name="cesit_detay_id" class="form-control" required="true" value="{{old('cesit_detay_id',$cesitDetay->id)}}">
										</div>
										<div class="row"> 
											<div class="col-lg-12 col-sm-12  ">
												<div class="form-group " >
													<label for="example-email-input1" class="col-form-label pt-0">Ürün Kodu <span style="color: red;">*</span></label>
													<input class="form-control" name="kod" type="text" required="true" placeholder="Ürün Kodu" value="{{ old('kod', $cesitDetay->kod) }}">
												</div>
											</div>
										</div>
										<div class="row"> 
											<div class="col-lg-12 col-sm-12 ">
												<div class="form-group" >
													<label for="example-email-input1" class="col-form-label pt-0">Barkod <span style="color: red;">*</span></label>
													<input class="form-control" name="barkod" type="text" required="true" placeholder="Barkod" value="{{ old('barkod', $cesitDetay->barkod) }}">
												</div>
											</div>
										</div>
										<div class="row"> 
											<div class="col-lg-12 col-sm-12">
												<div class="form-group" >
													<label for="example-email-input1" class="col-form-label pt-0">Stok <span style="color: red;">*</span></label>
													<input class="form-control" name="stok" type="number" placeholder="Stok giriniz" value="{{ old('stok',$cesitDetay->stok) }}" required="true">
												</div>
											</div>
										</div>
										<div class="form-group" >
											<label class="mt-2 ">Desi <span style="color: red;">*</span></label>
											<div class="row">
												<div class="col-lg-2 col-sm-12 mb-4 ">
													<label for="example-email-input1" class="col-form-label pt-0">En</label>
													<input class="form-control" name="en" type="number" step="any" required="true" placeholder="En giriniz"  value="{{ old('en', $desi->en) }}" >
												</div>
												<div  class="col-lg-3 col-sm-12  mb-4">
													<label for="example-email-input1" class="col-form-label pt-0">Boy</label>
													<input class="form-control" name="boy" type="number" step="any "required="true" placeholder="Boy giriniz"  value="{{ old('boy', $desi->boy) }}">
												</div>
												<div class="col-lg-2 col-sm-12  mb-4">
													<label for="example-email-input1" class="col-form-label pt-0">Yükseklik</label>
													<input class="form-control" name="yukseklik" type="number" step="any" required="true" placeholder="Yükseklik giriniz"  value="{{ old('yukseklik', $desi->yukseklik) }}" >
												</div>
												<div class="col-lg-3 col-sm-12  mb-4">
													<label for="example-email-input1" class="col-form-label pt-0">Kilogram</label>
													<input class="form-control" name="kilogram" type="number" step="any" required="true" placeholder="Kilogram giriniz"  value="{{ old('kilogram',$desi->kilogram) }}" >
												</div>
												<div class="col-lg-2 col-sm-12  mb-4">
													<label for="example-email-input1" class="col-form-label pt-0">Desi</label>
													<input class="form-control" name="desi" type="number" step="any" required="true" disabled value="{{ old('desi',$desi->desi) }}" >
												</div>
											</div>
										</div> 
										<button type="submit" class="btn btn-primary ">Gönder</button>
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