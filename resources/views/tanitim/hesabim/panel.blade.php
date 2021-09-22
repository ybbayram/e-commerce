 @extends('tanitim.layouts.master')
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
          <div class="col-lg-9">
             <div class="dashboard-right">
                <div class="dashboard">
                   <div class="page-title">
                      <h2>Hesabım</h2>
                   </div>
                   <div class="welcome-msg">
                      <p>Merhaba, @auth{{ Auth::user()->ad}}@endauth @guest ziyaretçi @endguest</p>
                      @guest
                      <p>
                         PetHepsi’ ye Hoşgeldiniz, Hesabım sayfasından siparişlerinizi görüntüleyebilir, adres bilgilerinizi güncelleyebilir, favorilerim menüsüne girerek favori ürünlerinizi listeleyebilirsiniz.
                      </p><br>
                      <p>
                         Güncel kampanya detayları ve yeni ürünlerimizden haberdar olmak isterseniz <a href="/">www.pethepsi.com</a> adresini ziyaret edebilir veya mobil uygulamamızı İOS - Android mobil işletim sistemleri resmi mağazalarından PetHepsi adını aratarak indirebilirsiniz. Ayrıca sosyal medya hesaplarımızı takip ederek güncel kampanyalardan haberdar olabilir ve anlık çekiliş fırsatlardan yararlanabilirsiniz😊
                      </p>
                      @endguest
                      @auth
                      <p>
                         PetHepsi’ ye Hoşgeldiniz, Hesabım sayfasından siparişlerinizi görüntüleyebilir, adres bilgilerinizi güncelleyebilir, favorilerim menüsüne girerek favori ürünlerinizi listeleyebilirsiniz.
                      </p><br>
                      <p>
                         Güncel kampanya detayları ve yeni ürünlerimizden haberdar olmak isterseniz <a href="/">www.pethepsi.com</a> adresini ziyaret edebilir veya mobil uygulamamızı İOS - Android mobil işletim sistemleri resmi mağazalarından PetHepsi adını aratarak indirebilirsiniz. Ayrıca sosyal medya hesaplarımızı takip ederek güncel kampanyalardan haberdar olabilir ve anlık çekiliş fırsatlardan yararlanabilirsiniz😊
                      </p>
                      @endauth

                   </div>
                   @auth
                   <div class="box-account box-info">
                      <div class="box-head">
                         <h2>Hesap Bilgileri</h2>
                      </div>
                      <div class="row">
                         <div class="col-sm-12">
                            <div class="box">
                               <div class="box-title">
                                  <h3>İletişim bilgileri</h3>
                               </div>
                               <div class="box-content">
                                  <h6> {{ Auth::user()->ad}}</h6>
                                  <h6> {{ Auth::user()->email}}</h6>
                                  <h6><a href="{{route('hesabim.sifreDegis.sayfa')}}">Şifre Değiştir</a></h6>
                               </div>
                            </div>
                         </div>
                      </div>
                   </div>
                   @endauth

                </div>
             </div>
          </div>
       </div>
 </section>
 <!-- section end -->
 @endsection