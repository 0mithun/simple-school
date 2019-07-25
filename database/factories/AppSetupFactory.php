<?php

use Faker\Generator as Faker;

$factory->define(App\AppSetup::class, function (Faker $faker) {
    return [
       'app_title'    => $faker->sentence(),
       'app_description' => $faker->paragraph(2),
       'copyright_title' => 'copyright &copy; domain.com',
       'app_logo'        => asset('assets/logo.png'),
       'app_favicon'     => asset('assets/logo.png')
    ];
});
