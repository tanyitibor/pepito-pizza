<?php

$factory->define(App\Order::class, function(Faker\Generator $faker) {
	return [
		'comment'		=> str_random(30),
		'status_id'		=> 0,
		'address_id'	=> 1,
	];
});