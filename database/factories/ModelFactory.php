<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Pais::class, function (Faker $faker) {
    static $password;
    return [
        'nombre_pais' => $faker->name,
        'estado' => '1',
        'icono' => 'https://randomuser.me/api/portraits/' . $faker->randomElement(['men', 'women']) . 'men/' . rand(1,99) . '.jpg',
    ];
});