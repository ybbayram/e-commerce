@extends('admin.layouts.master')
@section('content')
@include('admin.layouts.partials.navbar')
<div class="main-content">

	<div class="page-content">
		<div class="container-fluid">

			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-flex align-items-center justify-content-between">
						<h4 class="mb-0 font-size-18"><b>{{ $urunDetay['ad'] }}</b> Ürün Detayını Güncelle</h4>
					</div>
				</div>
			</div>

			<div class="row">
				@include('admin.layouts.partials.alert')
				@include('admin.layouts.partials.errors')
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<a href="{{ route('admin.urun', $urunDetay['urun_id']) }}"><span class="btn btn-purple btn btn-xl inputTwo" style="margin-bottom: 20px"><span class="dripicons-arrow-thin-left"> Önceki Sayfa</span></span></a>
							<h4 class="card-title">Kategori Güncelle</h4>
							<p class="card-title-desc">Kategori güncelleyiniz.</p>

							<div class="row">

								<div class="col-lg-12 col-sm-12 mb-4">
									<form action="{{ route('admin.urunDetay.guncelle', $urunDetay->id) }}" method="post">
										@csrf
										<div class="form-group" id="example-email-input1">
											<label for="example-email-input1" class="col-form-label pt-0">Dil <span style="color: red;">*</span></label>
											<select class="form-control" name="dil_id">
												@foreach($diller as $entry)
												@if($entry->id == $urunDetay->dil_id)
												<option value="{{ $entry->id }}" checked="true">{{ $entry->ad }}</option>
												@endif
												@endforeach
												@foreach($diller as $entry)
												@if($entry->id != $urunDetay->dil_id)
												<option value="{{ $entry->id }}">{{ $entry->ad }}</option>
												@endif
												@endforeach
											</select>
										</div>
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Ad <span style="color: red;">*</span></label>
											<input class="form-control" name="ad" type="text" id="example-email-input1" placeholder="Kategori adını giriniz" required="true" value="{{ old('ad', $urunDetay->ad) }}">
										</div>
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Açıklama Bir Başlık <span style="color: red;">*</span></label>
											<input class="form-control" name="aciklama_bir_baslik" type="text" id="example-email-input1" placeholder="Başlık bir giriniz" required="true" value="{{ old('aciklama_bir_baslik', $urunDetay->aciklama_bir_baslik) }}">
										</div>
										<div class="form-group" id="example-email-input1">
											<label for="example-email-input1" class="col-form-label pt-0">Açıklama Bir <span style="color: red;">*</span></label>
											<textarea id="elm1" name="aciklama_bir">{{ old('aciklama_bir', $urunDetay->aciklama_bir) }}</textarea>
										</div>
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Açıklama İki Başlık</label>
											<input class="form-control" name="aciklama_iki_baslik" type="text" id="example-email-input1" placeholder="Başlık iki giriniz" value="{{ old('aciklama_iki_baslik', $urunDetay->aciklama_iki_baslik) }}">
										</div>
										<div class="form-group" id="example-email-input1">
											<label for="example-email-input1" class="col-form-label pt-0">Açıklama İki</label>
											<textarea id="elm2" name="aciklama_iki">{{ old('aciklama_iki', $urunDetay->aciklama_iki) }}</textarea>
										</div>
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Açıklama Üç Başlık</label>
											<input class="form-control" name="aciklama_uc_baslik" type="text" id="example-email-input1" placeholder="Başlık üç giriniz" value="{{ old('aciklama_uc_baslik', $urunDetay->aciklama_uc_baslik) }}">
										</div>
										<div class="form-group" id="example-email-input1">
											<label for="example-email-input1" class="col-form-label pt-0">Açıklama Üç</label>
											<textarea id="elm3" class="form-control" name="aciklama_uc">{{ old('aciklama_uc', $urunDetay->aciklama_uc) }}</textarea>
										</div>
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Açıklama Dört Başlık</label>
											<input class="form-control" name="aciklama_dort_baslik" type="text" id="example-email-input1" placeholder="Başlık dört giriniz" value="{{ old('aciklama_dort_baslik', $urunDetay->aciklama_dort_baslik) }}">
										</div>
										<div class="form-group" id="example-email-input1">
											<label for="example-email-input1" class="col-form-label pt-0">Açıklama Dört </label>
											<textarea id="elm4" class="form-control" name="aciklama_dort">{{ old('aciklama_dort', $urunDetay->aciklama_dort) }}</textarea>
										</div>
										<h3>SEO</h3>
										<div class="form-group ">
											<label for="example-email-input1" class="col-form-label pt-0">Başlık <span style="color: red;">*</span></label>
											<input class="form-control" name="title" type="text" id="example-email-input1" placeholder="SEO başlık giriniz" required="true" maxlength="65" value="{{ old('title', $urunDetay->title) }}">
										</div>
										<div class="form-group" id="example-email-input1">
											<label for="example-email-input1" class="col-form-label pt-0">Açıklama <span style="color: red;">*</span></label>
											<textarea required="true" class="form-control" maxlength="160" name="description">{{ old('description', $urunDetay->description) }}</textarea>
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