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
									<form action="{{route('admin.site.medya.guncelle',$sosyal->id)}}" method="post">
										@csrf
										<div class="form-group">
											<label for="example-email-input1" class="col-form-label pt-0">İnstagram</label>
											<input class="form-control" name="instagram" type="text" id="example-email-input1" placeholder="İnstagram"  @if(isset($sosyal->instagram)) value="{{$sosyal->instagram}}" @endif>
										</div>
										<div class="form-group">
											<label for="example-email-input1" class="col-form-label pt-0">Facebook</label>
											<input class="form-control" name="facebook" type="text" min="0" id="example-email-input1" placeholder="Facebook" @if(isset($sosyal->facebook)) value="{{$sosyal->facebook}}" @endif>
										</div>
										<div class="form-group">
											<label for="example-email-input1" class="col-form-label pt-0">Linkedin</label>
											<input class="form-control" name="linkedin" type="text" min="0" id="example-email-input1" placeholder="Linkedink" @if(isset($sosyal->linkedin)) value="{{$sosyal->linkedin}}" @endif>
										</div>
										<div class="form-group">
											<label for="example-email-input1" class="col-form-label pt-0">Youtube</label>
											<input class="form-control" name="youtube" type="text" min="0" id="example-email-input1" placeholder="Youtube" @if(isset($sosyal->youtube)) value="{{$sosyal->youtube}}" @endif>
										</div>
										<div class="form-group">
											<label for="example-email-input1" class="col-form-label pt-0">Twitter</label>
											<input class="form-control" name="twitter" type="text" min="0" id="example-email-input1" placeholder="Twitter" @if(isset($sosyal->twitter)) value="{{$sosyal->twitter}}" @endif>
										</div>
										<div class="form-group">
											<label for="example-email-input1" class="col-form-label pt-0">Pinterest</label>
											<input class="form-control" name="pinterest" type="text" min="0" id="example-email-input1" placeholder="Pinterest" @if(isset($sosyal->pinterest)) value="{{$sosyal->pinterest}}" @endif>
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

@endsectionsosyal