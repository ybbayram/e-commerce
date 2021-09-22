@extends('admin.layouts.master')
@section('title', 'Slider')
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
						<h4 class="mb-0 font-size-18">Slider</h4>
					</div>
				</div>
			</div>
			<!-- end page title -->

			<div class="row">

				<div class="col-xl-12">
					<div class="card">
						<div class="card-body">
							<a href="{{ route('admin.site.slider.olustur.sayfa') }}"><span class="btn btn-primary btn btn-xl inputTwo" style="margin-bottom: 20px">Yeni Slider</span></span></a>
							<a href="{{ route('admin.site.slider.sirala.sayfa') }}"><span class="btn btn-primary btn btn-xl inputTwo" style="margin-bottom: 20px">Sırala</span></span></a>
							<span class="float-right text-muted font-size-13"></span>

							<h5 class="card-title mb-3">Slider</h5>
							<p class="card-title-desc">
								Sliderlara bu sayfadan ulaşabilirsiniz.
							</p>
							<div id="donut-example" class="morris-charts workloed-chart"
							dir="ltr">
							@include('admin.layouts.partials.alert')
							@include('admin.layouts.partials.errors')
							<div class="card-body">

								<div class="table-responsive">
									<table id="datatable-buttons" class="table table-striped table-bordered w-100">
										<thead>
											<tr>
												<th>Ad</th>
												<th>Oluşturma Tarihi</th>												
												<th>Detay</th>

											</tr>
										</thead>
										<tbody>
											@foreach($slider as $entry)
											<tr>
												<td>{{ $entry['ad'] }}</td>
												<td>{{ $entry['created_at'] }}</td>
												<td>
													<a href="{{ route('admin.site.slider.guncelle.sayfa', $entry->id) }}" title="Düzenle" data-tippy-placement="top" class="btn btn-primary waves-effect waves-light tippy-btn"><i class="dripicons-pencil"></i></a>
													<a href="{{ route('admin.site.sliderDil', $entry->id) }}" title="Dil"  class="btn btn-primary waves-effect waves-light tippy-btn"><i class="dripicons-flag"></i></a>
													@if($entry->durum == 0)
													<a href="{{ route('admin.site.slider.aktifYap', $entry->id) }}" class="btn btn-danger waves-effect waves-light">Aktif Yap</a>
													@else
													<a href="{{ route('admin.site.slider.pasifYap', $entry->id) }}" class="btn btn-success waves-effect waves-light">Pasif Yap</a>
													@endif
													<button type="button" title="Sil"  class="d-xl-inline-block ml-1 btn btn-danger tippy-btn" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-center-{{ $entry->id }}"> Sil </button>



													<div class="modal fade bs-example-modal-center-{{ $entry->id }}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
														<div class="modal-dialog modal-dialog-centered">
															<div class="modal-content">
																<div class="modal-header">
																	<h5 class="modal-title align-self-center mt-0" id="exampleModalLabel">Silmek istiyor musunuz?</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																	</button>
																</div>
																<div class="modal-body">
																	<form action="{{ route('admin.site.slider.sil', $entry->id) }}" method="get">
																		@csrf
																		<input type="submit" value="Evet" class="btn btn-primary btn btn-xl inputTwo"/>
																	</form>
																</div>
															</div><!-- /.modal-content -->
														</div><!-- /.modal-dialog -->
													</div><!-- /.modal -->
												</td>
											</tr>
											@endforeach
										</tbody>
									</table>
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
