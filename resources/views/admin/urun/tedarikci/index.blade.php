@extends('admin.layouts.master')
@section('title', 'Urun Tedarikçi')
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
						<h4 class="mb-0 font-size-18">Ürün</h4>
					</div>
				</div>
			</div>
			<!-- end page title -->

			<div class="row">

				<div class="col-xl-12">
					<div class="card">
						<div class="card-body">
							<a href="{{ route('admin.urun') }}"><span class="btn btn-purple btn btn-xl inputTwo" style="margin-bottom: 20px"><span class="dripicons-arrow-thin-left"> Önceki Sayfa</span></span></a>
							<span class="float-right text-muted font-size-13"></span>
							<button type="button" class="btn btn-light btn btn-xl inputTwo" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-center" style="margin-top: -20px; height: 37px; ">Tedarikçi Ekle</button>
							<h5 class="card-title mb-3">Ürün Tedarikçi</h5>
							<p class="card-title-desc">
								Ürün tedarikçilerine bu sayfadan ulaşabilirsiniz.
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
												<th>Stok Kodu</th>
												@if($urunDetay->cesit_durum == 0)<th>Çeşit Adı</th>@endif
												<th>Oluşturma Tarihi</th>
												<th>Detay</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												@foreach($urunTedarikcileri as $entry)

												<tr>
													<td>{{$entry->tedarikci_getir['ad']}}</td>
													<td>{{$entry->stok_kodu}}</td>
													@if($urunDetay->cesit_durum == 0)<td>{{$entry->cesit_detay_bul[0]->ad}}</td>@endif
													<td>{{$entry->created_at}} </td>					
													<td>
														<a href="{{ route('admin.urunTedarikci.guncelle.sayfa', $entry->id) }}" title="Düzenle" data-tippy-placement="top" class="btn btn-primary waves-effect waves-light tippy-btn"><i class="dripicons-pencil"></i></a> 
														@if($entry->durum == 0)
														<a href="{{ route('admin.urunTedarikci.aktifYap', $entry->id) }}" class="btn btn-danger waves-effect waves-light">Aktif Yap</a>
														@else
														<a href="{{ route('admin.urunTedarikci.pasifYap', $entry->id) }}" class="btn btn-success waves-effect waves-light">Pasif Yap</a>
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
																		<form action="{{ route('admin.urunTedarikci.sil', $entry->id) }}" method="get">
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
											</tr>
										</tbody>
									</table> 
								</div>
							</div>
						</div>


						<div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title align-self-center mt-0" id="exampleModalLabel">Çeşit</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<form action="{{ route('admin.urunTedarikci.olustur', $urun) }}" method="post">
											@csrf
											<div class="row"> 
												@if($urunDetay->cesit_durum == 0)
												<div class="col-lg-12 col-sm-12 ">
													<div class="form-group"  >
														<label class="mt-2">Çeşit <span style="color: red;">*</span></label>
														<select class="form-control mb-3" name="cesit_detay_id" style="width: 100%" required="true">
															@foreach($cesitDetay as $entry)
															<option value="{{ $entry->id }}">{{ $entry->ad }}</option>
															@endforeach
														</select> 
													</div>
												</div>
												@endif
												<div class="col-lg-12 col-sm-12 ">
													<div class="form-group"  >
														<label class="mt-2">Tedarikçi <span style="color: red;">*</span></label>
														<select class="form-control mb-3" name="tedarikci" style="width: 100%" required="true">
															@foreach($tedarikciler as $entry)
															<option value="{{ $entry->id }}">{{ $entry->ad }}</option>
															@endforeach
														</select> 
													</div>
												</div>
												<div class="col-lg-12 col-sm-12 ">
													<div class="form-group"  >
														<label class="mt-2">Tedarikçi Stok Kodu <span style="color: red;">*</span></label>
														<input type="text" class="form-control mb-3" name="stok_kodu" required>
													</div>
												</div>
											</div>

											<button type="submit" class="btn btn-primary w-lg btn-block">Gönder</button>
										</form>

									</div><!-- /.modal-content -->
								</div><!-- /.modal-dialog -->
							</div><!-- /.modal -->
						</div>




					</div>
				</div>
			</div>

		</div><!--end row-->
	</div>
</div>
</div>

@endsection




