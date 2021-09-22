 @extends('tanitim.layouts.master')
 @section('js')
 <script type="text/javascript" src="{{ asset('/assets/js/ek-js/adres.js') }}"></script>
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
 <!-- section start -->
 <section class="section-b-space">
     <div class="container">
         <div class="row">
            @include('tanitim.hesabim.hesabimNavbar')
            <div class="col-lg-9 @auth add_address @endauth">
             <div class="dashboard-right">
                 <div class="row">
                     <div class="col-lg-3">
                         <div class="col-lg-12 mb-3">
                             <div class="card">
                                 <div type="button" class="card-body" data-bs-toggle="modal" data-bs-target="#exampleModall">
                                     <button style="background: white; border: solid white;" class="btn btn-light btn-block">+ Adres Ekle</button>
                                 </div>
                             </div>
                         </div>

                         <div class="modal fade" id="exampleModall" tabindex="-1" aria-labelledby="exampleModalLabell" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Adres Oluşturunuz</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <form class="theme-form" action="{{ route('adres.olustur')}}" method="post">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-row row">  
                                                <div class="col-md-6 mb-3">
                                                    <label for="name">Adres Başlığı<span style="color: red;">*</span></label>
                                                    <input type="text" maxlength="50" class="form-control" name="baslik" id="address-two" placeholder="Adres Başlığı"
                                                    required="">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="name">Ad Soyad<span style="color: red;">*</span></label>
                                                    <input type="text" maxlength="50" class="form-control" name="ad"  id="home-ploat" placeholder="Ad Soyad"
                                                    required="">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="email">Telefon Numaranız<span style="color: red;">*</span></label>
                                                    <input type="number"  maxlength="30" class="form-control" name="telefon" id="zip-code" placeholder="Telefon Numaranız"
                                                    required="">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="email">Mail<span style="color: red;">*</span></label>
                                                    <input type="email"  maxlength="100" class="form-control" name="mail" id="zip-code" placeholder="Mailiniz"
                                                    required>
                                                </div>
                                                <div class="col-md-6 ">
                                                    <label for="review">Ülke<span style="color: red;">*</span></label>
                                                    <input type="text" maxlength="50" class="form-control" name="ulke" id="zip-code" placeholder="Ülke" disabled value="Türkiye" >
                                                </div>
                                                <div class="col-md-6 mb-3 ">
                                                    <label for="review">İl<span style="color: red;">*</span></label>
                                                    <input type="text" maxlength="50" class="form-control" name="il"  id="home-ploat" placeholder="İl"
                                                    required="">
                                                </div>
                                                <div class="col-md-6 ">
                                                    <label for="review">İlçe<span style="color: red;">*</span></label>
                                                    <input type="text" maxlength="50" class="form-control" name="ilce"  id="home-ploat" placeholder="İlçe"
                                                    required="">
                                                </div>
                                                <div class="col-md-6  mb-3">
                                                    <label for="review">Mahalle<span style="color: red;">*</span></label>
                                                    <input type="text" maxlength="50" class="form-control" name="mahalle"  id="home-ploat" placeholder="Mahalle"
                                                    required="">
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="email">Kimlik No</label>
                                                    <input type="text" maxlength="50" class="form-control" name="kimlik_no" minlength="6" id="zip-code" placeholder="Kimlik No">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="email">Posta Kodu</label>
                                                    <input type="text" maxlength="30" class="form-control" name="postakodu" id="zip-code" placeholder="Posta Kodu"
                                                    >
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="email">Adres<span style="color: red;">*</span></label>
                                                    <textarea class="form-control" maxlength="500" name="adres" id="zip-code" placeholder="Tam Adres"
                                                    required=""></textarea>
                                                </div>
                                                <div  id="kurumsal_var" style="display: none;">
                                                    <hr>
                                                    <div class="col-md-12">
                                                        <label for="firmaAd">Firma Adı<span style="color: red;">*</span></label>
                                                        <input id="firmaAd" required  class="form-control" name="firma_adi" type="text">
                                                    </div>   
                                                    <div class="col-md-12">
                                                        <label for="vergiNo">Vergi Numarası<span style="color: red;">*</span></label>
                                                        <input id="vergiNo"  required class="form-control" name="vergi_numarasi" type="text">
                                                    </div>   
                                                    <div class="col-md-12 mb-4">
                                                        <label for="vergiDaire">Vergi Dairesi<span style="color: red;">*</span></label>
                                                        <input id="vergiDaire"  required class="form-control" name="vergi_dairesi" type="text">
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-1 mt-1">
                                                            <input type="checkbox" value="1"  name="eFatura" id="efatura" style="float: left; width: 50px; margin-left: -25px;">  
                                                        </div>
                                                        <div class="col-8">
                                                            <label for="efatura" style="margin-left: -10px;">E-fatura mükellefiyim</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label><b>*Firma adresiniz yukardaki adres olarak olacaktır</b></label>
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="modal-footer"> 
                                            <div class="row">
                                                <div class="col-12 mt-1">
                                                    <input type="checkbox" id="kurumsal" value="1" onchange="kurumsalMusteri()" name="" style="width: 50px;">  

                                                    <label for="kurumsal"> Kurumsal Müşteriyim</label>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-secondary  btn-sm btn-solid" data-bs-dismiss="modal">Kapat</button>
                                            <button class="btn btn-sm btn-solid" type="submit">Kaydet</button>
                                        </div>

                                    </form> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">

                 @foreach($adresler as $adres)
                 @if(isset($adres))
                 <div class="col-lg-4 mb-3">
                     <div class="card">
                         <div class="close-circle" style="margin-left: 305px; ">
                             <a href="{{route('adres.sil', $adres->id)}}"><i class="fa fa-times" style="color: black;" aria-hidden="true"></i></a>
                         </div>
                         <div class="card-body">
                             <h5 class="card-title">{{$adres->baslik}}</h5>
                             <p class="card-title-desc" style="min-height: 85px;">{{$adres->adres}}</p>
                         </div>
                         <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModalll{{$adres->id}}" class="btn btn-solid btn-block">Güncelle</button>
                         <div class="modal fade" id="exampleModalll{{$adres->id}}" tabindex="-1" aria-labelledby="exampleModalLabelll{{$adres->id}}" aria-hidden="true">
                             <div class="modal-dialog">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                         <h5 class="modal-title" id="exampleModalLabelll{{$adres->id}}">Adres Oluşturunuz</h5>
                                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                     </div>

                                     <form class="theme-form" action="{{route('adres.guncelle', $adres->id)}}" method="post">
                                         @csrf
                                         <div class="modal-body">
                                             <div class="form-row row">
                                                 <div class="col-md-6">
                                                     <label for="name">Adres Başlığı</label>
                                                     <input type="text" maxlength="50" class="form-control" name="baslik" id="address-two" placeholder="Adres Başlığı" required="" value="{{$adres->baslik}}">
                                                 </div>
                                                 <div class="col-md-6">
                                                     <label for="name">Ad Soyad</label>
                                                     <input type="text" class="form-control" name="ad" id="home-ploat" placeholder="Ad Soyad" required="" value="{{$adres->isim}}">
                                                 </div>

                                                 <div class="col-md-6">
                                                    <label for="email">Mail<span style="color: red;">*</span></label>
                                                    <input type="email"  maxlength="100" class="form-control" name="mail" id="zip-code" value="{{$adres->mail}}"  placeholder="Mailiniz"
                                                    required>
                                                </div>
                                                <div class="col-md-6">
                                                 <label for="email">Telefon Numaranız</label>
                                                 <input type="number" class="form-control" name="telefon" id="zip-code" placeholder="Telefon Numaranız" required="" value="{{$adres->telefon}}">
                                             </div>
                                             <div class="col-md-6 select_input">
                                                 <label for="review">Ülke</label>
                                                 <input type="text" class="form-control" name="ulke" id="home-ploat" placeholder="Ülke" required="" disabled value="Türkiye">
                                             </div>
                                             <div class="col-md-6 select_input">
                                                 <label for="review">İl</label>
                                                 <input type="text" class="form-control" name="il" id="home-ploat" placeholder="İl" required="" value="{{$adres->il}}">
                                             </div>
                                             <div class="col-md-6 select_input">
                                                 <label for="review">İlçe</label>
                                                 <input type="text" class="form-control" name="ilce" id="home-ploat" placeholder="İlçe" required="" value="{{$adres->ilce}}">
                                             </div>
                                             <div class="col-md-6 select_input">
                                                 <label for="review">Mahalle</label>
                                                 <input type="text"  class="form-control" name="mahalle" id="home-ploat" placeholder="Mahalle" required="" value="{{$adres->mahalle}}">
                                             </div>
                                             <div class="col-md-6">
                                                 <label for="email">Kimlik No</label>
                                                 <input type="text" maxlength="30" minlength="6" class="form-control"     name="kimlik_no" id="zip-code" placeholder="Kimlik No" value="{{$adres->kimlik_no}}">
                                             </div>
                                             <div class="col-md-6">
                                                 <label for="email">Posta Kodu</label>
                                                 <input type="text" class="form-control" name="postakodu" id="zip-code" placeholder="Posta Kodu" maxlength="30" value="{{$adres->postakodu}}">
                                             </div> 
                                             <div class="col-md-12">
                                                 <label for="email">Adres</label>
                                                 <textarea class="form-control" maxlength="500" name="adres" id="zip-code" placeholder="Tam Adres" required="">{{$adres->adres}}</textarea>
                                             </div>

                                             @if($adres->kurumsal_mi == 1)
                                             <hr>
                                             <div class="col-md-12">
                                                <label for="firmaAd">Firma Adı</label>
                                                <input id="firmaAd" required  class="form-control" value="{{$adres->adres_kurumsal_getir['firma_adi']}}" name="firma_adi" type="text">
                                            </div>   
                                            <div class="col-md-12">
                                                <label for="vergiNo">Vergi Numarası</label>
                                                <input id="vergiNo"  required class="form-control" value="{{$adres->adres_kurumsal_getir['vergi_numarasi']}}" name="vergi_numarasi" type="text">
                                            </div>   
                                            <div class="col-md-12 mb-4">
                                                <label for="vergiDaire">Vergi Dairesi</label>
                                                <input id="vergiDaire" value="{{$adres->adres_kurumsal_getir['vergi_dairesi']}}" required class="form-control" name="vergi_dairesi" type="text">
                                            </div>
                                            <div class="row">
                                                <div class="col-1 mt-1">
                                                    <input type="checkbox" value="1" @if($adres->adres_kurumsal_getir['eFatura']== 1) checked @endif name="eFatura" id="efatura2" style="float: left; width: 50px; margin-left: -25px;">  
                                                </div>
                                                <div class="col-8">
                                                    <label for="efatura2" style="margin-left: -10px;">E-fatura mükellefiyim</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label><b>*Firma adresiniz yukardaki adres olarak kalacaktır</b></label>
                                            </div>
                                            @endif 

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary  btn-sm btn-solid" data-bs-dismiss="modal">Kapat</button>
                                        <button class="btn btn-sm btn-solid" type="submit">Kaydet</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif 
            @endforeach
        </div> <!-- end row -->

    </div>
</div>
</div>
</section>
<!-- section end -->
@endsection