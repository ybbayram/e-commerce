@extends('tanitim.layouts.master')

@section('content')
@include('admin.layouts.partials.alert')
@include('admin.layouts.partials.errors')
@section('title', $kategoriAlt->kategori_dil_getir['ad'])
@php
$description = substr($kategori->kategori_dil_getir['aciklama'],0,160)
@endphp
@section('description', $description )

<!-- breadcrumb start -->
<div class="breadcrumb-section">
  <div class="container">
    <div class="row">
      <div class="col-sm-6">
        <div class="page-title">
          <h2>Alt Kategoriler</h2>
        </div>
      </div>
      <div class="col-sm-6">
        <nav aria-label="breadcrumb" class="theme-breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Anasayfa</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('shop.kategori', $ustKategori->slug) }}">{{ $ustKategori->kategori_dil_getir['ad'] }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $kategoriAlt->kategori_dil_getir['ad'] }}</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</div>
<!-- breadcrumb end -->
<!-- section start -->
<section class="section-b-space ratio_asos">
  <div class="collection-wrapper">
    <div class="container">
      <div class="row">
        <div class="col-sm-3 collection-filter">
          <!-- side-bar colleps block stat -->
          <div class="collection-filter-block">
            <!-- brand filter start -->
            <div class="collection-mobile-back">
              <span class="filter-back">
                <i class="fa fa-angle-left" aria-hidden="true"></i> Geri
              </span>
            </div>
            <!-- Alt Kategoriler -->
            @php if(isset($kategoriAltlar[0])){ @endphp
            <div class="collection-collapse-block open">
              <h3 class="collapse-block-title">Alt Kategoriler</h3>
              <div class="collection-collapse-block-content">
                <div class="collection-brand-filter"> 
                 @foreach($kategoriAltlar as $entry) 
                 <div class="form-check collection-filter-checkbox">
                   <li><a style="color:black;" href="{{ route('shop.kategoriAlt', ['kategori' => $kategori->slug, 'kategoriAlt' => $entry->slug]) }}">{{ $entry->kategori_dil_getir['ad'] }}</a></li> 
                 </div>
                 @endforeach
               </div>
             </div>
           </div>

           @php } @endphp
           <form action="{{ route('shop.kategoriAlt.filtre', ['kategori' => $ustKategori->slug, 'kategoriAlt' => $kategoriAlt->slug]) }}" method="get">


            <!-- Markalar -->
            <div class="collection-collapse-block">
              <h3 class="collapse-block-title">Marka </h3>
              <div class="collection-collapse-block-content" style="display:none;">
                <div class="collection-brand-filter">
                 @foreach($markalar as $entry)
                 <div class="form-check collection-filter-checkbox">
                  <input type="checkbox" class="form-check-input" 
                  @if(in_array($entry->id, $gelenMarka)) checked  @endif id="m{{ $entry['id'] }}" name="markalar[]"  value="{{ $entry['id'] }}">
                  <label class="form-check-label mt-1"  for="m{{ $entry['id'] }}">{{ $entry['ad'] }}</label>
                </div>
                @endforeach
              </div>
            </div>
          </div>
          <!-- size filter start here -->
          @foreach($filtreler as $entry) 
          <div class="collection-collapse-block border-0">
            <h3 class="collapse-block-title">{{$entry->filtre_dil_getir['ad']}}</h3>
            <div class="collection-collapse-block-content"  style="display:none;">
              <div class="collection-brand-filter">
                @foreach($entry->filtre_etiket_getir as $filtreEtiket)
                <div class="form-check collection-filter-checkbox">
                  <input type="checkbox" class="form-check-input" @if(in_array($filtreEtiket->id, $gelenEtiket)) checked  @endif id="e{{ $filtreEtiket['filtre_id'] }}{{ $filtreEtiket['id'] }}" name="etiketler[]" value="{{$filtreEtiket['id'] }}">
                  <label class="form-check-label" for="e{{ $filtreEtiket['filtre_id'] }}{{ $filtreEtiket['id'] }}">{{ $filtreEtiket->filtre_etiket_etiket_bul['ad']}}</label>
                </div>
                @endforeach

              </div>
            </div>
          </div>
          @endforeach
          <div class="collection-collapse-block">

            <h3 class="collapse-block-title">Fiyat Aralığı</h3>
            <div class="collection-collapse-block-content" >
              <div class="wrapper mt-3">
                <div class="form-group-sm row">
                  <div class="col-lg-5">
                    <label>Başlangıç : </label>
                    <input type="number" min="0" max="100000" step="any" name="price_start" value="{{$gelenBaslangicFiyat}}" class="form-control">
                  </div>
                  <div class="col-lg-5">
                    <label>Bitiş : </label>
                    <input type="number" min="0" max="100000" step="any" name="price_finish" value="{{$gelenBitisFiyat}}" class="form-control">
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
        <button type="submit" class="btn rounded-pill py-2 btn-block btn-solid procced w-50 my-5 mx-auto">Filtrele</button>
      </form>
      <!-- silde-bar colleps block end here -->

      <!-- side-bar single product slider start -->
      <div class="theme-card">
        <h5 class="title-border">ilginizi çekebilir</h5>
        <div class="offer-slider slide-1">
          <div>
           @php $i=0; @endphp 
           
           @foreach($random as $entry)
           <div class="media">
            <a href="{{ route('urun', $entry->slug) }}"><img class="img-fluid blur-up lazyload" src="{{ $entry->gorsel_bul['gorsel'] }}" alt=""></a>
            <div class="media-body align-self-center">
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
       @php $i++; @endphp
       @if($i%4 ==0)
     </div>
     <div>
       @endif
       @endforeach
     </div> 
   </div>
 </div>
 <!-- side-bar single product slider end -->

 <!-- side-bar banner start here -->
 <div class="collection-sidebar-banner telepohne">
  <iframe height="650" width="320" src="{{route('tanitim.tel')}}"></iframe>
</div>
<!-- side-bar banner end here -->

</div>
<div class="collection-content col">
  <div class="page-main-content">
    <div class="row">
      <div class="col-sm-12">
        <div class="top-banner-wrapper">
         <img src="{{ $kategoriAlt->kategori_dil_getir['gorsel'] }}" class="img-fluid blur-up lazyload" alt="">
         <div class="top-banner-content small-section">
          <h4>{{ $kategoriAlt->kategori_dil_getir['ad'] }}</h4>
          <p>{!! $kategoriAlt->kategori_dil_getir['aciklama'] !!} </p>
        </div>
      </div>
      <div class="collection-product-wrapper">
       <div class="product-top-filter">
        <div class="row">
          <div class="col-xl-12">
            <div class="filter-main-btn"><span class="filter-btn btn btn-theme"><i class="fa fa-filter"
              aria-hidden="true"></i> Filtre</span></div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="product-filter-content">
                <div class="search-count">
                  <h5>Bulunan Ürün Sayısı: @if($urunler != null) {{ $urunler->total() }} @else 0 @endif</h5>
                </div>
                <div class="collection-view">
                  <ul>
                    <li><i class="fa fa-th grid-layout-view"></i></li>
                    <li><i class="fa fa-list-ul list-layout-view"></i></li>
                  </ul>
                </div>
                <div class="collection-grid-view">
                  <ul>
                    <li><img src="/assets/images/icon/2.png" alt="" class="product-2-layout-view"></li>
                    <li><img src="/assets/images/icon/3.png" alt="" class="product-3-layout-view"></li>
                    <li><img src="/assets/images/icon/4.png" alt="" class="product-4-layout-view"></li>
                    <li><img src="/assets/images/icon/6.png" alt="" class="product-6-layout-view"></li>
                  </ul>
                </div>

                @php $urlSlug = "shop"; @endphp
                <div class="product-page-filter">
                  <select name="filtreFiyat" id="filtreGetir" onchange="filtreFiyatgetir('{{$ustKategori->slug}}','{{$urlSlug}}','{{$kategoriAlt->slug}}')">
                    <option value="">Ürün Sırala</option>
                    <option value="artan" id="artan">Fiyata Göre Artan</option>
                    <option value="azalan" id="azalan">Fiyata Göre Azalan</option>
                  </select> 
                </div> 
              </div>
            </div>
          </div>
        </div>
        <div class="product-wrapper-grid">
          <div class="row margin-res">
           @foreach($urunler as $entry)

           <div class="col-xl-3 col-6 col-grid-box">
            <div class="product-box">
              <div class="img-wrapper">
                <div class="front">
                  <a href="{{ route('urun', $entry->slug) }}"><img src="{{ $entry->gorsel_bul['gorsel'] }}" class="img-fluid blur-up lazyload bg-img" alt=""></a>
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
                 <a href="{{ route('urun', $entry->slug) }}" title="Çeşitleri Gör">
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
              <p>{!! $entry->detay_bul['aciklama_bir'] !!}</p>
              <h4>
               @if($entry->cesit_durum == 1)
               @if($entry->stok == 0)
               <span class="product-sale-label">Stokta Yok</span>
               @else
               {{ $entry->fiyat_bul['fiyat']}} {{ $paraSimge }} <del> {{ $entry->fiyat_bul['fiyat_onceki'] }} {{ $paraSimge }}</del> 
               @endif
               @else
               <a href="{{ route('urun', $entry->slug) }}" class="btn btn-solid btn-xs mt-2"  >Çeşitleri Gör</a>
               @endif
             </h4>
           </div>
         </div>
       </div>

       @endforeach

     </div>
   </div> 
   <div class="mt-4"> 
    @if($urunler != null)
    @if($filtreFiyat == "")
    @if(isset($gelenBaslangicFiyat))
    @if($gelenMarka !== Array() || $gelenEtiket !== Array())
    {{ $urunler->appends(['markalar' => $gelenMarka , 'etiketler' => $gelenEtiket , 'price_start' => $gelenBaslangicFiyat, 'price_finish' => $gelenBitisFiyat])->links() }}
    @else
    {{ $urunler->appends([ 'price_start' => $gelenBaslangicFiyat, 'price_finish' => $gelenBitisFiyat])->links() }}
    @endif 
    @else
    {{ $urunler->links() }}
    @endif
    @endif
    @if($filtreFiyat == "priceAsc")
    {{ $urunler->appends(['filterPrice'=> "priceAsc"])->links() }}
    @endif
    @if($filtreFiyat == "priceDesc")
    {{ $urunler->appends(['filterPrice'=> "priceDesc"])->links() }}
    @endif
    @endif 
  </div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
<!-- section End -->
@endsection