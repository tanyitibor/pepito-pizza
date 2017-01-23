@extends('layouts.default')

@section('title', 'Order ' . $order->id)

@section('content')
	<div class="order-infos">
		<div>
			<h3>
				<div class="pull-left">
					Status:
				</div>
				@can('update', App\Order::class)
			</h3>
			<form action="">
				<select name="status">
					@foreach (App\Order::$statuses as $status)
					<option value="{{ $loop->index }}"{{ $loop->index == $order->status_id ? 'selected' : '' }}>
						{{ $status }}
					</option>
					@endforeach
				</select>
				<button class="btn btn-primary">Change</button>
			</form>
				@else
				{{ $order->statusName() }}
				@endcan
		</div>
		<div>
			<h4>Items:</h4>
			<div>
				@foreach ($order->items()->get() as $item)
				<div>
					Name: {{ $item->name() }} | Pieces: {{ $item->pieces }} | Size: {{ $item->size }}
				</div>
				@endforeach
			</div>
		</div>
		<div>
			<h4>Comment</h4>
			<div>
				{{ $order->comment ? $order->comment : "No comment. "}}
			</div>
		</div>
		<div>
			<h4>Price</h4>
			<div>
				{{ $order->priceWithCurrency() }}
			</div>
		</div>
		<div>
			<h4>Address</h4>
			<div>
				{{ $order->address}}
			</div>
		</div>
	</div>
@stop