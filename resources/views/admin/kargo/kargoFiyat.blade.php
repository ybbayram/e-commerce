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
						<h4 class="mb-0 font-size-18">Kargo</h4>
					</div>
				</div>
			</div>
			<!-- end page title -->

			<div class="row">

				<div class="col-xl-12">
					<div class="card">
						<div class="card-body"> 
							<a href="{{ route('admin.kargolar') }}"><span class="btn btn-purple btn btn-xl inputTwo" style="margin-bottom: 20px"><span class="dripicons-arrow-thin-left"> Önceki Sayfa</span></span></a>
							<span class="float-right text-muted font-size-13"></span>
							<h5 class="card-title mb-3">Kargo Fiyat </h5>
							<p class="card-title-desc">
								Kargo fiyatına bu sayfadan ulaşabilirsiniz 
							</p>
							@include('admin.layouts.partials.alert')
							@include('admin.layouts.partials.errors')
							<div class="row">

								<div class="col-lg-12 col-sm-12 mb-4">
									<form   method="post" action="{{route('admin.kargo.fiyat', $kargo->id)}}">
										@csrf
										<div class="form-group">
											<label>Alt Fiyat</label>
											<input type="number" step="any" min="0" name="limit_alt_fiyat" class="form-control mb-2" value="{{$kargo->limit_alt_fiyat}}">
											<input type="hidden" step="any" min="0" name="ulke_id" class="form-control mb-2" value="{{$ulke->id}}">
										</div>

										<div class="form-group">
											<label>Limit</label>
											<input type="number" step="any" min="0" name="limit" class="form-control mb-2" value="{{$kargo->limit}}">
										</div>
										<div class="form-group">
											<label>Üst Fİyat</label>
											<input type="number" step="any" min="0" name="limit_üst_fiyat" class="form-control mb-2" value="{{$kargo->limit_üst_fiyat}}">
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-primary">Güncelle</button>
										</div>

									</form>
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
