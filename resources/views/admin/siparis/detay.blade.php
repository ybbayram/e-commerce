@extends('admin.layouts.master')
@section('title', 'Sipariş Detay')
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
						<h4 class="mb-0 font-size-18">Siparişler</h4>
					</div>
				</div>
			</div>
			<!-- end page title -->

			<div class="row">
				<div class="col-xl-12">
					<div class="card">
						<div class="card-body">
							<a href="{{ route('admin.siparis') }}"><span class="btn btn-purple btn btn-xl inputTwo" style="margin-bottom: 20px"><span class="dripicons-arrow-thin-left"> Önceki Sayfa</span></span></a>
							<span class="float-right text-muted font-size-13"></span>
							<h5 class="card-title mb-3">Sipariş Detay</h5>
							<p class="card-title-desc">
								Sipariş detaylarına bu sayfadan ulaşabilirsiniz.
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
												<th>İd</th> 
												<th>Ad</th> 
												<th>Adet</th> 
												<th>Çeşit</th> 
												<th>Promosyon</th> 
												<th>Fiyat</th> 
												<th>Oluşturma Tarihi</th>
											</tr>
										</thead>
										<tbody>
											@foreach($siparis->sepet_urun_getir as $detay) 
											
											<tr> 
												<td>{{ $detay->sepeturun_urun_getir['id'] }}</td>
												<td> 
													<button type="button" title="Detaylar"  class="d-xl-inline-block ml-1 btn btn-primary tippy-btn mr-2" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-center-{{ $detay->id }}"> <i class="fa fa-eye"></i> </button>    
													<div class="modal fade bs-example-modal-center-{{ $detay->id }}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
														<div class="modal-dialog modal-dialog-centered">
															<div class="modal-content">
																<div class="modal-header">
																	<h5 class="modal-title align-self-center mt-0" id="exampleModalLabel">Ürün Kodları</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																	</button>
																</div>
																<div class="modal-body">
																	<p><b>Barkod Numarası</b>: {{$detay->urun['barkod']}}</p>
																	<p><b>Stok Kodu</b>: {{$detay->urun['kod']}}</p>
																	@if(isset($detay->urun->urun_tedarikci_getir[0]))
																	<hr>
																	<h4>Tedarikçiler</h4>
																	@foreach($detay->urun->urun_tedarikci_getir as $tedarikci)
																	<p><b>Tedarikçi Adı</b>: {{$tedarikci->tedarikci_getir['ad']}} - <b>Stok Kodu</b>: {{$tedarikci['stok_kodu']}}</p>
																	@endforeach
																	@endif

																</div>
															</div><!-- /.modal-content -->
														</div><!-- /.modal-dialog -->
													</div><!-- /.modal -->
													{{ $detay->sepeturun_urun_getir['baslik'] }}</td>
													<td>{{ $detay->adet}}</td>
													@if(isset($detay->cesit_detay_id))
													<td style="color:green;">{{ $detay->cesit_detay_siparis_bul['ad']}}</td>
													@else
													<td style="color: grey;">Çeşit Yok</td>
													@endif
													@if($detay->promosyonMu == 1)
													<td>Evet</td>
													@else
													<td>Hayır</td>
													@endif
													<td>{{ $detay->fiyati}}</td>
													<td>{{ $detay->created_at}}</td>

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
			<div class="row">
				<div class="col-xl-6">

				</div>
				<div class="col-xl-6">
					<div class="card">
						<div class="card-body">
							<span class="float-right text-muted font-size-13"></span>
							<h5 class="card-title mb-3">Ödeme Bilgileri</h5>
							<p class="card-title-desc">
								Ödeme detaylarına bu alandan ulaşabilirsiniz.
							</p> 

							<div class="card-body">

								<div class="table-responsive">
									<table id="datatable-buttons" class="table table-striped table-bordered ">
										@if(isset($odeme->indirimTutari))
										<tbody> 
											<tr> 
												<td>İndirim</td>
												<td>{{ $odeme->indirimTutari}}</td>
											</tr> 
										</tbody>
										@endif 
										@if(isset($odeme->SepetindirimTutari))
										<tbody> 
											<tr>  
												<td>Sepette İndirim</td>
												<td>{{ $odeme->SepetindirimTutari}}</td>
											</tr> 
										</tbody>
										@endif
										@if(isset($odeme->indirimXalYode))
										<tbody> 
											<tr>   
												<td>X Al Y Öde İndirimi</td>
												<td>{{ $odeme->indirimXalYode}}</td>
											</tr> 
										</tbody>
										@endif 
										<tbody> 
											<tr>    
												<td>Kargo Fiyatı</td> 
												<td>{{ $odeme->kargoFiyat}}</td> 
											</tr> 
										</tbody>
										<tbody> 
											<tr>     
												<td width="150">Toplam</td> 
												<td>{{ $odeme->toplam}}</td> 
											</tr> 
										</tbody>
									</table> 
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection