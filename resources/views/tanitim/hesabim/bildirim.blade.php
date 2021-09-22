@extends('tanitim.layouts.master')
@section('js')
<script type="text/javascript" src="{{ asset('/assets/js/ek-js/sifreDegistir.js') }}"></script>

@endsection
@section('content')
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

@include('tanitim.layouts.partials.alert')
@include('tanitim.layouts.partials.errors')
<!-- section start -->
<section class="section-b-space">
    <div class="container">
        <div class="row">
        @include('tanitim.hesabim.hesabimNavbar')
            <div class="col-lg-9 my_notifications">
                <div class="dashboard-right ">
                    <div class="row">
                        <form class="form-group" action="{{route('hesabim.bildirimler')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-12 mb-4">
                                    <div class=" form-check mt-1">
                                        <input class="mt-1" type="checkbox" value="1" name="kvkk" id="kvkk" @if(Auth::user()->kvkk == 1) checked @endif style="float: left; width: 50px;">

                                        <label for="kvkk" style="margin-left: 5px;">Kampanyalardan haberdar olmak için tarafıma elektronik ileti gönderilmesini kabul ediyorum.</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <button class="btn btn-solid ">Güncelle</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</section>
<!-- section end -->
@endsection