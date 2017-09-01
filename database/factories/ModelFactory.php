<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'token' => str_random(10)
    ];
});

$factory->define(App\tracker::class, function (Faker\Generator $faker) {
    return [
        't_id' =>  rand(0,1000000),
        'c_id' =>  1
    ];
});


$factory->define(App\Records::class, function (Faker\Generator $faker) {
    return [
        't_id' => rand(0,100000),
        'ip_address' => '127.0.0.1',
        'Browser' => 'Chrome',
        'OS' => 'Mac OS X',
        'Device' => 'Other',
        'Time' => '2017-08-23 11:20:14'
    ];
});

$factory->define(App\clicks::class, function (Faker\Generator $faker) {
    return [
        't_id' => rand(0,100000),
        'ip_address' => '127.0.0.1',
        'Browser' => 'Chrome',
        'OS' => 'Mac OS X',
        'Device' => 'Other',
        'Time' => '2017-08-23 11:20:14'
    ];
});