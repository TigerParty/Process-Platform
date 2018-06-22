<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(App\Models\Process::class, function (Faker $faker) {
    return [
        'description' => $faker->text(100),
        'created_by' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});
