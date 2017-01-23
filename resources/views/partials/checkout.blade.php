<div class="modal fade" id="checkout" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Checkout</h4>
			</div>
			<div class="modal-body order-create">
				@if(!Auth::check())
					Please login or register first!
				@else
				<table class="table">
					<thead>
						<tr>
							<th>Name</th>
							<th>Size</th>
							<th>Pieces</th>
							<th>Price</th>
						</tr>
					</thead>
					<tbody class="order-body">
					</tbody>
				</table>
				<div class="row">
					<div class="col-sm-4">
						<label>Full price</label>
					</div>
					<div class="col-sm-8">
						<span class="total-price"></span>
					</div>
				</div>
				<div>
					<div><label for="order-comment">Comment</label></div>
					<textarea name="order-comment" id="order-comment" rows="3"></textarea>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label for="address">Select Address</label>
						@if(Auth::user()->addresses()->exists())
						<select name="address" id="address">
							@foreach (Auth::user()->addresses()->get() as $address)
							<option value="{{ $address->id }}"> {{ $address->name }} </option>
							@endforeach
						</select>
						@endif
					</div>
					<div class="col-sm-8">
						@foreach (Auth::user()->addresses()->get() as $address)
						<span class="formated-address address-{{ $address->id }}"{!! $loop->first ?: 'style="display: none;"' !!}>
						{{ $address->formated() }}
						</span>
						@endforeach
						@if(!Auth::user()->addresses()->exists())
							Please create a new address first at your <a href="{{route('profile.index')}}">profile</a>!
						@endif
					</div>					
				</div>
				@endif
			</div>
			<div class="modal-footer">
				@if(Auth::check())
					<button type="button" class="btn btn-primary" id="send-order">Send Order</button>
				@endif
			</div>
		</div>
	</div>
</div>

@push('scripts')
<script>

</script>
@endpush