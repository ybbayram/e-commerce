@extends('tanitim.layouts.master')
@section('css')<link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/pages/login-register.css') }}"> 
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
                    <h2>PetHepsi'nin Fırsatlarla Dolu Dünyasına Katılın</h2>
                </div>
            </div>
            <div class="col-sm-6">
                <nav aria-label="breadcrumb" class="theme-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Anasayfa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Şifre Yenileme</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb end -->
@include('tanitim.layouts.partials.alert')
@include('tanitim.layouts.partials.errors')
<!--section start-->
<section class="login-page section-b-space">
    <div class="container">
        <div class="row">
        <div class="col-lg-6">
        <form action="{{ route('sifreYenilemePost') }}" method="post">
            @csrf
              <div class="form-group">
                <label for="exampleInputEmail1">Yeni Şifre</label>
                <input type="password" name="password_confirmation" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Şifre Giriniz">
                <label for="exampleInputEmail1">Yeni Şifre Tekrar</label>
                <input type="password" name="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Şifre Tekrar Giriniz">
                <input type="hidden" name="token" value="{{ $token }}">
              </div>
              <button type="submit" class="btn btn-solid mb-2">Kaydet</button>
        </form>
        </div>


        </div>
    </div>
</section>
<!--Section ends-->


@endsection