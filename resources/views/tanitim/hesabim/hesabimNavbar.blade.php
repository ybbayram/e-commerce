 <div class="col-lg-3">
 	<div class="account-sidebar"><a class="popup-btn">Hesabım</a></div>
 	@auth
 	<div class="block-content mb-2" style="background:#f9f9f9;border:none;padding:20px">
 		<div class="container">
 			<div class="row d-flex flex-column">
 				<div class="col mb-3"> {{ Auth::user()->ad}} </div>
 				<div class="col"> {{ Auth::user()->email}}</div>

 			</div>
 		</div>
 	</div>
 	@endauth
 	<div class="dashboard-left">
 		<div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left" aria-hidden="true"></i> Geri</span></div>
 		<div class="block-content">
 			<ul>
 				@auth
 				<li><a href="{{route('hesabim.panel')}}">Hesabım</a></li>
 				<li><a href="{{route('hesabim.adreslerim')}}">Adreslerim</a></li>
 				<li><a href="{{ route('hesabim.siparislerim') }}">Siparişlerim</a></li>
 				<li><a href="{{ route('hesabim.degerlendirmeler') }}">Değerlendirmelerim</a></li>
 				<li><a href="{{ route('favori') }}">Favorilerim</a></li>
 				<li><a href="{{route('hesabim.bildirimler.sayfa')}}">Bildirimler</a></li>
 				<li><a href="{{route('hesabim.sifreDegis.sayfa')}}">Şifre değiştir</a></li>
 				<li class="last mb-4"><a href="{{ route('cikisYap') }}">Çıkış Yap</a></li>
 				@endauth
 				@guest
 				<li><a href="{{route('hesabim.panel')}}">Hesabım</a></li>
 				<li class="active"><a href="{{route('hesabim.adreslerim')}}">Adreslerim</a></li>
 				<li><a href="{{ route('favori') }}">Favorilerim</a></li>
 				@endguest
 			</ul>
 		</div>
 	</div>
 </div>