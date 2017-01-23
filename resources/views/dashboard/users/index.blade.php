@extends('layouts.dashboard')

@section('title', 'Users')

@section('content')
<div class="row">
	<h2 class="text-center">Users</h2>
	<div>	
		<div>
			<button class="btn btn-default btn-lg" data-toggle="collapse" data-target="#filter">Filter</button>
			<div class="float-right">
			</div>
		</div>
		<form action="{{ route('dashboard.users.index') }}" method="GET" id="filter"
		 class="collapse {{ !(old('employee') || old('user_name') || old('permissions')) ?: 'in'}}">
			<div>
				Employee only: <input type="checkbox" name="employee"{{ old('employee') ? ' checked' : '' }}>				
			</div>
			<div>
				Username: <input type="text" name="user_name" value="{{ old('user_name') }}">				
			</div>
			<div>
				With permissons:
				@foreach ($permissions as $permission)
				<label><input type="checkbox" name="permissions[]" value="{{$permission}}"
				{{in_array($permission, old('permissions') ?: []) ? ' checked' : ''}}>
				{{$permission}}
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
			<div>
				<button class="btn btn-primary">Filter</button>
				<a href="{{ route('dashboard.users.index')}}" class="btn btn-danger">Reset</a>
			</div>
		</form>
	</div>
	<hr />
	<table class="table">
		<thead>
			<tr>
				<th>Username</th>
				<th>Email address</th>
				<th>Permissions</th>
				<th>Employee</th>
			</tr>
		</thead>
		@foreach ($users as $user)
		<tbody class="users">
			<tr class="pointer" data-toggle="collapse" data-target="#user-{{$user->id}}"
			 aria-expanded="false" aria-controls="user-{{$user->id}}">
				<td>{{$user->user_name}}</td>
				<td>{{$user->email}}</td>
				<td>
					{{implode('|', $user->permissions())}}
				</td>
				<td>{{ $user->isEmployee() ? 'Yes' : 'No' }}</td>
			</tr>
			@can('update', App\User::class)
			<tr>
				<td colspan="4" style="padding: 0 !important;">
					<div class="collapse" id="user-{{$user->id}}">
						<h4>Change Permissions:</h4>
						<div class="permissions">
							<form action="{{route('dashboard.users.update', ['user' => $user->id])}}" method="POST">
								{{csrf_field()}}
								{{ method_field('PUT') }}
								@foreach ($permissions as $permission)
								<label>
								<input type="checkbox" name="permissions[]" value="{{$permission}}"
								{{ $user->hasPermission($permission) ? ' checked' : ''}}>							
								{{$permission}}
								</label>
								@endforeach

								<button class="btn btn-primary" type="submit" name="update-user-{{$user->id}}">Update</button>
							</form>
						</div>		
					</div>
				</td>
			</tr>
			@endcan
		</tbody>
		@endforeach
	</table>
	@include('partials.paginator', ['page' => $users])
</div>
@stop

@push('scripts')
<script>
$(function() {
	$("#filter").submit(function(event) {
		if(this.user_name.value.trim() == '') {
			this.user_name.setAttribute('disabled', '');
		}

		return true;
	});
});	
</script>
@endpush