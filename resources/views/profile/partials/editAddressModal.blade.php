<div class="modal fade" tabindex="-1" role="dialog" id="edit_address">
	<form class="address-form form-horizontal" action="" method="post">
	{{ csrf_field() }}
	{{method_field('PUT')}}
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Edit address</h4>
			</div>
			<div class="modal-body">
				<div class="form-group{{$errors->has('name') ? ' has-error' : ''}}">
					<label for="name" class="col-sm-3 control-label">Name</label>
					<div class="col-sm-9">
						<input type="text" name="name" class="form-control" required value="{{old('name')}}" id="edit_name">
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
						<input type="tel" name="zip_code" class="form-control" maxlength="4" style="width: 70px;" required value="{{old('zip_code')}}" id="edit_zip_code">
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
						<input type="text" name="state" class="form-control" required value="{{old('state')}}" id="edit_state">
						@if($errors->has('state'))
						<div class="help-block">
							{{ $errors->first('state') }}
						</div>
						@endif
					</div>
				</div>
				<div class="form-group row{{$errors->has('city') ? ' has-error' : ''}}">
					<label for="city" class="col-sm-3 control-label">City</label>
					<div class="col-sm-9">
						<input type="text" name="city" class="form-control" required value="{{old('city')}}" id="edit_city">
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
						<input type="text" name="address_line" class="form-control" required value="{{old('address_line')}}" id="edit_address_line">
						@if($errors->has('address_line'))
						<div class="help-block">
							{{ $errors->first('address_line') }}
						</div>
						@endif
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default" name="edit-address">Edit</button>			
			</div>
		</div>
	</div>
	</form>
</div>