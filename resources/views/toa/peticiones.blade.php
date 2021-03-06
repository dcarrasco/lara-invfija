@extends('common.app_layout')

@section('modulo')
<div class="content-module-main">
{!! $reportePeticiones !!}
<div class="accordion">
	<div class="panel panel-default">
		<div class="panel-heading">
			<a href="#map-panel" class="accordion-toggle" data-toggle="collapse" aria-expanded="true">
				<span class="fa fa-map-marker"></span>
				Mapa
			</a>
		</div>
		<div class="panel-collapse collapse in" id="map-panel">
			<div class="panel-body panel-collapse collapse in">
				{!! $googleMaps !!}
			</div>
		</div>
	</div>
</div>

<hr/>
</div> <!-- fin content-module-main -->
@endsection
