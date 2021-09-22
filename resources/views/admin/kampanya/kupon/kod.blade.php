@extends('admin.layouts.master')
@section('title', 'Kupon Kod')
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
							<a href="{{ route('admin.kupon') }}"><span class="btn btn-purple btn btn-xl inputTwo" style="margin-bottom: 20px"><span class="dripicons-arrow-thin-left"> Önceki Sayfa</span></span></a>
							<a href="{{ route('admin.kupon.hepsiniAc', $kupon->id) }}"><span class="btn btn-success btn btn-xl inputTwo" style="margin-bottom: 20px"> Hepsini Aç</span></a>
							<a href="{{ route('admin.kupon.hepsiniKapat', $kupon->id) }}"><span class="btn btn-danger btn btn-xl inputTwo" style="margin-bottom: 20px"> Hepsini Kapat</span></a>
							<span class="float-right text-muted font-size-13"></span>
							<h5 class="card-title mb-3">Kodlar</h5>
							<p class="card-title-desc">
								Kodlara bu sayfadan ulaşabilirsiniz.
							</p>
							<div id="donut-example" class="morris-charts workloed-chart"
							dir="ltr">
							@include('admin.layouts.partials.alert')
							@include('admin.layouts.partials.errors')
							<div class="card-body">

								<div class="table-responsive">
									<table class="table" style="margin-bottom: 60px;">
										<thead>
											<tr>
												<th>Adı</th>
												<th>Adedi</th>
												<th>Minimum Tutar</th>
												<th>İndirim Tutarı</th>
												<th>Başlangıç Tarihi</th>
												<th>Bitiş Tarihi</th>
												<th>Oluşturma Tarihi</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>{{$kupon->ad}}</td>
												<td>{{$kupon->adet}}</td>
												<td>{{$kupon->min}}</td>
												<td>{{$kupon->indirim_tutarı}}</td>
												<td>{{$kupon->baslangic_tarihi}}</td>
												<td>{{$kupon->bitis_tarihi}}</td>
												<td>{{$kupon['created_at']}}</td>
											</tr>
										</tbody>
									</table>
									<table id="datatable-buttons" class="table table-striped table-bordered w-100">
										<thead>
											<tr>
												<th>Kod</th>
												<th>Kullanım Durumu</th> 
												
											</tr>
										</thead>
										<tbody>
											@foreach($kodlar as $entry)
											<tr>
												<td>{{$entry->kod}}</td>
												<td>
													@if($entry->kullanim_durumu == 0)
													<a href="{{ route('admin.kupon.kullanimAktifYap', $entry->id) }}" class="btn btn-success waves-effect waves-light">Kullanılmamış</a>
													@else
													<a href="{{ route('admin.kupon.kullanimPasifYap', $entry->id) }}" class="btn btn-danger waves-effect waves-light">Kullanılmış</a>
													@endif
												</td>
												
												@endforeach
											</tr>

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
