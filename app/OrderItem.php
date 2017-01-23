<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
	protected $fillable = [
		'order_id', 'pizza_id', 'pieces', 'size', 'price'
	];

	public $timestamps = false;

	public function name()
	{
		return $this->pizza()->exists() ? $this->pizza()->first()->name : 'Cant find.';
	}

	public function pizza()
	{
		return $this->belongsTo('App\Pizza', 'pizza_id');
	}
}