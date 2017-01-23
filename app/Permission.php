<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
	const PERMISSIONS = [
		'see_orders', 'modify_orders', 'modify_pizzas', 'modify_employees', 'modify_toppings'
	];

	protected $fillable = [
		'user_id', 'see_orders', 'modify_orders', 'modify_pizzas', 'modify_employees', 'modify_toppings'
	];

	public function hasPermissions()
	{
		$has = array_filter(self::PERMISSIONS, function($permission) {
			return $this->$permission == 1;
		}, ARRAY_FILTER_USE_BOTH);

		return $has;
	}
}