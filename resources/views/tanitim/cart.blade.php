@extends('tanitim.layouts.master')
@section('css')
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
<script type="text/javascript">

  var input = document.getElementById("yazdir");
  input.addEventListener("keyup", function(event) {
    if (event.keyCode === 13) {
     event.preventDefault();
   }
 }); 
  /*
  function azalt(id){ 
    var yazdir = document.getElementById('yazdir'+id).innerHTML; 
    var sonuc = 0;
    if (sonuc > 0) {
      sonuc = Number(yazdir) - 1;
      $.ajax({
        type:'GET',
        url:'/',
        success:function() {    
          document.getElementById('yazdir'+id).innerHTML = sonuc;
        }
      }); 
    }
  }
  function arttir(id, stok){
    var azalt = document.getElementById('arttir'+id);
    var yazdir = document.getElementById('yazdir'+id).innerHTML; 
    var sonuc = 0; 
    sonuc = Number(yazdir) + 1; 
    $.ajax({
      type:'GET',
      url:'/cart',
      success:function() {    
        document.getElementById('yazdir'+id).innerHTML = sonuc;
      }
    }); 
  }
  */
</script>
@endsection
@section('content')
@include('admin.layouts.partials.alert')
@include('admin.layouts.partials.errors')

<!-- breadcrumb start -->
<div class="breadcrumb-section">
  <div class="container">
    <div class="row">
      <div class="col-sm-6">
        <div class="page-title">
          <h2>Ödeme</h2> 
        </div>
      </div>
      <div class="col-sm-6">
        <nav aria-label="breadcrumb" class="theme-breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Anasayfa</a></li>
            <li class="breadcrumb-item active">Ödeme</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</div>
<!-- breadcrumb End -->


<!--section start-->
<section class="cart-section section-b-space">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 table-responsive-xs">
        <table class="table cart-table">
          <thead>
            <tr class="table-head">
              <th scope="col">Fotoğraf</th>
              <th scope="col">Ürün</th>
              <th scope="col">Fiyat</th>
              <th scope="col">Adet</th>
              <th scope="col"></th>
              <th scope="col">Toplam</th>
            </tr>
          </thead>
          @foreach($sepetNavUrun as $urunCartItem) 
          @php
          $urun = App\Models\Urun::find($urunCartItem->urun_id);
          $urunToplam = $urunCartItem->fiyati * $urunCartItem->adet; 
          @endphp
          @if($urunCartItem->promosyonMu == 1)
          <tbody>
            <tr>
              <td>
                <a href="{{ route('urun', $urun->slug) }}"><img src="{{ $urun->urun_gorsel_bul->gorsel }}" alt=""></a>
              </td>
              <td>
                <a href="{{ route('urun', $urun->slug) }}">{{ $urun->urun_detay_bul['ad'] }} 
                  @if($urun->cesit_durum == 0)
                  @php
                  $cesitDetay = App\Models\CesitDetay::find($urunCartItem->cesit_detay_id);
                  @endphp
                  ({{$cesitDetay->cesit_detay_dil_getir['ad']}}) 
                  @endif
                </a>
              </td>
              <td>
                <h2>{{ number_format($urunCartItem->fiyati, 2) }} {{ $paraSimge }}</h2>
              </td>
              <td>
                <div class="qty-box"><div class="input-group" > 
                  @if($urunCartItem->fiyati != 0)
                  <div class="spinner">
                    @php $deger1 = '-' @endphp
                    <a @if($urunCartItem->adet > 1) href="{{route('sepet.api.guncelle',['id' => $urunCartItem->id , 'deger' => $deger1])}}" @else href="javascript:void(0)" @endif>
                      <div class="spinner-button"  id="azalt{{$urunCartItem->id}}" onclick="/*azalt({{$urunCartItem['id']}})*/">-</div>
                    </a>
                    <form onsubmit="confirmInput()" action="{{route('sepet.guncelle',$urunCartItem->id)}}" method="get">
                      @csrf  
                      <input type="number" name="adet" min="1" max="100000" id="yazdir" class="form-control spinner-value input-number" value="{{$urunCartItem->adet}}">  
                    </form> 
                    @php $deger2 = '+' @endphp
                    <a href="{{route('sepet.api.guncelle',['id' => $urunCartItem->id , 'deger' => $deger2])}}">
                      <div class="spinner-button" id="arttir{{$urunCartItem->id}}" onclick="/*arttir({{$urunCartItem['id']}},{{$urun['stok']}})*/">+</div>
                    </a>
                  </div>   
                </div>
                @else
                <label>{{ $urunCartItem->adet }}</label>
                @endif  
              </div> 
            </td>
            <td>
              @if($urunCartItem->fiyati != 0)<a href="{{ route('sepet.kaldir', $urunCartItem->id) }}" class="icon"><i class="ti-close"></i></a>@endif
            </td>
            <td>
              <h2 class="td-color">{{ $urunToplam }} {{ $paraSimge }}</h2>
            </td>
          </tr>
        </tbody>
        @else
        <tbody >
          <tr >
            <td>
              <a href="{{ route('urun', $urun->slug) }}"><img src="{{ $urun->urun_gorsel_bul->gorsel }}" alt=""></a>
            </td>
            <td>
              <div class="row">
                <div class="col">
                  <a href="{{ route('urun', $urun->slug) }}">{{ $urun->urun_detay_bul['ad'] }} 
                    @if($urun->cesit_durum == 0)
                    @php
                    $cesitDetay = App\Models\CesitDetay::find($urunCartItem->cesit_detay_id);
                    @endphp
                    ({{$cesitDetay->cesit_detay_dil_getir['ad']}}) 
                    @endif
                  </a>
                  <div class="mobile-cart-content row flex-row">
                    <div class="col mt-3" >
                      <div class="qty-box">
                       <div class="input-group" > 
                        @if($urunCartItem->fiyati != 0)
                        <div class="spinner">
                          @php $deger1 = '-' @endphp
                          <a @if($urunCartItem->adet > 1) href="{{route('sepet.api.guncelle',['id' => $urunCartItem->id , 'deger' => $deger1])}}" @else href="javascript:void(0)" @endif>
                            <div class="spinner-button"  id="azalt{{$urunCartItem->id}}" onclick="/*azalt({{$urunCartItem['id']}})*/">-</div>
                          </a>
                          <form onsubmit="confirmInput()" action="{{route('sepet.guncelle',$urunCartItem->id)}}" method="get">
                            @csrf  
                            <input type="number" name="adet" min="1" max="100000" id="yazdir" class="form-control spinner-value input-number" value="{{$urunCartItem->adet}}">  
                          </form> 
                          @php $deger2 = '+' @endphp
                          <a href="{{route('sepet.api.guncelle',['id' => $urunCartItem->id , 'deger' => $deger2])}}">
                            <div class="spinner-button" id="arttir{{$urunCartItem->id}}" onclick="/*arttir({{$urunCartItem['id']}},{{$urun['stok']}})*/">+</div>
                          </a>
                        </div>   
                      </div>
                      @else
                      <label>{{ $urunCartItem->adet }}</label>
                      @endif 
                    </div>
                  </div>
                </div>
                <div class="col mt-3">
                  <h2 class="td-color">{{ number_format($urunCartItem->fiyati, 2) }} {{ $paraSimge }}</h2>
                </div>
              </div>
              <div class="col-1 d-lg-none d-md-none d-sm-block">
                <h2 class="td-color"><a href="{{ route('sepet.kaldir', $urunCartItem->id) }}" class="icon"><i class="ti-close"></i></a>
                </h2>
              </div> 
            </div>
          </td>
          <td>
            <h2>{{ number_format($urunCartItem->fiyati, 2) }} {{ $paraSimge }}</h2>
          </td>
          <td>
            <div class="qty-box">
              <div class="input-group" > 
                @if($urunCartItem->fiyati != 0)
                <div class="spinner">
                  @php $deger1 = '-' @endphp
                  <a @if($urunCartItem->adet > 1) href="{{route('sepet.api.guncelle',['id' => $urunCartItem->id , 'deger' => $deger1])}}" @else href="javascript:void(0)" @endif>
                    <div class="spinner-button"  id="azalt{{$urunCartItem->id}}" onclick="/*azalt({{$urunCartItem['id']}})*/">-</div>
                  </a>
                  <form onsubmit="confirmInput()" action="{{route('sepet.guncelle',$urunCartItem->id)}}" method="get">
                    @csrf  
                    <input type="number" name="adet" min="1" max="100000" id="yazdir" class="form-control spinner-value input-number" value="{{$urunCartItem->adet}}">  
                  </form> 
                  @php $deger2 = '+' @endphp
                  <a href="{{route('sepet.api.guncelle',['id' => $urunCartItem->id , 'deger' => $deger2])}}">
                    <div class="spinner-button" id="arttir{{$urunCartItem->id}}" onclick="/*arttir({{$urunCartItem['id']}},{{$urun['stok']}})*/">+</div>
                  </a>
                </div>   
              </div>   
              @else
              <label>{{ $urunCartItem->adet }}</label>
              @endif  
            </div>
          </div>
        </td>

        <td>
          @if($urunCartItem->fiyati != 0)<a href="{{ route('sepet.kaldir', $urunCartItem->id) }}" class="icon d-none d-md-block d-lg-block"><i class="ti-close"></i></a>@endif
        </td>
        <td>
          <h2 class="td-color">{{ $urunToplam }} {{ $paraSimge }}</h2>
        </td>
      </tr>
    </tbody>
    @endif
    @endforeach
  </table>

</div>
<div class="table-responsive-md">
  <table class="table cart-table ">
    <tfoot>
     <tr>
      <td>Ara Toplam :</td>
      <td>
        <h2><small>{{ $toplamFiyat }} {{ $paraSimge }}</small></h2>
      </td>
    </tr>
    @if(isset($indirim))
    <tr>
      <td>İndirim :</td>
      <td>
        <h2><small>{{$indirimler['indirimTutari']}} {{ $paraSimge }}</small></h2>
      </td>
    </tr>
    @endif
    @if(isset($indirimler['SepetindirimTutari']))
    <tr>
      <td>Sepet Kampanyası :</td>
      <td>
        <h2><small>{{$indirimler['SepetindirimTutari']}} {{ $paraSimge }}</small></h2>
      </td>
    </tr>
    @endif
    @if(isset($indirimler['indirimXalYode']))
    <tr>
      <td>X Al Y Öde Kampanyası İndirimi :</td>
      <td>
        <h2><small>{{$indirimler['indirimXalYode']}} {{ $paraSimge }}</small></h2>
      </td>
    </tr>
    @endif
    <tr>
      <td>Kargo :</td>
      <td>
        <h2><small>@if($sepetNavUrun->count() > 0){{$kargoFiyat}}{{ $paraSimge }}@else 0.00 {{ $paraSimge }} @endif</small></h2>
      </td>
    </tr>
    <tr>

      <td>Toplam :</td>
      <td>
        <h2><small>@if($sepetNavUrun->count() > 0) {{ $toplam }}{{ $paraSimge }} @else 0.00 {{ $paraSimge }}  @endif  </small></h2>
      </td>
    </tr>
  </tfoot>
</table>
</div>
</div>
<div class="row cart-buttons">
  <div class="col-6">
    <div class="row">
      <form  class="form-group" action="{{route('kupon.indirim.uygula')}}" method="post">
        @csrf
        <div class="col-6 col-sm-6">
          <div class="form-group">
            <input type="text" class="form-control " name="kupon" placeholder="Kuponunuzu Giriniz" required="required">
          </div>
        </div> 
        <button type="submit" class="btn btn-solid btn-xs" id="mc-submit">Kuponu Uygula</button>
      </form>
    </div>
  </div>
  <div class="col-6">
    @if($sepetNavUrun->count() > 0) 
    <a href="@auth {{ route('odeme') }} @endauth @guest {{ route('loginOdeme') }} @endguest" class="btn btn-solid">Devam Et</a>
    @endif
  </div>

</div>
</div>
</section>
<!--section end--> 
@endsection
