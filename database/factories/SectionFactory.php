<?php

use Faker\Generator as Faker;

$factory->define(App\Section::class, function (Faker $faker) {
    $class = App\ClassModel::all()->random();
    $teacher = App\Teacher::all()->random();
    return [
        'section_name'      => 'Section '.$faker->unique()->colorName,
        'class_id'          =>  $class,
        'teacher_id'        =>  $teacher
    ];
});
