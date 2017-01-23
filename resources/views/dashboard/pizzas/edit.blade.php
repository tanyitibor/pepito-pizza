@extends('layouts.dashboard')

@section('title', 'Edit pizza ' . $pizza->name)

@section('content')
<div class="row">
	<div class="col-sm-8 col-sm-offset-2">
		<form action="{{ route("dashboard.pizzas.update", ['pizza' => $pizza->id]) }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
			{{ method_field('PUT') }}
			<div class="form-group">
				<label for="name" class="col-sm-6">Name</label>
				<div class="col-sm-6">
					<input type="text" id="name" name="name" value="{{ $pizza->name }}">
				</div>
			</div>
			<div class="form-group">
				<label for="price_24cm" class="col-sm-6">Price 24cm</label>
				<div class="col-sm-6">
					<input type="tel" id="price_24cm" name="price_24cm" value="{{ $pizza->price_24cm }}">
				</div>
			</div>
			<div class="form-group">
				<label for="price_32cm" class="col-sm-6">Price 32cm</label>
				<div class="col-sm-6">
					<input type="tel" id="price_32cm" name="price_32cm" value="{{ $pizza->price_32cm }}">
				</div>
			</div>
			<div class="form-group">
				<label for="price_40cm" class="col-sm-6">Price 40cm</label>
				<div class="col-sm-6">
					<input type="tel" id="price_40cm" name="price_40cm" value="{{ $pizza->price_40cm }}">
				</div>
			</div>
			<div class="form-group">
				<label for="toppings" class="col-sm-6">Toppings</label>
				<div class="col-sm-6">
					@foreach ($toppings as $topping)
					<label><input type="checkbox" name="toppings[]" value="{{$topping->id}}"
					{{in_array($topping->id, $pizza->toppingIds()) ? ' checked' : ''}}>
					{{ $topping->name }}
					</label>
					@endforeach
				</div>
			</div>
			<div class="form-group">
				<label for="image" class="col-sm-6">Image</label>
				<div class="col-sm-6">
					<input type="file" name="image" id="image">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-6">
					<h4>Old Image</h4>
					<img class="img-responsive" src="{{asset($pizza->thumb_image)}}" alt="">
				</div>
				<div class="col-sm-6">
					<h4>New Image</h4>
					<img class="img-responsive" id="new-image" src="" alt="New image">
				</div>
			</div>	
			<div class="form-group">
				<button type="submit" class="btn btn-primary" name="submit">Update</button>
			</div>
	</div>
	<div class="col-sm-12">
	</div>

	{{ csrf_field() }}
	</form>
</div>
@stop

@push('scripts')
<script>
$('#image').change(function(event) {
	var fileReader = new FileReader();

	fileReader.onload = function(event) {
		$('#new-image').attr('src', event.target.result);
	};

	fileReader.readAsDataURL(this.files[0]);
});
</script>
@endpush