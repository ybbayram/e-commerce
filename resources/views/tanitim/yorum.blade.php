@extends('tanitim.layouts.master')
@section('content')
<!-- breadcrumb start -->
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="page-title">
                    <h2>Yorumlar/{{$urun->detay_bul['ad']}}</h2>
                </div>
            </div>
            <div class="col-sm-6">
                <nav aria-label="breadcrumb" class="theme-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Anasayfa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Yorumlar</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb End -->


<!-- section start -->
<section class="section-b-space blog-detail-page review-page">
    <div class="container">

        <div class="row">
            <div class="col-lg-5  col-sm-12">
                <div class="theme-card">
                    <div class="offer-slider slide-1">
                        <div>
                            <div class="media" style="margin-top:-60px;">
                                <a href="{{ route('urun', $urun->slug) }}"><img class="img-fluid blur-up lazyload" style="height: 300px;" src="{{ $urun->gorsel_bul['gorsel'] }}" alt=""></a>
                                <div class="media-body align-self-center">
                                    <a href="{{ route('urun', $urun->slug) }}">
                                        <h6>{{$urun->detay_bul['ad']}}</h6>
                                        <p>{!!$urun->detay_bul['aciklama_bir']!!}</p>
                                    </a>
                                    <div class="rating-section">
                                        @php
                                        $dolu = round($urun->urun_analiz_bul['ortalama_puan']);
                                        $a = $dolu;
                                        $b = 5 - $a ;
                                        @endphp
                                        @for($i=0; $i < $a ; $i++) <i class="fa fa-star yildiz checked-yildiz"></i>
                                            @endfor
                                            @for($i=0; $i < $b ; $i++) <i class="fa fa-star yildiz-two "></i>
                                                @endfor
                                    </div>
                                    <h4>
                                        @if($urun->cesit_durum == 1)
                                        @if($urun->stok == 0)
                                        <span class="product-sale-label">Stokta Yok</span>
                                        @else
                                        {{ $urun->fiyat_bul['fiyat']}} <del> {{ $urun->fiyat_bul['fiyat_onceki'] }}</del>
                                        @endif
                                        @else
                                        <a href="{{ route('urun', $urun->slug) }}" class="btn btn-solid btn-xs mt-2">Çeşitleri Gör</a>
                                        @endif
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 col-sm-12">
                @foreach($yorumlar as $yorum)
                <ul class="comment-section mb-4">
                    <li>
                        <div class="media">
                            <img src="../assets/images/2.jpg" alt="Generic placeholder image">
                            <div class="media-body">
                                <h6>{{ $yorum->kullanici_bul['ad'] }} <span>( {{ $yorum->created_at }} )</span></h6>
                                <p>{!!$yorum->yorum!!}</p>

                            </div>
                        </div>
                    </li>

                </ul>
                @endforeach
            </div>

        </div>

    </div>
</section>
<!-- Section ends -->
@endsection