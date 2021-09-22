<!-- footer section start -->
<footer class="dark-footer footer-style-1 footer-theme-color">
    <section class="section-b-space darken-layout">
        <div class="container">
            <div class="row footer-theme partition-f">
                <div class="col-lg-4 col-md-6 sub-title">
                    <div class="footer-title footer-mobile-title">
                        <h4>Hakkımızda</h4>
                    </div>
                    <div class="footer-contant">
                        <div class="footer-logo">
                            <img src="/assets/images/logo1.png" style="height: 70px;" alt="">
                        </div>
                        <p>Sizi PetHepsi ile tanıştırmak isteriz. PetHepsi sizin gibi can dostları olup onlar için her şeyi düşünen sahiplerinin rahat alışveriş yapabilmesi için tasarlanmış bir uygulamadır. Bu uygulama üzerinden can dostlarınız için aradığınız her ürüne ulaşıp satın alabilirsiniz.</p>
                        <div class="footer-logo mt-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <a target="_blank" href="https://apps.apple.com/us/app/pethepsi/id1583389018" ><img width="130" src="/assets/images/Appstore.png"></a>

                                    <a target="_blank" href="https://play.google.com/store/apps/details?id=com.pethepsi.alisveris2021"><img width="130"  src="/assets/images/Googleplay.png"></a>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="sub-title">
                        <div class="footer-title">
                            <h4>Sözleşmeler</h4>
                        </div>
                        <div class="footer-contant">
                            <ul>
                                @foreach($sozlesmeler as $entry)
                                <li><a href="{{route('sozlesmeler', $entry->slug)}}">{{$entry->sozlesme_dil_getir['baslik']}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="sub-title">
                        <div class="footer-title">
                            <h4>Kolay Erişim</h4>
                        </div>
                        <div class="footer-contant">
                            <ul>
                                <li><a href="{{route('sss')}}">Sıkça Sorulan Sorular</a></li>
                                <li><a href="#">İndirimli Ürünler</a></li>
                                <li><a href="#">Çok Satanlar</a></li>
                                <li><a href="#">PetPuan</a></li>
                                <li><a href="{{route('tanitim.about')}}">Hakkımızda</a></li>
                                <li><a href="#">İletişim</a></li>
                            </ul>
                        </div>
                    </div> 
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="sub-title">
                        <div class="footer-title">
                            <h4>Bize Ulaşın</h4>
                        </div>
                        <div class="footer-contant">
                            <p class="mb-cls-content">Bültenimize kayıt olarak PetHepsi fırsatlarını kaçırmayın.</p>
                            <form class="form-inline" action="{{route('bulten')}}" method="post">
                                @csrf
                                <div class="form-group me-sm-3 mb-2">
                                    <label for="inputPassword2" class="sr-only">E-Posta</label>
                                    <input type="email" class="form-control" name="mail" placeholder="E-posta adresinizi girin...">
                                </div>
                                <button type="submit" class="btn btn-solid mb-2">Katıl</button>
                            </form>
                            <ul class="contact-list mb-3">
                                @if(isset($iletisim))

                                <li><i class="fa fa-map-marker"></i>{!!$iletisim->adres!!}</li>
                                <li><i class="fa fa-phone"></i>{{$iletisim->telefon}}</li>
                                <li><i class="fa fa-envelope-o"></i>{{$iletisim->mail}}</li>
                                @endif 
                            </ul>
                        </div>
                        <div class="footer-social mt-4">
                            <ul>
                                @php 
                                $sosyal = ['instagram', 'facebook', 'twitter', 'linkedin', 'youtube', 'pinterest'];
                                @endphp
                                @foreach($sosyal as  $sos)
                                @if(isset($sosyalMedya->$sos))
                                <li><a target="_blank" href="{{$sosyalMedya->$sos}}"><i class="fa fa-{{$sos}}" aria-hidden="true"></i></a></li>
                                @endif
                                @endforeach
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="sub-footer dark-subfooter">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-md-6 col-sm-12">
                    <div class="footer-end">
                        <p><i class="fa fa-copyright" aria-hidden="true"></i> <a href="https://digico.com.tr/" target="_blank" class="beyaz">Digico Yazılım</a></p>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6 col-sm-12">
                    <div class="payment-card-bottom">
                        <ul>
                            <li>
                                <a href="javascript:void(0)"><img src="/assets/images/icon/visa.png" alt=""></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- footer section end -->


<!-- cookie bar star --> 
<div class="cookie-bar left-bottom" id="gizleCookie" >
    <img src="/assets/svg/cookie.svg" class="img-fluid" alt="cookie">
    <p>Size daha iyi bir alışveriş deneyimi sunabilmek için çerezler kullanıyoruz. Detaylı bilgi için
        @foreach($sozlesmelerCookie as $cookie) 
        <a target="_blank" href="{{route('sozlesmeler', $cookie->slug)}}">{{$cookie->sozlesme_dil_getir['baslik']}}</a> @if($sozlesmelerCookie->last() !== $cookie), @endif
    @endforeach   hakkında açıklama metnini inceleyebilirsiniz.</p>
    <a href="javascript:void(0)" onclick="cookieFonksiyon()"  class="btn btn-solid btn-xs">Kabul Ediyorum</a>
    <a href="javascript:void(0)" onclick="cookieFonksiyon()"  class="btn-close"><i class="fa fa-times" aria-hidden="true"></i></a>
</div> 
<!--cookie bar end -->
@guest 
<!-- Add to cart modal popup start-->
<div class="modal fade bd-example-modal-lg" id="addtofavori" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="background-color: transparent; border: solid transparent;"> 
         <section class="login-page section-b-space">
            <div class="container">
                <div class="row">
                    <div id="login-form" class="login-page">
                        <div class="form-box" style="box-shadow:0 0 0 0px ;">
                            <button type="button" style="float:right;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                            </button> 
                            <div class="button-box">
                                <div id="btn"></div>
                                <button type="button" onclick='login()' class="toggle-btn" >Giriş Yap</button>
                                <button type="button" onclick='register()' class="toggle-btn">Kayıt ol</button>
                            </div>

                            <!--Login form-->

                            <form action="{{ route('login') }}" method="post" id="login" class="input-group-login">
                                @csrf
                                <input type="email" class="input-field" placeholder="E-mail" name="email" required>
                                <input type="password" class="input-field" placeholder="Şifre" name="password"  required>
                                <a style="float: right; margin-top: 5px; margin-bottom: 5px;" href="{{ route('forgotPassword') }}" target="_blank">Şifremi Unuttum</a>
                                <button type="submit" class="submit-btn " name="submit2">Giriş Yap</button>
                                @if(isset($mesaj))
                                <p style="color:red; margin-top: 25px;">{{$mesaj}}</p>
                                @endif
                            </form>
                            <!--Login form end-->

                            <!--Register form-->
                            <form  action="{{ route('register') }}" method="post" id="register" class="input-group-register">
                                @csrf
                                <input type="text" class="input-field" placeholder="Ad Soyad" name="ad" required> 
                                <input type="email" class="input-field" placeholder="Email" name="email" required>
                                <input type="password" class="input-field" placeholder="Şifre" name="password" required> 
                                <input type="password" class="input-field" placeholder="Şifre Tekrar" name="password_confirmation" required> 
                                <div class="col-12  form-check mt-2" style="width:auto !important;">
                                    <input type="checkbox" required name="kabul" id="adda">
                                    <label  style="margin-left: 10px; font-size: 12px;" for="adda">
                                        @foreach($sozlesmelerRegister as $entry)
                                        <a target="_blank" href="{{route('sozlesmeler', $entry->slug)}}">
                                            {{$entry->sozlesme_dil_getir['baslik']}}@if($sozlesmelerRegister->last() !== $entry), @endif
                                        </a>
                                        @endforeach okudum ve kabul ediyorum.
                                    </label>
                                </div>
                                <div class="col-12 form-check mt-2" style="width:auto !important;">
                                    <input type="checkbox" value="1" name="kvkk" id="kvkk">
                                    <label for="kvkk" style="margin-left: 10px; font-size: 12px;">Kampanyalardan haberdar olmak için tarafıma elektronik ileti gönderilmesini kabul ediyorum.</label>
                                </div>
                                <button type="submit" class="submit-btn" name="submit">Kayıt Ol</button>
                            </form>
                            <!--Register form end -->

                        </div>
                    </div>
                </div>
            </div>
        </section> 
    </div>
</div>
</div>
<!-- Add to cart modal popup end-->
@endguest
@if(isset($iletisim))

<div class="wp-mobil">
    <a href="https://api.whatsapp.com/send?phone=+90{{$iletisim->telefon}}&text=Merhaba, " class="float" style="color: white;" target="_blank">
        <i class="fa fa-whatsapp my-float"></i>
    </a>
    <a href="https://t.me/PetHepsi" class="float-two" style="color: white;" target="_blank">
        <i class="fa fa-telegram my-float-two"></i>
    </a>
</div>
@endif  
<script type="text/javascript">
   function cookieFonksiyon(){
    document.cookie = "cookie=1";
}
var cookie_string = document.cookie;
var cerezler = document.cookie.split(";"); 
for (var i = 0; i < cerezler.length; i++) {  
    var cerez_degeri = cerezler[i].split("="); 
    if("cookie" == cerez_degeri[0].trim()) {    
        if (cerez_degeri[1] == 1) {
            document.getElementById('gizleCookie').style.display = "none";
        }
    } 
}
var url = "/sepet-api";
var obj = {};
var xmlHttp = new XMLHttpRequest();
            xmlHttp.open( "GET", url, false ); // false for synchronous request
            xmlHttp.send( null );
            obj = JSON.parse(xmlHttp.responseText); 
            var sepetNavUrun = obj['sepetUrunNav'];  
            var urunAdetToplam = obj['urunAdetToplam'];  
            var toplamFiyat = obj['toplamFiyat'];
            var urunSlug = document.getElementById('urunSlug');
            var urunSlug2 = document.getElementById('urunSlug2');
            var urunGorsel = document.getElementById('urunGorsel');
            var navUrun = document.getElementById('sepetNavUrun');
            var navUrunToplam = document.getElementById('sepetNavUrunToplam');
            var urunDetay = document.getElementById('urunDetay');
            var urunKaldirSlug = document.getElementById('urunKaldirSlug');  
            if(urunAdetToplam == null) { 
                document.getElementById('urunAdetToplamNavbar').innerHTML = 0; 
                navUrun.innerHTML = "<p style='font-size:20px;'>Lütfen sepetinize ürün ekleyiniz.</p>";
            }else { 
                if (urunAdetToplam < 99) {
                    document.getElementById('urunAdetToplam').innerHTML = urunAdetToplam;
                    document.getElementById('urunAdetToplamNavbar').innerHTML = urunAdetToplam; 
                }else{

                    document.getElementById('urunAdetToplam').innerHTML = "+99";
                    document.getElementById('urunAdetToplamNavbar').innerHTML = "+99"; 
                }
                sepetNavUrun.forEach(function(urunCartItem) {  
                    var slug = '/p/'+urunCartItem['sepeturun_urun_getir']['slug'];
                    var kaldirSlug = '/cart/api/remove/'+urunCartItem['sepeturun_urun_getir']['id'];
                    var div2 = "<li><div id='sepetsil"+urunCartItem['sepeturun_urun_getir']['id']+"'><div class='media'><a href='"+slug+"'> <img class='me-3' src='"+urunCartItem['sepeturun_urun_getir']['gorsel_bul']['gorsel']+"'></a><div class='media-body'><a href='"+slug+"'><h4>"+ urunCartItem['sepeturun_urun_getir']['detay_bul']['ad'] +"</h4></a><h4><span>"+  urunCartItem['adet'] +" x "+urunCartItem['fiyati']+"<span>{{ $paraSimge }}</span></h4></div></div><div class='close-circle'><a onclick='sepetSil("+urunCartItem['sepeturun_urun_getir']['id']+")'><i class='fa fa-times' aria-hidden='true'></i></a></div> </div></li>";
                    navUrun.innerHTML += div2; 
                });
                var divToplam = "<div class='total'><h5>Ara Toplam : <span>"+toplamFiyat+" {{ $paraSimge }}</span></h5></li>"+"<li><div class='buttons'><a href='{{route('sepet')}}' class='view-cart'>Sepete Git</a></div>";
                navUrunToplam.innerHTML = divToplam;
            }  
            function sepet(id){
                var sepeturl ='/cart/api/add/'+id;
                var data = {};
                var sepetxmlHttp = new XMLHttpRequest();
            sepetxmlHttp.open( "GET", sepeturl, false ); // false for synchronous request
            sepetxmlHttp.send( null );
            data = JSON.parse(sepetxmlHttp.responseText);
            var urun = data['urun'];   
            $.ajax({
                type:'GET',
                url:'/cart/add/'+id, 
                success:function() {  
                   if(urunAdetToplam == null) { 
                    urunAdetToplam = 1;  
                    navUrun.innerHTML = "";
                }else { 
                    if (urunAdetToplam == 0) {
                        navUrun.innerHTML = "";
                    }
                    urunAdetToplam++; 
                } 
                document.getElementById('urunAdetToplamNavbar').innerHTML = urunAdetToplam;
                var div = "<li id='sepetsil"+id+"' ><div class='media'><a href='"+urun['slug']+"'> <img class='me-3' src='"+urun['gorsel_bul']['gorsel']+"'></a><div class='media-body'><a href='"+urun['slug']+"'><h4>"+ urun['detay_bul']['ad']  +"</h4></a><h4><span>"+ data['urun_adet'] +" x "+data['urun_fiyat']+"<span>{{$paraSimge }}</span></h4></div></div><div class='close-circle'><a href='javascript:void(0)' onclick='sepetSil("+id+")'><i class='fa fa-times' aria-hidden='true'></i></a></div></li>" 
                navUrun.innerHTML += div; 

                var urunFiyat = Number(data['urun_fiyat']);
                toplamFiyat = Number(toplamFiyat); 
                if (toplamFiyat > 0) {
                    toplamFiyat += urunFiyat;
                }else{
                    toplamFiyat = urunFiyat;

                }
                var divToplam = "<div class='total'><h5>Ara Toplam : <span>"+toplamFiyat.toFixed(2)+" {{ $paraSimge }}</span></h5></li>"+"<li><div class='buttons'><a href='{{route('sepet')}}' class='view-cart'>Sepete Git</a></div>";
                navUrunToplam.innerHTML = divToplam;

            }

        });
        } 
        function favori(id,favid){
            var favoriEkle = document.getElementById('favoriEkle'+id);
            
            var fav = document.getElementById('fav'+id);  

            var favKaldir = document.getElementById('favKaldir'+id);  
            var favEkle = document.getElementById('favEkle'+id);  
            if (favKaldir !== null) {
                if (favKaldir.style.display == "block") { 
                    $.ajax({
                        type:'GET',
                        url:'/favorite/remove/'+favid,
                        success:function() {     
                            fav.className = "ti-heart";
                            fav.title = "Favorilere ekle"; 
                            favKaldir.style.display = "none";
                            favEkle.style.display = "block";
                        }
                    });

                }
            }
            if (favEkle.style.display == "block") { 
                $.ajax({
                    type:'GET',
                    url:'/favorite/add/'+id,
                    success:function() {  
                        fav.style.color = "#ff7f50";
                        fav.className = "fa fa-heart";
                        fav.title = "Favorilerden kaldır";
                        favKaldir.style.display = "block";
                        favEkle.style.display = "none";
                    }
                }); 
            }
        }
        function sepetSil(id){ 
            $.ajax({
                type:'GET',
                url:'/cart/api/remove/'+id,
                success:function() { 
                    document.getElementById('sepetsil'+id).remove();
                    if(urunAdetToplam == null) { 
                        urunAdetToplam = 0;  
                    }else { 
                        urunAdetToplam--; 
                    }
                    document.getElementById('urunAdetToplamNavbar').innerHTML = urunAdetToplam;
                    if(urunAdetToplam == 0) {  

                        navUrun.innerHTML = "<p style='font-size:20px;'>Lütfen sepetinize ürün ekleyiniz.</p>";
                        var divToplam = "";
                        navUrunToplam.innerHTML = divToplam;
                    }else{

                    }
                }
            });
        }
        function filtreFiyatgetir(slug, url, slug2 = null) {
            var getir = document.getElementById('filtreGetir').value; 
            if (slug2 !== null) {
                var gidenUrl =  "/"+url+"/"+slug+"/"+slug2;
            }else{

                var gidenUrl = "/"+url+"/"+slug;
            }
            if (getir == "artan") {
              $.ajax({
                type:"GET",
                url: gidenUrl+"?filterPrice=priceAsc",
                success:function(){  
                  window.location.href = gidenUrl+"?filterPrice=priceAsc";
              }
          });
          }
          if (getir == "azalan") {
             $.ajax({
              type:"GET",
              url: gidenUrl+"?filterPrice=priceDesc",
              success:function(){  
                window.location.href =  gidenUrl+"?filterPrice=priceDesc";
            }

        });
         }
     }
 </script> 

 <!-- latest jquery-->
 <script src="{{ asset('/assets/js/jquery-3.3.1.min.js') }}"></script>
 <!-- menu js-->
 <script src="{{ asset('/assets/js/menu.js') }}"></script>
 <script src="{{ asset('/assets/js/sticky-menu.js') }}"></script>

 <!-- lazyload js-->
 <script src="{{ asset('/assets/js/lazysizes.min.js') }}"></script>

 <!-- slick js-->
 <script src="{{ asset('/assets/js/slick.js') }}"></script>
 <script src="{{ asset('/assets/js/slick-animation.min.js') }}"></script>

 <!-- Bootstrap js-->
 <script src="{{ asset('/assets/js/bootstrap.bundle.min.js') }}"></script>

 <!-- Bootstrap Notification js-->
 <script src="{{ asset('/assets/js/bootstrap-notify.min.js') }}"></script>

 <!-- Theme js-->
 <script src="{{ asset('/assets/js/theme-setting.js') }}"></script>
 <script src="{{ asset('/assets/js/script.js') }}"></script>
 <script src="{{ asset('/assets/js/color-setting.js') }}"></script>
 <script src="{{ asset('/assets/js/custom-slick-animated.js') }}"></script>

 <!-- price range js -->
 <script src="{{ asset('/assets/js/price-range.js') }}"></script>

 <!-- price range js -->
 <script src="{{ asset('/assets/js/ek-js/arama.js') }}"></script>
 <!-- login-register js -->
 <script type="text/javascript" src="{{ asset('/assets/js/ek-js/login.js') }}"></script>

        <!--<div class="tap-top top-cls">
                <div>
                    <i class="fa fa-angle-double-up"></i>
                </div>
            </div> --> 