@extends('tanitim.layouts.master') 
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
                                        <div class="container-fluid p-0">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="product-filter-content">
                                                        <div class="search-count">
                                                            <h5>Bulunan Ürün Sayısı: @if($urunler != null) {{ $urunler->total() }} @else 0 @endif</h5>
                                                        </div>
                                                        <div class="collection-view">
                                                            <ul>
                                                                <li>
                                                                    <i class="fa fa-th grid-layout-view"></i>
                                                                </li>
                                                                <li>
                                                                    <i class="fa fa-list-ul list-layout-view"></i>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="collection-grid-view">
                                                            <ul>
                                                                <li>
                                                                    <img src="/assets/images/icon/2.png" alt="" class="product-2-layout-view">
                                                                </li>
                                                                <li>
                                                                    <img src="/assets/images/icon/3.png" alt="" class="product-3-layout-view">
                                                                </li>
                                                                <li>
                                                                    <img src="/assets/images/icon/4.png" alt="" class="product-4-layout-view">
                                                                </li>
                                                                <li>
                                                                    <img src="/assets/images/icon/6.png" alt="" class="product-6-layout-view">
                                                                </li>
                                                            </ul>
                                                        </div>

                                                        @php $urlSlug = "search"; @endphp
                                                        <div class="product-page-filter">
                                                            <select name="filtreFiyat" id="filtreGetir" onchange="filtreFiyatgetir('{{$aranan}}','{{$urlSlug}}')">
                                                              <option value="">Ürün Sırala</option>
                                                              <option value="artan" id="artan">Fiyata Göre Artan</option>
                                                              <option value="azalan" id="azalan">Fiyata Göre Azalan</option>
                                                          </select> 
                                                      </div> 
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
                                                        <a href="{{ route('urun', $entry->slug) }}">
                                                            <img src="{{$entry->gorsel_bul['gorsel']}}" class="img-fluid blur-up lazyload bg-img" alt="">
                                                        </a>
                                                    </div> 
                                                    <div class="cart-info cart-wrap">
                                                        @if($entry->stok > 0)
                                                        @if($entry->cesit_durum == 1)
                                                        <a href="{{ route('sepete.ekle', $entry->id) }}" title="Add to cart">
                                                            <i class="ti-shopping-cart"></i>
                                                        </a>
                                                        @endif
                                                        @endif

                                                        <a href="{{ route('favori.ekle', $entry->id) }}" title="Add to Wishlist">
                                                            <i class="ti-heart" aria-hidden="true"></i>
                                                        </a>
                                                        @if($entry->cesit_durum == 0)
                                                        <a href="{{ route('urun', $entry->slug) }}" data-bs-toggle="modal" data-bs-target="#quick-view{{$entry->id}}" title="Çeşitleri Gör">
                                                            <i class="ti-eye" aria-hidden="true"></i>
                                                        </a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="product-detail">
                                                    <div>
                                                        <div class="rating">
                                                            <i class="fa fa-star"></i> 
                                                            <i class="fa fa-star"></i> 
                                                            <i class="fa fa-star"></i> 
                                                            <i class="fa fa-star"></i> 
                                                            <i class="fa fa-star"></i>
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
                                                           {{ $entry->fiyat_bul['fiyat']}} <del> {{ $entry->fiyat_bul['fiyat_onceki'] }}</del> 
                                                           @endif
                                                           @else
                                                           <a href="{{ route('urun', $entry->slug) }}" class="btn btn-solid btn-xs mt-2"  >Çeşitleri Gör</a>
                                                           @endif
                                                       </h4>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                       @endforeach
                                   </div>
                               </div>
                               <div class="mt-4">
                                @if($urunler != null)
                                  @if($filtreFiyat == "")
                                  {{ $urunler->links() }}
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
  </section>

  @endsection