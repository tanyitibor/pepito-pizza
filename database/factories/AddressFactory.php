<?php

$factory->define(App\Address::class, function (Faker\Generator $faker) {
	return [
		'name'			=> str_random(5),
		'state'			=> $faker->state(),
		'zip_code'		=> rand(1000, 9999),
		'city'			=> $faker->city(),
		'address_line'	=> $faker->streetAddress(),
	];
});