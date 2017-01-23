<div class="modal fade{{$errors->isEmpty() ?: ' in' }}" tabindex="-1" role="dialog" id="new_address">
	<form class="address-form form-horizontal" action="{{ route('address.store') }}" method="post">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">New address</h4>
			</div>
			{{ csrf_field() }}
			<div class="modal-body">
				<div class="form-group{{$errors->has('name') ? ' has-error' : ''}}">
					<label for="name" class="col-sm-3 control-label">Name</label>
					<div class="col-sm-9">
						<input type="text" name="name" class="form-control" required value="{{old('name')}}">
						@if($errors->has('name'))
						<div class="help-block">
							{{ $errors->first('name') }}
						</div>
						@endif
					</div>
				</div>
				<div class="form-group{{$errors->has('zip_code') ? ' has-error' : ''}}">
					<label for="zip_code" class="col-sm-3 control-label">Zip Code</label>
					<div class="col-sm-9">
						<input type="tel" name="zip_code" class="form-control" maxlength="4" style="width: 70px;" required value="{{old('zip_code')}}">
						@if($errors->has('zip_code'))
						<div class="help-block">
							{{ $errors->first('zip_code') }}
						</div>
						@endif
					</div>
				</div>
				<div class="form-group row{{$errors->has('state') ? ' has-error' : ''}}">
					<label for="state" class="col-sm-3 control-label">State</label>
					<div class="col-sm-9">
						<input type="text" name="state" class="form-control" required value="{{old('state')}}">
						@if($errors->has('state'))
						<div class="help-block">
							{{ $errors->first('state') }}
						</div>
						@endif
					</div>
				</div>
				<div class="form-group row{{$errors->has('city') ? ' has-error' : ''}}">
					<label for="zip_code" class="col-sm-3 control-label">City</label>
					<div class="col-sm-9">
						<input type="text" name="city" class="form-control" required value="{{old('city')}}">
						@if($errors->has('city'))
						<div class="help-block">
							{{ $errors->first('city') }}
						</div>
						@endif
					</div>
				</div>
				<div class="form-group row{{$errors->has('address_line') ? ' has-error' : ''}}">
					<label for="state" class="col-sm-3 control-label">Address Line</label>
					<div class="col-sm-9">
						<input type="text" name="address_line" class="form-control" required value="{{old('address_line')}}">
						@if($errors->has('address_line'))
						<div class="help-block">
							{{ $errors->first('address_line') }}
						</div>
						@endif
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default" name="submit-address">Submit</button>			
			</div>
		</div>
	</div>
	</form>
</div>