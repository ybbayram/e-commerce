@extends('admin.layouts.master')
@section('title', 'Sipariş')
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
<script type="text/javascript">
	function kargoclick(id){
		var kargo = document.getElementById('kargo'+id); 

		console.log(kargo);
		var kargo_var = document.getElementById('kargo_var'+id);    
		if(kargo.value == 3){
			kargo_var.style.display = "block";

		}else{
			kargo_var.style.display = "none";
		}
	} 
	var kargo = document.getElementById('kargo'); 

</script>
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
							<span class="float-right text-muted font-size-13"></span>
							<h5 class="card-title mb-3">Siparişler</h5>
							<p class="card-title-desc">
								Siparişlere bu sayfadan ulaşabilirsiniz.
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
												<th>Ödeme Türü</th> 
												<th>Ref No</th> 
												<th>Sipariş Durumu</th> 
												<th>Oluşturma Tarihi</th>
												<th>Detay</th>
											</tr>
										</thead>
										<tbody>
											@foreach($siparisler as $entry)
											<tr> 

												<td>{{ $entry->id }}</td>
												<td>@if($entry->adres_bul){{ $entry->adres_bul['isim'] }}@endif</td>
												<td>Kredi Kartı</td>
												<td>@if($entry->adres_bul){{ $entry->adres_bul['isim'] }}@endif</td>
												<td>
													<form action="{{route('admin.siparis.islem', $entry->id)}}" method="post">
														@csrf
														<div class="row">
															<div class="col-lg-6">
																<select class="form-control" onchange="kargoclick({{$entry->id}})" id="kargo{{$entry->id}}" name="islem">
																	<option >Rol Seçiniz</option>
																	@foreach($durumlar as $durum)
																	<option @if($entry->islem_durum == $durum->durum_id) selected  @endif value="{{$durum->durum_id}}">{{$durum->durum}}</option>
																	@endforeach
																</select>
															</div>
															<div class="col-lg-6">
																<button class="btn btn-success " type="submit">Gönder</button>
															</div>
															<div id="kargo_var{{$entry->id}}" @if($entry->islem_durum == 3)style="display: block;" @else style="display: none;" @endif
																<div class="col-lg-6">
																	<label>Kargo Kod:</label>
																	<input type="text" class="form-control" placeholder="Kargo Takip Kod" name="kargo_kod" value="{{$entry->kargo_kod}}">
																</div>
															</div>
														</div>
													</form> 
												</td>
												<td>{{ $entry['created_at'] }}</td>  
												<td>

													<a href="{{ route('admin.siparis.detay', $entry->id) }}" class="btn btn-primary waves-effect waves-light"><i class="dripicons-pencil"></i></a>
													<button type="button" title="Adres"  class="d-xl-inline-block ml-1 btn btn-primary tippy-btn" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-center-adres{{ $entry->id }}"><i class="dripicons-article"></i></button>
													<div class="modal fade bs-example-modal-center-adres{{ $entry->id }}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
														<div class="modal-dialog modal-dialog-centered">
															<div class="modal-content">
																<div class="modal-header">
																	<h5 class="modal-title align-self-center mt-0" id="exampleModalLabel">Adres Bilgileri</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																	</button>
																</div>
																<div class="modal-body">
																	@if(isset($entry->adres_bul))
																	<h4>Teslimat Bilgisi</h4>
																	<hr>
																	<p>Adı: {{$entry->adres_bul['isim']}}</p>
																	<p>Ülke: {{$entry->adres_bul->ulke_getir->ulke_kod_getir['ad']}}</p>
																	<p>İl: {{$entry->adres_bul['il']}}</p>
																	<p>İlce: {{$entry->adres_bul['ilce']}}</p>
																	<p>Mahalle: {{$entry->adres_bul['mahalle']}}</p>
																	<p>Adres: {{$entry->adres_bul['adres']}}</p>
																	<p>Telefon: {{$entry->adres_bul['telefon']}}</p>
																	<p>Mail: {{$entry->adres_bul['mail']}}</p>
																	@if($entry->adres_bul['kurumsal_mi'] == 1)
																	<p>Firma Adı: {{$entry->adres_bul->adres_kurumsal_getir['firma_adi']}}</p>
																	<p>Vergi Numarası: {{$entry->adres_bul->adres_kurumsal_getir['vergi_numarasi']}}</p>
																	<p>Vergi Dairesi: {{$entry->adres_bul->adres_kurumsal_getir['vergi_dairesi']}}</p>
																	<p>E-fatura istiyor mu? : 
																		@if($entry->adres_bul->adres_kurumsal_getir['eFatura']==1)
																		Evet
																		@else
																		Hayır
																		@endif
																	</p>
																	@endif
																	@endif 
																	@if(isset($entry->fatura_adres_bul))
																	@if(isset($entry->fatura_adres_id))
																	<h4>Fatura Adresi</h4>
																	<hr>
																	<p>Adı: {{$entry->fatura_adres_bul['isim']}}</p>
																	<p>Ülke: {{$entry->adres_bul->ulke_getir->ulke_kod_getir['ad']}}</p>
																	<p>İl: {{$entry->fatura_adres_bul['il']}}</p>
																	<p>İlce: {{$entry->fatura_adres_bul['ilce']}}</p>
																	<p>Mahalle: {{$entry->fatura_adres_bul['mahalle']}}</p>
																	<p>Adres: {{$entry->fatura_adres_bul['adres']}}</p>
																	<p>Telefon: {{$entry->fatura_adres_bul['telefon']}}</p>
																	<p>Mail: {{$entry->adres_bul['mail']}}</p>
																	@if($entry->fatura_adres_bul['kurumsal_mi'] == 1)
																	<p>Firma Adı: {{$entry->fatura_adres_bul->adres_kurumsal_getir['firma_adi']}}</p>
																	<p>Vergi Numarası: {{$entry->fatura_adres_bul->adres_kurumsal_getir['vergi_numarasi']}}</p>
																	<p>Vergi Dairesi: {{$entry->fatura_adres_bul->adres_kurumsal_getir['vergi_dairesi']}}</p>
																	<p>E-fatura istiyor mu? :
																		@if($entry->fatura_adres_bul->adres_kurumsal_getir['eFatura']==1)
																		Evet
																		@else
																		Hayır
																	@endif</p>
																	@endif
																	@endif
																	@endif 
																</div>
															</div><!-- /.modal-content -->
														</div><!-- /.modal-dialog -->
													</div><!-- /.modal -->
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
																	<form action="{{ route('admin.yorum.sil', $entry->id) }}" method="post">
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