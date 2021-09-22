@extends('admin.layouts.master')
@section('css')
<link href="/adassets/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="/adassets/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="/adassets/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="/adassets/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" /> 
@endsection
@section('js')
<script src="/adassets/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/adassets/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/adassets/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="/adassets/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="/adassets/assets/libs/jszip/jszip.min.js"></script>
<script src="/adassets/assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="/adassets/assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="/adassets/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="/adassets/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="/adassets/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
<script src="/adassets/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="/adassets/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script src="/adassets/assets/js/pages/datatables.init.js"></script>
<script src="/adassets/assets/libs/tippy.js/tippy.all.min.js"></script>
<script src="/adassets/assets/js/pages/tooltipster.init.js"></script>
<script src="/adassets/assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="/adassets/assets/js/pages/sweet-alerts.init.js"></script>
@endsection
@section('content')
@include('admin.layouts.partials.navbar')
<div class="main-content">

	<div class="page-content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-flex align-items-center justify-content-between">
						<h4 class="mb-0 font-size-18">Kampanyalar</h4>
					</div>
				</div>
			</div>
			<!-- end page title -->

			<div class="row">

				<div class="col-xl-12">
					<div class="card">
						<div class="card-body"> 
							<a href="{{ route('admin.camp.index') }}"><span class="btn btn-purple btn btn-xl inputTwo" style="margin-bottom: 20px"><span class="dripicons-arrow-thin-left"> Önceki Sayfa</span></span></a>
							<span class="float-right text-muted font-size-13"></span>
							<h5 class="card-title mb-3">Kampanyalar </h5>
							<p class="card-title-desc">
								Kampanyalara bu sayfadan ulaşabilirsiniz.
							</p>
							<div id="donut-example" class="morris-charts workloed-chart"
							dir="ltr">
							@include('admin.layouts.partials.alert')
							@include('admin.layouts.partials.errors')
							<div class="card-body">
								<div class="table-responsive">
									<form action="{{ route('admin.camp.kampanyaSec', $ulke->id)}}" method="post">
										@csrf
										<ul>
											<label>
												Kargo
											</label>
											<ul class="mb-4">
												<input type="radio" name="kargolar[]" value="0" id="boskargo" class="form-check-input filled-in mt-1"><label for="boskargo">Boş</label> <br>
												@foreach($kargolar as $entry)
												<input type="radio" name="kargolar[]" value="{{ $entry->id}}" 
												@foreach($aktifKampanya as $aktif)
												@if($aktif->grup == 0 && $aktif->uygulanan_id == $entry->id)
												checked
												@endif
												@endforeach
												class="form-check-input filled-in mt-1"><label>{{$entry->ad}}</label> <br> 
												@endforeach
											</ul>
											<label>
												Sepette İndirim
											</label>
											<ul class="mb-4">
												<input type="radio" name="sepet[]" id="bosSepet" value="0" class="form-check-input filled-in mt-1"><label for="bosSepet">Boş</label> <br>
												
												@foreach($sepet as $entry)
												<input type="radio" name="sepet[]" value="{{ $entry->id}}" id="sepet{{$entry->id}}"
												@foreach($aktifKampanya as $aktif)
												@if($aktif->grup == 1 && $aktif->uygulanan_id == $entry->id)
												checked
												@endif
												@endforeach
												class="form-check-input filled-in mt-1"><label for="sepet{{$entry->id}}">{{$entry->ad}}</label> <br> 
												@endforeach
											</ul>
											<label>
												X Al Y Öde 
											</label>
											<ul class="mb-4">
												<input type="radio" name="XalYode[]" value="0" id="bosxy" class="form-check-input filled-in mt-1"><label for="bosxy">Boş</label> <br>
												@foreach($XalYode as $entry)
												<input type="radio" name="XalYode[]" id="xy{{$entry->id}}" value="{{ $entry->id}}" 
												@foreach($aktifKampanya as $aktif)
												@if($aktif->grup == 2 && $aktif->uygulanan_id == $entry->id)
												checked
												@endif
												@endforeach
												class="form-check-input filled-in mt-1"><label for="xy{{$entry->id}}">{{$entry->ad}}</label> <br> 
												@endforeach
											</ul>
											<label>
												Promosyon
											</label>
											<ul class="mb-4">
												<input type="radio" name="promosyon[]" value="0" id="bospromosyon" class="form-check-input filled-in mt-1"><label for="bospromosyon">Boş</label> <br>
												@foreach($promosyon as $entry)
												<input type="radio" name="promosyon[]" id="promosyon{{$entry->id}}" value="{{ $entry->id}}"  
												@foreach($aktifKampanya as $aktif)
												@if($aktif->grup == 3 && $aktif->uygulanan_id == $entry->id)
												checked
												@endif
												@endforeach
												class="form-check-input filled-in mt-1"><label for="promosyon{{$entry->id}}">{{$entry->ad}}</label> <br> 
												@endforeach
											</ul>
										</ul>
										<button type="submit" class="btn btn-primary btn-sm">Kaydet</button>
									</form>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>

		</div><!--end row-->
	</div>
</div>
</div>

@endsection
