<?php

$factory->define(App\Pizza::class, function (Faker\Generator $faker) {
    return [
        'name'			=> $faker->unique()->word(),
        'price_24cm'	=> rand(800, 1000),
        'price_32cm'	=> rand(1200, 1400),
        'price_40cm'	=> rand(1500, 1800),
        'image'         => 'img/pizza.jpg',
        'thumb_image'   => 'img/thumb/pizza.jpg',
    ];
});