@extends('tanitim.layouts.master')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/pages/urun.css') }}"> 
<style type="text/css"> 
.spinner {
  display: flex;
  overflow: hidden;
  border-radius: 30px; 
  font-size: 20px;
  box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);  
  
}
.spinner-button {
  padding: 16px; 
  font-weight: 800;
  user-select: none; 
}
.spinner-value {
  margin: 0 2px;
  display: flex;
  align-items: center;
  justify-content: center; 
  width: 60px;
  height: 60px;
  text-align: center;
  font-size: 15px;
  border: solid 0px;
}   
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
}
@media screen and (max-width: 500px) {
  .btnSepet-mobil {
    margin-left: 100px;
  }
}
</style>
@endsection
@section('js')
<script src="{{ asset('/assets/js/lazysizes.min.js') }}"></script>
<script src="{{ asset('/assets/js/jquery.elevatezoom.js') }}"></script>
@if($urun->cesit_durum == 1)
<script src="{{ asset('/assets/js/sticky-cart-bottom.js') }}"></script>
@endif
<script type="text/javascript">
  function azalt(id){ 
    var yazdir = document.getElementById('yazdir'+id).value; 
    var sonuc = 1; 
    sonuc = Number(yazdir) - 1;
    document.getElementById('yazdir'+id).value = sonuc;  
    document.getElementById('yazdir2'+id).value = sonuc;  
  }
  function arttir(id, stok){  
    var yazdir = document.getElementById('yazdir'+id).value; 
    var sonuc = 1; 
    sonuc = Number(yazdir) + 1; 
    if (sonuc < stok) {
      document.getElementById('yazdir'+id).value = sonuc; 
      document.getElementById('yazdir2'+id).value = sonuc; 
    }
  }
</script>
@endsection
@section('content')
@include('admin.layouts.partials.alert')
@include('admin.layouts.partials.errors')
@section('title', $urun->detay_bul['title'])
@section('description', $urun->detay_bul['description'])

<!-- breadcrumb start -->
<div class="breadcrumb-section">
  <div class="container">
    <div class="row">
      <div class="col-sm-3">
        <div class="page-title">
          <h2>Ürün Detayı</h2>
        </div>
      </div>
      <div class="col-sm-9">
        <nav aria-label="breadcrumb" class="theme-breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="/">Anasayfa</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"> {{ $urun->detay_bul['ad'] }}</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</div>
<!-- breadcrumb End -->


<!-- section start -->
<section>
  <div class="collection-wrapper">
    <div class="container">
      <div class="row">
        <div class="col-lg-1 col-sm-2 col-xs-12">
          <div class="row">
            <div class="col-12 p-0">
              <div class="slider-right-nav">
                @php
                $numara = 1;
                @endphp
                @foreach($urun->gorseller_bul as $entry)
                <div>
                  <img src="{{ $entry['gorsel'] }}" alt=""
                  class="img-fluid blur-up lazyload">
                </div> 
                @php
                $numara = $numara + 1;
                @endphp
                @endforeach
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5 col-sm-10 col-xs-12 order-up">
          <div class="product-right-slick">

            @foreach($urun->gorseller_bul as $entry)
            <div>
              <img src="{{ $entry['gorsel'] }}" alt="" class="img-fluid blur-up lazyload image_zoom_cls-0">
            </div>
            @endforeach
          </div>
        </div>
        <div class="col-lg-6 rtl-text">
          <div class="product-right">
            <div class="product-count">
              <ul>
                <li>
                  <img src="/assets/images/icon/truck.png" class="img-fluid" alt="image">
                  <span class="lang">100 TL üzeri siparişlerde kargo bedava</span>
                </li>
              </ul>
            </div>
            <h2>{{ $urun->detay_bul['ad'] }}</h2>
            <div class="rating-section">
              @php
              $dolu = round($analiz->ortalama_puan);
              $a =  $dolu;
              $b = 5 - $a ; 
              @endphp
              @for($i=0; $i < $a ; $i++)
              <i class="fa fa-star  checked-yildiz" style="font-size: 25px !important;"></i>
              @endfor
              @for($i=0; $i < $b ; $i++)
              <i class="fa fa-star " style="font-size: 25px !important;  color: #ddd;"></i>
              @endfor

            </div>
            <div class="label-section"> 
              <span class="label-text">
                <a href="{{ route('shop.marka', $marka['slug']) }}"><h3>{{ $urun->marka_bul['ad'] }}</h3></a>
              </span>
            </div> 


            <div class="border-product">
              <h6 class="product-title">{!! $urun->detay_bul['aciklama_bir_baslik'] !!}</h6>
              <ul class="shipping-info"> 
                {!! $urun->detay_bul['aciklama_bir'] !!}
              </ul>
            </div>
            <div class="product-buttons">
              <a @guest data-bs-toggle="modal" data-bs-target="#addtofavori" @endguest @auth href="{{ route('favori.ekle', $urun->id) }}"@endauth class="btn btn-solid" >
                <i class="fa fa-heart fz-16 me-2" aria-hidden="true"></i>Favorilere Ekle
              </a>
            </div>
            <div id="selectSize" class="addeffect-section product-description border-product">
              @if($urun->cesit_durum == 0)
              @foreach($urun->cesitler_bul as $cesit)
              <!-- -->
              <div class="table-responsive ">
                <h6 class="mb-0"><a href="javascript::void(0)"  style="color:black;" class=" d-inline-block">{{$cesit->cesit_dil_getir['ad']}}</a></h6>
                <div class="container">
                  @foreach($cesit->cesit_detay_bul as $detay)
                  <form method="get" action="{{route('sepete.ekle', $urun->id)}}">
                    @csrf
                    <div class="row">
                      <div class="col-lg-3 col-sm-6">
                       <div class="ml-3 d-inline-block align-top">
                        <h6 class="mb-0"><a href="javascript::void(0)" style="font-size: 20px;" class=" d-inline-block">{{$detay->cesit_detay_dil_getir['ad']}}</a></h6>
                      </div>
                    </div>
                    <div class="col-lg-2 col-sm-6 border-0 align-middle productcard-price" style="display: flex; flex-direction: column;">
                      <span style="text-decoration:line-through ; color: black; font-size: 15px;">{{$detay->cesit_detay_fiyat_bul['fiyat_onceki']}} {{ $paraSimge }}</span>
                      <span style="font-size: 18px;">{{$detay->cesit_detay_fiyat_bul['fiyat']}} {{ $paraSimge }}</span> 
                    </div> 
                    <input type="hidden" name="cesit_detay_id" value="{{$detay->id}}">
                    @if($detay['stok'] > 0)
                    <div class="col-lg-4 col-sm-6"> 
                      <div class="input-group btnSepet-mobil" >  
                        <div class="spinner"> 
                          <a href="javascript:void(0)" style="color:black;">
                            <div class="spinner-button"  id="azalt{{$detay->id}}" onclick="azalt({{$detay['id']}})">-</div>
                          </a>
                          <input type="number" name="adet" min="1" max="100000" id="yazdir{{$detay->id}}" class="form-control spinner-value input-number" value="1"> 
                          <a href="javascript:void(0)" style="color:black;">
                            <div class="spinner-button" id="arttir{{$detay->id}}" onclick="arttir({{$detay['id']}},{{$detay['stok']}})">+</div> 
                          </a>
                        </div>   
                      </div>
                    </div>
                    @endif
                    <div class="col-lg-3 col-sm-6">
                      @if($detay['stok'] == 0)
                      <span class="product-sale-label" style="color:#FF7F50;">Stokta Yok</span>
                      @else
                      <button style="width: auto; background-color: #FF7F50; color:white;border:none; padding:5px 20px; margin-top: 6px;">
                       <i class="fa fa-shopping-cart me-1"  aria-hidden="true"></i> Sepete Ekle
                     </button>
                     @endif
                   </div>
                   <hr class="mt-2">
                 </div>
               </form>
               @endforeach

             </div>
           </div>
           <!-- -->
           @endforeach
           @else
           <!-- -->
           <div class="table-responsive ">
            <div class="container">
              <form method="get" action="{{route('sepete.ekle', $urun->id)}}">
                <div class="row">

                  @csrf
                  <div class="col-lg-3 col-sm-6">
                   <div class="ml-3 d-inline-block align-top"> 
                   </div>
                 </div>
                 <div class="col-lg-2 col-sm-6 border-0 align-middle productcard-price" style="display: flex; flex-direction: column;">
                  <span style="text-decoration:line-through ; color: black; font-size: 15px;">{{$urun->fiyat_bul['fiyat_onceki']}} {{ $paraSimge }} </span>
                  <span style="font-size: 18px;">{{$urun->fiyat_bul['fiyat']}} {{ $paraSimge }}</span> 
                </div>   
                @if($urun->stok != 0)
                <div class="col-lg-4 col-sm-6"> 
                  <div class="input-group  btnSepet-mobil" >  
                    <div class="spinner"> 
                      <a href="javascript:void(0)" style="color:black;">
                        <div class="spinner-button"  id="azalt{{$urun->id}}" onclick="azalt({{$urun['id']}})">-</div>
                      </a>
                      <input type="number" name="adet" min="1" max="100000"  id="yazdir{{$urun->id}}" class="form-control spinner-value input-number" value="1"> 
                      <a href="javascript:void(0)"  style="color:black;">
                        <div class="spinner-button" id="arttir{{$urun->id}}" onclick="arttir({{$urun['id']}},{{$urun['stok']}})">+</div> 
                      </a>
                    </div>   
                  </div>
                </div>
                @endif
                @if($urun->stok == 0)       
                <div class="col-lg-4 col-sm-6">           
                  <a class="btn btn-solid btn-xs" @guest data-bs-toggle="modal" data-bs-target="#addtofavori" @endguest @auth href="{{ route('urun.haber', ['urun_id' => $urun->id, 'user_id' => Auth::user()->id]) }}"@endauth>
                   <i class="fa fa-shopping-cart me-1"  aria-hidden="true"></i> Gelince Haber Ver
                 </a>

               </div>
               @else
               <div class="col-lg-3 col-sm-6"> 
                 <button style="width: auto; background-color: #FF7F50; color:white;border:none; padding:5px 20px; margin-top: 6px;">
                   <i class="fa fa-shopping-cart me-1"  aria-hidden="true"></i> Sepete Ekle
                 </button>
               </div>
               @endif
               <hr class="mt-2"> 
             </div>
           </form>

         </div>
       </div>
       <!-- -->
       @endif

       <div class="table-responsive ">
        <table class="table table-borderless mb-0 mt-3">
          <tbody> 
            <tr>
              <th class="pl-0 w-70" scope="row">Ürün Kod:</th>
              <td>
                @if($urun->cesit_durum == 0)
                @foreach($urun->cesitler_bul as $cesit)
                @foreach($cesit->cesit_detay_bul as $detay)
                {{$detay->kod}} @if($cesit->cesit_detay_bul->last() !== $detay), @endif
                @endforeach
                @endforeach
                @else
                {{$urun->kod}} 
                @endif
              </td>
            </tr> 
            <tr>
              <th class="pl-0 w-70" scope="row">Ürün Barkod:</th>
              <td>
                @if($urun->cesit_durum == 0)
                @foreach($urun->cesitler_bul as $cesit)
                @foreach($cesit->cesit_detay_bul as $detay)
                {{$detay->barkod}} @if($cesit->cesit_detay_bul->last() !== $detay), @endif
                @endforeach
                @endforeach
                @else
                {{$urun->barkod}} 
                @endif
              </td>
            </tr>
            <tr>
              <th class="pl-0 w-70" scope="row">Kategoriler:</th>
              <td>
                @isset($urunKategoriler)
                @foreach($urunKategoriler as $urunKategori)
                <a href="{{ route('shop.kategori', $urunKategori->kategori_bul['slug']) }}">{{ $urunKategori->kategori_bul->kategori_dil_getir['ad'] }}@if($urunKategoriler->last() !== $urunKategori), @endif</a>
                @endforeach
                @endisset

              </td>
            </tr>
            <tr>
              <th class="pl-0 w-70" scope="row">Etiketler:</th>
              <td> 
                @foreach($etiketBenzer as $etiket)
                <a href="{{ route('shop.etiket', $etiket['slug']) }}">{{ $etiket->urun_etiket_dil_getir['ad'] }}@if($etiketBenzer->last() !== $etiket), @endif</a>
                @endforeach
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
</section>
<!-- Section ends -->


<!-- product-tab starts -->
<section class="tab-product m-0">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-lg-12">
        <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
          @if(isset($urun->detay_bul['aciklama_iki_baslik']))
          <li class="nav-item"><a class="nav-link active" id="top-home-tab" data-bs-toggle="tab" href="#top-home" role="tab" aria-selected="true"><i
            class="icofont icofont-ui-home"></i>{!! $urun->detay_bul['aciklama_iki_baslik'] !!}</a>
            <div class="material-border"></div>
          </li>
          @endif
          @if(isset($urun->detay_bul['aciklama_uc_baslik']))
          <li class="nav-item"><a class="nav-link" id="profile-top-tab" data-bs-toggle="tab" href="#top-profile" role="tab" aria-selected="false"><i
            class="icofont icofont-man-in-glasses"></i>{!! $urun->detay_bul['aciklama_uc_baslik'] !!}</a>
            <div class="material-border"></div>
          </li>
          @endif
          @if(isset($urun->detay_bul['aciklama_dort_baslik']))
          <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-bs-toggle="tab" href="#top-contact" role="tab" aria-selected="false"><i
            class="icofont icofont-contacts"></i>{!! $urun->detay_bul['aciklama_dort_baslik'] !!}</a>
            <div class="material-border"></div>
          </li>
          @endif

          <li class="nav-item"><a class="nav-link" id="review-top-tab" data-bs-toggle="tab" href="#top-review" role="tab" aria-selected="false"><i
            class="icofont icofont-contacts"></i>Yorum({{$yorum->count()}})</a>
            <div class="material-border"></div>
          </li>
        </ul>
        <div class="tab-content nav-material" id="top-tabContent">
          @if(isset($urun->detay_bul['aciklama_iki']))
          <div class="tab-pane fade show active" id="top-home" role="tabpanel" aria-labelledby="top-home-tab">
            <div class="product-tab-discription">
              {!! $urun->detay_bul['aciklama_iki'] !!}
            </div>
          </div>
          @endif
          @if(isset($urun->detay_bul['aciklama_uc']))
          <div class="tab-pane fade" id="top-profile" role="tabpanel" aria-labelledby="profile-top-tab">
            {!! $urun->detay_bul['aciklama_uc'] !!}
          </div>
          @endif
          @if(isset($urun->detay_bul['aciklama_dort']))
          <div class="tab-pane fade" id="top-contact" role="tabpanel" aria-labelledby="contact-top-tab">
            <div class="">
              {!! $urun->detay_bul['aciklama_dort'] !!}

            </div>
          </div>
          @endif


          <div class="tab-pane fade" id="top-review" role="tabpanel" aria-labelledby="review-top-tab">
           <!-- section start -->
           <section class="section-b-space blog-detail-page review-page">
            <div class="container">
              <div class="row">
                <div class="col-sm-12 bosluk"  >
                  @foreach($yorumlar as $yorum)
                  <ul class="comment-section mb-4">
                    <li>
                      <div class="media">
                        <img src="../assets/images/avtar.jpg" alt="Generic placeholder image">
                        <div class="media-body">
                          <h6>{{ $yorum->kullanici_bul['ad'] }}<span>( {{ $yorum->created_at }} )</span></h6>
                          <p>{!!$yorum->yorum!!}</p>
                        </div>
                      </div>
                    </li>
                  </ul>
                  @endforeach
                  <ul class="comment-section mb-4">
                    <li>
                      <a href="{{route('yorumlar', $urun->slug)}}">Tüm Yorumlar ↓</a>
                    </li>
                  </ul>
                  @guest 
                  <div class="row">
                    <div class="col-lg-3">
                      <a class="btn btn-solid" href="{{route('loginSayfa')}}">Yorum yapmak için giris yapın</a>
                    </div>
                    <div class="col-lg-3">
                      <a class="btn btn-solid" href="{{ route('loginSayfa') }}">Yorum yapmak için kayıt olun</a>
                    </div>
                  </div> 
                  @endguest
                </div>
              </div>
            </div>
          </section>
          <!-- Section ends -->
          @auth
          <form class="theme-form" action="{{ route('shop.yorum', ['user_id' => Auth::user()->id, 'urun_id' => $urun->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-row row">
              <div class="col-md-12">
                <div class="media bosluk">
                 <div class="feedback">
                  <div class="rating">
                    <input type="radio" name="rating" value="5" id="rating-5">
                    <label for="rating-5"></label>
                    <input type="radio" name="rating" value="4" id="rating-4">
                    <label for="rating-4"></label>
                    <input type="radio" name="rating" value="3" id="rating-3">
                    <label for="rating-3"></label>
                    <input type="radio" name="rating" value="2" id="rating-2">
                    <label for="rating-2"></label>
                    <input type="radio" name="rating" value="1" id="rating-1">
                    <label for="rating-1"></label>

                    <div class="emoji-wrapper">
                      <div class="emoji">
                        <svg class="rating-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                          <circle cx="256" cy="256" r="256" fill="#ffd93b"/>
                          <path d="M512 256c0 141.44-114.64 256-256 256-80.48 0-152.32-37.12-199.28-95.28 43.92 35.52 99.84 56.72 160.72 56.72 141.36 0 256-114.56 256-256 0-60.88-21.2-116.8-56.72-160.72C474.8 103.68 512 175.52 512 256z" fill="#f4c534"/>
                          <ellipse transform="scale(-1) rotate(31.21 715.433 -595.455)" cx="166.318" cy="199.829" rx="56.146" ry="56.13" fill="#fff"/>
                          <ellipse transform="rotate(-148.804 180.87 175.82)" cx="180.871" cy="175.822" rx="28.048" ry="28.08" fill="#3e4347"/>
                          <ellipse transform="rotate(-113.778 194.434 165.995)" cx="194.433" cy="165.993" rx="8.016" ry="5.296" fill="#5a5f63"/>
                          <ellipse transform="scale(-1) rotate(31.21 715.397 -1237.664)" cx="345.695" cy="199.819" rx="56.146" ry="56.13" fill="#fff"/>
                          <ellipse transform="rotate(-148.804 360.25 175.837)" cx="360.252" cy="175.84" rx="28.048" ry="28.08" fill="#3e4347"/>
                          <ellipse transform="scale(-1) rotate(66.227 254.508 -573.138)" cx="373.794" cy="165.987" rx="8.016" ry="5.296" fill="#5a5f63"/>
                          <path d="M370.56 344.4c0 7.696-6.224 13.92-13.92 13.92H155.36c-7.616 0-13.92-6.224-13.92-13.92s6.304-13.92 13.92-13.92h201.296c7.696.016 13.904 6.224 13.904 13.92z" fill="#3e4347"/>
                        </svg>
                        <svg class="rating-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                          <circle cx="256" cy="256" r="256" fill="#ffd93b"/>
                          <path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534"/>
                          <path d="M328.4 428a92.8 92.8 0 0 0-145-.1 6.8 6.8 0 0 1-12-5.8 86.6 86.6 0 0 1 84.5-69 86.6 86.6 0 0 1 84.7 69.8c1.3 6.9-7.7 10.6-12.2 5.1z" fill="#3e4347"/>
                          <path d="M269.2 222.3c5.3 62.8 52 113.9 104.8 113.9 52.3 0 90.8-51.1 85.6-113.9-2-25-10.8-47.9-23.7-66.7-4.1-6.1-12.2-8-18.5-4.2a111.8 111.8 0 0 1-60.1 16.2c-22.8 0-42.1-5.6-57.8-14.8-6.8-4-15.4-1.5-18.9 5.4-9 18.2-13.2 40.3-11.4 64.1z" fill="#f4c534"/>
                          <path d="M357 189.5c25.8 0 47-7.1 63.7-18.7 10 14.6 17 32.1 18.7 51.6 4 49.6-26.1 89.7-67.5 89.7-41.6 0-78.4-40.1-82.5-89.7A95 95 0 0 1 298 174c16 9.7 35.6 15.5 59 15.5z" fill="#fff"/>
                          <path d="M396.2 246.1a38.5 38.5 0 0 1-38.7 38.6 38.5 38.5 0 0 1-38.6-38.6 38.6 38.6 0 1 1 77.3 0z" fill="#3e4347"/>
                          <path d="M380.4 241.1c-3.2 3.2-9.9 1.7-14.9-3.2-4.8-4.8-6.2-11.5-3-14.7 3.3-3.4 10-2 14.9 2.9 4.9 5 6.4 11.7 3 15z" fill="#fff"/>
                          <path d="M242.8 222.3c-5.3 62.8-52 113.9-104.8 113.9-52.3 0-90.8-51.1-85.6-113.9 2-25 10.8-47.9 23.7-66.7 4.1-6.1 12.2-8 18.5-4.2 16.2 10.1 36.2 16.2 60.1 16.2 22.8 0 42.1-5.6 57.8-14.8 6.8-4 15.4-1.5 18.9 5.4 9 18.2 13.2 40.3 11.4 64.1z" fill="#f4c534"/>
                          <path d="M155 189.5c-25.8 0-47-7.1-63.7-18.7-10 14.6-17 32.1-18.7 51.6-4 49.6 26.1 89.7 67.5 89.7 41.6 0 78.4-40.1 82.5-89.7A95 95 0 0 0 214 174c-16 9.7-35.6 15.5-59 15.5z" fill="#fff"/>
                          <path d="M115.8 246.1a38.5 38.5 0 0 0 38.7 38.6 38.5 38.5 0 0 0 38.6-38.6 38.6 38.6 0 1 0-77.3 0z" fill="#3e4347"/>
                          <path d="M131.6 241.1c3.2 3.2 9.9 1.7 14.9-3.2 4.8-4.8 6.2-11.5 3-14.7-3.3-3.4-10-2-14.9 2.9-4.9 5-6.4 11.7-3 15z" fill="#fff"/>
                        </svg>
                        <svg class="rating-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                          <circle cx="256" cy="256" r="256" fill="#ffd93b"/>
                          <path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534"/>
                          <path d="M336.6 403.2c-6.5 8-16 10-25.5 5.2a117.6 117.6 0 0 0-110.2 0c-9.4 4.9-19 3.3-25.6-4.6-6.5-7.7-4.7-21.1 8.4-28 45.1-24 99.5-24 144.6 0 13 7 14.8 19.7 8.3 27.4z" fill="#3e4347"/>
                          <path d="M276.6 244.3a79.3 79.3 0 1 1 158.8 0 79.5 79.5 0 1 1-158.8 0z" fill="#fff"/>
                          <circle cx="340" cy="260.4" r="36.2" fill="#3e4347"/>
                          <g fill="#fff">
                            <ellipse transform="rotate(-135 326.4 246.6)" cx="326.4" cy="246.6" rx="6.5" ry="10"/>
                            <path d="M231.9 244.3a79.3 79.3 0 1 0-158.8 0 79.5 79.5 0 1 0 158.8 0z"/>
                          </g>
                          <circle cx="168.5" cy="260.4" r="36.2" fill="#3e4347"/>
                          <ellipse transform="rotate(-135 182.1 246.7)" cx="182.1" cy="246.7" rx="10" ry="6.5" fill="#fff"/>
                        </svg>
                        <svg class="rating-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                          <circle cx="256" cy="256" r="256" fill="#ffd93b"/>
                          <path d="M407.7 352.8a163.9 163.9 0 0 1-303.5 0c-2.3-5.5 1.5-12 7.5-13.2a780.8 780.8 0 0 1 288.4 0c6 1.2 9.9 7.7 7.6 13.2z" fill="#3e4347"/>
                          <path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534"/>
                          <g fill="#fff">
                            <path d="M115.3 339c18.2 29.6 75.1 32.8 143.1 32.8 67.1 0 124.2-3.2 143.2-31.6l-1.5-.6a780.6 780.6 0 0 0-284.8-.6z"/>
                            <ellipse cx="356.4" cy="205.3" rx="81.1" ry="81"/>
                          </g>
                          <ellipse cx="356.4" cy="205.3" rx="44.2" ry="44.2" fill="#3e4347"/>
                          <g fill="#fff">
                            <ellipse transform="scale(-1) rotate(45 454 -906)" cx="375.3" cy="188.1" rx="12" ry="8.1"/>
                            <ellipse cx="155.6" cy="205.3" rx="81.1" ry="81"/>
                          </g>
                          <ellipse cx="155.6" cy="205.3" rx="44.2" ry="44.2" fill="#3e4347"/>
                          <ellipse transform="scale(-1) rotate(45 454 -421.3)" cx="174.5" cy="188" rx="12" ry="8.1" fill="#fff"/>
                        </svg>
                        <svg class="rating-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                          <circle cx="256" cy="256" r="256" fill="#ffd93b"/>
                          <path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534"/>
                          <path d="M232.3 201.3c0 49.2-74.3 94.2-74.3 94.2s-74.4-45-74.4-94.2a38 38 0 0 1 74.4-11.1 38 38 0 0 1 74.3 11.1z" fill="#e24b4b"/>
                          <path d="M96.1 173.3a37.7 37.7 0 0 0-12.4 28c0 49.2 74.3 94.2 74.3 94.2C80.2 229.8 95.6 175.2 96 173.3z" fill="#d03f3f"/>
                          <path d="M215.2 200c-3.6 3-9.8 1-13.8-4.1-4.2-5.2-4.6-11.5-1.2-14.1 3.6-2.8 9.7-.7 13.9 4.4 4 5.2 4.6 11.4 1.1 13.8z" fill="#fff"/>
                          <path d="M428.4 201.3c0 49.2-74.4 94.2-74.4 94.2s-74.3-45-74.3-94.2a38 38 0 0 1 74.4-11.1 38 38 0 0 1 74.3 11.1z" fill="#e24b4b"/>
                          <path d="M292.2 173.3a37.7 37.7 0 0 0-12.4 28c0 49.2 74.3 94.2 74.3 94.2-77.8-65.7-62.4-120.3-61.9-122.2z" fill="#d03f3f"/>
                          <path d="M411.3 200c-3.6 3-9.8 1-13.8-4.1-4.2-5.2-4.6-11.5-1.2-14.1 3.6-2.8 9.7-.7 13.9 4.4 4 5.2 4.6 11.4 1.1 13.8z" fill="#fff"/>
                          <path d="M381.7 374.1c-30.2 35.9-75.3 64.4-125.7 64.4s-95.4-28.5-125.8-64.2a17.6 17.6 0 0 1 16.5-28.7 627.7 627.7 0 0 0 218.7-.1c16.2-2.7 27 16.1 16.3 28.6z" fill="#3e4347"/>
                          <path d="M256 438.5c25.7 0 50-7.5 71.7-19.5-9-33.7-40.7-43.3-62.6-31.7-29.7 15.8-62.8-4.7-75.6 34.3 20.3 10.4 42.8 17 66.5 17z" fill="#e24b4b"/>
                        </svg>
                        <svg class="rating-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                          <g fill="#ffd93b">
                            <circle cx="256" cy="256" r="256"/>
                            <path d="M512 256A256 256 0 0 1 56.8 416.7a256 256 0 0 0 360-360c58 47 95.2 118.8 95.2 199.3z"/>
                          </g>
                          <path d="M512 99.4v165.1c0 11-8.9 19.9-19.7 19.9h-187c-13 0-23.5-10.5-23.5-23.5v-21.3c0-12.9-8.9-24.8-21.6-26.7-16.2-2.5-30 10-30 25.5V261c0 13-10.5 23.5-23.5 23.5h-187A19.7 19.7 0 0 1 0 264.7V99.4c0-10.9 8.8-19.7 19.7-19.7h472.6c10.8 0 19.7 8.7 19.7 19.7z" fill="#e9eff4"/>
                          <path d="M204.6 138v88.2a23 23 0 0 1-23 23H58.2a23 23 0 0 1-23-23v-88.3a23 23 0 0 1 23-23h123.4a23 23 0 0 1 23 23z" fill="#45cbea"/>
                          <path d="M476.9 138v88.2a23 23 0 0 1-23 23H330.3a23 23 0 0 1-23-23v-88.3a23 23 0 0 1 23-23h123.4a23 23 0 0 1 23 23z" fill="#e84d88"/>
                          <g fill="#38c0dc">
                            <path d="M95.2 114.9l-60 60v15.2l75.2-75.2zM123.3 114.9L35.1 203v23.2c0 1.8.3 3.7.7 5.4l116.8-116.7h-29.3z"/>
                          </g>
                          <g fill="#d23f77">
                            <path d="M373.3 114.9l-66 66V196l81.3-81.2zM401.5 114.9l-94.1 94v17.3c0 3.5.8 6.8 2.2 9.8l121.1-121.1h-29.2z"/>
                          </g>
                          <path d="M329.5 395.2c0 44.7-33 81-73.4 81-40.7 0-73.5-36.3-73.5-81s32.8-81 73.5-81c40.5 0 73.4 36.3 73.4 81z" fill="#3e4347"/>
                          <path d="M256 476.2a70 70 0 0 0 53.3-25.5 34.6 34.6 0 0 0-58-25 34.4 34.4 0 0 0-47.8 26 69.9 69.9 0 0 0 52.6 24.5z" fill="#e24b4b"/>
                          <path d="M290.3 434.8c-1 3.4-5.8 5.2-11 3.9s-8.4-5.1-7.4-8.7c.8-3.3 5.7-5 10.7-3.8 5.1 1.4 8.5 5.3 7.7 8.6z" fill="#fff" opacity=".2"/>
                        </svg>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <label for="name">Ad Soyad</label>
              <input type="text" class="form-control" id="name" placeholder="Enter Your name" disabled required value="{{Auth::user()->ad}}">
            </div>
            <div class="col-md-6">
              <label for="email">Email</label>
              <input type="text" class="form-control" id="email" placeholder="Email" disabled required value="{{Auth::user()->email}}">
            </div>

            <div class="col-md-12">
              <label for="review">Yorumunuz</label>
              <textarea class="form-control" placeholder="Yorumunuzu Yazınız" name="yorum" id="exampleFormControlTextarea1" rows="6"></textarea>
            </div>
            <div class="col-md-12">
              <button class="btn btn-solid" type="submit">Gönder</button>
            </div>
          </div>
        </form>
        @endauth
      </div>


    </div>
  </div>
</div>
</div>
</section>
<!-- product-tab ends -->


<!-- product section start -->

<!-- Product slider -->
<section class="section-b-space j-box pets-box ratio_square">
  <div class="container">
    <div class="row">
      <div class="col">
        <div class="title1 title5"> 
          <h2 class="title-inner1">İlgili Ürünler</h2>
          <hr role="tournament6">
        </div>
        <div class="product-4 product-m no-arrow"> 

          @foreach($benzer as $entry)
          <div class="product-box">
            <div class="img-wrapper">
              <div class="lable-block">
                <span class="lable3">yeni</span> 
              </div>
              <!-- front image -->
              <div class="front">
                <a href="{{ route('urun', $entry->slug) }}">
                  <img src="{{ $entry->gorsel_bul['gorsel'] }}" class="img-fluid blur-up lazyload bg-img" alt="">
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
              <i class="ti-eye" aria-hidden="true"></i>
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
            <h6>{{ $entry->detay_bul['ad'] }}</h6>
          </a>
          <h4>
           @if($entry->cesit_durum == 1)
           @if($entry->stok == 0)
           <span class="product-sale-label">Stokta Yok</span>
           @else
           {{ $entry->fiyat_bul['fiyat']}} {{ $paraSimge }}<del> {{ $entry->fiyat_bul['fiyat_onceki'] }} {{ $paraSimge }}</del> 
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
</div>
</section>

<!-- product section end -->
@if($urun->cesit_durum == 1)
<!-- sticky cart bottom start -->
<div class="sticky-bottom-cart d-sm-block d-none">
  <div class="container">
    <div class="cart-content">
      <div class="product-image">
        @foreach($urun->gorseller_bul as $entry)
        <img src="{{ $entry['gorsel'] }}" alt="" class="img-fluid blur-up lazyload">
        @endforeach
        <div class="content d-lg-block d-none">
          <h5>{{ $urun->detay_bul['ad'] }}</h5>
          <h6>  <span style="text-decoration:line-through ; color: black; font-size: 15px;">{{$urun->fiyat_bul['fiyat_onceki']}} {{ $paraSimge }} </span>
            <span style="font-size: 18px;">{{$urun->fiyat_bul['fiyat']}} {{ $paraSimge }}</span> </h6>
          </div>
        </div>
        <form method="get" style="margin-left: 100px" action="{{route('sepete.ekle', $urun->id)}}">
          @csrf
          <div class="selection-section">
            @if($urun->stok > 0)
            <div class="row">
              <div class="input-group btnSepet-mobil" >  
                <div class="spinner"> 
                  <a href="javascript:void(0)" style="color:black;">
                    <div class="spinner-button"  onclick="azalt({{$urun['id']}})">-</div>
                  </a>
                  <input type="number" name="adet" min="1" max="100000" id="yazdir2{{$urun->id}}" class="form-control spinner-value input-number" value="1"> 
                  <a href="javascript:void(0)" style="color:black;">
                    <div class="spinner-button"  onclick="arttir({{$urun['id']}},{{$urun['stok']}})">+</div> 
                  </a>
                </div>   
              </div>
            </div>
            @endif
            <div class="add-btn col-lg-12" >
              @if($urun->stok == 0)
              <span class="product-sale-label " style="color: #FF7F50;">Satokta Yok</span>
              @else
              <button data-bs-toggle="modal" style="margin-left: 80px;" data-bs-target="#addtocart" href="" class="btn btn-solid"> <i class="fa fa-shopping-cart me-1"  aria-hidden="true"></i>Sepete Ekle</button>
              @endif
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- sticky cart bottom end -->
  @endif

  @endsection