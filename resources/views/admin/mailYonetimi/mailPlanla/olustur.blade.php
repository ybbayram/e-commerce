@extends('admin.layouts.master')
@section('js')
<script src="/adassets/assets/libs/jquery.repeater/jquery.repeater.min.js"></script>
<script src="/adassets/assets/js/pages/form-repeater.init.js"></script>
@endsection
@section('content')
@include('admin.layouts.partials.navbar')
<div class="main-content">

	<div class="page-content">
		<div class="container-fluid">

			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-flex align-items-center justify-content-between">
						<h4 class="mb-0 font-size-18">Mail Planla</h4>
					</div>
				</div>
			</div>

			<div class="row">
				@include('admin.layouts.partials.alert')
				@include('admin.layouts.partials.errors')
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<a href="{{ route('admin.mailPlanla') }}"><span class="btn btn-purple btn btn-xl inputTwo" style="margin-bottom: 20px"><span class="dripicons-arrow-thin-left"> Önceki Sayfa</span></span></a>
							<h4 class="card-title">Mail Planı Oluştur</h4>
							<p class="card-title-desc">Mail planı oluşturunuz.</p>

							<div class="row">

								<div class="col-lg-12 col-sm-12 mb-4">
									<form action="{{route('admin.mailPlanla.olustur')}}" method="post">
										@csrf
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Ad</label>
											<input class="form-control col-lg-4" name="ad" type="text" id="example-email-input1" placeholder="Plan adını giriniz" required="true" value="{{ old('ad') }}">
										</div>
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Günler</label>
											<div>
												<input type="checkbox" name="pazartesi" id="switch1" switch="success"/>
												<label for="switch1" data-on-label="Pzt"
												data-off-label="Pzt"></label>
												<input type="checkbox" name="sali" id="switch2" switch="success"/>
												<label for="switch2" data-on-label="Sal"
												data-off-label="Sal"></label>
												<input type="checkbox" name="carsamba" id="switch3" switch="success"/>
												<label for="switch3" data-on-label="Çar"
												data-off-label="Çar"></label>
												<input type="checkbox" name="persembe" id="switch4" switch="success"/>
												<label for="switch4" data-on-label="Per"
												data-off-label="Per"></label>
												<input type="checkbox" name="cuma" id="switch5" switch="success"/>
												<label for="switch5" data-on-label="Cum"
												data-off-label="Cum"></label>
												<input type="checkbox" name="cumartesi" id="switch6" switch="success"/>
												<label for="switch6" data-on-label="Cmt"
												data-off-label="Cmt"></label>
												<input type="checkbox" name="pazar" id="switch7" switch="success"/>
												<label for="switch7" data-on-label="Paz"
												data-off-label="Paz"></label>
											</div>
										</div>
										<div class="form-group">
											<label for="example-email-input1" class="col-form-label pt-0">Saat</label>
											<input class="form-control col-lg-2" name="saat" type="time" value="9:00:00" id="example-time-input">
										</div>
										<div class="form-group" >
											<label class="mt-2">Mail Türü</label>
											<select class="form-control select2 mb-3 col-lg-4" name="mailTuru" style="width: 100%; ">
												<option value="0">Son 1 günlük siparişler (Mail saatinden önceki 24 saat)</option> 
											</select> 
										</div>
										<fieldset>
											<div class="repeater-default">
												<div data-repeater-list="liste">
													<div data-repeater-item="">
														<div class="form-group row d-flex align-items-end">


															<div class="col-sm-4">
																<label class="control-label">Email</label>
																<input type="text" name="email" class="form-control">
															</div>


															<div class="col-sm-1">
																<span data-repeater-delete="" class="btn btn-danger btn-sm">
																	<span class="fa fa-times mr-1"></span> Sil
																</span>
															</div>
														</div>
													</div>

												</div>
												<div class="form-group mb-3 row">
													<div class="col-sm-12">
														<span data-repeater-create="" class="btn btn-light mr-1">
															<span class="fa fa-plus mr-1"></span> Yeni Email
														</span>
													</div>
												</div>                                             
											</fieldset>
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