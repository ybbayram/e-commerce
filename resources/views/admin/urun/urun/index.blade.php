@extends('admin.layouts.master')
@section('title', 'Ürün')
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
						<h4 class="mb-0 font-size-18">Ürünler</h4>
					</div>
				</div>
			</div>
			<!-- end page title -->

			<div class="row">

				<div class="col-xl-12">
					<div class="card">
						<div class="card-body">
							<a href="{{ route('admin.urun.olustur.sayfa') }}"><span class="btn btn-primary btn btn-xl inputTwo" style="margin-bottom: 20px">Yeni Ürün</span></span></a>
							<span class="float-right text-muted font-size-13"></span>
							
							<a href="#"><span class="btn btn-success btn btn-xl inputTwo" style="margin-bottom: 20px" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-center-hepsiAktif"> Hepsini Aktif Yap</span></a>

							<div class="modal fade bs-example-modal-center-hepsiAktif" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title align-self-center mt-0" id="exampleModalLabel">Hepsini aktif etmek istiyor musunuz?</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<form action="{{route('admin.urun.hepsiniAc')}}" method="get">
												@csrf
												<input type="submit" value="Evet" class="btn btn-primary btn btn-xl inputTwo"/>
											</form>
										</div>
									</div><!-- /.modal-content -->
								</div><!-- /.modal-dialog -->
							</div><!-- /.modal -->

							<a href="#"><span class="btn btn-danger btn btn-xl inputTwo" style="margin-bottom: 20px" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-center-hepsiPasif"> Hepsini Pasif Yap</span></a>
							<div class="modal fade bs-example-modal-center-hepsiPasif" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title align-self-center mt-0" id="exampleModalLabel">Hepsini pasif etmek istiyor musunuz?</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<form action="{{route('admin.urun.hepsiniKapat')}}" method="get">
												@csrf
												<input type="submit" value="Evet" class="btn btn-primary btn btn-xl inputTwo"/>
											</form>
										</div>
									</div><!-- /.modal-content -->
								</div><!-- /.modal-dialog -->
							</div><!-- /.modal -->
							
							<h5 class="card-title mb-3">Ürünler</h5>
							<p class="card-title-desc">
								Ürünlere bu sayfadan ulaşabilirsiniz.
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
												<th>Başlık</th>
												<th>Ürün Kodu</th>
												<th>Barkod</th>
												<th>Marka</th>
												<th>Stok</th>
												<th>Oluşturma Tarihi</th>
												<th>Detay</th>
											</tr>
										</thead>
										<tbody>
											@foreach($urun as $entry)
											<tr>
												<td>{{ $entry['baslik'] }}</td>
												<td>
													@if($entry->cesit_durum != 0)
													{{ $entry['kod'] }}
													@else
													@foreach($entry->cesitler_bul as $cesit)
													@foreach($cesit->cesit_detay_bul as $cesitDetay)
													<span class="tippy-btn" title="{{ $cesitDetay['ad'] }}">{{ $cesitDetay['kod'] }}</span> @if($cesit->cesit_detay_bul->last() !== $cesitDetay)<br> @endif
													@endforeach
													@endforeach
													@endif
												</td>
												<td>
													@if($entry->cesit_durum != 0)
													{{ $entry['barkod'] }}
													@else
													@foreach($entry->cesitler_bul as $cesit)
													@foreach($cesit->cesit_detay_bul as $cesitDetay)
													<span class="tippy-btn" title="{{ $cesitDetay['ad'] }}">{{ $cesitDetay['barkod'] }}</span> @if($cesit->cesit_detay_bul->last() !== $cesitDetay)<br> @endif
													@endforeach
													@endforeach
													@endif
												</td>
												<td>{{ $entry->marka_bul['ad'] }}</td>
												<td>
													@if($entry->cesit_durum != 0)
													{{ $entry['stok'] }}
													@else
													@foreach($entry->cesitler_bul as $cesit)
													@foreach($cesit->cesit_detay_bul as $cesitDetay)
													<span class="tippy-btn" title="{{ $cesitDetay['ad'] }}">{{ $cesitDetay['stok'] }}</span> @if($cesit->cesit_detay_bul->last() !== $cesitDetay)<br> @endif
													@endforeach
													@endforeach
													@endif
												</td>
												<td><span class="tippy-btn" title="Son Güncelleme: {{ $entry['updated_at'] }}">{{ $entry['created_at'] }}</span></td>					
												<td>
													<a href="{{ route('admin.urun.guncelle.sayfa', $entry->id) }}" title="Düzenle" data-tippy-placement="top" class="btn btn-primary waves-effect waves-light tippy-btn btn-sm"><i class="dripicons-pencil"></i></a>

													<a href="{{ route('admin.urunDetay', $entry->id) }}" title="Detay"  class="btn btn-primary waves-effect waves-light tippy-btn btn-sm">Detay</a>

													<a href="{{ route('admin.urunTedarikci', $entry->id) }}" title="Tedarikçi"  class="btn btn-primary waves-effect waves-light tippy-btn btn-sm"><i class="dripicons-store"></i></a>

													<a href="{{ route('admin.urunGorsel', $entry->id) }}" title="Görsel"  class="btn btn-primary waves-effect waves-light tippy-btn btn-sm">Görsel</a>
													@if($entry->cesit_durum == 0)
													<a href="{{ route('admin.urunCesit', $entry->id) }}" title="Çeşit"  class="btn btn-primary waves-effect waves-light tippy-btn btn-sm">Çeşit</a>
													@endif
													<a href="{{ route('admin.urunFiyat', $entry->id) }}" title="Fiyat"  class="btn btn-primary waves-effect waves-light tippy-btn btn-sm">Fiyat</a>

													@if($entry->durum == 0)
													<button type="button" title="Aktif Yap"  class="btn btn-danger waves-effect waves-light btn-sm" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-center-Aktif{{ $entry->id }}"> Aktif Yap </button>
													<div class="modal fade bs-example-modal-center-Aktif{{ $entry->id }}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
														<div class="modal-dialog modal-dialog-centered">
															<div class="modal-content">
																<div class="modal-header">
																	<h5 class="modal-title align-self-center mt-0" id="exampleModalLabel">Aktif yapmak istiyor musunuz?</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																	</button>
																</div>
																<div class="modal-body">
																	<a href="{{ route('admin.urun.aktifYap', $entry->id) }}" class="btn btn-danger waves-effect waves-light btn-sm">Aktif Yap</a>
																</div>
															</div><!-- /.modal-content -->
														</div><!-- /.modal-dialog -->
													</div><!-- /.modal -->
													@else
													<button type="button" title="Aktif Yap"   class="btn btn-success waves-effect waves-light btn-sm" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-center-Aktif{{ $entry->id }}"> Pasif Yap </button>
													<div class="modal fade bs-example-modal-center-Aktif{{ $entry->id }}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
														<div class="modal-dialog modal-dialog-centered">
															<div class="modal-content">
																<div class="modal-header">
																	<h5 class="modal-title align-self-center mt-0" id="exampleModalLabel">Pasif yapmak istiyor musunuz?</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																	</button>
																</div>
																<div class="modal-body">
																	<a href="{{ route('admin.urun.pasifYap', $entry->id) }}" class="btn btn-success waves-effect waves-light btn-sm">Pasif Yap</a>
																</div>
															</div><!-- /.modal-content -->
														</div><!-- /.modal-dialog -->
													</div><!-- /.modal -->
													@endif
													<button type="button" title="Sil"  class="d-xl-inline-block ml-1 btn btn-danger tippy-btn btn-sm" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-center-{{ $entry->id }}"> Sil </button>
													<a href="{{ route('urun', $entry->slug) }}" target="_blank" class="btn btn-light">
														<i class="fas fa-eye"></i>
													</a>
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
																	<form action="{{ route('admin.urun.sil', $entry->id) }}" method="get">
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