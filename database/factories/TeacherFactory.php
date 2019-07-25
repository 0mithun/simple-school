<?php

use Faker\Generator as Faker;

$factory->define(App\Teacher::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email'     =>  $faker->email,
        'date_of_birth' =>  $faker->dateTime,
        'age' =>  $faker->numberBetween(10,30),
        'contact'       => $faker->phoneNumber,
        'address'       => $faker->address,
        'city'       => $faker->city,
        'country'       => $faker->country,
        'job_type'       => $faker->numberBetween(1,5)
    ];
});
