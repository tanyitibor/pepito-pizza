@extends('layouts.dashboard')

@section('title', 'Pizzas')

@section('content')
<div class="row">
	<h2 class="text-center">Pizzas</h2>
	<div>
		<div>
			<button class="btn btn-default btn-lg" data-toggle="collapse" data-target="#filter">Filter</button>			
		</div>
		<form action="{{ route('dashboard.pizzas.index') }}" method="GET" id="filter"
		class="collapse {{ !(old('pizza_topping') || old('pizza_name')) ?: 'in'}}">
			<div>
				Name: <input type="text" name="pizza_name" value="{{old('pizza_name')}}">				
			</div>
			<div>
				Toppings:
				@foreach ($toppings as $topping)
				<label><input type="checkbox" name="pizza_topping[]" value="{{$topping->id}}"
				{{in_array($topping->id, old('pizza_topping')?: []) ? ' checked' : ''}}>
				{{ $topping->name }}
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
			<a href="{{ route('dashboard.pizzas.index')}}" class="btn btn-danger">Reset</a>
		</form>
	</div>
	<hr />
	<h3><a href="{{ route('dashboard.pizzas.create') }}">NEW</a></h3>
	<table class="table">
		<thead>
			<tr>
				<th>Name</th>
				<th>Toppings</th>
				@can('update', 'App\Pizza')
				<th>Edit</th>
				<th>Delete</th>
				@endcan
			</tr>
		</thead>
		<tbody>
			@foreach ($pizzas as $pizza)
			<tr>
				<td>{{ $pizza->name }}</td>
				<td>{{ $pizza->toppingsList() }}</td>
				@can('update', 'App\Pizza')
				<td><a href="{{ route('dashboard.pizzas.edit', ['pizza' => $pizza->id]) }}">Edit</a></td>
				<td>
					<form class="pizza-delete" action="{{route('dashboard.pizzas.destroy', ['pizza' => $pizza->id])}}" method="POST">
						{{ method_field('DELETE') }}
						{{csrf_field()}}
						<button class="btn btn-danger">Delete</button>
					</form>
				</td>
				@endcan
			</tr>
			@endforeach
		</tbody>
	</table>
	@include('partials.paginator', ['page' => $pizzas])
</div>
@stop

@push('scripts')
<script>
	$(function() {
		$('.pizza-delete').submit(function() {
			return window.confirm('Are you sure?');
		});
	});
</script>
@endpush