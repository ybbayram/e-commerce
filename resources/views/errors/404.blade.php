@extends('tanitim.layouts.master')
@section('content')
@section('title', '404 Sayfa Bulunamadı')
<!-- breadcrumb start -->
<div class="breadcrumb-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<div class="page-title">
					<h2>404</h2>
				</div>
			</div>
			<div class="col-sm-6">
				<nav aria-label="breadcrumb" class="theme-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="/">Anasayfa</a></li>
						<li class="breadcrumb-item active" aria-current="page">404</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</div>
<!-- breadcrumb end -->

<!-- section start -->
<section class="p-0">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="error-section">
					<h1>404</h1>
					<h2>Sayfa Bulunamadı</h2>
					<a href="/" class="btn btn-solid">Anasayfaya geri dön</a>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Section ends -->


@endsection