@extends('layouts.dashboard')

@section('title', 'Orders')

@section('content')
<div class="row">
	<h2 class="text-center">Orders</h2>
	<div>
		<div>
			<button class="btn btn-default btn-lg" data-toggle="collapse" data-target="#filter">Filter</button>			
		</div>
		<form action="{{ route('dashboard.orders.index') }}" method="GET" id="filter"
		class="collapse {{ !old('status') ?: 'in'}}">
			<div>
				Status:
				@foreach (App\Order::$statuses as $status)
				<label><input name="status[]" type="checkbox" 
				value="{{ $loop->index }}"{{in_array($loop->index, $statuses) ? ' checked' : '' }}>
				{{ $status }}
				</label>
				@endforeach
			</div>
			<div>
				Per page:
				<select name="per_page" id="per_page">
					@foreach([10, 25, 50, 100] as $number)
					<option value="{{$number}}"
					{{ old('per_page') == $number ? ' selected' : '' }}>
						{{$number}}
					</option>
					@endforeach
				</select>
			</div>
			<br>
			<button class="btn btn-primary">Filter</button>
			<a href="{{ route('dashboard.orders.index')}}" class="btn btn-danger">Reset</a>
		</form>
	</div>
	<hr />
	<table class="table" style="border-collapse:collapse;">
		<thead>
			<tr>
				<th>Order ID</th>
				<th>Address</th>
				<th>Status</th>
			</tr>
		</thead>
		@foreach ($orders as $order)
		<tbody class="order">
			<tr class="pointer" data-toggle="collapse" data-target="#order-{{$order->id}}"
			aria-expanded="true" aria-controls="order-{{$order->id}}">
				<td>{{ $order->id }}</td>
				<td>{{ $order->address }}</td>
				<td>{{ $order->statusName() }}</td>
			</tr>
			<tr >
				<td colspan="3" style="padding: 0 !important;">
					<div class="collapse" id="order-{{$order->id}}">
						<table class="table col-sm-12">
							<thead>
								<tr>
									<th>Name</th>
									<th>Size</th>
									<th>Pieces</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($order->items()->get() as $item)
								<tr>
									<td>{{ $item->name() }}</td>
									<td>{{ $item->size }}</td>
									<td>{{ $item->pieces }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						<div class="col-sm-6">
							<h3>Comment</h3>
							<div class="comment">
								{{$order->comment ? $order->comment : "No comments."}}
							</div>
						</div>
						@if (Auth::user()->can('update','App\Order'))
						<div class="col-sm-6">
							<h3>Update Status</h3>
							<form action="{{ route('dashboard.orders.update', ['order' => $order->id]) }}" method="POST">
								{{ method_field('PUT') }}
								<select name="status">
									@foreach (App\Order::$statuses as $status)
									<option value="{{ $loop->index }}"{{ $loop->index == $order->status_id ? 'selected' : '' }}>{{ $status }}</option>
									@endforeach
								</select>
								<button class="btn btn-primary">Change Status</button>
								{{ csrf_field() }}
							</form>	
						</div>
						@endif
					</div>
				</td>
			</tr>
		</tbody>
		@endforeach
	</table>
	@include('partials.paginator', ['page' => $orders])
</div>
@stop