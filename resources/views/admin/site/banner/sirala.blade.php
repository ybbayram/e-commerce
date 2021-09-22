@extends('admin.layouts.master')
@section('css')
<style type="text/css">

.cf:after { visibility: hidden; display: block; font-size: 0; content: " "; clear: both; height: 0; }
* html .cf { zoom: 1; }
*:first-child+html .cf { zoom: 1; }

html { margin: 0; padding: 0; }
body { margin: 0; font-family: 'Helvetica Neue', Arial, sans-serif; }

h1 { font-size: 1.75em; margin: 0 0 0.6em 0; }

a { color: #2996cc; }
a:hover { text-decoration: none; }

p { line-height: 1.5em; }
.small { color: #666; font-size: 0.875em; }
.large { font-size: 1.25em; }

/**
 * Nestable
 */

 .dd { position: relative; display: block; margin: 0; padding: 0; max-width: 600px; list-style: none; font-size: 13px; line-height: 20px; }

 .dd-list { display: block; position: relative; margin: 0; padding: 0; list-style: none; }
 .dd-list .dd-list { padding-left: 30px; }
 .dd-collapsed .dd-list { display: none; }

 .dd-item,
 .dd-empty,
 .dd-placeholder { display: block; position: relative; margin: 0; padding: 0; min-height: 20px; font-size: 13px; line-height: 20px; }

 .dd-handle { display: block; height: 30px; margin: 5px 0; padding: 5px 10px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc;
 	background: #fafafa;
 	background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
 	background:    -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
 	background:         linear-gradient(top, #fafafa 0%, #eee 100%);
 	-webkit-border-radius: 3px;
 	border-radius: 3px;
 	box-sizing: border-box; -moz-box-sizing: border-box;
 }
 .dd-handle:hover { color: #2ea8e5; background: #fff; }

 .dd-item > button { display: block; position: relative; cursor: pointer; float: left; width: 25px; height: 20px; margin: 5px 0; padding: 0; text-indent: 100%; white-space: nowrap; overflow: hidden; border: 0; background: transparent; font-size: 12px; line-height: 1; text-align: center; font-weight: bold; }
 .dd-item > button:before { content: '+'; display: block; position: absolute; width: 100%; text-align: center; text-indent: 0; }
 .dd-item > button[data-action="collapse"]:before { content: '-'; }

 .dd-placeholder,
 .dd-empty { margin: 5px 0; padding: 0; min-height: 30px; background: #f2fbff; border: 1px dashed #b6bcbf; box-sizing: border-box; -moz-box-sizing: border-box; }
 .dd-empty { border: 1px dashed #bbb; min-height: 100px; background-color: #e5e5e5;
 	background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
 	-webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
 	background-image:    -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
 	-moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
 	background-image:         linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
 	linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
 	background-size: 60px 60px;
 	background-position: 0 0, 30px 30px;
 }

 .dd-dragel { position: absolute; pointer-events: none; z-index: 9999; }
 .dd-dragel > .dd-item .dd-handle { margin-top: 0; }
 .dd-dragel .dd-handle {
 	-webkit-box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
 	box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
 }

/**
 * Nestable Extras
 */

 .nestable-lists { display: block; clear: both; padding: 30px 0; width: 100%; border: 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; }

 #nestable-menu { padding: 0; margin: 20px 0; }

 #nestable-output,
 #nestable2-output { width: 100%; height: 7em; font-size: 0.75em; line-height: 1.333333em; font-family: Consolas, monospace; padding: 5px; box-sizing: border-box; -moz-box-sizing: border-box; }

 #nestable2 .dd-handle {
 	color: #fff;
 	border: 1px solid #999;
 	background: #bbb;
 	background: -webkit-linear-gradient(top, #bbb 0%, #999 100%);
 	background:    -moz-linear-gradient(top, #bbb 0%, #999 100%);
 	background:         linear-gradient(top, #bbb 0%, #999 100%);
 }
 #nestable2 .dd-handle:hover { background: #bbb; }
 #nestable2 .dd-item > button:before { color: #fff; }

 @media only screen and (min-width: 700px) {

 	.dd { float: left; width: 48%; }
 	.dd + .dd { margin-left: 2%; }

 }

 .dd-hover > .dd-handle { background: #2ea8e5 !important; }

/**
 * Nestable Draggable Handles
 */

 .dd3-content { display: block; height: 30px; margin: 5px 0; padding: 5px 10px 5px 40px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc;
 	background: #fafafa;
 	background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
 	background:    -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
 	background:         linear-gradient(top, #fafafa 0%, #eee 100%);
 	-webkit-border-radius: 3px;
 	border-radius: 3px;
 	box-sizing: border-box; -moz-box-sizing: border-box;
 }
 .dd3-content:hover { color: #2ea8e5; background: #fff; }

 .dd-dragel > .dd3-item > .dd3-content { margin: 0; }

 .dd3-item > button { margin-left: 30px; }

 .dd3-handle { position: absolute; margin: 0; left: 0; top: 0; cursor: pointer; width: 30px; text-indent: 100%; white-space: nowrap; overflow: hidden;
 	border: 1px solid #aaa;
 	background: #ddd;
 	background: -webkit-linear-gradient(top, #ddd 0%, #bbb 100%);
 	background:    -moz-linear-gradient(top, #ddd 0%, #bbb 100%);
 	background:         linear-gradient(top, #ddd 0%, #bbb 100%);
 	border-top-right-radius: 0;
 	border-bottom-right-radius: 0;
 }
 .dd3-handle:before { content: '≡'; display: block; position: absolute; left: 0; top: 3px; width: 100%; text-align: center; text-indent: 0; color: #fff; font-size: 20px; font-weight: normal; }
 .dd3-handle:hover { background: #ddd; }

/**
 * Socialite
 */

 .socialite { display: block; float: left; height: 35px; }

</style>
@endsection
@section('js')
<script src="{{ asset('/adassets/assets/libs/nestable2/jquery.nestable.min.js') }}"></script> 

<script>

	$(document).ready(function()
	{

		var updateOutput = function(e)
		{
			var list   = e.length ? e : $(e.target),
			output = list.data('output');
			if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
        } else {
        	output.val('JSON browser support required for this demo.');
        }
    };

    // activate Nestable for list 1
    $('#nestable').nestable({
    	group: 1
    })
    .on('change', updateOutput);

    // activate Nestable for list 2
    $('#nestable2').nestable({
    	group: 1
    })
    .on('change', updateOutput);

    // output initial serialised data
    updateOutput($('#nestable').data('output', $('#nestable-output')));
    updateOutput($('#nestable2').data('output', $('#nestable2-output')));

    $('#nestable-menu').on('click', function(e)
    {
    	var target = $(e.target),
    	action = target.data('action');
    	if (action === 'expand-all') {
    		$('.dd').nestable('expandAll');
    	}
    	if (action === 'collapse-all') {
    		$('.dd').nestable('collapseAll');
    	}
    });

    $('#nestable3').nestable();

});
</script>
@endsection
@section('content')
@include('admin.layouts.partials.navbar')
<div class="main-content">

	<div class="page-content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-flex align-items-center justify-content-between">
						<h4 class="mb-0 font-size-18">Slider</h4>
					</div>
				</div>
			</div>
			<!-- end page title -->

			<div class="row">

				<div class="col-xl-12">
					<div class="card">
						<div class="card-body">
							<a href="{{ route('admin.site.banner') }}"><span class="btn btn-purple btn btn-xl inputTwo" style="margin-bottom: 20px"><span class="dripicons-arrow-thin-left"> Önceki Sayfa</span></span></a>
							<span class="float-right text-muted font-size-13"></span>
							<h5 class="card-title mb-3">Banner Sırala</h5>
							<p class="card-title-desc">
								Bannerları bu sayfadan sıralayabilirsiniz.
							</p>
							<div id="donut-example" class="morris-charts workloed-chart"
							dir="ltr">
							@include('admin.layouts.partials.alert')
							@include('admin.layouts.partials.errors')
							<div class="card-body">
								<div class="cf nestable-lists">

									<div class="dd" id="nestable">
										<ol class="dd-list">
											@foreach($banner as $entry)
											<li class="dd-item" data-id="{{ $entry->id }}"><div class="dd-handle">{{ $entry->ad }}</div></li>
											@endforeach
										</ol>
									</div>
								</div>
							</div>
							<form action="{{ route('admin.site.banner.sirala') }}" method="post">
								@csrf
								<div class="form-group" style="display: none">
									<textarea id="nestable-output" name="json"></textarea>
								</div>
								<button type="submit" class="btn btn-primary w-lg">Gönder</button>
							</form>
						</div>
					</div>
				</div>

			</div><!--end row-->
		</div>
	</div>
</div>
</div>

@endsection