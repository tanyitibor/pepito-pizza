@extends('layouts.dashboard')

@section('title', 'Toppings')

@section('content')
<div class="row">
	<h2 class="text-center">Toppings</h2>

	<table class="table">
		<thead>
			<tr>
				<th>Name</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody class="toppings">
			@foreach($toppings as $topping)
			<tr class="topping-{{$topping->id}}">
				<td>
					<div class="topping-name">
						{{$topping->name}}
					</div>
					<div class="topping-name-edit" style="display: none;">
						<form action="{{route('dashboard.toppings.update', ['topping' => $topping->id])}}" method="POST" class="pull-left">
							{{method_field('PUT')}}
							{{csrf_field()}}
							<input type="text" name="name" value="{{$topping->name}}">
							<button class="btn btn-default">Submit</button>
						</form>
					</div>
				</td>
				<td>
					<button class="btn btn-primary edit-topping-btn" id="edit-topping-{{$topping->id}}">Edit</button>
				</td>
				<td>
					<form class="topping-delete" action="{{route('dashboard.toppings.destroy', ['topping' => $topping->id])}}" method="POST">
						{{method_field('DELETE')}}
						{{csrf_field()}}
						<button class="btn btn-danger delete-topping-btn" name="delete-topping-{{$topping->id}}">Delete</button>
					</form>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	@include('partials.paginator', ['page' => $toppings])
	<div class="new-topping">
		<form action="{{route('dashboard.toppings.store')}}" method="POST">
			{{csrf_field()}}
			<label for="topping-name">Add Topping</label>
			<input type="text" name="name">
			<button class="btn btn-primary">Add</button>
		</form>
	</div>
</div>
@stop

@push('scripts')
<script>
	$(function() {
		$('.edit-topping-btn').click(function() {
			var id = this.id.replace('edit-topping-', '');
			$('.topping-' + id).find('.topping-name').toggle();
			$('.topping-' + id).find('.topping-name-edit').toggle();
		});

		$('.topping-delete').submit(function() {
			return window.confirm('Are you sure?');
		});
	});
</script>
@endpush