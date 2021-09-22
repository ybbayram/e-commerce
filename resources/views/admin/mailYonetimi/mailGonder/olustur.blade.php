@extends('admin.layouts.master')
@section('content')
@include('admin.layouts.partials.navbar')
<div class="main-content">

	<div class="page-content">
		<div class="container-fluid">

			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-flex align-items-center justify-content-between">
						<h4 class="mb-0 font-size-18">Mail Gönder</h4>
					</div>
				</div>
			</div>

			<div class="row">
				@include('admin.layouts.partials.alert')
				@include('admin.layouts.partials.errors')
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<a href="{{ route('admin.mailGonder') }}"><span class="btn btn-purple btn btn-xl inputTwo" style="margin-bottom: 20px"><span class="dripicons-arrow-thin-left"> Önceki Sayfa</span></span></a>
							<h4 class="card-title">Mail Gönder</h4>
							<p class="card-title-desc">Mail gönderiniz.</p>

							<div class="row">

								<div class="col-lg-12 col-sm-12 mb-4">
									<form action="{{route('admin.mailGonder.olustur')}}" method="post">
										@csrf
										<div class="form-group" >
											<label class="mt-2">Mail Grubu</label>
											<select class="form-control select2 mb-3 col-lg-4" name="mailGruplariId" style="width: 100%; ">
												@foreach($mailGruplari as $entry)
												<option value="{{ $entry->id }}">{{ $entry->ad }}</option>
												@endforeach
											</select> 
										</div>
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Konu</label>
											<input class="form-control col-lg-4" name="konu" type="text" placeholder="Konu giriniz" required="true" value="{{ old('konu') }}">
										</div>
										<div class="form-group" id="example-email-input1">
											<label for="example-email-input1" class="col-form-label pt-0">Mesaj <span style="color: red;">*</span></label>
											<textarea id="elm1" class="form-control" name="mesaj"></textarea>
										</div>
											<button type="button" title="Sil"  class="d-xl-inline-block ml-1 btn btn-primary tippy-btn" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-center-1"> Gönder </button>



													<div class="modal fade bs-example-modal-center-1" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
														<div class="modal-dialog modal-dialog-centered">
															<div class="modal-content">
																<div class="modal-header">
																	<h5 class="modal-title align-self-center mt-0" id="exampleModalLabel">Mail grubuna maili göndermek istiyor musunuz?</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																	</button>
																</div>
																<div class="modal-body">
																		<input type="submit" value="Evet" class="btn btn-primary btn btn-xl inputTwo"/>
																</div>
															</div><!-- /.modal-content -->
														</div><!-- /.modal-dialog -->
													</div><!-- /.modal -->
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