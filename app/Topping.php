<?php 
namespace App;
use Illuminate\Database\Eloquent\Model;

class Topping extends Model
{
	protected $fillable = ['name'];

	public $timestamps = false;

	public function PizzaToppings()
	{
		return $this->hasMany('App\PizzaTopping');
	}
}