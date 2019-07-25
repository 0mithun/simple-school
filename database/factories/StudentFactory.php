<?php

use Faker\Generator as Faker;

$factory->define(App\Student::class, function (Faker $faker) {
    
    $class = App\ClassModel::all()->random();
    $section = App\Section::all()->random();

    return [
        'student_name'               =>  $faker->name(),
        'date_of_birth'              =>  $faker->date(),
        'age'                        =>  $faker->numberBetween(10,16),
        'email'                      =>  $faker->safeEmail(),
        'contact'                    =>  $faker->phoneNumber,
        'address'                    =>  $faker->address,
        'city'                       =>  $faker->city,
        'country'                    =>  $faker->country,
        'date_of_register'           =>  $faker->date(),
        'class_id'                   =>  $class,
        'section_id'                 =>  $section,
    ];
});
