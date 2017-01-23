@extends('layouts.default')

@section('title', "Pizzas")

@section('content')
	<h2 class="text-center">Pizzas</h2>
	<div>
		<div>
			<button class="btn btn-default btn-lg" data-toggle="collapse" data-target="#filter">Filter</button>
		</div>
		<form action="{{ route('pizzas.index') }}" method="GET" id="filter"
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
			<a href="{{ route('pizzas.index')}}" class="btn btn-danger">Reset</a>
		</form>
	</div>
	<hr />
	<div class="pizza-list">
		@foreach ($pizzas as $pizza)
		@include('pizzas.partials.pizzaItem', ['pizza' => $pizza])
		@endforeach
	</div>
	@include('partials.paginator', ['page' => $pizzas])
	@include('pizzas.partials.imageModal')
@stop

@push('scripts')
<script>
$(function() {
	$('.pizza-prices > div').hover(function() {
		$(this).find('.add-pizza-btn').parent().toggle();
	});
	
	$('.pizza-thumb').click(function() {
		$('#image_modal').modal('show');
		$('#image_modal')
			.find('.modal-title')
			.html(this.alt);
		$('#image_modal')
			.find('.pizza-image')
			.attr('src', this.src.replace('thumb/', ''));
	});
});
</script>
@endpush