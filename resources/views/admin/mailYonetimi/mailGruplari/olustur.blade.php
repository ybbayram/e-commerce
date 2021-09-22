@extends('admin.layouts.master')
@section('content')
@include('admin.layouts.partials.navbar')
<div class="main-content">

	<div class="page-content">
		<div class="container-fluid">

			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-flex align-items-center justify-content-between">
						<h4 class="mb-0 font-size-18">Mail Yönetimi</h4>
					</div>
				</div>
			</div>

			<div class="row">
				@include('admin.layouts.partials.alert')
				@include('admin.layouts.partials.errors')
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<a href="{{ route('admin.mailGruplari') }}"><span class="btn btn-purple btn btn-xl inputTwo" style="margin-bottom: 20px"><span class="dripicons-arrow-thin-left"> Önceki Sayfa</span></span></a>
							<h4 class="card-title">Mail Grubu Oluştur</h4>
							<p class="card-title-desc">Mail grubu oluşturunuz.</p>

							<div class="row">

								<div class="col-lg-12 col-sm-12 mb-4">
									<form action="{{route('admin.mailGruplari.olustur')}}" method="post">
										@csrf
										<div class="form-group">
											<label for="example-email-input1" class="col-form-label pt-0">Ad</label>
											<input class="form-control" name="ad" type="text" id="example-email-input1" placeholder="Grup adını giriniz" required="true" value="{{ old('ad') }}">
										</div>
										<div class="form-group" >
											<label class="mt-2">Mail Grubu</label>
											<select class="form-control select2 mb-3" name="grup" style="width: 100%; ">
												<option value="-1">Tür Seçiniz</option> 
												<option value="0">Sipariş Vermiş Kullanıcılar</option> 
												<option value="1">Sipariş Vermemiş Kullanıcılar</option> 
												<option value="2">Favoride Ürün Bulunduranlar</option> 
												<option value="3">Spette Ürün Bulunduranlar</option> 
												<option value="4">Tariha Göre Tüm Kullanıcılar</option> 
											</select> 
										</div>
										<div class="form-group">
											<div class="col-lg-5 col-sm-12 mb-4" style=" padding: 0px;">
												<label for="example-datetime-local-input" class="ccol-form-label pt-0">Başlangıç Tarihi</label> 
												<input class="form-control" name="baslangic_tarihi" type="datetime-local" value="{{ old('baslangic_tarihi') }}" id="example-datetime-local-input" required="true">
											</div>	
										</div>
										<div class="form-group">
											<div class="col-lg-5 col-sm-12 mb-4" style=" padding: 0px;">
												<label for="example-datetime-local-input" class="ccol-form-label pt-0">Bitiş Tarihi</label> 
												<input class="form-control" name="bitis_tarihi" type="datetime-local" value="{{ old('bitis_tarihi') }}" id="example-datetime-local-input" required="true">
											</div>	
										</div>
										
										<button type="submit" class="btn btn-primary w-lg">Gönder</button>
									</form>
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>


		</div> <!-- container-fluid -->
	</div>
	<!-- End Page-content -->

</div>
<!-- end main content-->

</div>
@endsection