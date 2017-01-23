@extends('layouts.default')

@section('title', Auth::user()->user_name . '\'s profile')

@section('content')
<div class="row">
	<table class="table">
		<tbody>
			<tr>
				<td>Username</td>
				<td>{{ Auth::user()->user_name }}</td>
			</tr>
			<tr>
				<td>Email</td>
				<td>{{ Auth::user()->email }}</td>
			</tr>
			<tr>
				<td>Phone number</td>
				<td>
					<form action="{{route('profile.index')}}" method="POST">
						{{ csrf_field()}}
						<input type="tel" name="phone_number" value="{{Auth::user()->phone_number}}">
						<button class="btn btn-default">Update</button>
					</form>
			</tr>
		</tbody>
	</table>
	<h2>Addresses</h2>
	<div class="addresses">
		@foreach (Auth::user()->addresses->all() as $address)
		<div class="address-{{$address->id}}">
			<h3 class="address-name">{{ $address->name }}</h3>
			<table class="table" style="display: none;">
				<tbody>
					<tr>
						<td>Zip code</td>
						<td class="address-zip-code">{{ $address->zip_code }}</td>
					</tr>
					<tr>
						<td>State</td>
						<td class="address-state">{{ $address->state }}</td>
					</tr>
					<tr>
						<td>City</td>
						<td class="address-city">{{ $address->city }}</td>
					</tr>
					<tr>
						<td>Address line</td>
						<td class="address-address-line">{{ $address->address_line }}</td>
					</tr>
					<tr>
						<td colspan="2">
						<div class="pull-left">
							<button class="btn btn-primary edit-address" id="edit-address-{{$address->id}}">Edit</button>
						</div>
						<form action="{{route('address.destroy', ['address' => $address->id])}}" method="POST" class="pull-left">
							{{csrf_field()}}
							{{ method_field('DELETE') }}
							<button class="btn btn-danger" name="delete-{{ $address->id }}" onclick="return window.confirm('Are you sure?')">Delete</button>
						</form>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<hr>
		@endforeach
		<button class="btn btn-primary" data-toggle="modal" data-target="#new_address">New Address</button>
	</div>
	<div>
		<h3>Your last orders</h3>
		<div>
			<table class="table">
				<thead>
					<tr>
						<th>Pizzas</th>
						<th>Date</th>
						<th>Address</th>
						<th>Info</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($orders as $order)
					<tr>
						<td>{{$order->pizzasList()}}</td>
						<td>{{$order->created_at->format('Y-m-d')}}</td>
						<td>{{$order->address}}</td>
						<td><a href="{{ route('orders.show', ['order' => $order->id]) }}">More Info</a></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		@include('partials.paginator', ['page' => $orders])
	</div>
</div>

@include('profile.partials.newAddressModal')
@include('profile.partials.editAddressModal')
@stop

@push('scripts')
<script>
$(function() {
	$('.address-name').click(function() {
		$(this).parent().find('table').toggle();
	});

	$('.edit-address').click(function() {
		$('#edit_address').modal('show');
		var id = this.id.replace('edit-address-', '');
		var url = "{{route('address.store')}}/" + id;
		var address = $('.address-' + id);
		var name = address.find('.address-name').text();
		var zipCode = address.find('.address-zip-code').text();
		var state = address.find('.address-state').text();
		var city = address.find('.address-city').text();
		var addressLine = address.find('.address-address-line').text();

		$('#edit_address').find('form').attr('action', url);
		$('#edit_address').find('#edit_name').val(name);
		$('#edit_address').find('#edit_zip_code').val(zipCode);
		$('#edit_address').find('#edit_state').val(state);
		$('#edit_address').find('#edit_city').val(city);
		$('#edit_address').find('#edit_address_line').val(addressLine);
	});
	
	@if(!$errors->isEmpty())
	$('#new_address').modal('show');
	@endif
});
</script>
@endpush