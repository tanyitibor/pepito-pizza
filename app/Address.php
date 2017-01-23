<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
	protected $fillable = [
		'name', 'user_id', 'state', 'zip_code', 'city', 'address_line'
	];

	public $timestamps = false;

	public function formated()
	{
		return "$this->zip_code $this->city, $this->address_line";
	}
}