@extends('admin.layouts.master')	
@section('js')
<script src="/adassets/assets/js/pages/form-advanced.init.js"></script>
@endsection
@section('content')
@include('admin.layouts.partials.navbar')
<div class="main-content">

	<div class="page-content">
		<div class="container-fluid">

			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-flex align-items-center justify-content-between">
						<h4 class="mb-0 font-size-18">Filtre Güncelle</h4>
					</div>
				</div>
			</div>

			<div class="row">
				@include('admin.layouts.partials.alert')
				@include('admin.layouts.partials.errors')
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<a href="{{ route('admin.filtre') }}"><span class="btn btn-purple btn btn-xl inputTwo" style="margin-bottom: 20px"><span class="dripicons-arrow-thin-left"> Önceki Sayfa</span></span></a>
							<h4 class="card-title">Filtre Güncelle</h4>
							<p class="card-title-desc">Filtre güncelleyiniz.</p>

							<div class="row">

								<div class="col-lg-12 col-sm-12 mb-4">
									<form action="{{ route('admin.filtre.guncelle', $filtre->id) }}" method="post">
										@csrf
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Ad <span style="color: red;">*</span></label>
											<input class="form-control" name="ad" type="text" id="example-email-input1" placeholder="Filtre adını giriniz" required="true" value="{{ old('ad', $filtre->ad) }}">
										</div>
										<div class="form-group ">
											<label class="mt-2">Kategoriler <span style="color: red;">*</span></label>
											<select class="select2 mb-3 select2-multiple" name="kategoriler[]" style="width: 100%" multiple="multiple" required="true">
												@foreach($filtreKat as $uk)
												@foreach($adminKategoriler as $entry)
												@if($uk->kategori_id == $entry->id )
												<option value="{{ $entry->id }}" selected>{{ $entry->ad }}</option>
												@else
												@endif
												@endforeach
												@endforeach
												@foreach($adminKategoriler as $entry)
												<option value="{{ $entry->id }}">{{ $entry->ad }}</option>
												@endforeach
											</select> 
										</div>
										
										<div class="form-group ">
											<label class="mt-2">Etiketler <span style="color: red;">*</span></label>
											<select class="select2 mb-3 select2-multiple" name="etiketler[]" style="width: 100%" multiple="multiple"required="true">
												@foreach($filtre_etiket as $uk)
												@foreach($etiketler as $entry)
												@if($entry->durum == 1)
												@if($uk->etiket_id == $entry->id )
												<option value="{{ $entry->id }}" selected>{{ $entry->ad }}</option>
												@endif
												@endif
												@endforeach
												@endforeach
												@foreach($etiketler as $entry) 
												@if($entry->durum == 1)
												<option value="{{ $entry->id }}">{{ $entry->ad }}</option>  
												@endif
												@endforeach
											</select> 
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