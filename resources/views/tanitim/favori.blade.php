@extends('tanitim.layouts.master')
@section('js')
<script type="text/javascript">
    function favoriSil(id){  
        $.ajax({
            type:'GET',
            url:'/favorite/remove/'+id,
            success:function() { 
                document.getElementById('favorilerSil'+id).remove();
            }
        });

    }
</script>
@endsection
@section('content')
<section class="section-b-space ratio_asos j-box pets-box ratio_square">
    <div class="collection-wrapper">
        <div class="container">
            <div class="row">
                <div class="collection-content col">
                    <div class="page-main-content">
                        <div class="row">
                            <div class="col-sm-12"> 
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
                                              <h5>Bulunan Ürün Sayısı: {{$favoriler->count()}}</h5>
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-wrapper-grid">
                    <div class="row margin-res">
                        @foreach($favoriler as $entry)  
                        <div class="col-xl-3 col-6 col-grid-box" id="favorilerSil{{$entry->id}}">
                            <div class="product-box">
                                <div class="img-wrapper">
                                    <div class="front">
                                        <a href="{{ route('urun', $entry->favoriden_urun_bul->slug) }}">
                                            <img src="{{$entry->favoriden_urun_bul->urun_gorsel_bul['gorsel']}}" class="img-fluid blur-up lazyload bg-img" alt="">
                                        </a>
                                    </div> 
                                    <div class="cart-info cart-wrap">
                                        @if($entry->stok > 0)
                                        @if($entry->cesit_durum == 1)
                                        <a onclick="sepet({{$entry->favoriden_urun_bul['id']}});" title="Sepete Ekle">
                                            <i class="ti-shopping-cart"></i>
                                        </a>
                                        @endif
                                        @endif 
                                        <a  onclick="favoriSil({{$entry['id']}})" title="Favoriden Kaldır">
                                            <i class="ti-close" aria-hidden="true"></i>
                                        </a>
                                        @if($entry->cesit_durum == 0)
                                        <a href="{{ route('urun', $entry->slug) }}"   title="Çeşitleri Gör">
                                            <i class="ti-eye" aria-hidden="true"></i>
                                        </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="product-detail">
                                    <div>
                                       <div class="rating-section">
                                        @php
                                        $dolu = round($entry->favoriden_urun_bul->urun_analiz_bul['ortalama_puan']);
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
                                    <a href="{{ route('urun', $entry->favoriden_urun_bul->slug) }}">
                                        <h6>{{ $entry->favoriden_urun_bul->urun_detay_bul['ad'] }}</h6>
                                    </a>
                                    <p>{!! $entry->favoriden_urun_bul->urun_detay_bul['aciklama_bir'] !!}</p>
                                    <h4>
                                       <h4>
                                         @if($entry->cesit_durum == 1)
                                         @if($entry->stok == 0)
                                         <span class="product-sale-label">Stokta Yok</span>
                                         @else
                                         {{ $entry->favoriden_urun_bul->fiyat_bul['fiyat']}} <del> {{ $entry->favoriden_urun_bul->fiyat_bul['fiyat_onceki'] }}</del> 
                                         @endif
                                         @else
                                         <a href="{{ route('urun', $entry->slug) }}" class="btn btn-solid btn-xs mt-2"  >Çeşitleri Gör</a>
                                         @endif
                                     </h4>
                                 </h4>
                             </div>
                         </div>
                     </div>
                 </div>  
                 @endforeach
             </div>
         </div>
     </div>
 </div>
</div>
</div>
</div>
</div>
</section>
@endsection