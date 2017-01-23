<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('title', 'Home') - PepitoPizza</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="{{ asset('css/main.css') }}">
	<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.1.3/js.cookie.min.js" integrity="sha256-S20kSlaai+/AuQHj3KjoLxmxiOLT5298YvzpaTXtYxE=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script data-main="{{ asset('js/ShoppingCart.js') }}" src="https://cdnjs.cloudflare.com/ajax/libs/require.js/2.3.2/require.min.js"></script>
	@stack('scripts')
	<script>
		//Scripts for Checkout
		$.ajaxSetup({
			headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
			url: "{{ route('orders.store') }}"
		});
		$(function() {
			$('#address').change(function() {
				$('.formated-address').hide();
				$('.address-' + this.value).show();
			});
		});
	</script>
</head>
<body>
<div class="container">
	<div class="header">
		@include('partials.nav')
	</div>
	<div class="row">
		<div class="content col-sm-8">
			@yield('content')
		</div>	
		<div class="col-sm-4">
			@include('partials.sideBar')
		</div>
	</div>	
	@include('partials.footer')
</div>
@include('partials.checkout')
</body>
</html>