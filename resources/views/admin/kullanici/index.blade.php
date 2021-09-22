@extends('admin.layouts.master')
@section('title', 'Kullanıcı')
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
						<h4 class="mb-0 font-size-18">Kullanıcılar</h4>
					</div>
				</div>
			</div>
			<!-- end page title -->

			<div class="row">

				<div class="col-xl-12">
					<div class="card">
						<div class="card-body">
							<span class="float-right text-muted font-size-13"></span>
							<h5 class="card-title mb-3">Kullanıcılar</h5>
							<p class="card-title-desc">
								Kullanıcılara bu sayfadan ulaşabilirsiniz.
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
												<th>Email</th>
												<th>Rol</th>
												<th>Oluşturma Tarihi</th>
											</tr>
										</thead>
										<tbody>
											@foreach($user as $entry)
											<tr>
												<td>{{ $entry['ad'] }}</td>
												<td>{{ $entry['email'] }}</td>	
												<td>
													@if($entry->rol != 1)
													<form action="{{route('admin.user.bayi', $entry->id)}}" method="post">
														@csrf
														<div class="row">
															<div class="col-6">
																<select class="form-control" name="bayi">
																	<option selected>Rol Seçiniz</option>
																	<option @if($entry->rol == 2) selected  @endif value="2">Bayi 1</option>
																	<option @if($entry->rol == 3) selected  @endif value="3">Bayi 2</option>
																	<option @if($entry->rol == 4) selected  @endif value="4">Bayi 3</option>
																	<option @if($entry->rol == 5) selected  @endif value="5">Bayi 4</option>
																	<option @if($entry->rol == 0) selected  @endif value="0">Üye </option>
																</select>
															</div>
															<div class="col-6">

																<button class="btn btn-success btn-sm" type="submit">Gönder</button>
															</div>
														</div>
													</form>
													@else
													<p>Admin</p>
													@endif

												</td>	
												<td>{{ $entry['created_at'] }}</td>					
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