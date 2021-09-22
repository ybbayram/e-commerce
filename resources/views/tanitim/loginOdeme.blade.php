@extends('tanitim.layouts.master')
@section('css') 
<link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/pages/login-register.css') }}"> 
@endsection
@section('js')
<script type="text/javascript" src="{{ asset('/assets/js/ek-js/login.js') }}"></script>
@endsection
@section('content')
<!-- breadcrumb start -->
<div class="breadcrumb-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<div class="page-title">
					<h2>Alışverişe Devam Et</h2>
				</div>
			</div>
			<div class="col-sm-6">
				<nav aria-label="breadcrumb" class="theme-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="/">Anasayfa</a></li>
						<li class="breadcrumb-item active" aria-current="page">Giriş</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</div>
<!-- breadcrumb end -->
<!--section start-->
<section class="login-page section-b-space">
	<div class="container">
		<div class="row">

			<div id="login-form" class="login-page">
				<div class="form-box">
					<div class="button-box">
						<div id="btn"></div>
						<button type="button" onclick='login()' class="toggle-btn" >Giriş Yap</button>
						<button type="button" onclick='register()' class="toggle-btn">Kayıt ol</button>
					</div>

					<!--Login form-->

					<form action="{{ route('login') }}" method="post" id="login" class="input-group-login">
						@csrf
						<input type="text" class="input-field" placeholder="E-mail" name="email" required>
						<input type="password" class="input-field" placeholder="Şifre" name="password"  required>
						
						<button type="submit" class="submit-btn" name="submit2">Giriş Yap</button>
						<a href="{{route('odeme')}}"  class="submit-btn" style="color:white; background-color: #072448;" name="submit1">Giriş Yapmadan Devam Et</a>
						@if(isset($mesaj))
						<p style="color:red;">{{$mesaj}}</p>
						@endif
					</form>
					<!--Login form end-->

					<!--Register form-->
					<form  action="{{ route('register') }}" method="post" id="register" class="input-group-register">
						@csrf
						<input type="text" class="input-field" placeholder="Ad Soyad" name="first_name" required> 
						<input type="email" class="input-field" placeholder="Email" name="email" required>
						<input type="password" class="input-field" placeholder="Şifre" name="password" required> 
						<input type="password" class="input-field" placeholder="Şifre Tekrar" name="password_confirmation" required> 

						<div class="col-12 form-check mt-2" style="width:auto !important;">
							<input type="checkbox" value="1" name="kvkk" id="kvkk">
							<label for="kvkk" style="margin-left: 10px; font-size: 12px;">Kampanyalardan haberdar olmak için tarafıma elektronik ileti gönderilmesini kabul ediyorum.</label>
						</div>
						<button type="submit" class="submit-btn" name="submit">Kayıt Ol</button>
						<a href="{{route('odeme')}}" class="submit-btn"style="color:white; background-color: #072448;" name="submit1">Giriş Yapmadan Devam Et</a>

					</form>
					<!--Register form end -->

				</div>
			</div>
		</div>
	</div>
</section>
<!--Section ends-->


@endsection