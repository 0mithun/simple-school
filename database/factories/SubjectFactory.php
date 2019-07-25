<?php

use Faker\Generator as Faker;

$factory->define(App\Subject::class, function (Faker $faker) {
    $teacher = App\Teacher::all()->random();
    $class = App\ClassModel::all()->random();
    return [
        'subject_name'      =>      'Subject '.$faker->unique()->name(),
        'marks'             =>      100,
        'teacher_id'        =>      $teacher,
        'class_id'          =>      $class,
    ];
});
