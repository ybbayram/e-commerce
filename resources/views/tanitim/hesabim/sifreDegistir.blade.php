 @extends('tanitim.layouts.master')
 @section('js')
 <script type="text/javascript" src="{{ asset('/assets/js/ek-js/sifreDegistir.js') }}"></script>

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
@include('tanitim.layouts.partials.alert')
@include('tanitim.layouts.partials.errors')
 <!-- section start -->
 <section class="section-b-space">
    <div class="container">
       <div class="row">
        @include('tanitim.hesabim.hesabimNavbar')
          <div class="col-lg-9 change_pass">
             <div class="dashboard-right">
                <div class="row">
                   <form class="form-group" action="{{route('hesabim.sifreDegis')}}" method="post">
                      @csrf
                      <div class="col-6">
                         <div class="form-group">
                            <label>Eski Şifre</label>
                            <div class="input-group" id="show_hide_password3">
                               <input class="form-control" name="password_eski" type="password" required>
                               <div class="input-group-text">
                                  <a href="javascript::void(0)" style="color: black;"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                               </div>
                            </div>
                         </div>
                      </div>
                      <div class="col-6">
                         <div class="form-group">
                            <label>Yeni Şifre</label>
                            <div class="input-group" id="show_hide_password">
                               <input class="form-control" name="password" type="password" required>
                               <div class="input-group-text">
                                  <a href="javascript::void(0)" style="color: black;"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                               </div>
                            </div>
                         </div>
                      </div>
                      <div class="col-6">
                         <div class="form-group">
                            <label>Yeni Şifre Tekrar</label>
                            <div class="input-group" id="show_hide_password2">
                               <input class="form-control" name="password_confirmation" type="password" required>
                               <div class="input-group-text">
                                  <a href="javascript::void(0)" style="color: black;"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                               </div>
                            </div>
                         </div>
                      </div>
                      <div class="col-lg-6 mt-3">
                         <button class="btn btn-solid ">Güncelle</button>
                      </div>
                   </form>
                </div>
             </div>
          </div>
       </div>
 </section>
 <!-- section end -->
 @endsection