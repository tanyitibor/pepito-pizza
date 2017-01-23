<?php 
namespace App;
use Illuminate\Database\Eloquent\Model;

class PizzaTopping extends Model
{
	protected $fillable = ['pizza_id', 'topping_id'];

	public $timestamps = false;

	public function pizza()
	{
		return $this->belongsTo('App\Pizza');
	}

	public function topping()
	{
		return $this->belongsTo('App\Topping');
	}
}