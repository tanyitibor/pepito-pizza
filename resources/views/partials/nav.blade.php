<nav class="navbar navbar-default">
	<div class="container-fluid">
		<ul class="nav navbar-nav">
			<li><a href="{{url('/')}}">Home</a></li>
			<li><a href="{{route('pizzas.index')}}">Pizzas</a></li>
			<li><a href="{{url('/contact')}}">Contact</a></li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			@if(Auth::check())
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
				{{Auth::user()->user_name}} <span class="caret"></span>
				</a>
				<ul class="dropdown-menu text-center">
					@if (Auth::user()->isEmployee())
					<li>
						<a href="{{ urL('/dashboard') }}">Dashboard</a>
					</li>
					<li role="separator" class="divider"></li>
					@endif
					<li>
						<a href="{{ url('/profile') }}">Profile</a>
					</li>
					<li>
						<a href="{{ url('/logout') }}">Logout</a>
					</li>
				</ul>
			</li>
			@else
			<li>
				<a href="{{ url('/login') }}">Login</a>
			</li>
			<li>
				<a href="{{ url('/register') }}">Register</a>
			</li>
			@endif
		</ul>
	</div>
</nav>