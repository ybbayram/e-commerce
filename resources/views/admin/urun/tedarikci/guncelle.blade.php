@extends('admin.layouts.master')
@section('content')
@include('admin.layouts.partials.navbar')
<div class="main-content">

	<div class="page-content">
		<div class="container-fluid">

			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-flex align-items-center justify-content-between">
						<h4 class="mb-0 font-size-18">Ürün</h4>
					</div>
				</div>
			</div>

			<div class="row">
				@include('admin.layouts.partials.alert')
				@include('admin.layouts.partials.errors')
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<a href="{{ route('admin.urunTedarikci', $tedarikci->urun_id) }}"><span class="btn btn-purple btn btn-xl inputTwo" style="margin-bottom: 20px"><span class="dripicons-arrow-thin-left"> Önceki Sayfa</span></span></a>
							<h4 class="card-title">Ürün Tedarikçi </h4>
							<p class="card-title-desc">Ürün Tedarikçi güncelleyiniz.</p>

							<div class="row">

								<div class="col-lg-12 col-sm-12 mb-4">
									<form action="{{ route('admin.urunTedarikci.guncelle', $tedarikci->id) }}" method="post">
										@csrf
										<div class="row"> 
											
											<div class="col-lg-12 col-sm-12 ">
												<div class="form-group"  >
													<label class="mt-2">Tedarikçi <span style="color: red;"><small>Değiştirilmez</small></span></label>
													<input type="hidden" name="tedarikci" value="{{$tedarikci->id}}">
													<select class="form-control mb-3" name="tedarikci" style="width: 100%" required="true" disabled>

														@foreach($tedarikciler as $entry)
														@if($tedarikci->tedarikci_id == $entry->id )
														<option value="{{ $entry->id }}" selected>{{ $entry->ad }}</option>
														@else
														<option value="{{ $entry->id }}">{{ $entry->ad }}</option>
														@endif
														@endforeach
													</select> 
												</div>
											</div>
											@if($urunDetay->cesit_durum == 0)
											<div class="col-lg-12 col-sm-12 ">
												<div class="form-group"  >
													<label class="mt-2">Çeşit <span style="color: red;"><small>*</small></span></label>
													<select class="form-control mb-3" name="cesit_detay_id" style="width: 100%" required="true" >
														@foreach($cesitDetay as $entry)
														@if($cesit->id == $entry->id )
														<option value="{{ $entry->id }}" selected>{{ $entry->ad }}</option>
														@else
														<option value="{{ $entry->id }}">{{ $entry->ad }}</option>
														@endif
														@endforeach
													</select> 
												</div>
											</div>
											@endif
											<div class="col-lg-12 col-sm-12 ">
												<div class="form-group"  >
													<label class="mt-2">Tedarikçi Stok Kodu <span style="color: red;">*</span></label>  
													<input type="text" class="form-control mb-3" name="stok_kodu" required value="{{old('stok_kodu', $tedarikci->stok_kodu)}}">
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