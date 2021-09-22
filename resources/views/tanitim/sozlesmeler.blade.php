@extends('tanitim.layouts.master') 
@section('content')
<!-- breadcrumb start -->
<div class="breadcrumb-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<div class="page-title">
					<h2>{{$sozlesme->sozlesme_dil_getir['baslik']}}</h2>
				</div>
			</div>
			<div class="col-sm-6">
				<nav aria-label="breadcrumb" class="theme-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="/">Anasayfa</a></li>
						<li class="breadcrumb-item active" aria-current="page">{{$sozlesme->sozlesme_dil_getir['baslik']}}</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</div>
<!-- breadcrumb end -->


<!-- about section start -->
<section class="about-page section-b-space">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h4  style="text-transform: none !important;" class="mb-4">{{$sozlesme->sozlesme_dil_getir['baslik']}}
				</h4> 
				<p>{!!$sozlesme->sozlesme_dil_getir['aciklama']!!}</p>
				<p class="mt-4"><b>Son Güncelleme Tarihi: {!!$sozlesme->sozlesme_dil_getir['created_at']!!}</b></p>
			</div>
		</div>
	</section>
	<!-- about section end -->

	@endsection