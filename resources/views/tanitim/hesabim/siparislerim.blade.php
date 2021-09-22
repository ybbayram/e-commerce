@extends('tanitim.layouts.master')
@section('content')
@include('admin.layouts.partials.alert')
@include('admin.layouts.partials.errors')
<!-- breadcrumb start -->
<div class="breadcrumb-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<div class="page-title">
					<h2>Hesabım</h2>
				</div>
			</div>
			<div class="col-sm-6">
				<nav aria-label="breadcrumb" class="theme-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item active">Hoşgeldiniz</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</div>
<!-- breadcrumb End -->
<!--  dashboard section start -->
<section class="dashboard-section section-b-space">
	<div class="container">
		<div class="row">
			@include('tanitim.hesabim.hesabimNavbar')
			<div class="col-lg-9 my_orders">
				<div class="faq-content tab-content" id="top-tabContent" style="overflow-x: scroll;">
					<div class="tab-pane fade show active" id="orders">
						<div class="row">
							<div class="col-12">
								<div class="card dashboard-table mt-0">
									<div class="card-body">
										<div class="top-sec">
											<h3>Siparişlerim</h3>
										</div>
										<table class="table table-responsive-sm mb-0">
											<thead>
												<tr>
													<th scope="col">Sipariş Id</th>  
													<th scope="col">Ücret</th>
													<th scope="col">Kargo Takip Kodu</th>
													<th scope="col">Durum</th>
													<th scope="col">İade</th>
													<th scope="col">Detay</th>
												</tr>
											</thead>
											<tbody>
												@for($i=0; $i < $say ; $i++)
												@foreach($siparislerim[$i] as $entry)
												@if(isset($entry))
												<tr>
													<th scope="row">#{{ $entry->id }}</th> 
													<td>{{ $entry->odeme_getir['toplam'] }}</td>
													@if($entry->islem_durum == 3)
													<td>{{$entry->kargo_kod}}</td>
													@else
													<td></td>
													@endif
													<td> 

														@if(!isset($entry->siparis_iade_getir->onaylanmis_iade_getir))
														@if($entry->islem_durum == $entry->durum_getir['durum_id'])
														<a href="javascript::void(0)" style="color:blue;">{{$entry->durum_getir['durum']}}</a>
														@endif
														@endif
													</td>
													<td> 
														@if(isset($entry->siparis_iade_getir))
														@if(isset($entry->siparis_iade_getir->onaylanmis_iade_getir))
														@if($entry->siparis_iade_getir->onaylanmis_iade_getir['durum'] == 0)
														@if($entry->siparis_iade_getir['durum'] == 0)
														<a href="javascript::void(0)" class="btn btn-danger btn-sm">İnceleniyor</a>
														<a href="{{route('iade.iptal', $entry->siparis_iade_getir['id'])}}" class="btn btn-warning btn-sm">İptal</a>
														@endif
														@if($entry->siparis_iade_getir['durum'] == 1)
														<a href="javascript::void(0)" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModall">Kontrol Ediliyor</a>
														@endif
														@if($entry->siparis_iade_getir['durum'] == 2)
														<a href="javascript::void(0)" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModall">İade Onaylanmadı</a>
														@endif
														@endif 
														@if($entry->siparis_iade_getir->onaylanmis_iade_getir['durum'] == 1)
														<a href="javascript::void(0)" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModall">Onaylandı</a> 
														<a href="javascript::void(0)"class="btn btn-warning btn-sm">{{$entry->siparis_iade_getir->iade_kod['kargo_kod']}}</a>
														@endif
														@else
														@if($entry->siparis_iade_getir['durum'] == 0)
														<a href="javascript::void(0)" class="btn btn-danger btn-sm">İnceleniyor</a>
														<a href="{{route('iade.iptal', $entry->siparis_iade_getir['id'])}}" class="btn btn-warning btn-sm">İptal</a>
														@endif
														@if($entry->siparis_iade_getir['durum'] == 1)
														<a href="javascript::void(0)" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModall">Kontrol Ediliyor</a>
														@endif
														@if($entry->siparis_iade_getir['durum'] == 2)
														<a href="javascript::void(0)" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModall">İade Onaylanmadı</a>
														@endif
														@endif
														@else
														<a href="javascript::void(0)" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModall{{$entry->id}}">İade Et</a>
														@endif
														
													</td>
													<td> 
														<a href=""   data-bs-toggle="modal" data-bs-target="#exampleModallUrun{{$entry->id}}" class="btn btn-primary btn-sm">Detay</a>
													</td>
												</tr>
												<div class="modal fade" id="exampleModallUrun{{$entry->id}}" tabindex="-1" aria-labelledby="exampleModalLabell" aria-hidden="true">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="exampleModalLabel">Ürün Detayları</h5>
																<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
															</div>

															<div class="modal-body"> 
																@foreach($entry->sepet_urun_getir as $detay) 
																<img style="width:350px;" class="mb-3" src="{{$detay->sepeturun_urun_getir->gorsel_bul['gorsel']}}"> 
																<p><b>Ürun Adı : </b>{{$detay->sepeturun_urun_getir->detay_bul['ad']}}</p>
																<p><b>Adet : </b>{{$detay['adet']}}</p>
																<p><b>Fiyat : </b>{{$detay['fiyati']}}</p>
																<hr>
																@endforeach
																<p><b>Kargo Ücreti : </b>{{$entry->odeme_getir['kargoFiyat']}}</p>

															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-secondary  btn-sm btn-solid" data-bs-dismiss="modal">Kapat</button>
															</div>

														</div>
													</div>
												</div>
												<div class="modal fade" id="exampleModall{{$entry->id}}" tabindex="-1" aria-labelledby="exampleModalLabell" aria-hidden="true">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="exampleModalLabel">İade Oluşturunuz</h5>
																<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
															</div>

															<form class="theme-form" action="{{ route('iade', ['siparis_id'=>$entry->id, 'user_id' => Auth::id()])}}" method="post" enctype="multipart/form-data">
																@csrf
																<div class="modal-body">
																	<div class="form-row row">
																		<div class="col-md-12 mb-3">
																			<div class="col-md-12 mb-3">
																				<label for="name">İade Sebebi</label>
																				<select class="form-select" name="talep" required="true">
																					<option value="">Sebep Seçiniz</option>
																					@foreach($iadeSorular as $soru)
																					@if(isset($soru->iade_dil_getir))
																					<option value="{{$soru->iade_dil_getir['id']}}">{{$soru->iade_dil_getir['aciklama']}}</option>
																					@endif
																					@endforeach
																					<option value="0">Diğer</option>
																				</select>
																			</div>
																		</div>
																		<div class="col-md-12 mb-3">
																			<label for="name">Açıklama</label>
																			<textarea class="form-control" name="aciklama"></textarea>
																		</div>

																		<div class="col-md-12 mb-3">
																			<label for="name">Görsel</label>
																			<input type="file" class="form-control" name="gorsel">
																		</div>
																		<div class="col-md-12 mb-3">
																			<label for="name">Gorsel 2</label>
																			<input type="file" class="form-control" name="gorsel2">
																		</div>
																		<div class="col-md-12">
																		</div>
																	</div>
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-secondary  btn-sm btn-solid" data-bs-dismiss="modal">Kapat</button>
																	<button class="btn btn-sm btn-solid" type="submit">Kaydet</button>
																</div>

															</form>
														</div>
													</div>
												</div>
												@endif
												@endforeach
												@endfor
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
</section>
<!--  dashboard section end -->

@endsection