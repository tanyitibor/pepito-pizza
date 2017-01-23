<?php

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'user_name'         => $faker->unique()->userName,
        'email'             => $faker->unique()->safeEmail,
        'password'          => $password ?: $password = bcrypt('secret'),
        'phone_number'      => '06132456789',
        'remember_token'    => str_random(10),
    ];
});