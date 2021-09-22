@php
use App\Models\Yorum;
use App\Models\Siparis;

$yorumSay= Yorum::where('durum', 0)->get();
$yorumCount = $yorumSay->count();
$siparisSay= Siparis::where('islem_durum', 1)->get();
$siparisCount = $siparisSay->count();
@endphp
<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li>
                    <a href="{{ route('admin.index') }}" class="waves-effect">
                        <i class="dripicons-home"></i>
                        <span>Anasayfa</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.dil') }}" class=" waves-effect">
                        <i class="dripicons-flag"></i>
                        <span>Dil</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.ulke') }}" class=" waves-effect">
                        <i class="mdi mdi-flag"></i>
                        <span>Ülke</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.kategori')}}" class="waves-effect">
                        <i class="dripicons-arrow-right"></i>
                        <span>Kategori Yapısı</span>
                    </a>    
                </li>                
                <li>
                    <a href="{{ route('admin.etiket') }}" class=" waves-effect">
                        <i class="dripicons-tags"></i>
                        <span>Etiket</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.filtre') }}" class=" waves-effect">
                        <i class="mdi mdi-image-filter-center-focus"></i>
                        <span>Filtre</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.marka') }}" class=" waves-effect">
                        <i class="dripicons-star"></i>
                        <span>Marka</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.urun') }}" class=" waves-effect">
                        <i class="dripicons-jewel"></i>
                        <span>Ürün</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="dripicons-broadcast"></i>
                        <span>Kampanyalar</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.camp.index')}}">- Kampanya Seç</a></li>
                        <li><a href="{{route('admin.kargo')}}">- Kargo İndirimi</a></li>
                        <li><a href="{{route('admin.sepetIndirim')}}">- Sepette İndirim </a></li>
                        <li><a href="{{route('admin.xAlyOde')}}">- X al Y öde </a></li>
                        <li><a href="{{route('admin.promosyon')}}">- Promosyon </a></li>
                        <li><a href="{{route('admin.kupon')}}">- Kupon</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="dripicons-mail"></i>
                        <span>Mail Yönetimi</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.mailGruplari') }}">- Mail Grupları</a></li>
                        <li><a href="{{ route('admin.mailPlanla') }}">- Mail Planla</a></li>
                        <li><a href="{{ route('admin.mailGonder') }}">- Mail Gönder</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{route('admin.siparis')}}" class=" waves-effect">
                        <i class="dripicons-basket"></i>
                        <span class="badge badge-success float-right">{{$siparisCount}}</span>
                        <span>Sipariş</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="has-arrow  waves-effect">
                        <i class="dripicons-swap"></i>
                        <span>İade</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false"> 
                        <li><a href="{{route('admin.iade.sorular')}}">- Sorular</a></li>
                        <li><a href="{{route('admin.iade.iadeler')}}">- İadeler</a></li>
                        <li><a href="{{route('admin.iade.onaylanmis.iadeler')}}">- Onaylanmış İadeler</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" class="has-arrow  waves-effect">
                        <i class="dripicons-graph-line"></i>
                        <span>Analiz</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="#">- Sepetler</a></li>
                        <li><a href="#">- Favoriler </a></li>
                        <li><a href="#">- Site Analizi</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{route('admin.user')}}" class=" waves-effect">
                        <i class="dripicons-user"></i> 
                        <span>Üyeler</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.yorum') }}" class=" waves-effect">
                        <i class="dripicons-pencil"></i>
                        <span class="badge badge-success float-right">{{$yorumCount}}</span>
                        <span>Yorum</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.tedarikci') }}" class=" waves-effect">
                        <i class="dripicons-store"></i>
                        <span class="badge badge-success float-right"></span>
                        <span>Tedarikçi</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="has-arrow  waves-effect">
                        <i class="dripicons-monitor"></i>
                        <span>Tasarım</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.site.slider')}}">- Slider</a></li>
                        <li><a href="{{route('admin.site.banner')}}">- Banner</a></li>
                        <li><a href="{{route('admin.site.banner2')}}">- Banner 2</a></li>
                        <li><a href="{{route('admin.sss')}}">- SSS</a></li>
                        <li><a href="{{route('admin.sozlesme')}}">- Sözleşmeler</a></li>
                        <li><a href="{{route('admin.oneCikanlar')}}">- Öne Çıkar</a></li>

                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" class="has-arrow  waves-effect">
                        <i class="dripicons-user-group"></i>
                        <span>Etkileşim</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.bulten')}}">- Bülten</a></li>
                        <li><a href="#">- Anketler</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" class="has-arrow  waves-effect">
                        <i class="dripicons-gear"></i>
                        <span>Ayarlar</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.kargolar')}}">- Kargo</a></li>
                        <li><a href="{{route('admin.site.iletisim')}}">- İletişim</a></li>
                        <li><a href="{{route('admin.site.medya')}}">- Sosyal Medya </a></li>
                    </ul>
                </li>



            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->