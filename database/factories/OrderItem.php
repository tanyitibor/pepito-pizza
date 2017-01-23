<?php

$factory->define(App\OrderItem::class, function(Faker\Generator $faker) {
    $pizza = App\Pizza::all()->random();
    $pieces = rand(1, 3);

    return [
        'pizza_id'  => $pizza->id,
        'pieces'    => $pieces,
        'size'      => 32,
        'price'     => $pizza->price(32) * $pieces,
    ];
});