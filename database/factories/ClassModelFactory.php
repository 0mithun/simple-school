<?php

use Faker\Generator as Faker;

$factory->define(App\ClassModel::class, function (Faker $faker) {
    return [
        //
        'class_name'            =>  $faker->unique()->colorName,
        'class_numaric'         =>  $faker->unique()->numberBetween(5,12)
    ];
});
