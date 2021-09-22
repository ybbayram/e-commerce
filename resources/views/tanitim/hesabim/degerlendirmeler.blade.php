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

 <!-- section start -->
 <section class="section-b-space">
    <div class="container">
       <div class="row">
        @include('tanitim.hesabim.hesabimNavbar')
          <div class="col-lg-9 my_reviews">
             <div class="dashboard-right">

                <div class="row">

                   @foreach($yorumlar as $yorum)
                   <div class="col-lg-12 mb-3">
                      <div class="card">
                         <div class="row">
                            <div class="col-lg-5">
                               <a href="{{ route('urun', $yorum->urun_bul['slug']) }}">
                                  <img width="200px" height="200px" style="margin: 20px;" src="{{$yorum->urun_bul->gorsel_bul['gorsel']}}"></a>
                            </div>
                            <div class="col-lg-7" style="margin-top: 30px;">
                               <a href="{{ route('urun', $yorum->urun_bul['slug']) }}">
                                  <h3 class="card-title">{{$yorum->urun_bul->detay_bul['ad']}}</h3>
                               </a>
                               <h5 class="card-title">Puan : {{$yorum->oy}}</h5>
                               <p class="card-title-desc" style="min-height: 75px;">{{$yorum->yorum}}</p>
                            </div>
                         </div>

                         <div class="row">
                            <div class="col-lg-6" style="margin: 9px 20px 20px 20px;">
                               <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal{{$yorum->id}}" class="btn btn-solid ">Güncelle</button>
                               <a href="{{ route('hesabim.degerlendirmeler.sil', $yorum->id)}}" class="btn btn-solid">Sil</a>
                            </div>
                         </div>
                         <div class="modal fade" id="exampleModal{{$yorum->id}}" tabindex="-1" aria-labelledby="exampleModalLabel{{$yorum->id}}" aria-hidden="true">
                            <div class="modal-dialog">
                               <div class="modal-content">
                                  <div class="modal-header">
                                     <h5 class="modal-title" id="exampleModalLabel{{$yorum->id}}">Yorumunuz</h5>
                                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>

                                  <form class="theme-form" action="{{route('hesabim.degerlendirmeler.guncelle', $yorum->id)}}" method="post">
                                     @csrf
                                     <div class="modal-body">
                                        <div class="form-row row">
                                           <div class="col-md-6">
                                              <label for="name">Puan</label>
                                              <input type="text" class="form-control" name="oy" id="address-two" placeholder="Puanınız" required="" value="{{$yorum->oy}}">
                                           </div>
                                           <div class="col-md-6">
                                              <label for="name">Yorum</label>
                                              <input type="text" class="form-control" name="yorum" id="home-ploat" placeholder="Yorumunuz" required="" value="{{$yorum->yorum}}">
                                           </div>
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
                   @endforeach
                </div> <!-- end row -->

             </div>
          </div>
       </div>
 </section>
 <!-- section end -->
 @endsection