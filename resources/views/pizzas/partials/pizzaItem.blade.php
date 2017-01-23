<div class="pizza-item-{{$pizza->id}} row">
	<div class="pull-left col-md-3">
		<img src="{{ asset($pizza->thumb_image) }}" alt="{{$pizza->name}}" class="img-responsive pizza-thumb pointer">
	</div>
	<div class="col-md-6">
		<div class="pizza-name">
			<b>{{$pizza->name}}</b>
		</div>
		<div class="pull-left">
			Toppings: {{ $pizza->toppingsList() }}
		</div>	
	</div>
	<div class="col-md-3 pizza-prices">
		<div class="pizza-price-24" onclick="shoppingCart.addItem({{ $pizza->id }}, 24)">
			24cm: {{ $pizza->priceWithCurrency(24) }}
			<span style="display:none;">
				<span class="add-pizza-btn">+</span>
			</span>
		</div>
		<div class="pizza-price-32" onclick="shoppingCart.addItem({{ $pizza->id }}, 32)">
			32cm: {{ $pizza->priceWithCurrency(32) }}
			<span style="display:none;">
				<span class="add-pizza-btn">+</span>
			</span>
		</div>
		<div class="pizza-price-40" onclick="shoppingCart.addItem({{ $pizza->id }}, 40)">
			40cm: {{ $pizza->priceWithCurrency(40) }}
			<span style="display:none;">
				<span class="add-pizza-btn">+</span>
			</span>
		</div>
	</div>
</div>