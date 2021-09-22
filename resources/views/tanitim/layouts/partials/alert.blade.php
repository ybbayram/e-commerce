@if(session()->has('mesaj'))
<br>
<div class="container">
	<div class="alert alert-{{ session('mesaj_tur') }}">{{ session('mesaj') }}</div>
</div>

<script type="text/javascript">
	window.setTimeout(function() {
		$(".alert").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove(); 
		});
	}, 3000);
</script>
@endif