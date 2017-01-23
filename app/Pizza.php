<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
	protected $fillable = [
		'name', 'price_24cm', 'price_32cm', 'price_40cm', 'image', 'thumb_image'
	];

	public $timestamps = false;

	public function price($size)
	{
		if(!in_array($size, [24,32,40])) return null;

		$var = 'price_' . $size . 'cm';
		
		return $this->$var;
	}

	public function toppings()
	{
		return $this->belongsToMany('App\Topping', 'pizza_toppings');
	}

	public function toppingIds()
	{
		return $this->pizzaToppings()
			->pluck('topping_id')
			->toArray();
	}

	public function toppingNames()
	{
		return $this->toppings()
			->pluck('name')
			->toArray();
	}

	public function toppingsList()
	{
		$names = $this->toppingNames();

		return implode(", ", $names);
	}

	public function pizzaToppings()
	{
		return $this->hasMany('App\PizzaTopping');
	}

	public static function pizzasWithToppings($toppings, $query = false) {
		//if no query given create a new one
		if(!$query) $query = self::query();

		foreach ($toppings as $topping) {
			$query = $query->whereHas('toppings', function($q) use ($topping) {
				$q->where('topping_id', $topping);
			});
		}

		return $query;
	}

	public function priceWithCurrency($size)
	{
		return $this->price($size) . ' Ft.';
	}
}