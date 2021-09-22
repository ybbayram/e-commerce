@extends('admin.layouts.master')
@section('content')
@include('admin.layouts.partials.navbar')
<div class="main-content">

	<div class="page-content">
		<div class="container-fluid">

			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-flex align-items-center justify-content-between">
						<h4 class="mb-0 font-size-18">Site Ayarları</h4>
					</div>
				</div>
			</div>

			<div class="row">
				@include('admin.layouts.partials.alert')
				@include('admin.layouts.partials.errors')
				<div class="col-12">
					<div class="card">
						<div class="card-body">  
							<h4 class="card-title">İletişim Bilgileri</h4>
							<p class="card-title-desc">Sitenin iletişim bilgilerini buradan güncelleyebilirsiniz</p>
							<div class="row">
								<div class="col-lg-12 col-sm-12 mb-4">
									<form action="{{route('admin.site.iletisim.guncelle',$iletisim->id)}}" method="post">
										@csrf
										<div class="form-group">
											<label for="example-email-input1" class="col-form-label pt-0">Mail <span style="color: red;">*</span></label>
											<input class="form-control" name="mail" type="email" id="example-email-input1" placeholder="Site Mail Adresi" required="true"  @if(isset($iletisim->mail)) value="{{$iletisim->mail}}" @endif>
										</div>
										<div class="form-group">
											<label for="example-email-input1" class="col-form-label pt-0">Telefon <span style="color: red;">*</span></label>
											<input class="form-control" name="telefon" type="number" min="0" id="example-email-input1" placeholder="Telefon Numarası" required="true" @if(isset($iletisim->telefon)) value="{{$iletisim->telefon}}" @endif>
										</div>
										<div class="form-group">
											<label for="example-email-input1" class="col-form-label pt-0">Adres <span style="color: red;">*</span></label>
										<textarea  name="adres" id="elm1" placeholder="Tam Adres"
											required="" > @if(isset($iletisim->adres)){{$iletisim->adres}}@endif</textarea>
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