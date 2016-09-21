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

use App\Services\Logging\UserActivity\Activity;
use App\Support\Enum\UserStatus;

$factory->define(App\User::class, function (Faker\Generator $faker, array $attrs) {

    return [
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'phone' => $faker->phoneNumber,
        'avatar' => null,
        'address' => $faker->address,
        'status' => UserStatus::ACTIVE,
        'birthday' => $faker->date()
    ];
});

$factory->define(App\Role::class, function (Faker\Generator $faker) {
    return [
        'name' => str_random(5),
        'display_name' => implode(" ", $faker->words(2)),
        'description' => $faker->paragraph,
        'removable' => true,
    ];
});


$factory->define(Activity::class, function (Faker\Generator $faker, array $attrs) {

    $userId = isset($attrs['user_id'])
        ? $attrs['user_id']
        : factory(\App\User::class)->create()->id;

    return [
        'user_id' => $userId,
        'description' => $faker->paragraph,
        'ip_address' => $faker->ipv4,
        'user_agent' => $faker->userAgent
    ];
});

