@extends('admin.layouts.master')
@section('title', 'İadeler')
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
						<h4 class="mb-0 font-size-18">İade</h4>
					</div>
				</div>
			</div>
			<!-- end page title -->

			<div class="row">

				<div class="col-xl-12">
					<div class="card">
						<div class="card-body"> 
							<h5 class="card-title mb-3"> İade Soruları</h5>
							<p class="card-title-desc">
								İade Sorularına bu sayfadan ulaşabilirsiniz.
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
												<th>Sipariş Numarası</th>
												<th>Sebep</th>
												<th>Oluşturma Tarihi</th>
												<th>Kargo Takip Kodu</th>
												<th>Detay</th> 
											</tr>
										</thead>
										<tbody> 
											@foreach($iadeler as $entry) 
											<tr>
												<td>#{{$entry->siparis_id}}</td>
												<td>
													@if(isset($entry->iade_soru_getir))
													@if($entry->iade_sebebi != 0)										
													{{$entry->iade_soru_getir['aciklama']}}
													@else
													Diğer
													@endif
													@else
													@if($entry->iade_sebebi == 0)
													Diğer
													@endif
													@endif
												</td> 
												<td>{{ $entry['created_at'] }}</td> 
												@if($entry->durum == 1)
												<td>{{$entry->iade_kod['kargo_kod']}}</td>
												@else
												<td></td>
												@endif
												<td> 

													<button  type="button" title="Detay" class="btn btn-primary waves-effect waves-light tippy-btn" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-center-detay-{{ $entry->id }}">Detay</button>

													@if($entry->durum != 0)
													@if($entry->durum == 1)
													<a href="javascript::void(0)" class="btn btn-success waves-effect waves-light">Onaylandı</a>

													@endif
													@if($entry->durum == 2)
													<a href="javascript::void(0)" class="btn btn-danger waves-effect waves-light">Reddetildi</a>
													@endif
													@else 
													<button type="button" title="Onayla" class="d-xl-inline-block ml-1 btn btn-success tippy-btn" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-center-onay-{{ $entry->id }}"> Onayla </button>
													<div class="modal fade bs-example-modal-center-onay-{{ $entry->id }}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
														<div class="modal-dialog modal-dialog-centered">
															<div class="modal-content">
																<div class="modal-header">
																	<h5 class="modal-title align-self-center mt-0" id="exampleModalLabel">İadeyi onaylamak istiyor musunuz?</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																	</button>
																</div>
																<div class="modal-body">
																	<form action="{{ route('admin.iade.iadeler.onayla', $entry->id) }}" method="get">
																		@csrf
																		<input type="submit" value="Evet" class="btn btn-primary btn btn-xl inputTwo"/>
																	</form>
																</div>
															</div><!-- /.modal-content -->
														</div><!-- /.modal-dialog -->
													</div><!-- /.modal -->
													<button type="button" title="Reddet" class="d-xl-inline-block ml-1 btn btn-danger tippy-btn" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-center-{{ $entry->id }}"> Reddet </button>
													<div class="modal fade bs-example-modal-center-{{$entry->id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
														<div class="modal-dialog modal-dialog-centered">
															<div class="modal-content">
																<div class="modal-header">
																	<h5 class="modal-title align-self-center mt-0" id="exampleModalLabel">İadeyi reddetmek istiyor musunuz?</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																	</button>
																</div>
																<div class="modal-body">
																	<form action="{{ route('admin.iade.iadeler.red', $entry->id) }}" method="get">
																		@csrf
																		<input type="submit" value="Evet" class="btn btn-primary btn btn-xl inputTwo"/>
																	</form>
																</div>
															</div><!-- /.modal-content -->
														</div><!-- /.modal-dialog -->
													</div><!-- /.modal -->
													@endif
												</td>
											</tr>
											<div class="modal fade bs-example-modal-center-detay-{{ $entry->id }}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
												<div class="modal-dialog modal-dialog-centered">
													<div class="modal-content">

														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title align-self-center mt-0" id="mySmallModalLabel">İade Detay</h5>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">
																<div class="form-row row">  
																	<div class="col-md-12">
																		<label for="name"><b>İade Sebebi</b></label>
																		<p>
																			@if(isset($entry->iade_soru_getir))
																			@if($entry->iade_sebebi != 0)										
																			{{$entry->iade_soru_getir['aciklama']}}
																			@else
																			Diğer
																			@endif
																			@else
																			@if($entry->iade_sebebi == 0)
																			Diğer
																			@endif
																			@endif
																		</p>
																	</div>
																	@if(isset($entry->aciklama))
																	<div class="col-md-12">
																		<label for="name"><b>Açıklama</b></label>
																		<p>{{$entry->aciklama}}</p>
																	</div>
																	@endif

																	@if(isset($entry->gorsel))
																	<div class="col-md-12">
																		<label for="name"><b>Görsel 1</b></label><br>
																		<a href="{{$entry->gorsel}}" target="_blank">
																			<img src="{{$entry->gorsel}}" width="400px" >
																		</a>
																	</div>
																	@endif
																	@if(isset($entry->gorsel2))
																	<div class="col-md-12">
																		<label for="name"><b>Görsel 2</b></label><br>	
																		<a href="{{$entry->gorsel2}}" target="_blank">
																			<img src="{{$entry->gorsel2}}" width="400px">
																		</a>
																	</div>
																	@endif
																	<div class="col-md-12">

																	</div>
																</div>
															</div>
															<div class="modal-footer"> 
																<button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">
																	Kapat
																</button> 
															</div>
														</div>
													</div><!-- /.modal-dialog -->
												</div><!-- /.modal -->

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