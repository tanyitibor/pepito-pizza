@extends('layouts.dashboard')

@section('title', 'New Pizza')

@section('content')
<div class="row">
	<div class="col col-sm-8 col-sm-offset-2">
		<form action="{{ route("dashboard.pizzas.store") }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
			<div class="form-group{{($errors->has('name') ? ' has-error' : '')}}">
				<label for="name" class="col-sm-3">Name</label>
				<div class="col-sm-9">
					<input type="text" id="name" name="name" value="{{old('name')}}">
					@if ($errors->has('name'))
					<div class="help-block">
						{{$errors->first('name')}}
					</div>
					@endif
				</div>
			</div>
			<div class="form-group{{($errors->has('price_24cm') ? ' has-error' : '')}}">
				<label for="price_24cm" class="col-sm-3">Price 24cm</label>
				<div class="col-sm-9">
					<input type="tel" id="price_24cm" name="price_24cm" value="{{old('price_24cm')}}">
					@if ($errors->has('price_24cm'))
					<div class="help-block">
						{{$errors->first('price_24cm')}}
					</div>
					@endif
				</div>
			</div>
			<div class="form-group{{($errors->has('price_32cm') ? ' has-error' : '')}}">
				<label for="price_32cm" class="col-sm-3">Price 32cm</label>
				<div class="col-sm-9">
					<input type="tel" id="price_32cm" name="price_32cm" value="{{old('price_32cm')}}">
					@if ($errors->has('price_32cm'))
					<div class="help-block">
						{{$errors->first('price_32cm')}}
					</div>
					@endif
				</div>
			</div>
			<div class="form-group{{($errors->has('price_40cm') ? ' has-error' : '')}}">
				<label for="price_40cm" class="col-sm-3">Price 40cm</label>
				<div class="col-sm-9">
					<input type="tel" id="price_40cm" name="price_40cm" value="{{old('price_40cm')}}">
					@if ($errors->has('price_40cm'))
					<div class="help-block">
						{{$errors->first('price_40cm')}}
					</div>
					@endif
				</div>
			</div>
			<div class="form-group">
				<label for="toppings" class="col-sm-3">Toppings</label>
				<div class="col-sm-9">
					@foreach ($toppings as $topping)
					<label><input type="checkbox" name="toppings[]" value="{{$topping->id}}"
					{{in_array($topping->id, old('toppings') ?:[])? ' checked' : ''}}>
					{{ $topping->name }}
					</label>
					@endforeach
				</div>
			</div>
			<div class="form-group{{($errors->has('image') ? ' has-error' : '')}}">
				<label for="image" class="col-sm-3">Image</label>
				<div class="col-sm-9">
					<input type="file" name="image" id="image" value="{{old('image')}}">
					@if ($errors->has('image'))
					<div class="help-block">
						{{$errors->first('image')}}
					</div>
					@endif
				</div>
			</div>
			<button type="submit" class="btn btn-primary" name="submit">Submit</button>

			{{ csrf_field() }}
		</form>
	</div>
</div>
@stop