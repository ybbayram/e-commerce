@extends('tanitim.layouts.master')
@section('content')
<!-- breadcrumb start -->
<div class="breadcrumb-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<div class="page-title">
					<h2>Sıkça Sorulan Sorular</h2>
				</div>
			</div>
			<div class="col-sm-6">
				<nav aria-label="breadcrumb" class="theme-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="/">Anasayfa</a></li>
						<li class="breadcrumb-item active" aria-current="page">SSS</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</div>
<!-- breadcrumb end -->


<!--section start-->
<section class="faq-section section-b-space">
	
	<div class="container">
		<div class="row">
			@foreach($sssler as $sss)
			<div class="col-lg-3 mb-4">
				<div class="collection-filter-block">
					<div class="product-service">
						<div class="media d-flex justify-content-center">
							<img width="150px" height="150px" src="{{$sss->sss_dil_getir['icon']}}">
						</div>
						<div class="media">
							<div class="media-body">
								<center>
									<h4>{{$sss->sss_dil_getir['baslik']}}</h4>
									<p>{!!$sss->sss_dil_getir['aciklama']!!}</p>
								</center>
							</div>
						</div>
						<div class="media"> 
							<a href="{{route('sss.detay', $sss->slug)}}" class="btn btn-solid btn-block"> Daha Fazla</a>
						</div>

					</div>
				</div>
			</div>
			@endforeach

		</div>
		<div class="row">
			<div class="col-lg-12 mb-4" align="center">
				<form class="form_search" role="form" action="{{ route('sss.search') }}" method="post">
					@csrf
					<input id="query search-autocomplete" type="search" name="soru_aranan" placeholder="Soru arayınız..." class="nav-search nav-search-field" aria-expanded="true">
					<button type="submit" name="nav-submit-button" class="btn-search">
						<i class="ti-search"></i>
					</button>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="accordion theme-accordion" id="accordionExample">
					@foreach($sssler as $sss)
					@foreach($sss->sss_detay_bul as $detay)
					<div class="card" data-bs-toggle="collapse" data-bs-target="#collapseOne{{$detay->id}}" >
						<div class="card-header" id="headingOne">
							<h5 class="mb-0">
								<button class="btn btn-link" style="text-decoration:none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{$detay->id}}" aria-expanded="true" aria-controls="collapseOne">
									{{$detay->sss_detay_dil_getir['baslik']}}
								</button>
							</h5>
						</div>
						<div id="collapseOne{{$detay->id}}" class="collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
							<div class="card-body">
								<p>{!!$detay->sss_detay_dil_getir['aciklama']!!}
								</p>
							</div>
						</div>
					</div>
					@endforeach
					@endforeach
				</div>
			</div>
		</div>
	</div>
</section>
<!--Section ends-->


@endsection