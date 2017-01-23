@extends('layouts.default')

@section('title', 'Login')

@section('content')
<div class="row">
	<form action="{{ url('/login') }}" method="POST" class="col-sm-8 col-sm-offset-2">
		{{ csrf_field() }}
		<div class="form-group row{{($errors->has('login') ? ' has-error' : '')}}">
			<label for="username" class="col-sm-4">Username or Email</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" name="login" id="username" placeholder="Username or Email" value="{{ old('login') }}" required autofocus>
				@if ($errors->has('login'))
				<div class="help-block">
					{{ $errors->first('login')}}
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
		<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember <br />
		<button class="btn btn-primary">Login</button>
	</form>	
</div>
@stop