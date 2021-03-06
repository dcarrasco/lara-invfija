<!-- ============================== NAVBAR ============================== -->
<nav class="navbar navbar-expand-lg p-0 navbar-light shadow-sm" style="background-color: #fff;" role="navigation">
	<div class="h-100 col-2 d-inline-block bg-dark py-2 text-center">
		<span class="navbar-brand text-light">
			{{ config('app.name') }}
		</span>
	</div>

	<button class="navbar-toggler" data-toggle="collapse" data-target="#navMenuCollapse">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse col-10" id="navMenuCollapse">

		<span class="h5 my-0">
			{!! auth()->user()->moduloAppName() !!}
		</span>

		<ul class="navbar-nav ml-auto">
			@foreach(auth()->user()->getMenuApp() as $menuApp)
			<li class="nav-item dropdown {{ $menuApp['selected'] ? 'active' : '' }}">
				<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
					<span class="fa fa-{{ $menuApp['icono'] }} fa-fw"></span> {{ $menuApp['app'] }} <b class="caret"></b>
				</a>

				<div class="dropdown-menu">
					@foreach($menuApp['modulos'] as $modulo)
					<a class="dropdown-item" href="{{ route($modulo['url']) }}">
						<span class="fa fa-{{ $modulo['icono'] }} fa-fw"></span>
						{{ $modulo['modulo'] }}
					</a>
					@endforeach
				</div>
			</li>
			@endforeach
			<li class="nav-item">
				<a class="nav-link" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
					<span class="fa fa-power-off fa-fw"></span>
					Logout {{ auth()->user()->getFirstName() }}
            		<img src="https://secure.gravatar.com/avatar/{{ md5(auth()->user()->email) }}?size=24" class="rounded-circle border mx-2" />
				</a>
				{{ Form::open(['url' => route('logout'), 'id' => 'logout-form']) }}{{ Form::close() }}
			</li>

		</ul>
	</div> <!-- DIV class="collapse navbar-collapse navMenuCollapse" -->
</nav>
<!-- ============================== /NAVBAR ============================== -->
