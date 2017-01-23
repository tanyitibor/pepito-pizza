<?php

$factory->define(App\Topping::class, function(Faker\Generator $faker) {
    return [
        'name'  => str_random(6),
    ];
});