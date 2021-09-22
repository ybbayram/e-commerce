@extends('tanitim.layouts.master')
@section('js')
<script type="text/javascript" src="{{ asset('/assets/js/ek-js/register.js') }}"></script>
@endsection
@section('content')
<!--section start-->
<section class="register-page section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>Kayıt Ol</h3>
                <div class="theme-card">
                    <form class="form-group" action="{{ route('register') }}" method="post">
                        @csrf
                        <div class="form-row row">
                            <div class="col-md-6 mb-4">
                                <label for="email">Ad Soyad</label>
                                <input type="text" class="form-control" id="fname" name="ad" placeholder="Ad Soyad" required="">
                                <span class="error"></span>

                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email" required="">
                                <span class="error"></span>

                            </div>
                        </div>
                        <div class="form-row row ">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Şifre</label>
                                    <div class="input-group" id="show_hide_password">
                                        <input class="form-control" name="password" type="password" placeholder="Şifre Giriniz">
                                        <span class="error"></span>
                                        <div class="input-group-text">
                                            <a href="javascript::void(0)" style="color: black;"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Şifre Tekrar</label>
                                    <div class="input-group" id="show_hide_password2">
                                        <input class="form-control" name="password_confirmation" type="password" placeholder="Şifre Tekrar Giriniz">
                                        <span class="error"></span>

                                        <div class="input-group-text">
                                            <a href="javascript::void(0)" style="color: black;"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-2">

                                    <div class="col-4  form-check mt-2" style="width:auto !important;">
                                        <input type="checkbox" required name="kabul" id="adda">
                                    </div>
                                    <div class="col-8" style="margin-top:6px;">
                                        <label for="adda">
                                            @foreach($sozlesme as $entry)
                                            <a target="_blank" href="{{route('sozlesmeler', $entry->slug)}}">
                                                {{$entry->sozlesme_dil_getir['baslik']}}@if($sozlesme->last() !== $entry), @endif
                                            </a>
                                            @endforeach okudum ve kabul ediyorum.</label>
                                    </div>
                                
                            </div>
                            <div class="row">
                                
                                    <div class="col-4 form-check mt-2" style="width:auto !important;">
                                        <input type="checkbox" value="1" name="kvkk" id="kvkk">
                                    </div>
                                    <div class="col-8" style="margin-top:6px;">
                                        <label for="kvkk" style="margin-left: 10px;">Kampanyalardan haberdar olmak için tarafıma elektronik ileti gönderilmesini kabul ediyorum.</label>
                                    </div>
                                </div>
                            
                            <div class="col-6">
                                <button type="submit" class="btn btn-solid w-auto">Kayıt Ol</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Section ends-->


@endsection