<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(App\Models\Region::class, function (Faker $faker) {
    return [
        'name' => $faker->state,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});
