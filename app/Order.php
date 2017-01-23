<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $fillable = [
		'user_id', 'comment', 'status_id', 'address_id', 'address'
	];

	public static $statuses = [
		'Pending', 'Cooking', 'Delivering', 'Done'
	];

	public function items()
	{
		return $this->hasMany('App\OrderItem');
	}

	public function pizzas()
	{
		return $this->belongsToMany('\App\Pizza', 'order_items');
	}

	public function pizzasList()
	{
		$pizzas = $this->pizzas()
			->pluck('name')
			->toArray();
			
		return implode(',', $pizzas);
	}

	public function address()
	{
		return $this->belongsTo('App\Address');
	}

	public function price()
	{
		return $this->items()->sum('price');
	}

	public function priceWithCurrency()
	{
		return $this->price() . ' Ft.';
	}

	public function statusName()
	{
		return self::statusById($this->status_id);
	}

	public static function statusById($id)
	{
		return self::$statuses[$id];
	}

	public static function statusByName($name)
	{
		//case-insensitive search
		return array_search(
			strtolower($name), array_map('strtolower', self::$statuses)
		);
	}
}