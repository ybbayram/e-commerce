<style type="text/css">
@media screen and (max-width: 399px) {
 .logo-mobil {
     height: 50px;
 }
}

@media screen and (min-width: 400px) {
 .logo-mobil {
     height: 70px;
 }
}
</style>
<div class="loader_skeleton">
 <header class="header-style-5 color-style">
     <div class="top-header top-header-theme">
         <div class="container">
             <div class="row">
                 <div class="col-lg-6">
                     <div class="header-contact">
                         <ul>
                             @if(isset($iletisim))
                             <li><a href="mailto:info@pethepsi.com"><i class="fa fa-envelope-o" aria-hidden="true"></i>{{$iletisim->mail}}</a></li>
                             <li><a href="tel:533-202-32-45"><i class="fa fa-phone" aria-hidden="true"></i>{{$iletisim->telefon}}</a></li>
                             @endif
                         </ul>
                     </div>
                 </div>
                 <div class="col-lg-6">
                     <div class="header-contact text-end">
                         <ul>
                             <li><i class="fa fa-truck" aria-hidden="true"></i> Kargo Takip</li>
                             @auth
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
                             <img src="/assets/images/logo1.png" class="img-fluid blur-up lazyload logo-mobil" alt="">
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
                                             <img style="width: 25px;" src="/assets/images/icon/search.png" class="img-fluid blur-up lazyload" alt="">
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
                                         <span class="cart_qty_cls" id="urunAdetToplam"></span>
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
                                     <div class="mobile-back text-end">Kapat<i class="fa fa-angle-right ps-2" aria-hidden="true"></i>
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
</div>
<!-- header start -->
<header class="header-style-5 color-style">
 <div class="mobile-fix-option"></div>
 <div class="top-header top-header-theme">
     <div class="container">
         <div class="row">
             <div class="col-lg-6">
                 <div class="header-contact">
                     <ul>
                         @if(isset($iletisim))
                         <li><a href="mailto:info@pethepsi.com"><i class="fa fa-envelope-o" aria-hidden="true"></i>{{$iletisim->mail}}</a></li>
                         <li><a href="tel:533-202-32-45"><i class="fa fa-phone" aria-hidden="true"></i>{{$iletisim->telefon}}</a></li>
                         @endif
                     </ul>
                 </div>
             </div>
             <div class="col-lg-6">
                 <div class="header-contact text-end">
                     <ul>

                         <li><a href="#" style="color: white;"><i class="fa fa-truck" aria-hidden="true"></i>
                         Kargo Takip</a></li>
                         @auth
                         <li><a href="{{route('hesabim.siparislerim')}}" style="color: white;"><i class="fa fa-gift" aria-hidden="true"></i>
                         Siparişlerim</a></li>
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
                         <img src="/assets/images/logo1.png" class="img-fluid blur-up lazyload logo-mobil" alt="">
                     </a>

                 </div>
                 <div>
                     <form class="form_search ajax-search the-basics" action="{{ route('search') }}" role="form" method="post">
                         @csrf
                         <input type="search" placeholder="Ürün arayınız..." class="nav-search nav-search-field typeahead" name="aranan" aria-expanded="true">
                         <button type="submit" name="nav-submit-button" class="btn-search">
                             <i class="ti-search"></i>
                         </button>
                     </form>
                 </div>
                 <div class="menu-right pull-right">
                     <nav class="text-start">
                         <div class="toggle-nav">
                             <i class="fa fa-bars sidebar-bar"></i>
                         </div>
                     </nav>
                     <div class="icon-nav">
                         <ul class="onhover-div ">
                             <li class="mobile-user">
                                 <div>
                                     <a href="javascript::void(0)">
                                         <img style="width: 25px;" src="/assets/images/icon/user-1.png" alt="">
                                         <i class="ti-user"></i>
                                     </a>
                                 </div>
                                 <div class="show-div setting">
                                     @guest
                                     <ul>
                                         <li><a href="{{ route('hesabim.panel') }}"> Hesabım</a></li>
                                         <li><a href="{{route('loginSayfa')}}">Giriş Yap</a></li>
                                         <li><a href="{{route('loginSayfa')}}">Kayıt Ol</a></li>
                                     </ul>
                                     @endguest
                                     @auth
                                     <ul>
                                         <li><a href="{{ route('hesabim.panel') }}"><i class="fa fa-user" style="color:#b2b2b2;"></i> Hesabım</a></li>
                                         <li><a href="{{ route('hesabim.siparislerim') }}"><i class="fa fa-shopping-cart" style="color:#b2b2b2;"></i> Siparişlerim</a></li>
                                         <li><a href="{{ route('cikisYap') }}"><i class="fa fa-times" style="color:#b2b2b2;"></i> Çıkış Yap</a></li>
                                     </ul>
                                     @endauth
                                 </div>
                             </li>
                         </ul>
                     </div>
                     <div class="top-header d-block">
                         <ul class="header-dropdown">
                             <li class="mobile-wishlist" id="mobile-wishlist">
                                 <a href="{{ route('favori') }}">
                                     <img style="width: 25px;" src="/assets/images/icon/heart-1.png" alt="">
                                 </a>
                             </li>
                         </ul>
                     </div>

                     <div>
                         <div class="icon-nav">
                             <ul>
                                 <li class="onhover-div d-xl-none d-inline-block mobile-search">
                                     <div>
                                         <img src="/assets/images/icon/search.png " onclick="openSearch()" class="img-fluid blur-up lazyload" alt="">
                                         <i class="ti-search" onclick="openSearch()"></i>
                                     </div>
                                     <div id="search-overlay" class="search-overlay">
                                         <div>
                                             <span class="closebtn" onclick="closeSearch()" title="Close Overlay">×</span>
                                             <div class="overlay-content">
                                                 <div class="container">
                                                     <div class="row">
                                                         <div class="col-xl-12">
                                                             <form class="ajax-search" action="{{ route('search') }}" role="form" method="post">
                                                                 @csrf
                                                                 <div class="form-group the-basics">
                                                                     <input type="text" name="aranan" class="form-control typeahead" id="exampleInputPassword1" placeholder="Ürün arayınız...">
                                                                 </div>
                                                                 <button type="submit" class="btn btn-primary">
                                                                     <i class="fa fa-search"></i>
                                                                 </button>
                                                             </form>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </li>
                                 <li class="onhover-div mobile-setting">
                                     <div>
                                         <img style="width: 25px;" src="/assets/images/icon/setting.png" class="img-fluid blur-up lazyload" alt="">
                                         <i class="ti-settings"></i>
                                     </div>
                                     <div class="show-div setting">
                                         <h6>Dil</h6>
                                         <ul>
                                             @foreach($menuDil as $dil)
                                             <li><a href="#">{{$dil->ad}}</a> </li>
                                             @endforeach

                                         </ul>
                                     </div>
                                 </li>
                                 <li class="onhover-div mobile-cart">
                                     <div>
                                         <a href="javascript::void(0)">
                                             <img style="width: 25px;" src="/assets/images/icon/cart.png" class="img-fluid blur-up lazyload" alt="">
                                             <i class="ti-shopping-cart"></i>
                                         </a>
                                     </div> 
                                     <span class="cart_qty_cls" id="urunAdetToplamNavbar">0</span>
                                     <ul class="show-div shopping-cart">
                                        <li id="sepetNavUrun"></li>
                                        <li id="sepetNavUrunToplam"></li>
                                    </ul>
                                    
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
         <div class="col-xxl-6 col-xl-9 position-unset">
             <div class="main-nav-center">
                 <nav class="text-start">
                     <!-- Sample menu definition -->
                     <ul id="main-menu" class="sm pixelstrap sm-horizontal">
                         <li>
                             <div class="mobile-back text-end">Kapat
                                 <i class="fa fa-angle-right ps-2" aria-hidden="true"></i>
                             </div>
                         </li>
                         @foreach($kategoriler as $kategori)
                         @php if(isset($kategori->kategori_alt_getir[0])){ @endphp
                         <li>
                             <a href="{{ route('shop.kategori', $kategori->slug) }}">{{ $kategori->kategori_dil_getir['ad'] }}</a>
                             <ul>
                                 @foreach($kategori->kategori_alt_getir as $entry)
                                 <li>
                                     <a href="{{ route('shop.kategoriAlt', ['kategori' => $kategori->slug, 'kategoriAlt' => $entry->slug]) }}">
                                         {{$entry->kategori_dil_getir['ad']}}
                                     </a>
                                     @php if(isset($entry->kategori_alt_getir[0])){ @endphp
                                     <ul>
                                         @foreach($entry->kategori_alt_getir as $entryTwo)
                                         <li>
                                             <a href="{{ route('shop.kategoriAlt', ['kategori' => $kategori->slug, 'kategoriAlt' => $entryTwo->slug]) }}">
                                                 {{$entryTwo->kategori_dil_getir['ad']}}
                                             </a>
                                         </li>
                                         @endforeach
                                     </ul>
                                     @php }else{ }@endphp
                                 </li>
                                 @endforeach

                             </ul>

                             @php }else{ @endphp
                             <li>
                                 <a href="{{ route('shop.kategori', $kategori->slug) }}">{{ $kategori->kategori_dil_getir['ad'] }}</a>
                             </li>
                             @php } @endphp
                         </li>
                         @endforeach
                     </li>
                 </ul>
             </nav>
         </div>
     </div>
     <div class="col-xxl-3 d-none d-xxl-inline-block">
         <div class="header-options">
             <div class="vertical-slider no-arrow">
                 <div>
                     <span><i class="ti-truck" aria-hidden="true"></i>100 TL ÜZERİ KARGO ÜCRETSİZ</span>
                 </div>
             </div>
         </div>
     </div>
 </div>
</div>
</div>
</header>
 <!-- header end -->