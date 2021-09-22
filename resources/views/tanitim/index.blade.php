@extends('tanitim.layouts.master')
@section('css')
<style type="text/css">
@media screen and (max-width: 999px){
    .slider-desktop{
        display:none;
    }
    .slider-tablet{
        display:none;
    }
} 
@media screen and (min-width: 1000px) and (max-width: 1200px) {
    .slider-desktop{
        display:none;
    }
    .slider-mobil{
        display:none;
    }
} 
@media screen and (min-width: 1201px){
    .slider-mobil{
        display:none;
    }
    .slider-tablet{
        display:none;
    }
} 
</style>
@endsection 
@section('content')

<!-- loader start -->
<div class="loader_skeleton">
    <header class="header-style-5 color-style">
        <div class="top-header top-header-theme">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="header-contact">
                            <ul>
                             @if(isset($iletisim))
                             <li><i class="fa fa-envelope-o" aria-hidden="true"></i>{{$iletisim->mail}}</li>
                             <li><i class="fa fa-phone" aria-hidden="true"></i>{{$iletisim->telefon}}</li>
                             @endif
                         </ul>
                     </div>
                 </div>
                 <div class="col-lg-6">
                    <div class="header-contact text-end">
                        <ul>
                            @auth
                            <li><i class="fa fa-truck" aria-hidden="true"></i> Kargo Takip</li>
                            <li><i class="fa fa-gift" aria-hidden="true"></i> Siparişlerim</li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="main-menu">
                    <div class="menu-left">

                        <a href="/">
                            <img src="/assets/images/logo1.png"
                            class="img-fluid blur-up lazyload logo-mobil" alt="">
                        </a>
                    </div>
                    <div>
                        <form class="form_search ajax-search the-basics" role="form">
                            <input type="search" placeholder="Ürün arayınız..." class="nav-search nav-search-field typeahead" aria-expanded="true">
                            <button type="submit" name="nav-submit-button" class="btn-search">
                                <i class="ti-search"></i>
                            </button>
                        </form>
                    </div>
                    <div class="menu-right pull-right">
                        <nav class="text-start">
                            <div class="toggle-nav"><i class="fa fa-bars sidebar-bar"></i></div>
                        </nav>
                        <div class="top-header d-block">
                            <ul class="header-dropdown">
                                <div class="icon-nav">
                                    <li class="onhover-dropdown mobile-account">
                                        <a href="{{ route('hesabim.panel') }}">
                                            <img style="width: 25px;" src="/assets/images/icon/user-1.png" alt="">
                                        </a>
                                    </li>
                                </div>
                                <li class="mobile-wishlist">
                                    <a href="{{ route('favori') }}">
                                        <img style="width: 25px;" src="/assets/images/icon/heart-1.png" alt="">
                                    </a>
                                </li>

                            </ul>
                        </div>
                        <div>
                            <div class="icon-nav d-none d-sm-block">
                                <ul>
                                    <li class="onhover-div d-xl-none d-inline-block mobile-search">
                                        <div>
                                            <img style="width: 25px;" src="/assets/images/icon/search.png"  class="img-fluid blur-up lazyload" alt=""> 
                                            <i class="ti-search"></i>
                                        </div>
                                    </li>
                                    <li class="onhover-div mobile-setting">
                                        <div>
                                            <img style="width: 25px;" src="/assets/images/icon/setting.png" class="img-fluid blur-up lazyload" alt=""> 
                                            <i class="ti-settings"></i>
                                        </div>
                                    </li>
                                    <li class="onhover-div mobile-cart">
                                        <div>
                                            <img style="width: 25px;" src="/assets/images/icon/cart.png" class="img-fluid blur-up lazyload" alt=""> 
                                            <i class="ti-shopping-cart"></i>
                                        </div>
                                        <span class="cart_qty_cls">0</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-part">
        <div class="container">
            <div class="row">
               <div class="col-xl-3">
                <a href="/">
                    <div class="category-menu d-none d-xl-block h-100">
                        <div id="toggle-sidebar" class="toggle-sidebar"> 
                            <h5 class="mb-0">Anasayfa</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xxl-6 col-xl-9">
                <div class="main-nav-center">
                    <nav class="text-start">
                        <!-- Sample menu definition -->
                        <ul class="sm pixelstrap sm-horizontal">
                            <li>
                                <div class="mobile-back text-end">Kapat<i class="fa fa-angle-right ps-2"
                                    aria-hidden="true"></i>
                                </div>
                            </li> 
                            @foreach($kategoriler as $kategori)
                            @isset($kategori)
                            <li class="mega">
                              <a href="{{ route('shop.kategori', $kategori->slug) }}" onclick="{{ route('shop.kategori', $kategori->id) }}">{{ $kategori->kategori_dil_getir['ad'] }}</a> 
                          </li>
                          @endisset
                          @endforeach
                      </ul>
                  </nav>
              </div>
          </div>
      </div>
  </div>
</div>
</header>
<section class="pt-0 height-65">
    <div class="home-slider">
        <div class="home"></div>
    </div>
</section>
<section class="container category-ldr">
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="category-block col-2">
                    <a href="#">
                        <div class="category-image svg-image">
                        </div>
                    </a>
                </div>
                <div class="category-block col-2">
                    <a href="#">
                        <div class="category-image svg-image">
                        </div>
                    </a>
                </div>
                <div class="category-block col-2">
                    <a href="#">
                        <div class="category-image svg-image">
                        </div>
                    </a>
                </div>
                <div class="category-block col-2 d-none d-md-block">
                    <a href="#">
                        <div class="category-image svg-image">
                        </div>
                    </a>
                </div>
                <div class="category-block col-2 d-none d-lg-block">
                    <a href="#">
                        <div class="category-image svg-image">
                        </div>
                    </a>
                </div>
                <div class="category-block col-2 d-none d-xl-block">
                    <a href="#">
                        <div class="category-image svg-image">
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="product-para">
                    <p class="first"></p>
                    <p class="second"></p>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
<!-- loader end -->
<!-- Home slider -->
<section class="p-0 small-slider slider-desktop">
    <div class="slide-1 home-slider">
        @foreach($slider as $slid)
        <div>
            <div class="home ">
                <img src="{{$slid->slider_dil_getir['gorsel']}}"  alt="" class="bg-img blur-up lazyload">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="slider-contain">
                                <div>
                                    <h4>{{$slid->slider_dil_getir['baslik']}}</h4>
                                    <h1>{{$slid->slider_dil_getir['detay']}}</h1>
                                    @if($slid->slider_dil_getir['buton_baslik'] == " ")
                                    <a href="{{$slid->slider_dil_getir['buton_link']}}" target="_blank" class="btn btn-solid">{{$slid->slider_dil_getir['buton_baslik']}}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<section class="p-0 small-slider slider-mobil">
    <div class="slide-1 home-slider">
        @foreach($slider as $slid)
        <div>
            <div class="home ">
                <img src="{{$slid->slider_dil_getir['gorsel_mobil']}}"  alt="" class="bg-img blur-up lazyload">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="slider-contain">
                                <div>
                                    <h4>{{$slid->slider_dil_getir['baslik']}}</h4>
                                    <h1>{{$slid->slider_dil_getir['detay']}}</h1>
                                    @if($slid->slider_dil_getir['buton_baslik'] == " ")
                                    <a href="{{$slid->slider_dil_getir['buton_link']}}" target="_blank" class="btn btn-solid">{{$slid->slider_dil_getir['buton_baslik']}}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<section class="p-0 small-slider slider-tablet">
    <div class="slide-1 home-slider">
        @foreach($slider as $slid)
        <div>
            <div class="home ">
                <img src="{{$slid->slider_dil_getir['gorsel_3']}}"  alt="" class="bg-img blur-up lazyload">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="slider-contain">
                                <div>
                                    <h4>{{$slid->slider_dil_getir['baslik']}}</h4>
                                    <h1>{{$slid->slider_dil_getir['detay']}}</h1>
                                    @if($slid->slider_dil_getir['buton_baslik'] == " ")
                                    <a href="{{$slid->slider_dil_getir['buton_link']}}" target="_blank" class="btn btn-solid">{{$slid->slider_dil_getir['buton_baslik']}}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
<!-- Home slider end -->


<!-- logo section -->
<section class="mb-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="title1 title5">
                    <h4>Popüler Markalar</h4>
                    <hr role="tournament6">
                </div>
                <div class="slide-6 no-arrow">
                    @foreach($markalar as $marka) 
                    @if(isset($marka->logo))
                    <div>
                        <div class="logo-block">
                            <a href="{{ route('shop.marka', $marka['slug']) }}">
                                <img src="{{$marka->logo}}" alt="">
                            </a>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- logo section end -->


<!-- Banner section -->
<section class="pt-0 banner-6 ratio2_1">
    <div class="container">
        <div class="row partition3">
            @php 
            $i = 0;
            @endphp
            @foreach($banner as $ban)
            @php $i++; @endphp
            <div class="col-md-4 mb-3">
                <a href="{{ $ban->banner_dil_getir['buton_link'] }}">
                    <div class="collection-banner p-left">
                        <div class="img-part">
                            <img src="{{$ban->banner_dil_getir['gorsel']}}" class="img-fluid blur-up lazyload bg-img" alt="">
                        </div>
                        <div class="contain-banner banner-3">
                            <div>
                                <h2>{{$ban->banner_dil_getir['baslik']}}</h2>
                            </div>
                        </div>
                    </div>
                </a>
            </div> 
            @endforeach

        </div>

    </div>
</section>
<!-- banner section End -->


<!-- Product slider -->
<section class="section-b-space j-box pets-box ratio_square">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="title1 title5">
                    @if(isset($oneCikar))
                    <h4>{{$oneCikar->baslik_alt}}<h4>
                        <h2 class="title-inner1">{{$oneCikar->baslik}}</h2>
                        <hr role="tournament6">
                    </div>
                    <div class="product-4 product-m no-arrow"> 
                        @foreach($oneCikanUrun as $entry)
                        <div class="product-box">
                            <div class="img-wrapper">
                                <div class="lable-block">
                                    <span class="lable3">yeni </span> 
                                </div>
                                <!-- front image -->
                                <div class="front">
                                    <a href="{{ route('urun', $entry->urun_getir['slug']) }}">
                                        <img src="{{ $entry->urun_getir->gorsel_bul['gorsel'] }}" class="img-fluid blur-up lazyload bg-img" alt="">
                                    </a>
                                </div>
                                <div class="cart-info cart-wrap">
                                    @if($entry->urun_getir['stok'] > 0)
                                    @if($entry->urun_getir['cesit_durum'] == 1)
                                    <a  href="javascript:void(0)" onclick="sepet({{$entry->urun_getir['id']}});" title="Sepete Ekle">
                                        <i class="ti-shopping-cart"></i>
                                    </a>
                                    @endif
                                    @endif
                                    <a  href="javascript:void(0)" id="favKaldir{{$entry->urun_getir['id']}}" onclick="favori({{$entry->urun_getir['id']}},@if(isset($entry->urun_getir->urun_favori['urun_id'])){{$entry->urun_getir->urun_favori['id']}}@endif)" @if(isset($entry->urun_getir->urun_favori['urun_id'])) style="display: block;" @else style="display: none;" @endif title="Favorilerden Kaldır">
                                        <i id="fav{{$entry->urun_getir['id']}}" class="fa fa-heart" style="color:#ff7f50;"aria-hidden="true"></i>
                                    </a>    
                                    <a @guest data-bs-toggle="modal" data-bs-target="#addtofavori" @endguest @auth href="javascript:void(0)" id="favEkle{{$entry->urun_getir['id']}}" onclick="favori({{$entry->urun_getir['id']}},@if(isset($entry->urun_getir->urun_favori['urun_id'])){{$entry->urun_getir->urun_favori['id']}}@endif)" @if(isset($entry->urun_getir->urun_favori['urun_id'])) style="display: none;" @else style="display: block;" @endif @endauth   title="Favorilere ekle">
                                       <i  id="fav{{$entry->urun_getir['id']}}" class="ti-heart" aria-hidden="true"></i>
                                   </a>    
                                   @if($entry->urun_getir['cesit_durum'] == 0)
                                   <a href="{{ route('urun', $entry->urun_getir['slug']) }}"  title="Çeşitleri Gör">
                                    <i class="ti-eye" aria-hidden="true"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                        <div class="product-detail">
                            <div class="rating-section">
                                @php
                                $dolu = round($entry->urun_getir->urun_analiz_bul['ortalama_puan']);
                                $a =  $dolu;
                                $b = 5 - $a ; 
                                @endphp
                                @for($i=0; $i < $a ; $i++)
                                <i class="fa fa-star yildiz checked-yildiz" ></i>
                                @endfor
                                @for($i=0; $i < $b ; $i++)
                                <i class="fa fa-star yildiz-two "></i>
                                @endfor
                            </div>
                            <a href="{{ route('urun', $entry->urun_getir['slug']) }}">
                                <h6>{{ $entry->urun_getir->detay_bul['ad'] }}</h6>
                            </a>
                            <h4>
                             @if($entry->urun_getir['cesit_durum'] == 1)
                             @if($entry->urun_getir['stok'] == 0)
                             <span class="product-sale-label">Stokta Yok</span>
                             @else
                             {{ $entry->urun_getir->fiyat_bul['fiyat']}} {{ $paraSimge }}  <del> {{ $entry->urun_getir->fiyat_bul['fiyat_onceki'] }} {{ $paraSimge }} </del> 
                             @endif
                             @else
                             <a href="{{ route('urun', $entry->urun_getir['slug']) }}" class="btn btn-solid btn-xs mt-2"  >Çeşitleri Gör</a>
                             @endif
                         </h4>

                     </div>
                 </div>


                 @endforeach

             </div>
             @endif

         </div>
     </div>
 </div>
</section>
<!-- Product slider end -->

<!-- Parallax banner -->
<section class="p-0 pet-parallax">
    <div class="full-banner parallax  text-center p-center">
        <img src="@if(isset($banner2)){{$banner2['gorsel']}}@endif" alt="" class="bg-img blur-up lazyload">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="banner-contain">
                        <h4 style="color:#ff7f50">@if(isset($banner2)){{$banner2['baslik']}}@endif</h4>
                        <h3 style="color:#ff7f50" >@if(isset($banner2)){{$banner2['baslik_alt']}}@endif</h3>
                        <p style="color:#ff7f50">@if(isset($banner2)){{$banner2['detay']}} @endif</p>
                        @if(isset($banner2))
                        @if($banner2['buton_isim'] != "")
                        <a href="{{$banner2['buton_link']}} " class="btn btn-solid black-btn" tabindex="0">{{$banner2['buton_isim']}} </a>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="pet-decor">
            <img src="@if(isset($banner2)){{$banner2['gorsel2']}}@endif" alt="" class="img-fluid blur-up lazyload">
        </div>
    </div>
</section>
<!-- Parallax banner end -->


<!-- product end -->
<section class="section-b-space j-box pets-box ratio_square">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="title1 title5">
                    <h2 class="title-inner1">sizin için</h2>
                    <hr role="tournament6">
                </div>
                <div class="product-4 product-m no-arrow">

                    @foreach($yeni as $entry)

                    <div class="product-box">
                        <div class="img-wrapper">
                            <div class="lable-block">
                                <span class="lable3">yeni</span>
                            </div>
                            <!-- front image -->
                            <div class="front">
                                <a href="{{ route('urun', $entry->slug) }}">
                                    <img src="{{ asset($entry->gorsel_bul['gorsel']) }}" class="img-fluid blur-up lazyload bg-img" alt="">
                                </a>
                            </div>
                            <div class="cart-info cart-wrap">
                                @if($entry->stok > 0)
                                @if($entry->cesit_durum == 1)
                                <a  href="javascript:void(0)" onclick="sepet({{$entry['id']}});" title="Sepete Ekle">
                                    <i class="ti-shopping-cart"></i>
                                </a>
                                @endif
                                @endif

                                <a  href="javascript:void(0)" id="favKaldir{{$entry['id']}}" onclick="favori({{$entry['id']}},@if(isset($entry->urun_favori['urun_id'])){{$entry->urun_favori['id']}}@else null @endif)" @if(isset($entry->urun_favori['urun_id'])) style="display: block;" @else style="display: none;" @endif title="Favorilerden Kaldır">
                                    <i id="fav{{$entry['id']}}" class="fa fa-heart" style="color:#ff7f50;"aria-hidden="true"></i>
                                </a>    
                                <a @guest data-bs-toggle="modal" data-bs-target="#addtofavori" @endguest @auth href="javascript:void(0)" id="favEkle{{$entry['id']}}" onclick="favori({{$entry['id']}},@if(isset($entry->urun_favori['urun_id'])){{$entry->urun_favori['id']}}@else null @endif)" @if(isset($entry->urun_favori['urun_id'])) style="display: none;" @else style="display: block;" @endif @endauth  title="Favorilere ekle">
                                 <i  id="fav{{$entry['id']}}" class="ti-heart" aria-hidden="true"></i>
                             </a> 
                             @if($entry->cesit_durum == 0)
                             <a href="{{ route('urun', $entry->slug) }}"  title="Çeşitleri Gör">
                                <i class="ti-search" aria-hidden="true"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                    <div class="product-detail">
                        <div class="rating-section">
                            @php
                            $dolu = round($entry->urun_analiz_bul['ortalama_puan']);
                            $a =  $dolu;
                            $b = 5 - $a ; 
                            @endphp
                            @for($i=0; $i < $a ; $i++)
                            <i class="fa fa-star yildiz checked-yildiz" ></i>
                            @endfor
                            @for($i=0; $i < $b ; $i++)
                            <i class="fa fa-star yildiz-two "></i>
                            @endfor
                        </div>
                        <a href="{{ route('urun', $entry->slug) }}">
                            <h6>
                                {{ $entry->detay_bul['ad'] }}</h6>
                            </a>
                            <h4>
                             @if($entry->cesit_durum == 1)
                             @if($entry->stok == 0)
                             <span class="product-sale-label">Stokta Yok</span>
                             @else
                             {{ $entry->fiyat_bul['fiyat']}} {{ $paraSimge }}  <del> {{ $entry->fiyat_bul['fiyat_onceki'] }} {{ $paraSimge }} </del> 
                             @endif
                             @else
                             <a href="{{ route('urun', $entry->slug) }}" class="btn btn-solid btn-xs mt-2"  >Çeşitleri Gör</a>
                             @endif
                         </h4>
                     </div>
                 </div> 
                 @endforeach
             </div>
         </div>
     </div>
 </section>
 <!-- product end -->


 <!-- product slider -->
 <section class="section-b-space">
    <div class="container">
        <div class="row multiple-slider">
            @php $a = 0; @endphp
            @foreach($kategorilerAltBar as $kategori)
            @if($a < 4)
            <div class="col-lg-3 col-sm-6">
                <div class="theme-card"> 
                    <h5 class="title-border">{{$kategori->kategori_getir->kategori_dil_getir['ad']}}</h5>
                    <div class="offer-slider slide-1">
                        <div>
                         @php $i=0; @endphp 
                         @foreach($kategori->kategori_getir->kategori_urun_getir as $entry)
                         @php 
                         $urun = App\Models\Urun::where('id',$entry->urun_id)->where('durum',1)->first();
                         @endphp
                         @if(isset($urun))
                         @if($i == 20)
                         @php  break; @endphp
                         @endif
                         <div class="media">
                            <a href="{{ route('urun', $urun['slug']) }}">
                                <img class="img-fluid blur-up lazyload" src="{{ asset($urun->gorsel_bul['gorsel']) }}" alt="">
                            </a>
                            <div class="media-body align-self-center">

                                <a href="{{ route('urun', $urun['slug']) }}">
                                    <h6>{{ $urun->detay_bul['ad'] }}</h6>
                                </a>
                                <h4>
                                 @if($urun['cesit_durum'] == 1)
                                 @if($urun['stok']== 0)
                                 <span class="product-sale-label">Stokta Yok</span>
                                 @else
                                 {{ $urun->fiyat_bul['fiyat']}} {{ $paraSimge }}  <del> {{ $urun->fiyat_bul['fiyat_onceki'] }} {{ $paraSimge }} </del> 
                                 @endif
                                 @else
                                 <a href="{{ route('urun', $urun['slug']) }}" class="btn btn-solid btn-xs mt-2"  >Çeşitleri Gör</a>
                                 @endif
                             </h4>
                         </div>
                     </div>
                     @php $i++; @endphp
                     @if($i%4 ==0)
                 </div>
                 <div>
                   @endif
                   @endif

                   @endforeach
               </div>
           </div>
       </div>
   </div>  
   @endif
   @php $a++; @endphp
   @endforeach

</div>
</div>
</section>
<!-- product slider end -->

<!-- category 3 -->
<section class="p-0">
    <div class="container">
        <div class="row background">
           @foreach($kategorilerAltBar as $entry)
           <div class="col">
            <a href="{{ route('shop.kategori', $entry->kategori_getir['slug']) }}">
                <div class="contain-bg">
                    <h4 data-hover="size 06">{{$entry->kategori_getir->kategori_dil_getir['ad']}}</h4>
                </div>
            </a>
        </div>
        @endforeach


    </div>
</div>
</section>
<!-- category 3 end-->



<div class="modal fade bd-example-modal-lg theme-modal" id="exampleModal" tabindex="-1" role="dialog"
aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-body ">
            <div class="container">
                <div class="row"> 
                    <div class="modal-bg">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                        </button> 
                        <img  src="/assets/images/pop-up.jpeg" class="img-fluid blur-up lazyload" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div> 
@endsection