@extends('layouts.default')

@section('title', 'Register')

@section('content')
<div class="row">
	<form action="{{ url('/register') }}" method="POST" class="col-sm-8 col-sm-offset-2">
		{{ csrf_field() }}
		<div class="form-group row{{($errors->has('user_name') ? ' has-error' : '')}}">
			<label for="username" class="col-sm-4">Username</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" name="user_name" id="username" placeholder="Username" required autofocus>
				@if ($errors->has('user_name'))
				<div class="help-block">
					{{$errors->first('user_name')}}
				</div>
				@endif
			</div>
		</div>
		<div class="form-group row{{($errors->has('email') ? ' has-error' : '')}}">
			<label for="email" class="col-sm-4">Email</label>
			<div class="col-sm-8">
				<input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
				@if ($errors->has('email'))
				<div class="help-block">
					{{$errors->first('email')}}
				</div>
				@endif
			</div>
		</div>
		<div class="form-group row{{($errors->has('password') ? ' has-error' : '')}}">
			<label for="password" class="col-sm-4">Password</label>
			<div class="col-sm-8">
				<input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
				@if ($errors->has('password'))
				<div class="help-block">
					{{$errors->first('password')}}
				</div>
				@endif
			</div>
		</div>
		<div class="form-group row{{($errors->has('password_confirm') ? ' has-error' : '')}}">
			<label for="password_confirm" class="col-sm-4">Confirm Password</label>
			<div class="col-sm-8">
				<input type="password" class="form-control" name="password_confirm" id="password_confirm" placeholder="Confirm Password" required>
				@if ($errors->has('password_confirm'))
				<div class="help-block">
					{{$errors->first('password_confirm')}}
				</div>
				@endif
			</div>
		</div>
		<div class="form-group row{{($errors->has('phone_number') ? ' has-error' : '')}}">
			<label for="phone_number" class="col-sm-4">Phone Number</label>
			<div class="col-sm-8">
				<input type="password" class="form-control" name="phone_number" id="phone_number" placeholder="Phone Number" required>
				@if ($errors->has('phone_number'))
				<div class="help-block">
					{{$errors->first('phone_number')}}
				</div>
				@endif
			</div>
		</div>
		<button class="btn btn-primary">Register</button>
	</form>	
</div>
@stop