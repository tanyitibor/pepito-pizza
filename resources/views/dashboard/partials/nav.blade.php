<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<span class="navbar-brand">Dashboard</span>
		</div>
		<ul class="nav navbar-nav">
			<li role="presentation">
				<a href="{{ route("dashboard.orders.index") }}">Orders</a>
			</li>
			<li role="presentation">
				<a href="{{ route("dashboard.pizzas.index") }}">Pizzas</a>
			</li>
			<li role="presentation">
				<a href="{{ route("dashboard.users.index") }}">Users</a>
			</li>
			@can('update', App\Topping::class)
			<li role="presentation">
				<a href="{{ route("dashboard.toppings.index") }}">Toppings</a>
			</li>
			@endcan
		</ul>
		<ul class="nav navbar-nav navbar-right">
			@if (Auth::check())
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
					{{Auth::user()->user_name}} <span class="caret"></span>
				</a>
				<ul class="dropdown-menu">
					@if (Auth::user()->isEmployee())
					<li>
						<a href="{{ urL('/') }}">Home</a>
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